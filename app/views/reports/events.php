<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-calendar-alt"></i> Events Report</h1>
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
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date"
                           value="<?php echo $filters['start_date'] ?? date('Y-m-d', strtotime('-90 days')); ?>">
                </div>
                <div class="filter-group">
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date"
                           value="<?php echo $filters['end_date'] ?? date('Y-m-d'); ?>">
                </div>
                <div class="filter-group">
                    <label for="event_type">Event Type</label>
                    <select id="event_type" name="event_type">
                        <option value="">All Types</option>
                        <option value="meeting" <?php echo ($filters['event_type'] ?? '') === 'meeting' ? 'selected' : ''; ?>>Meeting</option>
                        <option value="workshop" <?php echo ($filters['event_type'] ?? '') === 'workshop' ? 'selected' : ''; ?>>Workshop</option>
                        <option value="competition" <?php echo ($filters['event_type'] ?? '') === 'competition' ? 'selected' : ''; ?>>Competition</option>
                        <option value="exhibition" <?php echo ($filters['event_type'] ?? '') === 'exhibition' ? 'selected' : ''; ?>>Exhibition</option>
                        <option value="other" <?php echo ($filters['event_type'] ?? '') === 'other' ? 'selected' : ''; ?>>Other</option>
                    </select>
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
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $report_data['summary']['total_events']; ?></h3>
                <p>Total Events</p>
            </div>
        </div>

        <div class="summary-card">
            <div class="card-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $report_data['summary']['upcoming_events']; ?></h3>
                <p>Upcoming Events</p>
            </div>
        </div>

        <div class="summary-card">
            <div class="card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $report_data['summary']['completed_events']; ?></h3>
                <p>Completed Events</p>
            </div>
        </div>

        <div class="summary-card">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $report_data['summary']['average_capacity']; ?></h3>
                <p>Average Capacity</p>
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
        <!-- Events by Type -->
        <div class="report-section">
            <h2><i class="fas fa-chart-pie"></i> Events by Type</h2>
            <div class="chart-container">
                <canvas id="eventsByTypeChart"></canvas>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Event Type</th>
                            <th>Count</th>
                            <th>Average Capacity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($report_data['events_by_type'])): ?>
                            <?php foreach ($report_data['events_by_type'] as $type): ?>
                                <tr>
                                    <td><?php echo ucfirst(htmlspecialchars($type['event_type'])); ?></td>
                                    <td><?php echo $type['count']; ?></td>
                                    <td><?php echo round($type['avg_capacity'] ?? 0, 1); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No event type data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Events -->
        <div class="report-section">
            <h2><i class="fas fa-history"></i> Recent Events</h2>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Event Title</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Capacity</th>
                            <th>Registered</th>
                            <th>Registration Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($report_data['recent_events'])): ?>
                            <?php foreach ($report_data['recent_events'] as $event): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                                    <td><?php echo ucfirst(htmlspecialchars($event['event_type'])); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($event['event_date'])); ?></td>
                                    <td><?php echo $event['max_participants'] ?: 'Unlimited'; ?></td>
                                    <td><?php echo $event['registered_count']; ?></td>
                                    <td>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: <?php echo min($event['registration_rate'] ?? 0, 100); ?>%"></div>
                                            <span class="progress-text"><?php echo round($event['registration_rate'] ?? 0, 1); ?>%</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No recent events data available.</td>
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
// Events by Type Chart
<?php if (!empty($report_data['events_by_type'])): ?>
const eventsByTypeData = <?php echo json_encode($report_data['events_by_type']); ?>;

const ctx = document.getElementById('eventsByTypeChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: eventsByTypeData.map(item => item.event_type.charAt(0).toUpperCase() + item.event_type.slice(1)),
        datasets: [{
            data: eventsByTypeData.map(item => item.count),
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
}

.filter-group {
    flex: 1;
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