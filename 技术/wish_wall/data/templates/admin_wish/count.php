<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>许愿墙数据统计</title>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="change-pw">
	<h3>许愿墙数据统计</h3>
	总用户数：<?php echo $totalUser; ?>&nbsp;&nbsp;总愿望数：<?php echo $totalWish; ?><br />
	<br/>
	<?php foreach ($dayList as $value) { ?>
		[<?php echo $value['date']; ?>]&nbsp;&nbsp;用户数：<?php echo $value['userCount']; ?>&nbsp;&nbsp;愿望数：<?php echo $value['wishCount']; ?><br />
	<?php } ?>
</div>
</body>
</html>
