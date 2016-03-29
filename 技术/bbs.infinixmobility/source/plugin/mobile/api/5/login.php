<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: login.php 34314 2014-02-20 01:04:24Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'logging';
$_GET['action'] = !empty($_GET['action']) ? $_GET['action'] : 'login';
include_once 'member.php';

class mobile_api {

	function common() {
	}

	function output() {
		global $_G;
		$variable = array();
		// 获取用户是否签到
		$variable['has_sign'] = 0;
		$qiandaodb = DB::fetch_first("SELECT * FROM ".DB::table('dsu_paulsign')." WHERE uid='$_G[uid]'");
		if(isset($qiandaodb['time']) && $qiandaodb['time'] >= strtotime('today')) {
		    $variable['has_sign'] = 1;
		}
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>