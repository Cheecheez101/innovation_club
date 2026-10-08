<?php if (!defined('APP_PATH')) { header('Location: /innovation_club/public/'); exit; } ?>
<div class="dashboard member-dashboard">
    <div class="dashboard-header">
        <h1><i class="fas fa-user-graduate"></i> Member Dashboard</h1>
        <p>Welcome back, <?php echo $user['name']; ?>! Ready to innovate today?</p>
    </div>

    <!-- Personal Progress -->
    <div class="progress-overview">
        <div class="progress-card">
            <div class="progress-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div class="progress-content">
                <h3>Active Projects</h3>
                <p class="progress-number"><?php echo $progress['active_projects'] ?? 0; ?></p>
                <span class="progress-desc">Currently working on</span>
            </div>
        </div>

        <div class="progress-card">
            <div class="progress-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="progress-content">
                <h3>Events Attended</h3>
                <p class="progress-number"><?php echo $progress['events_attended'] ?? 0; ?></p>
                <span class="progress-desc">This semester</span>
            </div>
        </div>

        <div class="progress-card">
            <div class="progress-icon">
                <i class="fas fa-trophy"></i>
            </div>
            <div class="progress-content">
                <h3>Achievements</h3>
                <p class="progress-number"><?php echo $progress['achievements'] ?? 0; ?></p>
                <span class="progress-desc">Unlocked badges</span>
            </div>
        </div>

        <div class="progress-card">
            <div class="progress-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="progress-content">
                <h3>Hours Contributed</h3>
                <p class="progress-number"><?php echo $progress['hours_contributed'] ?? 0; ?>h</p>
                <span class="progress-desc">This month</span>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="dashboard-content">
        <!-- My Projects -->
        <div class="dashboard-section my-projects">
            <div class="section-header">
                <h2><i class="fas fa-tasks"></i> My Projects</h2>
                <a href="<?php echo BASE_URL; ?>/projects" class="view-all">View All</a>
            </div>
            <div class="projects-list">
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $project): ?>
                        <div class="project-item">
                            <div class="project-info">
                                <h4><?php echo htmlspecialchars($project['title']); ?></h4>
                                <p><?php echo htmlspecialchars(substr($project['description'] ?? '', 0, 50)); ?><?php echo strlen($project['description'] ?? '') > 50 ? '...' : ''; ?></p>
                                <div class="project-meta">
                                    <span class="role">Role: <?php echo htmlspecialchars($project['member_role']); ?></span>
                                    <span class="team-size">Team: <?php echo $project['team_count']; ?> members</span>
                                </div>
                            </div>
                            <div class="project-status">
                                <?php
                                $statusClass = 'active';
                                $statusText = 'Active';
                                if ($project['status'] === 'completed') {
                                    $statusClass = 'completed';
                                    $statusText = 'Completed';
                                } elseif ($project['status'] === 'on_hold') {
                                    $statusClass = 'on-hold';
                                    $statusText = 'On Hold';
                                } elseif ($project['status'] === 'idea') {
                                    $statusClass = 'planning';
                                    $statusText = 'Planning';
                                }
                                ?>
                                <div class="status-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></div>
                                <?php if ($project['status'] === 'completed'): ?>
                                    <div class="completion-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                <?php else: ?>
                                    <div class="progress-circle">
                                        <svg width="60" height="60">
                                            <circle cx="30" cy="30" r="25" stroke="#ecf0f1" stroke-width="5" fill="none"/>
                                            <circle cx="30" cy="30" r="25" stroke="#667eea" stroke-width="5" fill="none"
                                                    stroke-dasharray="157" stroke-dashoffset="47" transform="rotate(-90 30 30)"/>
                                        </svg>
                                        <span class="progress-text">70%</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-project-diagram"></i>
                        <h4>No projects yet</h4>
                        <p>You haven't joined or created any projects yet.</p>
                        <a href="<?php echo BASE_URL; ?>/projects/create" class="btn btn-primary">Create Your First Project</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Upcoming Commitments -->
        <div class="dashboard-section commitments">
            <div class="section-header">
                <h2><i class="fas fa-calendar-alt"></i> My Schedule</h2>
                <a href="<?php echo BASE_URL; ?>/events" class="view-all">View Calendar</a>
            </div>
            <div class="commitments-list">
                <div class="commitment-item upcoming">
                    <div class="commitment-time">
                        <span class="time">2:00 PM</span>
                        <span class="date">Today</span>
                    </div>
                    <div class="commitment-details">
                        <h4>Tech Workshop</h4>
                        <p>AI and Machine Learning fundamentals</p>
                        <span class="location"><i class="fas fa-map-marker-alt"></i> Lab 201</span>
                    </div>
                    <div class="commitment-actions">
                        <button class="btn-attending">Attending</button>
                    </div>
                </div>

                <div class="commitment-item upcoming">
                    <div class="commitment-time">
                        <span class="time">10:00 AM</span>
                        <span class="date">Tomorrow</span>
                    </div>
                    <div class="commitment-details">
                        <h4>Project Meeting</h4>
                        <p>AI Research Initiative weekly sync</p>
                        <span class="location"><i class="fas fa-map-marker-alt"></i> Conference Room A</span>
                    </div>
                    <div class="commitment-actions">
                        <button class="btn-attending">Attending</button>
                    </div>
                </div>

                <div class="commitment-item past">
                    <div class="commitment-time">
                        <span class="time">3:00 PM</span>
                        <span class="date">Yesterday</span>
                    </div>
                    <div class="commitment-details">
                        <h4>IoT Workshop</h4>
                        <p>Sensor programming and integration</p>
                        <span class="location"><i class="fas fa-map-marker-alt"></i> Lab 305</span>
                    </div>
                    <div class="commitment-actions">
                        <span class="attended-badge">Attended</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achievements & Badges -->
        <div class="dashboard-section achievements">
            <div class="section-header">
                <h2><i class="fas fa-medal"></i> Achievements</h2>
                <a href="#" class="view-all">View All</a>
            </div>
            <div class="badges-grid">
                <div class="badge-item earned">
                    <div class="badge-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div class="badge-info">
                        <h4>Innovator</h4>
                        <p>Completed 5+ projects</p>
                    </div>
                </div>

                <div class="badge-item earned">
                    <div class="badge-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="badge-info">
                        <h4>Team Player</h4>
                        <p>Collaborated on 10+ team projects</p>
                    </div>
                </div>

                <div class="badge-item earned">
                    <div class="badge-icon">
                        <i class="fas fa-calendar-star"></i>
                    </div>
                    <div class="badge-info">
                        <h4>Regular Attendee</h4>
                        <p>Attended 20+ club events</p>
                    </div>
                </div>

                <div class="badge-item locked">
                    <div class="badge-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="badge-info">
                        <h4>Project Leader</h4>
                        <p>Lead a project to completion</p>
                        <span class="progress">2/3 complete</span>
                    </div>
                </div>

                <div class="badge-item locked">
                    <div class="badge-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="badge-info">
                        <h4>Top Contributor</h4>
                        <p>100+ hours of contribution</p>
                        <span class="progress">85/100 hours</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-section quick-actions">
            <div class="section-header">
                <h2><i class="fas fa-rocket"></i> Quick Actions</h2>
            </div>
            <div class="action-grid">
                <a href="<?php echo BASE_URL; ?>/projects" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div class="action-content">
                        <h4>Join Project</h4>
                        <p>Find and join new projects</p>
                    </div>
                </a>

                <a href="<?php echo BASE_URL; ?>/events" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <div class="action-content">
                        <h4>Register Event</h4>
                        <p>Sign up for upcoming events</p>
                    </div>
                </a>

                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div class="action-content">
                        <h4>Find Teammates</h4>
                        <p>Connect with other members</p>
                    </div>
                </a>

                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <div class="action-content">
                        <h4>Get Help</h4>
                        <p>Ask questions and get support</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.member-dashboard {
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

.dashboard-header {
    text-align: center;
    margin-bottom: 40px;
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

/* Progress Overview */
.progress-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.progress-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.07);
    border: 1px solid #ecf0f1;
    display: flex;
    align-items: center;
    gap: 25px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.progress-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.1);
}

