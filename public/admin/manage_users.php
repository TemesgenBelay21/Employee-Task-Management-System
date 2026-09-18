<?php
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('admin');
require_once __DIR__ . '/../../app/includes/admin_header.php';

$employees = $pdo->query("SELECT * FROM user WHERE role = 'employee' ORDER BY id")->fetchAll();
?>

<div class="page-title">
    <h2>Manage Users</h2>
    <div class="right">
        <a href="add_user.php" class="btn btn-success">Add User</a>
    </div>
</div>

<?php if (isset($_GET['added'])): ?>
    <div class="banner banner-success">User added successfully</div>
<?php elseif (isset($_GET['deleted'])): ?>
    <div class="banner banner-success">User deleted successfully</div>
<?php endif; ?>

<div class="table-wrap">
    <table class="tbl">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($employees): ?>
                <?php foreach ($employees as $i => $emp): ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo esc($emp['full_name']); ?></td>
                        <td><?php echo esc($emp['username']); ?></td>
                        <td><?php echo ucfirst($emp['role']); ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $emp['id']; ?>" class="btn btn-info btn-sm action-btn">Edit</a>
                            <a href="../../app/controllers/delete_user.php?id=<?php echo $emp['id']; ?>"
                               class="btn btn-danger btn-sm action-btn"
                               data-confirm="Delete <?php echo esc($emp['full_name']); ?>? This will also remove their tasks and notifications.">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="muted">No employees found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../app/includes/admin_footer.php'; ?>