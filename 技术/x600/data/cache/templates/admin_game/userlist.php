<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户列表</title>
<link href="css/admin.css?v=2015.11.18_17.48" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="topbar">
	<span><a href="./?m=admin" target="_self">管理中心</a> | <a href="./?m=admin&a=logout" target="_self">退出</a></span>
</div>
<div class="db">
	<h3>用户列表</h3>
	<table align="center" border="1" cellpadding="5" cellspacing="0" bgcolor="#FDF2F2">
		<tr>
			<td bgcolor="#F0C090">序号</td>
			<td bgcolor="#F0C090">头像</td>
			<td bgcolor="#F0C090">姓名</td>
			<td bgcolor="#F0C090">性别</td>
			<td bgcolor="#F0C090">邮箱</td>
			<td bgcolor="#F0C090">注册时间</td>
		</tr>
		<?php $isColor = false; ?>
		<?php $index = 1 + $indexOffset; ?>
		<?php foreach ($users as $value) { ?>
			<tr>
				<?php if ($isColor) { ?>
					<td bgcolor="#F1EDFE"><?php echo $index; ?></td>
					<td bgcolor="#F1EDFE"><img src="<?php echo $value['photo']; ?>" width="62px" height="62px"/></td>
					<td bgcolor="#F1EDFE"><?php echo $value['username']; ?></td>
					<td bgcolor="#F1EDFE"><?php echo $value['gender']; ?></td>
					<td bgcolor="#F1EDFE"><?php echo $value['email']; ?></td>
					<td bgcolor="#F1EDFE"><?php echo $value['regtime']; ?></td>
				<?php } else { ?>
					<td><?php echo $index; ?></td>
					<td><img src="<?php echo $value['photo']; ?>" width="62px" height="62px"/></td>
					<td><?php echo $value['username']; ?></td>
					<td><?php echo $value['gender']; ?></td>
					<td><?php echo $value['email']; ?></td>
					<td><?php echo $value['regtime']; ?></td>
				<?php } ?>
				<?php $isColor = !$isColor; ?>
				<?php $index++; ?>
			</tr>
		<?php } ?>
	</table>
	<br/>
	<br/>
	<?php echo $pageStr; ?><br/>
</div>
</body>
</html>
