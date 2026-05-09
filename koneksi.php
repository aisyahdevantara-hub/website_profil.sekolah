<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_sekolah";
$port = 3306;

try {
    $conn = mysqli_connect($host, $user, $pass, $db, $port);
    $conn->set_charset("utf8mb4");
} catch (Throwable $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
