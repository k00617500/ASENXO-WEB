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
    <style>
        .form-message { margin-top: 1rem; padding: 0.75rem; border-radius: 8px; font-size: 0.9rem; display: none; }
        .form-message.success { background-color: rgba(46,204,113,0.15); color: #2ecc71; border: 1px solid rgba(46,204,113,0.3); display: block; }
        .form-message.error { background-color: rgba(231,76,60,0.15); color: #e74c3c; border: 1px solid rgba(231,76,60,0.3); display: block; }
    </style>
</head>
<body>
    <main class="login-page">
        <div class="login-card">
            <div class="form-col">
                <a href="index.php"><img src="src/img/logo-name.png" class="form-logo" alt="ASENXO Logo"></a>

                <button class="google-btn" type="button" id="googleLogin">
                    <i class="fab fa-google"></i> Login with Google
                </button>

                <div class="divider">
                    <span class="divider-line"></span><span>or</span><span class="divider-line"></span>
                </div>

                <form id="loginForm">
                    <div class="input-group">
                        <label>Email*</label>
                        <input type="email" id="email" placeholder="juan.delacruz@gmail.com" required>
                    </div>

                    <div class="input-group">
                        <label>Password*</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" id="togglePassword" tabindex="-1">
                                <i class="far fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="agree-row">
                            <input type="checkbox" id="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="#" id="forgotPassword">Forgot password?</a>
                    </div>

                    <div id="formMessage" class="form-message"></div>

                    <button type="submit" class="signup-btn" id="loginBtn">Sign In</button>
                </form>

                <div class="login-link">
                    Don't have an account? <a href="register-mock.php">Sign up</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Supabase JS -->
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    <script>
        (function() {
            const SUPABASE_URL = 'https://hmxrblblcpbikkxcwwni.supabase.co';
            const SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImhteHJibGJsY3BiaWtreGN3d25pIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzIyODY0MDksImV4cCI6MjA4Nzg2MjQwOX0.qC4Lm2KbToc0f1syHpMWJmQqRhQTosNfFzBrfTXSWDw';
            const supabase = window.supabase.createClient(SUPABASE_URL, SUPABASE_ANON_KEY);

            const form = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const formMessage = document.getElementById('formMessage');
            const toggleBtn = document.getElementById('togglePassword');
            const pwdInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            // Password toggle
            if (toggleBtn && pwdInput && toggleIcon) {
                toggleBtn.addEventListener('click', () => {
                    const type = pwdInput.type === 'password' ? 'text' : 'password';
                    pwdInput.type = type;
                    toggleIcon.classList.toggle('fa-eye');
                    toggleIcon.classList.toggle('fa-eye-slash');
                });
            }

            // Handle login
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                if (!email || !password) {
                    formMessage.className = 'form-message error';
                    formMessage.textContent = 'Please enter both email and password.';
                    return;
                }

                loginBtn.disabled = true;
                loginBtn.textContent = 'Logging in...';

                try {
                    const { data, error } = await supabase.auth.signInWithPassword({
                        email,
                        password
                    });
                    if (error) throw error;

                    formMessage.className = 'form-message success';
                    formMessage.textContent = 'Login successful! Redirecting...';
                    setTimeout(() => {
                        window.location.href = 'dashboard.php'; // or your desired landing page
                    }, 1500);
                } catch (err) {
                    formMessage.className = 'form-message error';
                    formMessage.textContent = err.message;
                } finally {
                    loginBtn.disabled = false;
                    loginBtn.textContent = 'Sign In';
                }
            });

            // Google login (optional)
            document.getElementById('googleLogin').addEventListener('click', async () => {
                const { error } = await supabase.auth.signInWithOAuth({ provider: 'google' });
                if (error) console.error(error);
            });

            // Forgot password (optional)
            document.getElementById('forgotPassword').addEventListener('click', (e) => {
                e.preventDefault();
                // You can implement password reset flow using supabase.auth.resetPasswordForEmail()
                alert('Password reset feature - implement via supabase.auth.resetPasswordForEmail()');
            });
        })();
    </script>
</body>
</html>