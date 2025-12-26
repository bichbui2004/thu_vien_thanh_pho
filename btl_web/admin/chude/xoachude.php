<?php 
    include('../connect.php');
    $id = $_GET['id'];
    $sql = "delete from chu_de where MaCD = '$id'";
    mysqli_query($conn, $sql);
    header('location: ../index.php?page_layout=chude');
?>