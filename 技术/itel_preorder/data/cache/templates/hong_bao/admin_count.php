<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>抢红包数据统计</title>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="change-pw">
	<h3>抢红包数据统计</h3>
	总抢红包人次: <?php echo $_totalLucky; ?><br />
	<br />
	<?php foreach ($_dayList as $_value) { ?>
	[<?php echo $_value['date']; ?>] 抢红包人次: <?php echo $_value['num']; ?><br />
	<?php } ?>
</div>
</body>
</html>
