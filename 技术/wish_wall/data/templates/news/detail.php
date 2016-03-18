<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php 
$_str = System::fixTitle($_news['content']);
$_strTitle = mb_substr($_str, 0, 15, 'utf-8');
 ?><?php echo $$_strTitle; ?></title>
<meta name="keywords" content="<?php echo $_strTitle; ?>" />
<meta name="description" content="<?php echo mb_substr($_str, 0, 80, 'utf-8'); ?>" />
<link rel="shortcut icon" href="images/favicon.ico"/>
<link href="css/index.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<p class="float-left"><a href="/" target="_self">Home</a>&nbsp;&nbsp;<a href="/" target="_self">首页</a></p>
	<div class="clear"></div>
</div>
<div class="news-detail" id="txt"><?php echo System::fixHtml($_news['content']); ?></div>
<div class="footer align-center">
	<p>Copyright &copy; 2015 wishwall.com. All Rights Reserved</p>
</div>
<?php echo $_countCode; ?>
</body>
</html>
