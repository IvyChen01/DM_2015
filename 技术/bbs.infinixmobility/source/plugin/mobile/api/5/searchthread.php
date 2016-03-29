<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forumindex.php 27451 2012-02-01 05:48:47Z monkey $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'curforum';
include_once 'search.php';

class mobile_api {

	function common() {
	}

	function output() {
		global $_G;
		$index = $GLOBALS['index'];
		$totalpage = @ceil($index['num']/$_G['tpp']);
		
		$variable = array(
			'forum_threadlist'=>mobile_core::getvalues($GLOBALS['threadlist'], array('/^\d+$/'), array('tid','author','authorid','views','replies', 'subject','message','dateline','displayorder')),
		    'total'=>$index['num'],
			'ppp'=>$_G['tpp'],
			'page'=>$GLOBALS['page'],
			'totalpage'=>$totalpage,
			'searchid'=>$GLOBALS['searchid'],
			'orderby'=>$GLOBALS['orderby'],
			'ascdesc'=>$GLOBALS['ascdesc']		
		);
		if($variable['forum_threadlist']){
			foreach ($variable['forum_threadlist'] as $key=>$thread){
				$thread['subject'] = strip_tags($thread['subject']);
				$variable['forum_threadlist'][$thread['tid']]['message'] = strip_tags($thread['message']);
				$variable['forum_threadlist'][$key]['avatar'] = avatar($thread['authorid'],'small',true,false);
				$variable['forum_threadlist'][$key]['bigavatar'] = avatar($thread['authorid'],'big',true);
				$variable['forum_threadlist'][$key]['sticky'] = $thread['displayorder'] > 0 ? 1:0;
				unset($thread['displayorder']);
				// 增加是否已收藏的标志
				$variable['forum_threadlist'][$key]['has_favorite'] = 0;
				$variable['forum_threadlist'][$key]['favid'] = 0;
				if($_G['uid']) {
					$favorite_log = C::t('home_favorite')->fetch_by_id_idtype($thread['tid'], "tid", $_G['uid']);
					if(is_array($favorite_log) && $favorite_log) {
						$variable['forum_threadlist'][$key]['has_favorite'] = 1;
						$variable['forum_threadlist'][$key]['favid'] = $favorite_log['favid'];
					}
				}
			}
			$variable['forum_threadlist'] = array_values($variable['forum_threadlist']);
		}
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>