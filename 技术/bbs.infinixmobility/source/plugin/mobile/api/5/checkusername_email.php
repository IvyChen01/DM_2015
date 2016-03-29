<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :获取欢迎页面列表页图片
* @date: 2015年6月24日 下午12:13:47
* @author: yanhui.chen
* @version:
*/
if (!defined('IN_MOBILE_API')) {
    exit('Access Denied');
}

$_GET['mod'] = 'ajax';
$_GET['inajax'] = 'yes';
$_GET['infloat'] = 'register';
$_GET['handlekey'] = 'register';
$_GET['ajaxmenu'] = '1';
$_GET['action'] = $_GET['action'];
if (isset($_GET['email'])){
    $_GET['email'] = $_GET['email'];
}
if (isset($_GET['username'])){
    $_GET['username'] = $_GET['username'];
}
include_once 'forum.php';

class mobile_api {

	
	function common() {
	}

	
function output() {
		global $_G;
		$variable = array();
		mobile_core::result(mobile_core::variable($variable));
	}

}





?>