.progress-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 28px;
}

.progress-content h3 {
    margin: 0 0 10px 0;
    color: #2c3e50;
    font-size: 1.1rem;
}

.progress-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #667eea;
    margin: 0 0 5px 0;
}

.progress-desc {
    color: #7f8c8d;
    font-size: 0.9rem;
}

/* Dashboard Content */
.dashboard-content {
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
    justify-content: space-between;
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

/* My Projects */
.projects-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.project-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border: 1px solid #ecf0f1;
    border-radius: 10px;
    transition: box-shadow 0.3s ease;
}

.project-item:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.project-info h4 {
    margin: 0 0 5px 0;
    color: #2c3e50;
    font-size: 1.1rem;
}

.project-info p {
    margin: 0 0 10px 0;
    color: #7f8c8d;
    font-size: 0.9rem;
}

.project-meta {
    display: flex;
    gap: 15px;
    font-size: 0.8rem;
    color: #95a5a6;
}

.project-status {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-badge.active {
    background: #d4edda;
    color: #155724;
}

.status-badge.completed {
    background: #d1ecf1;
    color: #0c5460;
}

.progress-circle {
    position: relative;
}

.progress-circle svg {
    transform: rotate(-90deg);
}

.progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.7rem;
    font-weight: 600;
    color: #2c3e50;
}

