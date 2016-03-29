<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * From www.1314study.com
 */
//print_r($_G);
//print_r(FORMHASH);
$uid = intval($_G['uid']);
$splugin_setting = $_G['cache']['plugin']['study_daily_attendance'];
if(!empty($_GET['formhash']) && $_GET['formhash'] == formhash()){
	if($uid){
		$today_reward = intval($splugin_setting['today_reward']);	//每日签到奖励
		$more_reward = intval($splugin_setting['more_reward']);	//连续签到奖励	
		$groupsid = intval($splugin_setting['groupsid']);	//要签到的用户组
		$type_reward = intval($splugin_setting['type_reward']);//奖励类型
		$numb_days = intval($splugin_setting['numb_days']);//签到多少天奖励
		$daytime = strtotime(date('Y-m-d',intval($_G['timestamp'])));
		$ystd_daytime = strtotime(date('Y-m-d',(intval($_G['timestamp'])-24*3600)));
		$isexit = DB::fetch_first("SELECT * FROM ".DB::table('study_daily_attendance')." WHERE uid = '$uid' AND dateline >= '$daytime'");	
		if($isexit){
			showmessage(lang('plugin/study_daily_attendance', 'slang_001'));
		}else{
			DB::INSERT('study_daily_attendance',array(uid => $uid, 'dateline'=> intval($_G['timestamp'])));
			$conti_days = DB::result_first("SELECT conti_days FROM ".DB::table('study_daily_attendance_continuous_sign')." where uid = ".$uid);
			
			if($conti_days < 1){ 
				DB::INSERT('study_daily_attendance_continuous_sign', array('uid' => $uid, 'conti_days' => 1));
			}
			
			$ystd_isexit = DB::fetch_first("SELECT * FROM ".DB::table('study_daily_attendance')." WHERE uid = ".$uid." AND  dateline >= ".$ystd_daytime." AND dateline <= ".$daytime);
			
			if($ystd_isexit){
				
				DB::query("UPDATE ".DB::table('study_daily_attendance_continuous_sign')." SET conti_days = conti_days + 1 where uid = ".$uid);
		
				if($conti_days + 1 >= $numb_days){ 
					$today_reward += $more_reward;
					
				}
			}else{
				DB::UPDATE('study_daily_attendance_continuous_sign', array('conti_days'=> 1),array('uid' => $uid));
			}
			if(in_array($type_reward,array(1,2,3,4,5,6,7,8))){
			DB::query("UPDATE  ".DB::table('common_member_count')." SET extcredits".$type_reward ."= extcredits".$type_reward." + ".$today_reward." WHERE uid = '$uid'");
			}
			$string= lang('plugin/study_daily_attendance', 'slang_002').$today_reward.$_G[setting][extcredits][$type_reward][title];
			//print_r($_G[setting][extcredits]);
			if($conti_days + 1 >= $numb_days){
				$string = $string.lang('plugin/study_daily_attendance', 'slang_003').$numb_days.lang('plugin/study_daily_attendance', 'slang_004').$more_reward.$_G[setting][extcredits][$type_reward][title];
			}
			$_G['setting']['msgforward']['refreshtime'] = 10;
			showmessage($string,'forum.php'); 
		}
	}else{
		  showmessage('not_loggedin', null, array(), array('login' => 1));
	}
}
?>