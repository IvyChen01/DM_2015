<?php
 
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$pluginid='aljbd';
$table='aljbd_syscache';
echo '<table class="tb tb2 " id="tips">
	<tr>
		<th  class="partition">'.lang('plugin/'.$pluginid.'','daka24').'</th>
	</tr>
	<tr>
		<td class="tipsblock" s="1">
			<ul id="tipslis">
				<li>'.lang('plugin/'.$pluginid.'','daka25').'</li>
				<li>'.lang('plugin/'.$pluginid.'','daka26').'</li>
				<li>'.lang('plugin/'.$pluginid.'','daka27').'</li>
				<li>'.lang('plugin/'.$pluginid.'','daka43').'</li>
				<li>'.lang('plugin/'.$pluginid.'','daka53').'</li>
			</ul>
		</td>
	</tr>
</table><br>';
require_once libfile('class/xml');
include template('aljbd:nav');
$lj_plugin = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE identifier='".$pluginid."'");
$lj_dir = substr($lj_plugin['directory'], 0, -1);
$lj_modules = unserialize($lj_plugin['modules']);
if($_GET['cache']=='p_s'){
	if(!submitcheck('addsubmit')) {
		$cache=DB::result_first("select data from ".DB::table('common_syscache')." where cname='pluginlanguage_template'");
		$data=unserialize($cache);
		
		if(!C::t('#'.$pluginid.'#'.$table)->fetch_count('2')||C::t('#'.$pluginid.'#'.$table)->fetch_count('2')<count($data[$pluginid])){
			
			foreach($data[$pluginid] as $k=>$s){
				if(!C::t('#'.$pluginid.'#'.$table)->fetch_count_sign($k,'2')){
					C::t('#'.$pluginid.'#'.$table)->insert(array(
						'plugin_b'=>$k,
						'plugin_w'=>$s,
						'plugin_sign'=>'2',
					));
				}
			}
		}
		if(!C::t('#'.$pluginid.'#'.$table)->fetch_count('4')||C::t('#'.$pluginid.'#'.$table)->fetch_count('4')<count($data[$pluginid])){
			
			foreach($data[$pluginid] as $k=>$s){
				if(!C::t('#'.$pluginid.'#'.$table)->fetch_count_sign($k,'4')){
					C::t('#'.$pluginid.'#'.$table)->insert(array(
						'plugin_b'=>$k,
						'plugin_w'=>$s,
						'plugin_sign'=>'4',
					));
				}
			}
		}
		if(!C::t('#'.$pluginid.'#'.$table)->fetch_count('6')||C::t('#'.$pluginid.'#'.$table)->fetch_count('6')<count($data[$pluginid])){
			
			foreach($data[$pluginid] as $k=>$s){
				if(!C::t('#'.$pluginid.'#'.$table)->fetch_count_sign($k,'6')){
					C::t('#'.$pluginid.'#'.$table)->insert(array(
						'plugin_b'=>$k,
						'plugin_w'=>$s,
						'plugin_sign'=>'6',
					));
				}
			}
		}
		$plugin_bw=C::t('#'.$pluginid.'#'.$table)->fetch_all_by_sign('2');
		$url='admin.php?action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s';
		include template($pluginid.':scache');
	}else{
		if(is_array($_GET['plugin_all'])){
			foreach($_GET['plugin_all'] as $b=>$w){
				if($b){
					DB::update($table,array('plugin_w'=>$w),array('plugin_b'=>$b,'plugin_sign'=>'2'));
					DB::update($table,array('plugin_w'=>$w),array('plugin_b'=>$b,'plugin_sign'=>'6'));
				}
			}
			$cache=DB::result_first("select data from ".DB::table('common_syscache')." where cname='pluginlanguage_template'");
			$data=unserialize($cache);
			$data[$pluginid]=$_GET['plugin_all'];
			DB::update('common_syscache',array('data'=>serialize($data)),"cname='pluginlanguage_template'");
			$file = DISCUZ_ROOT.'./source/plugin/'.$lj_dir.'/discuz_plugin_'.$lj_dir.($lj_modules['extra']['installtype'] ? '_'.$lj_modules['extra']['installtype'] : '').'.xml';
			//debug($file);
			if(file_exists($file)) {
				$importtxt = @implode('', file($file));
				$data = $GLOBALS['importtxt'];
				//debug($GLOBALS);
				$xmldata = xml2array($data);
				$xmldata['Data']['language']['templatelang']=$_GET['plugin_all'];
				//debug($xmldata);
				$handle=fopen($file,"w");
				if(!$handle){
						cpmsg(lang('plugin/'.$pluginid.'','daka28'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s', 'error');
				}
				if(fwrite($handle,array2xml($xmldata,1))){
					fclose($handle);
					updatecache(array('plugin'));
					cleartemplatecache();
					cpmsg(lang('plugin/'.$pluginid.'','daka29'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s', 'succeed');
				}
				fclose($handle);
				cpmsg(lang('plugin/'.$pluginid.'','daka28'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s', 'error');
			}
		}
		cpmsg(lang('plugin/'.$pluginid.'','daka21'),'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s');
	}
}else if($_GET['cache']=='gl'){
	include template($pluginid.':gl');
}else if($_GET['cache']=='geshihua3'){
	if($_GET['formhash']==formhash()){
		$plugin_bw=C::t('#'.$pluginid.'#'.$table)->fetch_all_by_sign('3');
		foreach($plugin_bw as $w){
			DB::update($table,array('plugin_w'=>$w['plugin_w']),array('plugin_b'=>$w['plugin_b'],'plugin_sign'=>'1'));
			$plugin_data[$w['plugin_b']]=$w['plugin_w'];
		}
		
		$cache=DB::result_first("select data from ".DB::table('common_syscache')." where cname='pluginlanguage_script'");
		$data=unserialize($cache);
		//debug($data);
		$data[$pluginid]=$plugin_data;
		DB::update('common_syscache',array('data'=>serialize($data)),"cname='pluginlanguage_script'");
		$file = DISCUZ_ROOT.'./source/plugin/'.$lj_dir.'/discuz_plugin_'.$lj_dir.($lj_modules['extra']['installtype'] ? '_'.$lj_modules['extra']['installtype'] : '').'.xml';
		//debug($file);
		if(file_exists($file)) {
			$importtxt = @implode('', file($file));
			$data = $GLOBALS['importtxt'];
			//debug($GLOBALS);
			$xmldata = xml2array($data);
			$xmldata['Data']['language']['scriptlang']=$plugin_data;
			//debug($xmldata);
			$handle=fopen($file,"w");
			if(!$handle){
					cpmsg(lang('plugin/'.$pluginid.'','daka31'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache', 'error');
			}
			if(fwrite($handle,array2xml($xmldata,1))){
				fclose($handle);
				updatecache(array('plugin'));
				cleartemplatecache();
				cpmsg(lang('plugin/'.$pluginid.'','daka32'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache', 'succeed');
			}
			fclose($handle);
			cpmsg(lang('plugin/'.$pluginid.'','daka31'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache', 'error');
		}
		cpmsg(lang('plugin/'.$pluginid.'','daka41'),'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache');
	}
	
}else if($_GET['cache']=='geshihua4'){
	if($_GET['formhash']==formhash()){
		$plugin_bw=C::t('#'.$pluginid.'#'.$table)->fetch_all_by_sign('4');
		foreach($plugin_bw as $w){
			DB::update($table,array('plugin_w'=>$w['plugin_w']),array('plugin_b'=>$w['plugin_b'],'plugin_sign'=>'2'));
			$plugin_data[$w['plugin_b']]=$w['plugin_w'];
		}
		$cache=DB::result_first("select data from ".DB::table('common_syscache')." where cname='pluginlanguage_template'");
		$data=unserialize($cache);
		//debug($data);
		$data[$pluginid]=$plugin_data;
		DB::update('common_syscache',array('data'=>serialize($data)),"cname='pluginlanguage_template'");
		$file = DISCUZ_ROOT.'./source/plugin/'.$lj_dir.'/discuz_plugin_'.$lj_dir.($lj_modules['extra']['installtype'] ? '_'.$lj_modules['extra']['installtype'] : '').'.xml';
		//debug($file);
		if(file_exists($file)) {
			$importtxt = @implode('', file($file));
			$data = $GLOBALS['importtxt'];
			//debug($GLOBALS);
			$xmldata = xml2array($data);
			$xmldata['Data']['language']['templatelang']=$plugin_data;
			//debug($xmldata);
			$handle=fopen($file,"w");
			if(!$handle){
					cpmsg(lang('plugin/'.$pluginid.'','daka35'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s', 'error');
			}
			if(fwrite($handle,array2xml($xmldata,1))){
				fclose($handle);
				updatecache(array('plugin'));
				cleartemplatecache();
				cpmsg(lang('plugin/'.$pluginid.'','daka36'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s', 'succeed');
			}
			fclose($handle);
			cpmsg(lang('plugin/'.$pluginid.'','daka35'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s', 'error');
		}
		cpmsg(lang('plugin/'.$pluginid.'','daka41'),'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s');
	}
}else if($_GET['cache']=='huifu5'){
	if($_GET['formhash']==formhash()){
		$plugin_bw=C::t('#'.$pluginid.'#'.$table)->fetch_all_by_sign('5');
		foreach($plugin_bw as $w){
			DB::update($table,array('plugin_w'=>$w['plugin_w']),array('plugin_b'=>$w['plugin_b'],'plugin_sign'=>'1'));
			$plugin_data[$w['plugin_b']]=$w['plugin_w'];
		}
		$cache=DB::result_first("select data from ".DB::table('common_syscache')." where cname='pluginlanguage_script'");
		$data=unserialize($cache);
		//debug($data);
		$data[$pluginid]=$plugin_data;
		DB::update('common_syscache',array('data'=>serialize($data)),"cname='pluginlanguage_script'");
		$file = DISCUZ_ROOT.'./source/plugin/'.$lj_dir.'/discuz_plugin_'.$lj_dir.($lj_modules['extra']['installtype'] ? '_'.$lj_modules['extra']['installtype'] : '').'.xml';
		//debug($file);
		if(file_exists($file)) {
			$importtxt = @implode('', file($file));
			$data = $GLOBALS['importtxt'];
			//debug($GLOBALS);
			$xmldata = xml2array($data);
			$xmldata['Data']['language']['scriptlang']=$plugin_data;
			//debug($xmldata);
			$handle=fopen($file,"w");
			if(!$handle){
					cpmsg(lang('plugin/'.$pluginid.'','daka39'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache', 'error');
			}
			if(fwrite($handle,array2xml($xmldata,1))){
				fclose($handle);
				updatecache(array('plugin'));
				cleartemplatecache();
				cpmsg(lang('plugin/'.$pluginid.'','daka40'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache', 'succeed');
			}
			fclose($handle);
			cpmsg(lang('plugin/'.$pluginid.'','daka39'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache', 'error');
		}
		cpmsg(lang('plugin/'.$pluginid.'','daka42'),'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache');
	}
}else if($_GET['cache']=='huifu6'){
	if($_GET['formhash']==formhash()){
		$plugin_bw=C::t('#'.$pluginid.'#'.$table)->fetch_all_by_sign('6');
		foreach($plugin_bw as $w){
			DB::update($table,array('plugin_w'=>$w['plugin_w']),array('plugin_b'=>$w['plugin_b'],'plugin_sign'=>'2'));
			$plugin_data[$w['plugin_b']]=$w['plugin_w'];
		}
		$cache=DB::result_first("select data from ".DB::table('common_syscache')." where cname='pluginlanguage_template'");
		$data=unserialize($cache);
		//debug($data);
		$data[$pluginid]=$plugin_data;
		DB::update('common_syscache',array('data'=>serialize($data)),"cname='pluginlanguage_template'");
		$file = DISCUZ_ROOT.'./source/plugin/'.$lj_dir.'/discuz_plugin_'.$lj_dir.($lj_modules['extra']['installtype'] ? '_'.$lj_modules['extra']['installtype'] : '').'.xml';
		//debug($file);
		if(file_exists($file)) {
			$importtxt = @implode('', file($file));
			$data = $GLOBALS['importtxt'];
			//debug($GLOBALS);
			$xmldata = xml2array($data);
			$xmldata['Data']['language']['templatelang']=$plugin_data;
			//debug($xmldata);
			$handle=fopen($file,"w");
			if(!$handle){
					cpmsg(lang('plugin/'.$pluginid.'','daka37'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s', 'error');
			}
			if(fwrite($handle,array2xml($xmldata,1))){
				fclose($handle);
				updatecache(array('plugin'));
				cleartemplatecache();
				cpmsg(lang('plugin/'.$pluginid.'','daka38'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s', 'succeed');
			}
			fclose($handle);
			cpmsg(lang('plugin/'.$pluginid.'','daka37'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s', 'error');
		}
		cpmsg(lang('plugin/'.$pluginid.'','daka42'),'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache&cache=p_s');
	}
}else{
	if(!submitcheck('addsubmit')) {
		$cache=DB::result_first("select data from ".DB::table('common_syscache')." where cname='pluginlanguage_script'");
		$data=unserialize($cache);
		if(!C::t('#'.$pluginid.'#'.$table)->fetch_count('1')||C::t('#'.$pluginid.'#'.$table)->fetch_count('1')<count($data[$pluginid])){
			
			foreach($data[$pluginid] as $k=>$s){
				if(!C::t('#'.$pluginid.'#'.$table)->fetch_count_sign($k,'1')){
					C::t('#'.$pluginid.'#'.$table)->insert(array(
						'plugin_b'=>$k,
						'plugin_w'=>$s,
						'plugin_sign'=>'1',
					));
				}
			}
		}
		if(!C::t('#'.$pluginid.'#'.$table)->fetch_count('3')||C::t('#'.$pluginid.'#'.$table)->fetch_count('3')<count($data[$pluginid])){
			
			foreach($data[$pluginid] as $k=>$s){
				if(!C::t('#'.$pluginid.'#'.$table)->fetch_count_sign($k,'3')){
					C::t('#'.$pluginid.'#'.$table)->insert(array(
						'plugin_b'=>$k,
						'plugin_w'=>$s,
						'plugin_sign'=>'3',
					));
				}
			}
		}
		if(!C::t('#'.$pluginid.'#'.$table)->fetch_count('5')||C::t('#'.$pluginid.'#'.$table)->fetch_count('5')<count($data[$pluginid])){
			
			foreach($data[$pluginid] as $k=>$s){
				if(!C::t('#'.$pluginid.'#'.$table)->fetch_count_sign($k,'5')){
					C::t('#'.$pluginid.'#'.$table)->insert(array(
						'plugin_b'=>$k,
						'plugin_w'=>$s,
						'plugin_sign'=>'5',
					));
				}
			}
		}
		
		$plugin_bw=C::t('#'.$pluginid.'#'.$table)->fetch_all_by_sign('1');
		$url='admin.php?action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache';
		include template($pluginid.':scache');	
	}else{
		//debug($_GET['plugin_all']);
		if(is_array($_GET['plugin_all'])){
			foreach($_GET['plugin_all'] as $b=>$w){
				if($b){
					DB::update($table,array('plugin_w'=>$w),array('plugin_b'=>$b,'plugin_sign'=>'1'));
					DB::update($table,array('plugin_w'=>$w),array('plugin_b'=>$b,'plugin_sign'=>'5'));
				}
			}
			$cache=DB::result_first("select data from ".DB::table('common_syscache')." where cname='pluginlanguage_script'");
			$data=unserialize($cache);
			
			$data[$pluginid]=$_GET['plugin_all'];
			//debug($data[$pluginid]);
			DB::update('common_syscache',array('data'=>serialize($data)),"cname='pluginlanguage_script'");
			$file = DISCUZ_ROOT.'./source/plugin/'.$lj_dir.'/discuz_plugin_'.$lj_dir.($lj_modules['extra']['installtype'] ? '_'.$lj_modules['extra']['installtype'] : '').'.xml';
			//debug($file);
			if(file_exists($file)) {
				$importtxt = @implode('', file($file));
				$data = $GLOBALS['importtxt'];
				//debug($GLOBALS);
				$xmldata = xml2array($data);
				$xmldata['Data']['language']['scriptlang']=$_GET['plugin_all'];
				//debug($xmldata);
				$handle=fopen($file,"w");
				if(!$handle){
						cpmsg(lang('plugin/'.$pluginid.'','daka33'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache', 'error');
				}
				if(fwrite($handle,array2xml($xmldata,1))){
					fclose($handle);
					updatecache(array('plugin'));
					cleartemplatecache();
					cpmsg(lang('plugin/'.$pluginid.'','daka34'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache', 'succeed');
				}
				fclose($handle);
				cpmsg(lang('plugin/'.$pluginid.'','daka33'), 'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache', 'error');
			}
		}
		cpmsg(lang('plugin/'.$pluginid.'','daka21'),'action=plugins&operation=config&do=39&identifier='.$pluginid.'&pmod=cache');
	}
}
?>
