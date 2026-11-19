<?php

require_once __DIR__ . '/../../app/config/db.php';
require_once __DIR__ . '/../../app/includes/session.php';
require_once __DIR__ . '/../../app/includes/functions.php';
requireAuth('admin');

$id = (int)($_GET['id'] ?? 0);

if ($id > 0 && $id !== (int)($_SESSION['user_id'] ?? 0)) {
    $stmt = $pdo->prepare('DELETE FROM user WHERE id = ? AND role = ?');
    $stmt->execute([$id, 'employee']);
}

redirect(url('admin/manage_users.php'));