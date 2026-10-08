<?php if (!defined('APP_PATH')) { header('Location: /innovation_club/public/'); exit; } ?>
<div class="dashboard patron-dashboard">
    <div class="dashboard-header">
        <h1><i class="fas fa-hand-holding-heart"></i> Patron Dashboard</h1>
        <p>Welcome back, <?php echo $user['name']; ?>! Thank you for your continued support.</p>
    </div>

    <!-- Impact Overview -->
    <div class="impact-overview">
        <div class="impact-card">
            <div class="impact-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="impact-content">
                <h3>Members Impacted</h3>
                <p class="impact-number"><?php echo $impact['members_helped'] ?? 0; ?></p>
                <span class="impact-desc">Students benefited from your sponsorship</span>
            </div>
        </div>

        <div class="impact-card">
            <div class="impact-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div class="impact-content">
                <h3>Projects Supported</h3>
                <p class="impact-number"><?php echo $impact['projects_supported'] ?? 0; ?></p>
                <span class="impact-desc">Innovation projects you've enabled</span>
            </div>
        </div>

        <div class="impact-card">
            <div class="impact-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="impact-content">
                <h3>Events Sponsored</h3>
                <p class="impact-number"><?php echo $impact['events_sponsored'] ?? 0; ?></p>
                <span class="impact-desc">Events made possible by your generosity</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-content">
        <!-- Sponsored Projects -->
        <div class="dashboard-section sponsored-projects">
            <div class="section-header">
                <h2><i class="fas fa-star"></i> Your Sponsored Projects</h2>
                <a href="<?php echo BASE_URL; ?>/projects" class="view-all">View All Projects</a>
            </div>
            <div class="projects-grid">
                <div class="project-card">
                    <div class="project-header">
                        <h4>AI Research Initiative</h4>
                        <span class="project-status active">Active</span>
                    </div>
                    <p>Developing machine learning solutions for local businesses</p>
                    <div class="project-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 75%"></div>
                        </div>
                        <span class="progress-text">75% Complete</span>
                    </div>
                    <div class="project-footer">
                        <span class="project-team">Team: 8 members</span>
                        <span class="project-deadline">Due: March 2026</span>
                    </div>
                </div>

                <div class="project-card">
                    <div class="project-header">
                        <h4>IoT Smart Campus</h4>
                        <span class="project-status active">Active</span>
                    </div>
                    <p>Implementing IoT solutions for energy efficiency</p>
                    <div class="project-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 60%"></div>
                        </div>
                        <span class="progress-text">60% Complete</span>
                    </div>
                    <div class="project-footer">
                        <span class="project-team">Team: 12 members</span>
                        <span class="project-deadline">Due: April 2026</span>
                    </div>
                </div>

                <div class="project-card">
                    <div class="project-header">
                        <h4>Mobile App Development</h4>
                        <span class="project-status completed">Completed</span>
                    </div>
                    <p>Student attendance and management system</p>
                    <div class="project-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 100%"></div>
                        </div>
                        <span class="progress-text">Completed</span>
                    </div>
                    <div class="project-footer">
                        <span class="project-team">Team: 6 members</span>
                        <span class="project-deadline">Completed: Jan 2026</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sponsored Events -->
        <div class="dashboard-section sponsored-events">
            <div class="section-header">
                <h2><i class="fas fa-calendar-star"></i> Events You've Sponsored</h2>
                <a href="<?php echo BASE_URL; ?>/events" class="view-all">View All Events</a>
            </div>
            <div class="events-list">
                <div class="event-card">
                    <div class="event-date-badge">
                        <span class="date">15</span>
                        <span class="month">Feb</span>
                    </div>
                    <div class="event-info">
                        <h4>Tech Innovation Workshop</h4>
                        <p>Hands-on workshop with industry experts</p>
                        <div class="event-meta">
                            <span><i class="fas fa-map-marker-alt"></i> Main Auditorium</span>
                            <span><i class="fas fa-clock"></i> 2:00 PM - 5:00 PM</span>
                            <span><i class="fas fa-users"></i> 85 attendees</span>
                        </div>
                    </div>
                </div>

                <div class="event-card">
                    <div class="event-date-badge">
                        <span class="date">22</span>
                        <span class="month">Feb</span>
                    </div>
                    <div class="event-info">
                        <h4>Club Annual Dinner</h4>
                        <p>Celebrating achievements and networking</p>
                        <div class="event-meta">
                            <span><i class="fas fa-map-marker-alt"></i> Grand Hall</span>
                            <span><i class="fas fa-clock"></i> 6:00 PM - 9:00 PM</span>
                            <span><i class="fas fa-users"></i> 120 attendees</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recognition & Impact -->
        <div class="dashboard-section recognition">
            <div class="section-header">
                <h2><i class="fas fa-award"></i> Your Impact & Recognition</h2>
            </div>
            <div class="recognition-content">
                <div class="recognition-item">
                    <div class="recognition-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="recognition-details">
                        <h4>Platinum Patron</h4>
                        <p>Highest level of sponsorship commitment</p>
                        <span class="recognition-date">Since January 2025</span>
                    </div>
                </div>

                <div class="recognition-item">
                    <div class="recognition-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="recognition-details">
                        <h4>Community Champion</h4>
                        <p>Recognized for outstanding community support</p>
                        <span class="recognition-date">Awarded December 2025</span>
                    </div>
                </div>

                <div class="recognition-item">
                    <div class="recognition-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="recognition-details">
                        <h4>Education Excellence</h4>
                        <p>Supporting STEM education initiatives</p>
                        <span class="recognition-date">Ongoing recognition</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions for Patrons -->
        <div class="dashboard-section patron-actions">
            <div class="section-header">
                <h2><i class="fas fa-hand-holding-usd"></i> Support the Club</h2>
            </div>
            <div class="action-buttons">
                <a href="#" class="action-btn primary">
                    <i class="fas fa-plus-circle"></i>
                    <span>Make a Donation</span>
                </a>
                <a href="#" class="action-btn secondary">
                    <i class="fas fa-calendar-plus"></i>
                    <span>Sponsor an Event</span>
                </a>
                <a href="#" class="action-btn secondary">
                    <i class="fas fa-project-diagram"></i>
                    <span>Fund a Project</span>
                </a>
                <a href="#" class="action-btn secondary">
                    <i class="fas fa-envelope"></i>
                    <span>Contact Club</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.patron-dashboard {
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

/* Impact Overview */
.impact-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.impact-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 30px;
    display: flex;
    align-items: center;
    gap: 25px;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    transition: transform 0.3s ease;
}

