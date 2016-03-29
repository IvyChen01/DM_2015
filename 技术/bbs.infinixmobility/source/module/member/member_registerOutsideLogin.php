<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: member_register.php 23897 2011-08-15 09:21:07Z zhengqingpeng $
 */
if (! defined('IN_DISCUZ')) {
    exit('Access Denied');
}

define('NOROBOT', TRUE);

$ctl_obj = new register_ctl();
$ctl_obj->setting = $_G['setting'];
$ctl_obj->template = 'member/register';
if ($_GET['flag']) {
    $_GET['' . $ctl_obj->setting['reginput']['password']] = '123456';
    $_GET['phone'] = $_GET['oauthid'];
    $_GET['email'] = $_GET['email'];
    $_GET['nick'] = $_GET['nickname'];
    $_GET['nationality'] = 'United States';
    $user = uc_get_user($_GET['phone']);
    if ($user) {
        $ctl_obj_login = new logging_ctl();
        $ctl_obj_login->setting = $_G['setting'];
        $method = 'on_loginOutsideLogin';
        $_GET['username'] = $_GET['phone'];
        $_GET['password'] = '123456';
        $ctl_obj_login->template = 'member/login';
        $ctl_obj_login->$method();
    } else {
        $ctl_obj->on_registerOutsideLogin();
    }
} else {
    $ctl_obj->on_registerOutsideLogin();
}
?>
