<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification | ASENXO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/css/verify-style.css">
</head>

<body>
    <main class="verify-container">
        <div class="verify-card">

            <a href="index.php" class="logo-link">
                <img src="src/img/logo-name.png" alt="ASENXO Logo" class="logo-img">
            </a>

            <h1>OTP Verification</h1>
            <p class="info-text">
                Enter the 6-digit verification code sent to your email.
            </p>

            <!-- OTP Input Section -->
            <div class="verify-input-section">
                <div class="otp-inputs" id="otp-inputs"></div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="register-mock.php" class="btn btn-cancel">Cancel</a>
                <button id="verify-btn" class="btn btn-verify">Verify</button>
            </div>

        </div>
    </main>

    <script>
        // --- Create 6 OTP input boxes ---
        const otpContainer = document.getElementById('otp-inputs');

        for (let i = 0; i < 6; i++) {
            const input = document.createElement('input');
            input.type = 'text';
            input.maxLength = 1;
            input.classList.add('otp-box');
            input.setAttribute('inputmode', 'numeric');
            input.setAttribute('pattern', '[0-9]*');

            // Allow only digits
            input.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                if (e.target.value.length === 1) {
                    const next = e.target.nextElementSibling;
                    if (next) next.focus();
                }
            });

            // Backspace to previous box
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value) {
                    const prev = e.target.previousElementSibling;
                    if (prev) prev.focus();
                }
            });

            otpContainer.appendChild(input);
        }

        // --- Verify Button Logic ---
        document.getElementById('verify-btn').addEventListener('click', () => {
            const inputs = document.querySelectorAll('.otp-box');
            let enteredOTP = '';

            inputs.forEach(input => {
                enteredOTP += input.value;
            });

            if (enteredOTP.length !== 6) {
                alert('Please enter the complete 6-digit OTP.');
                return;
            }
n
            const correctOTP = "123456"; 

            if (enteredOTP === correctOTP) {
                window.location.href = "verified.php";
            } else {
                alert("Invalid OTP. Please try again.");
                inputs.forEach(input => input.value = '');
                inputs[0].focus();
            }
        });

        // --- Allow Paste of 6-digit OTP ---
        otpContainer.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasteData = (e.clipboardData || window.clipboardData).getData('text');

            if (/^\d{6}$/.test(pasteData)) {
                const inputs = document.querySelectorAll('.otp-box');
                for (let i = 0; i < 6; i++) {
                    inputs[i].value = pasteData[i];
                }
                inputs[5].focus();
            }
        });
    </script>
</body>
</html>