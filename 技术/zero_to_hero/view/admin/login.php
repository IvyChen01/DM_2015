<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link rel="shortcut icon" href="/images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="login">
	<h3>Login</h3>
	<ul>
		<li>
			<span>User Name: </span><input name="username" type="text" id="username" onfocus="this.select()"/>
		</li>
		<li>
			<span>　Password: </span><input name="password" type="password" id="password" onfocus="this.select()"/>
		</li>
		<li>
			<span>Verify Code: </span><input name="verify" type="text" id="verify" onfocus="this.select()"/><img id="verifyPic" src="?m=admin&a=verify" width="48px" height="22px" />
		</li>
		<li>
			<input type="button" name="login" id="login" value="Login" />
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
		alert("User name can not be empty!");
		$("#username").select();
	}
	else if ($("#password").val() == "")
	{
		alert("Password can not be empty!");
		$("#password").select();
	}
	else if ($("#verify").val() == "")
	{
		alert("Verify code can not be empty!");
		$("#verify").select();
	}
	else
	{
		$.post("?m=admin&a=doLogin", {username: $("#username").val(), password: $("#password").val(), verify: $("#verify").val()}, onLogin);
	}
}

function onLogin(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("Unknow Error!");
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			//登录成功
			document.location.href = "?m=admin";
			break;
		case 1:
			alert("User name or password error!");
			$("#verifyPic").attr("src", "?m=admin&a=verify&rand=" + Math.random());
			$("#username").select();
			break;
		case 2:
			alert("User name and password can not be empty!");
			$("#verifyPic").attr("src", "?m=admin&a=verify&rand=" + Math.random());
			$("#username").select();
			break;
		case 3:
			alert("Verify code error!");
			$("#verifyPic").attr("src", "?m=admin&a=verify&rand=" + Math.random());
			$("#verify").select();
			break;
		default:
			alert("Unknown error!");
			$("#verifyPic").attr("src", "?m=admin&a=verify&rand=" + Math.random());
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
