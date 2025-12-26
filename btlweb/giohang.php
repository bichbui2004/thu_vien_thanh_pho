<?php
require_once 'connect.php';

if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $id = $_POST['MaSach'];
    $_SESSION['cart'][$id] = 1;
    header("Location: giohang.php"); exit();
}

if (isset($_POST['confirm_borrow']) && isset($_SESSION['MaTK'])) {
    $maTK = $_SESSION['MaTK'];
    $sl = count($_SESSION['cart']);
    
    $sql = "INSERT INTO lich_su_muon (MaTK, NgayMuon, NgayTra, SoSachMuon, MaTT) 
            VALUES ('$maTK', NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY), '$sl', 1)";
    
    if(mysqli_query($conn, $sql)) {
        foreach($_SESSION['cart'] as $ms => $v){
            mysqli_query($conn, "UPDATE sach SET SoLuong = SoLuong - 1 WHERE MaSach = '$ms'");
        }
        unset($_SESSION['cart']);
        echo "<script>alert('Mượn sách thành công! Vui lòng trả sách sau 14 ngày.'); window.location='index.php';</script>";
    }
}
?>