<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Login--carlcare</title>
    <link rel="stylesheet" href="style/css/master.css"/>
</head>
<body class="page login-page">
<div class="header">
    <div class="container">
        <a href="/">
            <img src="images/logo.png" alt="carlcare"/>
        </a>
    </div>
</div>
<div class="body">
    <div class="container">
        <div class="lg-tils">
           <p>
               SUEVEY<br>
               FOR CUSTOMER<br>
               SATISFACTION
           </p>
        </div>
        <div class="login-panel">
            <div class="login-form">
                <div class="control-form">
                    <label for="inputUsername">USERNAME</label>
                    <input type="text" id="inputUsername" class="input-username"/>
                </div>
                <div class="control-form">
                    <label for="inputUserPwd">PASSWORD</label>
                    <input type="password" id="inputUserPwd" class="input-userpwd"/>
                </div>
                <div class="login-soc clearfix">
                    <div class="verify-code">
                        <input type="text" class="verify-input" id="verify" />
                        <a href="javascript:void(0);"><img id="verifyPic" src="/?m=user&a=verify" width="48px" height="22px" /></a>
                    </div>
                    <div class="remember-me">
                        <label>
                            <input type="checkbox" id="rememberChk" />
                            Remember
                        </label>
                    </div>
                </div>
                <div class="login-submit">
                    <button type="button" id="login">LOGIN</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="container">
        <p>
            Copyright © 2010 - 2015 Themes Kingdom. All Rights Reserved.<br>
            2CheckOut.com Inc. (Ohio, USA) is an authorized retailer for goods and services provided by Themes Kingdom.
        </p>
    </div>
</div>
<script src="style/js/jquery-1.8.2.min.js"></script>
<script src="style/js/cookie.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#inputUsername").focus();
	$("#login").click(onClickLogin);
	$("#verifyPic").click(onClickVerifyPic);
	$(document).keydown(onDownWindow);
});

function onClickLogin(e)
{
	var isRemember = 0;
	
	if ($('#rememberChk:checked').val())
	{
		isRemember = 1;
	}
	else
	{
		isRemember = 0;
	}
	
	if ($("#inputUsername").val() == "")
	{
		alert("用户名不能为空！");
		$("#inputUsername").select();
	}
	else if ($("#inputUserPwd").val() == "")
	{
		alert("密码不能为空！");
		$("#inputUserPwd").select();
	}
	else if ($("#verify").val() == "")
	{
		alert("验证码不能码为空！");
		$("#verify").select();
	}
	else
	{
		$.post("/?m=user&a=doLogin", {username: $("#inputUsername").val(), password: $("#inputUserPwd").val(), verify: $("#verify").val(), remember: isRemember}, onLogin);
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
			document.location.href = "/";
			break;
		case 1:
			alert("用户名或密码不正确！");
			$("#verifyPic").attr("src", "?m=user&a=verify&rand=" + Math.random());
			$("#inputUsername").select();
			break;
		case 2:
			alert("用户名和密码不能为空！");
			$("#verifyPic").attr("src", "?m=user&a=verify&rand=" + Math.random());
			$("#inputUsername").select();
			break;
		case 3:
			alert("验证码不正确！");
			$("#verifyPic").attr("src", "?m=user&a=verify&rand=" + Math.random());
			$("#verify").select();
			break;
		default:
			alert("未知错误！");
			$("#verifyPic").attr("src", "?m=user&a=verify&rand=" + Math.random());
			$("#inputUsername").select();
	}
}

function onClickVerifyPic(e)
{
	$("#verifyPic").attr("src", "?m=user&a=verify&rand=" + Math.random());
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