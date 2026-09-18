<?php
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('admin');
require_once __DIR__ . '/../../app/includes/admin_header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM user WHERE id = ? AND role = ?');
$stmt->execute([$id, 'employee']);
$emp = $stmt->fetch();

if (!$emp) {
    redirect('manage_users.php');
}
?>

<div class="page-title">
    <h2>Edit User</h2>
    <div class="right">
        <a href="manage_users.php" class="btn btn-success">Users</a>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="banner banner-success">User updated successfully</div>
<?php elseif (isset($_GET['error']) && $_GET['error'] === 'duplicate'): ?>
    <div class="banner banner-error">Username already exists. Please choose another.</div>
<?php endif; ?>

<?php
$mode = 'edit';
$user_id = $emp['id'];
$full_name = $emp['full_name'];
$username = $emp['username'];
?>

<?php require_once __DIR__ . '/../../app/templates/user_form.php'; ?>

<?php require_once __DIR__ . '/../../app/includes/admin_footer.php'; ?>