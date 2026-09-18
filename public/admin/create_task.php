<?php
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('admin');
require_once __DIR__ . '/../../app/includes/admin_header.php';

$stmt = $pdo->query("SELECT id, full_name FROM user WHERE role = 'employee' ORDER BY full_name");
$employees = $stmt->fetchAll();
?>

<div class="page-title">
    <h2>Create Task</h2>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="banner banner-success">Task created and assigned successfully</div>
<?php endif; ?>

<form method="post" action="../../app/controllers/task_save.php" class="form-card">
    <div class="form-group">
        <label class="form-label" for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="5"></textarea>
    </div>
    <div class="form-group">
        <label class="form-label" for="due_date">Due Date</label>
        <input type="date" class="form-control" id="due_date" name="due_date">
    </div>
    <div class="form-group">
        <label class="form-label" for="assigned_to">Assigned To</label>
        <select class="form-control" id="assigned_to" name="assigned_to" required>
            <option value="">-- Select employee --</option>
            <?php foreach ($employees as $emp): ?>
                <option value="<?php echo $emp['id']; ?>"><?php echo esc($emp['full_name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Create Task</button>
</form>

<?php require_once __DIR__ . '/../../app/includes/admin_footer.php'; ?>