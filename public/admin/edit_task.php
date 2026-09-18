<?php
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('admin');
require_once __DIR__ . '/../../app/includes/admin_header.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare(
    'SELECT t.*, u.full_name AS employee_name
     FROM tasks t JOIN user u ON u.id = t.assigned_to
     WHERE t.id = ?'
);
$stmt->execute([$id]);
$task = $stmt->fetch();

if (!$task) {
    redirect('all_tasks.php');
}

$employees = $pdo->query("SELECT id, full_name FROM user WHERE role = 'employee' ORDER BY full_name")->fetchAll();
?>

<div class="page-title">
    <h2>Edit Task</h2>
    <div class="right">
        <a href="all_tasks.php" class="btn btn-success">Tasks</a>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="banner banner-success">Task updated successfully</div>
<?php endif; ?>

<form method="post" action="../../app/controllers/task_save.php" class="form-card">
    <input type="hidden" name="task_id" value="<?php echo (int)$task['id']; ?>">

    <div class="form-group">
        <label class="form-label" for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title"
               value="<?php echo esc($task['title']); ?>" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="description">Description</label>
        <textarea class="form-control" id="description" name="description"
                  rows="5"><?php echo esc($task['description']); ?></textarea>
    </div>
    <div class="form-group">
        <label class="form-label" for="due_date">Due Date</label>
        <input type="date" class="form-control" id="due_date" name="due_date"
               value="<?php echo $task['due_date'] ? esc($task['due_date']) : ''; ?>">
    </div>
    <div class="form-group">
        <label class="form-label" for="assigned_to">Assigned To</label>
        <select class="form-control" id="assigned_to" name="assigned_to" required>
            <?php foreach ($employees as $emp): ?>
                <option value="<?php echo $emp['id']; ?>"
                    <?php echo $emp['id'] === (int)$task['assigned_to'] ? 'selected' : ''; ?>>
                    <?php echo esc($emp['full_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label class="form-label" for="status">Status</label>
        <select class="form-control" id="status" name="status" required>
            <?php foreach (['pending', 'in_progress', 'completed'] as $s): ?>
                <option value="<?php echo $s; ?>" <?php echo $task['status'] === $s ? 'selected' : ''; ?>>
                    <?php echo ucfirst(str_replace('_', ' ', $s)); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Update Task</button>
</form>

<?php require_once __DIR__ . '/../../app/includes/admin_footer.php'; ?>