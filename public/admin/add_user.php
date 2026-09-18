<?php
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('admin');
require_once __DIR__ . '/../../app/includes/admin_header.php';
?>

<div class="page-title">
    <h2>Add User</h2>
    <div class="right">
        <a href="manage_users.php" class="btn btn-success">Users</a>
    </div>
</div>

<?php if (isset($_GET['error']) && $_GET['error'] === 'duplicate'): ?>
    <div class="banner banner-error">Username already exists. Please choose another.</div>
<?php endif; ?>

<?php $mode = 'add'; ?>

<?php require_once __DIR__ . '/../../app/templates/user_form.php'; ?>

<?php require_once __DIR__ . '/../../app/includes/admin_footer.php'; ?>