<?php
/**
 * Created by PhpStorm.
 * User: zfy
 * Date: 2019/4/3
 * Time: 22:29
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
    $order_id = $para["order_id"];
    assert(isset($order_id));
    $result = mysqli_query($sql, "select * from orders where id='" . $order_id . "'");
    mysqli_data_seek($result, 0);
    $data["order"] = array();
    $row = mysqli_fetch_row($result);
    $total_price = 0;
    $data["order_id"] = $row[0];
    $data["order_user"] = $row[1];
    $data["order_canteen"] = $row[2] + 1;
    $str = $row[5];
    $var = explode("|", $str);
    $varlength = count($var);
    for ($x = 0; $x < $varlength - 1; $x = $x + 2) {
        $temp = [];
        $t_id = $var[$x];
        $temp_result = mysqli_query($sql, "select * from dishes where id='" . $t_id . "'");
        mysqli_data_seek($temp_result, 0);
        $t_row = mysqli_fetch_row($temp_result);
        $temp["name"] = $t_row[2];
        $temp["price"] = $t_row[3];
        $temp["count"] = $var[$x + 1];
        $total_price += $t_row[3] * $var[$x + 1];
        array_push($data["order"], $temp);
    }
    $data["total_price"] = $total_price;
    $data["status"] = "success";
    echo json_encode($data, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
}