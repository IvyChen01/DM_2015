<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理中心</title>
<link href="style/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
	<div align="right"><a href="?m=admin&a=logout" target="_self">退出</a></div>
	<div class="admin_main">
		<h3>后台管理中心</h3>
		<ul>
			<li><a href="?m=admin_faq&a=count_faq" title="查看统计数据" target="_self">查看统计数据</a></li>
			<li><a href="?m=admin&a=show_change_password" title="修改密码" target="_self">修改密码</a></li>
		</ul>
	</div>
</div>
</body>
</html>
