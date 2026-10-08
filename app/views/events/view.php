<div class="event-view-page">
    <div class="page-header">
        <div class="event-title-section">
            <h1><i class="fas fa-calendar-alt"></i> <?php echo htmlspecialchars($event['title'] ?? 'Event Details'); ?></h1>
            <div class="event-meta">
                <span class="event-type <?php echo 'event-type-' . strtolower($event['event_type'] ?? 'meeting'); ?>">
                    <i class="fas fa-tag"></i> <?php echo ucfirst($event['event_type'] ?? 'Meeting'); ?>
                </span>
                <span class="event-status <?php echo 'status-' . strtolower($event['status'] ?? 'upcoming'); ?>">
                    <i class="fas fa-circle"></i> <?php echo ucfirst($event['status'] ?? 'Upcoming'); ?>
                </span>
            </div>
        </div>
        <div class="event-actions">
            <?php if (($_SESSION['role'] ?? 'member') !== 'member'): ?>
                <a href="<?php echo BASE_URL; ?>/events/edit/<?php echo $event['id']; ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Event
                </a>
                <a href="<?php echo BASE_URL; ?>/events/delete/<?php echo $event['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event? This action cannot be undone.');">
                    <i class="fas fa-trash"></i> Delete Event
                </a>
            <?php endif; ?>
            <a href="<?php echo BASE_URL; ?>/events" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Events
            </a>
        </div>
    </div>

    <div class="event-content">
        <div class="event-details-grid">
            <!-- Event Information -->
            <div class="event-info-card">
                <h3><i class="fas fa-info-circle"></i> Event Information</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label><i class="fas fa-calendar"></i> Date & Time</label>
                        <span><?php
                            $eventDate = $event['event_date'] ?? '';
                            $eventTime = $event['start_time'] ?? '';
                            if ($eventDate && $eventTime) {
                                echo date('F j, Y \a\t g:i A', strtotime($eventDate . ' ' . $eventTime));
                            } elseif ($eventDate) {
                                echo date('F j, Y', strtotime($eventDate));
                            } else {
                                echo 'TBD';
                            }
                        ?></span>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-map-marker-alt"></i> Location</label>
                        <span><?php echo htmlspecialchars($event['location'] ?? 'TBD'); ?></span>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-users"></i> Capacity</label>
                        <span><?php echo $event['capacity'] ?? 'Unlimited'; ?> attendees</span>
                    </div>
                    <div class="info-item">
                        <label><i class="fas fa-user-tie"></i> Organizer</label>
                        <span><?php echo htmlspecialchars($event['organizer'] ?? 'Innovation Club'); ?></span>
                    </div>
                </div>
            </div>

            <!-- Event Description -->
            <div class="event-description-card">
                <h3><i class="fas fa-align-left"></i> Description</h3>
                <div class="description-content">
                    <?php echo nl2br(htmlspecialchars($event['description'] ?? 'No description available.')); ?>
                </div>
            </div>

            <!-- Registration Status -->
            <div class="event-registration-card">
                <h3><i class="fas fa-user-check"></i> Registration</h3>
                <div class="registration-info">
                    <div class="registration-stats">
                        <div class="stat-item">
                            <span class="stat-number"><?php echo $event['registered_count'] ?? 0; ?></span>
                            <span class="stat-label">Registered</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">
                                <?php
                                $capacity = $event['capacity'] ?? 0;
                                $registered = $event['registered_count'] ?? 0;
                                echo $capacity > 0 ? max(0, $capacity - $registered) : '∞';
                                ?>
                            </span>
                            <span class="stat-label">Spots Left</span>
                        </div>
                    </div>
                    <div class="registration-actions">
                        <?php
                        $userRole = $_SESSION['role'] ?? 'member';
                        $isRegistered = $event['is_registered'] ?? false;
                        // Keep backward compatibility for events created before allow_registration existed.
                        $allowRegistration = array_key_exists('allow_registration', $event)
                            ? (bool)$event['allow_registration']
                            : true;
                        $eventStatus = strtolower((string)($event['status'] ?? 'scheduled'));
                        $canRegisterByStatus = in_array($eventStatus, ['upcoming', 'scheduled'], true);

                        if ($userRole === 'member') {
                            if ($isRegistered) {
                                // Member is registered - show unregister option
                                echo '<button class="btn btn-danger" onclick="unregisterFromEvent(' . $event['id'] . ')">
                                        <i class="fas fa-minus"></i> Unregister
                                      </button>';
                            } elseif ($allowRegistration && $canRegisterByStatus) {
                                // Member can register
                                $capacity = isset($event['capacity']) ? (int)$event['capacity'] : 0;
                                $spotsLeft = $capacity - ($event['registered_count'] ?? 0);
                                $canRegister = $capacity > 0 ? $spotsLeft > 0 : true;

                                if ($canRegister) {
                                    echo '<button class="btn btn-primary" onclick="registerForEvent(' . $event['id'] . ')">
                                            <i class="fas fa-plus"></i> Register for Event
                                          </button>';
                                } else {
                                    echo '<button class="btn btn-secondary" disabled>
                                            <i class="fas fa-users"></i> Event Full
                                          </button>';
                                }
                            } else {
                                // Registration not available
                                echo '<button class="btn btn-secondary" disabled>
                                        <i class="fas fa-clock"></i> Registration Closed
                                      </button>';
                            }
                        } else {
                            // Admin/Patron - show registration management
                            echo '<div class="admin-registration-info">
                                    <small>As ' . ucfirst($userRole) . ', you have full access to manage this event.</small>
                                  </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendees List (if any) -->
        <?php if (!empty($event['attendees'])): ?>
        <div class="attendees-section">
            <h3><i class="fas fa-users"></i> Registered Attendees</h3>
            <div class="attendees-list">
                <?php foreach ($event['attendees'] as $attendee): ?>
                <div class="attendee-item">
                    <div class="attendee-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="attendee-info">
                        <?php $attendeeName = $attendee['full_name'] ?? ($attendee['username'] ?? 'Member'); ?>
                        <span class="attendee-name"><?php echo htmlspecialchars($attendeeName); ?></span>
                        <span class="attendee-role"><?php echo htmlspecialchars($attendee['role'] ?? 'Member'); ?></span>
                    </div>
                    <span class="registration-date"><?php echo date('M j', strtotime($attendee['registered_at'])); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function registerForEvent(eventId) {
    if (confirm('Are you sure you want to register for this event?')) {
        window.location.href = '<?php echo BASE_URL; ?>/events/register/' + eventId;
    }
}

function unregisterFromEvent(eventId) {
    if (confirm('Are you sure you want to unregister from this event?')) {
        window.location.href = '<?php echo BASE_URL; ?>/events/unregister/' + eventId;
    }
}
</script>
