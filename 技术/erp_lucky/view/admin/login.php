<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员登录</title>
<link href="style/admin.css" rel="stylesheet" type="text/css" />
<script src="style/js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="container">
	<div class="admin_login">
		<h3>管理员登录</h3>
		<ul>
			<li class=".text2">用户名：
				<input name="username" type="text" id="username" onfocus="this.select()"/>
			</li>
			<li>密码：　
				<input name="password" type="password" id="password" onfocus="this.select()"/>
			</li>
			<li>
				<input type="button" name="login" id="login" value="登录" />
			</li>
		</ul>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#username").focus();
	$("#login").click(onClickLogin);
	$(document).keydown(onDownWindow);
});

function onClickLogin(e)
{
	$.post("?m=admin&a=login", {username: $("#username").val(), password: $("#password").val()}, onLogin);
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
			alert(res.info);
			document.location.href = "?m=admin&a=main";
			break;
		default:
			alert(res.info);
			$("#password").select();
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
