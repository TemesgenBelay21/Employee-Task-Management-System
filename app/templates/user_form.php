<?php
$mode = $mode ?? 'add';
$user_id = $user_id ?? '';
$full_name = $full_name ?? '';
$username = $username ?? '';
$submitLabel = ($mode === 'edit') ? 'Update' : 'Create User';
?>
<form method="post" action="../../app/controllers/user_save.php" class="form-card">
    <input type="hidden" name="user_id" value="<?php echo esc($user_id); ?>">
    <div class="form-group">
        <label class="form-label" for="full_name">Full Name</label>
        <input type="text" class="form-control" id="full_name" name="full_name"
               value="<?php echo esc($full_name); ?>" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username"
               value="<?php echo esc($username); ?>" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password"
               autocomplete="new-password"
               placeholder="<?php echo ($mode === 'edit') ? 'Leave blank to keep current password' : ''; ?>"
               <?php echo ($mode === 'add') ? 'required' : ''; ?>>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success"><?php echo $submitLabel; ?></button>
    </div>
</form>