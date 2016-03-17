<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=0.4, minimum-scale=0.4, maximum-scale=0.4, user-scalable=no" />
<title>Phantom5</title>
<link href="css/mobile_index.css?v=2015.11.13_18.58" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="page12">
	<div id="navBar" class="navBar">
		<div class="bg"></div>
		<a id="menuBtn" href="javascript:void(0);"><img class="menuBtn" src="./images/mobile/menu_btn.png" /></a>
		<div class="username"><?php echo $personal['username']; ?></div>
		<img class="photo" src="<?php echo $photo; ?>" />
	</div>
	<div id="navMenu" class="navMenu">
		<ul>
			<a href="./?m=game&a=main" target="_self"><li><span>Game</span></li></a>
			<a href="./?m=game&a=personal" target="_self"><li><span>Personal Center</span></li></a>
			<a href="./?m=game&a=rank" target="_self"><li><span>Rank</span></li></a>
			<a href="./?m=game&a=rule" target="_self"><li><span class="select">Game Rules</span></li></a>
		</ul>
	</div>
	<img src="./images/mobile/bg.jpg" class="bg" />
	<img src="./images/mobile/page12/bg.png" class="bg2" />
	<img src="./images/mobile/page12/title.png" class="title" />
	<p class="kouHao">Play Game, Win TECNO Phantom 5!!!</p>
	<p class="ruleTxt">Play game to get entertaining coins, share<br/>
it on your Facebook. You can invite your<br/>
friends to play the game, the more friends<br/>
you invite, the more coins you will get.</p>
	<p class="gameTime">Game Time</p>
	<p class="timeTxt">Nov.9 - Nov.22</p>
	<p class="prize">Prize</p>
	<p class="tecnoPhantom">3 TECNO Phantom 5</p>
	<p class="powerBank">3 Selfie Sticks</p>
	<p class="selfieStick">4 Flash Disk</p>
	<a href="./?m=game&a=main" target="_self">
		<img src="./images/mobile/page12/finger.png" class="finger" />
		<p class="returnBtn">Return Previous Page</p>
	</a>
</div>
<script>
$(document).ready(function()
{
	$("#navBar").click(onClickMenu);
});

function onClickMenu(e)
{
	$("#navMenu").slideToggle();
}
</script>
<?php echo Config::$countCode; ?>
</body>
</html>
