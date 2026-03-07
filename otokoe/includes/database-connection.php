<?php
$type     = 'mysql';
$server   = 'localhost';
$db       = 'otokoe';
$port     = 3306;
$username = 'root';
$password = '';

$dsn = "$type:host=$server;dbname=$db;port=$port;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    $title       = 'Database error';
    $description = '';
    $navigation  = [];
    include 'database-troubleshooting.php';
}
