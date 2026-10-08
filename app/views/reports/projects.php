<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-project-diagram"></i> Projects Report</h1>
            <div class="header-actions">
                <a href="<?php echo BASE_URL; ?>/reports" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Reports
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="report-filters">
        <form method="GET" class="filters-form">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="">All Status</option>
                        <option value="planning" <?php echo ($filters['status'] ?? '') === 'planning' ? 'selected' : ''; ?>>Planning</option>
                        <option value="in_progress" <?php echo ($filters['status'] ?? '') === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="completed" <?php echo ($filters['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="on_hold" <?php echo ($filters['status'] ?? '') === 'on_hold' ? 'selected' : ''; ?>>On Hold</option>
                        <option value="cancelled" <?php echo ($filters['status'] ?? '') === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <option value="">All Categories</option>
                        <option value="web_development" <?php echo ($filters['category'] ?? '') === 'web_development' ? 'selected' : ''; ?>>Web Development</option>
                        <option value="mobile_app" <?php echo ($filters['category'] ?? '') === 'mobile_app' ? 'selected' : ''; ?>>Mobile App</option>
                        <option value="ai_ml" <?php echo ($filters['category'] ?? '') === 'ai_ml' ? 'selected' : ''; ?>>AI/ML</option>
                        <option value="iot" <?php echo ($filters['category'] ?? '') === 'iot' ? 'selected' : ''; ?>>IoT</option>
                        <option value="blockchain" <?php echo ($filters['category'] ?? '') === 'blockchain' ? 'selected' : ''; ?>>Blockchain</option>
                        <option value="other" <?php echo ($filters['category'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date"
                           value="<?php echo $filters['start_date'] ?? date('Y-m-d', strtotime('-180 days')); ?>">
                </div>
                <div class="filter-group">
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date"
                           value="<?php echo $filters['end_date'] ?? date('Y-m-d'); ?>">
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="card-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $report_data['summary']['total_projects']; ?></h3>
                <p>Total Projects</p>
            </div>
        </div>

        <div class="summary-card">
            <div class="card-icon">
                <i class="fas fa-play-circle"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $report_data['summary']['active_projects']; ?></h3>
                <p>Active Projects</p>
            </div>
        </div>

        <div class="summary-card">
            <div class="card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $report_data['summary']['completed_projects']; ?></h3>
                <p>Completed Projects</p>
            </div>
        </div>
    </div>

    <!-- Export Actions -->
    <div class="export-actions">
        <a href="?<?php echo http_build_query(array_merge($_GET, ['export' => 'csv'])); ?>" class="btn btn-success">
            <i class="fas fa-download"></i> Export to CSV
        </a>
    </div>

    <div class="report-grid">
        <!-- Projects by Status -->
        <div class="report-section">
            <h2><i class="fas fa-chart-pie"></i> Projects by Status</h2>
            <div class="chart-container">
                <canvas id="projectsByStatusChart"></canvas>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($report_data['projects_by_status'])): ?>
                            <?php foreach ($report_data['projects_by_status'] as $status): ?>
                                <tr>
                                    <td><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($status['status']))); ?></td>
                                    <td><?php echo $status['count']; ?></td>
                                    <td><?php echo round($status['percentage'], 1); ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No status data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Projects by Category -->
        <div class="report-section">
            <h2><i class="fas fa-tags"></i> Projects by Category</h2>
            <div class="chart-container">
                <canvas id="projectsByCategoryChart"></canvas>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($report_data['projects_by_category'])): ?>
                            <?php foreach ($report_data['projects_by_category'] as $category): ?>
                                <tr>
                                    <td><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($category['category']))); ?></td>
                                    <td><?php echo $category['count']; ?></td>
                                    <td><?php echo round($category['percentage'], 1); ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No category data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Projects -->
        <div class="report-section">
            <h2><i class="fas fa-clock"></i> Recent Projects</h2>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Project Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>Expected End Date</th>
                            <th>Budget</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($report_data['recent_projects'])): ?>
                            <?php foreach ($report_data['recent_projects'] as $project): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($project['title']); ?></td>
                                    <td><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($project['category']))); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $project['status']; ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($project['status']))); ?>
                                        </span>
                                    </td>
                                    <td><?php echo $project['start_date'] ? date('M d, Y', strtotime($project['start_date'])) : 'Not set'; ?></td>
                                    <td><?php echo $project['expected_end_date'] ? date('M d, Y', strtotime($project['expected_end_date'])) : 'Not set'; ?></td>
                                    <td>$<?php echo number_format($project['budget'] ?? 0, 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No recent projects data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Project Timeline -->
        <div class="report-section">
            <h2><i class="fas fa-calendar-alt"></i> Project Timeline</h2>
            <div class="chart-container">
                <canvas id="projectTimelineChart"></canvas>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Started</th>
                            <th>Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($report_data['project_timeline'])): ?>
                            <?php foreach ($report_data['project_timeline'] as $timeline): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($timeline['month']); ?></td>
                                    <td><?php echo $timeline['started']; ?></td>
                                    <td><?php echo $timeline['completed']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No timeline data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Projects by Status Chart
