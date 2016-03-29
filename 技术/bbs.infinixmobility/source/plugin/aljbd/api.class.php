<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 34718 2014-07-14 08:56:39Z nemohou $
 */
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class aljbd_api {

	function forumdisplay_topBar() {
		global $_G;
		$config = $_G['cache']['plugin']['aljbd'];
		require_once DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php';
		$return = array();
		$url = WeChatHook::getPluginUrl('aljbd:aljbd',array('act' => 'attend'));
		$index_url = WeChatHook::getPluginUrl('aljbd:aljbd');
		$return[] = array(
			'name' => lang('plugin/aljbd','sj_1'),
			'html' => '<a href="'.$index_url.'">'.$config['wsq_1'].'</a><br/><br/><a href="'.$url.'">'.$config['wsq_2'].'</a>',
			'more' => '',
		);
		return $return;
	}

}

?>
