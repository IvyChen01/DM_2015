<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>抽奖数据统计</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="./?m=admin" target="_self">管理中心</a> | <a href="./?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="change-pw">
	<h3>抽奖数据统计</h3>
	总抽奖人次：<?php echo $totalLucky; ?>&nbsp;&nbsp;总中奖人次：<?php echo $totalWinner; ?>&nbsp;&nbsp;总中奖比例：<?php echo $totalLuckyRate; ?>%<br />
	<br />
	<?php foreach ($dayList as $value) { ?>
		[<?php echo $value['date']; ?>]&nbsp;&nbsp;抽奖人次：<?php echo $value['lucky']; ?>&nbsp;&nbsp;中奖人次：<?php echo $value['winner']; ?>&nbsp;&nbsp;中奖比例：<?php echo $value['luckyRate']; ?>%<br />
	<?php } ?>
</div>
</body>
</html>
