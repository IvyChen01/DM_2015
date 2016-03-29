<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$sql ="ALTER TABLE ".DB::table('aljes')." ADD `state` tinyint(3) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljes')." ADD `clientip` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljes')." ADD `phone` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');

$sql ="ALTER TABLE `pre_aljes` ADD `qrcode` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');

$sql ="ALTER TABLE `pre_aljes_toplog` CHANGE `id` `id` INT( 10 ) NOT NULL AUTO_INCREMENT " ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljes` ADD `topstime` int NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljes` ADD `topetime` int NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljes` ADD `tid` int NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljes_reflashlog` ADD `name` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljes_reflashlog` ADD `title` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');

$sql ="ALTER TABLE `pre_aljes_toplog` ADD `title` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljes_toplog` ADD `name` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljes_toplog` ADD `endtime` int NOT NULL" ;
DB::query($sql,'SILENT');
//finish to put your own code
$sql ="ALTER TABLE `pre_aljes` ADD `qq` bigint NOT NULL" ;
DB::query($sql,'SILENT');

$sql ="ALTER TABLE `pre_aljes` ADD `new` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');

$sql ="ALTER TABLE `pre_aljes` ADD `lxr` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');

$sql ="ALTER TABLE `pre_aljes` ADD `tuijian` int NOT NULL" ;
DB::query($sql,'SILENT');

$sql ="ALTER TABLE `pre_aljes` ADD `displayorder` int NOT NULL" ;
DB::query($sql,'SILENT');


$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_aljes_comment` (
  `id` int(11) NOT NULL auto_increment,
  `upid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `lid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `upid` (`upid`),
  KEY `dateline` (`dateline`),
  KEY `lid` (`lid`)
) 
EOF;
runquery($sql);
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
$finish = TRUE;
?>