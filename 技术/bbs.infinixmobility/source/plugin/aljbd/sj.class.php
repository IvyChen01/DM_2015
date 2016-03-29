<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Deined');
}
class mobileplugin_aljbd {
	function index_top_mobile() {
		global $_G;
		$config = $_G ['cache'] ['plugin'] ['aljbd'];
		if (!file_exists(DISCUZ_ROOT . './source/plugin/aljbd/template/mobile/list.htm')) {
			return;
		}
		if($_GET['mobile']=='1'){
			$xian='<span class="pipe">|</span>';
		}else{
			$xian='&nbsp;&nbsp;&nbsp;';
		}
		return $xian.'<a href="plugin.php?id=aljbd">'.lang('plugin/aljbd','sj_1').'</a>';
		
	}
}
class mobileplugin_aljbd_forum extends mobileplugin_aljbd {
}
?>