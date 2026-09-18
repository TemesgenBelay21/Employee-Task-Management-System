<?php

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

function esc($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function statusBadge($status)
{
    $map = [
        'pending'     => 'status badge-pending',
        'in_progress' => 'status badge-in-progress',
        'completed'   => 'status badge-completed',
    ];
    $label = str_replace('_', ' ', $status);
    $label = ($status === 'in_progress') ? 'In Progress' : ucfirst($label);
    $class = isset($map[$status]) ? $map[$status] : 'status';
    return '<span class="' . $class . '">' . $label . '</span>';
}

function formatDate($date)
{
    if (!$date) {
        return '<span class="muted">No date</span>';
    }
    return date('M d, Y', strtotime($date));
}

function unreadCount($pdo, $employeeId)
{
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM notifications WHERE employee_id = ? AND is_read = 0');
    $stmt->execute([$employeeId]);
    return (int)$stmt->fetchColumn();
}

function activeIf($value, $target)
{
    return ($value === $target) ? 'active' : '';
}