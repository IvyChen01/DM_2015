<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Deined');
} 
class plugin_aljbd {
	
}
class plugin_aljbd_forum extends plugin_aljbd {
	
	/**帖内个人信息显示店铺**/
	function viewthread_sidetop_output() {
		global $_G,$postlist;
		$config = $_G['cache']['plugin']['aljbd'];
		if(!$config['ista']||!file_exists('source/plugin/aljbd/com/ta.php')){
			return;
		}
		foreach($postlist as $key=>$value){
			$check = DB::result_first(" select * from ".DB::table('aljbd')." where uid=".$value['authorid']);
			if (!$check) {
				$sharecode[]='<p style="background: url(\'../source/plugin/aljbd/images/button.gif\') no-repeat!important;overflow: hidden;text-align: center;width: 110px;"><a style="color: #FFFFFF;font-size: 14px;"  href="plugin.php?id=aljbd&amp;act=attend" >'.lang('plugin/aljbd','hook_1').'</a></p>';
			}else{
				$sharecode[]='<p style="background: url(\'../source/plugin/aljbd/images/button.gif\') no-repeat!important;background-position: right 0%!important;overflow: hidden;text-align: center;width: 110px;"><a  style="color: #FFFFFF;font-size: 14px;" onclick="showWindow(\'aljbd\',\'plugin.php?id=aljbd&act=glmsg&formhash='.FORMHASH.'&username='.$value['username'].'&uid='.$value['authorid'].'\');" href="javascript:;">'.lang('plugin/aljbd','hook_2').'</a></p>';
			}
		}
		return $sharecode;
	}
} 
?>