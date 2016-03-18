<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登录</title>
<link href="style/admin.min.css" rel="stylesheet" type="text/css" />
<script src="style/js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="login">
	<h3>管理员登录</h3>
	<ul>
		<li>
			<span>用户名：</span><input name="username" type="text" id="username" onfocus="this.select()"/>
		</li>
		<li>
			<span>　密码：</span><input name="password" type="password" id="password" onfocus="this.select()"/>
		</li>
		<li>
			<span>验证码：</span><input name="verify" type="text" id="verify" onfocus="this.select()"/><img id="verify_pic" src="?m=admin&a=verify" width="48px" height="22px" />
		</li>
		<li>
			<input type="button" name="login" id="login" value="登录" />
		</li>
	</ul>
</div>
<script type="text/javascript">
$(document).ready(function()
{
	$("#username").focus();
	$("#login").click(onClickLogin);
	$(document).keydown(onDownWindow);
});

function onClickLogin(e)
{
	if ($("#username").val() == "")
	{
		alert("用户名不能为空！");
		$("#username").select();
	}
	else if ($("#password").val() == "")
	{
		alert("密码不能为空！");
		$("#password").select();
	}
	else if ($("#verify").val() == "")
	{
		alert("验证码不能码为空！");
		$("#verify").select();
	}
	else
	{
		$.post("?m=admin&a=do_login", {username: $("#username").val(), password: $("#password").val(), verify: $("#verify").val()}, onLogin);
	}
}

function onLogin(value)
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
			alert("登录成功！");
			document.location.href = "?m=admin";
			break;
		case 1:
			alert("用户名或密码不正确！");
			$("#verify_pic").attr("src", "?m=admin&a=verify&rand=" + Math.random());
			$("#username").select();
			break;
		case 2:
			alert("用户名和密码不能为空！");
			$("#verify_pic").attr("src", "?m=admin&a=verify&rand=" + Math.random());
			$("#username").select();
			break;
		case 3:
			alert("验证码不正确！");
			$("#verify_pic").attr("src", "?m=admin&a=verify&rand=" + Math.random());
			$("#verify").select();
			break;
		default:
			alert("未知错误！");
			$("#verify_pic").attr("src", "?m=admin&a=verify&rand=" + Math.random());
			$("#username").select();
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
			onClickLogin(null);
			break;
		default:
	}
}
</script>
</body>
</html>
