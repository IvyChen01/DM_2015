<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: seccodehtml.php 34428 2014-04-25 09:09:34Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}
//$_GET['action'] = $_GET['action'];
$_GET['mod'] = 'seccode';
include_once 'misc.php';

class mobile_api {

	function common() {
	    global $_G;
	    $variable = array();
	    if ($_GET['action']=='check'){
	        $_GET['secverify'] = $_GET['code'];
	        $idhash = isset($_GET['idhash']) && preg_match('/^\w+$/', $_GET['idhash']) ? $_GET['idhash'] : '';
            $modid = isset($_GET['modid']) && preg_match('/^[\w:]+$/', $_GET['modid']) ? $_GET['modid'] : ''; 
	        $message = check_seccode($_GET['secverify'], $idhash, 1, $modid) ? 'succeed' : 'invalid';
	        $variable = array(
	            'message' => $message,
	        );
	    }else {
	        $variable = array(
	            'url' =>   $_G['siteurl'].'api/mobile/index.php?module=seccode&sechash='.urlencode($_GET['sechash']).'&version='.(empty($_GET['secversion']) ? '5' : $_GET['secversion']),
	        );
	    }
	    
	    mobile_core::result(mobile_core::variable($variable));
		//global $_G;
		//echo '<img src="'.$_G['siteurl'].'api/mobile/index.php?module=seccode&sechash='.urlencode($_GET['sechash']).'&version='.(empty($_GET['secversion']) ? '5' : $_GET['secversion']).'" />';
		//exit;
	}

	function output() {}
	
}

?>