<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
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
	总抽奖人次: <?php echo $_total_lucky; ?><br />
	总中奖人次: <?php echo $_total_winner; ?><br />
	总中奖比例: <?php echo $_total_lucky_rate; ?>%<br />
	<br />
	<br />
	<br />
	<?php foreach ($_day_list as $_value) { ?>
		日期: <?php echo $_value['date']; ?><br />
		抽奖人次: <?php echo $_value['lucky']; ?><br />
		中奖人次: <?php echo $_value['winner']; ?><br />
		中奖比例: <?php echo $_value['lucky_rate']; ?>%<br />
		<br />
	<?php } ?>
</div>
</body>
</html>