<?php if (!empty($report_data['projects_by_status'])): ?>
const projectsByStatusData = <?php echo json_encode($report_data['projects_by_status']); ?>;

const statusCtx = document.getElementById('projectsByStatusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: projectsByStatusData.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1).replace('_', ' ')),
        datasets: [{
            data: projectsByStatusData.map(item => item.count),
            backgroundColor: [
                '#667eea',
                '#764ba2',
                '#f093fb',
                '#f5576c',
                '#4facfe'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
<?php endif; ?>

// Projects by Category Chart
<?php if (!empty($report_data['projects_by_category'])): ?>
const projectsByCategoryData = <?php echo json_encode($report_data['projects_by_category']); ?>;

const categoryCtx = document.getElementById('projectsByCategoryChart').getContext('2d');
new Chart(categoryCtx, {
    type: 'bar',
    data: {
        labels: projectsByCategoryData.map(item => item.category.charAt(0).toUpperCase() + item.category.slice(1).replace('_', ' ')),
        datasets: [{
            label: 'Projects',
            data: projectsByCategoryData.map(item => item.count),
            backgroundColor: '#667eea',
            borderColor: '#5a67d8',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
<?php endif; ?>

// Project Timeline Chart
<?php if (!empty($report_data['project_timeline'])): ?>
const projectTimelineData = <?php echo json_encode($report_data['project_timeline']); ?>;

const timelineCtx = document.getElementById('projectTimelineChart').getContext('2d');
new Chart(timelineCtx, {
    type: 'line',
    data: {
        labels: projectTimelineData.map(item => item.month),
        datasets: [{
            label: 'Started',
            data: projectTimelineData.map(item => item.started),
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 2,
            fill: true
        }, {
            label: 'Completed',
            data: projectTimelineData.map(item => item.completed),
            borderColor: '#48bb78',
            backgroundColor: 'rgba(72, 187, 120, 0.1)',
            borderWidth: 2,
            fill: true
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
<?php endif; ?>
</script>

<style>
.page-header {
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-content h1 {
    margin: 0;
    color: #2c3e50;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

.report-filters {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.filters-form {
    width: 100%;
}

.filter-row {
    display: flex;
    gap: 1rem;
    align-items: end;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.filter-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #495057;
}

.filter-group input,
.filter-group select {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 1rem;
}

.summary-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.summary-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.card-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.card-content h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
}

.card-content p {
    margin: 0.25rem 0 0 0;
    color: #6c757d;
    font-size: 0.9rem;
}

.export-actions {
    margin-bottom: 2rem;
    text-align: right;
}

.report-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.report-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.report-section h2 {
    margin: 0 0 1.5rem 0;
    color: #2c3e50;
    font-size: 1.5rem;
}

.chart-container {
    margin-bottom: 2rem;
    height: 300px;
}

.table-container {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #e1e5e9;
}

.table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #495057;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-planning {
    background: #e2e8f0;
    color: #2d3748;
}

.status-in_progress {
    background: #bee3f8;
    color: #2b6cb0;
}

.status-completed {
    background: #c6f6d5;
    color: #22543d;
}

.status-on_hold {
    background: #fef5e7;
    color: #744210;
}

.status-cancelled {
    background: #fed7d7;
    color: #742a2a;
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    transition: width 0.3s ease;
}

.progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
}

.text-center {
    text-align: center;
    color: #6c757d;
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .filter-row {
        flex-direction: column;
        gap: 1rem;
    }

    .summary-cards {
        grid-template-columns: 1fr;
    }

    .report-grid {
        grid-template-columns: 1fr;
    }

    .table-container {
        overflow-x: auto;
    }

    .table {
        min-width: 600px;
    }
}
</style>