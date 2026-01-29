<div class="form-page">
    <div class="page-header">
        <h1><i class="fas fa-user-plus"></i> <?php echo $title; ?></h1>
        <a href="<?php echo BASE_URL; ?>/members" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Members
        </a>
    </div>
    
    <div class="form-container">
        <form method="POST" action="<?php echo BASE_URL; ?>/members/create">
            <div class="form-row">
                <div class="form-group">
                    <label for="full_name"><i class="fas fa-user"></i> Full Name *</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                
                <div class="form-group">
                    <label for="student_id"><i class="fas fa-id-card"></i> Student ID *</label>
                    <input type="text" id="student_id" name="student_id" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
                    <input type="tel" id="phone" name="phone">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="department"><i class="fas fa-building"></i> Department *</label>
                    <select id="department" name="department" required>
                        <option value="">Select Department</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Software Engineering">Software Engineering</option>
                        <option value="Electrical Engineering">Electrical Engineering</option>
                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                        <option value="Business Administration">Business Administration</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="year_of_study"><i class="fas fa-graduation-cap"></i> Year of Study *</label>
                    <select id="year_of_study" name="year_of_study" required>
                        <option value="">Select Year</option>
                        <option value="Year 1">Year 1</option>
                        <option value="Year 2">Year 2</option>
                        <option value="Year 3">Year 3</option>
                        <option value="Year 4">Year 4</option>
                    </select>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Member
                </button>
            </div>
        </form>
    </div>
</div>
