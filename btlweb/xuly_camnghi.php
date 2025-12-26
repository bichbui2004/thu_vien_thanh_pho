<?php
require_once 'connect.php';
if (isset($_POST['gui_cn']) && isset($_SESSION['MaTK'])) {
    $maTK = $_SESSION['MaTK'];
    $maSach = $_POST['MaSach'];
    $noiDung = mysqli_real_escape_string($conn, $_POST['NoiDung']);

    $sql = "INSERT INTO cam_nghi (MaTK, MaSach, NoiDung) VALUES ('$maTK', '$maSach', '$noiDung')";
    mysqli_query($conn, $sql);
    header("Location: index.php?page_layout=chitiet&id=$maSach");
}
?>