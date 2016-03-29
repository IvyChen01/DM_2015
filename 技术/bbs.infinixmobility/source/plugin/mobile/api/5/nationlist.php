<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: toplist.php 34314 2014-02-20 01:04:24Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}


define('APPTYPEID', 2);
define('CURSCRIPT', 'forum');

require './source/class/class_core.php';
require './source/function/function_forum.php';


C::app()->init();
$variable = array();
$nationlist = C::t('forum_threadclass')->fetch_nations_by_fid(41);
unset($nationlist[19]);
foreach ($nationlist as $k=>$v){
    $prefix_info = C::t('common_sms_price_list')->fetch_priceinfo_by_nation($v['name']);
    $nationlist[$k]['code'] = $prefix_info['prefix'];
}
foreach ($nationlist as $key=>$value){
    $variable['nationlist'][] = $value; 
}
mobile_core::result(mobile_core::variable($variable));

?>