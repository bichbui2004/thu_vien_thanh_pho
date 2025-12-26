
<?php
    include("connect.php");
    $id = $_GET['id'];

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

        // LẤY ẢNH CŨ TỪ DB  // FIX
        $sql_old = "SELECT HinhAnh FROM sach WHERE MaSach = '$id'";
        $rs_old = mysqli_query($conn, $sql_old);
        $row_old = mysqli_fetch_array($rs_old);
        $oldImage = $row_old['HinhAnh'];

        // ======================
        // XỬ LÝ ẢNH
        // ======================
        if ($_FILES["fileToUpload"]["error"] == 4) {
            // Không chọn ảnh mới → giữ ảnh cũ
            $hinhAnh = $oldImage; // FIX
        } else {
            $target_dir = "uploads/";
            $hinhAnh = $_FILES["fileToUpload"]["name"]; // FIX
            $target_file = $target_dir . basename($hinhAnh);

            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check === false) {
                echo "File không phải ảnh.";
                $uploadOk = 0;
            }

            if ($_FILES["fileToUpload"]["size"] > 10000000) {
                echo "File quá lớn";
                $uploadOk = 0;
            }

            if (
                $imageFileType != "jpg" &&
                $imageFileType != "jpeg" &&
                $imageFileType != "png" &&
                $imageFileType != "gif"
            ) {
                echo "Chỉ cho phép JPG, PNG, GIF.";
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
            } else {
                $hinhAnh = $oldImage; // FIX
            }
        }

        // ======================
        // UPDATE
        // ======================
        $sql = "UPDATE sach SET
                TuaSach = '$tuaSach',
                HinhAnh = '$hinhAnh',
                TacGia = '$tacGia',
                GiaTri = '$giaTri',
                MoTa = '$moTa',
                MaCD = '$maCD',
                SoLuong = '$soLuong'
                WHERE MaSach = '$id'"; // FIX

        mysqli_query($conn, $sql);
        header('location: index.php?page_layout=sach');

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
    <?php 
        include("connect.php");
        $sql = "SELECT * FROM sach WHERE MaSach = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result)
    ?>
    <div class="container">
    <form action="index.php?page_layout=suasach&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">   
        <h1>Cập nhật sách</h1>
        <div class="box1">
            <p>Tên sach</p>
            <input type="text" name="tua-sach" placeholder="Nhập tên sách" value="<?php echo $row['TuaSach']?>">
        </div>
        <div class="box1">
            <p>Hình ảnh</p>
            <input type="file" name="fileToUpload" placeholder="hình ảnh"value="<?php echo $row['HinhAnh']?>">
        </div>
        <div class="box1">
            <p>Tác giả</p>
            <input type="text" name="tac-gia" placeholder="Nhập tên tác giả"value="<?php echo $row['TacGia']?>">
        </div>
        <div class="box1">
            <p>Giá trị</p>
            <input type="text" name="gia-tri" placeholder="Nhập tiền"value="<?php echo $row['GiaTri']?>">
        </div>
        <div class="box1">
            <p>Mô tả</p>
            <input type="text" name="mo-ta" placeholder="Nhập mô tả"value="<?php echo $row['MoTa']?>">
        </div>
        <div class="box1">
            <p>Mã chủ đề</p>
            <input type="text" name="ma-cd" placeholder="Nhập"value="<?php echo $row['MaCD']?>">
        </div>
        <div class="box1">
            <p>Số lượng</p>
            <input type="text" name="so-luong" placeholder="Nhập số lượng"value="<?php echo $row['SoLuong']?>">
        </div>

        <div class="box1"><input type="submit" value="Cập nhật"></div>

    </form>
    <div>
</body>
</html>