<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php 
$_str = System::fixTitle($_news['content']);
$_str = mb_substr($_str, 0, 15, 'utf-8');
 ?><?php echo $_str; ?></title>
<link rel="shortcut icon" href="images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="?m=adminNews" target="_self">新闻管理</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="news-detail"><?php echo System::fixHtml($_news['content']); ?></div>
</body>
</html>
