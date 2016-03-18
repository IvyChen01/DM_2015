<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理中心</title>
<link href="style/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="main">
	<h3>后台管理中心</h3>
	<ul>
		<!--
		<li>
			<a href="?m=admin&a=winlist" title="中奖名单" target="_self">中奖名单</a>
		</li>
		<li>
			<a href="?m=admin&a=lucky_count" title="抽奖统计" target="_self">抽奖统计</a>
		</li>
		-->
		<li>
			<a href="?m=admin&a=hong_bao_count" title="抢红包统计" target="_self">抢红包统计</a>
		</li>
		<li>
			<a href="?m=admin&a=hong_bao_winlist" title="抢红包中奖名单" target="_self">抢红包中奖名单</a>
		</li>
		<li>
			<a href="?m=admin&a=change_password" title="修改密码" target="_self">修改密码</a>
		</li>
	</ul>
</div>
</body>
</html>
