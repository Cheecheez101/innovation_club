<?php
// app/views/auth/login.php
$title = 'Login - Elite Academy Innovation Club';
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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        .login-split {
            display: flex;
            width: 100%;
            max-width: 1200px;
            min-height: 600px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        /* ── Brand / Left Side ── */
        .brand-side {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, #2d387a 100%);
            color: white;
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .brand-side::before {
            content: '';
            position: absolute;
            inset: -50%;
            background: radial-gradient(circle at 30% 70%, rgba(79,195,247,0.12) 0%, transparent 40%);
            opacity: 0.7;
            pointer-events: none;
        }

        .brand-content {
            position: relative;
            z-index: 2;
            max-width: 420px;
        }

        .brand-title {
            font-size: 2.1rem;
            font-weight: 600;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .brand-main {
            font-size: 3.8rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0.4rem;
        }

        .brand-main span {
            color: var(--accent);
        }

        .brand-subtitle {
            font-size: 1.3rem;
            font-weight: 500;
            opacity: 0.85;
            margin-bottom: 2.5rem;
        }

        .brand-prompt {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 2rem;
        }

        /* ── Form / Right Side ── */
        .form-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            background: white;
        }

        .form-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2.8rem;
        }

        .form-header h1 {
            font-size: 2.1rem;
            color: var(--primary);
            margin-bottom: 0.6rem;
        }

        .form-header p {
            color: var(--gray);
            font-size: 1.05rem;
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

        .error {
            background: #fee2e2;
            color: #b91c1c;
            border-left: 4px solid #ef4444;
        }

        .success {
            background: #ecfdf5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        /* Floating label input */
        .input-group {
            position: relative;
            margin-bottom: 1.8rem;
        }

        .input-group input {
            width: 100%;
            padding: 1.25rem 1rem 0.5rem;
            border: 2px solid #d1d5db;
            border-radius: 10px;
            font-size: 1.05rem;
            background: white;
            transition: all 0.25s ease;
        }

        .input-group input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(79, 195, 247, 0.12);
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
        .input-group input:not(:placeholder-shown) + label {
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
        }

        .input-group input:focus ~ .input-icon {
            color: var(--accent);
        }

        /* Adjust padding when icon present */
        .has-icon input {
            padding-left: 3rem;
        }

        .has-icon label {
            left: 3rem;
        }

        .btn-login {
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
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #283593, var(--primary));
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(26, 35, 126, 0.25);
        }

        .extra-links {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.95rem;
            color: var(--gray);
        }

        .extra-links a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 3rem;
            text-align: center;
            color: #9ca3af;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* ── Responsive ── */
        @media (max-width: 992px) {
            .login-split {
                flex-direction: column;
            }
            .brand-side {
                padding: 3.5rem 1.8rem;
                text-align: center;
            }
            .brand-content {
                max-width: none;
            }
            .brand-main {
                font-size: 3.2rem;
            }
            .form-side {
                padding: 2.5rem 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .brand-main { font-size: 2.8rem; }
            .form-header h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

    <div class="login-split">
        <!-- Brand / Inspiration Side -->
        <div class="brand-side">
            <div class="brand-content">
                <div class="brand-title">Elite Academy</div>
                <h1 class="brand-main">Inno<span>Club</span></h1>
                <div class="brand-subtitle">Innovation • Creativity • Technology</div>

                <div class="brand-prompt">Login to manage club activities</div>
            </div>
        </div>

        <!-- Login Form -->
        <div class="form-side">
            <div class="form-wrapper">
                <div class="form-header">
                    <h1>Welcome Back</h1>
                    <p>Sign in to your Innovation Club dashboard</p>
                </div>

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

                <form method="POST" action="<?php echo BASE_URL; ?>/auth/login">
                    <div class="input-group has-icon">
                        <i class="input-icon fas fa-user"></i>
                        <input type="text" name="username" placeholder=" " required autofocus>
                        <label>Username or Email</label>
                    </div>

                    <div class="input-group has-icon">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" name="password" placeholder=" " required>
                        <label>Password</label>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                        Sign In
                    </button>
                </form>

                <div class="extra-links">
                    <a href="#">Forgot password?</a><br><br>
                    Don't have an account? <a href="<?php echo BASE_URL; ?>/auth/register">Create one</a>
                </div>

                <div class="footer">
                    <p>© 2026 Elite Academy Innovation Club</p>
                    <p>Diploma in ICT – Trade Project</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Optional: Auto-remove messages after ~6 seconds
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