<?php include_once APP_PATH . '/views/layouts/header.php'; ?>
<?php
$summary = $report_data['summary'] ?? [];
$membersByDepartment = $report_data['members_by_department'] ?? ($report_data['by_department'] ?? []);
$membersByYear = $report_data['members_by_year'] ?? ($report_data['by_year'] ?? []);
$recentMembers = $report_data['recent_members'] ?? [];

$totalMembers = (int)($summary['total_members'] ?? 0);
$activeMembers = (int)($summary['active_members'] ?? 0);
$newThisMonth = (int)($summary['new_this_month'] ?? 0);

$yearValues = [];
foreach ($membersByYear as $yearItem) {
    $yearLabel = $yearItem['year'] ?? ($yearItem['year_of_study'] ?? '');
    if (preg_match('/(\d+)/', (string)$yearLabel, $matches)) {
        $yearValues[] = (int)$matches[1];
    }
}
$avgYear = !empty($yearValues) ? round(array_sum($yearValues) / count($yearValues), 1) : 0;
?>

<div class="container">
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-users"></i> Members Report</h1>
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
                    <label for="department">Department</label>
                    <select id="department" name="department">
                        <option value="">All Departments</option>
                        <option value="Computer Science" <?php echo ($filters['department'] ?? '') === 'Computer Science' ? 'selected' : ''; ?>>Computer Science</option>
                        <option value="Information Technology" <?php echo ($filters['department'] ?? '') === 'Information Technology' ? 'selected' : ''; ?>>Information Technology</option>
                        <option value="Electrical Engineering" <?php echo ($filters['department'] ?? '') === 'Electrical Engineering' ? 'selected' : ''; ?>>Electrical Engineering</option>
                        <option value="Mechanical Engineering" <?php echo ($filters['department'] ?? '') === 'Mechanical Engineering' ? 'selected' : ''; ?>>Mechanical Engineering</option>
                        <option value="Civil Engineering" <?php echo ($filters['department'] ?? '') === 'Civil Engineering' ? 'selected' : ''; ?>>Civil Engineering</option>
                        <option value="Business Administration" <?php echo ($filters['department'] ?? '') === 'Business Administration' ? 'selected' : ''; ?>>Business Administration</option>
                        <option value="Other" <?php echo ($filters['department'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" <?php echo ($filters['status'] ?? '') === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo ($filters['status'] ?? '') === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        <option value="suspended" <?php echo ($filters['status'] ?? '') === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="year">Year</label>
                    <select id="year" name="year">
                        <option value="">All Years</option>
                        <?php for ($y = date('Y'); $y >= date('Y') - 4; $y--): ?>
                            <option value="<?php echo $y; ?>" <?php echo ($filters['year'] ?? '') == $y ? 'selected' : ''; ?>><?php echo $y; ?></option>
                        <?php endfor; ?>
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
                <i class="fas fa-users"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $report_data['summary']['total_members']; ?></h3>
                <p>Total Members</p>
            </div>
        </div>

        <div class="summary-card">
            <div class="card-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $activeMembers; ?></h3>
                <p>Active Members</p>
            </div>
        </div>

        <div class="summary-card">
            <div class="card-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $avgYear; ?></h3>
                <p>Average Year</p>
            </div>
        </div>

        <div class="summary-card">
            <div class="card-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $newThisMonth; ?></h3>
                <p>New This Month</p>
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
        <!-- Members by Department -->
        <div class="report-section">
            <h2><i class="fas fa-building"></i> Members by Department</h2>
            <div class="chart-container">
                <canvas id="membersByDepartmentChart"></canvas>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($membersByDepartment)): ?>
                            <?php foreach ($membersByDepartment as $dept): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($dept['department']); ?></td>
                                    <td><?php echo $dept['count']; ?></td>
                                    <td><?php echo $totalMembers > 0 ? round(($dept['count'] / $totalMembers) * 100, 1) : 0; ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No department data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Members by Year -->
        <div class="report-section">
            <h2><i class="fas fa-graduation-cap"></i> Members by Year</h2>
            <div class="chart-container">
                <canvas id="membersByYearChart"></canvas>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($membersByYear)): ?>
                            <?php foreach ($membersByYear as $year): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($year['year'] ?? ($year['year_of_study'] ?? 'N/A')); ?></td>
                                    <td><?php echo $year['count']; ?></td>
                                    <td><?php echo $totalMembers > 0 ? round(($year['count'] / $totalMembers) * 100, 1) : 0; ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No year data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Members -->
        <div class="report-section">
            <h2><i class="fas fa-clock"></i> Recent Members</h2>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Year</th>
                            <th>Status</th>
                            <th>Join Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentMembers)): ?>
                            <?php foreach ($recentMembers as $member): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($member['full_name'] ?? trim(($member['first_name'] ?? '') . ' ' . ($member['last_name'] ?? ''))); ?></td>
                                    <td><?php echo htmlspecialchars($member['department'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($member['year_of_study'] ?? ($member['year'] ?? 'N/A')); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo htmlspecialchars($member['status'] ?? 'inactive'); ?>">
                                            <?php echo ucfirst(htmlspecialchars($member['status'] ?? 'inactive')); ?>
                                        </span>
                                    </td>
                                    <td><?php echo !empty($member['join_date']) ? date('M d, Y', strtotime($member['join_date'])) : (!empty($member['created_at']) ? date('M d, Y', strtotime($member['created_at'])) : 'N/A'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No recent members data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Member Activity -->
        <div class="report-section">
            <h2><i class="fas fa-chart-line"></i> Member Activity</h2>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Events Attended</th>
                            <th>Projects Joined</th>
                            <th>Last Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($report_data['member_activity'])): ?>
                            <?php foreach ($report_data['member_activity'] as $activity): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($activity['first_name'] . ' ' . $activity['last_name']); ?></td>
                                    <td><?php echo $activity['events_attended']; ?></td>
                                    <td><?php echo $activity['projects_joined']; ?></td>
                                    <td><?php echo $activity['last_activity'] ? date('M d, Y', strtotime($activity['last_activity'])) : 'Never'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No activity data available.</td>
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
// Members by Department Chart
<?php if (!empty($membersByDepartment)): ?>
const membersByDepartmentData = <?php echo json_encode($membersByDepartment); ?>;

const deptCtx = document.getElementById('membersByDepartmentChart').getContext('2d');
new Chart(deptCtx, {
    type: 'bar',
    data: {
        labels: membersByDepartmentData.map(item => item.department),
        datasets: [{
            label: 'Members',
            data: membersByDepartmentData.map(item => item.count),
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

// Members by Year Chart
<?php if (!empty($membersByYear)): ?>
const membersByYearData = <?php echo json_encode($membersByYear); ?>;

const yearCtx = document.getElementById('membersByYearChart').getContext('2d');
new Chart(yearCtx, {
    type: 'line',
    data: {
        labels: membersByYearData.map(item => item.year || item.year_of_study),
        datasets: [{
            label: 'Members',
            data: membersByYearData.map(item => item.count),
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderColor: '#667eea',
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

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-inactive {
    background: #f8d7da;
    color: #721c24;
}

.status-suspended {
    background: #fff3cd;
    color: #856404;
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