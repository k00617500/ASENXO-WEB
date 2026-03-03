<?php
// 1. Load PHPMailer - REQUIRED
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');
$otp   = trim($data['otp'] ?? '');

if (empty($email) || empty($otp)) {
    echo json_encode(['success' => false, 'error' => 'Missing email or OTP']);
    exit;
}

// 2. Database Connection - UPDATE THESE VALUES
$db_host = 'db.hmxrblblcpbikxkcwwni.supabase.co'; // Get this from Supabase Settings > Database
$db_name = 'postgres';
$db_user = 'postgres';
$db_pass = 'YOUR_ACTUAL_DATABASE_PASSWORD'; // The password you set when creating the project

try {
    $pdo = new PDO("pgsql:host=$db_host;dbname=$db_name", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $stmt = $pdo->prepare("
        INSERT INTO email_verifications (email, otp, expires_at)
        VALUES (:email, :otp, NOW() + INTERVAL '10 minutes')
        ON CONFLICT (email) DO UPDATE
        SET otp = EXCLUDED.otp, expires_at = EXCLUDED.expires_at
    ");
    $stmt->execute(['email' => $email, 'otp' => $otp]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// 3. Send Email
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'dost.asenxo@gmail.com';
    $mail->Password   = 'qkoczbdhdfcmqnoi'; // Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('dost.asenxo@gmail.com', 'ASENXO');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Your ASENXO Verification Code';
    $mail->Body    = "<h3>Verification Code</h3><p>Your OTP code is: <b>$otp</b></p>";

    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
}