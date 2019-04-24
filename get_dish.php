<?php
/**
 * Created by PhpStorm.
 * User: Badegg
 * Date: 2019/4/22
 * Time: 17:16
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
$para = json_decode($para, true);
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_EXCEPTION, 1);


try {
    $temp = $para["id"];
    $id = $temp;
    assert(isset($temp));
    $query = "select * from dishes where id=" . intval($id);
    $result = mysqli_query($sql, $query);
    mysqli_data_seek($result, 0);
    while ($row = mysqli_fetch_row($result)) {
        $data["canteen"] = $row[1];
        $data["name"] = $row[2];
        $data["price"] = $row[3];
        $data["image"] = $row[4];
        $data["type"] = $row[5];
        $data["calorie"] = $row[6];
        $data["liked"] = $row[7];
    }
    $data["status"] = "success";
    echo json_encode($data, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
}




