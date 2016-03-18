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
<body class="login">
<div class="container">
    <!--<div class="position">-->
        <!--<a href="/login.html" class="back"><img src="images/mobile/m_left_2.png" /></a>-->
        <!--<span>Register</span>-->
    <!--</div>-->
    <div class="content">
        <div class="logo">
            <img src="images/mobile/logo.png"/>
        </div>
        <div class="login-form form">
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
            </div>
            <div class="form-submit">
                <input id="submitBtn" type="submit" value="Login"/>
            </div>
            <div class="register-or-forgot">
                <a href="?m=mwuser&a=register" target="_self" class="link-register" >Register</a>
                <!--<a href="#" class="link-forgot-password">Forgot password?</a>-->
            </div>
            <div class="other-login-method">
                <!--<span class="title">Other login method</span>-->
				<!--
                <div class="other-login-btn facebook-login">
                    <img src="images/mobile/fb_login.png" alt=""/>
                    <span>login with facebook</span>
                </div>
				-->
                <!--<div class="other-login-btn palmchat-login">
                    <img src="images/mobile/af_login.png" alt=""/>
                    <span>login with palmchat</span>
                </div>-->
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
	else
	{
		$.post("?m=mwuser&a=doLogin", {username: $("#usernameTxt").val(), password: $("#passwordTxt").val()}, onSubmit);
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
