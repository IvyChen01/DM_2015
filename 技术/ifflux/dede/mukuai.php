<?php
 require(dirname(__FILE__).'/config.php');
require(DEDEADMIN.'/inc/inc_menu.php');
require(DEDEADMIN.'/inc/inc_menu_func.php');
$openitem = (empty($openitem) ? 1 : $openitem);
include DedeInclude('templets/mukuai.htm');
