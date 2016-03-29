<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//start to put your own code 
$sql = <<<EOF
DROP TABLE IF  EXISTS `pre_aljlp`;
DROP TABLE IF  EXISTS `pre_aljlp_log`;
DROP TABLE IF  EXISTS `pre_aljlp_reflashlog`;
DROP TABLE IF  EXISTS `pre_aljlp_region`;
DROP TABLE IF  EXISTS `pre_aljlp_toplog`;
DROP TABLE IF  EXISTS `pre_aljlp_user`;
DROP TABLE IF  EXISTS `pre_aljlp_comment`;
DROP TABLE IF  EXISTS `pre_aljlp_attestation`;
EOF;

runquery($sql);
//finish to put your own code
$finish = TRUE;
?>