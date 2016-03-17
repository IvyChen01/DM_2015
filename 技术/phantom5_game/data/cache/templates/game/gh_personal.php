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
<div class="page10">
	<div class="navBar">
		<div class="bg"></div>
		<div class="left">
			<img src="<?php echo $photo; ?>" />
			<span><?php echo $personal['username']; ?></span>
		</div>
		<div class="right">
			<ul>
				<li><a href="./?m=game&a=main" target="_self"><span>Game</span></a></li>
				<li><a href="./?m=game&a=personal" target="_self"><span class="select">Personal Center</span></a></li>
				<li><a href="./?m=game&a=rank" target="_self"><span>Rank</span></a></li>
				<li><a href="./?m=game&a=rule" target="_self"><span>Game Rules</span></a></li>
			</ul>
		</div>
	</div>
	<img src="./images/bg2.jpg" class="bg" />
	<img src="./images/page10/personal_center.png" class="personal_center" />
	<img src="./images/page10/phone.png" class="phone" />
	<img src="./images/page10/smile_face.png" class="smile_face" />
	<div class="friendsTip">You have got from your invited friends</div>
	<div class="friendsScore"><span id="friendsScoreTxt"><?php echo $personal['friendscore']; ?></span><img src="./images/page10/gem6.png" /></div>
	<div class="totalTip">Your total coins are</div>
	<div class="totalScore"><span id="totalScoreTxt"><?php echo $personal['totalscore']; ?></span><img src="./images/page10/gem6.png" /></div>
	<a href="javascript:void(0);" id="shareBtn">
		<img src="./images/page10/facebook.png" class="facebook" />
		<img src="./images/button_bg.png" class="shareBg" />
		<div class="shareTxt">Share To Facebook</div>
	</a>
	<a href="./?m=game&a=rank" target="_self">
		<img src="./images/page10/fingerprint.png" class="fingerprint" />
		<img src="./images/button_bg.png" class="rankBg" />
		<div class="rankTxt">Check Your Rank</div>
	</a>
	<div class="list">
		<ul>
			<?php foreach ($daily as $value) { ?>
			<li>
				<img src="<?php echo $photo; ?>" class="photo" />
				<span class="date"><?php echo Utils::mdate('Y.m.d', $value['playtime']); ?></span>
				<img src="./images/page10/gem6.png" class="gem" />
				<span class="coin"><?php echo $value['score']; ?></span>
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
<input type="hidden" id="isFb" value="<?php if (Config::$isFb) { echo 1; } else { echo 0; } ?>" />
<input type="hidden" id="appId" value="<?php echo Config::$fbAppId; ?>" />
<input type="hidden" id="shareUrl" value="<?php echo Config::$shareUrl; ?>" />
<input type="hidden" id="sharePic" value="<?php echo Config::$sharePic; ?>" />

<script>
var isFb = false;
var appId = '';
var shareUrl = '';
var sharePic = '';

$(document).ready(function()
{
	isFb = ($("#isFb").val() == 1) ? true : false;
	appId = $("#appId").val();
	shareUrl = $("#shareUrl").val();
	sharePic = $("#sharePic").val();
	
	resizeWindow();
	$(window).resize(resizeWindow);
	$("#shareBtn").click(onClickShare);
	
	if (isFb)
	{
		window.fbAsyncInit = function()
		{
			FB.init({
				appId: appId,
				status: true,
				cookie: true,
				xfbml: true
			});
		};
		
		(function(d, s, id)
		{
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	}
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
	$(".page10").css("margin-top", offset + "px");
}

function onClickShare(e)
{
	feed(shareUrl, sharePic);
}

function login()
{
	FB.login(function(response){ document.location.href = "./?m=game&a=introduction"; });
}

function feed(link, picture)
{
	if (!isFb)
	{
		window.open(link);
		return;
	}
	FB.ui(
	{
		method: 'feed',
		name: 'Phantom5',
		link: link,
		picture: picture,
		caption: 'www.tecno-mobile.com',
		description: 'Play Game, Win prizes from TECNO!!!'
	},
	function(response) {
		//alert("Succeed!");
	});
}

function invite()
{
	FB.ui({method: 'apprequests',
	  message: 'Tecno'
	}, function (response){});
}

function addPage(redirect_uri)
{
	FB.ui({
	  method: 'pagetab',
	  redirect_uri: redirect_uri
	}, function(response){});
}
</script>
<?php echo Config::$countCode; ?>
</body>
</html>
