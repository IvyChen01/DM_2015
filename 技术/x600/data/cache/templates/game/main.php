<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Infinix NOTE 2</title>
<link href="css/index.css?v=2015.11.25_12.08" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
<script src="js/jquery.rotate.min.js" type="text/javascript" language="javascript"></script>
<script src="js/mover.js" type="text/javascript" language="javascript"></script>
<script src="js/game.js?v=2015.11.27_14.36" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="info">
	<img src="images/bg1.jpg" class="bg" />
	<p class="t1">
		- 6 inch screen<br/>
		- Large 4000 mAh battery last for 2 days<br/>
		- Fast charging: 15 min charge 8 hours usage<br/>
		- 13 Mega pixels back camera<br/>
		- Android OS-Lollipop 5.1
	</p>
	<p class="date"><span class="d1">2015</span>&nbsp; 11.16~11.29</p>
	<p class="t2">
		In the infinix website <a href="http://www.infinixmobility.com/" target="_blank">http://www.infinixmobility.com/</a><br/>
		you can participate in the lottery draw and have<br/>
		the opportunity to win Infinix new product<br/>
		and more luxury gifts.
	</p>
	<a id="arrowBtn" href="javascript:void(0);">
		<div class="arrowBtn">
			<p class="arrowTxt">WIN BIG Gift</p>
			<img src="images/down_arrow.png" class="arrowImg" />
		</div>
	</a>
</div>
<div class="lucky">
	<img src="images/bg2.jpg" class="bg" />
	<img src="images/phone.png" class="phone" id="phoneImg" />
	<img id="dot" src="images/dot.png" class="dot" />
	<p class="t1">New Product Launching</p>
	<p class="t2">
		Participating & Winning big gift<br/>
		11.16.2015~11.29.2015
	</p>
	<p class="t3">Activity rules:</p>
	<p class="t4">
		1.Login your personal Facebook<br/>
		2.Like Infinix facebook page<br/>
		3.Each account, have only one<br/>
		opportunity to participate
	</p>
	<a id="loginBtn" href="<?php echo $loginUrl; ?>" target="_self"><img src="images/login.png" class="login" /></a>
	<a id="startBtn" href="javascript:void(0);"><img src="images/start.png" class="start" /></a>
	<a id="myLottery" href="javascript:void(0);"><img src="images/my_lottery.png" class="myLottery" /></a>
</div>
<div class="resultBg"></div>
<div class="result">
	<img class="resultPhone" src="images/result_phone2.png"/>
	<p id="awardName" class="awardName"></p>
	<p id="awardTitle" class="title"></p>
	<p id="awardDesc" class="desc"></p>
	<div class="btn">
		<a id="shareBtn" href="javascript:void(0);"><img class="shareBtn" src="images/result_share.png"/></a>
		<a id="okBtn" href="javascript:void(0);"><img class="okBtn" src="images/like.png"/></a>
	</div>
</div>
<div class="award">
	<div class="titleBar">
		<p class="title">Awards List</p>
	</div>
	<div class="list">
		<ul>
			<?php foreach ($winlist as $value) { ?>
			<?php if (!$isClick && ($fbid == $value['fbid'])) { continue; } ?>
			<?php $date = Utils::mdate('m.d.Y', $value['luckydate']);  ?>
			<li>
				<div class="leftLine"></div>
				<img class="photo" src="<?php echo $value['photo']; ?>"/>
				<div class="nameBox">
					<p class="name"><?php echo $value['username']; ?></p>
					<p class="date"><?php echo $date; ?></p>
				</div>
				<div class="awardName"><?php echo $prize[$value['prizeid'] - 1]; ?></div>
			</li>
			<?php } ?>
		</ul>
		<div class="clear"></div>
	</div>
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
