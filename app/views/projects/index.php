<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-tasks"></i> Projects</h1>
        <?php if (($_SESSION['role'] ?? 'member') !== 'patron'): ?>
            <a href="<?php echo BASE_URL; ?>/projects/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create Project
            </a>
        <?php endif; ?>
    </div>

    <div class="projects-grid">
        <?php if (!empty($projects)): ?>
            <?php foreach ($projects as $project): ?>
                <div class="project-card">
                    <div class="project-header">
                        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                        <span class="status status-<?php echo $project['status']; ?>">
                            <?php echo ucfirst(str_replace('_', ' ', $project['status'])); ?>
                        </span>
                    </div>
                    <p><?php echo htmlspecialchars($project['description']); ?></p>
                    <div class="project-footer">
                        <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($project['lead_member_name'] ?? 'Unknown'); ?></span>
                        <div class="actions">
                            <a href="<?php echo BASE_URL; ?>/projects/show/<?php echo $project['id']; ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <?php
                            $userRole = $userRole ?? ($_SESSION['role'] ?? 'member');
                            $memberId = $memberId ?? null;
                            $canEdit = false;

                            if ($userRole === 'admin' || $userRole === 'patron') {
                                $canEdit = true;
                            } elseif ($userRole === 'member' && $memberId) {
                                $canEdit = ($project['lead_member_id'] == $memberId);
                            }

                            if ($canEdit):
                            ?>
                                <a href="<?php echo BASE_URL; ?>/projects/edit/<?php echo $project['id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?php echo BASE_URL; ?>/projects/delete/<?php echo $project['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this project? This action cannot be undone.');">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-tasks fa-3x"></i>
                <h3>No projects yet</h3>
                <p>Start by creating your first innovation project!</p>
                <a href="<?php echo BASE_URL; ?>/projects/create" class="btn btn-primary">Create Project</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.page-header h1 {
    margin: 0;
}

.projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}

.project-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.project-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.project-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.project-header h3 {
    margin: 0;
    font-size: 1.2rem;
}

.status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-in_progress { background: #f39c12; color: white; }
.status-ongoing { background: #f39c12; color: white; }
.status-planning { background: #3498db; color: white; }
.status-completed { background: #27ae60; color: white; }
.status-on_hold { background: #95a5a6; color: white; }
.status-on-hold { background: #95a5a6; color: white; }

.project-card p {
    padding: 1.5rem;
    margin: 0;
    color: #666;
}

.project-footer {
    padding: 1rem 1.5rem;
    background: #f8f9fa;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.project-footer span {
    color: #666;
    font-size: 0.9rem;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.btn-primary { background: #007bff; color: white; }
.btn-primary:hover { background: #0056b3; }

.btn-info { background: #17a2b8; color: white; }
.btn-info:hover { background: #138496; }

.btn-warning { background: #ffc107; color: #212529; }
.btn-warning:hover { background: #e0a800; }

.btn-danger { background: #dc3545; color: white; }
.btn-danger:hover { background: #c82333; }

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    color: #666;
}

.empty-state i {
    color: #ddd;
    margin-bottom: 1rem;
}
</style>