<?php

include __DIR__ . '/env.php';

$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$db = $_ENV['DB_NAME'];

date_default_timezone_set(
    "Asia/Jakarta"
);

$conn = mysqli_connect($host, $user, $pass, $db, (int) $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>