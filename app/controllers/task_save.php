<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();

$user   = currentUser();
$taskId = (int)($_POST['task_id'] ?? 0);

if ($user['role'] === 'admin') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $dueDate     = trim($_POST['due_date'] ?? '');
    $dueDate     = $dueDate === '' ? null : $dueDate;
    $assignedTo  = (int)($_POST['assigned_to'] ?? 0);
    $status      = $_POST['status'] ?? 'pending';

    if ($taskId === 0) {
        $stmt = $pdo->prepare(
            'INSERT INTO tasks (title, description, due_date, status, assigned_to, assigned_by)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$title, $description, $dueDate, $status, $assignedTo, $user['id']]);
        $taskId = (int)$pdo->lastInsertId();

        if ($assignedTo > 0) {
            $stmt = $pdo->prepare(
                'INSERT INTO notifications (employee_id, task_id, message, type)
                 VALUES (?, ?, ?, ?)'
            );
            $stmt->execute([$assignedTo, $taskId, "'" . $title . "' has been assigned to you. Please review and start working on it.", 'New Task Assigned']);
        }

        redirect('../../public/admin/edit_task.php?id=' . $taskId . '&success=1');
    }

    $stmt = $pdo->prepare('SELECT assigned_to FROM tasks WHERE id = ?');
    $stmt->execute([$taskId]);
    $old = $stmt->fetchColumn();

    $stmt = $pdo->prepare(
        'UPDATE tasks SET title = ?, description = ?, due_date = ?,
         status = ?, assigned_to = ? WHERE id = ?'
    );
    $stmt->execute([$title, $description, $dueDate, $status, $assignedTo, $taskId]);

    if ((int)$old !== $assignedTo) {
        $stmt = $pdo->prepare(
            'INSERT INTO notifications (employee_id, task_id, message, type)
             VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$assignedTo, $taskId, "'" . $title . "' has been assigned to you. Please review and start working on it.", 'New Task Assigned']);
    }

    redirect('../../public/admin/edit_task.php?id=' . $taskId . '&success=1');
}

requireAuth('employee');
$status = $_POST['status'] ?? 'pending';
if (!in_array($status, ['pending', 'in_progress', 'completed'])) {
    $status = 'pending';
}

$stmt = $pdo->prepare('UPDATE tasks SET status = ? WHERE id = ? AND assigned_to = ?');
$stmt->execute([$status, $taskId, $user['id']]);

redirect('../../public/employee/edit_task.php?id=' . $taskId . '&success=1');