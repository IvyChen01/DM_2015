<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查看数据库</title>
<link rel="shortcut icon" href="/images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="db">
	<h3>查看数据库</h3>
	<?php
	foreach ($_tableList as $_tempList)
	{
		//表名
		echo '<p align="center">' . $_tempList['tbname'] . '</p>';
		echo '<table align="center" border="1" cellpadding="5" cellspacing="0" bgcolor="#FDF2F2">';
		//字段名
		echo '<tr>';
		foreach ($_tempList['fields'] as $_tempField)
		{
			echo '<td bgcolor="#F0C090">' . $_tempField . '</td>';
		}
		echo '</tr>';
		//表记录
		$_tempIsColor = false;
		foreach ($_tempList['records'] as $_tempRecord)
		{
			echo '<tr>';
			if ($_tempIsColor)
			{
				foreach ($_tempRecord as $_tempVar)
				{
					echo '<td bgcolor="#F1EDFE">' . $_tempVar . '</td>';
				}
			}
			else
			{
				foreach ($_tempRecord as $_tempVar)
				{
					echo '<td>' . $_tempVar . '</td>';
				}
			}
			$_tempIsColor = !$_tempIsColor;
			echo '</tr>';
		}
		echo '</table><br />';
	}
	?>
</div>
</body>
</html>
