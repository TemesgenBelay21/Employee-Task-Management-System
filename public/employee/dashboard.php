<?php
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('employee');
require_once __DIR__ . '/../../app/includes/employee_header.php';

$uid = (int)currentUser()['id'];

$myTasks   = (int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE assigned_to = $uid")->fetchColumn();
$myPending = (int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE assigned_to = $uid AND status = 'pending'")->fetchColumn();
$myInProg  = (int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE assigned_to = $uid AND status = 'in_progress'")->fetchColumn();
$myDone    = (int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE assigned_to = $uid AND status = 'completed'")->fetchColumn();
$overdue   = (int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE assigned_to = $uid AND due_date < CURDATE() AND status != 'completed'")->fetchColumn();
$noDeadline= (int)$pdo->query("SELECT COUNT(*) FROM tasks WHERE assigned_to = $uid AND due_date IS NULL")->fetchColumn();
?>

<div class="page-title">
    <h2>Welcome, <?php echo esc(currentUser()['full_name']); ?></h2>
</div>

<div class="stat-grid">
    <a class="stat-card" href="my_task.php">
        <div class="stat-icon blue"><i class="fa fa-tasks" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $myTasks; ?></div>
            <div class="label">My Tasks</div>
        </div>
    </a>
    <a class="stat-card" href="my_task.php?filter=overdue">
        <div class="stat-icon red"><i class="fa fa-hourglass-end" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $overdue; ?></div>
            <div class="label">Overdue</div>
        </div>
    </a>
    <a class="stat-card" href="my_task.php?filter=no_deadline">
        <div class="stat-icon purple"><i class="fa fa-calendar-o" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $noDeadline; ?></div>
            <div class="label">No Deadline</div>
        </div>
    </a>
    <a class="stat-card" href="my_task.php">
        <div class="stat-icon orange"><i class="fa fa-hourglass-half" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $myPending; ?></div>
            <div class="label">Pending</div>
        </div>
    </a>
    <a class="stat-card" href="my_task.php">
        <div class="stat-icon teal"><i class="fa fa-spinner" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $myInProg; ?></div>
            <div class="label">In Progress</div>
        </div>
    </a>
    <a class="stat-card" href="my_task.php">
        <div class="stat-icon green"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
        <div class="stat-info">
            <div class="count"><?php echo $myDone; ?></div>
            <div class="label">Completed</div>
        </div>
    </a>
</div>

<?php require_once __DIR__ . '/../../app/includes/employee_footer.php'; ?>
