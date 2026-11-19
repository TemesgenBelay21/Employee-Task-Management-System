<?php

require_once __DIR__ . '/../app/includes/session.php';
require_once __DIR__ . '/../app/includes/functions.php';

if (!isLoggedIn()) {
    redirect(url('login.php'));
}

if (currentUser()['role'] === 'admin') {
    redirect(url('admin/dashboard.php'));
}

redirect(url('employee/dashboard.php'));