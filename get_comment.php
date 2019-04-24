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
    $dish = $para["dish"];
    assert(isset($dish));
    $result = mysqli_query($sql,"select * from comments where dish=".$dish." and deleted=0");
    mysqli_data_seek($result,0);
    $data["comments"] = array();
    while($row = mysqli_fetch_row($result)){
        $temp = [];
        $temp["id"] = $row[0];
        $temp["username"] = $row[1];
        $temp["date"] = $row[3];
        $temp["message"] = $row[4];
        $temp["liked"] = $row[6];
        array_push($data["comments"],$temp);
    }
    $data["status"] = "success";
    echo json_encode($data, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
}
catch (Throwable $e){
    echo json_encode($data, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
}
