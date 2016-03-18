<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zero to Hero</title>
<link href="css/index.min.css?v=2015.5.7_14.37" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
<style type="text/css" media="screen">
.test-panel {
	color: #00FF00;
	font-size: 24px;
	background-color: #333333;
	width: 100%;
	height: 100%;
}
#code, #username {
	font-size: 24px;
	width: 150px;
}
#okBtn {
	font-size: 18px;
	width: 100px;
}
</style>
</head>

<body>
<div class="test-panel">
<br /><br /><br /><br /><br />
<p>Zero to Hero 测试</p>
<br /><br />
测试密码：<input type="text" id="code" /><br /><br /><br />
<input type="button" value="进入测试" id="okBtn" />
</div>
<script type="text/javascript">
var isSubmit = false;

$(document).ready(function()
{
	$("#code").focus();
	$("#okBtn").click(onClickChange);
	$(document).keydown(onDownWindow);
});

function onClickChange(e)
{
	if (!isSubmit)
	{
		if ("" == $("#code").val())
		{
			alert("测试密码不能为空！");
			$("#code").select();
		}
		else
		{
			isSubmit = true;
			$.post("?m=fbzero&a=testLogin", {code: $("#code").val()}, onChange);
		}
	}
}

function onChange(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		isSubmit = false;
		alert("未知错误！");
		$("#code").select();
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			document.location.href = "./";
			break;
		case 1:
			isSubmit = false;
			alert("测试密码错误！");
			$("#code").select();
			break;
		default:
			isSubmit = false;
			alert(res.info);
			$("#code").select();
	}
}

function onDownWindow(e)
{
	var currKey = 0, e = e || event;
	
	currKey = e.keyCode || e.which || e.charCode;
	switch (currKey)
	{
		case 13:
			//回车
			onClickChange(null);
			break;
		default:
	}
}
</script>
</body>
</html>
