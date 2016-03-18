﻿<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>抽奖数据统计</title>
<link href="style/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="change-pw">
	<h3>抽奖数据统计</h3>
	<?php
		echo '总抽奖人次: ' . $_total_lucky . '<br />';
		echo '总中奖人次: ' . $_total_winner . '<br />';
		echo '总中奖比例: ' . $_total_lucky_rate . '%<br />';
		echo '<br />';
		echo '<br />';
		echo '<br />';
		
		foreach ($_day_list as $_value)
		{
			echo '日期: ' . $_value['date'] . '<br />';
			echo '抽奖人次: ' . $_value['lucky'] . '<br />';
			echo '中奖人次: ' . $_value['winner'] . '<br />';
			echo '中奖比例: ' . $_value['lucky_rate'] . '%<br />';
			echo '<br />';
		}
	?>
</div>
</body>
</html>
