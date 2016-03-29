<?php
/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: mythread.php 27451 2012-02-01 05:48:47Z monkey $
 */

if (!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'space';
$_GET['do'] = 'thread';
$_GET['type'] = 'reply';
$_GET['from'] = 'space';
$_GET['view'] = 'me';
include_once 'home.php';

class mobile_api {

	function common() {
	}

	function output() {
		global $_G;
		/*
		foreach ($GLOBALS['data']['my']['threadlist'] as $key => $val) {
			$val['isnew'] = $val['new'];
			unset($val['new']);
			$GLOBALS['data']['my']['threadlist'][$key] = $val;
		}

		$variable = array(
			'list' => array_values($GLOBALS['data']['my']['threadlist']),
			'perpage' => $GLOBALS['perpage'],
			'count' => $GLOBALS['data']['my']['threadcount'],
			'page' => intval($_G['page']),
		);
		*/
		$list = mobile_core::getvalues($GLOBALS['list'], array('/^\d+$/'), array('tid','fid', 'new', 'dateline', 'subject'));
		foreach ($list as $key => $val) {
			$val['isnew'] = $val['new'];
			unset($val['new']);
			$list[$key] = $val;
		}
		
		$variable = array(
				'list' => array_values($list),
				'perpage' => $GLOBALS['perpage'],
				'count' => $GLOBALS['listcount'],
				'page' => intval($_G['page']),
		);
		mobile_core::result(mobile_core::variable($variable));
	}
}

?>