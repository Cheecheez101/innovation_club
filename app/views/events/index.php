<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-calendar-alt"></i> Events</h1>
        <?php if (($_SESSION['role'] ?? 'member') !== 'member'): ?>
            <a href="<?php echo BASE_URL; ?>/events/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create Event
            </a>
        <?php endif; ?>
    </div>

    <div class="events-grid">
        <?php if (!empty($events)): ?>
            <?php foreach ($events as $event): ?>
                <div class="event-card">
                    <div class="event-header">
                        <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                        <span class="status status-<?php echo $event['status']; ?>">
                            <?php echo ucfirst($event['status']); ?>
                        </span>
                    </div>
                    <p><?php echo htmlspecialchars($event['description']); ?></p>
                    <div class="event-details">
                        <div class="detail-item">
                            <i class="fas fa-calendar"></i>
                            <?php echo date('M d, Y', strtotime($event['event_date'])); ?>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <?php
                                $time = $event['start_time'] ?? '';
                                echo $time ? date('H:i', strtotime($time)) : 'TBD';
                            ?>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo htmlspecialchars($event['venue']); ?>
                        </div>
                    </div>
                    <div class="event-footer">
                        <div class="actions">
                            <a href="<?php echo BASE_URL; ?>/events/show/<?php echo $event['id']; ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <?php if (($_SESSION['role'] ?? 'member') !== 'member'): ?>
                                <a href="<?php echo BASE_URL; ?>/events/edit/<?php echo $event['id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?php echo BASE_URL; ?>/events/delete/<?php echo $event['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event? This action cannot be undone.');">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-calendar-alt fa-3x"></i>
                <h3>No events yet</h3>
                <p>Start by creating your first club event!</p>
                <?php if (($_SESSION['role'] ?? 'member') !== 'member'): ?>
                    <a href="<?php echo BASE_URL; ?>/events/create" class="btn btn-primary">Create Event</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.page-header h1 {
    margin: 0;
}

.events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}

.event-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.event-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.event-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.event-header h3 {
    margin: 0;
    font-size: 1.2rem;
}

.status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-scheduled { background: #3498db; color: white; }
.status-ongoing { background: #f39c12; color: white; }
.status-completed { background: #27ae60; color: white; }
.status-cancelled { background: #e74c3c; color: white; }

.event-card p {
    padding: 1rem 1.5rem;
    margin: 0;
    color: #666;
}

.event-details {
    padding: 0 1.5rem;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #666;
    font-size: 0.9rem;
}

.event-footer {
    padding: 1rem 1.5rem;
    background: #f8f9fa;
    display: flex;
    justify-content: flex-end;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.btn-primary { background: #007bff; color: white; }
.btn-primary:hover { background: #0056b3; }

.btn-info { background: #17a2b8; color: white; }
.btn-info:hover { background: #138496; }

.btn-warning { background: #ffc107; color: #212529; }
.btn-warning:hover { background: #e0a800; }

.btn-danger { background: #dc3545; color: white; }
.btn-danger:hover { background: #c82333; }

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    color: #666;
}

.empty-state i {
    color: #ddd;
    margin-bottom: 1rem;
}
</style>