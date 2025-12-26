
<?php
    include("connect.php");
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

            #Bắt đầu xử lý thêm ảnh
// Xử lý ảnh
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Kiểm tra xem file ảnh có hợp lệ không
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File không phải là ảnh.";
        $uploadOk = 0;
    }
}

// Kiểm tra nếu file đã tồn tại
if (file_exists($target_file)) {
    echo "File này đã tồn tại trên hệ thông";
    $uploadOk = 2;
}

// Kiểm tra kích thước file
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "File quá lớn";
    $uploadOk = 0;
}

// Cho phép các định dạng file ảnh nhất định
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Chỉ những file JPG, JPEG, PNG & GIF mới được chấp nhận.";
    $uploadOk = 0;
}

#Kết thúc xử lý ảnh
if($uploadOk == 0){
    echo "File của bạn chưa được tải lên";
}
else{
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //Đoạn code xử lý login ban đầu
            $sql = "INSERT INTO `tai_khoan`(`SoDienThoai`, `MatKhau`, `HoTen`, `HinhAnh`, `NgaySinh`, `MaQuyen`) VALUES ('$soDienThoai','$matKhau','$hoTen','$target_file','$ngaySinh','$quyen')";
            mysqli_query($conn,$sql);
            $row = mysqli_insert_id($conn);
            header('location: index.php?page_layout=taikhoan');
    }
    
}  
        }else{
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
    <form action="index.php?page_layout=themtaikhoan" method="post" enctype="multipart/form-data">   
        <h1>Thêm tài khoản</h1>
        <div class="box1">
            <p>Số điện thoại</p>
            <input type="text" name="so-dien-thoai" placeholder="Nhập số điện thoại: 0xx.xxx.xxxx">
        </div>
        <div class="box1">
            <p>Mật khẩu</p>
            <input type="password" name="mat-khau" placeholder="Mật khẩu">
        </div>
        <div class="box1">
            <p>Họ và tên</p>
            <input type="text" name="ho-ten" placeholder="Họ và tên">
        </div>
        <div class="box1">
            <p>Hình ảnh</p>
            <input type="file" name="fileToUpload" placeholder="Hình ảnh">
        </div>
        <div class="box1">
            <p>Ngày sinh</p>
            <input type="date" name="ngay-sinh" placeholder="Ngày sinh">
        </div>
        <div class="box1">
            <p>Quyền sử dụng</p>
            <select name="quyen">
                <option value="1">Người dùng</option>
                <option value="2">Admin</option>
            </select>
        </div>
        <div class="box1"><input type="submit" value="Thêm"></div>

    </form>
    <div>
</body>
</html>