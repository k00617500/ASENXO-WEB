<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ASENXO</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="src/css/login-style.css">

</head>
<body>
    <main class="login-page">
        <div class="login-card">
            <div class="form-col">
                <!-- Logo (will hide if missing) -->
                <img src="src/img/logo-name.png" class="form-logo" alt="ASENXO Logo" onerror="this.style.display='none'">

                <!-- Google login button -->
                <button class="google-btn" type="button">
                    <i class="fab fa-google"></i> Login with Google
                </button>

                <div class="divider">
                    <span class="divider-line"></span>
                    <span>or</span>
                    <span class="divider-line"></span>
                </div>

                <form action="#" method="post">
                    <!-- Email field (label above input) -->
                    <div class="input-group">
                        <label>Email*</label>
                        <input type="email" placeholder="juan.delacruz@gmail.com" required>
                    </div>

                    <!-- Password field with toggle -->
                    <div class="input-group">
                        <label>Password*</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" id="togglePassword" tabindex="-1">
                                <i class="far fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember me & Forgot password row -->
                    <div class="row">
                        <div class="agree-row">
                            <input type="checkbox" id="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="#">Forgot password?</a>
                    </div>

                    <button type="submit" class="signup-btn">Sign In</button>
                </form>

                <div class="login-link">
                    Don't have an account? <a href="register-mock.php">Sign up</a>
                </div>
            </div>
        </div>
    </main>

    <script>
        (function() {
            const toggleBtn = document.getElementById('togglePassword');
            const pwdInput = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');

            if (toggleBtn && pwdInput && icon) {
                toggleBtn.addEventListener('click', function() {
                    const type = pwdInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    pwdInput.setAttribute('type', type);
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }
        })();
    </script>
</body>
</html>