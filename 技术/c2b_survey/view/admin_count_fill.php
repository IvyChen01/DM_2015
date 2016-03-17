<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>统计数据</title>
</head>
<body>
<div class="container">
	<?php
	$_temp_index = 1;
	foreach ($_fill_data as $_temp_key => $_temp_value)
	{
		//echo '<b>[' . $_temp_index . ']</b> <b>[fbid:' . $_temp_value['fbid'] . ']</b> ' . $_temp_value['answer'] . '<br />';
		echo '[' . $_temp_index . '] [fbid:' . $_temp_value['fbid'] . '] <b>' . $_temp_value['answer'] . '</b><br />';
		$_temp_index++;
	}
	
	if ($_question_id == 14)
	{
		echo '<br />平均月数：<b>' . $_month_avg . '</b><br />';
	}
	?>
</div>
</body>
</html>
