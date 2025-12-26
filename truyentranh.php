<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sách Giáo Khoa</title>
    <link rel="stylesheet" href="sachgk.css">
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
        .product-grid{
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
        }
    </style>
</head>
<body>
    
    <main>
        <div class="box-right">
            <div class="product-grid">
            <?php
            include("../admin/connect.php");
            $sql = "SELECT * 
                    FROM sach WHERE MaCD = 10";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_array($result)){
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
                    Mượn
                </a>
            </a></div>
            <?php } ?>
        </div>
    </main>
</body>
</html>