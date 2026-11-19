<?php

require_once __DIR__ . '/../../app/config/db.php';
require_once __DIR__ . '/../../app/includes/functions.php';
require_once __DIR__ . '/../../app/includes/session.php';

if (isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        setSession($user);
        if ($user['role'] === 'admin') {
            redirect(url('admin/dashboard.php'));
        }
        redirect(url('employee/dashboard.php'));
    }
}

redirect(url('login.php?error=1&username=' . urlencode($username ?? '')));