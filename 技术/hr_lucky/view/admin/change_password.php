<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改管理员密码</title>
<link rel="shortcut icon" href="/images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="change-pw">
	<h3>修改管理员密码</h3>
	<ul>
		<li>
			<span>　　原密码：</span><input type="password" name="srcPassword" id="srcPassword" onfocus="this.select()"/>
		</li>
		<li>
			<span>　　新密码：</span><input type="password" name="newPassword" id="newPassword" onfocus="this.select()"/>
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
	$("#srcPassword").focus();
	$("#change").click(onClickChange);
	$(document).keydown(onDownWindow);
});

function onClickChange(e)
{
	if ($("#srcPassword").val() == "")
	{
		alert("原密码不能为空！");
		$("#srcPassword").select();
	}
	else if ($("#newPassword").val() == "")
	{
		alert("新密码不能为空！");
		$("#newPassword").select();
	}
	else if ($("#confirm").val() == "")
	{
		alert("确认新密码不能码为空！");
		$("#confirm").select();
	}
	else if ($("#confirm").val() != $("#newPassword").val())
	{
		alert("两次密码不一致！");
		$("#confirm").select();
	}
	else
	{
		$.post("?m=admin&a=doChangePassword", {srcPassword: $("#srcPassword").val(), newPassword: $("#newPassword").val()}, onChange);
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
			$("#srcPassword").select();
			break;
		case 2:
			alert("原密码和新密码不能为空！");
			$("#srcPassword").select();
			break;
		default:
			alert("未知错误！");
			$("#srcPassword").select();
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
