<?php
include "connect.php";
$id = $_GET['id'];
if (isset($_POST['btn_luu'])) {
    $trang_thai_moi = $_POST['chon_trang_thai'];
    $sql_update = "UPDATE lich_su_muon SET MaTT = '$trang_thai_moi' WHERE MaLS = $id";
    mysqli_query($conn, $sql_update);
    header("location: index.php?page_layout=muontra");
}
$sql_don = "SELECT * FROM lich_su_muon 
            INNER JOIN tai_khoan ON lich_su_muon.MaTK = tai_khoan.MaTK 
            INNER JOIN trang_thai ON lich_su_muon.MaTT = trang_thai.MaTT 
            WHERE MaLS = $id";
$query_don = mysqli_query($conn, $sql_don);
$row_don = mysqli_fetch_array($query_don);

$sql_sach = "SELECT * FROM chi_tiet_lich_su_muon 
             INNER JOIN sach ON chi_tiet_lich_su_muon.MaSach = sach.MaSach 
             WHERE MaLS = $id";
$query_sach = mysqli_query($conn, $sql_sach);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chi tiết đơn mượn #<?php echo $id; ?></title>
    <style>
        .khung-lon { 
            display: flex; 
            padding: 20px; 
            background-color: #fff; 
            border-radius: 8px; }
        .cot-trai { 
            width: 45%; 
            padding-right: 30px; 
            border-right: 1px solid #ddd; }
        .cot-phai { 
            width: 55%; 
            padding-left: 30px; }
        .dong { 
            margin-bottom: 15px; 
            border-bottom: 1px solid #f9f9f9; 
            padding-bottom: 10px; }
        .nhan { 
            font-weight: bold; 
            width: 140px; 
            display: inline-block; 
            color: #555; }
        .badge { 
            background: #007bff; 
            color: #fff; 
            padding: 4px 12px; 
            border-radius: 4px; 
            font-size: 14px; }
        .item-sach { 
            display: flex; 
            align-items: center; 
            margin-bottom: 12px; 
            border-bottom: 1px solid #eee; 
            padding-bottom: 8px; }
        .anh-sach { 
            width: 50px; 
            height: 70px; 
            margin-right: 15px; 
            border: 1px solid #ddd;  }
        select { 
            padding: 8px; 
            border-radius: 4px;
            border: 1px solid #ccc; 
            width: 180px; }
        .btn-luu {
            background-color: #28a745;
            color: white;
            padding: 10px 25px;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 15px;}
    </style>
</head>
<body style="background-color: #f4f4f4; margin: 0;">
<div style="padding: 20px; font-family: Arial;">
    <h2 style="margin-bottom: 25px;">
        Chi tiết đơn #<?php echo $id; ?> 
        <span class="badge"><?php echo $row_don['TenTrangThai']; ?></span>
    </h2>

    <div class="khung-lon">
        <div class="cot-trai">
            <div class="dong"><span class="nhan">Người mượn:</span> <?php echo $row_don['HoTen']; ?></div> 
            <div class="dong"><span class="nhan">Ngày mượn:</span> <?php echo $row_don['NgayMuon']; ?></div>
            <div class="dong"><span class="nhan">Hạn trả:</span> <?php echo $row_don['NgayTra']; ?></div>
            <div class="dong"><span class="nhan">Số sách:</span> <?php echo $row_don['SoSachMuon']; ?> cuốn</div>
            <div class="dong"><span class="nhan">Tổng tiền:</span> <b style="color:red;"><?php echo number_format($row_don['TongTien'], 0, ',', '.'); ?>đ</b></div>
            
            <form method="POST">
                <div class="dong" style="border:none;">
                    <span class="nhan">Cập nhật trạng thái:</span>
                    <select name="chon_trang_thai">
                        <?php
                        $sql_all_tt = "SELECT * FROM trang_thai";
                        $query_all_tt = mysqli_query($conn, $sql_all_tt);
                        while($row_tt = mysqli_fetch_array($query_all_tt)) {
                            $check = ($row_tt['MaTT'] == $row_don['MaTT']) ? "selected" : "";
                            echo "<option value='".$row_tt['MaTT']."' $check>".$row_tt['TenTrangThai']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="btn_luu" class="btn-luu">Lưu và Quay lại</button>
            </form>
        </div>

        <div class="cot-phai">
            <div style="display: flex; justify-content: space-between; font-weight: bold; border-bottom: 2px solid #5d5fef; padding-bottom: 8px; margin-bottom: 15px;">
                <span>Sách đã chọn</span>
                <span>Số lượng</span>
            </div>

            <?php while($sach = mysqli_fetch_array($query_sach)) { ?>
                <div class="item-sach">
                    <img src="../user/img/product/<?php echo $sach['HinhAnh']; ?>" class="anh-sach">
                   <div style="flex: 1; font-size: 14px;"><?php echo $sach['TuaSach']; ?></div>
                    <div style="font-weight: bold; color: #5d5fef;"><?php echo $sach['SoLuong']; ?></div>
            </div>
        <?php } ?>
        </div>
    </div>
</div>

</body>
</html>