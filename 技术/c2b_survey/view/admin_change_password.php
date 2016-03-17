<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改管理员密码</title>
<script src="style/js/jquery-2.1.0.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="container">
	<div align="right"><a href="?m=admin&a=show_admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></div>
	<div class="admin_change_password">
		<h3>修改管理员密码</h3>
		<ul>
			<li>原密码：　　
				<input type="password" name="src_password" id="src_password" onfocus="this.select()"/>
			</li>
			<li>新密码：　　
				<input type="password" name="new_password" id="new_password" onfocus="this.select()"/>
			</li>
			<li>确认新密码：
				<input type="password" name="confirm" id="confirm" onfocus="this.select()"/>
			</li>
			<li>
				<input type="button" name="change" id="change" value="修改密码" />
			</li>
		</ul>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#src_password").focus();
		$("#change").click(onClickChange);
		$(document).keydown(onDownWindow);
	});
	
	function onClickChange(e)
	{
		if ($("#confirm").val() == $("#new_password").val())
		{
			$.post("?m=admin&a=change_password", {src_password: $("#src_password").val(), new_password: $("#new_password").val()}, onChange);
		}
		else
		{
			alert("两次密码不一致！");
			$("#confirm").focus();
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
				alert(res.info);
				document.location.href = "?m=admin";
				break;
			default:
				alert(res.info);
				$("#src_password").focus();
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
