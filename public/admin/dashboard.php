<?php
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('admin');
require_once __DIR__ . '/../../app/includes/admin_header.php';

$employees = (int)$pdo->query("SELECT COUNT(*) FROM user WHERE role = 'employee'")->fetchColumn();
$allTasks  = (int)$pdo->query('SELECT COUNT(*) FROM tasks')->fetchColumn();
$overdue   = (int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE due_date < CURDATE() AND status != 'completed'")->fetchColumn();
$noDeadline = (int)$pdo->query('SELECT COUNT(*) FROM tasks WHERE due_date IS NULL')->fetchColumn();
$dueToday  = (int)$pdo->query('SELECT COUNT(*) FROM tasks WHERE due_date = CURDATE()')->fetchColumn();
$notifCount = (int)$pdo->query('SELECT COUNT(*) FROM notifications')->fetchColumn();
$pending   = (int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE status = 'pending'")->fetchColumn();
$inProgress = (int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE status = 'in_progress'")->fetchColumn();
$completed = (int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE status = 'completed'")->fetchColumn();
?>

<div class="page-title">
    <h2>Dashboard</h2>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fa fa-users" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $employees; ?></div>
            <div class="label">Employee</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon navy"><i class="fa fa-tasks" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $allTasks; ?></div>
            <div class="label">All Tasks</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $overdue; ?></div>
            <div class="label">Overdue</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fa fa-calendar-o" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $noDeadline; ?></div>
            <div class="label">No Deadline</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $dueToday; ?></div>
            <div class="label">Due Today</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon pink"><i class="fa fa-bell" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $notifCount; ?></div>
            <div class="label">Notifications</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal"><i class="fa fa-hourglass-half" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $pending; ?></div>
            <div class="label">Pending</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fa fa-spinner" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $inProgress; ?></div>
            <div class="label">In Progress</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $completed; ?></div>
            <div class="label">Completed</div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../app/includes/admin_footer.php'; ?>