<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>中奖名单</title>
<link href="css/admin.css?v=2015.11.18_17.48" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="./?m=admin" target="_self">管理中心</a> | <a href="./?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="db">
	<h3>中奖名单</h3>
	<?php foreach ($winner as $arr1) { ?>
	日期：<?php echo $arr1['date']; ?><br />
	<table align="center" border="1" cellpadding="5" cellspacing="0" bgcolor="#FDF2F2">
		<tr>
			<td bgcolor="#F1EDFE">序号</td>
			<td bgcolor="#F1EDFE">部门</td>
			<td bgcolor="#F1EDFE">姓名</td>
			<td bgcolor="#F1EDFE">工号</td>
			<td bgcolor="#F1EDFE">工作地</td>
			<td bgcolor="#F1EDFE">奖品</td>
		</tr>
		<!--表记录-->
		<?php $isColor = false; ?>
		<?php $index = 1; ?>
		<?php foreach ($arr1['list'] as $arr2) { ?>
			<tr>
			<?php if ($isColor) { ?>
				<td bgcolor="#F1EDFE"><?php echo $index; ?></td>
				<td bgcolor="#F1EDFE"><?php echo $arr2['dept']; ?></td>
				<td bgcolor="#F1EDFE"><?php echo $arr2['username']; ?></td>
				<td bgcolor="#F1EDFE"><?php echo $arr2['jobnum']; ?></td>
				<td bgcolor="#F1EDFE"><?php echo $arr2['address']; ?></td>
				<td bgcolor="#F1EDFE"><?php echo $arr2['prize']; ?></td>
			<?php } else { ?>
				<td><?php echo $index; ?></td>
				<td><?php echo $arr2['dept']; ?></td>
				<td><?php echo $arr2['username']; ?></td>
				<td><?php echo $arr2['jobnum']; ?></td>
				<td><?php echo $arr2['address']; ?></td>
				<td><?php echo $arr2['prize']; ?></td>
			<?php } ?>
			<?php $isColor = !$isColor; ?>
			<?php $index++; ?>
			</tr>
		<?php } ?>
	</table>
	<br />
	<?php } ?>
</div>
</body>
</html>
