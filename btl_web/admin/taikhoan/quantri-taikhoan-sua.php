
<?php
    include("connect.php");
    $id = $_GET['id'];
    if(!empty($_POST["so-dien-thoai"])&&
    !empty($_POST["mat-khau"])&&
    !empty($_POST["ho-ten"])&&
    !empty($_POST["ngay-sinh"])&&
    !empty($_POST["quyen"])){

        $soDienThoai = $_POST["so-dien-thoai"];
        $matKhau = $_POST["mat-khau"];
        $hoTen = $_POST["ho-ten"];
        $ngaySinh = $_POST["ngay-sinh"];
        $quyen = $_POST["quyen"];

    // Lấy ảnh cũ
    $sqlOld = "SELECT HinhAnh FROM tai_khoan WHERE MaTK = '$id'";
    $resultOld = mysqli_query($conn, $sqlOld);
    $oldData = mysqli_fetch_assoc($resultOld);
    $oldImage = $oldData["hinh_anh"];

    // Nếu KHÔNG chọn ảnh mới → giữ ảnh cũ
    if ($_FILES["fileToUpload"]["error"] == 4) {
        $target_file = $oldImage;
    }
    else {
        // Có chọn ảnh mới → xử lý upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra file là ảnh
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check === false) {
            echo "File không phải ảnh.";
            $uploadOk = 0;
        }

        // Kiểm tra kích thước
        if ($_FILES["fileToUpload"]["size"] > 10000000) {
            echo "File quá lớn";
            $uploadOk = 0;
        }

        // Chỉ cho phép JPG, PNG, GIF
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" &&
            $imageFileType != "png" && $imageFileType != "gif") {
            echo "Chỉ cho phép file JPG, PNG, GIF.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        } else {
            $target_file = $oldImage;
        }
    }

    // Update dữ liệu
    $sql = "UPDATE `tai_khoan` SET `SoDienThoai`='$soDienThoai',`MatKhau`='$matKhau',`HoTen`='$hoTen',`HinhAnh`='$target_file',`NgaySinh`='$ngaySinh',`MaQuyen`='$quyen' WHERE MaTK = '$id'";

    mysqli_query($conn, $sql);
    header('Location: index.php?page_layout=taikhoan');
    exit();
}
else {
    echo '<p class="warning">Vui lòng nhập đầy đủ thông tin</p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php - Buổi 2</title>
    <style>
        .warning{
            margin-left: 100px;
        }
        h1{
            margin: 5px 0px;
        }
        .container{
            border: 1px solid black;
            border-radius: 10px;
            width: 35%;
            padding: 20px 0;
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-left: 100px;
        }
        form{
            width:80%;
            
        }
        input{
            width:100%;
            padding: 5px 0;

        }
        .box1{
            width:100%;
            margin: 10px 0;
        }
        .select{
            width: 100%;
            padding: 5px 0;
        }
        .warning{
            color: red;
            font-weight: bold;

        } 
    </style>
</head>
<body>
    <?php 
        include("connect.php");
        $sql = "SELECT tk.*, q.Quyen FROM tai_khoan tk JOIN quyen q ON tk.MaQuyen = q.MaQuyen WHERE MaTK = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result)
    ?>
    <div class="container">
    <form action="index.php?page_layout=suataikhoan&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">   
        <h1>Thêm tài khoản</h1>
        <div class="box1">
            <p>Số điện thoại</p>
            <input type="text" name="so-dien-thoai" placeholder="Nhập số điện thoại: 0xx.xxx.xxxx" value="<?php echo $row['SoDienThoai']?>">
        </div>
        <div class="box1">
            <p>Mật khẩu</p>
            <input type="password" name="mat-khau" placeholder="Mật khẩu" value="<?php echo $row['MatKhau']?>">
        </div>
        <div class="box1">
            <p>Họ và tên</p>
            <input type="text" name="ho-ten" placeholder="Họ và tên" value="<?php echo $row['HoTen']?>">
        </div>
        <div class="box1">
            <p>Hình ảnh</p>
            <input type="file" name="fileToUpload" placeholder="Hình ảnh">
        </div>
        <div class="box1">
            <p>Ngày sinh</p>
            <input type="date" name="ngay-sinh" placeholder="Ngày sinh" value="<?php echo $row['NgaySinh']?>">
        </div>
        <div class="box1">
            <p>Quyền sử dụng</p>
            <select name="quyen">
                <option value="1" <?php echo ($row['MaQuyen'] == 1) ? "selected" : ""; ?>>Người dùng</option>
                <option value="2" <?php echo ($row['MaQuyen'] == 2) ? "selected" : ""; ?>>Admin</option>
            </select>
        </div>
        <div class="box1"><input type="submit" value="Cập nhật"></div>

    </form>
    <div>
</body>
</html>