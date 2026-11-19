<?php

require_once __DIR__ . '/../../app/config/db.php';
require_once __DIR__ . '/../../app/includes/session.php';
require_once __DIR__ . '/../../app/includes/functions.php';
requireAuth('employee');

$id = $_SESSION['user_id'];
$full_name = trim($_POST['full_name'] ?? '');
$username  = trim($_POST['username'] ?? '');
$password  = $_POST['password'] ?? '';

if ($full_name === '' || $username === '') {
    redirect(url('employee/profile.php?error=1'));
}

$dupStmt = $pdo->prepare('SELECT COUNT(*) FROM user WHERE username = ? AND id <> ?');
$dupStmt->execute([$username, $id]);
if ($dupStmt->fetchColumn() > 0) {
    redirect(url('employee/profile.php?error=duplicate'));
}

if ($password !== '') {
    $stmt = $pdo->prepare('UPDATE user SET full_name = ?, username = ?, password = ? WHERE id = ?');
    $stmt->execute([$full_name, $username, password_hash($password, PASSWORD_DEFAULT), $id]);
} else {
    $stmt = $pdo->prepare('UPDATE user SET full_name = ?, username = ? WHERE id = ?');
    $stmt->execute([$full_name, $username, $id]);
}

$_SESSION['full_name'] = $full_name;
$_SESSION['username']  = $username;

redirect(url('employee/profile.php?success=1'));
