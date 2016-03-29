<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$cloudsetting = $_G['cache']['plugin']['k_check_zz'];
require_once DISCUZ_ROOT.'./source/plugin/k_check_zz/function_cloud.inc.php';
$op = addslashes($_GET['op']);

if(!$op) {
	$extra = '';
	$url = kcloud_url($extra);
	echo '<script type="text/javascript">location.href=\''.$url.'\';</script>';
}