<?php
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('employee');
require_once __DIR__ . '/../../app/includes/employee_header.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = ? AND assigned_to = ?');
$stmt->execute([$id, $user['id']]);
$task = $stmt->fetch();

if (!$task) {
    redirect('my_task.php');
}
?>
<div class="page-title">
    <h2>Update Task</h2>
    <div class="right">
        <a href="my_task.php" class="btn btn-success">Tasks</a>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="banner banner-success">Task updated successfully</div>
<?php endif; ?>

<div class="form-card">
    <form method="post" action="../../app/controllers/task_save.php">
        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">

        <div class="form-group">
            <label class="form-label" for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title"
                   value="<?php echo esc($task['title']); ?>" readonly disabled>
        </div>
        <div class="form-group">
            <label class="form-label" for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5"
                      readonly disabled><?php echo esc($task['description']); ?></textarea>
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
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

<?php require_once __DIR__ . '/../../app/includes/employee_footer.php'; ?>