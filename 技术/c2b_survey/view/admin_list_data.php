<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>答题列表</title>
</head>
<body>
<div class="container">
	<div align="right"><a href="?m=admin&a=show_admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></div>
	<h3 align="center">答题列表</h3>
	<?php
	echo '<table align="center" border="1" cellpadding="5" cellspacing="0" bgcolor="#FDF2F2">';
	?>
	<tr>
		<td bgcolor="#F0C090">photo</td>
		<td bgcolor="#F0C090">fbid</td>
		<td bgcolor="#F0C090">name</td>
		<td bgcolor="#F0C090">email</td>
		<td bgcolor="#F0C090">gender</td>
		<td bgcolor="#F0C090">locale</td>
		<td bgcolor="#F0C090">Q1</td>
		<td bgcolor="#F0C090">Q2</td>
		<td bgcolor="#F0C090">Q3</td>
		<td bgcolor="#F0C090">Q3_fill</td>
		<td bgcolor="#F0C090">Q4</td>
		<td bgcolor="#F0C090">Q4_fill</td>
		<td bgcolor="#F0C090">Q5</td>
		<td bgcolor="#F0C090">Q5_fill</td>
		<td bgcolor="#F0C090">Q6</td>
		<td bgcolor="#F0C090">Q6_fill</td>
		<td bgcolor="#F0C090">Q7</td>
		<td bgcolor="#F0C090">Q7_fill</td>
		<td bgcolor="#F0C090">Q8</td>
		<td bgcolor="#F0C090">Q8_fill</td>
		<td bgcolor="#F0C090">Q9</td>
		<td bgcolor="#F0C090">Q10</td>
		<td bgcolor="#F0C090">Q10_fill</td>
		<td bgcolor="#F0C090">Q11</td>
		<td bgcolor="#F0C090">Q11_fill</td>
		<td bgcolor="#F0C090">Q12</td>
		<td bgcolor="#F0C090">Q12_fill</td>
		<td bgcolor="#F0C090">Q13</td>
		<td bgcolor="#F0C090">Q14</td>
		<td bgcolor="#F0C090">Q15</td>
		<td bgcolor="#F0C090">Q16</td>
		<td bgcolor="#F0C090">lucky_code</td>
		<td bgcolor="#F0C090">time</td>
	</tr>
	<?php
	//表记录
	$_temp_isColor = false;
	foreach ($_all_answer as $_temp_row)
	{
		echo '<tr>';
		if ($_temp_isColor)
		{
			echo '<td bgcolor="#F1EDFE"><img src="https://graph.facebook.com/' . $_temp_row['fbid'] . '/picture"></td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['fbid'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['username'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['email'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['gender'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['locale'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question1'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question2'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question3'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question3_fill'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question4'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question4_fill'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question5'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question5_fill'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question6'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question6_fill'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question7'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question7_fill'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question8'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question8_fill'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question9'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question10'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question10_fill'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question11'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question11_fill'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question12'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question12_fill'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question13'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question14'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question15'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['question16'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['lucky_code'] . '</td>';
			echo '<td bgcolor="#F1EDFE">' . $_temp_row['do_time'] . '</td>';
		}
		else
		{
			echo '<td><img src="https://graph.facebook.com/' . $_temp_row['fbid'] . '/picture"></td>';
			echo '<td>' . $_temp_row['fbid'] . '</td>';
			echo '<td>' . $_temp_row['username'] . '</td>';
			echo '<td>' . $_temp_row['email'] . '</td>';
			echo '<td>' . $_temp_row['gender'] . '</td>';
			echo '<td>' . $_temp_row['locale'] . '</td>';
			echo '<td>' . $_temp_row['question1'] . '</td>';
			echo '<td>' . $_temp_row['question2'] . '</td>';
			echo '<td>' . $_temp_row['question3'] . '</td>';
			echo '<td>' . $_temp_row['question3_fill'] . '</td>';
			echo '<td>' . $_temp_row['question4'] . '</td>';
			echo '<td>' . $_temp_row['question4_fill'] . '</td>';
			echo '<td>' . $_temp_row['question5'] . '</td>';
			echo '<td>' . $_temp_row['question5_fill'] . '</td>';
			echo '<td>' . $_temp_row['question6'] . '</td>';
			echo '<td>' . $_temp_row['question6_fill'] . '</td>';
			echo '<td>' . $_temp_row['question7'] . '</td>';
			echo '<td>' . $_temp_row['question7_fill'] . '</td>';
			echo '<td>' . $_temp_row['question8'] . '</td>';
			echo '<td>' . $_temp_row['question8_fill'] . '</td>';
			echo '<td>' . $_temp_row['question9'] . '</td>';
			echo '<td>' . $_temp_row['question10'] . '</td>';
			echo '<td>' . $_temp_row['question10_fill'] . '</td>';
			echo '<td>' . $_temp_row['question11'] . '</td>';
			echo '<td>' . $_temp_row['question11_fill'] . '</td>';
			echo '<td>' . $_temp_row['question12'] . '</td>';
			echo '<td>' . $_temp_row['question12_fill'] . '</td>';
			echo '<td>' . $_temp_row['question13'] . '</td>';
			echo '<td>' . $_temp_row['question14'] . '</td>';
			echo '<td>' . $_temp_row['question15'] . '</td>';
			echo '<td>' . $_temp_row['question16'] . '</td>';
			echo '<td>' . $_temp_row['lucky_code'] . '</td>';
			echo '<td>' . $_temp_row['do_time'] . '</td>';
		}
		$_temp_isColor = !$_temp_isColor;
		echo '</tr>';
	}
	echo '</table><br />';
	?>
</div>
</body>
</html>
