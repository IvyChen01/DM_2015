<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * From www.1314study.com
 */
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_study_daily_attendance {
	function global_cpnav_extra1(){
		return $this->_show_position(1);//���ڵ��ú�������$this->_show();
	}
	function global_cpnav_extra2(){
		return $this->_show_position(2);
	}
	function global_usernav_extra1(){
		return $this->_show_position(3);	
	}
	function _show_position($position){
		global $_G;
		//print_r($_G);
		$uid = intval($_G['uid']);
		if($uid){
			$groupid = intval($_G['groupid']);
			$splugin_setting = $_G['cache']['plugin']['study_daily_attendance'];
			$position_qd = intval($splugin_setting[position_qd]);//ǩ��λ��
			$setting = unserialize($splugin_setting[groupsid]);//��Ҫǩ�����û���
			$return = ''; 
			if(in_array($groupid,$setting)){
				if($position_qd == $position){
					$daytime = strtotime(date('Y-m-d',intval($_G['timestamp'])));
					$isexit = DB::fetch_first("SELECT * FROM ".DB::table('study_daily_attendance')." WHERE uid = '$uid' AND dateline >= '$daytime' ");	
					if(!$isexit){
							include template('study_daily_attendance:daily_attendance');//���Ϊphp�ļ�����ģ���ļ�
					}	
				}
			}
		}
		return $return;	
	}	
}
class plugin_study_daily_attendance_forum extends plugin_study_daily_attendance {
}
?>