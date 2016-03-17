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
<div class="page11">
	<div class="navBar">
		<div class="bg"></div>
		<div class="left">
			<img src="<?php echo $photo; ?>" />
			<span><?php echo $personal['username']; ?></span>
		</div>
		<div class="right">
			<ul>
				<li><a href="./?m=game&a=main" target="_self"><span>Game</span></a></li>
				<li><a href="./?m=game&a=personal" target="_self"><span>Personal Center</span></a></li>
				<li><a href="./?m=game&a=rank" target="_self"><span class="select">Rank</span></a></li>
				<li><a href="./?m=game&a=rule" target="_self"><span>Game Rules</span></a></li>
			</ul>
		</div>
	</div>
	<img src="./images/bg2.jpg" class="bg" />
	<img src="./images/page11/game_rank.png" class="game_rank" />
	<img src="./images/page11/phone.png" class="phone" />
	<a href="./?m=game&a=rule" target="_self">
		<img src="./images/page11/fingerprint.png" class="fingerprint" />
		<img src="./images/button_bg.png" class="rulesBg" />
		<div class="ruleTxt">See you Tomorrow</div>
	</a>
	<div class="list">
		<ul>
			<?php foreach ($rank as $value) { ?>
			<li>
				<?php if ($value['isSelf']) { ?>
				<div class="selectFrame"></div>
				<div class="selectBg"></div>
				<?php } ?>
				<?php if ($value['rank'] <= 3) { ?>
				<img src="./images/page11/<?php echo $value['rank']; ?>.png" class="guang" />
				<?php } else { ?>
				<span class="rankNum"><?php echo $value['rank']; ?></span>
				<?php } ?>
				<img src="<?php echo $value['photo']; ?>" class="photo" />
				<span class="name"><?php echo $value['username']; ?></span>
				<img src="./images/page10/gem6.png" class="gem" />
				<span class="coin"><?php echo $value['totalscore']; ?></span>
			</li>
			<?php } ?>
		</ul>
	</div>
	<a href="<?php echo $prevLink; ?>" target="_self">
		<img src="./images/arrow_bold_left.png" class="arrow_bold_left" />
		<img src="./images/arrow_left.png" class="arrow_left" />
	</a>
	<a href="<?php echo $nextLink; ?>" target="_self">
		<img src="./images/arrow_bold_right.png" class="arrow_bold_right" />
		<img src="./images/arrow_right.png" class="arrow_right" />
	</a>
	<div class="page"><?php echo $pageStr; ?></div>
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
	$(".page11").css("margin-top", offset + "px");
}
</script>
<?php echo Config::$countCode; ?>
</body>
</html>
