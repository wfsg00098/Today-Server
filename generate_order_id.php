<?php
/**
 * Created by PhpStorm.
 * User: Badegg
 * Date: 2018/11/2
 * Time: 22:50
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
    $temp = $para["username"];
	$username = $temp;
    assert(isset($temp));
    $temp = $para["canteen"];
	$canteen = $temp;
    assert(isset($temp));
    $temp1 = $para["count"];
	$count = $temp1;
    assert(isset($temp1));
	$dishes = "";
    for ($i = 1;$i<=intval($temp1);$i++){
        $temp = $para["id".$i];
		$dishes = $dishes.$temp."|";
        assert(isset($temp));
        $temp = $para["count".$i];
		$dishes = $dishes.$temp."|";
        assert(isset($temp));
    }
    $data["status"] = "success";
	$date = date("YmdHis").msectime();
	$order_id = $date.mt_rand(0,99);
	$data["order_id"] = $order_id;
    echo json_encode($data);
	mysqli_query($sql,"insert into orders values('".$order_id."','".$username."',".$canteen.",'".$date."',".$count.",'".$dishes."','');");
	}
catch (Throwable $e){
    echo json_encode($data);
}




