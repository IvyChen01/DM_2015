<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//start to put your own code 
$sql = <<<EOF
DROP TABLE IF  EXISTS `pre_aljes`;
DROP TABLE IF  EXISTS `pre_aljes_log`;
DROP TABLE IF  EXISTS `pre_aljes_reflashlog`;
DROP TABLE IF  EXISTS `pre_aljes_region`;
DROP TABLE IF  EXISTS `pre_aljes_toplog`;
DROP TABLE IF  EXISTS `pre_aljes_user`;
DROP TABLE IF  EXISTS `pre_aljes_comment`;
EOF;

runquery($sql);
//finish to put your own code
$finish = TRUE;
?>