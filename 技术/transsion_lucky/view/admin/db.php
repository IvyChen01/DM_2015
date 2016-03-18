﻿<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查看数据库</title>
<link href="style/admin.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="db">
	<h3>查看数据库</h3>
	<?php
	foreach ($_table_list as $_temp_list)
	{
		//表名
		echo '<p align="center">' . $_temp_list['tbname'] . '</p>';
		echo '<table align="center" border="1" cellpadding="5" cellspacing="0" bgcolor="#FDF2F2">';
		//字段名
		echo '<tr>';
		foreach ($_temp_list['fields'] as $_temp_field)
		{
			echo '<td bgcolor="#F0C090">' . $_temp_field . '</td>';
		}
		echo '</tr>';
		//表记录
		$_temp_isColor = false;
		foreach ($_temp_list['records'] as $_temp_record)
		{
			echo '<tr>';
			if ($_temp_isColor)
			{
				foreach ($_temp_record as $_temp_var)
				{
					echo '<td bgcolor="#F1EDFE">' . $_temp_var . '</td>';
				}
			}
			else
			{
				foreach ($_temp_record as $_temp_var)
				{
					echo '<td>' . $_temp_var . '</td>';
				}
			}
			$_temp_isColor = !$_temp_isColor;
			echo '</tr>';
		}
		echo '</table><br />';
	}
	?>
</div>
</body>
</html>
