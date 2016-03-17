<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>问卷调研</title>
<script src="style/js/jquery-2.1.0.min.js" type="text/javascript" language="javascript"></script>
</head>
<body>
<div style="text-align: center;">
主答题界面
<br />
<input type="button" id="submitBtn" value="提交问卷" />
</div>
<script type="text/javascript">
$("#submitBtn").click(onClickSubmit);

function onClickSubmit(e)
{
	var data = [{id:1, answer:["4"], fill:"fill"}, {id:3, answer:["3", "2", "0"], fill:"fill"}];
	
	//var data = [{id:1, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:2, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:3, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:4, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:5, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:6, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:7, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:8, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:9, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:10, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:11, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:12, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:13, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:14, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:12}, {id:15, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}, {id:16, answer:["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19"], fill:"fill"}];
	
	$("#submitBtn").hide();
	$.post("?m=faq&a=answer", {data: JSON.stringify(data)}, onSubmit);
}

function onSubmit(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("Unknown Error！");
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			alert('ok');
			window.location.reload();
			break;
		default:
			alert(res.info);
	}
}
</script>
<!--<script>-->
<!--    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){-->
<!--        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),-->
<!--        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)-->
<!--    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');-->
<!---->
<!--    ga('create', 'UA-51497299-1', 'gsmvillage.net');-->
<!--    ga('send', 'pageview');-->
<!---->
<!--</script>-->
</body>
</html>
