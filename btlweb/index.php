<?php require_once 'connect.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thư viện thành phố</title>
    <link rel="stylesheet" href="trangchu.css">
</head>
<body>
    <header>
        <ul class="menu">
            <li style="font-size: 20px;"><a href="index.php">Thư viện thành phố</a></li>
            <li><a href="index.php">Trang chủ</a></li>
        </ul>
        <ul class="menu">
            <?php if (isset($_SESSION["hoTen"])): ?>
                <li><a href="giohang.php">Giỏ hàng (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></li>
                <li><a href="#">Xin chào, <?php echo $_SESSION["hoTen"]; ?></a>
                    <ul class="sub-menu">
                        <li><a href="index.php?page_layout=dangxuat">Đăng xuất</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li><a href="index.php?page_layout=dangky">Đăng ký</a></li>
                <li><a href="index.php?page_layout=dangnhap">Đăng nhập</a></li>
            <?php endif; ?>
        </ul>
    </header>

    <main style="padding: 20px; width: 85%; margin: auto;">
        <?php
        $page = $_GET['page_layout'] ?? 'home';
        switch($page){
            case 'dangnhap': include "dangnhap.php"; break;
            case 'dangky': include "dangky.php"; break;
            case 'chitiet': include "chitiet.php"; break;
            case 'dangxuat': 
                session_destroy(); 
                header("Location: index.php"); 
                break;
            default:
                // Hiển thị danh sách sách từ DB
                $sql = "SELECT * FROM sach";
                $res = mysqli_query($conn, $sql);
                echo '<div style="display:grid; grid-template-columns: repeat(4, 1fr); gap: 25px;">';
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "
                    <div style='border: 1px solid #eee; padding: 15px; border-radius:10px; text-align:center; background:white; box-shadow: 0 4px 8px rgba(0,0,0,0.05);'>
                        <img src='images/{$row['HinhAnh']}' style='width:100%; height:280px; object-fit:cover; border-radius:5px;'>
                        <h3 style='font-size:18px; color:#333; margin:10px 0;'>{$row['TuaSach']}</h3>
                        <p style='color:#666;'>Tác giả: {$row['TacGia']}</p>
                        <a href='index.php?page_layout=chitiet&id={$row['MaSach']}' style='background:rgb(89, 89, 211); color:white; padding:10px 20px; display:inline-block; border-radius:5px; margin-top:10px;'>Xem chi tiết</a>
                    </div>";
                }
                echo '</div>';
                break;
        }
        ?>
    </main>
</body>
</html>