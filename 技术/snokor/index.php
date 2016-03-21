<?php
//phpinfo();
$browser = $_SERVER['HTTP_USER_AGENT'];
$flag = false;
if (preg_match('/AppleWebKit.*Mobile.*/i', $browser)){
    $flag = true;
}elseif (strpos('$browser','Android')>-1||strpos('$browser','Linux')>-1||strpos('$browser','iPhone')>-1||strpos('$browser','iPad')>-1){
    $flag = true;
}elseif (strpos('$browser','Safari') == -1){
    $flag = true;
}
//var_dump($flag);exit;
if (!$flag){
    header('location:snokorpc.html');
}else {
    header('location:snokorphone.html');
}
