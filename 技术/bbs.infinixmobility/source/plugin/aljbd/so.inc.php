<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Deined');
}

if(file_exists('source/plugin/aljbd/com/so.php')){
	include 'source/plugin/aljbd/com/so.php';
}else{
	showmessage(lang('plugin/aljbd','map'));
}
?>