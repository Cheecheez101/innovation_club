<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-chart-line"></i> Reports</h1>
    </div>

    <div class="reports-grid">
        <?php if (!empty($reports)): ?>
            <?php foreach ($reports as $report): ?>
                <div class="report-card">
                    <div class="report-icon">
                        <i class="<?php echo $report['icon']; ?>"></i>
                    </div>
                    <h3><?php echo htmlspecialchars($report['title']); ?></h3>
                    <p><?php echo htmlspecialchars($report['description']); ?></p>
                    <a href="<?php echo $report['url']; ?>" class="btn btn-primary">
                        <i class="fas fa-eye"></i> View Report
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-chart-line fa-3x"></i>
                <h3>No reports available</h3>
                <p>Reports will be available once you have data in the system.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-header h1 {
    margin: 0;
    color: #2c3e50;
}

.reports-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.report-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e9ecef;
}

.report-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.report-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.report-card h3 {
    margin: 0 0 1rem 0;
    color: #2c3e50;
    font-size: 1.3rem;
}

.report-card p {
    color: #6c757d;
    margin: 0 0 1.5rem 0;
    line-height: 1.6;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    color: #6c757d;
}

.empty-state i {
    color: #dee2e6;
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    margin: 0 0 1rem 0;
    color: #495057;
}
</style>