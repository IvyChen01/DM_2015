<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :修改用户名接口
* @date: 2016年3月4日 下午2:05:09
* @author: yanhui.chen
* @version:
*/

if(!defined('IN_MOBILE_API')) {
    exit('Access Denied');
}

define('APPTYPEID', 2);
define('CURSCRIPT', 'forum');

require './source/class/class_core.php';
require './source/function/function_forum.php';

C::app()->init();


$variable = array();
$username = getgpc('username');
$uid = getgpc('uid');
$username = trim(dstripslashes($username));
$usernamelen = dstrlen($username);
global $_G;
if (empty($_G['cookie']['auth'])||empty($_G['cookie']['saltkey'])){
    $variable['message'] = 'no login!';
    $variable['info'] = 'failed';
    mobile_core::result(mobile_core::variable($variable));
    exit;
}
if (C::t('common_member')->fetch_uid_by_username($username) ) {
   $variable['message'] = 'username duplicate!';
   $variable['info'] = 'failed';
   mobile_core::result(mobile_core::variable($variable));
   exit;
}

if ($uid == $_G['member']['uid']){
    //var_dump(1);exit;
    C::t('common_member')->update($uid,array('username'=>$username));
    $sql = "UPDATE infinixbbs_ucenter_members SET username='".$username."' WHERE uid=".$uid;
    $rs = DB::query($sql);
    if ($rs){
        $variable['member_username'] = $username;
        $variable['info'] = 'succeed';
    }else{
        $variable['info'] = 'failed';
    }
}else {
    $variable['message'] = 'Permission denied!';
    $variable['info'] = 'failed';
}


mobile_core::result(mobile_core::variable($variable));