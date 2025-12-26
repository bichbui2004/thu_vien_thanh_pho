<?php
    include("../admin/connect.php");
    if(!empty($_POST["hoten"])&&
        !empty($_POST["matkhau"])&&
        !empty($_POST["sodienthoai"])){

            $hoTen = $_POST['hoten']; 
            $soDienThoai = $_POST['sodienthoai'];  
            $matKhau = $_POST['matkhau'];

            $sql = "SELECT MaTK FROM tai_khoan WHERE SoDienThoai = '$soDienThoai'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0){
                echo '<p class="warning">Tài khoản này đã tồn tại</p>';
            }else{

            $sql = "INSERT INTO `tai_khoan`(`SoDienThoai`, `MatKhau`, `HoTen`, `MaQuyen`) VALUES ('$soDienThoai','$matKhau','$hoTen','1')";
            mysqli_query($conn,$sql);
            mysqli_close($conn);
            header('location: index.php?page_layout=dangnhap');}
        }else{
            echo '<p class="warning">Vui lòng nhập đầy đủ thông tin</p>';
        }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="dangky.css">
</head>
<body>
    <form action="index.php?page_layout=dangky" method="post">
        <h1>Đăng ký</h1>
        <div class="tt">Họ tên<br>
            <input type="text" name="hoten">
        </div>
        <div class="tt">Số điện thoại<br>
            <input type="text" name="sodienthoai">
        </div>
        <div class="tt">Mật khẩu<br>
            <input type="text" name="matkhau">
        </div>
    <div class="btn"><input type="submit" name="dangky" value="Đăng ký"></div>      
    </form>
        
</body>
</html>