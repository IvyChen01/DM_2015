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
//$_GET['newnumber'] = 1;
$_GET['password'] = $_GET['password'];
$_GET['offlinesubmit'] = '提交查询';
$_GET['offlinestatus'] = 4; 
$_GET['tradesubmit'] = true;
/* formhash  tradesubmit
message
newbuyercontact
newbuyermobile
newbuyermsg
newbuyername
newbuyerphone
newbuyerzip
newnumber
offlinestatus
offlinesubmit
password */
include_once 'forum.php';

class mobile_api {

	function common() {

	}

	function output() {
		global $_G;
		$orderid = $_GET['orderid'];
		$tradelog = C::t('forum_tradelog')->fetch($orderid);
		
		$variable = array(
		    'status' => $GLOBALS['tradestatus'],
		);
		
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>