<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | ASENXO</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="src/css/register-style.css">

    <style>
    
        @keyframes cardIntro {
            0% {
                opacity: 0;
                transform: translateY(30px) scale(0.98);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .register-card {
            animation: cardIntro 0.7s cubic-bezier(0.2, 0.9, 0.3, 1) forwards;
            transform-origin: center;
            will-change: transform, opacity;
        }

        body {
            animation: bodyFade 0.9s ease-out;
        }
        @keyframes bodyFade {
            0% { background-color: #000; }
            100% { background-color: #0a0a0a; }
        }
    </style>
    
</head>
<body>
    <main class="register-page">
        <div class="register-card" id="registerCard">
            <div class="form-col">
                <img src="src/img/logo-name.png" class="form-logo" alt="ASENXO Logo">
                
                <button class="google-btn" type="button">
                    <i class="fab fa-google"></i> Login with Google
                </button>

                <div class="divider">
                    <span class="divider-line"></span>
                    <span>or</span>
                    <span class="divider-line"></span>
                </div>

                <form action="verify-mock.php" method="POST">
                    <div class="row">
                        <div class="input-group">
                            <label>First Name*</label>
                            <input type="text" placeholder="Juan" required>
                        </div>
                        <div class="input-group">
                            <label>Last Name*</label>
                            <input type="text" placeholder="de la Cruz" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Email*</label>
                        <input type="email" placeholder="juan.delacruz@gmail.com" required>
                    </div>

                    <div class="input-group password-group">
                        <label>Password*</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" id="togglePassword" tabindex="-1">
                                <i class="far fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <ul class="password-checklist" id="passwordChecklist" style="display: none;">
                            <li id="checkUpper">Uppercase letter</li>
                            <li id="checkLower">Lowercase letter</li>
                            <li id="checkNumber">Number</li>
                            <li id="checkSpecial">Special character (e.g. !?<>@#$%)</li>
                            <li id="checkLength">8 characters or more</li>
                        </ul>
                    </div>

                    <div class="input-group">
                        <label>Referral Code (Optional)</label>
                        <input type="text">
                    </div>

                    <div class="agree-row">
                        <input type="checkbox" required>
                        <label>I agree to <span id="termsLink">Terms and Conditions</span></label>
                    </div>

                    <button type="submit" class="signup-btn">Sign Up</button>
                </form>

                <div class="login-link">
                    Already have an account? <a href="login-mock.php">Log in</a>
                </div>
            </div>
        </div>
    </main>

    <div id="termsModal" class="modal">
        <div class="modal-content">
            <h4>Terms and Conditions</h4>
            <p><strong>1. Acceptance of Terms</strong><br> By registering for ASENXO, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions. Use of the platform constitutes your consent to these terms and the privacy practices outlined herein.</p>
            <p><strong>2. Data Privacy & Security</strong><br> ASENXO collects, processes, and stores personal, financial, and transactional information necessary for the management of MSME applications, Technology Needs Assessments, procurement documentation, and compliance monitoring. Your data will only be used for official project management purposes. We implement administrative, technical, and physical safeguards to protect your information against unauthorized access, disclosure, alteration, or loss, in accordance with Philippine data privacy laws (RA 10173) and applicable regulations.</p>
            <p><strong>3. Confidentiality of Account</strong><br> You are responsible for maintaining the confidentiality of your login credentials. All actions performed under your account are your responsibility. Immediately report any suspected unauthorized access or data breach to ASENXO administrators.</p>
            <p><strong>4. Proper Use of Platform</strong><br> Users must use ASENXO solely for lawful and authorized purposes, related to project management, financial tracking, and compliance activities. Any misuse, including fraudulent submissions, unauthorized sharing of sensitive documents, or tampering with system data, may result in account suspension or termination.</p>
            <p><strong>5. Intellectual Property</strong><br> All content, software, reports, and system documentation in ASENXO remain the property of ASENXO or its licensors. Users are granted a limited, non-transferable license to access the platform for official project management activities in accordance with these Terms.</p>
            <p><strong>6. Limitation of Liability</strong><br> ASENXO is provided on an "as-is" basis. While we implement strict security and data protection measures, we are not liable for indirect, incidental, or consequential damages arising from the use or inability to use the system.</p>
            <p><strong>7. Termination</strong><br> ASENXO reserves the right to suspend or terminate accounts that violate these Terms. Upon termination, access to stored data may be restricted or deleted according to our data retention and privacy policies.</p>
            <p><strong>8. Governing Law</strong><br> These Terms are governed by Philippine laws. Any disputes shall be subject to the jurisdiction of Philippine courts.</p>
            <p><em>Note: This Terms & Conditions template prioritizes the privacy and security of financial and compliance data for ASENXO. Update as needed to reflect your institutional or legal requirements.</em></p>
            <button class="close-modal" id="closeModal">Close</button>
        </div>
    </div>

    <script>
    (function() {
        const password = document.getElementById("password");
        const checklist = document.getElementById("passwordChecklist");
        if (!password || !checklist) return;

        const checkUpper = document.getElementById("checkUpper");
        const checkLower = document.getElementById("checkLower");
        const checkNumber = document.getElementById("checkNumber");
        const checkSpecial = document.getElementById("checkSpecial");
        const checkLength = document.getElementById("checkLength");

        function toggle(el, valid) {
            el.classList.remove("valid", "invalid");
            el.classList.add(valid ? "valid" : "invalid");
        }

        password.addEventListener("input", () => {
            const val = password.value;

            if (val.length > 0 && checklist.style.display === 'none') {
                checklist.style.display = 'block';
            }
            else if (val.length === 0 && checklist.style.display !== 'none') {
                checklist.style.display = 'none';
            }

            toggle(checkUpper, /[A-Z]/.test(val));
            toggle(checkLower, /[a-z]/.test(val));
            toggle(checkNumber, /[0-9]/.test(val));
            toggle(checkSpecial, /[!@#$%^&*(),.?":{}|<>]/.test(val));
            toggle(checkLength, val.length >= 8);
        });
    })();

    const modal = document.getElementById('termsModal');
    const termsLink = document.getElementById('termsLink');
    const closeBtn = document.getElementById('closeModal');
    if (termsLink) {
        termsLink.addEventListener('click', (e) => {
            e.preventDefault();
            modal.style.display = 'flex';
        });
    }
    if (closeBtn) {
        closeBtn.addEventListener('click', () => modal.style.display = 'none');
    }
    window.addEventListener('click', (e) => {
        if (e.target === modal) modal.style.display = 'none';
    });

    const passwordToggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    if (passwordToggleBtn && passwordInput && toggleIcon) {
        passwordToggleBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    }
    </script>
</body>
</html>