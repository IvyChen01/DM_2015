<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>抽奖数据统计</title>
<link href="css/admin.css?v=2015.11.18_17.48" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="./?m=admin" target="_self">管理中心</a> | <a href="./?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="change-pw">
	<h3>抽奖数据统计</h3>
	总抽奖人次: <?php echo $totalPlay; ?><br />
	总中奖人次: <?php echo $totalWinner; ?><br />
	总登录人数: <?php echo $totalUser; ?><br />
	<br />
	<br />
	<br />
	<?php foreach ($dayList as $value) { ?>
		日期: <?php echo $value['date']; ?><br />
		抽奖人次: <?php echo $value['playNum']; ?><br />
		中奖人次: <?php echo $value['winner']; ?><br />
		新增登录人数: <?php echo $value['userNum']; ?><br />
		<br />
	<?php } ?>
</div>
</body>
</html>
