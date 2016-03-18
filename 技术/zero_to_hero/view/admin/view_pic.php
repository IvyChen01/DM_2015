<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Picture</title>
<link href="./css/index.min.css?v=2015.5.7_14.37" rel="stylesheet" type="text/css" />
</head>

<body>
<?php if ($_isPic) { ?>
<div class="comment-panel">
	<img class="c-img" src="<?php echo $_picInfo['pic']; ?>" />
	<div class="c-right">
		<div class="c-right-in">
			<div class="c-auth">
				<img class="c-auth-pic" src="<?php echo $_picInfo['photo']; ?>" />
				<div class="c-detail">
					<p class="c-username"><?php echo $_picInfo['username']; ?></p>
					<p class="c-time"><?php echo $_picInfo['upload_time']; ?></p>
				</div>
				<div class="clear"></div>
			</div>
			<div class="c-likes">
				<img src="images/comment_like.png" class="c-likes-img" /><span id="likeNumTxt"><?php echo $_picInfo['num']; ?></span> likes &nbsp;&nbsp;&nbsp;&nbsp;
			</div>
			<ul class="c-list" id="commentList">
				<?php foreach ($_comment as $_row) { ?>
				<li>
					<img class="c-li-photo" src="<?php echo $_row['photo']; ?>" />
					<div class="c-li-detail">
						<p><span class="c-li-name"><?php echo $_row['username']; ?></span> <span class="c-li-commen"><?php echo $_row['content']; ?></span></p>
						<p class="c-li-time"><?php echo $_row['comment_time']; ?></p>
					</div>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?php } else { ?>
404 Not Found!
<?php } ?>

<?php
/*
////// debug
echo '$_picInfo:<br />';
var_dump($_picInfo);
echo '$_comment:<br />';
var_dump($_comment);
echo '$_isLogin: ' . $_isLogin . '<br />';
echo '$_isPic: ' . $_isPic . '<br />';
*/
?>
</body>
</html>
