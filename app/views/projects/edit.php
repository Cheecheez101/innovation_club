<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <div class="header-content">
            <h1><i class="fas fa-edit"></i> Edit Project</h1>
            <p class="page-subtitle">Update your project details and progress</p>
        </div>
        <div class="header-actions">
            <a href="<?php echo BASE_URL; ?>/projects/show/<?php echo $project['id']; ?>" class="btn btn-info">
                <i class="fas fa-eye"></i> View Project
            </a>
            <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
        </div>
    </div>

    <div class="edit-project-container">
        <form action="<?php echo BASE_URL; ?>/projects/edit/<?php echo $project['id']; ?>" method="POST" class="project-form" enctype="multipart/form-data">
            <!-- Basic Information -->
            <div class="form-section">
                <h3><i class="fas fa-info-circle"></i> Basic Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="title" class="required">
                            <i class="fas fa-tag"></i> Project Title
                        </label>
                        <input type="text" id="title" name="title" required
                               placeholder="e.g., Smart Campus Navigation App"
                               value="<?php echo htmlspecialchars($project['title'] ?? ''); ?>">
                        <small class="form-help">Choose a clear, descriptive name for your project</small>
                    </div>

                    <div class="form-group">
                        <label for="category">
                            <i class="fas fa-folder"></i> Category
                        </label>
                        <select id="category" name="category">
                            <option value="">Select a category</option>
                            <option value="Mobile Development" <?php echo ($project['category'] ?? '') === 'Mobile Development' ? 'selected' : ''; ?>>Mobile Development</option>
                            <option value="Web Development" <?php echo ($project['category'] ?? '') === 'Web Development' ? 'selected' : ''; ?>>Web Development</option>
                            <option value="IoT" <?php echo ($project['category'] ?? '') === 'IoT' ? 'selected' : ''; ?>>IoT</option>
                            <option value="AI/ML" <?php echo ($project['category'] ?? '') === 'AI/ML' ? 'selected' : ''; ?>>AI/ML</option>
                            <option value="Data Science" <?php echo ($project['category'] ?? '') === 'Data Science' ? 'selected' : ''; ?>>Data Science</option>
                            <option value="Cybersecurity" <?php echo ($project['category'] ?? '') === 'Cybersecurity' ? 'selected' : ''; ?>>Cybersecurity</option>
                            <option value="Game Development" <?php echo ($project['category'] ?? '') === 'Game Development' ? 'selected' : ''; ?>>Game Development</option>
                            <option value="Other" <?php echo ($project['category'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            <div class="form-section">
                <h3><i class="fas fa-align-left"></i> Project Description</h3>
                <div class="form-group">
                    <label for="description" class="required">
                        <i class="fas fa-file-alt"></i> Description
                    </label>
                    <textarea id="description" name="description" rows="4" required
                              placeholder="Describe your project in detail. What problem does it solve? Who will benefit from it?"><?php echo htmlspecialchars($project['description'] ?? ''); ?></textarea>
                    <small class="form-help">Provide a comprehensive description of your project</small>
                </div>

                <div class="form-group">
                    <label for="objectives">
                        <i class="fas fa-bullseye"></i> Objectives & Goals
                    </label>
                    <textarea id="objectives" name="objectives" rows="3"
                              placeholder="What are the main objectives of this project? What do you hope to achieve?"><?php echo htmlspecialchars($project['objectives'] ?? ''); ?></textarea>
                    <small class="form-help">List the specific goals and objectives you want to accomplish</small>
                </div>
            </div>

            <!-- Timeline & Budget -->
            <div class="form-section">
                <h3><i class="fas fa-calendar-alt"></i> Timeline & Budget</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="start_date">
                            <i class="fas fa-play"></i> Start Date
                        </label>
                        <input type="date" id="start_date" name="start_date"
                               value="<?php echo $project['start_date'] ?? ''; ?>">
                        <small class="form-help">When did you start working on this project?</small>
                    </div>

                    <div class="form-group">
                        <label for="expected_end_date">
                            <i class="fas fa-flag-checkered"></i> Expected End Date
                        </label>
                        <input type="date" id="expected_end_date" name="expected_end_date"
                               value="<?php echo $project['expected_end_date'] ?? ''; ?>">
                        <small class="form-help">When do you expect to complete this project?</small>
                    </div>

                    <div class="form-group">
                        <label for="budget">
                            <i class="fas fa-dollar-sign"></i> Estimated Budget
                        </label>
                        <input type="number" id="budget" name="budget" step="0.01" min="0"
                               placeholder="0.00" value="<?php echo $project['budget'] ?? ''; ?>">
                        <small class="form-help">Estimated cost in your local currency</small>
                    </div>

                    <div class="form-group">
                        <label for="status">
                            <i class="fas fa-tasks"></i> Project Status
                        </label>
                        <?php $currentStatus = strtolower((string)($project['status'] ?? 'idea')); ?>
                        <select id="status" name="status">
                            <option value="idea" <?php echo $currentStatus === 'idea' ? 'selected' : ''; ?>>Idea</option>
                            <option value="planning" <?php echo $currentStatus === 'planning' ? 'selected' : ''; ?>>Planning</option>
                            <option value="in_progress" <?php echo in_array($currentStatus, ['in_progress', 'ongoing'], true) ? 'selected' : ''; ?>>In Progress</option>
                            <option value="completed" <?php echo $currentStatus === 'completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="on_hold" <?php echo in_array($currentStatus, ['on_hold', 'on-hold'], true) ? 'selected' : ''; ?>>On Hold</option>
                        </select>
                        <small class="form-help">Current stage of your project</small>
                    </div>
                </div>
            </div>

            <!-- Project Leadership (for admins/patrons only) -->
            <?php if (($userRole ?? 'member') !== 'member'): ?>
            <div class="form-section">
                <h3><i class="fas fa-users"></i> Project Leadership</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="lead_member_id">
                            <i class="fas fa-user-tie"></i> Project Lead
                        </label>
                        <select id="lead_member_id" name="lead_member_id">
                            <option value="">Select project lead</option>
                            <!-- This would be populated with members from database -->
                            <option value="<?php echo $project['lead_member_id'] ?? ''; ?>" selected>
                                <?php echo htmlspecialchars($project['lead_member_name'] ?? 'Current Lead'); ?>
                            </option>
                        </select>
                        <small class="form-help">Who leads this project?</small>
                    </div>

                    <div class="form-group">
                        <label for="supervisor_id">
                            <i class="fas fa-user-shield"></i> Supervisor
                        </label>
                        <select id="supervisor_id" name="supervisor_id">
                            <option value="">Select supervisor (optional)</option>
                            <!-- This would be populated with supervisors from database -->
                            <option value="<?php echo $project['supervisor_id'] ?? ''; ?>" selected>
                                <?php echo htmlspecialchars($project['supervisor_name'] ?? 'Current Supervisor'); ?>
                            </option>
                        </select>
                        <small class="form-help">Faculty supervisor or mentor</small>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Additional Files (Optional) -->
            <div class="form-section">
                <h3><i class="fas fa-paperclip"></i> Additional Files (Optional)</h3>
                <div class="form-group">
                    <label for="project_files">
                        <i class="fas fa-upload"></i> Upload Additional Files
                    </label>
                    <input type="file" id="project_files" name="project_files[]" multiple
                           accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.zip,.rar">
                    <small class="form-help">Upload additional project files, updates, or documentation (Max 10MB per file)</small>
                </div>
            </div>

            <!-- Submit Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large">
                    <i class="fas fa-save"></i> Update Project
                </button>
                <a href="<?php echo BASE_URL; ?>/projects/show/<?php echo $project['id']; ?>" class="btn btn-info">
                    <i class="fas fa-eye"></i> View Project
                </a>
                <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
}

.header-content h1 {
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
}

.page-subtitle {
    color: #6c757d;
    margin: 0;
    font-size: 1rem;
}

.header-actions {
    display: flex;
    gap: 0.5rem;
}

.edit-project-container {
    max-width: 900px;
    margin: 0 auto;
}

.project-form {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.form-section {
    padding: 2rem;
    border-bottom: 1px solid #e9ecef;
}

.form-section:last-child {
    border-bottom: none;
}

.form-section h3 {
    margin: 0 0 1.5rem 0;
    color: #2c3e50;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-group label.required::after {
    content: '*';
    color: #dc3545;
    font-weight: bold;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.2s ease;
    background: white;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
    font-family: inherit;
}

.form-group select {
    cursor: pointer;
}

.form-help {
    display: block;
    margin-top: 0.25rem;
    color: #6c757d;
    font-size: 0.875rem;
}

.form-actions {
    padding: 2rem;
    background: #f8f9fa;
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,123,255,0.3);
}

.btn-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
}

