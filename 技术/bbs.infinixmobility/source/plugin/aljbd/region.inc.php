<?php
/**
 *      [Liangjian] (C)2001-2099 Liangjian Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: region.inc.php liangjian $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if($_GET['act'] == 'empty'){
	$sql='TRUNCATE TABLE '.DB::table('aljbd_region');
	DB::query($sql);
	cpmsg(lang('plugin/aljbd','s10'),'action=plugins&operation=config&identifier=aljbd&pmod=region&upid='.$_GET['upid']);
}else if($_GET['act'] == 'importall'){
	foreach(C::t('common_district')->range() as $rid => $r){
		if(C::t('#aljbd#aljbd_region')->count_by_upid($r['id'])){
			cpmsg('导入地区表请先清空插件表');
		}
		if($r['level']>3){
			break;
		}
		C::t('#aljbd#aljbd_region')->insert(array(
			'catid'=>$r['id'],
			'name'=>$r['name'],
			'upid'=>$r['upid'],
			'subcatid'=>$r['id'],
			'level'=>$r['level']-1,
		));
	}
	cpmsg(lang('plugin/aljbd','s10'),'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=region&upid='.$_GET['upid']);
}else if($_GET['act'] == 'import'){
	if(!submitcheck('submit')){
		include template('common/header');
		include_once libfile('function/profile');
		$rlist=C::t('#aljbd#aljbd_region')->fetch_all_by_upid_sys();
		foreach($rlist as $rid => $r){
			$str.='<option value="'.$r['id'].'" >'.$r['name'].'</option>';
		}
		$districthtml = '<select name="birthprovince" id="region" style="width:120px;" onchange="ajaxget(\'plugin.php?id=aljbd&act=admingetregion&upid=\'+$(\'region\').value,\'subregion\')">
							<option value="">&#45;&#30465;&#20221;&#45;</option>
							'.$str.'
						</select>';	
		$districthtml.='<span name="subregion" id="subregion"></span><span name="region1" id="region1"></span>';
		showformheader('plugins&operation=config&identifier=aljbd&pmod=region&act=import');	
		showtableheader('', 'nobottom');
		echo '<div style="height:170px;width:530px;"><h3 class="flb mn"><span><a href="javascript:;" class="flbc" onclick="hideWindow(\'edit\',1,0);" title="Close">Close</a></span>'.
			lang('plugin/aljbd','region_import').'</h3><div style="margin-left:10px;">'.$districthtml.'<p style="padding:10px; color:#3333CC; line-height:20px;">'.lang('plugin/aljbd','region_annotation').'</p></div></div>';
		showsubmit('submit', 'import');
		showtablefooter();
		showformfooter();	
		include template('common/footer');
	}else{
		$regionarr = array();
		$regionarr['birthprovince'] = dhtmlspecialchars(trim($_GET['birthprovince']));
		if(!$regionarr['birthprovince']){
			cpmsg(lang('plugin/aljbd','Please_select_a_province'));
		}
		$regionarr['birthcity'] = dhtmlspecialchars(trim($_GET['birthcity']));
		$regionarr['birthdist'] = dhtmlspecialchars(trim($_GET['birthdist']));
		$regionarr['birthcommunity'] = dhtmlspecialchars(trim($_GET['birthcommunity']));
		$upid = 0;
		if ($regionarr['birthprovince']) {
		   $upid = $regionarr['birthprovince'];
		   if ($regionarr['birthcity']) {
				$upid = $regionarr['birthcity'];	
				if($regionarr['birthdist']){
					$upid = $regionarr['birthdist'];		
				}
		   }
		}
		if(!$upid){
			cpmsg(lang('plugin/aljbd','Please_select_a_province'));
		}
		foreach(C::t('#aljbd#aljbd_region')->fetch_all_by_upid_sys($upid) as $data) {
		    $insertarray=array('name'=>$data['name'],'upid'=>'');
			$insertid=C::t('#aljbd#aljbd_region')->insert($insertarray,true);
			DB::update('aljbd_region', array('subcatid'=>$insertid), "catid='$insertid'");
			if(C::t('#aljbd#aljbd_region')->fetch_all_by_upid_sys($data['id'])){
				foreach(C::t('#aljbd#aljbd_region')->fetch_all_by_upid_sys($data['id']) as $data_1) {
					
					$insertarray=array('name'=>$data_1['name'],'upid'=>$insertid);
					$insertid_1=C::t('#aljbd#aljbd_region')->insert($insertarray,true);
					DB::update('aljbd_region', array('subcatid'=>$insertid_1), "catid='$insertid_1'");
					$region=C::t('#aljbd#aljbd_region')->fetch($insertid);
					$region['subcatid']=trim(($region['subcatid'].','.$insertid_1),',');
					$level=$region['level']+1;
					$region['havechild']=1;
					C::t('#aljbd#aljbd_region')->update($region['catid'],$region);
					DB::update('aljbd_region', array('level'=>$level), "catid='$insertid_1'");
					if(C::t('#aljbd#aljbd_region')->fetch_all_by_upid_sys($data_1['id'])){
						foreach(C::t('#aljbd#aljbd_region')->fetch_all_by_upid_sys($data_1['id']) as $data_2) {
							$insertarray=array('name'=>$data_2['name'],'upid'=>$insertid_1);
							$insertid_2=C::t('#aljbd#aljbd_region')->insert($insertarray,true);
							DB::update('aljbd_region', array('subcatid'=>$insertid_2), "catid='$insertid_2'");
							$region_1=C::t('#aljbd#aljbd_region')->fetch($insertid_1);
							$region_1['subcatid']=trim(($region_1['subcatid'].','.$insertid_2),',');
							
							$level_1=$region_1['level']+1;
							$region_1['havechild']=1;
							C::t('#aljbd#aljbd_region')->update($region_1['catid'],$region_1);
							DB::update('aljbd_region', array('level'=>$level_1), "catid='$insertid_2'");
						}
					}
				}
			}
		}
		
		cpmsg(lang('plugin/aljbd','s10'),'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=region&upid='.$_GET['upid']);
	}
}else{
	if(!submitcheck('submit')){
		if($_GET['upid']){
			$upid_data=C::t('#aljbd#aljbd_region')->fetch($_GET['upid']);
			
		}
		$currpage=$_GET['page']?$_GET['page']:1;
		$perpage=20;
		$num=C::t('#aljbd#aljbd_region')->count_by_upid($_GET['upid']);
		$start=($currpage-1)*$perpage;
		$region=C::t('#aljbd#aljbd_region')->fetch_all_by_upid($start,$perpage,$_GET['upid']);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier=aljbd&pmod=region&upid='.$_GET['upid'], 0, 11, false, false);	
		include template('aljbd:region');
	}else{
		
		if($_GET['delete']){
			foreach($_GET['delete'] as $key=>$value){
				C::t('#aljbd#aljbd_region')->delete($value);
			}
		}else if($_GET['name']){
			foreach($_GET['name'] as $key=>$value){
				C::t('#aljbd#aljbd_region')->update($key,array('name'=>$value));
			}
			if($_GET['displayorder']){
				foreach($_GET['displayorder'] as $key=>$value){
					C::t('#aljbd#aljbd_region')->update($key,array('displayorder'=>$value));
				}
			}
		} 
		foreach($_GET['newregion'] as $key=>$value){
			if($value){
				$insertarray=array('name'=>$value,'upid'=>$_GET['upid'],'displayorder'=>$_GET['newdisplayorder'][$key]);
				$insertid=C::t('#aljbd#aljbd_region')->insert($insertarray,true);
				DB::update('aljbd_region', array('subcatid'=>$insertid), "catid='$insertid'");
				if($_GET['upid']){
					$region=C::t('#aljbd#aljbd_region')->fetch($_GET['upid']);
					$region['subcatid']=trim(($region['subcatid'].','.$insertid),',');
					$level=$region['level']+1;
					$region['havechild']=1;
					C::t('#aljbd#aljbd_region')->update($region['catid'],$region);
					DB::update('aljbd_region', array('level'=>$level), "catid='$insertid'");
				}
			}
		}
		
		cpmsg(lang('plugin/aljbd','s10'),'action=plugins&operation=config&do='.$_GET['do'].'&identifier=aljbd&pmod=region&upid='.$_GET['upid']);
	}
}
?>