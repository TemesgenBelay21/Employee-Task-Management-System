<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/session.php';
requireAuth('admin');

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ?');
    $stmt->execute([$id]);
}

redirect('../../public/admin/all_tasks.php?deleted=1');