<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `business_hours`  varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add business_hours succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `bus_routes`  varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add bus_routes succeed!<br>');}

$sql ="ALTER TABLE ".DB::table('aljbd_region')." ADD `displayorder`  int(10) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add displayorder succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `businesstype`  varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add businesstype succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_consume')." ADD `draw`  varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add draw succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `amount` INT NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add amount succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `buyamount` INT NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add buyamount succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `endtime` INT NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add endtime succeed!<br>');}

$sql ="ALTER TABLE ".DB::table('aljbd_consume')." ADD `sign` INT NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add sign succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_notice')." ADD `subtype` INT NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add subtype succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_notice')." ADD `type` INT NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add type succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_consume')." ADD `subtype` INT NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add subtype succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_consume')." ADD `type` INT NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add type succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_consume')." CHANGE `jieshao` `jieshao` MEDIUMTEXT  NOT NULL" ;
if(DB::query($sql,'SILENT')){print(' CHANGE jieshao succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `region1`  varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add region1 succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `qrcode`  varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add qrcode succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_attestation')." CHANGE `tel` `tel` VARCHAR( 255 ) NOT NULL" ;
if(DB::query($sql,'SILENT')){print(' CHANGE tel succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `subtype` INT NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add subtype succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `type` INT NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add type succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `sign` INT NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add sign succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `wurl` varchar(255) NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add wurl succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `gwurl` varchar(255) NOT NULL ;" ;
if(DB::query($sql,'SILENT')){print('add gwurl succeed!<br>');}
//finish to put your own code
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `qq`  BIGINT NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add qq succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `displayorder` INT NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add displayorder succeed!<br>');}

if(file_exists( DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php')&&file_exists( DISCUZ_ROOT . './source/plugin/aljbd/template/touch/list.htm')){
	$pluginid = 'aljbd';
	$Hooks = array(
		'forumdisplay_topBar',
	);
	$data = array();
	foreach ($Hooks as $Hook) {
		$data[] = array($Hook => array('plugin' => $pluginid, 'include' => 'api.class.php', 'class' => $pluginid . '_api', 'method' => $Hook));
	}
	require_once DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php';
	WeChatHook::updateAPIHook($data);
}
echo '<br/>repair succeed';
?>