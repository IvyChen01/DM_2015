<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Change Password</title>
<link rel="shortcut icon" href="/images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">Management Center</a> | <a href="?m=admin&a=logout" target="_self">Exit</a></span>
</div>
<div class="change-pw">
	<h3>Change Password</h3>
	<ul>
		<li>
			<span>　　Old password：</span><input type="password" name="srcPassword" id="srcPassword" onfocus="this.select()"/>
		</li>
		<li>
			<span>　　New password：</span><input type="password" name="newPassword" id="newPassword" onfocus="this.select()"/>
		</li>
		<li>
			<span>Confirm new password：</span><input type="password" name="confirm" id="confirm" onfocus="this.select()"/>
		</li>
		<li>
			<input type="button" name="change" id="change" value="Change" />
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
		alert("Old password can not be empty!");
		$("#srcPassword").select();
	}
	else if ($("#newPassword").val() == "")
	{
		alert("New password can not be empty!");
		$("#newPassword").select();
	}
	else if ($("#confirm").val() == "")
	{
		alert("Confirmation password can not be empty!");
		$("#confirm").select();
	}
	else if ($("#confirm").val() != $("#newPassword").val())
	{
		alert("Password and confirmation password are not the same!");
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
		alert("Unknown Error!");
		return;
	}
	res = $.parseJSON(value);
	if (0 == res.code)
	{
		alert("Changed succeed!");
		document.location.href = "?m=admin";
	}
	else
	{
		alert(res.msg);
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
