<?php
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('employee');
require_once __DIR__ . '/../../app/includes/employee_header.php';

$uid = $user['id'];

$stmt = $pdo->prepare('SELECT full_name, username, role, created_at FROM user WHERE id = ?');
$stmt->execute([$uid]);
$mine = $stmt->fetch();
?>
<div class="page-title">
    <h2>My Profile</h2>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="banner banner-success">Profile updated successfully</div>
<?php endif; ?>

<div class="form-card">
    <form method="post" action="../../app/controllers/profile_save.php">
        <div class="form-group">
            <label class="form-label" for="full_name">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name"
                   value="<?php echo esc($mine['full_name']); ?>" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username"
                   value="<?php echo esc($mine['username']); ?>" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="password">New Password <span class="muted">(leave blank to keep current)</span></label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-success">Save Profile</button>
    </form>
</div>

<?php require_once __DIR__ . '/../../app/includes/employee_footer.php'; ?>