.impact-card:hover {
    transform: translateY(-5px);
}

.impact-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
}

.impact-content h3 {
    margin: 0 0 10px 0;
    font-size: 1.1rem;
    opacity: 0.9;
}

.impact-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 5px 0;
}

.impact-desc {
    font-size: 0.9rem;
    opacity: 0.8;
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

/* Sponsored Projects */
.projects-grid {
    display: grid;
    gap: 20px;
}

.project-card {
    border: 1px solid #ecf0f1;
    border-radius: 10px;
    padding: 20px;
    transition: box-shadow 0.3s ease;
}

.project-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.project-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.project-header h4 {
    margin: 0;
    color: #2c3e50;
    font-size: 1.1rem;
}

.project-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.project-status.active {
    background: #d4edda;
    color: #155724;
}

.project-status.completed {
    background: #d1ecf1;
    color: #0c5460;
}

.project-card p {
    color: #7f8c8d;
    margin: 0 0 15px 0;
    font-size: 0.9rem;
}

.project-progress {
    margin-bottom: 15px;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: #ecf0f1;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 5px;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 4px;
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 0.8rem;
    color: #7f8c8d;
    font-weight: 500;
}

.project-footer {
    display: flex;
    justify-content: space-between;
    font-size: 0.8rem;
    color: #95a5a6;
}

/* Sponsored Events */
.events-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.event-card {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    border: 1px solid #ecf0f1;
    border-radius: 10px;
    transition: box-shadow 0.3s ease;
}

.event-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.event-date-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 60px;
    padding: 10px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 10px;
    text-align: center;
}

.event-date-badge .date {
    font-size: 1.4rem;
    font-weight: 700;
}

.event-date-badge .month {
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
}

.event-info h4 {
    margin: 0 0 8px 0;
    color: #2c3e50;
    font-size: 1.1rem;
}

.event-info p {
    margin: 0 0 10px 0;
    color: #7f8c8d;
    font-size: 0.9rem;
}

.event-meta {
    display: flex;
    gap: 15px;
    font-size: 0.8rem;
    color: #95a5a6;
}

.event-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Recognition */
.recognition-content {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.recognition-item {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.recognition-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.recognition-details h4 {
    margin: 0 0 5px 0;
    color: #2c3e50;
    font-size: 1.1rem;
}

.recognition-details p {
    margin: 0 0 5px 0;
    color: #7f8c8d;
    font-size: 0.9rem;
}

.recognition-date {
    color: #3498db;
    font-size: 0.8rem;
    font-weight: 500;
}

/* Patron Actions */
.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 25px 20px;
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.3s ease;
    font-weight: 500;
    text-align: center;
}

.action-btn.primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.action-btn.primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

.action-btn.secondary {
    background: white;
    color: #2c3e50;
    border: 2px solid #ecf0f1;
}

.action-btn.secondary:hover {
    border-color: #667eea;
    color: #667eea;
    transform: translateY(-2px);
}

.action-btn i {
    font-size: 24px;
}

.action-btn span {
    font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 1024px) {
    .dashboard-content {
        grid-template-columns: 1fr;
    }

    .impact-overview {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}

@media (max-width: 768px) {
    .patron-dashboard {
        padding: 15px;
    }

    .impact-overview {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        grid-template-columns: 1fr;
    }

    .event-card {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }

    .event-meta {
        justify-content: center;
        flex-wrap: wrap;
    }
}
</style>
