<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ERP抽奖数据统计</title>
<link href="style/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container">
	<div align="right"><a href="?m=admin&a=main" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></div>
	<div class="main"><br />
		<span><b>ERP抽奖数据统计</b></span><br />
		<br/>
		<?php
			echo '总答题人次: ' . $_total_answer . '<br />';
			echo '总答对人次: ' . $_total_right . '<br />';
			echo '总答对比例: ' . $_total_right_rate . '%<br />';
			echo '总抽奖人次: ' . $_total_right . '<br />';
			echo '总中奖人次: ' . $_total_lucky . '<br />';
			echo '总中奖比例: ' . $_total_lucky_rate . '%<br />';
			echo '<br />';
			echo '<br />';
			echo '<br />';
			
			foreach ($_day_list as $_value)
			{
				echo '日期: ' . $_value['date'] . '<br />';
				echo '答题人次: ' . $_value['answer'] . '<br />';
				echo '答对人次: ' . $_value['right'] . '<br />';
				echo '答对比例: ' . $_value['right_rate'] . '%<br />';
				echo '抽奖人次: ' . $_value['right'] . '<br />';
				echo '中奖人次: ' . $_value['lucky'] . '<br />';
				echo '中奖比例: ' . $_value['lucky_rate'] . '%<br />';
				echo '<br />';
			}
		?>
	</div>
</div>
</body>
</html>
