<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sql ="ALTER TABLE ".DB::table('aljes')." ADD `state` tinyint(3) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add state succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljes')." ADD `clientip` varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add clientip succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljes')." ADD `phone` varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add phone succeed!<br>');}

$sql ="ALTER TABLE ".DB::table('aljes')." ADD `qrcode` varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add qrcode succeed!<br>');}

$sql ="ALTER TABLE ".DB::table('aljes')." ADD `qq` bigint NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add qq succeed!<br>');}

$sql ="ALTER TABLE ".DB::table('aljes')." ADD `new` varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add new succeed!<br>');}

$sql ="ALTER TABLE ".DB::table('aljes')." ADD `lxr` varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add lxr succeed!<br>');}

$sql ="ALTER TABLE ".DB::table('aljes')." ADD `tuijian` int NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add tuijian succeed!<br>');}

$sql ="ALTER TABLE ".DB::table('aljes')." ADD `displayorder` int NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add displayorder succeed!<br>');}
//
$sql ="ALTER TABLE ".DB::table('aljes')." ADD `topstime` int NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add topstime succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljes')." ADD `topetime` int NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add topetime succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljes')." ADD `tid` int NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add tid succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljes_reflashlog')." ADD `name` varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add name succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljes_reflashlog')." ADD `title` varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add title succeed!<br>');}

$sql ="ALTER TABLE ".DB::table('aljes_toplog')." ADD `title` varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add title succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljes_toplog')." ADD `name` varchar(255) NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add name succeed!<br>');}
$sql ="ALTER TABLE ".DB::table('aljes_toplog')." ADD `endtime` int NOT NULL" ;
if(DB::query($sql,'SILENT')){print('add endtime succeed!<br>');}

$sql ="ALTER TABLE ".DB::table('aljes_toplog')." CHANGE `id` `id` INT( 10 ) NOT NULL AUTO_INCREMENT " ;
if(DB::query($sql,'SILENT')){print('add CHANGE succeed!<br>');}
if(file_exists( DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php')&&file_exists( DISCUZ_ROOT . './source/plugin/aljes/template/touch/index.htm')){
	$pluginid = 'aljes';
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