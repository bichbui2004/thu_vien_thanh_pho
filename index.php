<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="trangchu.css">
</head>
<body>
    <?php
    session_start();
    ?>
    <header>
        <ul class="menu">
            <li style="font-size: 20px;"><a href="index.php?page_layout=trangchu">Thư viện thành phố</a></li>
            <li><a href="index.php?page_layout=trangchu">Trang chủ</a></li>
            <li><a href="index.php?page_layout=chude">Chủ đề</a>
                <ul class="sub-menu">
                    <li><a href="index.php?page_layout=tieuthuyet" >Tiểu thuyết</a></li>
                    <li><a href="index.php?page_layout=trinhtham">Trinh thám</a></li>
                    <li><a href="index.php?page_layout=truyentranh">Truyện tranh</a></li>
                    <li><a href="index.php?page_layout=SGK">SGK</a></li>
                </ul>
            </li>
        </ul>
        <ul class="menu">
            <?php if (isset($_SESSION["hoTen"])): ?>
                <li><a href="#">Giỏ hàng</a></li>
                <li><?php echo "Xin chào " . $_SESSION["hoTen"]; ?></a>
                    <ul class="sub-menu">
                        <li><a href="taikhoancuatoi.php">Thông tin tài khoản</a></li>
                        <li><a href="index.php?page_layout=lichsumuon">Lịch sử mượn sách</a></li>
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
            <div class="timkiem">
                <input type="text" id="search" name="timkiem" placeholder="Nhập tựa sách cần tìm"><button>Tìm</button>
            </div>
            <ul class="tab-menu">
                <li class="border" style="background-color: rgb(58, 58, 211); color: white; border-radius: 10px 10px 0px 0px;">Sách đọc nhiều</li>
                <li class="border">1. Đắc nhân tâm</li>
                <li class="border">2. Tuổi trẻ đáng giá bao nhiêu?</li>
                <li class="border">3. Bí quyết không ăn mà vẫn sống</li>
                <li>4. Sắc đẹp ngàn cân</li>
            </ul>
        </div>
        <div class="box-right">
            <?php
            if(isset($_GET['page_layout'])){
                switch($_GET['page_layout']){
                    case 'lichsumuon':
                        include "lichsumuonsach.php";
                        break;
                    case 'dangnhap':
                        include "dangnhap.php";
                        break;
                    case 'dangky':
                        include "dangky.php";
                        break;
                    case 'dangxuat':
                        session_unset();      // Xóa biến session
                        session_destroy();    // Hủy session
                        header("Location: index.php");
                        exit();
                }
            }else{
                    include "trangchu.php";
            }
            ?>
        </div>
    </main>
</body>
</html>