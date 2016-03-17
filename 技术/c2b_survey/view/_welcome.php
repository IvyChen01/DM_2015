<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>问卷调研</title>
</head>
<body>
欢迎页
<input type="button" id="loginBtn" value="Start" />

<script type="text/javascript">
	var loginBtn = document.getElementById("loginBtn");
	
	loginBtn.onclick = onLogin;
	
	function onLogin(e)
	{
		window.location.reload();
	}
</script>
</body>
</html>
