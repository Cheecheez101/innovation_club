<?php include_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="container">
	<div class="page-header">
		<h1><i class="fas fa-user-cog"></i> My Profile</h1>
		<p>Update your personal details and account settings</p>
	</div>

	<div class="form-container">
		<form action="<?php echo BASE_URL; ?>/members/profile" method="POST" class="profile-form">
			<div class="form-section">
				<h3><i class="fas fa-user"></i> Account Information</h3>
				<div class="form-grid">
					<div class="form-group">
						<label for="username" class="required">Username</label>
						<input type="text" id="username" name="username" required
							   value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>">
					</div>

					<div class="form-group">
						<label for="email" class="required">Email</label>
						<input type="email" id="email" name="email" required
							   value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
					</div>
				</div>
			</div>

			<div class="form-section">
				<h3><i class="fas fa-id-card"></i> Member Details</h3>
				<div class="form-grid">
					<div class="form-group">
						<label for="full_name">Full Name</label>
						<input type="text" id="full_name" name="full_name"
							   value="<?php echo htmlspecialchars($member['full_name'] ?? ''); ?>">
					</div>

					<div class="form-group">
						<label for="student_id">Student ID</label>
						<input type="text" id="student_id" value="<?php echo htmlspecialchars($member['student_id'] ?? 'N/A'); ?>" disabled>
					</div>
				</div>

				<div class="form-grid">
					<div class="form-group">
						<label for="phone">Phone</label>
						<input type="text" id="phone" name="phone"
							   value="<?php echo htmlspecialchars($member['phone'] ?? ''); ?>">
					</div>

					<div class="form-group">
						<label for="department">Department</label>
						<input type="text" id="department" name="department"
							   value="<?php echo htmlspecialchars($member['department'] ?? ''); ?>">
					</div>
				</div>

				<div class="form-grid">
					<div class="form-group">
						<label for="year_of_study">Year of Study</label>
						<input type="text" id="year_of_study" name="year_of_study"
							   value="<?php echo htmlspecialchars($member['year_of_study'] ?? ''); ?>">
					</div>

					<div class="form-group">
						<label for="join_date">Join Date</label>
						<input type="text" id="join_date" value="<?php echo !empty($member['join_date']) ? date('F j, Y', strtotime($member['join_date'])) : 'N/A'; ?>" disabled>
					</div>
				</div>
			</div>

			<div class="form-section">
				<h3><i class="fas fa-lock"></i> Change Password (Optional)</h3>
				<div class="form-grid">
					<div class="form-group">
						<label for="current_password">Current Password</label>
						<input type="password" id="current_password" name="current_password" autocomplete="current-password">
					</div>

					<div class="form-group">
						<label for="new_password">New Password</label>
						<input type="password" id="new_password" name="new_password" autocomplete="new-password">
					</div>
				</div>

				<div class="form-group">
					<label for="confirm_new_password">Confirm New Password</label>
					<input type="password" id="confirm_new_password" name="confirm_new_password" autocomplete="new-password">
				</div>
			</div>

			<div class="form-actions">
				<button type="submit" class="btn btn-primary">
					<i class="fas fa-save"></i> Save Changes
				</button>
				<a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-secondary">
					<i class="fas fa-arrow-left"></i> Back to Dashboard
				</a>
			</div>
		</form>
	</div>
</div>

<style>
.container {
	max-width: 900px;
	margin: 0 auto;
	padding: 2rem;
}

.page-header {
	text-align: center;
	margin-bottom: 2rem;
}

.form-container {
	background: #fff;
	border-radius: 12px;
	box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.form-section {
	padding: 1.5rem 2rem;
	border-bottom: 1px solid #e9ecef;
}

.form-section:last-child {
	border-bottom: none;
}

.form-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
	gap: 1rem;
}

.form-group {
	margin-bottom: 1rem;
}

.form-group label {
	display: block;
	margin-bottom: 0.5rem;
	font-weight: 600;
}

.form-group label.required::after {
	content: '*';
	color: #dc3545;
	margin-left: 4px;
}

.form-group input {
	width: 100%;
	padding: 0.75rem 1rem;
	border: 2px solid #e9ecef;
	border-radius: 8px;
}

.form-actions {
	padding: 1.5rem 2rem;
	background: #f8f9fa;
	display: flex;
	gap: 1rem;
	flex-wrap: wrap;
}

.btn {
	padding: 0.75rem 1.25rem;
	border-radius: 8px;
	text-decoration: none;
	display: inline-flex;
	align-items: center;
	gap: 0.5rem;
	border: none;
	cursor: pointer;
}

.btn-primary {
	background: #0d6efd;
	color: #fff;
}

.btn-secondary {
	background: #6c757d;
	color: #fff;
}
</style>
