<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
<title>Infinix NOTE 2</title>
<link href="css/mobile_index.css?v=2015.11.25_12.08" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
<script src="js/jquery.rotate.min.js" type="text/javascript" language="javascript"></script>
<script src="js/mover.js" type="text/javascript" language="javascript"></script>
<script src="js/mobile_game.js?v=2015.11.27_9.40" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="info">
	<a href="<?php echo $loginUrl; ?>" target="_self">
		<img class="note2" src="images/mobile/note2.jpg"/>
		<img class="main" src="images/mobile/main.jpg"/>
	</a>
	<p class="date"><span class="year">2015</span>&nbsp; 11.16~11.29</p>
	<p class="desc">In the infinix website <br/>
	<a href="http://www.infinixmobility.com/" target="_blank">http://www.infinixmobility.com/</a><br/>
you can participate in the lottery draw and have <br/>
the opportunity to win Infinix new product and <br/>
more luxury gifts.</p>
</div>
<div class="pan">
	<img class="bg" src="images/mobile/pan_bg.jpg"/>
	<img id="phoneImg" class="phone" src="images/mobile/phone.png"/>
	<img id="dot" src="images/mobile/dot.png" class="dot" />
	<a id="satartBtn" href="javascript:void(0);"><img class="start" src="images/mobile/start_btn.png"/></a>
	<a id="winnersBtn" href="javascript:void(0);"><img class="award" src="images/mobile/award_btn.png"/></a>
	<div class="winDlg">
		<div class="bg"></div>
		<img class="phone" src="images/mobile/win_phone.png"/>
		<p id="awardName" class="awardName"></p>
		<p id="awardTitle" class="title"></p>
		<p id="awardDesc" class="desc"></p>
		<a id="shareBtn" href="javascript:void(0);"><img class="shareBtn" src="images/mobile/share_btn.png"/></a><br/>
		<a id="likeBtn" href="javascript:void(0);"><img class="likeBtn" src="images/mobile/like_btn.png"/></a>
	</div>
</div>
<div class="winners">
	<div class="title">Awards List</div>
	<ul>
		<?php foreach ($winlist as $value) { ?>
		<?php if (!$isClick && ($fbid == $value['fbid'])) { continue; } ?>
		<?php $date = Utils::mdate('m.d.Y', $value['luckydate']);  ?>
		<li>
			<div class="leftLine"></div>
			<img class="photo" src="<?php echo $value['photo']; ?>"/>
			<p class="name"><?php echo $value['username']; ?></p>
			<p class="date"><?php echo $date; ?></p>
			<p class="prizeName"><?php echo $prize[$value['prizeid'] - 1]; ?></p>
		</li>
		<?php } ?>
	</ul>
</div>
<input type="hidden" id="isLocal" value="<?php if (Config::$isLocal) { echo 1; } else { echo 0; } ?>" />
<input type="hidden" id="isFb" value="<?php if (Config::$isFb) { echo 1; } else { echo 0; } ?>" />
<input type="hidden" id="appId" value="<?php echo Config::$fbAppId; ?>" />
<input type="hidden" id="shareUrl" value="<?php echo Config::$shareUrl; ?>" />
<input type="hidden" id="sharePic" value="<?php echo Config::$sharePic; ?>" />

<input type="hidden" id="isLogin" value="<?php echo $isLogin; ?>" />
<input type="hidden" id="isClick" value="<?php echo $isClick; ?>" />
<input type="hidden" id="prizeId" value="<?php echo $prizeId; ?>" />
<input type="hidden" id="prizeName" value="<?php echo $prizeName; ?>" />
<?php echo Config::$countCode; ?>
</body>
</html>
