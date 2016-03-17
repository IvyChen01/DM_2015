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
<div class="page11">
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
			<a href="./?m=game&a=rank" target="_self"><li><span class="select">Rank</span></li></a>
			<a href="./?m=game&a=rule" target="_self"><li><span>Game Rules</span></li></a>
		</ul>
	</div>
	<img src="./images/mobile/bg.jpg" class="bg" />
	<img src="./images/mobile/page11/title.png" class="title" />
	<img src="./images/mobile/line.png" class="line1" />
	<img src="./images/mobile/line.png" class="line2" />
	<img src="./images/mobile/line.png" class="line3" />
	<div class="list">
		<ul>
			<?php foreach ($rank as $value) { ?>
			<li>
				<?php if ($value['isSelf']) { ?>
				<div class="selectFrame"></div>
				<div class="selectBg"></div>
				<?php } ?>
				<?php if ($value['rank'] <= 3) { ?>
				<img src="./images/mobile/page11/<?php echo $value['rank']; ?>.png" class="guang" />
				<?php } else { ?>
				<span class="rankNum"><?php echo $value['rank']; ?></span>
				<?php } ?>
				<img src="<?php echo $value['photo']; ?>" class="photo" />
				<span class="name"><?php echo $value['username']; ?></span>
				<img src="./images/mobile/page10/gem1.png" class="gem" />
				<span class="coin"><?php echo $value['totalscore']; ?></span>
			</li>
			<?php } ?>
		</ul>
	</div>
	<a href="<?php echo $prevLink; ?>" target="_self">
		<img src="./images/mobile/left.png" class="leftBtn" />
	</a>
	<a href="<?php echo $nextLink; ?>" target="_self">
		<img src="./images/mobile/right.png" class="rightBtn" />
	</a>
	<div class="page"><?php echo $pageStr; ?></div>
	<a href="./?m=game&a=rule" target="_self">
		<img src="./images/mobile/finger_rank.png" class="fingerprint" />
		<div class="ruleTxt">See you Tomorrow</div>
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
