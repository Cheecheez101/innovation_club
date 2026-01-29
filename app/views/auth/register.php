<?php
// app/views/auth/register.php
$title = 'Register - Elite Academy Innovation Club';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a237e;
            --primary-dark: #0f174f;
            --accent: #4fc3f7;
            --light: #f8faff;
            --gray: #6b7280;
            --dark: #111827;
            --success: #10b981;
            --error: #ef4444;
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
            background: var(--light);
            color: var(--dark);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .register-container {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            overflow: hidden;
            animation: fadeIn 0.6s ease-out;
            margin: 0 auto;
        }

        @keyframes fadeIn {
            from { opacity:0; transform: translateY(20px); }
            to   { opacity:1; transform: translateY(0); }
        }

        .register-header {
            background: linear-gradient(135deg, var(--primary) 0%, #2d387a 100%);
            color: white;
            padding: 3.5rem 2rem 2.5rem;
            text-align: center;
            position: relative;
        }

        .register-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 80%, rgba(79,195,247,0.18) 0%, transparent 50%);
            opacity: 0.6;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .register-header i {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            opacity: 0.92;
        }

        .register-header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .register-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .register-form {
            padding: 2.5rem 2rem 2rem;
        }

        .form-message {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.8rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 0.95rem;
        }

        .error { background:#fee2e2; color:#b91c1c; border-left:4px solid var(--error); }
        .success { background:#ecfdf5; color:#065f46; border-left:4px solid var(--success); }

        .input-group {
            position: relative;
            margin-bottom: 1.8rem;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 1.25rem 1rem 0.5rem;
            border: 2px solid #d1d5db;
            border-radius: 10px;
            font-size: 1.05rem;
            background: white;
            transition: all 0.25s ease;
        }

        .input-group input:focus,
        .input-group select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(79,195,247,0.12);
            outline: none;
        }

        .input-group label {
            position: absolute;
            top: 1.1rem;
            left: 1rem;
            color: var(--gray);
            font-size: 1.05rem;
            pointer-events: none;
            transition: all 0.25s ease;
        }

        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label,
        .input-group select:focus + label,
        .input-group select option:checked + label {
            top: 0.4rem;
            font-size: 0.82rem;
            color: var(--accent);
            font-weight: 500;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 1.1rem;
            color: var(--gray);
            font-size: 1.3rem;
            transition: color 0.25s;
            pointer-events: none;
        }

        .input-group input:focus ~ .input-icon,
        .input-group select:focus ~ .input-icon {
            color: var(--accent);
        }

        .has-icon input,
        .has-icon select {
            padding-left: 3rem;
        }

        .has-icon label {
            left: 3rem;
        }

        .form-row {
            display: flex;
            gap: 1.25rem;
            margin-bottom: 1.2rem;
        }

        .form-row > * { flex: 1; }

        .btn-register {
            width: 100%;
            padding: 1.15rem;
            background: linear-gradient(135deg, var(--primary), #283593);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.7rem;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #283593, var(--primary));
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(26,35,126,0.25);
        }

        .form-footer {
            text-align: center;
            margin-top: 1.8rem;
            font-size: 0.95rem;
            color: var(--gray);
        }

        .form-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .form-footer a:hover { text-decoration: underline; }

        .copyright {
            margin-top: 2.5rem;
            text-align: center;
            color: #9ca3af;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        @media (max-width: 640px) {
            .form-row { flex-direction: column; gap: 1.8rem; }
            .register-header { padding: 3rem 1.5rem 2rem; }
            .register-form { padding: 2rem 1.5rem 2rem; }
        }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="register-header">
            <div class="header-content">
                <i class="fas fa-user-plus"></i>
                <h1>InnoClub</h1>
                <p>Join the Elite Academy Innovation Club</p>
            </div>
        </div>

        <div class="register-form">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="form-message error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="form-message success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo BASE_URL; ?>/auth/register">
                <div class="form-row">
                    <div class="input-group has-icon">
                        <i class="input-icon fas fa-user"></i>
                        <input type="text" id="username" name="username" placeholder=" " required autofocus>
                        <label for="username">Username</label>
                    </div>

                    <div class="input-group has-icon">
                        <i class="input-icon fas fa-user-tag"></i>
                        <select id="role" name="role" required>
                            <option value="" disabled selected></option>
                            <option value="member">Member</option>
                            <option value="patron">Patron</option>
                        </select>
                        <label for="role">Role</label>
                    </div>
                </div>

                <div class="input-group has-icon">
                    <i class="input-icon fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder=" " required>
                    <label for="email">Email Address</label>
                </div>

                <div class="form-row">
                    <div class="input-group has-icon">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder=" " required>
                        <label for="password">Password</label>
                    </div>

                    <div class="input-group has-icon">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder=" " required>
                        <label for="confirm_password">Confirm Password</label>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i>
                    Create Account
                </button>
            </form>

            <div class="form-footer">
                Already have an account? <a href="<?php echo BASE_URL; ?>/auth/login">Login here</a>
            </div>

            <div class="copyright">
                <p>© 2026 Elite Academy Innovation Club</p>
                <p>Diploma in ICT – Trade Project</p>
            </div>
        </div>
    </div>

    <script>
        // Password match validation
        const password = document.getElementById('password');
        const confirm = document.getElementById('confirm_password');

        confirm.addEventListener('input', function() {
            if (password.value !== this.value) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        // Basic password strength border feedback
        password.addEventListener('input', function() {
            const len = this.value.length;
            if (len < 6) {
                this.style.borderColor = '#ef4444';
            } else if (len < 9) {
                this.style.borderColor = '#f59e0b';
            } else {
                this.style.borderColor = '#10b981';
            }
        });

        // Auto-remove messages after 6s
        setTimeout(() => {
            document.querySelectorAll('.form-message').forEach(el => {
                el.style.transition = 'opacity 0.6s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 600);
            });
        }, 6000);
    </script>
</body>
</html>