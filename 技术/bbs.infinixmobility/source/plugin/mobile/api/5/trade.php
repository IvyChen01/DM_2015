<?php

/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :交易信息
* @date: 2015年6月24日 下午12:13:47
* @author: yanhui.chen
* @version:
*/
if (!defined('IN_MOBILE_API')) {
    exit('Access Denied');
}

$_GET['mod'] = 'trade';
$_GET['tid'] = $_GET['tid'];
$_GET['pid'] = $_GET['pid'];
$_GET['number'] = 1;
$_GET['action'] = 'trade';
$_GET['tradesubmit'] = true;
$_GET['transport'] = 2;
$_GET['offline'] =1;
/* buyercontact
buyermobile
buyermsg
buyername
buyerphone
buyerzip */
include_once 'forum.php';

class mobile_api {

	function common() {

	}

	function output() {
		global $_G;
		$variable = array(
		    'orderid' => $GLOBALS['orderid'],
		    'trade'   => $GLOBALS['trade'],
		);
		$variable['trade']['dateline'] = dgmdate($variable['trade']['dateline']);
		$variable['trade']['expiration'] = dgmdate($variable['trade']['expiration']);
		$variable['trade']['pic'] = $_G['siteurl'].getforumimg($variable['trade']['aid'], 0, 260, 300, 'fixnone');
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>