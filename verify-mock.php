<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP | ASENXO (Mock)</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/css/register-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="src\css\verify-style.css">
</head>
<body>
<main class="register-page">
    <div class="register-card">
        <!-- LEFT COLUMN (form) -->
        <div class="form-col">
            <a href="index.php"><img src="src/img/logo-name.png" class="logo-img" alt="ASENXO Logo"></a>

            <h2>Verify Your Email</h2>
            <div class="trial-subhead">
                Enter the 6‑digit code sent to<br>
                <strong>user@example.com</strong>   
            </div>

            <!-- Mock error message (hidden by default) -->
            <div class="error-msg" style="display: none;">Invalid or expired OTP (mock).</div>

            <!-- OTP form – submits to verified.php -->
            <form action="verified.php" method="post">
                <div class="input-group">
                    <label>OTP*</label>
                    <input type="text" name="otp" placeholder="123456" maxlength="6" pattern="\d{6}" required>
                </div>
                <button type="submit" name="verify_otp" class="signup-btn">Verify & Complete</button>
            </form>

            <!-- Link back to registration -->
            <div class="login-link"><a href="register-mock.php">← Back to registration</a></div>
        </div>

        <!-- RIGHT COLUMN (same as before) -->
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

</body>
</html>