<?php 
if(isset($_POST['dangnhap'])){
    $hoTen = $_POST['hoten']; 
    $soDienThoai = $_POST['sodienthoai'];  
    $matKhau = $_POST['matkhau'];  
    $sql = "SELECT * FROM tai_khoan WHERE HoTen = '$hoTen' AND MatKhau = '$matKhau' AND SoDienThoai = '$soDienThoai'"; 
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $_SESSION["hoTen"] = $user["HoTen"];
        $_SESSION["MaTK"] = $user["MaTK"];
        $_SESSION["id_quyen"] = $user["MaQuyen"];
        header('location: index.php');
        exit();
    } else { echo "<p style='color:red; text-align:center;'>Sai thông tin đăng nhập!</p>"; }
}
?>
<form method="post" style="max-width:400px; margin: 50px auto; padding:30px; border:1px solid #ddd; border-radius:10px;">
    <h1 style="text-align:center; color:rgb(89, 89, 211);">Đăng nhập</h1>
    <input type="text" name="hoten" placeholder="Họ tên" required style="width:100%; padding:10px; margin:10px 0;">
    <input type="text" name="sodienthoai" placeholder="Số điện thoại" required style="width:100%; padding:10px; margin:10px 0;">
    <input type="password" name="matkhau" placeholder="Mật khẩu" required style="width:100%; padding:10px; margin:10px 0;">
    <input type="submit" name="dangnhap" value="Vào thư viện" style="width:100%; padding:10px; background:rgb(89, 89, 211); color:white; border:none; cursor:pointer;">
</form>