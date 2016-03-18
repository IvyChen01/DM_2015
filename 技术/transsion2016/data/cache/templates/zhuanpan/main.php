<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
<title>传音年会大福利</title>
<link href="<?php echo Config::$resUrl; ?>/css/zhuan_pan.css?v=2016.1.19_15.58" rel="stylesheet" type="text/css" />
<script src="<?php echo Config::$resUrl; ?>/js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo Config::$resUrl; ?>/js/jquery.rotate.min.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo Config::$resUrl; ?>/js/mover-1.1.1.js?v=2016.1.19_15.58" type="text/javascript" language="javascript"></script>
<script src="<?php echo Config::$resUrl; ?>/js/lucky.js?v=2016.1.20_14.43" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="box">
	<img src="<?php echo Config::$resUrl; ?>/images/big3/bg.jpg" class="bg" />
	<div id="zhuanPan">
		<a id="start" href="javascript:void(0);">
			<img src="<?php echo Config::$resUrl; ?>/images/big3/pan.png?v=2016.1.19_18.38" id="pan" />
			<img src="<?php echo Config::$resUrl; ?>/images/big3/start.png" class="startBtn" />
		</a>
		<p id="restTxt"><?php echo $restLucky; ?></p>
	</div>
	<div id="mask"></div>
	<div id="loginPanel">
		<img src="<?php echo Config::$resUrl; ?>/images/big3/login.png" class="loginBg" />
		<a href="javascript:void(0);"><img src="<?php echo Config::$resUrl; ?>/images/big3/login_btn.png" id="loginBtn" /></a>
		<input type="text" id="jobnumTxt" />
		<input type="text" id="usernameTxt" />
	</div>
	<div id="winPanel">
		<img src="<?php echo Config::$resUrl; ?>/images/big3/dialog_bg.png" class="winBg" />
		<img src="<?php echo Config::$resUrl; ?>/images/big3/title_win.png" class="winTitle" />
		<div class="winpicBox">
			<img src="" id="winPic" />
		</div>
		<p id="winTxt"></p>
	</div>
	<div id="losePanel">
		<img src="<?php echo Config::$resUrl; ?>/images/big3/dialog_bg.png" class="loseBg" />
		<img src="<?php echo Config::$resUrl; ?>/images/big3/title_lose.png" class="loseTitle" />
		<div class="losepicBox">
			<img src="<?php echo Config::$resUrl; ?>/images/big3/<?php echo $losePic; ?>" class="losePic" />
		</div>
	</div>
</div>
<input type="hidden" id="restLucky" value="<?php echo $restLucky; ?>" />
<input type="hidden" id="isLogin" value="<?php if ($isLogin) { echo 1; } else { echo 0; } ?>" />
<input type="hidden" id="isLockTime" value="<?php if ($isLockTime) { echo 1; } else { echo 0; } ?>" />
</body>
</html>
