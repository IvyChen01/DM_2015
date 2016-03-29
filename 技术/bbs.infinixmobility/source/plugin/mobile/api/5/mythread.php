<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: mythread.php 34314 2014-02-20 01:04:24Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'guide';
$_GET['view'] = 'my';
include_once 'forum.php';

class mobile_api {

	function common() {
	}

	function output() {
		global $_G;
		
		$list =  mobile_core::getvalues(array_values($GLOBALS['data']['my']['threadlist']), array('/^\d+$/'), array('tid', 'fid', 'typeid','authorid', 'author', 'subject', 'dateline', 'views', 'replies','attachment'));
			
		
		//$url = substr($_G['siteurl'], 0,strrpos($_G['siteurl'],'/',-9)+1);
		foreach ($list as $k=>$v){
		    $list[$k]['avatar'] = avatar($v['authorid'],'small');
		    $list[$k]['bigavatar'] = avatar($v['authorid'],'big',true);
		    $list[$k] ['has_favorite'] = 0;
		    $list[$k] ['favid'] = 0;
		    $list[$k]['dateline'] =  preg_replace("/&nbsp;/",' ',$list[$k]['dateline']);
		    if ($_G ['uid']) {
		        $favorite_log = C::t ( 'home_favorite' )->fetch_by_id_idtype ( $v ['tid'], "tid", $_G ['uid'] );
		    
		        if (is_array ( $favorite_log ) && $favorite_log) {
		            $list[$k] ['has_favorite'] = 1;
		            $thread ['favid'] = $favorite_log ['favid'];
		        }
		    }
		    $pid=C::t('forum_post')->fetch_pid_by_tid_authorid($v['tid'],$v['authorid']);
		    $message = C::t('forum_post')->fetch_message_by_tid_pid($v['tid'],$pid);
		    	
		    $message= preg_replace('/\[quote\]|\[\/quote\]/', '', $message);
		    $message= preg_replace('/\[img\](.*?)\[\/img\]/', '', $message);
		    $message= preg_replace('/\[size=(.+?)\](.*?)\[\/size\]/', '', $message);
		    $message= preg_replace('/\[b\]|\[\/b\]/', '', $message);
		    $message= preg_replace('/\[i=(.+?)\](.*?)\[\/i\]/', '', $message);
		    $message= preg_replace('/\[attach\](.*?)\[\/attach\]/', '', $message);
		    $list[$k]['message'] = cutstr(strip_tags($message),50);
		    	
		    if ($v['attachment']){
		        $attachlist = C::t('forum_attachment_n')->fetch_all_by_id('tid:'.$v['tid'], 'pid', $pid,'',true);
		         
		    }
		    if (count($attachlist)>3){
		        $attachlist = array_slice($attachlist,0,3);
		    }
		    foreach ($attachlist as $key=>$attach){
		        if ($attach['aid']) {
		            $attach_arr[] = array(
		                'aid' => $attach['aid'],
		                'filename' => $attach['filename'],
		                'isimage' => $attach['isimage'],
		                'attachment' =>$_G['siteurl'].getforumimg($attach['aid'], 0, 200, 200, 'fixnone'),
		                'dateline' => $attach['dateline']
		            );
		        }
		    }
		   
		    $list[$k]['images_num'] = count($attachlist);
		    $list[$k]['images'] = $attach_arr?$attach_arr:null;
		    unset($attachlist,$attach_arr,$attach,$list[$k]['attachment']);
		}
		
		$variable = array(
		    'forum_threadlist' => $list,
		    'perpage' => $GLOBALS['perpage'],
		    'page' => $_G['page'],
		);
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>