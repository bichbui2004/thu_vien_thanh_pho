<?php 
    include('../connect.php');
    $id = $_GET['id'];
    $sql = "delete from tai_khoan where MaTK = '$id'";
    mysqli_query($conn, $sql);
    header('location: ../index.php?page_layout=taikhoan');
?>