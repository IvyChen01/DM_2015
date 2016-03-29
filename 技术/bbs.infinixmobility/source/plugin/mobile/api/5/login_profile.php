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

$_GET['mod'] = 'logging';
$_GET['action'] = !empty($_GET['action']) ? $_GET['action'] : 'login';
include_once 'member.php';

class mobile_api {

	function common() {
	}

	function output() {
		global $_G;
		$variable = array();
		$result = mobile_core::variable($variable);
		//var_dump($result);exit;
		if ($result['Message']['messageval'] == 'login_succeed' || $result['Message']['messageval'] == 'login_succeed_inactive_member'){
		    
		    unset($result['Message']);
		    $_GET['mod'] = 'space';
		    $_GET['do'] = 'profile';
		    $_GET['auth'] = $result['Variables']['auth'];
		    $_GET['saltkey'] = $result['Variables']['saltkey'];
		    $_GET['username'] = $result['Variables']['member_username'];
		    require_once 'home.php';
		    
		    global $_G;
		    $data = $GLOBALS['space'];
		    
		    if($_G['uid'] && $data['uid'] == $_G['uid']) {
		        $data['favthreads'] = C::t('home_favorite')->count_by_uid_idtype($_G['uid'], 'tid');
		        $data['avatar_small'] = avatar($_G['uid'],small);
		    }
		    
		    unset($data['password'], $data['regip'], $data['lastip'], $data['regip_loc'], $data['lastip_loc']);
		    $url = $_G['siteurl'].'data/attachment/profile/';
		    if (!empty($data['field1'])){
		        $appbg = $url.$data['field1'];
		    }else{
		        $appbg = $data['field1'];
		    }
		    $group_info = C::t('common_usergroup')->fetch_by_groupid($data['groupid']);
		  
		    
		    
		    foreach ($data['extcredits'] as $k=>$v){
		        $data['extcredits'][$k]['title'] = $v['title'];
		    }
		    $avatar = './uc_server/data/avatar/'.get_avatar2($_G['uid']);
		    if(!file_exists($avatar)){
		        $header = 0;
		    }else {
		        $header = 1;
		    }
		    $profile = array(
		        //'space' => $data,
		        'uid' => $_G['uid'],
		        'avatar' => avatar($_G['uid'],'small'),
		        'bigavatar' => avatar($_G['uid'],'big',true),
		        'is_avatar' => $header,
		        'username' => $data['username'],
				'nickname' => $data['field8'],
		        'email' => $data['email'],
		        'adminid' => $data['adminid'],
		        'group_id' => $data['groupid'],
		        'group_icon' => $group_info[$data['groupid']]['icon'],
		        'level'   => $group_info[$data['groupid']]['grouptitle'],
		        'regdate' => $data['regdate'],
		        'credits' => $data['credits'],
		        'extcredits1' => $data['extcredits1'],
		        'extcredits2' =>$data['extcredits2'],
		        'extcredits3' =>$data['extcredits3'],
		        'friends'=>$data['friends'],
		        'posts' => $data['posts'],
		        'threads' => $data['threads'],
		        'digestposts' => $data['digestposts'],
		        'oltime'      => $data['oltime'],
		        'realname' =>$data['realname'],
		        'backgroud' => $appbg,
		        'gender'=> $data['gender'],
		        'birthyear' => $data['birthyear']?$data['birthyear']:'',
		        'birthmonth' => $data['birthmonth']?$data['birthmonth']:'',
		        'birthday' => $data['birthday']?$data['birthday']:'',
		        'constellation' => $data['constellation'],
		        'zodiac' => $data['zodiac'],
		        'telephone' => $data['telephone'],
		        'mobile' => $data['mobile'],
		        'idcardtype' => $data['idcardtype'],
		        'idcard' => $data['idcard'],
		        'address' => $data['address'],
		        'zipcode' => $data['zipcode'],
		        'nationality' => $data['nationality'],
		        'birthprovince' => $data['birthprovince'],
		        'birthcity' => $data['birthcity'],
		        'birthdist' => $data['birthdist'],
		        'birthcommunity' => $data['birthcommunity'],
		        'resideprovince' => $data['resideprovince'],
		        'residecity' => $data['residecity'],
		        'residedist' => $data['residedist'],
		        'residecommunity' => $data['residecommunity'],
		        'residesuite' => $data['residesuite'],
		        'graduateschool' => $data['graduateschool'],
		        'company' => $data['company'],
		        'education' => $data['education'],
		        'occupation' => $data['occupation'],
		        'position' => $data['position'],
		        'revenue' => $data['revenue'],
		        'affectivestatus' =>$data['affectivestatus'],
		        'lookingfor' => $data['lookingfor'],
		        'bloodtype' => $data['bloodtype'],
		        'height' => $data['height'],
		        'weight' => $data['weight'],
		        'WhatsApp' => $data['field3'],
		        'IMEI ' => $data['field5'],
		        'facebook' => $data['field2'],
		        'lastvisit' => $data['lastvisit'],
		        //'admingroup' => $data['admingroup'],
		        //'group'      => $data['group'],
		        'extcredits' => $_G['setting']['extcredits'],
		    );
		    $result = array_merge($result,$profile);
		    mobile_core::result($result);
		}else {
		    mobile_core::result($result);
		}
	}

}

?>