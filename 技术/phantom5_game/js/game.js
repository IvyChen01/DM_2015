var isLocal = false;
var isFb = false;
var appId = '';
var shareUrl = '';
var sharePic = '';
var isPlayed = false;
var todayScore = 0;
var loadingPanel = null;
var navBar = null;
var coinBar = null;
var missionPanel = null;
var missionBtn = null;
var hifiPanel = null;
var hifiBtn = null;
var cameraPanel = null;
var cameraBtn = null;
var gamePanel = null;
var winPanel = null;
var winShareBtn = null;
var winContinueBtn = null;
var friendPanel = null;
var friendShareBtn = null;
var allCoinTxt = null;
var winCoinTxt = null;
var friendCoinTxt = null;

var readyTxt = null;
var timeTxt = null;
var addScoreTxt = null;
var readyTimer = null;
var timeTimer = null;
var readyTime = 3;
var restTime = 60;
var iconArr = null;
var icon = null;
var iconPool = null;
var iconBoxWidth = 740;
var iconBoxHeight = 400;
var randTop = 0;
var moverArr = null;
var mover = null;
var moverTimer = null;
var pushTimer = null;
var totalScore = 0;
var coinScore = 0;
var scoreArr = [3000, 4000, 3000, 5000, 1000, 2000, 2000, 2000, 5000, 1000, 3000, 3000, 1000,      3000, 4000, 3000, 5000, 1000, 2000, 2000, 2000, 5000, 1000, 3000, 3000, 1000];
var missionScore = 2000;
var hifiScore = 4000;
var cameraScore = 9000;

