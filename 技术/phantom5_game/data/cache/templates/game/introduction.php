<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Phantom5</title>
<link href="css/index.css?v=2015.11.6_18.49" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="page2">
	<img src="./images/bg2.jpg" class="bg" />
	<img src="./images/page2/checkbox_empty.png" class="checkboxEmpty" />
	<img src="./images/page2/checkbox_ok.png" class="checkboxOk" />
	<img src="./images/page2/entertainment.png" class="entertainment" />
	<img src="./images/page2/icon.png" class="icon" />
	<img src="./images/page2/line.png" class="line" />
	<p class="t1">Game Rules</p>
	<p class="t2">Play Game, Win TECNO Phantom 5!!!</p>
	<p class="t3"><img src="./images/dot.png" />Play game to get entertaining coins, share 
it on your Facebook. You can invite your 
friends to play the game, the more friends 
you invite, the more coins you will get.</p>
	<p class="t4">Game Time</p>
	<p class="t5"><img src="./images/dot.png" />Nov.9 - Nov.22</p>
	<p class="t6">Prize</p>
	<p class="t7"><img src="./images/dot.png" />3 TECNO Phantom 5</p>
	<p class="t8"><img src="./images/dot.png" />3 Selfie Sticks</p>
	<p class="t9"><img src="./images/dot.png" />4 Flash Disk</p>
	<p class="agree">I AGREE TO THE TERMS OF SERVICE</p>
	<a href="./?m=game&a=main" target="_self">
		<div class="startBtn">
			<img src="./images/page2/fingerprint.png" class="fingerprint" />
			<div class="enter">Click to Start</div>
		</div>
	</a>
</div>
<script>
$(document).ready(function()
{
	resizeWindow();
	$(window).resize(resizeWindow);
});

function resizeWindow()
{
	var winWidth = $(window).width();
	var winHeight = $(window).height();
	var panelHeight = 600;
	var offset = parseInt((winHeight - panelHeight) / 2);
	
	if (offset < 0)
	{
		offset = 0;
	}
	$(".page2").css("margin-top", offset + "px");
}
</script>
<?php echo Config::$countCode; ?>
</body>
</html>
