<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查看用户数据</title>
</head>
<body>
<div>
	<div align="right"><a href="?m=admin&a=show_admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></div>
	<h3 align="center">查看用户数据</h3>
	<?php
	foreach ($_['table_list'] as $_['temp_list'])
	{
		//表名
		echo '<p align="center">' . $_['temp_list']['tbname'] . '</p>';
		echo '<table align="center" border="1" cellpadding="5" cellspacing="0" bgcolor="#FDF2F2">';
		//字段名
		echo '<tr>';
		echo '<td bgcolor="#F0C090">photo</td>';
		foreach ($_['temp_list']['fields'] as $_['temp_field'])
		{
			echo '<td bgcolor="#F0C090">' . $_['temp_field'] . '</td>';
		}
		echo '</tr>';
		//表记录
		$_['temp_isColor'] = false;
		foreach ($_['temp_list']['records'] as $_['temp_record'])
		{
			echo '<tr>';
			echo '<td bgcolor="#F1EDFE"><img src="https://graph.facebook.com/' . $_['temp_record'][1] . '/picture"></td>';
			if ($_['temp_isColor'])
			{
				foreach ($_['temp_record'] as $_['temp_var'])
				{
					echo '<td bgcolor="#F1EDFE">' . $_['temp_var'] . '</td>';
				}
			}
			else
			{
				foreach ($_['temp_record'] as $_['temp_var'])
				{
					echo '<td>' . $_['temp_var'] . '</td>';
				}
			}
			$_['temp_isColor'] = !$_['temp_isColor'];
			echo '</tr>';
		}
		echo '</table><br />';
	}
	?>
</div>
</body>
</html>
