<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//start to put your own code 
$sql = <<<EOF
CREATE TABLE `pre_aljlp` (
  `id` int(10) NOT NULL auto_increment,
  `uid` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `addtime` int(10) NOT NULL,
  `updatetime` int(10) NOT NULL,
  `wanted` tinyint(3) NOT NULL,
  `title` varchar(255) NOT NULL,
  `zufangtype` tinyint(3) NOT NULL,
  `fangxing` varchar(255) NOT NULL,
  `louceng` varchar(255) NOT NULL,
  `zujin` int(10) NOT NULL,
  `content` mediumtext NOT NULL,
  `pic1` varchar(255) NOT NULL,
  `pic2` varchar(255) NOT NULL,
  `pic3` varchar(255) NOT NULL,
  `pic4` varchar(255) NOT NULL,
  `pic5` varchar(255) NOT NULL,
  `pic6` varchar(255) NOT NULL,
  `pic7` varchar(255) NOT NULL,
  `pic8` varchar(255) NOT NULL,
  `xiaoqu` varchar(255) NOT NULL,
  `region` int(11) NOT NULL,
  `region1` int(10) NOT NULL,
  `region2` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `chaoxiang` varchar(255) NOT NULL,
  `zhuangxiu` varchar(255) NOT NULL,
  `peizhi` varchar(255) NOT NULL,
  `pay` varchar(255) NOT NULL,
  `zuqi` varchar(255) NOT NULL,
  `views` mediumint(9) NOT NULL,
  `qq` bigint(20) NOT NULL,
  `lxr` varchar(255) NOT NULL,
  `tuijian` int(11) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `topstime` int(11) NOT NULL,
  `topetime` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `jingjiren` int(11) NOT NULL,
  `qrcode` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `clientip` varchar(255) NOT NULL,
  `state` tinyint(3) NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE `pre_aljlp_log` (
  `day` int(11) NOT NULL,
  `views` mediumint(9) NOT NULL,
  PRIMARY KEY  (`day`)
);
CREATE TABLE `pre_aljlp_reflashlog` (
  `id` int(11) NOT NULL auto_increment,
  `lid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `dateline` int(10) NOT NULL,
  `pay` int(10) NOT NULL,
  `extcredit` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE `pre_aljlp_region` (
  `id` mediumint(9) unsigned NOT NULL auto_increment,
  `upid` mediumint(9) unsigned NOT NULL,
  `subid` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `displayorder` mediumint(9) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE `pre_aljlp_toplog` (
  `id` int(10) NOT NULL auto_increment,
  `lid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `dateline` int(10) NOT NULL,
  `pay` int(10) NOT NULL,
  `extcredit` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `endtime` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
);
CREATE TABLE `pre_aljlp_user` (
  `uid` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `dateline` int(10) NOT NULL,
  `count` int(10) NOT NULL default '0',
  `updatecount` int(10) NOT NULL default '0',
  `top` int(10) NOT NULL default '0',
  `last` int(10) NOT NULL,
  PRIMARY KEY  (`uid`)
);
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
//finish to put your own code
$finish = TRUE;
?>