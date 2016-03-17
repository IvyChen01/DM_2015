<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>中奖名单</title>
</head>
<body>
<div class="container">
	<div align="right"><a href="?m=admin&a=show_admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></div>
	<h3 align="center">中奖名单</h3>
	<?php
	echo '<table align="center" border="1" cellpadding="5" cellspacing="0" bgcolor="#FDF2F2">';
	?>
	<tr>
		<td bgcolor="#F0C090">id</td>
		<td bgcolor="#F0C090">photo</td>
		<td bgcolor="#F0C090">fbid</td>
		<td bgcolor="#F0C090">name</td>
		<td bgcolor="#F0C090">email</td>
		<td bgcolor="#F0C090">gender</td>
		<td bgcolor="#F0C090">locale</td>
		<td bgcolor="#F0C090">type</td>
		<td bgcolor="#F0C090">lucky_code</td>
	</tr>
	<?php
	//表记录
	$_temp_isColor = false;
	$_index = 1;
	foreach ($_data as $_temp_row)
	{
		echo '<tr>';
		if ($_temp_isColor)
		{
			echo '<td bgcolor="#F1EDFE">' . $_index . '</td>';
			echo '<td bgcolor="#F1EDFE"><img src="https://graph.facebook.com/' . $_temp_row['fbid'] . '/picture"></td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['fbid'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['username'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['email'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['gender'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['locale'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['type'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['lucky_code'] . '</td>';
		}
		else
		{
			echo '<td>' . $_index . '</td>';
			echo '<td><img src="https://graph.facebook.com/' . $_temp_row['fbid'] . '/picture"></td>';
			echo '<td>' . $_temp_row['fbid'] . '</td>';
			echo '<td>' . $_temp_row['username'] . '</td>';
			echo '<td>' . $_temp_row['email'] . '</td>';
			echo '<td>' . $_temp_row['gender'] . '</td>';
			echo '<td>' . $_temp_row['locale'] . '</td>';
			echo '<td>' . $_temp_row['type'] . '</td>';
			echo '<td>' . $_temp_row['lucky_code'] . '</td>';
		}
		$_temp_isColor = !$_temp_isColor;
		echo '</tr>';
		$_index++;
	}
	echo '</table><br />';
	?>
</div>
</body>
</html>
