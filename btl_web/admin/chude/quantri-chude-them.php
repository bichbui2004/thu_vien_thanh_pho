
<?php
    include("connect.php");
    if(!empty($_POST["chu-de"])){

        $chuDe = $_POST["chu-de"];;

            $sql = "INSERT INTO `chu_de`(`TenChuDe`) VALUES ('$chuDe')";
            mysqli_query($conn,$sql);
            $row = mysqli_insert_id($conn);
            header('location: index.php?page_layout=chude');
    }else{
            echo '<p class="warning">Vui lòng nhập đầy đủ thông tin</p>';
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php - Buổi 2</title>
    <style>
        .warning{
            margin-left: 100px;
        }
        h1{
            margin: 5px 0px;
        }
        .container{
            border: 1px solid black;
            border-radius: 10px;
            width: 35%;
            padding: 20px 0;
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-left: 100px;
        }
        form{
            width:80%;
            
        }
        input{
            width:100%;
            padding: 5px 0;

        }
        .box1{
            width:100%;
            margin: 10px 0;
        }
        .select{
            width: 100%;
            padding: 5px 0;
        }
        .warning{
            color: red;
            font-weight: bold;

        } 
    </style>
</head>
<body>
    <div class="container">
    <form action="index.php?page_layout=themchude" method="post" enctype="multipart/form-data">   
        <h1>Thêm chủ để</h1>
        <div class="box1">
            <p>Tên chủ đề</p>
            <input type="text" name="chu-de" placeholder="Nhập tên chủ đề">
        </div>
        <div class="box1"><input type="submit" value="Thêm"></div>

    </form>
    <div>
</body>
</html>