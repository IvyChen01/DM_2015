<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-6-17
 * Time: 上午10:30
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link href="style/master.css" rel="stylesheet">
	<script src="style/js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>
</head>
<body class="login-page">
    <div class="wrapper">
        <div class="top"></div>
            <div class="main">
                <div id="login">
                    <span class="login-form-title">ERP答题抽奖系统</span>
                    <div class="login-form">
                        <p class="employee-id"><input type="text" placeholder="工号" id="username" /></p>
                        <p class="employee-pwd"><input type="password" placeholder="密码"  id="password"/></p>
                        <p class="submit"><a href="javascript:onClickLogin(null);">点击进入</a></p>
                    </div>
                </div>
            </div>
    </div>
<?php include("inc/footer.php");?>
<script type="text/javascript">
$(document).ready(function(){
	$("#username").focus();
	$(document).keydown(onDownWindow);
});

function onClickLogin(e)
{
	$.post("?m=user&a=login", {username: $("#username").val(), password: $("#password").val()}, onLogin);
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
			document.location.href = "?m=faq";
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