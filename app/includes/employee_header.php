<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/../config/db.php';

$user = currentUser();
$currentPage = basename($_SERVER['PHP_SELF']);
$unreadCount = unreadCount($pdo, $user['id']);

$stmt = $pdo->prepare('SELECT * FROM notifications WHERE employee_id = ? ORDER BY created_at DESC, id DESC LIMIT 5');
$stmt->execute([$user['id']]);
$recentNotifs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Pro — Employee</title>
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
            <div class="topbar-right">
                <div class="bell-wrap">
                    <button class="bell-btn" id="bellBtn" type="button">
                        <i class="fa fa-bell" aria-hidden="true"></i>
                        <span class="bell-badge <?php echo $unreadCount > 0 ? 'show' : ''; ?>"><?php echo $unreadCount; ?></span>
                    </button>
                    <div class="notif-drop" id="notifDrop">
                        <div class="notif-drop-head">Notifications</div>
                        <?php if ($recentNotifs): ?>
                            <?php foreach ($recentNotifs as $n): ?>
                                <a class="notif-drop-item <?php echo $n['is_read'] ? '' : 'unread'; ?>"
                                   href="../../app/controllers/notification_read.php?id=<?php echo $n['id']; ?>">
                                    <?php echo esc($n['message']); ?>
                                    <small><?php echo date('M d, Y H:i', strtotime($n['created_at'])); ?></small>
                                </a>
                            <?php endforeach; ?>
                            <div class="notif-drop-foot">
                                <a href="notifications.php" class="btn btn-info btn-sm">View all notifications</a>
                            </div>
                        <?php else: ?>
                            <div class="notif-drop-item">No notifications yet.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
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
                    <li class="<?php echo activeIf($currentPage, 'my_task.php'); ?>">
                        <a href="my_task.php"><i class="fa fa-tasks" aria-hidden="true"></i><span>My Task</span></a>
                    </li>
                    <li class="<?php echo activeIf($currentPage, 'profile.php'); ?>">
                        <a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i><span>Profile</span></a>
                    </li>
                    <li class="<?php echo activeIf($currentPage, 'notifications.php'); ?>">
                        <a href="notifications.php"><i class="fa fa-bell" aria-hidden="true"></i><span>Notifications</span></a>
                    </li>
                    <li>
                        <a href="../../app/controllers/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Logout</span></a>
                    </li>
                </ul>
            </nav>
            <main class="main-content">