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
    $id = $para["id"];
    assert(isset($id));
    mysqli_query($sql,"update comments set liked=liked+1 where id=".$id);
    $data["status"] = "success";
    echo json_encode($data);
}
catch (Throwable $e){
    echo json_encode($data);
}