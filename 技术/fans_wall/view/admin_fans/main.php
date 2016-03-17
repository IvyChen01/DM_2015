<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fans management</title>
<link rel="shortcut icon" href="/images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="?m=adminFans&a=add" target="_self">Add Fans</a> | <a href="?m=admin" target="_self">Management Center</a> | <a href="?m=admin&a=logout" target="_self">Exit</a></span>
</div>
<div class="news-main">
	<h3>Fans management</h3>
	<ul>
		<?php
			$_itemIndex = 1;
			foreach ($_fans as $_value)
			{
				echo '<li><a class="art-title" href="?m=adminFans&a=modify&id=' . $_value['id'] . '" target="_self">' . $_itemIndex . '、' . $_value['username'] . '</a><a class="art-delete" href="?m=adminFans&a=delete&id=' . $_value['id'] . '" target="_self">[Delete]</a><a class="art-modify" href="?m=adminFans&a=modify&id=' . $_value['id'] . '" target="_self">[Modify]</a><span class="art-pubtime">' . $_value['pubtime'] . '</span><div class="clear"></div></li>' . "\r\n";
				$_itemIndex++;
			}
		?>
	</ul>
	<div class="clear"></div>
</div>
</body>
</html>
