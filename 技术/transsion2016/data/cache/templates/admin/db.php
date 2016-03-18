<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查看数据库</title>
<link rel="shortcut icon" href="images/favicon.ico"/>
<link href="css/admin.css?v=2016.1.14_17.59" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="db">
	<h3>查看数据库</h3>
	<?php foreach ($_tableList as $_tempList) { ?>
		<!--表名-->
		<p align="center"><?php echo $_tempList['tbname']; ?></p>
		<table align="center" border="1" cellpadding="5" cellspacing="0" bgcolor="#FDF2F2">
		<!--字段名-->
		<tr>
		<?php foreach ($_tempList['fields'] as $_tempField) { ?>
			<td bgcolor="#F0C090"><?php echo $_tempField; ?></td>
		<?php } ?>
		</tr>
		<!--表记录-->
		<?php $_tempIsColor = false; ?>
		<?php foreach ($_tempList['records'] as $_tempRecord) { ?>
			<tr>
			<?php if ($_tempIsColor) { ?>
				<?php foreach ($_tempRecord as $_tempVar) { ?>
					<td bgcolor="#F1EDFE"><?php echo $_tempVar; ?></td>
				<?php } ?>
			<?php } else { ?>
				<?php foreach ($_tempRecord as $_tempVar) { ?>
					<td><?php echo $_tempVar; ?></td>
				<?php } ?>
			<?php } ?>
			<?php $_tempIsColor = !$_tempIsColor; ?>
			</tr>
		<?php } ?>
		</table><br />
	<?php } ?>
</div>
</body>
</html>
