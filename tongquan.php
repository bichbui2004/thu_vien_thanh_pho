<?php
include 'connect.php';
$query1 = mysqli_query($conn, "SELECT * FROM sach");
$tong_sach = mysqli_num_rows($query1);

$query2 = mysqli_query($conn, "SELECT * FROM tai_khoan WHERE MaQuyen = 1");
$tong_bandoc = mysqli_num_rows($query2);

$query3 = mysqli_query($conn, "SELECT * FROM chu_de");
$tong_chude = mysqli_num_rows($query3);

$query4 = mysqli_query($conn, "SELECT * FROM lich_su_muon");
$tong_luotmuon = mysqli_num_rows($query4);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thống kê thư viện</title>
    <style>
        .khung-thong-ke {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
        }
        .o-vuong {
            width: 20%;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #fff;
        }
        .o-vuong a {
            display: block;
            padding: 30px 10px;
            text-decoration: none;
            text-align: center;
        }
        .o-vuong h3 {
            font-weight: normal;
            color:black;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif; 
            font-weight: 600;
        }
        .o-vuong b {
            font-size: 30px;
            display: block;
            margin-top: 15px;
            color: #000;
            font-family: Arial, Helvetica, sans-serif; 
        }
    </style>
</head>
<body>

    <div class="khung-thong-ke">
        
        <div class="o-vuong">
            <a href="index.php?page_layout=sach">
                <h3>Đầu sách</h3>
                <b><?php echo $tong_sach; ?></b>
            </a>
        </div>

        <div class="o-vuong">
            <a href="index.php?page_layout=taikhoan">
                <h3>Bạn đọc</h3>
                <b><?php echo $tong_bandoc; ?></b>
            </a>
        </div>

        <div class="o-vuong">
            <a href="index.php?page_layout=chude">
                <h3>Chủ đề</h3>
                <b><?php echo $tong_chude; ?></b>
            </a>
        </div>

        <div class="o-vuong">
            <a href="index.php?page_layout=muontra">
                <h3>Lượt mượn</h3>
                <b><?php echo $tong_luotmuon; ?></b>
            </a>
        </div>

    </div>
</body>
</html>