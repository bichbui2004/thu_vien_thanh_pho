<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "quan_ly_thu_vien";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) { die("Kết nối thất bại: " . $conn->connect_error); }
mysqli_set_charset($conn, "utf8mb4");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>