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
	Q5. 具体来说，您认为这部手机在屏幕方面的哪些表现让您感到不满意或认为需要改进，请将它们全部勾选出来？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;Screen size (too large) &nbsp;<b>[<?php echo $_answer_num['question5_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Screen size (too small) &nbsp;<b>[<?php echo $_answer_num['question5_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The screen is not clear enough &nbsp;<b>[<?php echo $_answer_num['question5_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The color is not bright enough &nbsp;<b>[<?php echo $_answer_num['question5_4']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;It's not clear under the sun &nbsp;<b>[<?php echo $_answer_num['question5_5']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;It's not clear to see from other angles &nbsp;<b>[<?php echo $_answer_num['question5_6']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The touch feeling is not good &nbsp;<b>[<?php echo $_answer_num['question5_7']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The lighting of the screen is uneven &nbsp;<b>[<?php echo $_answer_num['question5_8']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Easy to break &nbsp;<b>[<?php echo $_answer_num['question5_9']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Easy to scratch &nbsp;<b>[<?php echo $_answer_num['question5_10']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Take a long time to response (Sensitivity) &nbsp;<b>[<?php echo $_answer_num['question5_11']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No screen protector &nbsp;<b>[<?php echo $_answer_num['question5_12']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Others (Please specify:__________) &nbsp;<b>[<?php echo $_answer_num['question5_13']; ?>人]</b> <a href="?m=admin&a=fill&type=<?php echo $_phone_type; ?>&id=5" target="_blank"><b>more...</b></a><br />
	<br />
	Q6. 请问您觉得这部手机在电池方面应该怎样改进或达到怎样的效果？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;The capacity is less than that of other phones &nbsp;<b>[<?php echo $_answer_num['question6_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Drain out fast in normal use &nbsp;<b>[<?php echo $_answer_num['question6_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Over heat while using the phone &nbsp;<b>[<?php echo $_answer_num['question6_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Take a long time to charge &nbsp;<b>[<?php echo $_answer_num['question6_4']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Cannot get fully charged &nbsp;<b>[<?php echo $_answer_num['question6_5']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Others (Please specify:__________) &nbsp;<b>[<?php echo $_answer_num['question6_6']; ?>人]</b> <a href="?m=admin&a=fill&type=<?php echo $_phone_type; ?>&id=6" target="_blank"><b>more...</b></a><br />
	<br />
	Q7. 具体来说，您认为这部手机在拍摄方面的哪些表现让您感到不满意或认为需要改进，请将它们全部勾选出来？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;Take a long time to start up &nbsp;<b>[<?php echo $_answer_num['question7_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The photos are not clear &nbsp;<b>[<?php echo $_answer_num['question7_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Take a long time to focus &nbsp;<b>[<?php echo $_answer_num['question7_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Out of focus/cannot auto-focus &nbsp;<b>[<?php echo $_answer_num['question7_4']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Continuous shoot speed is low &nbsp;<b>[<?php echo $_answer_num['question7_5']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No continuous shoot &nbsp;<b>[<?php echo $_answer_num['question7_6']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Shutter speed is low &nbsp;<b>[<?php echo $_answer_num['question7_7']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No photograph shortcut key &nbsp;<b>[<?php echo $_answer_num['question7_8']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The night shoot is not good. &nbsp;<b>[<?php echo $_answer_num['question7_9']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The flashlight is not bright enough. &nbsp;<b>[<?php echo $_answer_num['question7_10']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No dual cameras &nbsp;<b>[<?php echo $_answer_num['question7_11']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The pixels of rear camera is low &nbsp;<b>[<?php echo $_answer_num['question7_12']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The pixels of front camera is low &nbsp;<b>[<?php echo $_answer_num['question7_13']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Photograph modes are poor. &nbsp;<b>[<?php echo $_answer_num['question7_14']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The colors of the photo distort. &nbsp;<b>[<?php echo $_answer_num['question7_15']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Photo edition is weak. &nbsp;<b>[<?php echo $_answer_num['question7_16']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Inconvenient to invoke photograph. &nbsp;<b>[<?php echo $_answer_num['question7_17']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Inconvenient to upload/share photos. &nbsp;<b>[<?php echo $_answer_num['question7_18']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Photo albums are not sorted properly &nbsp;<b>[<?php echo $_answer_num['question7_19']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Others (Please specify:__________) &nbsp;<b>[<?php echo $_answer_num['question7_20']; ?>人]</b> <a href="?m=admin&a=fill&type=<?php echo $_phone_type; ?>&id=7" target="_blank"><b>more...</b></a><br />
	<br />
	Q8. 具体来说，您认为这部手机在音乐体验方面（自动显示Q1的答案）的哪些表现让您感到不满意或认为需要改进，请将它们全部勾选出来？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;The sound is too low. &nbsp;<b>[<?php echo $_answer_num['question8_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The sound is too loud. &nbsp;<b>[<?php echo $_answer_num['question8_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Too few sound modes. &nbsp;<b>[<?php echo $_answer_num['question8_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The bass effect is bad. &nbsp;<b>[<?php echo $_answer_num['question8_4']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The UI of music player is not good-looking. &nbsp;<b>[<?php echo $_answer_num['question8_5']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Music player is complicated to use &nbsp;<b>[<?php echo $_answer_num['question8_6']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No music shortcut key. &nbsp;<b>[<?php echo $_answer_num['question8_7']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No Dolby/SRS/Beats Certification &nbsp;<b>[<?php echo $_answer_num['question8_8']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The tone of the speaker is poor. &nbsp;<b>[<?php echo $_answer_num['question8_9']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The tone of the earpiece is poor. &nbsp;<b>[<?php echo $_answer_num['question8_10']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The memory capacity is limited. &nbsp;<b>[<?php echo $_answer_num['question8_11']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Too few pre-installed music apps &nbsp;<b>[<?php echo $_answer_num['question8_12']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Sharing music is inconvenient. &nbsp;<b>[<?php echo $_answer_num['question8_13']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Support too few music formats &nbsp;<b>[<?php echo $_answer_num['question8_14']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No recording function. &nbsp;<b>[<?php echo $_answer_num['question8_15']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No lyric displaying function. &nbsp;<b>[<?php echo $_answer_num['question8_16']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Music download is inconvenient. &nbsp;<b>[<?php echo $_answer_num['question8_17']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No music preloaded. &nbsp;<b>[<?php echo $_answer_num['question8_18']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The system ringtone is unpleasant. &nbsp;<b>[<?php echo $_answer_num['question8_19']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Others (Please specify:__________) &nbsp;<b>[<?php echo $_answer_num['question8_20']; ?>人]</b> <a href="?m=admin&a=fill&type=<?php echo $_phone_type; ?>&id=8" target="_blank"><b>more...</b></a><br />
	<br />
	Q9. 具体来说，您认为这部手机在视频体验方面的哪些表现让您感到不满意或认为需要改进，请将它们全部勾选出来？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;The UI of video player is not good-looking. &nbsp;<b>[<?php echo $_answer_num['question9_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Video player is complicated to use.  &nbsp;<b>[<?php echo $_answer_num['question9_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No video shortcut key. &nbsp;<b>[<?php echo $_answer_num['question9_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Support too few video formats &nbsp;<b>[<?php echo $_answer_num['question9_4']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The video image is not clear &nbsp;<b>[<?php echo $_answer_num['question9_5']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Video playing is not smooth &nbsp;<b>[<?php echo $_answer_num['question9_6']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Video download is inconvenient. &nbsp;<b>[<?php echo $_answer_num['question9_7']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Sharing video is inconvenient. &nbsp;<b>[<?php echo $_answer_num['question9_8']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The memory capacity is limited. &nbsp;<b>[<?php echo $_answer_num['question9_9']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Too few pre-installed video apps &nbsp;<b>[<?php echo $_answer_num['question9_10']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Do not support to connect other devices &nbsp;<b>[<?php echo $_answer_num['question9_11']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No video preloaded. &nbsp;<b>[<?php echo $_answer_num['question9_12']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Others &nbsp;<b>[<?php echo $_answer_num['question9_13']; ?>人]</b><br />
	<br />
	Q10. 具体来说，您认为这部手机在上网方面的哪些表现让您感到不满意或认为需要改进，请将它们全部勾选出来？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;The network setting is too complicated &nbsp;<b>[<?php echo $_answer_num['question10_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Do not like the pre-installed browser &nbsp;<b>[<?php echo $_answer_num['question10_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Take a long time to start up &nbsp;<b>[<?php echo $_answer_num['question10_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The UI of the browser is not good looking &nbsp;<b>[<?php echo $_answer_num['question10_4']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The browser loading time is too long &nbsp;<b>[<?php echo $_answer_num['question10_5']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The browser is complicated to use &nbsp;<b>[<?php echo $_answer_num['question10_6']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The internet connection is slow &nbsp;<b>[<?php echo $_answer_num['question10_7']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Consume a lot of data &nbsp;<b>[<?php echo $_answer_num['question10_8']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Bad webpage browsing experience &nbsp;<b>[<?php echo $_answer_num['question10_9']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Browser crashes always &nbsp;<b>[<?php echo $_answer_num['question10_10']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Download speed is too slow &nbsp;<b>[<?php echo $_answer_num['question10_11']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Others (Please specify:__________________) &nbsp;<b>[<?php echo $_answer_num['question10_12']; ?>人]</b> <a href="?m=admin&a=fill&type=<?php echo $_phone_type; ?>&id=10" target="_blank"><b>more...</b></a><br />
	<br />
	Q11. 具体来说，您认为这部手机在预装应用方面的哪些表现让您感到不满意或认为需要改进，请将它们全部勾选出来？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;Too many pre-loaded apps &nbsp;<b>[<?php echo $_answer_num['question11_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Cannot uninstall pre-installed apps &nbsp;<b>[<?php echo $_answer_num['question11_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Too few pre-loaded apps &nbsp;<b>[<?php echo $_answer_num['question11_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;No favorite pre-loaded apps &nbsp;<b>[<?php echo $_answer_num['question11_4']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The version of pre-loaded apps are too old &nbsp;<b>[<?php echo $_answer_num['question11_5']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Others (Please specify:_______________) &nbsp;<b>[<?php echo $_answer_num['question11_6']; ?>人]</b> <a href="?m=admin&a=fill&type=<?php echo $_phone_type; ?>&id=11" target="_blank"><b>more...</b></a><br />
	<br />
	Q12. 具体来说，您认为这部手机在配件方面的哪些表现让您感到不满意或认为需要改进，请将它们全部勾选出来？<br />
	&nbsp;&nbsp;&nbsp;&nbsp;Too few accessories &nbsp;<b>[<?php echo $_answer_num['question12_1']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The quality of accessories is not good &nbsp;<b>[<?php echo $_answer_num['question12_2']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;The accessories are not good-looking &nbsp;<b>[<?php echo $_answer_num['question12_3']; ?>人]</b><br />
	&nbsp;&nbsp;&nbsp;&nbsp;Others (Please specify:_______________) &nbsp;<b>[<?php echo $_answer_num['question12_4']; ?>人]</b> <a href="?m=admin&a=fill&type=<?php echo $_phone_type; ?>&id=12" target="_blank"><b>more...</b></a><br />
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
