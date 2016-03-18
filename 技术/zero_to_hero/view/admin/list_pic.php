<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Picture Management</title>
<link rel="shortcut icon" href="/images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">Management Center</a> | <a href="?m=admin&a=logout" target="_self">Exit</a></span>
</div>
<div class="pic-box">
	<h3>Picture Management</h3>
	<div class="pic-pagelist"><?php echo $_pagelist;?></div>
	<div class="pic-list">
		<?php $_index = ($_page - 1) * $_pagesize + 1; ?>
		<?php foreach ($_data as $_row) { ?>
		<div class="pic-item">
			<a href="<?php echo $_appUrl; ?>?m=fbzero&a=viewPic&picId=<?php echo $_row['pic_id']; ?>" target="_blank"><img class="l-pic" src="<?php echo $_row['small_pic']; ?>" /></a>
			<div class="r-box">
				<p><?php echo $_index; ?>.</p>
				<img src="<?php echo $_row['photo']; ?>" width="50px" height="50px" />
				<p>Name: <?php echo $_row['username']; ?></p>
				<p>Tel: <?php echo $_row['phone']; ?></p>
				<p>Email: <?php echo $_row['email']; ?></p>
				<!--<p>上传日期: <?php echo Utils::mdate('Y-m-d', $_row['upload_time']);?></p>-->
				<p>Likes: <?php echo $_row['num']; ?></p>
				<p><a href="<?php echo $_appUrl; ?>?m=fbzero&a=viewPic&picId=<?php echo $_row['pic_id']; ?>" target="_blank">[View]</a> | <a href="?m=adminZero&a=deletePic&id=<?php echo $_row['pic_id']; ?>&page=<?php echo $_page; ?>" target="_self">[Delete]</a></p>
			</div>
		</div>
		<?php $_index++; ?>
		<?php } ?>
		<div class="clear"></div>
	</div>
	<div class="pic-pagelist"><?php echo $_pagelist;?></div>
</div>
</body>
</html>
