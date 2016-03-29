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
include_once 'member.php';

class mobile_api {
	function common() {
		global $_G;
		if(empty($_POST['regsubmit'])) {
			$_G['mobile_version'] = intval($_GET['version']);
		}
		
		$ctl_obj = new register_ctl();
		$ctl_obj->setting = $_G['setting'];
		require_once libfile('class/member');
		$_GET[''.$ctl_obj->setting['reginput']['password']] = '123456';
		$_GET['phone'] = $_GET['oauthid'];
		$_GET['email'] = $_GET['oauthid']."@afmobi.group";
		$_GET['nick'] = $_GET['username'];
		$_GET['nationality'] = 'United States';
		$user = uc_get_user($_GET['phone']);
		if($user){
		    $ctl_obj_login = new logging_ctl();
		    $ctl_obj_login->setting = $_G['setting'];
		    $method = 'on_loginOutsideLogin';
		    $_GET['username'] = $_GET['phone'];
		    $_GET['password'] = '123456';
		    //$ctl_obj_login->template = 'member/login';
		    $ctl_obj_login->$method();
		}else{
		    $ctl_obj->on_registerOutsideLogin();
		}
	}

	function output() {
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