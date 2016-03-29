<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :获取商品信息
* @date: 2015年6月24日 下午12:13:47
* @author: yanhui.chen
* @version:
*/
if (!defined('IN_MOBILE_API')) {
    exit('Access Denied');
}

define('APPTYPEID', 2);
define('CURSCRIPT', 'forum');

require './source/class/class_core.php';
require './source/function/function_forum.php';

C::app()->init();


$variable = array();
$shoplist = C::t('forum_trade')->fetch_all();

foreach ($shoplist as $k=>$list){
    $tid = $list['tid'];
    $pid = $list['pid'];
    $post = C::t('forum_post')->fetch_all_by_tid_pid($tid,$pid);
    $shoplist[$k]['message']=$post['message'];
    $shoplist[$k]['dateline'] = dgmdate($list['dateline']);
    $shoplist[$k]['expiration'] = dgmdate($list['expiration']);
    $shoplist[$k]['pic']=$_G['siteurl'].getforumimg($list['aid'], 0, 260, 300, 'fixnone');
    if ($post['invisible']){
        unset($shoplist[$k]);
    }
}
$num = count($shoplist);
$page = $_GET['page'];
if(empty($page)) {
    $page = 1;
}
$pagenumber = 6;
$number =!$page?$pagenumber:$page*$pagenumber;
$productlist = array_slice($shoplist, $number-$pagenumber,$pagenumber);
$variable['shoplist'] = $productlist;
$variable['page'] = $page;
$variable['pagenumber'] = 6;
$variable['total'] = $num;
mobile_core::result(mobile_core::variable($variable));
?>