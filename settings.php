
<?php

function covert2($str)
{
    $str1 = $str;
    $str1 = str_replace("'","\'",$str1);
    return $str1;
}
function isvalidstr($str)
{
    if(preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$str) && $str!="admin" && $str!="log" && substr($str,0,5)!="#user") return true;
    else return false;
}
function covert($str)
{
    $str1=$str;
    $str1=trim($str1);
    $str1=addslashes($str1);
    //$str1=str_replace("_","\_",$str1);
    //$str1=str_replace("%","\%",$str1);
    $str1=nl2br($str1);
    $str1=htmlspecialchars($str1);
    return $str1;
}
function msectime() {
    list($msec, $sec) = explode(' ', microtime());
    $msectime =  (float)sprintf('%.0f', floatval($msec) * 1000);
    return $msectime;
}

$sqladdr = "";
    $sqluser = "";
    $sqlpass = "";
    $sqldbnm = "";
    $file_max_size = 4096000;

