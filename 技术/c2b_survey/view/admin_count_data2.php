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
	Q3. 在您的使用过程中，您认为这部手机在哪些方面的表现让您感到不满意或者需要改进，请您将它们全部勾选出来？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;Quality &nbsp;<b>[<?php echo $_answer_num['question3_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Signal &nbsp;<b>[<?php echo $_answer_num['question3_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Appearance &nbsp;<b>[<?php echo $_answer_num['question3_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Screen &nbsp;<b>[<?php echo $_answer_num['question3_4']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Lasting battery &nbsp;<b>[<?php echo $_answer_num['question3_5']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Photography experience &nbsp;<b>[<?php echo $_answer_num['question3_6']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Music experience &nbsp;<b>[<?php echo $_answer_num['question3_7']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Video experience &nbsp;<b>[<?php echo $_answer_num['question3_8']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Social media (chatting tools) &nbsp;<b>[<?php echo $_answer_num['question3_9']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Internet surfing &nbsp;<b>[<?php echo $_answer_num['question3_10']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Pre-loaded APP &nbsp;<b>[<?php echo $_answer_num['question3_11']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Running speed &nbsp;<b>[<?php echo $_answer_num['question3_12']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Memory capacity &nbsp;<b>[<?php echo $_answer_num['question3_13']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;UI (user interface) &nbsp;<b>[<?php echo $_answer_num['question3_14']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Accessories &nbsp;<b>[<?php echo $_answer_num['question3_15']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Others (Please specify___________) &nbsp;<b>[<?php echo $_answer_num['question3_16']; ?>人]</b> <a href="?m=admin&a=fill&type=<?php echo $_phone_type; ?>&id=3" target="_blank"><b>more...</b></a><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No unsatisfying aspect &nbsp;<b>[<?php echo $_answer_num['question3_17']; ?>人]</b><br />
	<br />
	Q4. 在您提到不满意的方面中，哪三个方面的表现让您最不满意？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;Quality &nbsp;<b>[<?php echo $_answer_num['question4_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Signal &nbsp;<b>[<?php echo $_answer_num['question4_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Appearance &nbsp;<b>[<?php echo $_answer_num['question4_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Screen &nbsp;<b>[<?php echo $_answer_num['question4_4']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Lasting battery &nbsp;<b>[<?php echo $_answer_num['question4_5']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Photography experience &nbsp;<b>[<?php echo $_answer_num['question4_6']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Music experience &nbsp;<b>[<?php echo $_answer_num['question4_7']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Video experience &nbsp;<b>[<?php echo $_answer_num['question4_8']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Social media (chatting tools) &nbsp;<b>[<?php echo $_answer_num['question4_9']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Internet surfing &nbsp;<b>[<?php echo $_answer_num['question4_10']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Pre-loaded APP &nbsp;<b>[<?php echo $_answer_num['question4_11']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Running speed &nbsp;<b>[<?php echo $_answer_num['question4_12']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Memory capacity &nbsp;<b>[<?php echo $_answer_num['question4_13']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;UI (user interface) &nbsp;<b>[<?php echo $_answer_num['question4_14']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Accessories &nbsp;<b>[<?php echo $_answer_num['question4_15']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Others (Please specify___________) &nbsp;<b>[<?php echo $_answer_num['question4_16']; ?>人] <a href="?m=admin&a=fill&type=<?php echo $_phone_type; ?>&id=4" target="_blank"><b>more...</b></a></b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No unsatisfying aspect &nbsp;<b>[<?php echo $_answer_num['question4_17']; ?>人]</b><br />
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
