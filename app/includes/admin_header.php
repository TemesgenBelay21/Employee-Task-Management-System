<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/../config/db.php';

$user = currentUser();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Pro — Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body>
    <div class="app">
        <header class="topbar">
            <div class="brand">
                <button class="hamburger" id="sidebarToggle" type="button">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                <span class="logo">Task <b>Pro</b></span>
            </div>
            <div class="topbar-right"></div>
        </header>
        <div class="body">
            <nav class="side-bar" id="sidebar">
                <div class="user-p">
                    <img src="../../assets/img/user.png" alt="avatar">
                    <h4>@<?php echo esc($user['username']); ?></h4>
                </div>
                <ul>
                    <li class="<?php echo activeIf($currentPage, 'dashboard.php'); ?>">
                        <a href="dashboard.php"><i class="fa fa-tachometer" aria-hidden="true"></i><span>Dashboard</span></a>
                    </li>
                    <li class="<?php echo in_array($currentPage, ['manage_users.php', 'add_user.php', 'edit_user.php']) ? 'active' : ''; ?>">
                        <a href="manage_users.php"><i class="fa fa-users" aria-hidden="true"></i><span>Manage Users</span></a>
                    </li>
                    <li class="<?php echo activeIf($currentPage, 'create_task.php'); ?>">
                        <a href="create_task.php"><i class="fa fa-plus" aria-hidden="true"></i><span>Create Task</span></a>
                    </li>
                    <li class="<?php echo in_array($currentPage, ['all_tasks.php', 'edit_task.php']) ? 'active' : ''; ?>">
                        <a href="all_tasks.php"><i class="fa fa-tasks" aria-hidden="true"></i><span>All Tasks</span></a>
                    </li>
                    <li>
                        <a href="../../app/controllers/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a>
                    </li>
                </ul>
            </nav>
            <main class="main-content">