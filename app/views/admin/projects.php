<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-projects">
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-project-diagram"></i> All Projects</h1>
            <p class="page-subtitle">View and manage all projects in the system</p>
        </div>
        <div class="header-actions">
            <a href="<?php echo BASE_URL; ?>/projects/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create Project
            </a>
            <a href="<?php echo BASE_URL; ?>/admin" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="projects-filters">
        <div class="filter-group">
            <label for="status-filter">Filter by Status:</label>
            <select id="status-filter" class="filter-select">
                <option value="">All Projects</option>
                <option value="planning">Planning</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="on_hold">On Hold</option>
            </select>
        </div>
    </div>

    <div class="projects-table-container">
        <table class="projects-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Project Title</th>
                    <th>Leader</th>
                    <th>Team Size</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Progress</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><?php echo $project['id']; ?></td>
                            <td>
                                <div class="project-title">
                                    <strong><?php echo htmlspecialchars($project['title']); ?></strong>
                                    <br>
                                    <small><?php echo htmlspecialchars(substr($project['description'], 0, 50)) . (strlen($project['description']) > 50 ? '...' : ''); ?></small>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($project['leader_name'] ?? 'Not assigned'); ?></td>
                            <td>
                                <span class="team-count">
                                    <i class="fas fa-users"></i>
                                    <?php echo $project['team_count'] ?? 0; ?> members
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo $project['status']; ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $project['status'])); ?>
                                </span>
                            </td>
                            <td><?php echo $project['start_date'] ? date('M j, Y', strtotime($project['start_date'])) : 'Not set'; ?></td>
                            <?php $projectEndDate = $project['end_date'] ?? ($project['expected_end_date'] ?? ($project['actual_end_date'] ?? null)); ?>
                            <td><?php echo !empty($projectEndDate) ? date('M j, Y', strtotime($projectEndDate)) : 'Not set'; ?></td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $project['progress'] ?? 0; ?>%"></div>
                                    <span class="progress-text"><?php echo $project['progress'] ?? 0; ?>%</span>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo BASE_URL; ?>/projects/view/<?php echo $project['id']; ?>" class="btn btn-sm btn-info" title="View Project">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/projects/edit/<?php echo $project['id']; ?>" class="btn btn-sm btn-warning" title="Edit Project">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/admin/delete-project/<?php echo $project['id']; ?>" class="btn btn-sm btn-danger" title="Delete Project" onclick="return confirm('Are you sure you want to delete this project? This action cannot be undone.')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="no-data">
                            <i class="fas fa-project-diagram"></i>
                            <p>No projects found</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.admin-projects {
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

.projects-filters {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.filter-group label {
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.filter-select {
    padding: 0.5rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 1rem;
    background: white;
    cursor: pointer;
}

.filter-select:focus {
    outline: none;
    border-color: #007bff;
}

.projects-table-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.projects-table {
    width: 100%;
    border-collapse: collapse;
}

.projects-table thead th {
    background: #f8f9fa;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #2c3e50;
    border-bottom: 2px solid #e9ecef;
}

.projects-table tbody td {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.projects-table tbody tr:hover {
    background: #f8f9fa;
}

.projects-table tbody tr:last-child td {
    border-bottom: none;
}

.project-title strong {
    color: #2c3e50;
    display: block;
    margin-bottom: 0.25rem;
}

.project-title small {
    color: #6c757d;
    font-size: 0.875rem;
}

.team-count {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #495057;
    font-size: 0.9rem;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-planning {
    background: #e3f2fd;
    color: #1976d2;
}

.status-in_progress {
    background: #fff3e0;
    color: #f57c00;
}

.status-completed {
    background: #e8f5e8;
    color: #2e7d32;
}

.status-on_hold {
    background: #ffebee;
    color: #c62828;
}

.progress-bar {
    position: relative;
    width: 100px;
    height: 20px;
    background: #e9ecef;
    border-radius: 10px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
    transition: width 0.3s ease;
}

.progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.75rem;
    font-weight: 600;
    color: #2c3e50;
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
    .admin-projects {
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

    .projects-table-container {
        overflow-x: auto;
    }

    .projects-table {
        min-width: 1000px;
    }

    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }

    .filter-group {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('status-filter');

    statusFilter.addEventListener('change', function() {
        const selectedStatus = this.value;
        const rows = document.querySelectorAll('.projects-table tbody tr');

        rows.forEach(row => {
            if (!row.classList.contains('no-data')) {
                const statusBadge = row.querySelector('.status-badge');
                if (selectedStatus === '' || statusBadge.textContent.toLowerCase().replace(' ', '_') === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });
});
</script>