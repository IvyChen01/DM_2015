<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>itel preorder</title>
<link href="css/index.min.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="demo">
	<form id="orderFrm">
		<ul>
			<li>
				<span>region: </span><input name="region" type="text" id="region" onfocus="this.select()"/>
			</li>
			<li>
				<span>username: </span><input name="username" type="text" id="username" onfocus="this.select()"/>
			</li>
			<li>
				<span>email: </span><input name="email" type="text" id="email" onfocus="this.select()"/>
			</li>
			<li>
				<span>tel: </span><input name="tel" type="text" id="tel" onfocus="this.select()"/>
			</li>
			<li>
				<span>Verify: </span><input name="verify" type="text" id="verify" onfocus="this.select()"/><img id="verifyPic" src="?m=order&a=verify" width="48px" height="22px" />
			</li>
			<li>
				<input type="button" name="submitBtn" id="submitBtn" value="Submit" />
			</li>
		</ul>
	</form>
</div>
<script>
$(document).ready(function()
{
	$("#submitBtn").click(onClickSubmit);
});

function onClickSubmit(e)
{
	if ($("#username").val() == "")
	{
		alert("Name can not be empty!");
		$("#username").select();
		return;
	}
	if (!checkEmail($("#email").val()))
	{
		alert("Please enter the correct email!");
		$("#email").select();
		return;
	}
	if ($("#verify").val() == "")
	{
		alert("Verify can not be empty!");
		$("#verify").select();
		return;
	}
	$.post("?m=order&a=order", {region: $("#region").val(), username: $("#username").val(), email:$("#email").val(), tel:$("#tel").val(), verify:$("#verify").val()}, onSubmit);
}

function onSubmit(value)
{
	var res = null;
	
	try
	{
		res = $.parseJSON(value);
	}
	catch (err)
	{
		//服务端返回异常，json数据不能正常解析
		alert("Unknown error!");
		return;
	}
	
	if (0 == res.code)
	{
		alert("Succeed! Thank you!");
		$("#orderFrm")[0].reset();
	}
	else
	{
		alert(res.msg);
		$("#verifyPic").attr("src", "?m=order&a=verify&rand=" + Math.random());
	}
}

function checkEmail(str)
{
	var re = /^([a-za-z0-9]+[_|-|.]?)*[a-za-z0-9]+@([a-za-z0-9]+[_|-|.]?)*[a-za-z0-9]+.[a-za-z]{2,3}$/;
	
	return re.test(str);
}
</script>
</body>
</html>
