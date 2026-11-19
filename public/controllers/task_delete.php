<?php

require_once __DIR__ . '/../../app/config/db.php';
require_once __DIR__ . '/../../app/includes/session.php';
require_once __DIR__ . '/../../app/includes/functions.php';
requireAuth('admin');

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ?');
    $stmt->execute([$id]);
}

redirect(url('admin/all_tasks.php?deleted=1'));