<?php

define('BASE_URL', 'https://task-management.et-cam.com.et');
define('PUBLIC_PATH', '/public');
define('APP_DEBUG', false);

function url($path = '')
{
    return BASE_URL . PUBLIC_PATH . '/' . ltrim((string)$path, '/');
}

function asset($path = '')
{
    return url('assets/' . ltrim((string)$path, '/'));
}
