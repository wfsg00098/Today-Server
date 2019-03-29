<?php
include "settings.php";
date_default_timezone_set("Asia/Shanghai");
header('content-type:application/json;charset=utf8');
$sql = mysqli_connect($sqladdr, $sqluser, $sqlpass);
mysqli_query($sql, "set names utf8mb4;");
mysqli_select_db($sql, $sqldbnm);
$username = covert($_GET["username"]);
$password = covert($_GET["password"]);
$nickname = covert($_GET["nickname"]);
$date = date("Y_m_d_H_i_s") . "_" . msectime();

$result = mysqli_query($sql, "select * from users where username='" . $username . "';");
mysqli_data_seek($result, 0);
if (mysqli_num_rows($result)) {
    $arr['status'] = "duplicated";
    die(json_encode($arr));
}

$result = mysqli_query($sql, "insert into users values('" . $username . "','" . $password . "','','" . $nickname . "','','',0,'',0,1,'');");
$result = mysqli_query($sql, "select * from users where username='" . $username . "';");
mysqli_data_seek($result, 0);
if (mysqli_num_rows($result)) {
    $arr['status'] = "success";
    die(json_encode($arr));
} else {
    $arr['status'] = "failed";
    die(json_encode($arr));
}

