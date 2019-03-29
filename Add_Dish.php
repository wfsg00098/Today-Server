<!DOCTYPE HTML>
<html>
<head>
    <title>添加菜品</title>
    <meta name="theme-color" content="#1c1c1c"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
</head>
<body>
<?php include "settings.php";
?>

<!-- Header -->
<header id="header">
    <a href="#" class="logo"><strong>添加菜品</strong></a>
</header>

<?php
date_default_timezone_set("Asia/Shanghai");
$sql = mysqli_connect($sqladdr, $sqluser, $sqlpass);// or die("Database Connection Failed");
mysqli_query($sql, "set names utf8mb4;");
mysqli_select_db($sql, $sqldbnm);
?>

<!-- Main -->
<section id="main">
    <div class="inner">
        <form method="post" enctype="multipart/form-data">
            <p>新增菜品</p><br>
            名称<input type="text" name="name"><br>
            食堂编号<input type="text" name="canteen"><br>
            单价<input type="text" name="price"><br>
            图片<input type="file" name="image"><br>
            类型<input type="text" name="type"><br>
            卡路里<input type="text" name="calorie"><br>
            <input type="submit" name="add" value="新增">
            <input type="reset" value="清空"><br>
        </form>
        <?php
        if (isset($_POST["add"])) {
            $name = $_POST["name"];
            $canteen = $_POST["canteen"];
            $price = $_POST["price"];
            $type = $_POST["type"];
            $calorie = $_POST["calorie"];

            if (!((($_FILES["image"]["type"] == "image/gif")
                    || ($_FILES["image"]["type"] == "image/jpeg")
                    || ($_FILES["image"]["type"] == "image/pjpeg")
                    || ($_FILES["image"]["type"] == "image/png"))
                && ($_FILES["image"]["size"] < $file_max_size))) {
                echo("<script language=\"JavaScript\">alert(\"文件过大或类型不符！\");</script>");
            } else if ($_FILES["image"]["error"] > 0) {
                echo("<script language=\"JavaScript\">alert(\"上传失败！\");</script>");
            } else {
                $tempname = explode(".", $_FILES["image"]["name"]);
                $extname = $tempname[sizeof($tempname) - 1];

                $content = "DISH_IMAGE_" . date("Y_m_d_H_i_s") . "_" . msectime() . "." . $extname;
                $content = covert($content);
                move_uploaded_file($_FILES["image"]["tmp_name"], "/var/www/today/dishes/" . $content);
                $result = mysqli_query($sql,"select count(*) from dishes;");
                mysqli_data_seek($result,0);
                $rows = mysqli_fetch_row($result)[0];
                $rows = $rows + 1;
                $result = mysqli_query($sql, "insert into dishes values(".$rows.",".$canteen.",'".$name."',".$price.",'https://today.guaiqihen.com/dishes/".$content."',".$type.",".$calorie.",0);");
                echo("<script language=\"JavaScript\">alert(\"添加成功！\");</script>");
                echo "<script language=\"JavaScript\"> location.replace(location.href);</script>";
            }
        }
        ?>


    </div>
</section>

<!-- Footer -->
<footer id="footer">
    <div class="copyright">Copyright &copy; 2018-<?php echo(date("Y")); ?>. 王七喜♏ All rights reserved.</div>
</footer>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>


</body>
</html>