<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 15-3-23
 * Time: 下午5:21
 */
require_once(dirname(__FILE__) . '/../include/common.inc.php');

$args = $_POST['args'];
$action = $_POST['action'];

if(!$action || !$args){
    echo 0,
    exit();
}


if(count($args) < 7) {
    echo 0;
    exit();
}
$table = $action == 'distributor' ? 'oraimo_distributor' : 'oraimo_retailer';
$sql_count = "SELECT COUNT(*) as num FROM $table WHERE cName = '$args[0]'";
$count = $db->GetOne($sql_count);
if(!empty($count) && $count['num'] > 0){
    echo 2;
    exit();
}
$sql = "INSERT INTO $table (cName,cTel,cSize,cStaffs,cAddr,cScope,cInterested,cDate) VALUES('$args[0]','$args[1]','$args[2]','$args[3]','$args[4]','$args[5]','$args[5]','".date('Y-m-d')."')";
$rs = $db->ExecuteNoneQuery2($sql);
echo $rs;
exit();

