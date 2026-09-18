<?php
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('employee');
require_once __DIR__ . '/../../app/includes/employee_header.php';

$unread = (int)$pdo->prepare('SELECT COUNT(*) FROM notifications WHERE employee_id = ? AND is_read = 0');
$unread->execute([$user['id']]);
$unreadCount = $unread->fetchColumn();

$allStmt = $pdo->prepare(
    'SELECT * FROM notifications WHERE employee_id = ? ORDER BY created_at DESC, id DESC'
);
$allStmt->execute([$user['id']]);
$notifs = $allStmt->fetchAll();
?>
<div class="page-title">
    <h2>Notifications</h2>
</div>

<?php if (isset($_GET['deleted'])): ?>
    <div class="banner banner-success">All notifications cleared</div>
<?php endif; ?>

<?php if ($unreadCount > 0): ?>
    <div class="right-push">
        <a href="../../app/controllers/notification_read.php?all=1&back=../../public/employee/notifications.php"
           class="btn btn-success btn-sm">Mark All Read</a>
    </div>
<?php endif; ?>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Message</th>
                <th>Type</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($notifs): ?>
                <?php foreach ($notifs as $i => $n): ?>
                    <tr class="<?php echo $n['is_read'] ? '' : 'unread-row'; ?>">
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo esc($n['message']); ?></td>
                        <td><?php echo esc($n['type']); ?></td>
                        <td><?php echo formatDate($n['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="muted">No notifications</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../app/includes/employee_footer.php'; ?>