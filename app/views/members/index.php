<div class="members-page">
    <div class="page-header">
        <h1><i class="fas fa-users"></i> <?php echo $title; ?></h1>
        <a href="<?php echo BASE_URL; ?>/members/create" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Add New Member
        </a>
    </div>
    
    <div class="search-container">
        <form class="search-form" onsubmit="searchMembers(event)">
            <div class="form-group">
                <input type="text" placeholder="Search members by name, ID, or email..." id="searchInput" value="<?php echo htmlspecialchars($search ?? ''); ?>">
            </div>
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
    </div>
    
    <?php if (empty($members)): ?>
        <div class="empty-state">
            <i class="fas fa-users-slash"></i>
            <h3>No Members Found</h3>
            <p>No members have been added to the system yet.</p>
            <a href="create" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Add Your First Member
            </a>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Student ID</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Year</th>
                        <th>Join Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $member): ?>
                    <tr>
                        <td><?php echo $member['id']; ?></td>
                        <td><?php echo htmlspecialchars($member['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($member['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($member['email']); ?></td>
                        <td><?php echo htmlspecialchars($member['department']); ?></td>
                        <td><?php echo htmlspecialchars($member['year_of_study']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($member['join_date'])); ?></td>
                        <td class="actions">
                            <a href="<?php echo BASE_URL; ?>/members/edit/<?php echo $member['id']; ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <button onclick="deleteMember(<?php echo $member['id']; ?>)" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="table-footer">
            <p>Showing <?php echo count($members); ?> member(s)</p>
            <div class="pagination">
                <button class="btn btn-sm" disabled>Previous</button>
                <span>Page 1 of 1</span>
                <button class="btn btn-sm" disabled>Next</button>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function searchMembers(event) {
    event.preventDefault();
    const query = document.getElementById('searchInput').value;
    if (query.trim() !== '') {
        window.location.href = '?search=' + encodeURIComponent(query);
    } else {
        window.location.href = window.location.pathname;
    }
}

function deleteMember(id) {
    if (confirm('Are you sure you want to delete this member?')) {
        window.location.href = 'delete/' + id;
    }
}
</script>
