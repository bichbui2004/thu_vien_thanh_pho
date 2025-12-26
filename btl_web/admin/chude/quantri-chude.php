<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý chủ đề</title>
    <style>
        a{
            text-decoration-line: none;
            color: black;
        }
        .container{
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 10px;
        }
        .container h1{
            font-family: Arial, Helvetica, sans-serif;
        }
        table{
            width: 100%;
            border-bottom: 1px solid rgb(185, 182, 182);
        }
        th{
            font-size: 20px;
            padding-bottom: 5px;
        }
        td{
            padding: 10px 0px;
            border-top: 1px solid rgb(185, 182, 182);
        }
        .container button{
            padding: 10px 15px;
            font-size: 15px;
            width: auto;
            height: auto;
            border-radius: 10px;
            background-color: rgb(48, 136, 48);
            font-weight: bold;
            border: none;
            color: white;
        }
        .quyen{
            border-radius: 10px;
            background-color: rgb(240, 224, 80);
            color: white;
            padding: 7px;
            font-weight:bold;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
        .btn-fix{
            border-radius: 10px;
            background-color: orange;
            color: black;
            padding: 5px;   
            border: none; 
            font-weight:bold;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }
        .btn-delete{
            border-radius: 10px;
            background-color: red;
            color: white;
            padding: 5px;    
            border: none;
            font-weight:bold;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chủ đề</h1>
        <a href="index.php?page_layout=themchude"><button>Thêm chủ đề</button></a>
    </div>
    <table class="ds-taikhoan">
        <tr>
            <th>STT</th>
            <th>Tên chủ đề</th>
            <th>Hành động</th>
        </tr>
        <?php 
            include("connect.php");
            $sql = "SELECT * FROM chu_de ";
            $result = mysqli_query($conn, $sql);
            $stt = 1;
            while($row = mysqli_fetch_array($result)){
        ?>
        <tr align="center">
            <td><?php echo $stt++?></td>
            <td><?php echo $row["TenChuDe"] ?></td>
            <td class="hanhDong">
                <a class="btn-fix" href="index.php?page_layout=suachude&id=<?php echo $row["MaCD"] ?>">Cập nhật</a>
                <a class="btn-delete" href="chude/xoachude.php?id=<?php echo $row['MaCD']; ?>"onclick="return confirm('Bạn chắc chắn muốn xóa chủ để <?php echo $row['TenChuDe'] ?>?')">Xóa</a>
            </td>
        </tr>
        <?php }?>   
    </table>
    
</body>
</html>