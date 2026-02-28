<?php
/*
|--------------------------------------------------------------------------
| REGISTER PAGE BACKEND LOGIC (CURRENTLY DISABLED)
|--------------------------------------------------------------------------
| This block handles:
| 1. Session initialization
| 2. OTP verification step detection
| 3. OTP validation
| 4. User insertion into database
| 5. Error handling
|
| It is currently commented out for testing UI purposes.
|--------------------------------------------------------------------------
*/

// Start session
// session_start();

// Include database connection
// require_once 'config.php';

// Default step: 1 = Registration Form, 2 = OTP Verification
// $step = 1;
// $error = '';
// $email = '';

// If user already has OTP session data, move to step 2
// if (isset($_SESSION['reg_email']) && isset($_SESSION['reg_otp'])) {
//     $step = 2;
//     $email = $_SESSION['reg_email'];
// }

// Handle OTP verification form submission
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_otp'])) {

//     $entered_otp = trim($_POST['otp']);

//     // Validate OTP and check expiration
//     if (isset($_SESSION['reg_otp']) &&
//         $_SESSION['reg_otp'] == $entered_otp &&
//         time() < $_SESSION['reg_otp_expiry']) {

//         // Insert verified user into database
//         $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
//         $stmt->execute([
//             $_SESSION['reg_name'],
//             $_SESSION['reg_email'],
//             $_SESSION['reg_password'] // Password already hashed
//         ]);

//         // Clear registration session data
//         unset(
//             $_SESSION['reg_name'],
//             $_SESSION['reg_email'],
//             $_SESSION['reg_password'],
//             $_SESSION['reg_otp'],
//             $_SESSION['reg_otp_expiry']
//         );

//         // Redirect to login page after successful registration
//         header('Location: login.php?registered=1');
//         exit;

//     } else {
//         $error = 'Invalid or expired OTP.';
//     }
// }

// Check for error messages passed from send_otp.php
// if (isset($_SESSION['reg_error'])) {
//     $error = $_SESSION['reg_error'];
//     unset($_SESSION['reg_error']);
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | ASENXO</title>

    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <!-- Correct CSS path -->
    <link rel="stylesheet" href="src/css/register-style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<main class="register-page">
    <div class="register-card">
        <!-- LEFT COLUMN -->
        <div class="form-col">
            <a href="index.php"><img src="src/img/logo-name.png" class="logo-img" alt="ASENXO Logo"></a>

            <?php if ($step === 1): ?>
                <div class="trial-subhead">Start leveraging SETUP benefits for your business today</div>
                <button class="google-btn" type="button"><i class="fab fa-google"></i> Login with Google</button>
                <div class="divider"><span class="divider-line"></span><span>or</span><span class="divider-line"></span></div>

                <?php if ($error): ?><div class="error-msg"><?= htmlspecialchars($error) ?></div><?php endif; ?>

                <form action="send_otp.php" method="post">
                    <div class="input-group">
                        <label>Name*</label>
                        <input type="text" name="name" placeholder="Enter your name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Email*</label>
                        <input type="email" name="email" placeholder="Enter your email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Password*</label>
                        <input type="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <div class="agree-row">
                        <input type="checkbox" name="terms" id="termsCheck" required>
                        <label for="termsCheck">I agree to all <span class="terms-link" id="termsLink">Terms and Conditions</span>.</label>
                    </div>

                    <button type="submit" name="signup" class="signup-btn">Sign Up</button>
                </form>

                <div class="login-link">Already have an account? <a href="login.php">Log in</a></div>

            <?php elseif ($step === 2): ?>
                <h2>Verify Your Email</h2>
                <div class="trial-subhead">Enter the 6-digit code sent to <?= htmlspecialchars($email) ?></div>

                <?php if ($error): ?><div class="error-msg"><?= htmlspecialchars($error) ?></div><?php endif; ?>

                <form method="post">
                    <div class="input-group">
                        <label>OTP*</label>
                        <input type="text" name="otp" placeholder="123456" maxlength="6" pattern="\d{6}" required>
                    </div>
                    <button type="submit" name="verify_otp" class="signup-btn">Verify & Complete</button>
                </form>

                <div class="login-link"><a href="register.php">← Back to registration</a></div>
            <?php endif; ?>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="info-col">
            <img src="src/img/setup-illustration.png" alt="DOST SETUP" class="info-img">
            <h3>Upgrade your Business.</h3>
            <p>DOST SETUP assists micro, small, and medium enterprises (MSMEs) with business development, technology adoption, and market expansion.</p>
            <div class="feature-list">
                <div class="feature-item">✓ Guidance for Startup & Existing MSMEs</div>
                <div class="feature-item">✓ Support with Technology & Equipment</div>
            </div>
        </div>
    </div>
</main>

<!-- Terms Modal -->
<div id="termsModal" class="modal">
    <div class="modal-content">
        <h4>Terms and Conditions</h4>
        <p><strong>1. Acceptance of Terms</strong><br>By registering for ASENXO, you agree to comply with these terms.</p>
        <p><strong>2. Privacy Policy</strong><br>Your data will be handled according to our Privacy Policy.</p>
        <p><strong>3. Fees</strong><br>Some services may incur fees as described on our website.</p>
        <p><em>This is a placeholder for the actual legal terms.</em></p>
        <button class="close-modal" id="closeModal">Close</button>
    </div>
</div>

<script>
    const modal = document.getElementById('termsModal');
    const termsLink = document.getElementById('termsLink');
    const closeBtn = document.getElementById('closeModal');
    termsLink.addEventListener('click', (e) => { e.preventDefault(); modal.style.display = 'flex'; });
    closeBtn.addEventListener('click', () => { modal.style.display = 'none'; });
    window.addEventListener('click', (e) => { if (e.target === modal) modal.style.display = 'none'; });
</script>
</body>
</html>p