<?php
// No whitespace before <?php
// Turn off display errors for production – log them instead
error_reporting(0);
ini_set('display_errors', 0);

// Load Composer dependencies
require __DIR__ . '/vendor/autoload.php';

// Ensure we always output JSON
header('Content-Type: application/json');

// ------------------------------------------------------------
// 1. Read and validate input
// ------------------------------------------------------------
$data = json_decode(file_get_contents('php://input'), true);
$email        = trim($data['email'] ?? '');
$otp          = trim($data['otp'] ?? '');
$firstName    = trim($data['first_name'] ?? '');
$lastName     = trim($data['last_name'] ?? '');
$referralCode = trim($data['referral_code'] ?? '');

if (empty($email) || empty($otp) || empty($firstName) || empty($lastName)) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

// ------------------------------------------------------------
// 2. Environment configuration (use environment variables)
// ------------------------------------------------------------
$db_host = getenv('DB_HOST') ?: 'db.yourproject.supabase.co';
$db_name = getenv('DB_NAME') ?: 'postgres';
$db_user = getenv('DB_USER') ?: 'postgres';
$db_pass = getenv('DB_PASS') ?: 'your-db-password';

$supabaseUrl   = getenv('SUPABASE_URL') ?: 'https://hmxrblblcpbikkxcwwni.supabase.co';
$serviceRoleKey = getenv('SUPABASE_SERVICE_ROLE_KEY') ?: 'your-supabase-service-role-key';

// ------------------------------------------------------------
// 3. Connect to PostgreSQL (Supabase)
// ------------------------------------------------------------
try {
    $pdo = new PDO(
        "pgsql:host=$db_host;dbname=$db_name",
        $db_user,
        $db_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Internal server error']);
    exit;
}

// ------------------------------------------------------------
// 4. Verify OTP
// ------------------------------------------------------------
try {
    $stmt = $pdo->prepare("SELECT otp FROM email_verifications WHERE email = :email AND expires_at > NOW()");
    $stmt->execute(['email' => $email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row || $row['otp'] !== $otp) {
        echo json_encode(['success' => false, 'error' => 'Invalid or expired OTP']);
        exit;
    }
} catch (PDOException $e) {
    error_log('OTP verification query failed: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Database error']);
    exit;
}

// ------------------------------------------------------------
// 5. Retrieve Supabase Auth user ID via Admin API
// ------------------------------------------------------------
$userId = null;
$ch = curl_init();

// URL-encode email to avoid special characters breaking the URL
$filter = urlencode($email);
curl_setopt_array($ch, [
    CURLOPT_URL => "$supabaseUrl/auth/v1/admin/users?filter=$filter",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'apikey: ' . $serviceRoleKey,
        'Authorization: Bearer ' . $serviceRoleKey
    ],
    CURLOPT_TIMEOUT => 10
]);

$response = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($curlError) {
    error_log('cURL error while fetching user: ' . $curlError);
    echo json_encode(['success' => false, 'error' => 'Failed to communicate with authentication service']);
    exit;
}

if ($httpCode !== 200) {
    error_log("Supabase Auth API returned HTTP $httpCode: $response");
    echo json_encode(['success' => false, 'error' => 'Unable to verify user']);
    exit;
}

$users = json_decode($response, true);
if (json_last_error() !== JSON_ERROR_NONE || empty($users)) {
    error_log('Invalid JSON response from Supabase Auth: ' . $response);
    echo json_encode(['success' => false, 'error' => 'Invalid response from authentication service']);
    exit;
}

$userId = $users[0]['id'] ?? null;
if (!$userId) {
    echo json_encode(['success' => false, 'error' => 'User not found in authentication system']);
    exit;
}

// ------------------------------------------------------------
// 6. (Optional) Confirm email in Supabase Auth
// ------------------------------------------------------------
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => "$supabaseUrl/auth/v1/admin/users/$userId",
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => json_encode(['email_confirm' => true]),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'apikey: ' . $serviceRoleKey,
        'Authorization: Bearer ' . $serviceRoleKey,
        'Content-Type: application/json'
    ],
    CURLOPT_TIMEOUT => 10
]);
curl_exec($ch);
// We ignore the result because this is optional
curl_close($ch);

// ------------------------------------------------------------
// 7. Insert/update profile in public.profiles (transaction)
// ------------------------------------------------------------
try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO public.profiles (id, first_name, last_name, referral_code, email_verified)
        VALUES (:id, :first_name, :last_name, :referral_code, TRUE)
        ON CONFLICT (id) DO UPDATE
        SET first_name = EXCLUDED.first_name,
            last_name  = EXCLUDED.last_name,
            referral_code = EXCLUDED.referral_code,
            email_verified = TRUE
    ");
    $stmt->execute([
        'id'            => $userId,
        'first_name'    => $firstName,
        'last_name'     => $lastName,
        'referral_code' => $referralCode ?: null
    ]);

    // Delete used OTP
    $stmt = $pdo->prepare("DELETE FROM email_verifications WHERE email = :email");
    $stmt->execute(['email' => $email]);

    $pdo->commit();

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    $pdo->rollBack();
    error_log('Profile insert failed: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Database error while saving profile']);
    exit;
}