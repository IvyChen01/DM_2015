<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forumindex.php 27451 2012-02-01 05:48:47Z monkey $
 */
if (! defined('IN_MOBILE_API')) {
	exit('Access Denied');
}
define('APPTYPEID', 2);
define('CURSCRIPT', 'forum');
require_once './source/class/class_core.php';
require_once './source/function/function_forum.php';
C::app()->init();
global $_G;
if (! function_exists('discuzcode')) {
	@require_once DISCUZ_ROOT . './source/function/function_discuzcode.php';
} 

	$page = $_G['page'];
	$threadtableids = ! empty($_G['cache']['threadtableids']) ? $_G['cache']['threadtableids'] : array ();
	$tableid = $_GET['archiveid'] && in_array($_GET['archiveid'],$threadtableids) ? intval($_GET['archiveid']) : 0;
	$forumdisplayadd = array ('orderby' => '');
	
	$filterfield = array ('dateline','page','orderby','lastpost','digest');
	
	foreach ( $filterfield as $v ) {
		$forumdisplayadd[$v] = '';
	}
	
	$filter = isset($_GET['filter']) && in_array($_GET['filter'],$filterfield) ? $_GET['filter'] : '';
	$filterbool = ! empty($filter);
	$filterarr = array ();
	
	if (! empty($_GET['orderby']) && ! $_G['setting']['closeforumorderby'] && in_array($_GET['orderby'],array ('lastpost','dateline'))) {
		$forumdisplayadd['orderby'] .= '&orderby=' . $_GET['orderby'];
	} else {
		$_GET['orderby'] = 'lastpost';
	}
	$_GET['ascdesc'] = 'DESC';
	$filterarr['inforum'] = $fids?$fids:41;
	$filterarr['intype'] = intval($_GET['typeid']);
	$filterarr['sticky'] = 4;
	$filterarr['digest'] = 0;
	if ($_GET['typeid']){
	    $filterarr['displayorder'] = $gid ? array(0,2,4) : array(0,1,2,4);
	}else{
	    $filterarr['displayorder'] = $gid ? array(0,2,4) : array(0,1,4);
	}
	
	$filterarr['sql_where'] = $gid ?'':"and `closed` = 0 or `displayorder` = 3";
	$forum_threadcount=C::t('forum_thread')->count_search($filterarr,$tableid);
	
	if ($forum_threadcount) {
		@ceil($forum_threadcount / $_G['tpp']) < $page && $page = 1;
		$start_limit = ($page - 1) * $_G['tpp'];
		
		$forumdisplayadd['page'] = ! empty($forumdisplayadd['page']) ? $forumdisplayadd['page'] : '';
		//$multipage_archive = $_GET['archiveid'] && in_array($_GET['archiveid'],$threadtableids) ? "&archiveid={$_GET['archiveid']}" : '';
		
		$realpages = @ceil($forum_threadcount / $_G['tpp']);
		$maxpage = ($_G['setting']['threadmaxpages'] && $_G['setting']['threadmaxpages'] < $realpages) ? $_G['setting']['threadmaxpages'] : $realpages;
		$fileds_threads = array ('tid','author','authorid','subject','dateline','views','replies','displayorder');
		$fileds_posts = array('pid','fid','tid','message','attachment'); 
		$threads=C::t('forum_thread')->fetch_feilds_search($filterarr,$fileds_threads,$tableid,$start_limit,$_G['tpp'],"displayorder DESC, $_GET[orderby] $_GET[ascdesc]",'',$filterbool && $filterarr['digest'] ? " FORCE INDEX (digest) " : "");
	    
		$threadindex = 0;
		$forum_threadlist = array ();
		$url = substr($_G['siteurl'], 0,strrpos($_G['siteurl'],'/',-9)+1);
	
		foreach ( $threads as $thread ) {
		    
			$thread['avatar'] = avatar($thread['authorid'],'small');
			$thread['bigavatar'] = avatar($thread['authorid'],'big',true);
			//$multipate_archive = $_GET['archiveid'] && in_array($_GET['archiveid'],$threadtableids) ? "archiveid={$_GET['archiveid']}" : '';
			$thread['dateline'] = dgmdate($thread['dateline'],'u','9999',getglobal('setting/dateformat'));
			$thread['dateline'] = preg_replace("/&nbsp;/",' ',$thread['dateline']);
			// 增加是否已收藏的标志
			$thread ['has_favorite'] = 0;
			$thread ['favid'] = 0;
			if ($_G ['uid']) {
				$favorite_log = C::t ( 'home_favorite' )->fetch_by_id_idtype ( $thread ['tid'], "tid", $_G ['uid'] );
				
				if (is_array ( $favorite_log ) && $favorite_log) {
					$thread ['has_favorite'] = 1;
					//$thread ['favid'] = $favorite_log ['favid'];
				}
			}
			$thread['sticky'] = $thread['displayorder'] > 0 ? 1:0;
			unset($thread['displayorder']);
			$forum_threadlist[$thread['tid']] = $thread;
			
			$postlist[$threadindex] = C::t('forum_post')->fetch_feilds_by_tid($tableid,$thread['tid'],$fileds_posts,true,'',0,0,1);
			
			$pid_arr = array_keys($postlist[$threadindex]);
			
			$pid = $pid_arr[0];
			
			$post['message'] = parse_post_message($postlist[$threadindex][$pid]);
			
			if ($postlist[$threadindex][$pid]['attachment']) {
				$attachlist = C::t('forum_attachment_n')->fetch_all_by_id('tid:'.$thread['tid'], 'pid', $pid,'',true);
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
			
			$forum_threadlist[$thread['tid']]['images_num'] = count($attachlist);
			$forum_threadlist[$thread['tid']]['images'] = $attach_arr?$attach_arr:null;
			$forum_threadlist[$thread['tid']]['message'] = cutstr(strip_tags($post['message']),200);
			$threadindex ++;
			unset($attachlist,$attach_arr,$attach);
		}
	}
	
$variable['forum_threadlist'] = array_values($forum_threadlist);
$variable['tpp'] = $_G['tpp'];
$variable['page'] = $_G['page'];
$variable['totalpage'] = $GLOBALS['maxpage'];
mobile_core::result(mobile_core::variable($variable));
?>