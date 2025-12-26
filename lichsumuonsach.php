<?php
include "../admin/connect.php"; 
if (!isset($_SESSION["user_id"])) {
    echo "<h3 style='padding:20px; color:red;'>Vui lòng đăng nhập để xem lịch sử!</h3>";
    return;
}
$maTK = $_SESSION["user_id"]; 
$tim_kiem = "";
if(isset($_POST['nut_tim'])) {
    $tim_kiem = $_POST['o_tim_kiem'];
}
$loc_trang_thai = "";
if(isset($_POST['loc_trang_thai'])) {
    $loc_trang_thai = $_POST['loc_trang_thai'];
}

$sql = "SELECT s.TuaSach, s.TacGia, s.HinhAnh, ls.NgayMuon, ls.NgayTra, tt.TenTrangThai 
        FROM chi_tiet_lich_su_muon ct
        INNER JOIN lich_su_muon ls ON ct.MaLS = ls.MaLS
        INNER JOIN sach s ON ct.MaSach = s.MaSach
        INNER JOIN trang_thai tt ON ls.MaTT = tt.MaTT
        WHERE ls.MaTK = $maTK 
        AND s.TuaSach LIKE '%$tim_kiem%'";
if($loc_trang_thai != "" && $loc_trang_thai != "Tất cả trạng thái") {
    $sql .= " AND tt.TenTrangThai = '$loc_trang_thai'";
}
$sql .= " ORDER BY ls.MaLS DESC";
$query = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> 
    <title>Lịch sử mượn sách</title>
    <style>
        .thanh-cong-cu { 
            margin: 20px 0; 
            padding-left: 20px; 
            font-family: Arial; }
        .o-nhap { 
            padding: 8px; 
            width: 300px; 
            border: 1px solid #ccc; }
        .danh-sach-muon { 
            padding: 20px;  }
        .khoi-sach {
            width: 30%; 
            float: left; 
            margin-right: 3%; 
            margin-bottom: 40px;
            text-align: center; 
            font-family: Arial, sans-serif;
        }
        .khung-anh-sach {
            width: 100%; 
            height: 250px; 
            border: 1px solid #ddd;
            margin-bottom: 10px;
            display: flex; 
            justify-content: center;
             align-items: center;
        }
        .khung-anh-sach img { 
            max-height: 100%; 
            max-width: 100%; }
        .ten-sach { 
            color: #008080; 
            font-weight: bold; 
            font-size: 18px; 
            text-decoration: none; 
            display: block; 
            margin-bottom: 10px; }
        .chu-nho { 
            font-size: 14px; 
            margin: 5px 0; 
            color: #333; }
        .xanh-dam {
            color: #008080; 
            font-weight: bold; }
    </style>
</head>
<body>
<div class="thanh-cong-cu">
    <form method="POST">
        <select name="loc_trang_thai" style="padding: 8px;" onchange="this.form.submit()">
            <option value="">Tất cả trạng thái</option>
            <?php
            $sql_tt = "SELECT * FROM trang_thai";
            $query_tt = mysqli_query($conn, $sql_tt);
            while($row_tt = mysqli_fetch_array($query_tt)) {
                $selected = ($loc_trang_thai == $row_tt['TenTrangThai']) ? "selected" : "";
                echo "<option value='".$row_tt['TenTrangThai']."' $selected>".$row_tt['TenTrangThai']."</option>";
            }
            ?>
        </select>
        <input type="text" name="o_tim_kiem" class="o-nhap" placeholder="Lọc theo tên sách..." value="<?php echo $tim_kiem; ?>">
        <button type="submit" name="nut_tim" style="padding: 8px 15px;">Tìm</button>
    </form>
</div>

<div class="danh-sach-muon">
    <?php 
    if(mysqli_num_rows($query) > 0) {
        while($row = mysqli_fetch_array($query)) { 
    ?>
        <div class="khoi-sach">
            <div class="khung-anh-sach">
                <img src="img/product/<?php echo $row['HinhAnh']; ?>">
            </div>
            <a href="#" class="ten-sach"><?php echo $row['TuaSach']; ?></a>
            <p class="chu-nho"><b>Tác giả:</b> <?php echo $row['TacGia']; ?></p>
            <p class="chu-nho"><b>Ngày mượn:</b> <?php echo date("F d, Y", strtotime($row['NgayMuon'])); ?></p>
            <p class="chu-nho"><b>Ngày trả:</b> <?php echo date("F d, Y", strtotime($row['NgayTra'])); ?></p>
            <p class="chu-nho"><b>Trạng thái:</b> <span class="xanh-dam"><?php echo $row['TenTrangThai']; ?></span></p>
        </div>
    <?php 
        }
    } else {
        echo "<p style='padding-left:20px;'>Không có dữ liệu phù hợp.</p>";
    }
    ?>
</div>

</body>
</html>