<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: register.php 32489 2013-01-29 03:57:16Z monkey $
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
		$phone = getgpc('tel');
		$vcode = getgpc('vcode');
		if(strpos($phone, '0') === 0){
		    $phone = substr($phone, 1);
		}
		$vcode_info = C::t('common_phone_code')->fetch_all_by_phone($phone);
		$nowtime = time();
		
		if (empty($vcode_info)){
		    $code = -1;
		}elseif (intval($nowtime)-intval($vcode_info['time']) > 180){
		    $code = -11;
		}elseif ($vcode != $vcode_info['vcode']) {
		    $code = -12;
		}else {
		    $code =0;
		}
		if ($code!=0){
		    $variable = array(
		        'code' => $code,
		        'message' => getCodeMessage($code),
		    );
		    mobile_core::result(mobile_core::variable($variable));
		    exit;
		}
		
		require_once libfile('class/member');
		$_GET['phone'] = getgpc('tel');
		$_GET['nick']  = getgpc('nick');
		$_GET['password'] = getgpc('password');
		$_GET['password2'] = getgpc('password2');
		$email = getgpc('email');
		if (!$email){
		    $_GET['email'] = $_GET['phone']."@afmobi.group";
		}else {
		    $_GET['email'] = $email;
		}
		
		
		$ctl_obj = new register_ctl();
		$ctl_obj->setting = $_G['setting'];
		$ctl_obj->setting['reginput']['phone'] = 'phone';
		$ctl_obj->setting['reginput']['password'] = 'password';
		$ctl_obj->setting['reginput']['password2'] = 'password2';
		$_G['setting']['reginput']['phone'] = 'phone';
		$_G['setting']['reginput']['password'] = 'password';
		$_G['setting']['reginput']['password2'] = 'password2';
		//$ctl_obj->template = 'mobile:register';
		$ctl_obj->on_registerbyphone();
		if(empty($_POST['regsubmit'])) {
			exit;
		}
	}

	function output() {
		mobile_core::result(mobile_core::variable());
	}

}
function getCodeMessage($code){
    $message = array(
        '0'  => 'succeed',
        '-3' => 'param wrong',
        '-10' => 'invalid ip',
        '-14' => 'the phone num over 3 times today',
        '-12' => 'not fund the verification code',
        '-11' => 'code expired ',
        '-1'  => 'code not invalid'
    );
    return $message[$code];
}
?>