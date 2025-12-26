<?php
    session_start();
    include("../admin/connect.php");
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?page_layout=dangnhap");
        exit();
    }
    $id = $_SESSION['user_id'];
    if (isset($_POST['capnhat'])) {
        if(!empty($_POST["sodienthoai"])&&
        !empty($_POST["matkhau"])&&
        !empty($_POST["hoten"])){

            $soDienThoai = $_POST["sodienthoai"];
            $matKhau = $_POST["matkhau"];
            $hoTen = $_POST["hoten"];
            $ngaySinh = $_POST["ngaysinh"];

        // Lấy ảnh cũ
        $sqlOld = "SELECT HinhAnh FROM tai_khoan WHERE MaTK = '$id'";
        $resultOld = mysqli_query($conn, $sqlOld);
        $oldData = mysqli_fetch_assoc($resultOld);
        $oldImage = $oldData["HinhAnh"];

        // Nếu KHÔNG chọn ảnh mới → giữ ảnh cũ
        if ($_FILES["fileToUpload"]["error"] == 4) {
            $target_file = $oldImage;
        }
        else {
            // Có chọn ảnh mới → xử lý upload
            $target_dir = "../admin/uploads/";
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
        $sql = "UPDATE `tai_khoan` SET `SoDienThoai`='$soDienThoai',`MatKhau`='$matKhau',`HoTen`='$hoTen',`HinhAnh`='$target_file',`NgaySinh`='$ngaySinh' WHERE MaTK = '$id'";

        mysqli_query($conn, $sql);
        header('Location: taikhoancuatoi.php');
        exit();
    }
    else {
        echo '<p class="warning">Vui lòng nhập đầy đủ thông tin</p>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản</title>
    <link rel="stylesheet" href="taikhoancuatoi.css">
</head>
<body>
    <main>
        <?php 
            $sql = "SELECT * FROM tai_khoan  WHERE MaTK = '$id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result)
        ?>
        <h1 align="center" style="color:rgb(39, 39, 105); font-family: Cambria; margin-bottom: 15px;">Hồ sơ của tôi</h1>
        <div class="thongtin">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="tt">
                    <div>Họ tên:</div> 
                    <div><input type="text" name="hoten" value="<?php echo $row['HoTen']?>"></div>
                </div>
                <div class="tt">
                    <div>Mật khẩu:</div> 
                    <div><input type="text" name="matkhau" value="<?php echo $row['MatKhau']?>"></div>
                </div>
                <div class="tt">
                    <div>Số điện thoại:</div> 
                    <div><input type="text" name="sodienthoai" value="<?php echo $row['SoDienThoai']?>"></div>
                </div>
                <div class="tt">
                    <div>Ngày sinh:</div>
                    <div><input type="date" name="ngaysinh" value="<?php echo $row['NgaySinh']?>"></div>
                </div> 
                
                <div style="margin-top: 20px; border: 1px dashed #ccc; padding: 10px;">
                    <p style="font-size: 14px;">Thay ảnh đại diện mới:</p>
                    <input type="file" name="fileToUpload">
                </div>

                <div align="center">
                    <input name="capnhat" style="font-size: 20px; border-radius: 5px; background-color: rgb(90, 55, 167); color: white; padding: 10px; cursor: pointer;" type="submit" value="Lưu tất cả">
                </div>
            </form>

            <div class="anh-preview" align="center">
                <p>Ảnh hiện tại:</p>
                <img src="../admin/<?php echo $row['HinhAnh'] ?>" width="250px" style="border-radius: 10px; border: 2px solid #5a37a7;"><br>
                <button style="margin-top: 15px;"><a href="index.php?page_layout=trangchu" style="color: black;">Quay lại trang chủ</a></button>
            </div>
        </div>
    </main>
</body>
</html>

