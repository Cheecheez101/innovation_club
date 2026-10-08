<?php
function getFileIcon($extension) {
    $icons = [
        'pdf' => 'file-pdf',
        'doc' => 'file-word',
        'docx' => 'file-word',
        'ppt' => 'file-powerpoint',
        'pptx' => 'file-powerpoint',
        'xls' => 'file-excel',
        'xlsx' => 'file-excel',
        'jpg' => 'file-image',
        'jpeg' => 'file-image',
        'png' => 'file-image',
        'gif' => 'file-image',
        'zip' => 'file-archive',
        'rar' => 'file-archive',
        'txt' => 'file-alt'
    ];
    return $icons[$extension] ?? 'file';
}

function formatFileSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $i = 0;
    while ($bytes >= 1024 && $i < 3) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}
?>

<div class="container">
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-project-diagram"></i> <?php echo htmlspecialchars($project['title']); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/projects">Projects</a></li>
                    <li class="breadcrumb-item active"><?php echo htmlspecialchars($project['title']); ?></li>
                </ol>
            </nav>
        </div>
        <div class="actions">
            <?php if (!empty($canManage)): ?>
                <a href="<?php echo BASE_URL; ?>/projects/edit/<?php echo $project['id']; ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Project
                </a>
                <a href="<?php echo BASE_URL; ?>/projects/delete/<?php echo $project['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project? This action cannot be undone.');">
                    <i class="fas fa-trash"></i> Delete Project
                </a>
            <?php endif; ?>
            <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
        </div>
    </div>

    <div class="project-detail-card">
        <!-- Project Header -->
        <div class="project-header">
            <div class="project-meta">
                <div class="meta-item">
                    <i class="fas fa-tag"></i>
                    <span><?php echo htmlspecialchars($project['category'] ?? 'Uncategorized'); ?></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-calendar"></i>
                    <span>Started: <?php echo $project['start_date'] ? date('M j, Y', strtotime($project['start_date'])) : 'Not set'; ?></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-clock"></i>
                    <span>Due: <?php echo $project['expected_end_date'] ? date('M j, Y', strtotime($project['expected_end_date'])) : 'Not set'; ?></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Budget: $<?php echo number_format($project['budget'] ?? 0, 2); ?></span>
                </div>
            </div>
            <div class="project-status">
                <span class="status status-<?php echo $project['status']; ?>">
                    <?php echo ucfirst(str_replace('_', ' ', $project['status'])); ?>
                </span>
            </div>
        </div>

        <!-- Project Content -->
        <div class="project-content">
            <!-- Description -->
            <div class="content-section">
                <h3><i class="fas fa-info-circle"></i> Description</h3>
                <p><?php echo nl2br(htmlspecialchars($project['description'] ?? 'No description provided.')); ?></p>
            </div>

            <!-- Objectives -->
            <?php if (!empty($project['objectives'])): ?>
            <div class="content-section">
                <h3><i class="fas fa-bullseye"></i> Objectives</h3>
                <p><?php echo nl2br(htmlspecialchars($project['objectives'])); ?></p>
            </div>
            <?php endif; ?>

            <!-- Team Members -->
            <div class="content-section">
                <h3><i class="fas fa-users"></i> Team</h3>
                <div class="team-list">
                    <div class="team-member lead">
                        <div class="member-avatar">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="member-info">
                            <h4><?php echo htmlspecialchars($project['lead_name'] ?? 'Unknown'); ?></h4>
                            <span class="member-role">Project Lead</span>
                        </div>
                    </div>
                    <!-- Additional team members would be listed here -->
                </div>
            </div>

            <!-- Project Files -->
            <div class="content-section">
                <h3><i class="fas fa-file-alt"></i> Project Files</h3>
                <?php if (!empty($projectFiles)): ?>
                    <div class="files-list">
                        <?php foreach ($projectFiles as $file): ?>
                            <div class="file-item">
                                <div class="file-icon">
                                    <i class="fas fa-<?php echo getFileIcon($file['file_type']); ?>"></i>
                                </div>
                                <div class="file-info">
                                    <h4><?php echo htmlspecialchars($file['original_name']); ?></h4>
                                    <div class="file-meta">
                                        <span><?php echo formatFileSize($file['file_size']); ?></span>
                                        <span>•</span>
                                        <span>Uploaded by <?php echo htmlspecialchars($file['uploaded_by_name']); ?></span>
                                        <span>•</span>
                                        <span><?php echo date('M j, Y', strtotime($file['uploaded_at'])); ?></span>
                                    </div>
                                </div>
                                <div class="file-actions">
                                    <a href="<?php echo BASE_URL . $file['file_path']; ?>" class="btn btn-sm btn-primary" target="_blank">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-file-alt"></i>
                        <h3>No files uploaded</h3>
                        <p>Files uploaded to this project will appear here.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Project Timeline -->
            <div class="content-section">
                <h3><i class="fas fa-calendar-alt"></i> Timeline</h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Project Created</h4>
                            <p><?php echo date('M j, Y', strtotime($project['created_at'])); ?></p>
                        </div>
                    </div>
                    <?php if ($project['start_date']): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Work Started</h4>
                            <p><?php echo date('M j, Y', strtotime($project['start_date'])); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($project['actual_end_date']): ?>
                    <div class="timeline-item completed">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Project Completed</h4>
                            <p><?php echo date('M j, Y', strtotime($project['actual_end_date'])); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-header h1 {
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #6c757d;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #007bff;
}

.actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.project-detail-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.project-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 1rem;
}

.project-title-section h2 {
    margin: 0 0 0.5rem 0;
    font-size: 1.8rem;
    font-weight: 600;
}

.status {
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    display: inline-block;
}

.status-planning { background: #3498db; }
.status-in_progress { background: #f39c12; }
.status-completed { background: #27ae60; }
.status-on_hold { background: #95a5a6; }

.project-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.meta-item i {
    opacity: 0.8;
}

.project-content {
    padding: 2rem;
}

.content-section {
    margin-bottom: 2rem;
}

.content-section h3 {
    color: #2c3e50;
    margin-bottom: 1rem;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.content-section h3 i {
    color: #667eea;
}

.content-section p {
    color: #666;
    line-height: 1.6;
    margin: 0;
}

.status-details {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.status-dot.status-planning { background: #3498db; }
.status-dot.status-in_progress { background: #f39c12; }
.status-dot.status-completed { background: #27ae60; }
.status-dot.status-on_hold { background: #95a5a6; }

.team-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.team-member {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.team-member.lead {
    border-left-color: #f39c12;
    background: linear-gradient(135deg, #fff3cd 0%, #f8f9fa 100%);
}

.member-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #667eea;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.member-info h4 {
    margin: 0 0 0.25rem 0;
    color: #2c3e50;
    font-size: 1rem;
}

.member-role {
    color: #6c757d;
    font-size: 0.85rem;
    font-weight: 500;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
    padding-left: 1rem;
}

.timeline-item.completed .timeline-marker {
    background: #28a745;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #667eea;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content h4 {
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
    font-size: 1rem;
}

.timeline-content p {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
}

.files-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.file-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    transition: all 0.2s;
}

.file-item:hover {
    background: #f1f3f4;
    border-color: #dee2e6;
}

.file-icon {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    background: #667eea;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.file-info {
    flex: 1;
    min-width: 0;
}

.file-info h4 {
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
    font-size: 1rem;
    word-break: break-word;
}

.file-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: #6c757d;
    flex-wrap: wrap;
}

.file-actions {
    flex-shrink: 0;
}

.btn {
    padding: 0.6rem 1.2rem;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s;
    cursor: pointer;
}

.btn-warning {
    background: #ffc107;
    color: #212529;
}

.btn-warning:hover {
    background: #e0a800;
    color: #212529;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    color: white;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-primary:hover {
    background: #0056b3;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #666;
}

.empty-state i {
    color: #ddd;
    margin-bottom: 1rem;
}

.empty-state h3 {
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .project-header {
        flex-direction: column;
        text-align: center;
    }

    .project-meta {
        align-items: center;
    }

    .status-details {
        flex-direction: column;
        align-items: flex-start;
    }

    .actions {
        justify-content: center;
    }
}
</style>