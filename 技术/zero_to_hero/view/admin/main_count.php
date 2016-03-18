<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Data Counter</title>
<link rel="shortcut icon" href="/images/favicon.ico"/>
<link href="css/admin.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="topbar">
	<span><a href="?m=admin" target="_self">Management Center</a> | <a href="?m=admin&a=logout" target="_self">Exit</a></span>
</div>
<div class="main">
	<h3>Data Counter (<?php echo $_country; ?>)</h3>
	All users: <?php echo $_usersTotal; ?><br/>
	All pictures: <?php echo $_picturesTotal; ?><br/>
	All likes: <?php echo $_likesTotal; ?><br/>
	All comments: <?php echo $_commentsTotal; ?><br/>
	<br/>
	PC web users: <?php echo $_fbUsersTotal; ?><br/>
	PC web pictures: <?php echo $_fbPicturesTotal; ?><br/>
	PC web likes: <?php echo $_fbLikesTotal; ?><br/>
	PC web comments: <?php echo $_fbCommentsTotal; ?><br/>
	<br/>
	Mobile web users: <?php echo $_mwUsersTotal; ?><br/>
	Mobile web pictures: <?php echo $_mwPicturesTotal; ?><br/>
	Mobile web likes: <?php echo $_mwLikesTotal; ?><br/>
	<!--mobile web comments: <?php echo $_mwCommentsTotal; ?><br/>-->
	<br/>
	APK users: <?php echo $_mUsersTotal; ?><br/>
	APK pictures: <?php echo $_mPicturesTotal; ?><br/>
	APK likes: <?php echo $_mLikesTotal; ?><br/>
	APK comments: <?php echo $_mCommentsTotal; ?><br/>
</div>
</body>
</html>
