<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>中奖名单</title>
<link href="style/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="db">
	<h3>中奖名单</h3>
	<?php foreach ($_jiang_list as $_temp_list) { ?>
	日期：<?php echo $_temp_list['date']; ?><br />
	<table align="center" border="1" cellpadding="5" cellspacing="0" bgcolor="#FDF2F2">
		<tr>
			<td bgcolor="#F1EDFE">部门</td>
			<td bgcolor="#F1EDFE">姓名</td>
			<td bgcolor="#F1EDFE">奖品</td>
		</tr>
		<!--表记录-->
		<?php $_temp_isColor = false; ?>
		<?php foreach ($_temp_list['winner'] as $_temp_winner) { ?>
			<tr>
			<?php if ($_temp_isColor) { ?>
				<td bgcolor="#F1EDFE"><?php echo $_temp_winner['department']; ?></td>
				<td bgcolor="#F1EDFE"><?php echo $_temp_winner['username']; ?></td>
				<td bgcolor="#F1EDFE"><?php echo $_temp_winner['prizename']; ?></td>
			<?php } else { ?>
				<td><?php echo $_temp_winner['department']; ?></td>
				<td><?php echo $_temp_winner['username']; ?></td>
				<td><?php echo $_temp_winner['prizename']; ?></td>
			<?php } ?>
			<?php $_temp_isColor = !$_temp_isColor; ?>
			</tr>
		<?php } ?>
	</table>
	<br />
	<?php } ?>
</div>
</body>
</html>
