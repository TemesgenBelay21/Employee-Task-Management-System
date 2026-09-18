<?php
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('employee');
require_once __DIR__ . '/../../app/includes/employee_header.php';

$uid = $user['id'];

$filter = $_GET['filter'] ?? 'all';

$labels = [
    'all'         => 'All Task',
    'due_today'   => 'Due Today',
    'overdue'     => 'Overdue',
    'no_deadline' => 'No Deadline',
];

$where  = "WHERE t.assigned_to = $uid";
$params = [];

if ($filter === 'due_today') {
    $where .= " AND t.due_date = CURDATE() AND t.status != 'completed'";
} elseif ($filter === 'overdue') {
    $where .= " AND t.due_date < CURDATE() AND t.status != 'completed'";
} elseif ($filter === 'no_deadline') {
    $where .= ' AND t.due_date IS NULL';
}

$filterLabel = $labels[$filter] ?? 'All Task';

$countStmt = $pdo->query("SELECT COUNT(*) FROM tasks t $where");
$taskCount = (int)$countStmt->fetchColumn();

$stmt = $pdo->query(
    "SELECT t.*, u.full_name AS assigned_by
     FROM tasks t JOIN user u ON u.id = t.assigned_by
     $where ORDER BY COALESCE(t.due_date, '9999-12-31') ASC"
);
$tasks = $stmt->fetchAll();
?>
<div class="page-title">
    <h2>My Task</h2>
</div>
<div class="filter-links">
    <a href="my_task.php?filter=all" class="<?php echo $filter === 'all' ? 'active' : ''; ?>">All Task</a>
    <a href="my_task.php?filter=due_today" class="<?php echo $filter === 'due_today' ? 'active' : ''; ?>">Due Today</a>
    <a href="my_task.php?filter=overdue" class="<?php echo $filter === 'overdue' ? 'active' : ''; ?>">Overdue</a>
    <a href="my_task.php?filter=no_deadline" class="<?php echo $filter === 'no_deadline' ? 'active' : ''; ?>">No Deadline</a>
</div>
<div class="count-label"><?php echo $filterLabel; ?> (<?php echo $taskCount; ?>)</div>

<?php if (isset($_GET['deleted'])): ?>
    <div class="banner banner-success">Task deleted successfully</div>
<?php endif; ?>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>#</th><th>Title</th><th>Description</th><th>Due Date</th><th>Status</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($tasks): ?>
            <?php foreach ($tasks as $i => $task): ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo esc($task['title']); ?></td>
                    <td><?php echo esc(mb_strimwidth($task['description'], 0, 50, '...')); ?></td>
                    <td><?php echo formatDate($task['due_date']); ?></td>
                    <td><?php echo statusBadge($task['status']); ?></td>
                    <td>
                        <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-success">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="muted">No tasks found</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../app/includes/employee_footer.php'; ?>