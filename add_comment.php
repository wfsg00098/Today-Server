<?php
/**
 * Created by PhpStorm.
 * User: Badegg
 * Date: 2019/3/19
 * Time: 15:46
 */
include "settings.php";
date_default_timezone_set("Asia/Shanghai");
header('Content-Type:text/json');
$sql = mysqli_connect($sqladdr, $sqluser, $sqlpass);
mysqli_query($sql, "set names utf8mb4;");
mysqli_select_db($sql, $sqldbnm);
$data = [];
$data["status"] = "failed";
$para = file_get_contents('php://input');
$para = json_decode($para,true);
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_EXCEPTION,1);

try{
    $username = $para["username"];
    assert(isset($username));
    $dish = $para["dish"];
    assert(isset($dish));
    $message = $para["message"];
    assert(isset($message));
    $date = date("Y-m-d H:i:s");
    $result = mysqli_query($sql,"select count(*) from comments;");
    mysqli_data_seek($result,0);
    $rows = mysqli_fetch_row($result)[0];
    $rows = $rows + 1;
    mysqli_query($sql,"insert into comments values(".$rows.",'".$username."',".$dish.",'".$date."','".$message."',0,0);");
    $data["status"] = "success";
    echo json_encode($data);
}
catch (Throwable $e){
    echo json_encode($data);
}