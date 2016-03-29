<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forum_trade.php 27054 2011-12-31 06:04:21Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
global $_G;
require_once libfile('function/misc');

$shoplist = C::t('forum_trade')->fetch_all();
$location = convertip($_G['clientip']);
$uid_arr = array("1","7449","8678");
foreach ($shoplist as $k=>$list){
    $tid = $list['tid'];
    $pid = $list['pid'];
    $local = $list['locus'];
    
    $post = C::t('forum_post')->fetch_all_by_tid_pid($tid,$pid);
    $shoplist[$k]['message']=$post['message'];
    $shoplist[$k]['dateline'] = dgmdate($list['dateline']);
    $shoplist[$k]['expiration'] = dgmdate($list['expiration']);
    $shoplist[$k]['pic']=$_G['siteurl'].getforumimg($list['aid'], 0, 260, 300, 'fixnone');
    
    if ($post['invisible'] || (strcasecmp($local,$location) != 0 && !in_array($_G['uid'], $uid_arr))){
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
$local_arr = array("Egypt","Pakistan");
if (in_array($location, $local_arr) || in_array($_G['uid'], $uid_arr)){
    $productlist = array_slice($shoplist, $number-$pagenumber,$pagenumber);
}else {
    showmessage('This module is only for Egypt member!','forum.php?mod=index');
}

$multipage = multi($num, $pagenumber, $page, 'forum.php?mod=shop', $_G['setting']['membermaxpages']);
include template('shop/shop');

?>