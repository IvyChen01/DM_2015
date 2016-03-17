<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理中心</title>
<link rel="shortcut icon" href="/images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="main">
	<h3>后台管理中心</h3>
	<ul>
		<li>
			<a href="?m=admin&a=changePassword" title="修改密码" target="_self">修改密码</a>
		</li>
	</ul>
</div>
</body>
</html>
