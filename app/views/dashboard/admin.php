<?php if (!defined('APP_PATH')) { header('Location: /innovation_club/public/'); exit; } ?>
<div class="dashboard admin-dashboard">
    <div class="dashboard-header">
        <h1><i class="fas fa-crown"></i> Admin Dashboard</h1>
        <p>Welcome back, <?php echo $user['name']; ?>! Here's your system overview.</p>
        <div class="admin-panel-link">
            <a href="<?php echo BASE_URL; ?>/admin" class="btn-admin-panel">
                <i class="fas fa-cog"></i> Admin Panel
            </a>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>Total Members</h3>
                <p class="stat-number"><?php echo $stats['total_members'] ?? 0; ?></p>
                <span class="stat-change positive">+12%</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h3>Active Events</h3>
                <p class="stat-number"><?php echo $stats['active_events'] ?? 0; ?></p>
                <span class="stat-change">This month</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div class="stat-content">
                <h3>Ongoing Projects</h3>
                <p class="stat-number"><?php echo $stats['active_projects'] ?? 0; ?></p>
                <span class="stat-change">In progress</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3>Pending Tasks</h3>
                <p class="stat-number"><?php echo $stats['pending_tasks'] ?? 0; ?></p>
                <span class="stat-change urgent">Requires attention</span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Recent Activities -->
        <div class="dashboard-section activities-section">
            <div class="section-header">
                <h2><i class="fas fa-history"></i> Recent Activities</h2>
                <a href="<?php echo BASE_URL; ?>/reports" class="view-all">View All</a>
            </div>
            <div class="activities-list">
                <?php if (!empty($recent_activities)): ?>
                    <?php foreach ($recent_activities as $activity): ?>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-history"></i>
                            </div>
                            <div class="activity-content">
                                <p><?php echo htmlspecialchars($activity['title']); ?></p>
                                <span class="activity-time"><?php echo htmlspecialchars($activity['time']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="activity-content">
                            <p>No recent activities</p>
                            <span class="activity-time">No activities yet</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-section actions-section">
            <div class="section-header">
                <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
            </div>
            <div class="quick-actions">
                <a href="<?php echo BASE_URL; ?>/admin/members" class="action-btn">
                    <i class="fas fa-users-cog"></i>
                    <span>Manage Members</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/users" class="action-btn">
                    <i class="fas fa-user-shield"></i>
                    <span>Manage Users</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/create-patron" class="action-btn">
                    <i class="fas fa-user-tie"></i>
                    <span>Create Patron</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/events/create" class="action-btn">
                    <i class="fas fa-calendar-plus"></i>
                    <span>Create Event</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/projects/create" class="action-btn">
                    <i class="fas fa-plus-circle"></i>
                    <span>New Project</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/admin/projects" class="action-btn">
                    <i class="fas fa-project-diagram"></i>
                    <span>All Projects</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/reports" class="action-btn">
                    <i class="fas fa-chart-bar"></i>
                    <span>View Reports</span>
                </a>
            </div>
        </div>

        <!-- System Health -->
        <div class="dashboard-section health-section">
            <div class="section-header">
                <h2><i class="fas fa-heartbeat"></i> System Health</h2>
            </div>
            <div class="health-metrics">
                <div class="health-item">
                    <span class="health-label">Database Status</span>
                    <span class="health-status healthy">
                        <i class="fas fa-check-circle"></i> Online
                    </span>
                </div>
                <div class="health-item">
                    <span class="health-label">Server Load</span>
                    <span class="health-status good">
                        <i class="fas fa-info-circle"></i> Normal
                    </span>
                </div>
                <div class="health-item">
                    <span class="health-label">Backup Status</span>
                    <span class="health-status healthy">
                        <i class="fas fa-check-circle"></i> Up to date
                    </span>
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="dashboard-section events-section">
            <div class="section-header">
                <h2><i class="fas fa-calendar"></i> Upcoming Events</h2>
                <a href="<?php echo BASE_URL; ?>/events" class="view-all">View All</a>
            </div>
            <div class="upcoming-events">
                <?php if (!empty($upcoming_events)): ?>
                    <?php foreach ($upcoming_events as $event): ?>
                        <div class="event-item">
                            <div class="event-date">
                                <span class="day"><?php echo date('d', strtotime($event['event_date'])); ?></span>
                                <span class="month"><?php echo date('M', strtotime($event['event_date'])); ?></span>
                            </div>
                            <div class="event-details">
                                <h4><?php echo htmlspecialchars($event['title']); ?></h4>
                                <p><?php echo htmlspecialchars($event['description'] ?? 'No description available'); ?></p>
                                <span class="event-time">
                                    <?php
                                    if ($event['start_time'] && $event['end_time']) {
                                        echo date('g:i A', strtotime($event['start_time'])) . ' - ' . date('g:i A', strtotime($event['end_time']));
                                    } else {
                                        echo 'Time TBD';
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="event-item">
                        <div class="event-date">
                            <span class="day">--</span>
                            <span class="month">No</span>
                        </div>
                        <div class="event-details">
                            <h4>No upcoming events</h4>
                            <p>No events scheduled at this time</p>
                            <span class="event-time">Check back later</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

.dashboard-header {
    margin-bottom: 30px;
    text-align: center;
}

.dashboard-header h1 {
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 2.5rem;
}

.dashboard-header p {
    color: #7f8c8d;
    font-size: 1.1rem;
}

.admin-panel-link {
    margin-top: 15px;
}

.btn-admin-panel {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-admin-panel:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    text-decoration: none;
    color: white;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.07);
    border: 1px solid #ecf0f1;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
}

.stat-content h3 {
    margin: 0 0 8px 0;
    color: #2c3e50;
    font-size: 0.9rem;
    font-weight: 600;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0 0 5px 0;
}

.stat-change {
    font-size: 0.8rem;
    font-weight: 500;
}

.stat-change.positive {
    color: #27ae60;
}

.stat-change.urgent {
    color: #e74c3c;
}

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

.dashboard-section {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.07);
    border: 1px solid #ecf0f1;
}

