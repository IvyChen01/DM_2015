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


define('APPTYPEID', 1);
define('CURSCRIPT', 'home');

require_once './source/class/class_core.php';
require_once './source/function/function_home.php';


C::app()->init();
$variable = array();

$variable['userslevel'] = C::t('common_usergroup')->userslevel();
mobile_core::result(mobile_core::variable($variable));
?>