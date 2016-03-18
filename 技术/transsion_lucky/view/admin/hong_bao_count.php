<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>抢红包数据统计</title>
<link href="style/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="change-pw">
	<h3>抢红包数据统计</h3>
	<?php
		echo '总抢红包人次: ' . $_total_lucky . '<br />';
		echo '<br />';
		foreach ($_day_list as $_value)
		{
			echo '[' . $_value['date'] . '] 抢红包人次: ' . $_value['lucky'] . '<br />';
		}
	?>
</div>
</body>
</html>
