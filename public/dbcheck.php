<?php
header('Content-Type: text/plain; charset=utf-8');

$dbFile = __DIR__ . '/../app/config/db.php';
echo 'db.php exists: ' . (is_file($dbFile) ? 'yes' : 'no') . PHP_EOL;
if (!is_file($dbFile)) {
    exit;
}

$src = file_get_contents($dbFile);

function cfgValue($src, $key)
{
    $pattern = "/define\('" . preg_quote($key, '/') . "',\s*'([^']*)'\)/";
    return preg_match($pattern, $src, $m) ? $m[1] : null;
}

$host = cfgValue($src, 'DB_HOST');
$name = cfgValue($src, 'DB_NAME');
$user = cfgValue($src, 'DB_USER');
$pass = cfgValue($src, 'DB_PASS');

echo 'PHP: ' . PHP_VERSION . PHP_EOL;
echo 'PDO drivers: ' . implode(', ', PDO::getAvailableDrivers()) . PHP_EOL;
echo "parsed DB_HOST: {$host}" . PHP_EOL;
echo "parsed DB_NAME: {$name}" . PHP_EOL;
echo "parsed DB_USER: {$user}" . PHP_EOL;
echo 'parsed DB_PASS literal: ' . ($pass === null ? 'not found (env-based)' : 'found') . PHP_EOL;

if ($host === null || $name === null || $user === null || $pass === null) {
    echo 'RESULT: cannot parse literal credentials from db.php' . PHP_EOL;
    exit;
}

$ip = gethostbyname($host);
echo "Resolve {$host}: " . ($ip === $host ? 'FAILED' : $ip) . PHP_EOL;

try {
    $pdo = new PDO(
        'mysql:host=' . $host . ';dbname=' . $name . ';charset=utf8mb4',
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo 'CONNECTED OK' . PHP_EOL;
    echo 'MySQL version: ' . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . PHP_EOL;
} catch (Throwable $e) {
    echo 'ERROR: ' . get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
}
