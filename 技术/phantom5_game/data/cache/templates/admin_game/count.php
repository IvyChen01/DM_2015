<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户数统计</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="./?m=admin" target="_self">管理中心</a> | <a href="./?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="change-pw">
	<h3>用户数统计</h3>
	总用户数：<?php echo $totalUser; ?>&nbsp;&nbsp;总邀请数：<?php echo $totalInvite; ?><br />
	<br />
	<?php foreach ($dayList as $value) { ?>
		[<?php echo $value['date']; ?>]&nbsp;&nbsp;新增用户：<?php echo $value['userNum']; ?>&nbsp;&nbsp;新增邀请：<?php echo $value['inviteNum']; ?><br />
	<?php } ?>
</div>
</body>
</html>
