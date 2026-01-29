<div class="dashboard">
    <h1><i class="fas fa-tachometer-alt"></i> Welcome, <?php echo $user['name']; ?>!</h1>
    <p>Role: <span class="badge badge-<?php echo $user['role']; ?>"><?php echo ucfirst($user['role']); ?></span></p>
    
    <div class="dashboard-cards">
        <div class="card">
            <div class="card-icon" style="background: #3498db;">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-content">
                <h3>Total Members</h3>
                <p class="card-number">0</p>
                <a href="<?php echo BASE_URL; ?>/members">View Members </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-icon" style="background: #2ecc71;">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="card-content">
                <h3>Upcoming Events</h3>
                <p class="card-number">0</p>
                <a href="<?php echo BASE_URL; ?>/events">View Events </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-icon" style="background: #e74c3c;">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div class="card-content">
                <h3>Active Projects</h3>
                <p class="card-number">0</p>
                <a href="<?php echo BASE_URL; ?>/projects">View Projects </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-icon" style="background: #f39c12;">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="card-content">
                <h3>Reports</h3>
                <p class="card-number">4</p>
                <a href="<?php echo BASE_URL; ?>/reports">Generate Reports </a>
            </div>
        </div>
    </div>
    
    <div class="quick-actions">
        <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
        <div class="action-buttons">
            <?php if ($this->isPatron()): ?>
                <a href="<?php echo BASE_URL; ?>/members/create" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Add New Member
                </a>
                <a href="<?php echo BASE_URL; ?>/events/create" class="btn btn-success">
                    <i class="fas fa-calendar-plus"></i> Create Event
                </a>
                <a href="<?php echo BASE_URL; ?>/projects/create" class="btn btn-info">
                    <i class="fas fa-plus-circle"></i> New Project
                </a>
            <?php endif; ?>
            
            <?php if ($this->isAdmin()): ?>
                <a href="#" class="btn btn-warning">
                    <i class="fas fa-cog"></i> System Settings
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="recent-activity">
        <h2><i class="fas fa-history"></i> Recent Activity</h2>
        <div class="activity-list">
            <div class="activity-item">
                <i class="fas fa-info-circle"></i>
                <p>No recent activity. System is newly installed.</p>
                <span class="activity-time">Just now</span>
            </div>
        </div>
    </div>
</div>