$(document).ready(function()
{
	isLocal = ($("#isLocal").val() == 1) ? true : false;
	isFb = ($("#isFb").val() == 1) ? true : false;
	appId = $("#appId").val();
	shareUrl = $("#shareUrl").val();
	sharePic = $("#sharePic").val();
	isPlayed = ($("#isPlayed").val() == 1) ? true : false;
	todayScore = $("#todayScore").val();
	loadingPanel = $("#loadingPanel");
	navBar = $("#navBar");
	coinBar = $("#coinBar");
	missionPanel = $("#missionPanel");
	missionBtn = $("#missionBtn");
	hifiPanel = $("#hifiPanel");
	hifiBtn = $("#hifiBtn");
	cameraPanel = $("#cameraPanel");
	cameraBtn = $("#cameraBtn");
	gamePanel = $("#gamePanel");
	winPanel = $("#winPanel");
	winShareBtn = $("#winShareBtn");
	winContinueBtn = $("#winContinueBtn");
	friendPanel = $("#friendPanel");
	friendShareBtn = $("#friendShareBtn");
	allCoinTxt = $("#coinBar .coinNum");
	winCoinTxt = $("#winPanel .coinNum");
	friendCoinTxt = $("#friendPanel .coinNum");
	readyTxt = $("#gamePanel .ready");
	timeTxt = $("#gamePanel .timeTxt");
	addScoreTxt = $("#gamePanel .addScore");
	
	if (isPlayed)
	{
		allCoinTxt.text(todayScore);
		friendCoinTxt.text(todayScore);
	}
	
	if (isLocal)
	{
		setTimeout(loadComplete, 1000);
	}
	else
	{
		$(window).load(loadComplete);
	}
	
	missionBtn.click(onClickMission);
	hifiBtn.click(onClickHifi);
	cameraBtn.click(onClickCamera);
	winShareBtn.click(onClickWinShare);
	winContinueBtn.click(onClickWinContinue);
	friendShareBtn.click(onClickFriendShare);
	resizeWindow();
	$(window).resize(resizeWindow);
	
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
	$(".game").css("margin-top", offset + "px");
}

function onPush()
{
	var rand = 0;
	var iconIndex = 0;
	var minLeft = 100;
	var maxLeft = iconBoxWidth - 100;
	var randX = 0;
	
	if (iconPool.length > 0)
	{
		rand = parseInt(Math.random() * iconPool.length);
		iconIndex = iconPool[rand];
		iconPool.splice(rand, 1);
		icon = iconArr.eq(iconIndex);
		randTop = parseInt(Math.random() * iconBoxHeight);
		icon.css("left", "-100px");
		icon.css("top", randTop + "px");
		icon.show();
		mover = moverArr[iconIndex];
		mover.currentPlace = -100;
		randX = parseInt(Math.random() * (maxLeft - minLeft)) + minLeft;
		mover.down2To(randX, randX + 20, iconBoxWidth + 200);
	}
}

function onMove()
{
	for (var i=0; i<iconArr.length; i++)
	{
		mover = moverArr[i];
		icon = iconArr.eq(i);
		if (mover.moving)
		{
			mover.move();
			icon.css("left", mover.currentPlace + "px");
			if (!mover.moving)
			{
				iconPool.push(i);
			}
		}
	}
}

function loadComplete(e)
{
	loadingPanel.fadeOut("normal", showGame);
}

function showGame()
{
	if (isPlayed)
	{
		friendPanel.fadeIn();
	}
	else
	{
		missionPanel.fadeIn();
	}
}

function onClickMission(e)
{
	missionPanel.fadeOut("normal", showHifi);
	totalScore += missionScore;
	allCoinTxt.text(totalScore);
}

function showHifi()
{
	$("#hifiBtn").hide();
	$(".page5 .entertain").css("opacity", 0);
	$(".page5 .headset").css("opacity", 0);
	$(".page5 .phone").css("opacity", 0);
	$(".page5 .player").css("opacity", 0);
	$(".page5 .playgameto").css("opacity", 0);
	$(".page5 .listen").css("opacity", 0);
	hifiPanel.fadeIn("normal", showHifi1);
}

function showHifi1()
{
	var entertain = parseInt($(".page5 .entertain").css("left"));
	var headset = parseInt($(".page5 .headset").css("left"));
	var phone = parseInt($(".page5 .phone").css("left"));
	var player = parseInt($(".page5 .player").css("top"));
	var playgameto = parseInt($(".page5 .playgameto").css("left"));
	var listen = parseInt($(".page5 .listen").css("top"));
	var offset = 200;
	
	$(".page5 .entertain").css("left", entertain + offset);
	$(".page5 .headset").css("left", headset - offset);
	$(".page5 .phone").css("left", phone - offset);
	$(".page5 .player").css("top", player + offset);
	$(".page5 .playgameto").css("left", playgameto + offset);
	$(".page5 .listen").css("top", listen + offset);
	$(".page5 .entertain").css("opacity", 0);
	$(".page5 .headset").css("opacity", 0);
	$(".page5 .phone").css("opacity", 0);
	$(".page5 .player").css("opacity", 0);
	$(".page5 .playgameto").css("opacity", 0);
	$(".page5 .listen").css("opacity", 0);
	$(".page5 .entertain").animate({opacity: 1, left: entertain}, 1000);
	$(".page5 .headset").animate({opacity: 1, left: headset}, 1000);
	$(".page5 .phone").animate({opacity: 1, left: phone}, 1000);
	$(".page5 .player").animate({opacity: 1, top: player}, 1000);
	$(".page5 .playgameto").animate({opacity: 1, left: playgameto}, 1000);
	$(".page5 .listen").animate({opacity: 1, top: listen}, 1000, null, showHifi2);
}

function showHifi2()
{
	$("#hifiBtn").fadeIn(1500);
}

function onClickHifi(e)
{
	hifiPanel.fadeOut("normal", showCamera);
	totalScore += hifiScore;
	allCoinTxt.text(totalScore);
}

function showCamera()
{
	$("#cameraBtn").hide();
	$(".page6 .entertain").css("opacity", 0);
	$(".page6 .phone_cemera").css("opacity", 0);
	$(".page6 .play_game").css("opacity", 0);
	cameraPanel.fadeIn("normal", showCamera1);
}

function showCamera1()
{
	var entertain = parseInt($(".page6 .entertain").css("left"));
	var phone_cemera = parseInt($(".page6 .phone_cemera").css("left"));
	var play_game = parseInt($(".page6 .play_game").css("left"));
	var offset = 200;
	
	$(".page6 .entertain").css("left", entertain + offset);
	$(".page6 .phone_cemera").css("left", phone_cemera - offset);
	$(".page6 .play_game").css("left", play_game + offset);
	$(".page6 .entertain").css("opacity", 0);
	$(".page6 .phone_cemera").css("opacity", 0);
	$(".page6 .play_game").css("opacity", 0);
	$(".page6 .entertain").animate({opacity: 1, left: entertain}, 1000);
	$(".page6 .phone_cemera").animate({opacity: 1, left: phone_cemera}, 1000);
	$(".page6 .play_game").animate({opacity: 1, left: play_game}, 1000, null, showCamera2);
}

function showCamera2()
{
	$("#cameraBtn").fadeIn(1500);
}

function onClickCamera(e)
{
	cameraPanel.fadeOut("normal", showCoinGame);
	totalScore += cameraScore;
	allCoinTxt.text(totalScore);
}

function showCoinGame()
{
	readyTxt.hide();
	gamePanel.fadeIn("normal", showReady);
}

function showReady()
{
	readyTxt.fadeIn();
	setTimeout(showTime, 3000);
}

function showTime()
{
	readyTxt.fadeOut();
	readyTimer = setInterval(onReadyTimer, 1000);
}

function onReadyTimer()
{
	if (readyTime > 0)
	{
		readyTxt.hide();
		readyTxt.css("font-size", "150px");
		readyTxt.text(readyTime);
		readyTxt.fadeIn();
		readyTime--;
	}
	else
	{
		readyTxt.hide();
		clearInterval(readyTimer);
		startGame();
	}
}

function startGame()
{
	iconArr = $("#gamePanel .iconBox img");
	iconPool = [];
	moverArr = [];
	for (var i=0; i<iconArr.length; i++)
	{
		iconPool.push(i);
		mover = new Mover();
		moverArr.push(mover);
		icon = iconArr.eq(i);
		icon.mousedown(onClickIcon);
	}
	moverTimer = setInterval(onMove, 30);
	pushTimer = setInterval(onPush, 400);
	
	timeTimer = setInterval(onTimeTimer, 1000);
	timeTxt.text(restTime + " s");
	restTime--;
}

function onClickIcon(e)
{
	var index = $(this).index();
	var thisX = parseInt($(this).css("left"));
	var thisY = parseInt($(this).css("top"));
	var addOffsetX = -30;
	var addOffsetY = 80;
	var currentScore = 0;
	var randScore = parseInt(Math.random() * 1000);
	
	currentScore = scoreArr[index] + randScore;
	$(this).hide();
	moverArr[index].moving = false;
	iconPool.push(index);
	addScoreTxt.text("+" + currentScore);
	addScoreTxt.css("left", (addOffsetX + thisX) + "px");
	addScoreTxt.css("top", (addOffsetY + thisY) + "px");
	addScoreTxt.css("opacity", 1);
	addScoreTxt.stop();
	addScoreTxt.animate({opacity: 0}, 1000);
	totalScore += currentScore;
	coinScore += currentScore;
	allCoinTxt.text(totalScore);
}

function onTimeTimer()
{
	if (restTime > 0)
	{
		timeTxt.text(restTime + " s");
		restTime--;
	}
	else
	{
		clearInterval(timeTimer);
		timeTxt.text(restTime + " s");
		gameOver();
	}
}

function gameOver()
{
	clearInterval(moverTimer);
	clearInterval(pushTimer);
	gamePanel.fadeOut("normal", showWin);
}

function showWin()
{
	winCoinTxt.text(coinScore);
	friendCoinTxt.text(totalScore);
	winPanel.fadeIn();
	$.post("./?m=game&a=score", {score: totalScore}, null);
}

function onClickWinShare(e)
{
	feed(shareUrl, sharePic);
}

function onClickWinContinue(e)
{
	winPanel.fadeOut("normal", showFriend);
	$.post("./?m=game&a=score", {score: totalScore}, null);
}

function showFriend()
{
	friendPanel.fadeIn();
}

function onClickFriendShare(e)
{
	feed(shareUrl, sharePic);
}

function login()
{
	FB.login(function(response){ location.href = "./?m=game&a=introduction"; });
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
		description: 'Play Game, Win TECNO Phantom 5!!!'
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
