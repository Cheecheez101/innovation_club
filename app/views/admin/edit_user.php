<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="edit-user">
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-user-edit"></i> Edit User</h1>
            <p class="page-subtitle">Modify user account information and settings</p>
        </div>
        <div class="header-actions">
            <a href="<?php echo BASE_URL; ?>/admin/users" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="form-container">
        <form action="<?php echo BASE_URL; ?>/admin/edit-user/<?php echo $user['id']; ?>" method="POST" class="user-form">
            <div class="form-section">
                <h3><i class="fas fa-user"></i> Account Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="username" class="required">
                            <i class="fas fa-at"></i> Username
                        </label>
                        <input type="text" id="username" name="username" required
                               placeholder="Enter username" value="<?php echo htmlspecialchars($user['username']); ?>">
                        <small class="form-help">Unique username for login</small>
                    </div>

                    <div class="form-group">
                        <label for="email" class="required">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <input type="email" id="email" name="email" required
                               placeholder="user@eliteacademy.edu" value="<?php echo htmlspecialchars($user['email']); ?>">
                        <small class="form-help">Valid email address for notifications</small>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="role" class="required">
                            <i class="fas fa-shield-alt"></i> User Role
                        </label>
                        <select id="role" name="role" required>
                            <option value="member" <?php echo ($user['role'] === 'member') ? 'selected' : ''; ?>>Member</option>
                            <option value="patron" <?php echo ($user['role'] === 'patron') ? 'selected' : ''; ?>>Patron</option>
                            <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                        <small class="form-help">Select the appropriate role for this user</small>
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> New Password (Optional)
                        </label>
                        <input type="password" id="password" name="password"
                               placeholder="Leave blank to keep current password" minlength="6">
                        <small class="form-help">Minimum 6 characters. Leave blank to keep current password.</small>
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="is_active" name="is_active" <?php echo $user['is_active'] ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                        Account Active
                    </label>
                    <small class="form-help">Inactive users cannot log in to the system</small>
                </div>
            </div>

            <!-- User Information Display -->
            <div class="form-section">
                <h3><i class="fas fa-info-circle"></i> Account Details</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>User ID:</label>
                        <span><?php echo $user['id']; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Created:</label>
                        <span><?php echo date('F j, Y \a\t g:i A', strtotime($user['created_at'])); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Last Login:</label>
                        <span><?php echo $user['last_login'] ? date('F j, Y \a\t g:i A', strtotime($user['last_login'])) : 'Never'; ?></span>
                    </div>
                    <?php if ($user['full_name']): ?>
                        <div class="info-item">
                            <label>Member Name:</label>
                            <span><?php echo htmlspecialchars($user['full_name']); ?> (ID: <?php echo htmlspecialchars($user['student_id']); ?>)</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large">
                    <i class="fas fa-save"></i> Update User
                </button>
                <a href="<?php echo BASE_URL; ?>/admin/users" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.edit-user {
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

.header-actions {
    display: flex;
    gap: 0.5rem;
}

.form-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.user-form {
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

.form-group select {
    cursor: pointer;
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

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.info-item {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.info-item label {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.info-item span {
    color: #495057;
    font-size: 0.95rem;
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
    .edit-user {
        padding: 1rem;
    }

    .form-section {
        padding: 1.5rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .info-grid {
        grid-template-columns: 1fr;
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
    const form = document.querySelector('.user-form');
    const password = document.getElementById('password');

    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (password.value && password.value.length < 6) {
            e.preventDefault();
            alert('Password must be at least 6 characters long.');
            password.focus();
            return false;
        }
    });
});
</script>