<?php

define('BASE_URL', 'https://task-management.et-cam.com.et');
define('APP_DEBUG', false);

function url($path = '')
{
    return BASE_URL . '/' . ltrim((string)$path, '/');
}

function asset($path = '')
{
    return url('assets/' . ltrim((string)$path, '/'));
}
