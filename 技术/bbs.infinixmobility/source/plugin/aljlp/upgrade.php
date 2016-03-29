<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$sql ="ALTER TABLE ".DB::table('aljlp')." ADD `state` tinyint(3) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljlp')." ADD `clientip` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljlp')." ADD `jingjiren` int NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljlp` ADD `area` int NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljlp_toplog` CHANGE `id` `id` INT( 10 ) NOT NULL AUTO_INCREMENT " ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljlp` ADD `topstime` int NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljlp` ADD `topetime` int NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljlp` ADD `tid` int NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljlp_reflashlog` ADD `name` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljlp_reflashlog` ADD `title` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');

$sql ="ALTER TABLE `pre_aljlp_toplog` ADD `title` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljlp_toplog` ADD `name` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE `pre_aljlp_toplog` ADD `endtime` int NOT NULL" ;
DB::query($sql,'SILENT');
//finish to put your own code
$sql ="ALTER TABLE `pre_aljlp` ADD `qq` bigint NOT NULL" ;
DB::query($sql,'SILENT');

$sql ="ALTER TABLE `pre_aljlp` ADD `lxr` varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');

$sql ="ALTER TABLE `pre_aljlp` ADD `tuijian` int NOT NULL" ;
DB::query($sql,'SILENT');

$sql ="ALTER TABLE `pre_aljlp` ADD `displayorder` int NOT NULL" ;
DB::query($sql,'SILENT');
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_aljlp_comment` (
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
);
CREATE TABLE IF NOT EXISTS `pre_aljlp_attestation` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `gongsiname` varchar(255) NOT NULL,
  `mendianname` varchar(255) NOT NULL,
  `num` bigint(20) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `sign` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
)
EOF;
runquery($sql);
$sql ="ALTER TABLE ".DB::table('aljlp')." ADD `qrcode` VARCHAR( 255 ) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljlp')." ADD `phone` VARCHAR( 255 ) NOT NULL" ;
DB::query($sql,'SILENT');
if(file_exists( DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php')&&file_exists( DISCUZ_ROOT . './source/plugin/aljlp/template/touch/aljlp_index.htm')){
	$pluginid = 'aljlp';
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