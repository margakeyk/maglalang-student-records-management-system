<?php
// Database connection for XAMPP.
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'student_records';
$port = 3306;

mysqli_report(MYSQLI_REPORT_OFF);
$conn = mysqli_connect($host, $username, $password, $database, $port);
if (!$conn) {
    die('Cannot connect to the database. Check db.php and start MySQL in XAMPP.');
}
mysqli_set_charset($conn, 'utf8mb4');
