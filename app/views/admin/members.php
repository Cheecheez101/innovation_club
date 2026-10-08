<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-members">
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-user-graduate"></i> Manage Members</h1>
            <p class="page-subtitle">View and manage club members</p>
        </div>
        <div class="header-actions">
            <a href="<?php echo BASE_URL; ?>/members/create" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Add Member
            </a>
            <a href="<?php echo BASE_URL; ?>/admin" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="members-table-container">
        <table class="members-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Student ID</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Year</th>
                    <th>Status</th>
                    <th>Join Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($members)): ?>
                    <?php foreach ($members as $member): ?>
                        <tr>
                            <td><?php echo $member['id']; ?></td>
                            <td><?php echo htmlspecialchars($member['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($member['student_id']); ?></td>
                            <td><?php echo htmlspecialchars($member['email']); ?></td>
                            <td><?php echo htmlspecialchars($member['department'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($member['year_of_study'] ?? 'N/A'); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $member['status']; ?>">
                                    <?php echo ucfirst($member['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($member['join_date'])); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo BASE_URL; ?>/members/profile/<?php echo $member['id']; ?>" class="btn btn-sm btn-info" title="View Profile">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/members/edit/<?php echo $member['id']; ?>" class="btn btn-sm btn-warning" title="Edit Member">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/admin/toggle-member-status/<?php echo $member['id']; ?>" class="btn btn-sm <?php echo $member['status'] === 'active' ? 'btn-secondary' : 'btn-success'; ?>" title="<?php echo $member['status'] === 'active' ? 'Deactivate' : 'Activate'; ?> Member">
                                        <i class="fas fa-<?php echo $member['status'] === 'active' ? 'ban' : 'check'; ?>"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/admin/delete-member/<?php echo $member['id']; ?>" class="btn btn-sm btn-danger" title="Delete Member" onclick="return confirm('Are you sure you want to delete this member? This action cannot be undone.')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="no-data">
                            <i class="fas fa-users"></i>
                            <p>No members found</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.admin-members {
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

.members-table-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.members-table {
    width: 100%;
    border-collapse: collapse;
}

.members-table thead th {
    background: #f8f9fa;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #2c3e50;
    border-bottom: 2px solid #e9ecef;
}

.members-table tbody td {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.members-table tbody tr:hover {
    background: #f8f9fa;
}

.members-table tbody tr:last-child td {
    border-bottom: none;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-inactive {
    background: #f8d7da;
    color: #721c24;
}

.status-alumni {
    background: #d1ecf1;
    color: #0c5460;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn {
    padding: 0.375rem 0.75rem;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.btn-info {
    background: #17a2b8;
    color: white;
}

.btn-info:hover {
    background: #138496;
    transform: translateY(-1px);
}

.btn-warning {
    background: #ffc107;
    color: #212529;
}

.btn-warning:hover {
    background: #e0a800;
    transform: translateY(-1px);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-1px);
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-success:hover {
    background: #218838;
    transform: translateY(-1px);
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,123,255,0.3);
}

.no-data {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.no-data i {
    font-size: 3rem;
    margin-bottom: 1rem;
    display: block;
}

.no-data p {
    margin: 0;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .admin-members {
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

    .members-table-container {
        overflow-x: auto;
    }

    .members-table {
        min-width: 800px;
    }

    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
}
</style>