<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=0.4, minimum-scale=0.4, maximum-scale=0.4, user-scalable=no" />
<title>itel survey</title>
<link href="css/game.css?v=2015.12.25_14.04" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
<script src="js/jquery.rotate.min.js" type="text/javascript" language="javascript"></script>
<script src="js/mover.js" type="text/javascript" language="javascript"></script>
<script src="js/lucky.js?v=2015.12.25_14.04" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="lucky">
	<img src="images/h2.jpg" class="h2" />
	<div class="t1"><p><img src="images/icon_time.jpg" class="icon_time" /> Temps de jeu:12.25-12.31</p></div>
	<div class="t2">
		<img src="images/icon_gift.jpg" class="icon_gift" />
		<p>Lots a gagner :<br />
		Le 1er lot est le it 1505<br />
		Le 2nd lot  est le it 1407<br />
		Le troisième est Un parapluie Itel<br />
		Un T-shirt, Le baton de selfie</p>
	</div>
	<div class="t3"><div class="sign"></div><p>&nbsp;CLIQUER SUR JOUER ET GAGNER</p></div>
	<a id="startBtn" href="javascript:void(0);">
	<div class="pan">
		<img id="pan" src="images/pan.png" class="panBg" />
		<img src="images/pin.png" class="pin" />
		<img src="images/start.png" class="start" />
	</div>
	</a>
	<div class="footer">
		<img src="images/icon_flower.jpg" class="icon_flower" />
		<p class="t4">Si vous partagez cette enquête sur votre
page Facebook, ainsi vous pourrez avoir une 
chance supplémentaire d'être sélectionné. </p>
		<a id="shareBtn" href="javascript:void(0);">
		<div class="shareBtn">
			<p>Share To Facebook</p>
		</div>
		</a>
	</div>
	<div id="mask" class="mask"></div>
	<div id="winDlg" class="win">
		<div class="bg"></div>
		<img class="awardIcon" src="images/icon_win.png" />
		<p class="title">Félicitations! </p>
		<p class="content">Félicitations! Votre prix est <span id="awardName"></span> !</p>
		<div class="bottom"></div>
		<img class="shareIcon" src="images/icon_share.png" />
		<p class="shareTxt">Share</p>
	</div>
	<div id="loseDlg" class="win">
		<div class="bg"></div>
		<img class="awardIcon" src="images/icon_lose.png" />
		<p class="title">Si vous ne gagnez pas</p>
		<p class="content">essayez encore !</p>
		<div class="bottom"></div>
		<img class="shareIcon" src="images/icon_share.png" />
		<p class="shareTxt">Share</p>
	</div>
</div>
<input type="hidden" id="isFb" value="<?php if (Config::$isFb) { echo 1; } else { echo 0; } ?>" />
<input type="hidden" id="appId" value="<?php echo Config::$fbAppId; ?>" />
<input type="hidden" id="shareUrl" value="<?php echo Config::$shareUrl; ?>" />
<input type="hidden" id="sharePic" value="<?php echo Config::$sharePic; ?>" />
<input type="hidden" id="restLucky" value="<?php echo $restLucky; ?>" />
<input type="hidden" id="prizeId" value="<?php echo $prizeId; ?>" />
<?php echo Config::$countCode; ?>
</body>
</html>
