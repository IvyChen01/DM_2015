<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=0.4, minimum-scale=0.4, maximum-scale=0.4, user-scalable=no" />
<title>Phantom5</title>
<link href="css/mobile_index.css?v=2015.11.13_18.58" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
<script src="js/touche.min.js" type="text/javascript" language="javascript"></script>
<script src="js/mover.js?v=2015.11.6_18.49" type="text/javascript" language="javascript"></script>
<script src="js/mobile_game.js?v=2015.11.13_18.58" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="game">
	<div id="navBar" class="navBar">
		<div class="bg"></div>
		<a id="menuBtn" href="javascript:void(0);"><img class="menuBtn" src="./images/mobile/menu_btn.png" /></a>
		<div class="username"><?php echo $personal['username']; ?></div>
		<img class="photo" src="<?php echo $photo; ?>" />
	</div>
	<div id="navMenu" class="navMenu">
		<ul>
			<a href="./?m=game&a=main" target="_self"><li><span class="select">Game</span></li></a>
			<a href="./?m=game&a=personal" target="_self"><li><span>Personal Center</span></li></a>
			<a href="./?m=game&a=rank" target="_self"><li><span>Rank</span></li></a>
			<a href="./?m=game&a=rule" target="_self"><li><span>Game Rules</span></li></a>
		</ul>
	</div>
	<div id="coinBar" class="coin">
		<span class="coinNum">0</span>
		<img class="gem2" src="./images/mobile/gem.png" />
	</div>
	<div id="loadingPanel" class="page3">
		<img src="./images/mobile/bg.jpg" class="bg" />
		<img src="./images/mobile/page3/fingerprint.png" class="fingerprint" />
		<img src="./images/mobile/page3/tecno.png" class="tecno" />
		<img src="./images/loading.gif" class="loading" />
		<p class="loadingTxt">Loading...</p>
		<p class="loadDesc">from TECNO Phantom 5 Finger Sensor</p>
	</div>
	<div id="missionPanel" class="page4">
		<img src="./images/mobile/bg.jpg" class="bg" />
		<img src="./images/mobile/page4/dialog.png" class="dialogBg" />
		<p class="title">Your Mission</p>
		<p class="desc">Play game to get coins, share you<br/>
		rank on Facebook and invite your friends to<br/>
		play to get more coins. The more coins you<br/>
		get, the bigger chance you will have to get<br/>
		a prizes from TECNO.</p>
		<a href="javascript:void(0);" id="missionBtn">
			<p class="btn">Continue</p>
		</a>
	</div>
	<div id="hifiPanel" class="page5">
		<img src="./images/mobile/bg.jpg" class="bg" />
		<p class="title">PLAY GAME TO WIN<br/>
		prizes from TECNO</p>
		<p class="content">Entertain yourself with HI-FI music</p>
		<img src="./images/mobile/page5/music_icon.png" class="musicIcon" />
		<a href="javascript:void(0);" id="hifiBtn">
			<img src="./images/mobile/page5/phone.png" class="phone" />
			<p class="continue">Continue</p>
		</a>
	</div>
	<div id="cameraPanel" class="page6">
		<img src="./images/mobile/page6/bg.jpg" class="bg" />
		<p class="title">PLAY GAME TO WIN<br/>
		prizes from TECNO</p>
		<p class="content">Entertain yourself with 13MP back<br/>
		camera & 8.0MP camera</p>
		<a href="javascript:void(0);" id="cameraBtn">
			<img src="./images/mobile/page6/phone.png" class="phone" />
			<p class="continue">Continue</p>
		</a>
	</div>
	<div id="gamePanel" class="page7">
		<img src="./images/mobile/bg.jpg" class="bg" />
		<div class="timeTxt">60 s</div>
		<img src="./images/mobile/line.png" class="line1" />
		<img src="./images/mobile/line.png" class="line2" />
		<a href="javascript:void(0);">
			<div class="iconBox">
				<img src="./images/mobile/page7/cemera.png" />
				<img src="./images/mobile/page7/dataline.png" />
				<img src="./images/mobile/page7/diamond.png" />
				<img src="./images/mobile/page7/fingerprint.png" />
				<img src="./images/mobile/page7/green_rock.png" />
				<img src="./images/mobile/page7/headset.png" />
				<img src="./images/mobile/page7/lte.png" />
				<img src="./images/mobile/page7/oxygen_bottle.png" />
				<img src="./images/mobile/page7/phone.png" />
				<img src="./images/mobile/page7/red_rock.png" />
				<img src="./images/mobile/page7/spaceship.png" />
				<img src="./images/mobile/page7/star.png" />
				<img src="./images/mobile/page7/yellow_rock.png" />
				
				<img src="./images/mobile/page7/cemera.png" />
				<img src="./images/mobile/page7/dataline.png" />
				<img src="./images/mobile/page7/diamond.png" />
				<img src="./images/mobile/page7/fingerprint.png" />
				<img src="./images/mobile/page7/green_rock.png" />
				<img src="./images/mobile/page7/headset.png" />
				<img src="./images/mobile/page7/lte.png" />
				<img src="./images/mobile/page7/oxygen_bottle.png" />
				<img src="./images/mobile/page7/phone.png" />
				<img src="./images/mobile/page7/red_rock.png" />
				<img src="./images/mobile/page7/spaceship.png" />
				<img src="./images/mobile/page7/star.png" />
				<img src="./images/mobile/page7/yellow_rock.png" />
			</div>
			<div class="ready">Click icon to get coins!</div>
			<div class="addScore">+0</div>
		</a>
	</div>
	<div id="winPanel" class="page8">
		<img src="./images/mobile/bg.jpg" class="bg" />
		<img src="./images/mobile/page8/win_dialog.png" class="dialog" />
		<div class="title">Congratulations</div>
		<div class="describe">You just got <span class="coinNum">0</span> coins!</div>
		<a href="javascript:void(0);" id="winShareBtn">
			<img src="./images/mobile/share.png" class="share_icon" />
			<div class="shareTxt">Share</div>
		</a>
		<a href="javascript:void(0);" id="winContinueBtn">
			<div class="continueTxt">Continue</div>
		</a>
	</div>
	<div id="friendPanel" class="page9">
		<img src="./images/mobile/bg.jpg" class="bg" />
		<img src="./images/mobile/page9/share_dialog.png" class="dialog" />
		<div class="title">You’ve got <span class="coinNum">0</span> coins today!</div>
		<div class="describe">Invite your friends to play the game.<br/>
		If your friend enters the<br/>
		game from the link you shared,<br/>
		both you and your friend<br/>
		will get 20000 coins! <br/>
		<p class="welcome">Welcome back tomorrow to get more coins!</p></div>
		<a href="javascript:void(0);" id="friendShareBtn">
			<img src="./images/mobile/share.png" class="share_icon" />
			<div class="shareTxt">Share</div>
		</a>
		<a href="./?m=game&a=personal" target="_self">
			<div class="continueTxt">Continue</div>
		</a>
	</div>
</div>
<input type="hidden" id="isLocal" value="<?php if (Config::$isLocal) { echo 1; } else { echo 0; } ?>" />
<input type="hidden" id="isFb" value="<?php if (Config::$isFb) { echo 1; } else { echo 0; } ?>" />
<input type="hidden" id="appId" value="<?php echo Config::$fbAppId; ?>" />
<input type="hidden" id="shareUrl" value="<?php echo Config::$shareUrl; ?>" />
<input type="hidden" id="sharePic" value="<?php echo Config::$sharePic; ?>" />
<input type="hidden" id="isPlayed" value="<?php echo $isPlayed; ?>" />
<input type="hidden" id="todayScore" value="<?php echo $todayScore; ?>" />
<?php echo Config::$countCode; ?>
</body>
</html>
