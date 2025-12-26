<?php
session_start();
$tukhoa = "";
if(isset($_GET['tukhoa'])){
    $tukhoa = trim($_GET['tukhoa']);
}
include("../admin/connect.php");
if(isset($_GET['page_layout']) && $_GET['page_layout'] == 'dangxuat'){
session_unset();
session_destroy();
header("Location: index.php");
exit();
}
?>
<?php 
include('../admin/connect.php');
if(isset($_POST['hoten']) && isset($_POST['matkhau']) && isset($_POST['sodienthoai'])){
$hoTen = $_POST['hoten']; 
$soDienThoai = $_POST['sodienthoai'];  
$matKhau = $_POST['matkhau'];  
$sql = "SELECT * from tai_khoan tk where HoTen = '$hoTen' and MatKhau = '$matKhau' and SoDienThoai = '$soDienThoai' "; 
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0){
    $nguoiDung = mysqli_fetch_assoc($result);
    $_SESSION["hoTen"] = $nguoiDung["HoTen"];
    $_SESSION["id_quyen"] = $nguoiDung["MaQuyen"];
    $_SESSION['user_id'] = $nguoiDung['MaTK'];
    if ($_SESSION["id_quyen"] == 2) {
        header('location: ../admin/index.php');
    } else {
            echo "<script>location.href='index.php';</script>";
        }
        exit(); 
    }
else{
    echo "<p class='warning'>Sai thong tin dang nhap</p>";
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="trangchu.css">
    <style>
        .khung {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .khung:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }

        .khung img {
            width: 150px;
            height: 220px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .khung a{
            color: black
        }
        .ttin1 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .ttin1 small {
            display: block;
            font-weight: normal;
            color: #666;
        }

        .ttin2 {
            color: #d0021b;
            font-weight: bold;
            margin: 10px 0;
        }

        .muon {
            display: inline-block;
            padding: 8px 16px;
            background: #2d2dfc;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.2s;
        }

        .muon:hover {
            background: #1b1bd8;
        }
        .ketqua{
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
        }
    </style>
</head>
<body>
    <header>
        <ul class="menu">
            <li style="font-size: 20px;"><a href="index.php?page_layout=trangchu">Thư viện thành phố</a></li>
            <li><a href="index.php?page_layout=trangchu">Trang chủ</a></li>
            <li><a href="index.php?page_layout=trangchu">Chủ đề</a>
                <ul class="sub-menu">
                    <li><a href="index.php?page_layout=tieuthuyet" >Tiểu thuyết</a></li>
                    <li><a href="index.php?page_layout=trinhtham">Kỹ năng sống</a></li>
                    <li><a href="index.php?page_layout=truyentranh">Thiếu nhi</a></li>
                    <li><a href="index.php?page_layout=SGK">SGK</a></li>
                </ul>
            </li>
        </ul>
        <ul class="menu">
            <?php if (isset($_SESSION["hoTen"])): ?>
                <li><a href="giohang.php">Giỏ hàng</a></li>
                <li><?php echo "Xin chào " . $_SESSION["hoTen"]; ?></a>
                    <ul class="sub-menu">
                        <li><a href="taikhoancuatoi.php">Thông tin tài khoản</a></li>
                        <li><a href="lichsumuonsach.php">Lịch sử mượn sách</a></li>
                        <li><a href="index.php?page_layout=dangxuat"
                            onclick="return confirm('Bạn chắc chắn muốn đăng xuất?')">Đăng xuất</a>
                        </li>
                    </ul>
                </li>
            <?php else: ?>
                <li><a href="index.php?page_layout=dangnhap">Đăng nhập</a></li>
                <li><a href="index.php?page_layout=dangky">Đăng ký</a></li>
            <?php endif; ?>
        </ul>
    </header>
    <div class="banner">
        <img src="anh1.jpg" width="100%">
    </div>
    <main>
        <div class="box-left">
            <form method="get" action="index.php" class="timkiem">
                <input type="hidden" name="page_layout" value="timkiem">
                <input type="text"  name="tukhoa" placeholder="Nhập tựa sách cần tìm" value="<?php echo($tukhoa) ?>" ><button type="submit">Tìm</button>
            </form>
            <ul class="tab-menu">
                <li class="border" style="background-color: rgb(58, 58, 211); color: white; border-radius: 10px 10px 0px 0px;">Sách mới</li>
                <?php 
                    $sql = "SELECT * FROM sach ORDER BY MaSach DESC LIMIT 5 ";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_array($result)){
                ?>
                <li class="border"><a href="index.php?page_layout=chitietsach&id=<?php echo $row['MaSach']; ?>" style="color: black"><?php echo $row['TuaSach']?></a></li>
                <?php }?>
            </ul>
        </div>
        <div class="box-right">
        <div class="ketqua"> 
        <?php
        $tukhoa = "";
        if(isset($_GET['tukhoa'])){
            $tukhoa = trim($_GET['tukhoa']);
        }

        if ($tukhoa != "") {
            $sql = "SELECT s.*, cd.TenChuDe 
                    FROM sach s 
                    JOIN chu_de cd ON s.MaCD = cd.MaCD
                    WHERE LOWER(s.TuaSach) LIKE LOWER('%$tukhoa%')
                    OR LOWER(s.TacGia) LIKE LOWER('%$tukhoa%')
                    OR LOWER(cd.TenChuDe) LIKE LOWER('%$tukhoa%')";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
        ?>       
            <div class="khung"><a href="index.php?page_layout=chitietsach&id=<?php echo $row['MaSach']; ?>">
                <img src="../img/product/<?php echo $row['HinhAnh']; ?>" 
                    alt="<?php echo $row['TuaSach']; ?>">

                <div class="ttin1">
                    <?php echo $row['TuaSach']; ?>
                    <small><?php echo $row['TacGia']; ?></small>
                </div>

                <div class="ttin2">
                    <?php echo number_format($row['GiaTri'], 0, ',', '.'); ?>đ
                </div>

                <a class="muon"
                href="themvaogio.php?MaSach=<?php echo $row['MaSach']; ?>">
                    Mua
                </a>
            </a></div>
        <?php
                }
            } else {
                echo "<p>Không tìm thấy kết quả phù hợp</p>";
            }
        }
        ?>
        </div>

            <?php
            if(isset($_GET['page_layout'])){
                switch($_GET['page_layout']){
                    case 'dangnhap':
                        include "dangnhap.php";
                        break;
                    case 'dangky':
                        include "dangky.php";
                        break;
                    case 'chitietsach':
                        include "chitiet.php";
                        break;
                    case 'trangchu':
                        include "trangchu.php";
                        break;
                    case 'tieuthuyet':
                        include "../user/chude/tieuthuyet.php";
                        break;
                    case 'trinhtham':
                        include "../user/chude/trinhtham.php";
                        break;
                    case 'truyentranh':
                        include "../user/chude/truyentranh.php";
                        break;
                    case 'SGK':
                        include "../user/chude/SGK.php";
                        break;
                }
            }else{
                    include "trangchu.php";
            }
            ?>
        </div>
    </main>
</body>
</html>