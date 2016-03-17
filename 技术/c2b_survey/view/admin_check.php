<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<div class="container">
	<?php
	echo '<table align="center" border="1" cellpadding="5" cellspacing="0" bgcolor="#FDF2F2">';
	//字段名
	echo '<tr>';
	foreach ($_fields as $_field_name)
	{
		echo '<td bgcolor="#F0C090">' . $_field_name . '</td>';
	}
	echo '</tr>';
	//表记录
	$_temp_isColor = false;
	foreach ($_data as $_temp_row)
	{
		echo '<tr>';
		if ($_temp_isColor)
		{
			foreach ($_temp_row as $_temp_var)
			{
				echo '<td bgcolor="#F1EDFE">' . $_temp_var . '</td>';
			}
		}
		else
		{
			foreach ($_temp_row as $_temp_var)
			{
				echo '<td>' . $_temp_var . '</td>';
			}
		}
		$_temp_isColor = !$_temp_isColor;
		echo '</tr>';
	}
	echo '</table><br />';
	echo 'count: ' . $_count . '<br />';
	?>
</div>
</body>
</html>
