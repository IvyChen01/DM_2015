<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改管理员密码</title>
<link href="style/admin.min.css" rel="stylesheet" type="text/css" />
<script src="style/js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="change-pw">
	<h3>修改管理员密码</h3>
	<ul>
		<li>
			<span>　　原密码：</span><input type="password" name="src_password" id="src_password" onfocus="this.select()"/>
		</li>
		<li>
			<span>　　新密码：</span><input type="password" name="new_password" id="new_password" onfocus="this.select()"/>
		</li>
		<li>
			<span>确认新密码：</span><input type="password" name="confirm" id="confirm" onfocus="this.select()"/>
		</li>
		<li>
			<input type="button" name="change" id="change" value="修改密码" />
		</li>
	</ul>
</div>
<script type="text/javascript">
$(document).ready(function()
{
	$("#src_password").focus();
	$("#change").click(onClickChange);
	$(document).keydown(onDownWindow);
});

function onClickChange(e)
{
	if ($("#src_password").val() == "")
	{
		alert("原密码不能为空！");
		$("#src_password").select();
	}
	else if ($("#new_password").val() == "")
	{
		alert("新密码不能为空！");
		$("#new_password").select();
	}
	else if ($("#confirm").val() == "")
	{
		alert("确认新密码不能码为空！");
		$("#confirm").select();
	}
	else if ($("#confirm").val() != $("#new_password").val())
	{
		alert("两次密码不一致！");
		$("#confirm").select();
	}
	else
	{
		$.post("?m=admin&a=do_change_password", {src_password: $("#src_password").val(), new_password: $("#new_password").val()}, onChange);
	}
}

function onChange(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("未知错误！");
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			alert("修改成功！");
			document.location.href = "?m=admin";
			break;
		case 1:
			alert("原密码错误！");
			$("#src_password").select();
			break;
		case 2:
			alert("原密码和新密码不能为空！");
			$("#src_password").select();
			break;
		default:
			alert("未知错误！");
			$("#src_password").select();
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
