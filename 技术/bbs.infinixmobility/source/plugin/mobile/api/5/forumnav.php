<?php
/**
* Copyright @ 2013 Infinix. All rights reserved.
* ==============================================
* @Description :获取nav列表
* @date: 2015年8月6日 上午10:44:17
* @author: yanhui.chen
* @version:
*/
if (! defined('IN_MOBILE_API')) {
	exit('Access Denied');
}
define('APPTYPEID', 2);
define('CURSCRIPT', 'forum');
require_once './source/class/class_core.php';
require './source/function/function_forum.php';
C::app()->init();

global $_G;
$variable = array ();

$catlist = C::t('forum_forum')->fetch_all_for_ranklist(1,'group',2);
$forums = C::t('forum_forum')->fetch_all_by_status(1);
$forums =array_values(mobile_core::getvalues($forums,array ('/^\d+$/'),array ('fid','fup','type','name')));
foreach ( $forums as $key => $forum ) {
	if ($forum['type'] == 'forum') {
		foreach ( $catlist as $k => $catlist_forum ) {
			if ($catlist_forum['fid'] == $forum['fup']) {
				$_forum = $forum;
				$_forum['sub'] = C::t('forum_forum')->fetch_all_subforum_by_fup($forum['fid']);
				$sub_num = count($_forum['sub']);
				if ($_forum['sub']) {
					for($i = 0; $i < $sub_num; $i ++) {
						$forumfields[$forum['fid']] = C::t('forum_forumfield')->fetch_info_threadtypes_by_fid($_forum['sub'][$i]['fid']);
						$_forum['sub'][$i]['types'] = $forumfields[$forum['fid']]['types'] ? $forumfields[$forum['fid']]['types'] : array ();
						if ($_forum['sub'][$i]['types']) {
							foreach ( $_forum['sub'][$i]['types'] as $id => $name ) {
								$type_arr[] = array ('id' => $id,'name' => $name);
							}
							$_forum['sub'][$i]['types'] = $type_arr;
							unset($type_arr);
						}	
					}
				}
				$forumfields[$forum['fid']] = C::t('forum_forumfield')->fetch_info_threadtypes_by_fid($forum['fid']);
				$_forum['types'] = $forumfields[$forum['fid']]['types'] ? $forumfields[$forum['fid']]['types'] : array ();
				if ($_forum['types']) {
					foreach ( $_forum['types'] as $id => $name ) {
						$type_arr[] = array ('id' => $id,'name' => $name);
					}
					$_forum['types'] = $type_arr;
					unset($type_arr);
				}
				$catlist[$k]['forums'][] = $_forum;
			}
		}
	}
}
//var_dump($catlist);exit;
$variable['catlist'] = array_values(mobile_core::getvalues($catlist,array ('/^\d+$/'),array ('fid','name','icon','forums')));
mobile_core::result(mobile_core::variable($variable));
?>