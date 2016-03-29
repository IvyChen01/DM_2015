<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: recommend.php 34398 2014-04-14 07:11:22Z nemohou $
 */
if (!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'report';
$_GET['rtype'] = 'post';
$_GET['reportsubmit'] = true;
$_GET['inajax'] = 1;
include_once 'misc.php';

class mobile_api {

	function common() {
	   
	   
	}

	function output() {
		mobile_core::result(mobile_core::variable(array()));
	}

}

?>