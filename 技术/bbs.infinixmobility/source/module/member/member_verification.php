<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
define('NOROBOT', TRUE);
$ctl_obj = new register_ctl();
$ctl_obj->setting = $_G['setting'];
if(isset($_GET['mobile_phone'])){
    $_G['setting']['mobile_phone'] = $_GET['mobile_phone'];
}
// update start 20150730
if(isset($_GET['email'])){
    $_G['setting']['email'] = $_GET['email'];
}
if(isset($_GET['nick'])){
    $_G['setting']['nick_name'] = $_GET['nick'];
}
// update end 20150730
// print_r($_GET);exit;
$_G['setting']['codes'] = array(
    'China' => '+86',
    'Singapore' => '+65',
    'South Korea' => '+82',
    'The United States' => '+1',
    'Cote dIvoire' => '+225',
    'Egypt' => '+20',
    'France' => '+33',
    'Ghana' => '+233',
    'Kenya' => '+254',
    'Morocco' => '+212',
    'Nigeria' => '+234',
    //'Pakistan' => '+0092',
    'Saudi Arabia' => '+966',
    'United Arab Emirates' => '+971',
);
$_G['setting']['phone_verification'] = false;
if(isset($_GET['flag'])&& $_GET['flag'] == 'verification_success'){
    $_G['setting']['phone_verification'] = true;
    $ctl_obj->template = 'member/registerbyphone';
}else{
    $ctl_obj->template = 'member/verification';
}
$ctl_obj->on_registerbyphone();
?>
