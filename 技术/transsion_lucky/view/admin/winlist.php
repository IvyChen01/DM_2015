<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
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
		<?php
		//表记录
		$_temp_isColor = false;
		foreach ($_temp_list['winner'] as $_temp_winner)
		{
			echo '<tr>';
			if ($_temp_isColor)
			{
				echo '<td bgcolor="#F1EDFE">' . $_temp_winner['department'] . '</td>';
				echo '<td bgcolor="#F1EDFE">' . $_temp_winner['username'] . '</td>';
				echo '<td bgcolor="#F1EDFE">' . $_temp_winner['prizename'] . '</td>';
			}
			else
			{
				echo '<td>' . $_temp_winner['department'] . '</td>';
				echo '<td>' . $_temp_winner['username'] . '</td>';
				echo '<td>' . $_temp_winner['prizename'] . '</td>';
			}
			$_temp_isColor = !$_temp_isColor;
			echo '</tr>';
		}
		?>
	</table>
	<br />
	<?php } ?>
</div>
</body>
</html>
