<?php
require_once __DIR__ . '/bootstrap_env.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli(appEnv('DB_HOST', '127.0.0.1'), appEnv('DB_USER'), appEnv('DB_PASSWORD'), appEnv('DB_NAME'), (int) appEnv('DB_PORT', '3306'));
$conn->set_charset('utf8mb4');
