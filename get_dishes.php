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
    $query = "select * from dishes where canteen='".$canteen."'";
	$result = mysqli_query($sql,$query);
	mysqli_data_seek($result,0);
	$data["count"] = null;
	$count = 0;
	while ($row = mysqli_fetch_row($result)){
		$count++;
		$data["id".$count] = $row[0];
		$data["name".$count] = $row[2];
		$data["price".$count] = $row[3];
		$data["image".$count] = $row[4];
		$data["type".$count] = $row[5];
		$data["calorie".$count] = $row[6];
		$data["liked".$count] = $row[7];
	}
	$data["count"] = $count;
    $data["status"] = "success";
    echo json_encode($data);
	}
catch (Throwable $e){
    echo json_encode($data);
}



