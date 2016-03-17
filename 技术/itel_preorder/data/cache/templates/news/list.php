<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>test</title>
<meta name="keywords" content="test" />
<meta name="description" content="test" />
<link rel="shortcut icon" href="images/favicon.ico"/>
<link href="css/index.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<p class="float-left"><a href="/" target="_self">test</a></p>
	<div class="clear"></div>
</div>
<div class="news-list">
	<ul>
		<?php foreach ($_news as $_value) { ?>
			<?php $_str = System::fixTitle($_value['content']); ?>
			<?php $_str = Utils::msubstr($_str, 0, 200); ?>
			<li><a href="?m=news&a=detail&id=<?php echo $_value['id']; ?>" target="_self"><?php echo $_str; ?></a>
			<p class="date"><?php echo Utils::mdate('Y-m-d', $_value['pubdate']); ?></p>
			</li>
		<?php } ?>
	</ul>
</div>
<div class="footer align-center">
	<p>Copyright &copy; 2015 test.com. All Rights Reserved</p>
</div>
<?php echo $_countCode; ?>
</body>
</html>
