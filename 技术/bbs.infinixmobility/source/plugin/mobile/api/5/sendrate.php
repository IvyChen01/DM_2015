<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sendreply.php 32489 2013-01-29 03:57:16Z monkey $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'misc';
$_GET['action'] = 'rate';
$_GET['inajax'] = 1;
$_GET['infloat'] = 'yes';
$_GET['ratesubmit'] = true;
$_GET['handlekey'] = 'rate';
include_once 'forum.php';

class mobile_api {

	function common() {
	}
	
	function output() {
		global $_G;
		/*添加加分减分次数  */
		$addscore= C::t('forum_ratelog')->fetch_ratenum_by_pid($_GET['pid'],0);
		$minusscore = C::t('forum_ratelog')->fetch_ratenum_by_pid($_GET['pid'],-1);
		$variable = array(
			'tid' => $_G['tid'],
			'rid' => $_GET['pid'].'_'.$_G['uid'],
		    'minusscore'=>$minusscore['COUNT(*)'],
		    'addscore' => $addscore['COUNT(*)']
		);
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>