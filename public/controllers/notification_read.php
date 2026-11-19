<?php

require_once __DIR__ . '/../../app/config/db.php';
require_once __DIR__ . '/../../app/includes/session.php';
requireAuth('employee');

$id = (int)($_GET['id'] ?? 0);
$back = $_GET['back'] ?? 'employee/notifications.php';
if (!preg_match('#^(admin|employee)/[A-Za-z0-9_/.-]+\.php$#', $back)) {
    $back = 'employee/notifications.php';
}

if ($id > 0) {
    $stmt = $pdo->prepare('UPDATE notifications SET is_read = 1 WHERE id = ? AND employee_id = ?');
    $stmt->execute([$id, $_SESSION['user_id']]);
} elseif (isset($_GET['all'])) {
    $stmt = $pdo->prepare('UPDATE notifications SET is_read = 1 WHERE employee_id = ?');
    $stmt->execute([$_SESSION['user_id']]);
}

header('Location: ' . url($back));
exit;