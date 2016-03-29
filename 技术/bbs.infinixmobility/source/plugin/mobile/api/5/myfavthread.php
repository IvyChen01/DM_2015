<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: myfavthread.php 34314 2014-02-20 01:04:24Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'space';
$_GET['do'] = 'favorite';
$_GET['type'] = 'thread';
include_once 'home.php';

class mobile_api {

	function common() {
	}

	function output() {
		global $_G;
		$list = array_values($GLOBALS['list']);
		$tids = array();
		foreach($list as $key=>$value) {
			$tids[] = $value['id'];
		}
		if($tids) {
			$threadinfo = C::t('forum_thread')->fetch_all($tids);
		}
		$url = substr($_G['siteurl'], 0,strrpos($_G['siteurl'],'/',-9)+1);
		$threadtableids = ! empty($_G['cache']['threadtableids']) ? $_G['cache']['threadtableids'] : array ();
		$tableid = $_GET['archiveid'] && in_array($_GET['archiveid'],$threadtableids) ? intval($_GET['archiveid']) : 0;
		$fileds_posts = array('pid','fid','tid','message','attachment');
		foreach($list as $key=>$value) {
			$list[$key]['replies'] = $threadinfo[$value['id']]['replies'];
			$list[$key]['views'] = $threadinfo[$value['id']]['views'];
			$list[$key]['author'] = $threadinfo[$value['id']]['author'];
			$list[$key]['authorid'] = $threadinfo[$value['id']]['authorid'];
			$list[$key]['avatar'] = avatar($threadinfo[$value['id']]['authorid'],'small');
			$list[$key]['bigavatar'] = avatar($threadinfo[$value['id']]['authorid'],'big',true);
			$list[$key]['dateline'] = dgmdate($threadinfo[$value['id']]['dateline']);
			$list[$key]['dateline'] =  preg_replace("/&nbsp;/",' ',$list[$key]['dateline']);
			$list[$key]['tid'] = $list[$key]['id'];
			$list[$key]['subject'] = $list[$key]['title'];
			$list[$key]['has_favorite'] = 1;
			$pid=C::t('forum_post')->fetch_pid_by_tid_authorid($list[$key]['id'],$list[$key]['authorid']);
			$message = C::t('forum_post')->fetch_message_by_tid_pid($list[$key]['id'],$pid);
			
			$message= preg_replace('/\[quote\]|\[\/quote\]/', '', $message);
			$message= preg_replace('/\[img\](.*?)\[\/img\]/', '', $message);
			$message= preg_replace('/\[size=(.+?)\](.*?)\[\/size\]/', '', $message);
			$message= preg_replace('/\[b\]|\[\/b\]/', '', $message);
			$message= preg_replace('/\[i=(.+?)\](.*?)\[\/i\]/', '', $message);
			$list[$key]['message'] = cutstr(strip_tags($message),50);
			
			if ($threadinfo[$value['id']]['attachment']){
			    $attachlist = C::t('forum_attachment_n')->fetch_all_by_id('tid:'.$list[$key]['id'], 'pid', $pid,'',true);
			    
			}
			if (count($attachlist)>3){
			    $attachlist = array_slice($attachlist,0,3);
			}
			foreach ($attachlist as $k=>$attach){
			    if ($attach['aid']) {
			        $attach_arr[] = array(
			            'aid' => $attach['aid'],
			            'filename' => $attach['filename'],
			            'isimage' => $attach['isimage'],
			            'attachment' =>$url.getforumimg($attach['aid'], 0, 200, 200, 'fixnone'),
			            'dateline' => $attach['dateline']
			        );
			    }
			}
			$list[$key]['images_num'] = count($attachlist);
			$list[$key]['images'] = $attach_arr?$attach_arr:null;
			unset($attachlist,$attach_arr,$attach);
			unset($list[$key]['icon'],$list[$key]['title'],$list[$key]['url'],$list[$key]['uid'],$list[$key]['description'],$list[$key]['idtype'],$list[$key]['id'],$list[$key]['spaceuid']);
		}
		$variable = array(
			'forum_threadlist' => $list,
			'perpage' => $GLOBALS['perpage'],
			'count' => $GLOBALS['count'],
		);
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>