<?php
	if(!defined('IN_DISCUZ')) {
	exit('Access Deined');
}
class mobileplugin_aljes {
	function index_top_mobile() {
		global $_G;
		$config = $_G ['cache'] ['plugin'] ['aljes'];
		if(!$config['sjurl']){
			return;
		}
		if (!file_exists(DISCUZ_ROOT . './source/plugin/aljes/template/mobile/index.htm')) {
			return;
		}
		if($_GET['mobile']=='1'){
			$xian='<span class="pipe">|</span>';
		}else{
			$xian='&nbsp;&nbsp;&nbsp;';
		}
		return $xian.'<a href="plugin.php?id=aljes">'.$config['daohang'].'</a>';
		
	}
}
class mobileplugin_aljes_forum extends mobileplugin_aljes {
}
?>