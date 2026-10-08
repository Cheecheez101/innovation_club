<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-dashboard">
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-cog"></i> Admin Dashboard</h1>
            <p class="page-subtitle">Manage users, members, and system settings</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['total_users'] ?? 0; ?></h3>
                <p>Total Users</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['total_members'] ?? 0; ?></h3>
                <p>Club Members</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['total_projects'] ?? 0; ?></h3>
                <p>Total Projects</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-play-circle"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['active_projects'] ?? 0; ?></h3>
                <p>Active Projects</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['recent_registrations'] ?? 0; ?></h3>
                <p>New Members (30 days)</p>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <div class="actions-grid">
                <a href="<?php echo BASE_URL; ?>/admin/create-user" class="action-card">
                    <i class="fas fa-user-plus"></i>
                    <span>Add User</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/users" class="action-card">
                    <i class="fas fa-users-cog"></i>
                    <span>Manage Users</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/members" class="action-card">
                    <i class="fas fa-user-graduate"></i>
                    <span>Manage Members</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/projects" class="action-card">
                    <i class="fas fa-project-diagram"></i>
                    <span>All Projects</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/reports" class="action-card">
                    <i class="fas fa-chart-bar"></i>
                    <span>View Reports</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <div class="activity-section">
                <h2><i class="fas fa-user-plus"></i> Recent Member Registrations</h2>
                <div class="activity-list">
                    <?php if (!empty($recent_members)): ?>
                        <?php foreach ($recent_members as $member): ?>
                            <div class="activity-item">
                                <div class="activity-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="activity-content">
                                    <p><strong><?php echo htmlspecialchars($member['full_name']); ?></strong> joined the club</p>
                                    <small><?php echo date('M j, Y', strtotime($member['created_at'])); ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-activity">No recent member registrations</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="activity-section">
                <h2><i class="fas fa-lightbulb"></i> Recent Projects</h2>
                <div class="activity-list">
                    <?php if (!empty($recent_projects)): ?>
                        <?php foreach ($recent_projects as $project): ?>
                            <div class="activity-item">
                                <div class="activity-avatar">
                                    <i class="fas fa-project-diagram"></i>
                                </div>
                                <div class="activity-content">
                                    <p><strong><?php echo htmlspecialchars($project['title']); ?></strong> was created</p>
                                    <small>by <?php echo htmlspecialchars($project['lead_member_name'] ?? 'Unknown'); ?> • <?php echo date('M j, Y', strtotime($project['created_at'])); ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-activity">No recent projects</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
    max-width: 1200px;
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

/* Statistics Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-icon:nth-child(1) { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.stat-icon:nth-child(2) { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.stat-icon:nth-child(3) { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.stat-icon:nth-child(4) { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
.stat-icon:nth-child(5) { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }

.stat-content h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
}

.stat-content p {
    margin: 0.25rem 0 0 0;
    color: #6c757d;
    font-size: 0.9rem;
}

/* Dashboard Content */
.dashboard-content {
    display: grid;
    gap: 2rem;
}

/* Quick Actions */
.quick-actions h2 {
    margin: 0 0 1.5rem 0;
    color: #2c3e50;
    font-size: 1.5rem;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.action-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    text-decoration: none;
    color: #2c3e50;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.2s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 2px solid transparent;
}

.action-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    border-color: #007bff;
}

.action-card i {
    font-size: 2rem;
    color: #007bff;
}

.action-card span {
    font-weight: 600;
    text-align: center;
}

/* Recent Activity */
.recent-activity {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.activity-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.activity-section h2 {
    margin: 0 0 1.5rem 0;
    color: #2c3e50;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.activity-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #007bff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.activity-content p {
    margin: 0;
    color: #2c3e50;
    font-size: 0.9rem;
}

.activity-content small {
    color: #6c757d;
    font-size: 0.8rem;
}

.no-activity {
    text-align: center;
    color: #6c757d;
    margin: 2rem 0;
    font-style: italic;
}

@media (max-width: 768px) {
    .admin-dashboard {
        padding: 1rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .recent-activity {
        grid-template-columns: 1fr;
    }

    .actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .stat-card {
        padding: 1rem;
    }

    .stat-content h3 {
        font-size: 1.5rem;
    }
}
</style>