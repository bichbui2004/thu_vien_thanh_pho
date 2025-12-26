<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản</title>
    <link rel="stylesheet" href="quantri-taikhoan.css">
</head>
<body>
    <div class="box-trai">
        <div class="title" align="center">TRANG QUẢN LÝ</div>
        <ul class="box">
            <li><a href="index.php?page_layout=tongquan">Tổng quan</a></li>
            <li><a href="index.php?page_layout=taikhoan">Tài khoản</a></li>
            <li><a href="index.php?page_layout=chude">Chủ đề</a></li>
            <li><a href="index.php?page_layout=sach">Sách</a></li>
            <li><a href="index.php?page_layout=muontra">Mượn/trả</a></li>
        </ul>
    </div>
    <div class="box-phai">
        <ul class="menu">
            <li><a href="../user/index.php?page_layout=trangchu" style="font-size: 25px; font-weight: 100;font-family: Arial, Helvetica, sans-serif; padding: 5px;color: white;">Thư viện thành phố</a></li>
            <li><a href="" style="font-size: 15px; font-weight: 100;font-family: Arial, Helvetica, sans-serif; padding: 5px;color: white;"><?php echo "Xin chào " . $_SESSION["hoTen"]; ?></a>
                <ul class="sub-menu">
                    <li><a href="../user/index.php?page_layout=trangchu">Trang chủ</a></li>
                    <li><a href="index.php?page_layout=dangxuat"
                            onclick="return confirm('Bạn chắc chắn muốn đăng xuất?')">Đăng xuất
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <div>
            <?php
            if(isset($_GET['page_layout'])){
                switch($_GET['page_layout']){
                    case 'tongquan':
                        include "tongquan.php";
                        break;
                    case 'taikhoan':
                        include "taikhoan/quantri-taikhoan.php";
                        break;
                    case 'themtaikhoan':
                        include "taikhoan/quantri-taikhoan-them.php";
                        break;
                    case 'suataikhoan':
                        include "taikhoan/quantri-taikhoan-sua.php";
                        break;
                    case 'chude':
                        include "chude/quantri-chude.php";
                        break;
                    case 'themchude':
                        include "chude/quantri-chude-them.php";
                        break;
                    case 'suachude':
                        include "chude/quantri-chude-sua.php";
                        break;
                    case 'muontra':
                        include "muontra/muontra.php";
                        break;
                    case 'chitietmuon':
                        include "muontra/chitietmuontra.php";
                        break;
                    case 'sach':
                        include "sach/quantri-sach.php";
                        break;
                    case 'themsach':
                        include "sach/quantri-sach-themsach.php";
                        break;
                    case 'suasach':
                        include "sach/quantri-sach-sua.php";
                        break;
                    case 'xoasach':
                        include "sach/xoasach.php";
                        break;
                    case 'dangxuat':
                        session_unset();      // Xóa biến session
                        session_destroy();    // Hủy session
                        header("Location: ../user/index.php");
                        exit();
                }
            }else{
                    include "tongquan.php";
            }
            ?>
        </div>
    </div>
</body>
</html>
