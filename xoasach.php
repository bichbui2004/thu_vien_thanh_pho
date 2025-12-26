<?php 
    include('../connect.php');
    $id = $_GET['id'];
    $sql = "delete from sach where MaSach = '$id'";
    mysqli_query($conn, $sql);
    header('location: ../index.php?page_layout=sach');
?>