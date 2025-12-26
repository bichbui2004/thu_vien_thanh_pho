<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản</title>
    <link rel="stylesheet" href="quantri-taikhoan.css">
    <style>
        .quyen{
            border-radius: 10px;
            background-color: rgba(59, 213, 126, 1);
            color: white;
            padding: 7px;
            font-weight:bold;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tài khoản</h1>
        <a href="index.php?page_layout=themtaikhoan"><button>Thêm tài khoản</button></a>
    </div>
    <table class="ds-taikhoan">
        <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Họ tên</th>
            <th>Số điện thoại</th>
            <th>Quyền truy cập</th>
            <th>Hành động</th>
        </tr>
        <?php 
            include("connect.php");
            $sql = "SELECT tk.*, q.Quyen FROM tai_khoan tk JOIN quyen q ON tk.MaQuyen = q.MaQuyen ";
            $result = mysqli_query($conn, $sql);
            $stt = 1;
            while($row = mysqli_fetch_array($result)){
        ?>
        <tr align="center">
            <td><?php echo $stt++?></td>
            <td><img src="<?php echo $row["HinhAnh"] ?>" class="anh-tk" style="width:32px;height:32px;object-fit: cover;"></td>
            <td class="hoTen"><?php echo $row["HoTen"] ?></td>
            <td class="sdt"><?php echo $row["SoDienThoai"] ?></td>
            <td>
                <span class="quyen"><?php echo $row["Quyen"] ?></span>
            </td>
            <td class="hanhDong">
                <a class="btn-fix" href="index.php?page_layout=suataikhoan&id=<?php echo $row["MaTK"] ?>">Cập nhật</a>
                <a class="btn-delete" href="taikhoan/xoataikhoan.php?id=<?php echo $row['MaTK']; ?>"onclick="return confirm('Bạn chắc chắn muốn xóa tài khoản <?php echo $row['HoTen'] ?>?')">Xóa</a>
            </td>
        </tr>
        <?php }?>   
    </table>
    
</body>
</html>