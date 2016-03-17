<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新闻管理</title>
<link rel="shortcut icon" href="images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="news-main">
	<h3>新闻管理</h3>
	<ul>
		<?php $_itemIndex = 1; ?>
		<?php foreach ($_news as $_value) { ?>
			<?php $_str = System::fixTitle($_value['content']); ?>
			<?php $_str = Utils::msubstr($_str, 0, 200); ?>
			<li><a class="art-title" href="?m=adminNews&a=modify&id=<?php echo $_value['id']; ?>" target="_blank"><?php echo $_itemIndex; ?>、<?php echo $_str; ?></a><a class="art-delete" href="?m=adminNews&a=delete&id=<?php echo $_value['id']; ?>" target="_self">[删除]</a><a class="art-modify" href="?m=adminNews&a=modify&id=<?php echo $_value['id']; ?>" target="_blank">[修改]</a><span class="art-pubdate"><?php echo $_value['pubdate']; ?></span><div class="clear"></div></li>
			<?php $_itemIndex++; ?>
		<?php } ?>
	</ul>
	<div class="clear"></div>
	<br />
	[上一页] [下一页]
	<br/><br/>
	<p><a href="?m=adminNews&a=add" target="_self">发布新闻</a></p>
</div>
</body>
</html>
