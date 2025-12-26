<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT s.*, cd.TenChuDe FROM sach s LEFT JOIN chu_de cd ON s.MaCD = cd.MaCD WHERE s.MaSach = $id";
$res = mysqli_query($conn, $sql);
$book = mysqli_fetch_assoc($res);
if (!$book) return;
?>
<div style="display:flex; gap:40px; background:#fff; padding:30px; border-radius:15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <img src="images/<?php echo $book['HinhAnh']; ?>" width="300" style="border-radius:10px;">
    <div>
        <h1 style="color:rgb(89, 89, 211);"><?php echo $book['TuaSach']; ?></h1>
        <p>Tác giả: <strong><?php echo $book['TacGia']; ?></strong> | Chủ đề: <?php echo $book['TenChuDe']; ?></p>
        <p>Trạng thái: <b>Còn <?php echo $book['SoLuong']; ?> cuốn</b></p>
        <hr>
        <?php if(isset($_SESSION['MaTK'])): ?>
            <form action="giohang.php?action=add" method="POST">
                <input type="hidden" name="MaSach" value="<?php echo $book['MaSach']; ?>">
                <button type="submit" style="padding:15px 30px; background:rgb(89, 89, 211); color:white; border:none; border-radius:8px; cursor:pointer; font-weight:bold;">THÊM VÀO GIỎ MƯỢN</button>
            </form>
        <?php else: ?>
            <p style="background:#fff3cd; padding:15px; border-radius:5px;">Vui lòng <a href="index.php?page_layout=dangnhap" style="color:blue; font-weight:bold;">đăng nhập</a> để mượn sách.</p>
        <?php endif; ?>
    </div>
</div>

<div style="margin-top:40px; background:#fff; padding:30px; border-radius:15px;">
    <h2 style="color:rgb(89, 89, 211);">Độc giả cảm nhận</h2>
    <div style="max-height:400px; overflow-y:auto; margin-bottom:30px;">
        <?php
        $sql_cn = "SELECT cn.*, tk.HoTen FROM cam_nghi cn JOIN tai_khoan tk ON cn.MaTK = tk.MaTK WHERE cn.MaSach = $id ORDER BY NgayGui DESC";
        $res_cn = mysqli_query($conn, $sql_cn);
        if(mysqli_num_rows($res_cn) > 0){
            while($r = mysqli_fetch_assoc($res_cn)){
                echo "<div style='border-bottom:1px solid #eee; padding:15px 0;'>
                        <strong>{$r['HoTen']}</strong> <small style='color:#999;'>({$r['NgayGui']})</small>
                        <p style='margin-top:5px; color:#444;'>{$r['NoiDung']}</p>
                      </div>";
            }
        } else { echo "<p style='color:#999;'>Chưa có cảm nhận nào.</p>"; }
        ?>
    </div>

    <?php if(isset($_SESSION['MaTK'])): ?>
        <form action="xuly_camnghi.php" method="POST" style="background:#f9f9f9; padding:20px; border-radius:10px;">
            <input type="hidden" name="MaSach" value="<?php echo $id; ?>">
            <textarea name="NoiDung" placeholder="Chia sẻ cảm nghĩ của bạn..." required style="width:100%; height:100px; padding:10px; border:1px solid #ddd; border-radius:5px;"></textarea>
            <button type="submit" name="gui_cn" style="margin-top:10px; padding:10px 25px; background:green; color:white; border:none; border-radius:5px; cursor:pointer;">Gửi cảm nghĩ</button>
        </form>
    <?php endif; ?>
</div>