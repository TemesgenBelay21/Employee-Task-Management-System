<?php
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('admin');
require_once __DIR__ . '/../../app/includes/admin_header.php';

$filter = $_GET['filter'] ?? 'all';

$where  = '';
$params = [];

if ($filter === 'due_today') {
    $where  = "WHERE due_date = CURDATE() AND status != 'completed'";
} elseif ($filter === 'overdue') {
    $where  = "WHERE due_date < CURDATE() AND status != 'completed'";
} elseif ($filter === 'no_deadline') {
    $where  = 'WHERE due_date IS NULL';
}

$countStmt = $pdo->prepare("SELECT COUNT(*) FROM tasks $where");
$countStmt->execute($params);
$taskCount = (int)$countStmt->fetchColumn();

$stmt = $pdo->prepare(
    "SELECT t.*, u.full_name AS employee
     FROM tasks t
     JOIN user u ON u.id = t.assigned_to
     $where
     ORDER BY (t.due_date IS NULL), t.due_date ASC"
);
$stmt->execute($params);
$tasks = $stmt->fetchAll();

$labels = [
    'due_today'  => 'Due Today',
    'overdue'    => 'Overdue',
    'no_deadline'=> 'No Deadline',
    'all'        => 'All Task',
];
?>
<div class="page-title">
    <h2>All Tasks</h2>
    <div class="right">
        <a href="create_task.php" class="btn btn-success">Create Task</a>
    </div>
</div>

<div class="filter-links">
    <a href="all_tasks.php?filter=all" class="<?php echo $filter === 'all' ? 'active' : ''; ?>">All Tasks</a>
    <a href="all_tasks.php?filter=due_today" class="<?php echo $filter === 'due_today' ? 'active' : ''; ?>">Due Today</a>
    <a href="all_tasks.php?filter=overdue" class="<?php echo $filter === 'overdue' ? 'active' : ''; ?>">Overdue</a>
    <a href="all_tasks.php?filter=no_deadline" class="<?php echo $filter === 'no_deadline' ? 'active' : ''; ?>">No Deadline</a>
    <span class="count-label"><?php echo $labels[$filter]; ?> (<?php echo $taskCount; ?>)</span>
</div>

<?php if (isset($_GET['deleted'])): ?>
    <div class="banner banner-success">Task deleted successfully</div>
<?php endif; ?>

<div class="table-wrap">
    <table class="tbl">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Assigned To</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($tasks): ?>
                <?php foreach ($tasks as $i => $task): ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo esc($task['title']); ?></td>
                        <td><?php echo esc(mb_strimwidth($task['description'] ?? '', 0, 60, '…')); ?></td>
                        <td><?php echo esc($task['employee']); ?></td>
                        <td><?php echo formatDate($task['due_date']); ?></td>
                        <td><?php echo statusBadge($task['status']); ?></td>
                        <td>
                            <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                            <a href="../../app/controllers/task_delete.php?id=<?php echo $task['id']; ?>"
                               class="btn btn-danger btn-sm" data-confirm="Delete this task and all its notifications?">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="muted">No tasks found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../app/includes/admin_footer.php'; ?>