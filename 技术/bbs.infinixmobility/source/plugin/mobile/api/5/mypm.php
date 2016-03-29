<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: mypm.php 34314 2014-02-20 01:04:24Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'space';
$_GET['do'] = 'pm';
include_once 'home.php';

class mobile_api {

	function common() {
	}

	function output() {
		global $_G;
		$variable = array(
			'list' => mobile_core::getvalues($GLOBALS['list'], array('/^\d+$/'), array('plid', 'isnew', 'pmnum', 'authorid', 'author', 'pmtype', 'subject', 'members', 'dateline', 'touid', 'pmid', 'msgfromid', 'msgfrom', 'message', 'msgtoid', 'tousername')),
			'count' => $GLOBALS['count'],
			'perpage' => $GLOBALS['perpage'],
			'page' => intval($GLOBALS['page']),
		);
		if($_GET['subop']) {
			$variable = array_merge($variable, array('pmid' => $GLOBALS['pmid']));
		}
		foreach ($variable['list'] as $k=>$list){
		    $variable['list'][$k]['dateline'] = dgmdate($variable['list'][$k]['dateline']);
		    //$variable['list'][$k]['lastdateline'] = dgmdate($variable['list'][$k]['lastdateline']);
		    //$variable['list'][$k]['lastupdate'] = dgmdate($variable['list'][$k]['lastupdate']);
		    if ($_G['uid'] == $variable['list'][$k]['msgfromid']){
		        $variable['list'][$k]['avatar'] = avatar($variable['list'][$k]['msgtoid'],'small');
		    }else {
		        $variable['list'][$k]['avatar'] = avatar($variable['list'][$k]['msgfromid'],'small');
		    }
		    $variable['list'][$k]['uid_avatar'] = avatar($_G['uid'],'small');
		    $preg = "/<img src=\"(.+?)\".*?>/";
		    if (preg_match($preg, $list['message'])){
		        
		        preg_match_all($preg, $list['message'],$new_cnt);
		        foreach ($new_cnt[1] as $i => $url){
		            $message_img[$i]['url'] =  $url;
		        }
		        $variable['list'][$k]['message_imgsrc'] = $message_img;
		        //$variable['list'][$k]['message']=preg_replace($preg, '', $list['message']);
		    }else {
		        $variable['list'][$k]['message_imgsrc'] = null;
		    }
		    
		    $variable['list'][$k]['message'] = strip_tags($variable['list'][$k]['message']);
		}
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>