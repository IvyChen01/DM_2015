<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: member_lostpasswd.php 31164 2012-07-20 07:50:57Z chenmengshu $
 *
 *	Modified by Valery Votintsev, codersclub.org
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define('NOROBOT', TRUE);

$discuz_action = 141;

if(submitcheck('lostpwsubmit')) {
	loaducenter();
	$_GET['email'] = strtolower(trim($_GET['email']));
/*vot*/	$_GET['username'] = trim($_GET['username']);

/*vot*/	$member = false;

	// Check for username exists
	if($_GET['username']) {
/*vot*/		list($tmp['uid'], , $tmp['email']) = uc_get_user($_GET['username']);
		$tmp['email'] = strtolower(trim($tmp['email']));
/*vot*/		if($_GET['email']) {
		if($_GET['email'] != $tmp['email']) {
			showmessage('getpasswd_account_notmatch');
		}
/*vot*/		}
		$member = getuserbyuid($tmp['uid'], 1);
/*vot*/	} else if($_GET['email']) {	// Check for Email exists
		$emailcount = C::t('common_member')->count_by_email($_GET['email'], 1);
		if(!$emailcount) {
			showmessage('lostpasswd_email_not_exist');
		}
		if($emailcount > 1) {
			showmessage('lostpasswd_many_users_use_email');
		}
		$member = C::t('common_member')->fetch_by_email($_GET['email'], 1);
		list($tmp['uid'], , $tmp['email']) = uc_get_user(addslashes($member['username']));
/*vot*/		$tmp['email'] = strtolower(trim($tmp['email']));
/*vot*/} elseif ($_GET['phone'] && ($_GET['flag'] == 'true')) {	// Check for NO username & NO email entered
 			if (isset($_GET['code'])){
 				//获取用户信息
 				list($tmp['uid'], , $tmp['email']) = uc_get_user($_GET['phone']);
 				$member = getuserbyuid($tmp['uid'], 1);
 				
 				//存储新密码
 				$newpswd = random(6);
 // 				$newpswd = "1234567";
 				
 				//更改密码
 				$resultid = uc_user_edit(addslashes($_GET['phone']), $newpswd, $newpswd, addslashes($tmp['email']), 1, 0);
 				$password = md5(random(10));
 				C::t('common_member')->update($_GET['uid'], array('password' => $password));
 				
 // 				$p = $resultid;
 // 				echo "<script>alert('$p');</script>";
 // 				exit();
 				
 				//发送信息
 				$content = "your Infinix BBS newpassword is [".$newpswd."].";
 				$content = urlencode($content);
 				
 				$url="http://79.125.125.243:8080/sentMessage";
 				$post_data = array(
 						'mobile'=> $_GET['phone'],
 						'content'=> $content,
 						'internationalCode' => $_GET['code'],
 						'fromAddr' => "xClub",
 				);
 					
 				$post_data = implode('&',$post_data);
 				$ch = curl_init();
 				curl_setopt($ch, CURLOPT_URL, $url);
 				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 				//post数据
 				curl_setopt($ch, CURLOPT_POST, 1);
 				//post的变量
 				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
 				$output = curl_exec($ch);
 				curl_close($ch);
 				$obj = json_decode($output);
  				//echo $obj->code;
 				}
 				
 				// update start 20150730
 	} else {	// Check for NO username & NO email entered
		
/*vot*/		showmessage('getpasswd_account_notmatch');
	}
	if(!$member) {
		showmessage('getpasswd_account_notmatch');
	} elseif($member['adminid'] == 1 || $member['adminid'] == 2) {
		showmessage('getpasswd_account_invalid');
	}

	$table_ext = $member['_inarchive'] ? '_archive' : '';
//vot	if($member['email'] != $tmp['email']) {
//vot		C::t('common_member'.$table_ext)->update($tmp['uid'], array('email' => $tmp['email']));
//vot	}
	$idstring = random(6);
	C::t('common_member_field_forum'.$table_ext)->update($member['uid'], array('authstr' => "$_G[timestamp]\t1\t$idstring"));
	require_once libfile('function/mail');
	$get_passwd_subject = lang('email', 'get_passwd_subject');
	$get_passwd_message = lang(
		'email',
		'get_passwd_message',
		array(
			'username' => $member['username'],
			'bbname' => $_G['setting']['bbname'],
			'siteurl' => $_G['siteurl'],
			'uid' => $member['uid'],
			'idstring' => $idstring,
			'clientip' => $_G['clientip'],
		)
	);
	if(!sendmail("$_GET[username] <$tmp[email]>", $get_passwd_subject, $get_passwd_message)) {
		runlog('sendmail', "$tmp[email] sendmail failed.");
	}
	showmessage('getpasswd_send_succeed', $_G['siteurl'], array(), array('showdialog' => 1, 'locationtime' => true));
}

