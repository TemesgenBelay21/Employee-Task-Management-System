<?php

require_once __DIR__ . '/../../app/config/db.php';
require_once __DIR__ . '/../../app/includes/session.php';
require_once __DIR__ . '/../../app/includes/functions.php';
requireAuth('admin');

if (isset($_POST['full_name'], $_POST['username'])) {
    $id        = trim($_POST['user_id'] ?? '');
    $full_name = trim($_POST['full_name']);
    $username  = trim($_POST['username']);
    $password  = $_POST['password'] ?? '';

    $dupStmt = $pdo->prepare('SELECT COUNT(*) FROM user WHERE username = ? AND id <> ?');
    $dupStmt->execute([$username, $id ? (int)$id : 0]);
    if ($dupStmt->fetchColumn() > 0) {
        if ($id) {
            redirect(url('admin/edit_user.php?id=' . $id . '&error=duplicate'));
        }
        redirect(url('admin/add_user.php?error=duplicate'));
    }

    if ($id) {
        if ($password !== '') {
            $stmt = $pdo->prepare('UPDATE user SET full_name = ?, username = ?, password = ? WHERE id = ?');
            $stmt->execute([$full_name, $username, password_hash($password, PASSWORD_DEFAULT), $id]);
        } else {
            $stmt = $pdo->prepare('UPDATE user SET full_name = ?, username = ? WHERE id = ?');
            $stmt->execute([$full_name, $username, $id]);
        }
        redirect(url('admin/edit_user.php?id=' . $id . '&success=1'));
    }

    $stmt = $pdo->prepare('INSERT INTO user (full_name, username, password, role) VALUES (?, ?, ?, ?)');
    $stmt->execute([$full_name, $username, password_hash($password, PASSWORD_DEFAULT), 'employee']);
    redirect(url('admin/manage_users.php?added=1'));
}

redirect(url('admin/manage_users.php'));