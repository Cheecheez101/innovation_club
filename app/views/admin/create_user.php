<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="create-patron">
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-user-plus"></i> Add User Account</h1>
            <p class="page-subtitle">Create a user directly from User Management</p>
        </div>
        <a href="<?php echo BASE_URL; ?>/admin/users" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
    </div>

    <div class="form-container">
        <form action="<?php echo BASE_URL; ?>/admin/create-user" method="POST" class="patron-form">
            <div class="form-section">
                <h3><i class="fas fa-user"></i> Account Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="username" class="required">
                            <i class="fas fa-at"></i> Username
                        </label>
                        <input type="text" id="username" name="username" required
                               placeholder="Enter username" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>">
                        <small class="form-help">Unique username for login</small>
                    </div>

                    <div class="form-group">
                        <label for="email" class="required">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <input type="email" id="email" name="email" required
                               placeholder="user@eliteacademy.edu" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                        <small class="form-help">Valid email address for notifications</small>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="role" class="required">
                            <i class="fas fa-shield-alt"></i> Role
                        </label>
                        <select id="role" name="role" required>
                            <option value="member" <?php echo (($user['role'] ?? 'member') === 'member') ? 'selected' : ''; ?>>Member</option>
                            <option value="patron" <?php echo (($user['role'] ?? '') === 'patron') ? 'selected' : ''; ?>>Patron</option>
                            <option value="admin" <?php echo (($user['role'] ?? '') === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                        <small class="form-help">Select user access level</small>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="is_active" name="is_active" <?php echo !isset($user['is_active']) || (int)$user['is_active'] === 1 ? 'checked' : ''; ?>>
                            <span class="checkmark"></span>
                            Account Active
                        </label>
                        <small class="form-help">Inactive users cannot log in</small>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="password" class="required">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" id="password" name="password" required
                               placeholder="Enter password" minlength="6">
                        <small class="form-help">Minimum 6 characters</small>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password" class="required">
                            <i class="fas fa-lock"></i> Confirm Password
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                               placeholder="Confirm password">
                        <small class="form-help">Re-enter password to confirm</small>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large">
                    <i class="fas fa-user-plus"></i> Add User
                </button>
                <a href="<?php echo BASE_URL; ?>/admin/users" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.create-patron {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
}

.header-content h1 {
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
}

.page-subtitle {
    color: #6c757d;
    margin: 0;
    font-size: 1rem;
}

.form-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.patron-form {
    padding: 0;
}

.form-section {
    padding: 2rem;
    border-bottom: 1px solid #e9ecef;
}

.form-section:last-child {
    border-bottom: none;
}

.form-section h3 {
    margin: 0 0 1.5rem 0;
    color: #2c3e50;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-group label.required::after {
    content: '*';
    color: #dc3545;
    font-weight: bold;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.2s ease;
    background: white;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
}

.form-help {
    display: block;
    margin-top: 0.25rem;
    color: #6c757d;
    font-size: 0.875rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.checkbox-label input[type="checkbox"] {
    width: auto;
    margin: 0;
    cursor: pointer;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid #e9ecef;
    border-radius: 4px;
    position: relative;
    background: white;
    transition: all 0.2s ease;
}

.checkbox-label input[type="checkbox"]:checked + .checkmark {
    background: #007bff;
    border-color: #007bff;
}

.checkbox-label input[type="checkbox"]:checked + .checkmark::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.form-actions {
    padding: 2rem;
    background: #f8f9fa;
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,123,255,0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-1px);
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .create-patron {
        padding: 1rem;
    }

    .form-section {
        padding: 1.5rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .form-actions {
        flex-direction: column;
        padding: 1.5rem;
    }

    .btn {
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.patron-form');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');

    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }

    password.addEventListener('change', validatePassword);
    confirmPassword.addEventListener('keyup', validatePassword);

    form.addEventListener('submit', function(e) {
        if (password.value !== confirmPassword.value) {
            e.preventDefault();
            alert('Passwords do not match. Please try again.');
            return false;
        }

        if (password.value.length < 6) {
            e.preventDefault();
            alert('Password must be at least 6 characters long.');
            return false;
        }
    });
});
</script>
