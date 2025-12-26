<?php
include "connect.php"; 

$sql = "SELECT ls.MaLS, tk.HoTen, ls.NgayMuon, ls.NgayTra, ls.SoSachMuon, ls.TongTien, tt.TenTrangThai 
        FROM lich_su_muon ls
        INNER JOIN tai_khoan tk ON ls.MaTK = tk.MaTK
        INNER JOIN trang_thai tt ON ls.MaTT = tt.MaTT
        ORDER BY ls.MaLS DESC";
$query = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quản lý mượn trả</title>
    <style>
        .container-muontra { 
            padding: 20px; 
            margin: 20px; 
            border-radius: 8px;  }
        .tieude { 
            font-size: 20px; 
            margin-bottom: 20px;  
             }
        table { 
            width: 100%; 
            margin-top: 10px; }
        th, td { 
            padding: 12px 10px; 
            
            text-align: left; 
            font-size: 14px; }
        th { 
            color: black; 
            font-weight: 600;
           
            }
        .status-label {
            padding: 5px 12px;
            font-size: 12px;
            color: white;
            display: inline-block;
            text-align: center;
        }
        .status-cho-xac-nhan { background-color: #777; } 
        .status-cho-giao { background-color: #007bff; } 
        .status-dang-muon { background-color: #28a745; } 
        .status-da-tra { background-color: #17a2b8; } 
        .btn-view {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="container-muontra">
    <div class="tieude">Mượn/Trả</div>
    <table>
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Người mượn</th>
                <th>Ngày mượn</th>
                <th>Ngày trả (dự kiến)</th>
                <th>Số sách</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($row = mysqli_fetch_array($query)){ 
            ?>
            <tr>
                <td><?php echo $row['MaLS']; ?></td>
                <td><?php echo $row['HoTen']; ?></td>
                <td><?php echo date("d/m/Y H:i:s", strtotime($row['NgayMuon'])); ?></td>
                <td><?php echo date("d/m/Y H:i:s", strtotime($row['NgayTra'])); ?></td>
                <td><?php echo $row['SoSachMuon']; ?></td>
                <td><?php echo number_format($row['TongTien'], 0, ',', '.'); ?>đ</td>
                <td>
                    <?php 
                        $class_status = "status-cho-xac-nhan"; 
                        if($row['TenTrangThai'] == 'Chờ giao') $class_status = "status-cho-giao";
                        if($row['TenTrangThai'] == 'Đang mượn') $class_status = "status-dang-muon";
                        if($row['TenTrangThai'] == 'Đã trả') $class_status = "status-da-tra";
                    ?>
                    <span class="status-label <?php echo $class_status; ?>">
                        <?php echo $row['TenTrangThai']; ?>
                    </span>
                </td>
                <td>
                    <a href="index.php?page_layout=chitietmuon&id=<?php echo $row['MaLS']; ?>" class="btn-view" title="Xem chi tiết">
                        👁
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>