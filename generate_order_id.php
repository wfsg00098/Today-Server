<?php
/**
 * Created by PhpStorm.
 * User: Badegg
 * Date: 2018/11/2
 * Time: 22:50
 */
header('Content-Type:text/json');
$data = [];
$data["status"] = "failed";
$para = file_get_contents('php://input');
$para = json_decode($para,true);
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_EXCEPTION,1);

try{
    $temp = $para["username"];
    assert(isset($temp));
    $temp = $para["canteen"];
    assert(isset($temp));
    $temp1 = $para["count"];
    assert(isset($temp1));
    for ($i = 1;$i<=intval($temp1);$i++){
        $temp = $para["id".$i];
        assert(isset($temp));
        $temp = $para["count".$i];
        assert(isset($temp));
    }
    $data["status"] = "success";
    $data["order_id"] = date("Ymd").mt_rand(10000000,99999999);
    echo json_encode($data);
}
catch (Throwable $e){
    echo json_encode($data);
}




