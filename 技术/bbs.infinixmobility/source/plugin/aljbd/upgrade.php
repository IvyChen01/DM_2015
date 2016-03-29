<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `business_hours`  varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `bus_routes`  varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_region')." ADD `displayorder`  int(10) NOT NULL" ;
DB::query($sql,'SILENT');
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_aljbd_type_goods` (
  `id` mediumint(9) unsigned NOT NULL auto_increment,
  `upid` mediumint(9) unsigned NOT NULL,
  `subid` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `displayorder` mediumint(9) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_username` (
  `id` int(10) NOT NULL auto_increment,
  `uid` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `bid` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
);
 CREATE TABLE IF NOT EXISTS `pre_aljbd_goods` (
  `id` int(10) NOT NULL auto_increment,
  `bid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price1` varchar(255) NOT NULL,
  `price2` varchar(255) NOT NULL,
  `view` int(10) NOT NULL,
  `pic1` varchar(255) NOT NULL,
  `pic2` varchar(255) NOT NULL,
  `pic3` varchar(255) NOT NULL,
  `pic4` varchar(255) NOT NULL,
  `pic5` varchar(255) NOT NULL,
  `intro` longtext NOT NULL,
  `dateline` int(10) NOT NULL,
  `gwurl` varchar(255) NOT NULL,
  `subtype` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `sign` int(11) NOT NULL,
  `amount` int(10) NOT NULL,
  `buyamount` int(10) NOT NULL,
  `endtime` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_syscache` (
  `id` int(11) NOT NULL auto_increment,
  `plugin_b` varchar(255) NOT NULL,
  `plugin_w` mediumtext NOT NULL,
  `plugin_sign` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_comment_notice` (
  `id` int(11) NOT NULL auto_increment,
  `upid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `bid` int(11) NOT NULL,
  `nid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_notice` (
  `id` int(11) NOT NULL auto_increment,
  `bid` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `dateline` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `view` int(11) NOT NULL,
  `sign` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `subtype` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_album` (
  `id` int(11) NOT NULL auto_increment,
  `bid` int(11) NOT NULL,
  `albumname` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `dateline` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `view` int(11) NOT NULL,
  `sign` int(11) NOT NULL,
  `picnum` int(11) NOT NULL,
  `lastpost` int(11) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `subjectimage` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_album_attachments` (
  `id` int(11) NOT NULL auto_increment,
  `bid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `alt` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_comment_consume` (
  `id` int(11) NOT NULL auto_increment,
  `upid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `bid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_consume` (
  `id` int(11) NOT NULL auto_increment,
  `bid` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `jieshao` MEDIUMTEXT NOT NULL,
  `xianzhi` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `mianze` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `view` int(11) NOT NULL,
  `downnum` int(11) NOT NULL,
  `sign` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `subtype` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_attestation` (
  `bid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_card` bigint(20) NOT NULL,
  `id_pic` varchar(255) NOT NULL,
  `qiyename` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `sign` tinyint(4) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `jieshao` mediumtext NOT NULL,
  `ban_pic` varchar(255) NOT NULL,
  `id_pic1` varchar(255) NOT NULL,
  PRIMARY KEY  (`bid`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_usergroup` (
  `groupid` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `good` int(11) NOT NULL,
  `notice` int(11) NOT NULL,
  `album` int(11) NOT NULL,
  `consume` int(11) NOT NULL,
  `grouptitle` varchar(255) NOT NULL,
  PRIMARY KEY  (`groupid`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_type_consume` (
  `id` mediumint(9) unsigned NOT NULL auto_increment,
  `upid` mediumint(9) unsigned NOT NULL,
  `subid` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `displayorder` mediumint(9) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_type_notice` (
  `id` mediumint(9) unsigned NOT NULL auto_increment,
  `upid` mediumint(9) unsigned NOT NULL,
  `subid` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `displayorder` mediumint(9) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_order` (
  `orderid` char(32) NOT NULL DEFAULT '',
  `status` char(3) NOT NULL DEFAULT '',
  `buyer` char(50) NOT NULL DEFAULT '',
  `admin` char(15) NOT NULL DEFAULT '',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL,
  `sid` int(11) NOT NULL,
  `stitle` varchar(255) NOT NULL,
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `price` float(7,2) unsigned NOT NULL DEFAULT '0.00',
  `submitdate` int(10) unsigned NOT NULL DEFAULT '0',
  `confirmdate` int(10) unsigned NOT NULL DEFAULT '0',
  `email` char(40) NOT NULL DEFAULT '',
  `ip` char(15) NOT NULL DEFAULT '',
  UNIQUE KEY `orderid` (`orderid`),
  KEY `submitdate` (`submitdate`),
  KEY `uid` (`uid`,`submitdate`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_setting` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `a` varchar(255) NOT NULL,
  `b` varchar(255) NOT NULL,
  `c` text NOT NULL,
  `d` int(11) NOT NULL,
  `e` int(11) NOT NULL,
  PRIMARY KEY (`key`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_settle` (
  `settleid` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL,
  `settleprice` varchar(255) NOT NULL,
  `payment` tinyint(3) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `applytime` int(11) NOT NULL,
  `dateline` int(11) NOT NULL,
  `uid` int(10) NOT NULL,
  PRIMARY KEY (`settleid`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_user` (
  `uid` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `bid` int(10) NOT NULL,
  `qq` int(10) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `addr` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`)
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_wuliu` (
  `orderid` varchar(255) NOT NULL,
  `type` int(10) NOT NULL,
  `companyname` varchar(255) NOT NULL,
  `worderid` varchar(255) NOT NULL,
  `dateline` int(10) NOT NULL,
  `updatetime` int(10) NOT NULL,
  `a` int(10) NOT NULL,
  `b` int(10) NOT NULL,
  `c` varchar(255) NOT NULL,
  `d` varchar(255) NOT NULL,
  `e` varchar(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS `pre_aljbd_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `dateline` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `view` int(11) NOT NULL,
  `sign` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `subtype` int(11) NOT NULL,
  `displayorder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);
EOF;
runquery($sql);
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `businesstype`  varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `amount` INT NOT NULL ;" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `buyamount` INT NOT NULL ;" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `endtime` INT NOT NULL ;" ;
DB::query($sql,'SILENT');

$sql ="ALTER TABLE ".DB::table('aljbd_consume')." ADD `sign` INT NOT NULL ;" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_notice')." ADD `subtype` INT NOT NULL ;" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_notice')." ADD `type` INT NOT NULL ;" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_consume')." ADD `subtype` INT NOT NULL ;" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_consume')." ADD `type` INT NOT NULL ;" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_consume')." CHANGE `jieshao` `jieshao` MEDIUMTEXT  NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `region1`  varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `qrcode`  varchar(255) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_attestation')." CHANGE `tel` `tel` VARCHAR( 255 ) NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `subtype` INT NOT NULL ;" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `type` INT NOT NULL ;" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `sign` INT NOT NULL ;" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `wurl` varchar(255) NOT NULL ;" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd_goods')." ADD `gwurl` varchar(255) NOT NULL ;" ;
DB::query($sql,'SILENT');
//finish to put your own code
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `qq`  BIGINT NOT NULL" ;
DB::query($sql,'SILENT');
$sql ="ALTER TABLE ".DB::table('aljbd')." ADD `displayorder` INT NOT NULL" ;
DB::query($sql,'SILENT');

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
$finish = TRUE;
?>