.completion-check {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #28a745;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

/* Commitments */
.commitments-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.commitment-item {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    border-radius: 10px;
    transition: background 0.3s ease;
}

.commitment-item.upcoming {
    background: #f8f9fa;
    border-left: 4px solid #667eea;
}

.commitment-item.past {
    background: #f8f9fa;
    border-left: 4px solid #95a5a6;
    opacity: 0.7;
}

.commitment-time {
    min-width: 80px;
    text-align: center;
}

.commitment-time .time {
    display: block;
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
}

.commitment-time .date {
    display: block;
    font-size: 0.8rem;
    color: #7f8c8d;
    margin-top: 2px;
}

.commitment-details h4 {
    margin: 0 0 5px 0;
    color: #2c3e50;
    font-size: 1rem;
}

.commitment-details p {
    margin: 0 0 5px 0;
    color: #7f8c8d;
    font-size: 0.85rem;
}

.location {
    color: #95a5a6;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

.commitment-actions {
    margin-left: auto;
}

.btn-attending {
    background: #28a745;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn-attending:hover {
    background: #218838;
}

.attended-badge {
    background: #6c757d;
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Achievements */
.badges-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.badge-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

.badge-item.earned {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border: 2px solid #28a745;
}

.badge-item.locked {
    background: #f8f9fa;
    border: 2px solid #dee2e6;
    opacity: 0.6;
}

.badge-item.earned:hover {
    transform: translateY(-2px);
}

.badge-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.badge-item.earned .badge-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.badge-item.locked .badge-icon {
    background: #dee2e6;
    color: #6c757d;
}

.badge-info h4 {
    margin: 0 0 3px 0;
    color: #2c3e50;
    font-size: 1rem;
}

.badge-info p {
    margin: 0 0 5px 0;
    color: #7f8c8d;
    font-size: 0.8rem;
}

.badge-info .progress {
    color: #667eea;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Quick Actions */
.action-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.action-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid #ecf0f1;
}

.action-card:hover {
    background: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
    border-color: #667eea;
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

.action-content h4 {
    margin: 0 0 3px 0;
    color: #2c3e50;
    font-size: 1rem;
}

.action-content p {
    margin: 0;
    color: #7f8c8d;
    font-size: 0.8rem;
}

/* Responsive */
@media (max-width: 1024px) {
    .dashboard-content {
        grid-template-columns: 1fr;
    }

    .progress-overview {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}

@media (max-width: 768px) {
    .member-dashboard {
        padding: 15px;
    }

    .progress-overview {
        grid-template-columns: 1fr;
    }

    .action-grid {
        grid-template-columns: 1fr;
    }

    .project-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .commitment-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .badges-grid {
        grid-template-columns: 1fr;
    }
}
</style>
