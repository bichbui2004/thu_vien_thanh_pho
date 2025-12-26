
<?php
    include("connect.php");

    if(
        !empty($_POST["tua-sach"]) &&
        !empty($_POST["tac-gia"]) &&
        !empty($_POST["gia-tri"]) &&
        !empty($_POST["mo-ta"]) &&
        !empty($_POST["ma-cd"]) &&
        !empty($_POST["so-luong"])
    ){

        $tuaSach = $_POST["tua-sach"];
        $tacGia  = $_POST["tac-gia"];
        $giaTri  = $_POST["gia-tri"];
        $moTa    = $_POST["mo-ta"];
        $maCD    = $_POST["ma-cd"];
        $soLuong = $_POST["so-luong"];

        // =======================
        // XỬ LÝ UPLOAD ẢNH
        // =======================
        $target_dir  = "uploads/";
        $hinhAnh     = $_FILES["fileToUpload"]["name"]; // FIX: khai báo biến
        $target_file = $target_dir . basename($hinhAnh);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra file ảnh
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check === false){
            echo "File không phải là ảnh.";
            $uploadOk = 0;
        }

        // Kiểm tra file tồn tại
        if (file_exists($target_file)) {
            echo "File này đã tồn tại trên hệ thống.";
            $uploadOk = 0; // FIX: không dùng =2
        }

        // Kiểm tra kích thước
        if ($_FILES["fileToUpload"]["size"] > 10000000) {
            echo "File quá lớn.";
            $uploadOk = 0;
        }

        // Kiểm tra định dạng
        if(
            $imageFileType != "jpg" &&
            $imageFileType != "png" &&
            $imageFileType != "jpeg" &&
            $imageFileType != "gif"
        ){
            echo "Chỉ chấp nhận JPG, JPEG, PNG, GIF.";
            $uploadOk = 0;
        }

        // =======================
        // UPLOAD & INSERT
        // =======================
        if($uploadOk == 0){
            echo "File của bạn chưa được tải lên.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

                $sql = "INSERT INTO sach
                        (TuaSach, HinhAnh, TacGia, GiaTri, MoTa, MaCD, SoLuong)
                        VALUES
                        ('$tuaSach','$hinhAnh','$tacGia','$giaTri','$moTa','$maCD','$soLuong')";

                mysqli_query($conn, $sql);
                header('location: index.php?page_layout=sach');
            }
        }

    } else {
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
    <div class="container">
    <form action="index.php?page_layout=themsach" method="post" enctype="multipart/form-data">   
        <h1>Thêm sách</h1>
        <div class="box1">
            <p>Tên sách</p>
            <input type="text" name="tua-sach" placeholder="Nhập tên sách">
        </div>
        <div class="box1">
            <p>Hình ảnh</p>
            <input type="file" name="fileToUpload" placeholder="hình ảnh">
        </div>
        <div class="box1">
            <p>Tác giả</p>
            <input type="text" name="tac-gia" placeholder="Nhập tên tác giả">
        </div>
        <div class="box1">
            <p>Giá trị</p>
            <input type="text" name="gia-tri" placeholder="Nhập tiền">
        </div>
        <div class="box1">
            <p>Mô tả</p>
            <input type="text" name="mo-ta" placeholder="Nhập mô tả">
        </div>
        <div class="box1">
            <p>Mã chủ đề</p>
            <input type="text" name="ma-cd" placeholder="Nhập">
        </div>
        <div class="box1">
            <p>Số lượng</p>
            <input type="text" name="so-luong" placeholder="Nhập số lượng">
        </div>
        
        <div class="box1"><input type="submit" value="Thêm"></div>

    </form>
    <div>
</body>
</html>