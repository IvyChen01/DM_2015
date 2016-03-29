<?php
	if(!defined('IN_DISCUZ')) {
	exit('Access Deined');
}
class mobileplugin_aljlp {
	function index_top_mobile() {
		global $_G;
		$config = $_G ['cache'] ['plugin'] ['aljlp'];
		if(!$config['sjurl']){
			return;
		}
		if (!file_exists(DISCUZ_ROOT . './source/plugin/aljlp/template/mobile/index.htm')) {
			return;
		}
		if($_GET['mobile']=='1'){
			$xian='<span class="pipe">|</span>';
		}else{
			$xian='&nbsp;&nbsp;&nbsp;';
		}
		return $xian.'<a href="plugin.php?id=aljlp">'.$config['daohang'].'</a>';
		
	}
}
class mobileplugin_aljlp_forum extends mobileplugin_aljlp {
}
?>