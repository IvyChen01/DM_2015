<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="css/mobile.css?v=2015.5.23_18.18"/>
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
</head>
<body>
<div class="container">
    <div class="position">
        <a href="?m=mwuser&a=login" target="_self" class="back"><img src="images/mobile/m_left_2.png" /></a>
        <span>Register</span>
    </div>
    <div class="content">
        <div class="logo">
            <img src="images/mobile/logo.png"/>
        </div>
        <div class="register-form form">
            <div class="basic-info">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input"><input id="usernameTxt" type="text" placeholder=""/></div>
                    <a class="delete-v" href="javascript:;">×</a>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input"><input id="passwordTxt" type="password" /></div>
                    <a class="delete-v" href="javascript:;">×</a>
                </div>
				<!--
                <div class="form-group">
                    <label>Confirm</label>
                    <div class="input"><input id="confirmTxt" type="password"/></div>
                    <a class="delete-v" href="javascript:;">×</a>
                </div>
				-->
				<div class="form-group">
                    <label>Phone</label>
                    <div class="input"><input id="phoneTxt" type="text" placeholder=""/></div>
                    <a class="delete-v" href="javascript:;">×</a>
                </div>
				<div class="form-group">
                    <label>Nickname</label>
                    <div class="input"><input id="nicknameTxt" type="text" placeholder=""/></div>
                    <a class="delete-v" href="javascript:;">×</a>
                </div>
            </div>
			<!--
            <div class="user-nick">
                <div class="form-group">
                    <label>Nickname</label>
                    <div class="input"><input id="nicknameTxt" type="text"/></div>
                    <a class="delete-v" href="javascript:;">×</a>
                </div>
            </div>
			-->
            <div class="form-submit">
                <input id="submitBtn" type="submit" value="Register"/>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function()
{
	$("#submitBtn").click(onClickSubmit);
});

function onClickSubmit(e)
{
	if ($("#usernameTxt").val() == "")
	{
		alert("Username cannot be empty!");
		$("#usernameTxt").select();
	}
	else if ($("#passwordTxt").val() == "")
	{
		alert("Password cannot be empty!");
		$("#passwordTxt").select();
	}
	else if ($("#phoneTxt").val() == "")
	{
		alert("Phone number cannot be empty!");
		$("#phoneTxt").select();
	}
	else if ($("#nicknameTxt").val() == "")
	{
		alert("Nickname cannot be empty!");
		$("#nicknameTxt").select();
	}
	else
	{
		$.post("?m=mwuser&a=doRegister", {username: $("#usernameTxt").val(), password: $("#passwordTxt").val(), phone: $("#phoneTxt").val(), nick: $("#nicknameTxt").val()}, onSubmit);
	}
}

function onSubmit(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("Unknown error!");
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			document.location.href = "./";
			break;
		default:
			alert(res.info);
	}
}
</script>
</body>
</html>
