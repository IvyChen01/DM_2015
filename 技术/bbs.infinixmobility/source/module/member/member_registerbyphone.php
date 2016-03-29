<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
define('NOROBOT', TRUE);
$ctl_obj = new register_ctl();
$ctl_obj->setting = $_G['setting'];
$ctl_obj->setting['reginput']['phone'] = 'phone';
$_G['setting']['reginput']['phone'] = 'phone';
// update start 20150730
$_G['setting']['reginput']['email'] = $_POST['email'];
$_G['setting']['reginput']['nick'] = $_POST['nick'];
// update end 20150730
$ctl_obj->template = 'member/registerbyphone';
$ctl_obj->on_registerbyphone();
?>
