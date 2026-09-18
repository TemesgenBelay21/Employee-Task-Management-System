<?php

require_once __DIR__ . '/../app/includes/session.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

if (currentUser()['role'] === 'admin') {
    redirect('admin/dashboard.php');
}

redirect('employee/dashboard.php');