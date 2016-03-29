<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if(!file_exists("source/plugin/aljlp/template/com/attes.php")){
	echo lang('plugin/aljlp','admin_14');
	include_once DISCUZ_ROOT . './source/plugin/aljlp/com_array.inc.php';
	include template('aljlp:com');
	exit;
}
$typearr=array('1'=>lang('plugin/aljlp','admin_9'),'2'=>lang('plugin/aljlp','admin_10'),'3'=>lang('plugin/aljlp','admin_11'),'4'=>lang('plugin/aljlp','admin_12'));
$config = array();
foreach($pluginvars as $key => $val) {
	$config[$key] = $val['value'];	
}
$pluginid='aljlp';
if($_GET['act']=='yes'){
	if(!submitcheck('submit')) {
		$currpage=$_GET['page']?$_GET['page']:1;
		$perpage=$config['page'];
		$num=C::t('#'.$pluginid.'#'.$pluginid.'_attestation')->count_by_status(1);
		$start=($currpage-1)*$perpage;
		$atlist=C::t('#'.$pluginid.'#'.$pluginid.'_attestation')->fetch_all_by_status(1,$start,$perpage);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier='.$pluginid.'&pmod=attes&act=yes', 0, 11, false, false);
		include template($pluginid.':admin_attes');
	}else{
		
		if(is_array($_POST['delete'])) {
			foreach($_POST['delete'] as $id) {
				C::t('#'.$pluginid.'#'.$pluginid.'_attestation')->delete($id);
			}
		}
		cpmsg(lang('plugin/aljlp','admin_13'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=attes&act=yes', 'succeed');
		
	}
}else{

	if(!submitcheck('sh_submit')&&!submitcheck('del_submit')) {
		$currpage=$_GET['page']?$_GET['page']:1;
		$perpage=$config['page'];
		$num=C::t('#'.$pluginid.'#'.$pluginid.'_attestation')->count_by_status(0);
		$start=($currpage-1)*$perpage;
		$atlist=C::t('#'.$pluginid.'#'.$pluginid.'_attestation')->fetch_all_by_status(0,$start,$perpage);
		$paging = helper_page :: multi($num, $perpage, $currpage, 'admin.php?action=plugins&operation=config&identifier='.$pluginid.'&pmod=attes', 0, 11, false, false);	
		
		include template($pluginid.':admin_attes');
		
	}else{
		if(submitcheck('del_submit')){
			if(is_array($_POST['delete'])) {
				foreach($_POST['delete'] as $id) {
					C::t('#'.$pluginid.'#'.$pluginid.'_attestation')->delete($id);
				}
			}
		}
		if(submitcheck('sh_submit')){
			if(is_array($_POST['delete'])) {
				foreach($_POST['delete'] as $id) {
					DB::update($pluginid.'_attestation',array('sign'=>1),'id='.$id);
				}
			}
		}
		
		cpmsg(lang('plugin/aljlp','admin_13'), 'action=plugins&operation=config&identifier='.$pluginid.'&pmod=attes', 'succeed');
	}
}

?>