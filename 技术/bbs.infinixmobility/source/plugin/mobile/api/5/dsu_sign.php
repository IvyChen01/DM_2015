<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: mypm.php 27451 2012-02-01 05:48:47Z monkey $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['id'] = 'dsu_paulsign:sign';
$_GET['operation'] = 'qiandao';
$_GET['infloat'] = 1;
$_GET['inajax'] = 1;
$_GET['fastreply'] = 0;
$_GET['qdmode'] = 1;
$_GET['qdxq'] = 'kx';
$_GET['todaysay'] = 'happy day';
include_once 'plugin.php';

class mobile_api {

	function common() {
	}

	function output() {
		global $_G;
		
		$signInfo = DB::fetch_first("SELECT * FROM ".DB::table('dsu_paulsign')." WHERE uid='$_G[uid]'");
		$variable = array(
		    'days'=>$signInfo['days'],
		    'mdays'=>$signInfo['mdays'],
		    'lasted'=>$signInfo['lasted']
		);
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>