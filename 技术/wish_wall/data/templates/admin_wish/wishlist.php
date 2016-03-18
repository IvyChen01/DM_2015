<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>许愿查看</title>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">管理中心</a> | <a href="?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="db">
	<h3>许愿查看</h3>
	<table align="center" border="1" cellpadding="5" cellspacing="0" bgcolor="#FDF2F2">
		<tr>
			<td bgcolor="#F0C090">头像</td>
			<td bgcolor="#F0C090">姓名</td>
			<td bgcolor="#F0C090">性别</td>
			<td bgcolor="#F0C090">邮箱</td>
			<td bgcolor="#F0C090">日期</td>
			<td bgcolor="#F0C090">内容</td>
			<td bgcolor="#F0C090">删除</td>
		</tr>
		<?php $isColor = false; ?>
		<?php foreach ($wishList as $value) { ?>
			<tr>
				<?php if ($isColor) { ?>
					<td bgcolor="#F1EDFE"><img src="<?php echo $value['photo']; ?>" width="56px" height="56px"/></td>
					<td bgcolor="#F1EDFE"><?php echo $value['username']; ?></td>
					<td bgcolor="#F1EDFE"><?php echo $value['gender']; ?></td>
					<td bgcolor="#F1EDFE"><?php echo $value['email']; ?></td>
					<td bgcolor="#F1EDFE"><?php echo $value['pubdate']; ?></td>
					<td bgcolor="#F1EDFE"><?php echo $value['content']; ?></td>
					<td bgcolor="#F1EDFE"><a href="?m=adminWish&a=deleteWish&id=<?php echo $value['id']; ?>&page=<?php echo $page; ?>" target="_self">删除</a></td>
				<?php } else { ?>
					<td><img src="<?php echo $value['photo']; ?>" width="56px" height="56px"/></td>
					<td><?php echo $value['username']; ?></td>
					<td><?php echo $value['gender']; ?></td>
					<td><?php echo $value['email']; ?></td>
					<td><?php echo $value['pubdate']; ?></td>
					<td><?php echo $value['content']; ?></td>
					<td><a href="?m=adminWish&a=deleteWish&id=<?php echo $value['id']; ?>&page=<?php echo $page; ?>" target="_self">删除</a></td>
				<?php } ?>
				<?php $isColor = !$isColor; ?>
			</tr>
		<?php } ?>
	</table>
	<br/>
	<?php echo $pageStr; ?>
	<br/>
</div>
</body>
</html>