.btn-info:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(23,162,184,0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-1px);
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .header-actions {
        justify-content: center;
    }

    .form-section {
        padding: 1.5rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .form-actions {
        flex-direction: column;
        padding: 1.5rem;
    }

    .btn {
        justify-content: center;
    }
}
</style>

<script>
// Form validation and enhancements
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.project-form');

    // Auto-resize textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });

    // Date validation
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('expected_end_date');

    function validateDates() {
        if (startDate.value && endDate.value) {
            if (new Date(startDate.value) >= new Date(endDate.value)) {
                endDate.setCustomValidity('End date must be after start date');
            } else {
                endDate.setCustomValidity('');
            }
        }
    }

    startDate.addEventListener('change', validateDates);
    endDate.addEventListener('change', validateDates);

    // File upload validation
    const fileInput = document.getElementById('project_files');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const files = this.files;
            const maxSize = 10 * 1024 * 1024; // 10MB
            let totalSize = 0;

            for (let file of files) {
                totalSize += file.size;
                if (file.size > maxSize) {
                    alert(`File "${file.name}" is too large. Maximum size is 10MB per file.`);
                    this.value = '';
                    return;
                }
            }

            if (totalSize > maxSize * 5) { // 50MB total
                alert('Total file size exceeds 50MB. Please reduce the number or size of files.');
                this.value = '';
            }
        });
    }

    // Character counter for description
    const description = document.getElementById('description');
    const counter = document.createElement('small');
    counter.className = 'form-help';
    counter.style.float = 'right';
    description.parentNode.appendChild(counter);

    function updateCounter() {
        const length = description.value.length;
        counter.textContent = `${length}/1000 characters`;
        counter.style.color = length > 900 ? '#dc3545' : '#6c757d';
    }

    description.addEventListener('input', updateCounter);
    updateCounter();
});
</script>
