<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1><i class="fas fa-user-edit"></i> Edit Member</h1>
        <p>Update member information</p>
    </div>

    <div class="form-container">
        <form action="<?php echo BASE_URL; ?>/members/edit/<?php echo $member['id']; ?>" method="POST" class="member-form">
            <div class="form-section">
                <h3><i class="fas fa-user"></i> Personal Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="full_name" class="required">
                            <i class="fas fa-user"></i> Full Name
                        </label>
                        <input type="text" id="full_name" name="full_name" required
                               placeholder="Enter full name" value="<?php echo htmlspecialchars($member['full_name']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="student_id" class="required">
                            <i class="fas fa-id-card"></i> Student ID
                        </label>
                        <input type="text" id="student_id" name="student_id" required
                               placeholder="e.g., CS001" value="<?php echo htmlspecialchars($member['student_id']); ?>">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="email" class="required">
                            <i class="fas fa-envelope"></i> Email Address
                        </label>
                        <input type="email" id="email" name="email" required
                               placeholder="student@eliteacademy.edu" value="<?php echo htmlspecialchars($member['email']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="phone">
                            <i class="fas fa-phone"></i> Phone Number
                        </label>
                        <input type="tel" id="phone" name="phone"
                               placeholder="+254 XXX XXX XXX" value="<?php echo htmlspecialchars($member['phone'] ?? ''); ?>">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3><i class="fas fa-graduation-cap"></i> Academic Information</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="department" class="required">
                            <i class="fas fa-building"></i> Department
                        </label>
                        <select id="department" name="department" required>
                            <option value="">Select Department</option>
                            <option value="Computer Science" <?php echo ($member['department'] ?? '') === 'Computer Science' ? 'selected' : ''; ?>>Computer Science</option>
                            <option value="Information Technology" <?php echo ($member['department'] ?? '') === 'Information Technology' ? 'selected' : ''; ?>>Information Technology</option>
                            <option value="Software Engineering" <?php echo ($member['department'] ?? '') === 'Software Engineering' ? 'selected' : ''; ?>>Software Engineering</option>
                            <option value="Business Administration" <?php echo ($member['department'] ?? '') === 'Business Administration' ? 'selected' : ''; ?>>Business Administration</option>
                            <option value="Mathematics" <?php echo ($member['department'] ?? '') === 'Mathematics' ? 'selected' : ''; ?>>Mathematics</option>
                            <option value="Physics" <?php echo ($member['department'] ?? '') === 'Physics' ? 'selected' : ''; ?>>Physics</option>
                            <option value="Other" <?php echo ($member['department'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="year_of_study" class="required">
                            <i class="fas fa-calendar-alt"></i> Year of Study
                        </label>
                        <select id="year_of_study" name="year_of_study" required>
                            <option value="">Select Year</option>
                            <option value="Year 1" <?php echo ($member['year_of_study'] ?? '') === 'Year 1' ? 'selected' : ''; ?>>Year 1</option>
                            <option value="Year 2" <?php echo ($member['year_of_study'] ?? '') === 'Year 2' ? 'selected' : ''; ?>>Year 2</option>
                            <option value="Year 3" <?php echo ($member['year_of_study'] ?? '') === 'Year 3' ? 'selected' : ''; ?>>Year 3</option>
                            <option value="Year 4" <?php echo ($member['year_of_study'] ?? '') === 'Year 4' ? 'selected' : ''; ?>>Year 4</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Member Information Display -->
            <div class="form-section">
                <h3><i class="fas fa-info-circle"></i> Member Details</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Member ID:</label>
                        <span><?php echo $member['id']; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Join Date:</label>
                        <span><?php echo date('F j, Y', strtotime($member['join_date'])); ?></span>
                    </div>
                    <div class="info-item">
                        <label>Status:</label>
                        <span class="status-badge status-<?php echo $member['status']; ?>">
                            <?php echo ucfirst($member['status']); ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Last Updated:</label>
                        <span><?php echo date('F j, Y \a\t g:i A', strtotime($member['updated_at'])); ?></span>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large">
                    <i class="fas fa-save"></i> Update Member
                </button>
                <a href="<?php echo BASE_URL; ?>/members" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.page-header {
    text-align: center;
    margin-bottom: 2rem;
}

.page-header h1 {
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.page-header p {
    color: #7f8c8d;
    font-size: 1.1rem;
}

.form-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.member-form {
    padding: 0;
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
    margin-bottom: 1.5rem;
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
.form-group select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.2s ease;
    background: white;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
}

.form-group select {
    cursor: pointer;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.info-item {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.info-item label {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.info-item span {
    color: #495057;
    font-size: 0.95rem;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
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

.status-alumni {
    background: #d1ecf1;
    color: #0c5460;
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
    .container {
        padding: 1rem;
    }

    .form-section {
        padding: 1.5rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .info-grid {
        grid-template-columns: 1fr;
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
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.member-form');

    // Form validation
    form.addEventListener('submit', function(e) {
        const studentId = document.getElementById('student_id').value.trim();
        const email = document.getElementById('email').value.trim();

        // Basic student ID validation (should contain some letters and numbers)
        if (!/^[A-Za-z]{1,4}\/\d{4}\/\d{2}$/.test(studentId) && !/^[A-Za-z]{2,3}\d{3}$/.test(studentId)) {
            alert('Please enter a valid student ID format (e.g., CS001 or CS/2024/01)');
            e.preventDefault();
            return false;
        }

        // Email validation
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            alert('Please enter a valid email address');
            e.preventDefault();
            return false;
        }
    });
});
</script>
