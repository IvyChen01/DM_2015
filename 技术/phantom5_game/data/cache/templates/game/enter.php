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
<div class="page1">
	<img src="./images/bg1.jpg" class="bg" />
	<img src="./images/page1/entertainment.png" class="entertainment" />
	<img src="./images/page1/headset.png" class="headset" />
	<img src="./images/page1/icon.png" class="icon" />
	<img src="./images/page1/left_bottom.png" class="left_bottom" />
	<img src="./images/page1/left_top.png" class="left_top" />
	<img src="./images/page1/line.png" class="line" />
	<img src="./images/page1/rec.png" class="rec" />
	<img src="./images/page1/right_bottom.png" class="right_bottom" />
	<img src="./images/page1/right_top.png" class="right_top" />
	<a href="<?php echo $loginUrl; ?>" target="_self">
		<img src="./images/page1/fingerprint.png" class="fingerprint" />
		<img src="./images/page1/phone.png" class="phone" />
		<div class="title">Be Entertained with TECNO Phantom 5</div>
		<div class="footer">Explore the map of entertainment from the fingertip</div>
		<div class="enter">Click to Enter</div>
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
	$(".page1").css("margin-top", offset + "px");
}
</script>
<?php echo Config::$countCode; ?>
</body>
</html>
