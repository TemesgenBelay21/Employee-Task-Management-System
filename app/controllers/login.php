<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/session.php';

if (isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        setSession($user);
        if ($user['role'] === 'admin') {
            redirect('../../public/admin/dashboard.php');
        }
        redirect('../../public/employee/dashboard.php');
    }
}

redirect('../../public/login.php?error=1&username=' . urlencode($username ?? ''));