<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>中奖名单</title>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="db">
	<h3>中奖名单</h3>
	<table align="center" border="1" cellpadding="5" cellspacing="0" bgcolor="#FDF2F2">
		<tr>
			<td bgcolor="#F0C090">序号</td>
			<td bgcolor="#F0C090">奖品</td>
			<td bgcolor="#F0C090">兑奖码</td>
			<td bgcolor="#F0C090">中奖时间</td>
		</tr>
		<?php
		//表记录
		$_noIndex = 1;
		$_tempIsColor = false;
		foreach ($_zhongJiang as $_tempWinner)
		{
			echo '<tr>';
			if ($_tempIsColor)
			{
				echo '<td bgcolor="#F1EDFE">' . $_noIndex . '</td>';
				echo '<td bgcolor="#F1EDFE">' . $_tempWinner['prizename'] . '</td>';
				echo '<td bgcolor="#F1EDFE">' . $_tempWinner['lucky_code'] . '</td>';
				echo '<td bgcolor="#F1EDFE">' . $_tempWinner['lucky_time'] . '</td>';
			}
			else
			{
				echo '<td>' . $_noIndex . '</td>';
				echo '<td>' . $_tempWinner['prizename'] . '</td>';
				echo '<td>' . $_tempWinner['lucky_code'] . '</td>';
				echo '<td>' . $_tempWinner['lucky_time'] . '</td>';
			}
			$_tempIsColor = !$_tempIsColor;
			echo '</tr>';
			$_noIndex++;
		}
		?>
	</table>
</div>
</body>
</html>
