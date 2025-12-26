<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "quan_ly_thu_vien";
//$port = 3306

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>