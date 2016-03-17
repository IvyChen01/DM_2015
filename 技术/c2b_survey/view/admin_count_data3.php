<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>统计数据</title>
</head>
<body>
<div class="container">
	<div align="right"><a href="?m=admin&a=show_admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></div>
	<h3 align="center">统计数据</h3>
	总答题人数：<?php echo $_all_count; ?><br />
	<br />
	当前机型：<b><?php echo $_phone_name; ?></b><br />
	<br />
	Q1. 请问您目前最常使用的机型是以下哪种情况？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="t1" value="查看" onclick="window.location.href='?m=admin&a=count&type=0'" <?php echo $_phone_type == 0 ? 'disabled="true"' : ''?> /> TECNO Phantom A+ (F7+) &nbsp;<b>[<?php echo $_question_count[0]['question1_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="t2" value="查看" onclick="window.location.href='?m=admin&a=count&type=1'" <?php echo $_phone_type == 1 ? 'disabled="true"' : ''?> /> TECNO P5 &nbsp;<b>[<?php echo $_question_count[1]['question1_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="t3" value="查看" onclick="window.location.href='?m=admin&a=count&type=2'" <?php echo $_phone_type == 2 ? 'disabled="true"' : ''?> /> Other TECNO smartphone (Android phone) &nbsp;<b>[<?php echo $_question_count[2]['question1_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="t4" value="查看" onclick="window.location.href='?m=admin&a=count&type=3'" <?php echo $_phone_type == 3 ? 'disabled="true"' : ''?> /> Other TECNO phone (Not smartphone/ not Android phone) &nbsp;<b>[<?php echo $_question_count[3]['question1_4']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="t5" value="查看" onclick="window.location.href='?m=admin&a=count&type=4'" disabled="true" /> Other Brand's phone &nbsp;<b>[<?php echo $_question_count[4]['question1_5']; ?>人]</b><br />
	<br />
	Q2. 您对当前使用的这部手机的整体满意度是怎样的？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;Very satisfied &nbsp;<b>[<?php echo $_answer_num['question2_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Somewhat satisfied &nbsp;<b>[<?php echo $_answer_num['question2_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Neither satisfied nor dissatisfied &nbsp;<b>[<?php echo $_answer_num['question2_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Somewhat dissatisfied &nbsp;<b>[<?php echo $_answer_num['question2_4']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Very dissatisfied &nbsp;<b>[<?php echo $_answer_num['question2_5']; ?>人]</b><br />
	<br />
	Q13. 您的手机有没有出现过需要去售后中心进行维修的问题？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;Yes &nbsp;<b>[<?php echo $_answer_num['question13_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No &nbsp;<b>[<?php echo $_answer_num['question13_2']; ?>人]</b><br />
	<br />
	Q14. 您在购买这部手机多久后出现了以上问题？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;<a href="?m=admin&a=fill&type=<?php echo $_phone_type; ?>&id=14" target="_blank"><b>more...</b></a><br />
	<br />
	Q15. 您去过TECNO的售后中心吗？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;Yes &nbsp;<b>[<?php echo $_answer_num['question15_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No &nbsp;<b>[<?php echo $_answer_num['question15_2']; ?>人]</b><br />
	<br />
	Q16. 您对TECNO的售后中心的满意程度如何？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;Very satisfied &nbsp;<b>[<?php echo $_answer_num['question16_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Somewhat satisfied &nbsp;<b>[<?php echo $_answer_num['question16_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Neither satisfied nor dissatisfied &nbsp;<b>[<?php echo $_answer_num['question16_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Somewhat dissatisfied &nbsp;<b>[<?php echo $_answer_num['question16_4']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Very dissatisfied &nbsp;<b>[<?php echo $_answer_num['question16_5']; ?>人]</b><br />
</div>
</body>
</html>
