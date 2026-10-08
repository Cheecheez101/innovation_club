<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-users">
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-users-cog"></i> User Management</h1>
            <p class="page-subtitle">Manage system users and their roles</p>
        </div>
        <div class="header-actions">
            <a href="<?php echo BASE_URL; ?>/admin/create-user" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Add User
            </a>
            <a href="<?php echo BASE_URL; ?>/admin" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="users-table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Member Info</th>
                    <th>Last Login</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="role-badge role-<?php echo $user['role']; ?>">
                                    <?php echo ucfirst($user['role']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo $user['is_active'] ? 'active' : 'inactive'; ?>">
                                    <?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($user['full_name']): ?>
                                    <div class="member-info">
                                        <strong><?php echo htmlspecialchars($user['full_name']); ?></strong><br>
                                        <small>ID: <?php echo htmlspecialchars($user['student_id']); ?></small>
                                    </div>
                                <?php else: ?>
                                    <span class="no-member">Not a member</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo $user['last_login'] ? date('M j, Y H:i', strtotime($user['last_login'])) : 'Never'; ?>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo BASE_URL; ?>/admin/edit-user/<?php echo $user['id']; ?>" class="btn btn-sm btn-info" title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/admin/toggle-status/<?php echo $user['id']; ?>" class="btn btn-sm <?php echo $user['is_active'] ? 'btn-warning' : 'btn-success'; ?>" title="<?php echo $user['is_active'] ? 'Deactivate' : 'Activate'; ?> User">
                                        <i class="fas fa-<?php echo $user['is_active'] ? 'ban' : 'check'; ?>"></i>
                                    </a>
                                    <?php if ((int) $user['id'] !== (int) ($_SESSION['user_id'] ?? 0)): ?>
                                        <form action="<?php echo BASE_URL; ?>/admin/delete-user/<?php echo $user['id']; ?>" method="POST" class="inline-delete-form" onsubmit="return confirm('Delete this user account? This action cannot be undone.');">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="no-data">
                            <i class="fas fa-users"></i>
                            <p>No users found</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.admin-users {
    max-width: 1400px;
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

.users-table-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
}

.users-table thead {
    background: #f8f9fa;
}

.users-table th,
.users-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #e9ecef;
}

.users-table th {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.users-table tbody tr:hover {
    background: #f8f9fa;
}

.role-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
}

.role-admin { background: #dc3545; color: white; }
.role-patron { background: #fd7e14; color: white; }
.role-member { background: #28a745; color: white; }

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-active { background: #d4edda; color: #155724; }
.status-inactive { background: #f8d7da; color: #721c24; }

.member-info {
    line-height: 1.4;
}

.member-info strong {
    color: #2c3e50;
}

.member-info small {
    color: #6c757d;
}

.no-member {
    color: #6c757d;
    font-style: italic;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn {
    padding: 0.5rem 0.75rem;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
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

.btn-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
}

.btn-info:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(23,162,184,0.3);
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    color: #212529;
}

.btn-warning:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255,193,7,0.3);
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    color: white;
}

.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(40,167,69,0.3);
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
    color: white;
}

.btn-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220,53,69,0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-1px);
}

.btn-sm {
    padding: 0.375rem 0.5rem;
    font-size: 0.75rem;
}

.inline-delete-form {
    display: inline;
}

.no-data {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.no-data i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.no-data p {
    margin: 0;
    font-size: 1.1rem;
}

@media (max-width: 1024px) {
    .users-table {
        font-size: 0.9rem;
    }

    .users-table th,
    .users-table td {
        padding: 0.75rem 0.5rem;
    }
}

@media (max-width: 768px) {
    .admin-users {
        padding: 1rem;
    }

    .page-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .header-actions {
        justify-content: center;
    }

    .users-table-container {
        overflow-x: auto;
    }

    .users-table {
        min-width: 800px;
    }
}
</style>