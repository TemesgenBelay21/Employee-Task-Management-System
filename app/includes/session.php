<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function requireAuth($role = null)
{
    if (!isLoggedIn()) {
        header('Location: ../login.php');
        exit;
    }
    if ($role !== null && ($_SESSION['role'] ?? '') !== $role) {
        header('Location: ../login.php');
        exit;
    }
}

function currentUser()
{
    if (!isLoggedIn()) {
        return null;
    }
    return [
        'id'        => $_SESSION['user_id'],
        'username'  => $_SESSION['username'],
        'role'      => $_SESSION['role'],
        'full_name' => $_SESSION['full_name'],
    ];
}

function setSession($user)
{
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['username']  = $user['username'];
    $_SESSION['role']      = $user['role'];
    $_SESSION['full_name'] = $user['full_name'];
}

function logout()
{
    session_destroy();

    header('Location: ../../public/login.php');
    exit;
}