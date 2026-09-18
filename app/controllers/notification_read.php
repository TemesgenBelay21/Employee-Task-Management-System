<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/session.php';
requireAuth('employee');

$id = (int)($_GET['id'] ?? 0);
$back = $_GET['back'] ?? '../public/employee/notifications.php';

if ($id > 0) {
    $stmt = $pdo->prepare('UPDATE notifications SET is_read = 1 WHERE id = ? AND employee_id = ?');
    $stmt->execute([$id, $_SESSION['user_id']]);
} elseif (isset($_GET['all'])) {
    $stmt = $pdo->prepare('UPDATE notifications SET is_read = 1 WHERE employee_id = ?');
    $stmt->execute([$_SESSION['user_id']]);
}

header('Location: ' . $back);
exit;