.section-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #ecf0f1;
}

.section-header h2 {
    margin: 0;
    color: #2c3e50;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.view-all {
    color: #3498db;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
}

.view-all:hover {
    text-decoration: underline;
}

/* Activities */
.activities-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    border-radius: 8px;
    background: #f8f9fa;
    transition: background 0.3s ease;
}

.activity-item:hover {
    background: #e9ecef;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #3498db;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

.activity-content p {
    margin: 0 0 5px 0;
    color: #2c3e50;
    font-size: 0.9rem;
}

.activity-time {
    color: #7f8c8d;
    font-size: 0.8rem;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    font-size: 0.9rem;
    font-weight: 500;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(102, 126, 234, 0.3);
}

.action-btn i {
    font-size: 24px;
}

/* Health Metrics */
.health-metrics {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.health-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #ecf0f1;
}

.health-item:last-child {
    border-bottom: none;
}

.health-label {
    color: #2c3e50;
    font-weight: 500;
}

.health-status {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    font-size: 0.9rem;
}

.health-status.healthy {
    color: #27ae60;
}

.health-status.good {
    color: #f39c12;
}

/* Upcoming Events */
.upcoming-events {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.event-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    border-radius: 8px;
    background: #f8f9fa;
    transition: background 0.3s ease;
}

.event-item:hover {
    background: #e9ecef;
}

.event-date {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 50px;
    padding: 8px;
    background: #3498db;
    color: white;
    border-radius: 8px;
    text-align: center;
}

.event-date .day {
    font-size: 1.2rem;
    font-weight: 700;
}

.event-date .month {
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
}

.event-details h4 {
    margin: 0 0 5px 0;
    color: #2c3e50;
    font-size: 1rem;
}

.event-details p {
    margin: 0 0 5px 0;
    color: #7f8c8d;
    font-size: 0.85rem;
}

.event-time {
    color: #3498db;
    font-size: 0.8rem;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }

    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}

@media (max-width: 768px) {
    .admin-dashboard {
        padding: 15px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .quick-actions {
        grid-template-columns: 1fr;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>
