<div class="form-page">
    <div class="page-header">
        <h1><i class="fas fa-calendar-plus"></i> <?php echo $title; ?></h1>
        <a href="<?php echo BASE_URL; ?>/events" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Events
        </a>
    </div>

    <div class="form-container">
        <form method="POST" action="<?php echo BASE_URL; ?>/events/create" id="eventForm">
            <div class="form-section">
                <h3><i class="fas fa-info-circle"></i> Basic Information</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="title"><i class="fas fa-heading"></i> Event Title *</label>
                        <input type="text" id="title" name="title" required placeholder="Enter event title">
                    </div>

                    <div class="form-group">
                        <label for="event_type"><i class="fas fa-tag"></i> Event Type *</label>
                        <select id="event_type" name="event_type" required>
                            <option value="">Select Event Type</option>
                            <option value="meeting">Meeting</option>
                            <option value="workshop">Workshop</option>
                            <option value="competition">Competition</option>
                            <option value="exhibition">Exhibition</option>
                            <option value="seminar">Seminar</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description"><i class="fas fa-align-left"></i> Description *</label>
                    <textarea id="description" name="description" rows="4" required placeholder="Describe the event..."></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3><i class="fas fa-calendar"></i> Date & Time</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="event_date"><i class="fas fa-calendar-day"></i> Event Date *</label>
                        <input type="date" id="event_date" name="event_date" required>
                    </div>

                    <div class="form-group">
                        <label for="event_time"><i class="fas fa-clock"></i> Event Time *</label>
                        <input type="time" id="event_time" name="event_time" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="duration"><i class="fas fa-hourglass-half"></i> Duration (hours)</label>
                        <input type="number" id="duration" name="duration" min="0.5" step="0.5" placeholder="2.5">
                    </div>

                    <div class="form-group">
                        <label for="timezone"><i class="fas fa-globe"></i> Timezone</label>
                        <select id="timezone" name="timezone">
                            <option value="UTC+3">East Africa Time (UTC+3)</option>
                            <option value="UTC+0">GMT (UTC+0)</option>
                            <option value="UTC+1">CET (UTC+1)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3><i class="fas fa-map-marker-alt"></i> Location & Capacity</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="location"><i class="fas fa-map-marker-alt"></i> Location *</label>
                        <input type="text" id="location" name="location" required placeholder="Venue or virtual link">
                    </div>

                    <div class="form-group">
                        <label for="capacity"><i class="fas fa-users"></i> Capacity</label>
                        <input type="number" id="capacity" name="capacity" min="1" placeholder="Maximum attendees">
                    </div>
                </div>

                <div class="form-group">
                    <label for="venue_details"><i class="fas fa-building"></i> Venue Details</label>
                    <textarea id="venue_details" name="venue_details" rows="2" placeholder="Additional location information..."></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3><i class="fas fa-cog"></i> Additional Settings</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="organizer"><i class="fas fa-user-tie"></i> Organizer</label>
                        <input type="text" id="organizer" name="organizer" placeholder="Event organizer name">
                    </div>

                    <div class="form-group">
                        <label for="contact_email"><i class="fas fa-envelope"></i> Contact Email</label>
                        <input type="email" id="contact_email" name="contact_email" placeholder="contact@example.com">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="registration_deadline"><i class="fas fa-calendar-times"></i> Registration Deadline</label>
                        <input type="date" id="registration_deadline" name="registration_deadline">
                    </div>

                    <div class="form-group">
                        <label for="cost"><i class="fas fa-dollar-sign"></i> Cost (if any)</label>
                        <input type="number" id="cost" name="cost" min="0" step="0.01" placeholder="0.00">
                    </div>
                </div>

                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="is_public" name="is_public" checked>
                        <span class="checkmark"></span>
                        Make this event public (visible to all users)
                    </label>
                </div>

                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="allow_registration" name="allow_registration" checked>
                        <span class="checkmark"></span>
                        Allow online registration
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calendar-plus"></i> Create Event
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('eventForm').addEventListener('submit', function(e) {
    // Basic validation
    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();
    const eventDate = document.getElementById('event_date').value;
    const location = document.getElementById('location').value.trim();

    if (!title || !description || !eventDate || !location) {
        e.preventDefault();
        alert('Please fill in all required fields.');
        return;
    }

    // Check if event date is in the future
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const selectedDate = new Date(eventDate);

    if (selectedDate < today) {
        e.preventDefault();
        alert('Event date must be in the future.');
        return;
    }

    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
    submitBtn.disabled = true;

    // Re-enable after a delay (in case of error)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 5000);
});

// Set minimum date to today
document.getElementById('event_date').min = new Date().toISOString().split('T')[0];

// Auto-set registration deadline to 1 week before event
document.getElementById('event_date').addEventListener('change', function() {
    const eventDate = new Date(this.value);
    const deadlineDate = new Date(eventDate);
    deadlineDate.setDate(eventDate.getDate() - 7);

    const deadlineInput = document.getElementById('registration_deadline');
    if (deadlineDate > new Date()) {
        deadlineInput.value = deadlineDate.toISOString().split('T')[0];
    }
});
</script>
