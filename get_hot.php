<?php
/**
 * Created by PhpStorm.
 * User: Badegg
 * Date: 2018/10/29
 * Time: 20:30
 */
header('Content-Type:text/json');
$data=[];
$data["count"] = 8;
for ($i = 0 ; $i <8; $i++){
    $data["data".$i] = mt_rand(50,200);
}
echo json_encode($data);