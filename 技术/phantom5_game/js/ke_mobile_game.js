var isLocal = false;
var isFb = false;
var appId = '';
var shareUrl = '';
var sharePic = '';
var isPlayed = false;
var todayScore = 0;
var loadingPanel = null;
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
var allCoinTxt = null;
var winCoinTxt = null;

var readyTxt = null;
var timeTxt = null;
var addScoreTxt = null;
var readyTimer = null;
var timeTimer = null;
var readyTime = 3;
var restTime = 30;
var iconArr = null;
var icon = null;
var iconPool = null;
var iconBoxWidth = 740;
var iconBoxHeight = 950;
var moverArr = null;
var mover = null;
var moverTimer = null;
var pushTimer = null;
var totalScore = 0;
var scoreArr = [300, 400, 300, 500, 100, 200, 200, 200, 500, 100, 300, 300, 100,      300, 400, 300, 500, 100, 200, 200, 200, 500, 100, 300, 300, 100];
var maxRandScore = 300;
var missionScore = 1200;
var hifiScore = 1800;
var cameraScore = 2000;
var addTimer = null;

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
	allCoinTxt = $("#coinBar .coinNum");
	winCoinTxt = $("#winPanel .coinNum");
	readyTxt = $("#gamePanel .ready");
	timeTxt = $("#gamePanel .timeTxt");
	addScoreTxt = $("#gamePanel .addScore");
	$("#navBar").click(onClickMenu);
	
	if (isPlayed)
	{
		allCoinTxt.text(todayScore);
		winCoinTxt.text(todayScore);
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

function onClickMenu(e)
{
	$("#navMenu").slideToggle();
}

function onPush()
{
	var rand = 0;
	var iconIndex = 0;
	var minLeft = 100;
	var maxLeft = iconBoxWidth - 100;
	var randX = 0;
	var randY = 0;
	
	var minTop = 100;
	var maxTop = iconBoxHeight - 100;
	
	
	if (iconPool.length > 0)
	{
		rand = parseInt(Math.random() * iconPool.length);
		iconIndex = iconPool[rand];
		iconPool.splice(rand, 1);
		icon = iconArr.eq(iconIndex);
		randX = parseInt(Math.random() * (iconBoxWidth - 100));
		randY = parseInt(Math.random() * (maxTop - minTop)) + minTop;
		icon.css("left", randX + "px");
		icon.css("top", "-120px");
		icon.show();
		mover = moverArr[iconIndex];
		mover.currentPlace = -120;
		mover.down2To(randY, randY + 20, iconBoxHeight + 200);
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
			icon.css("top", mover.currentPlace + "px");
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
		winPanel.fadeIn();
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
	$(".page5 .title").css("opacity", 0);
	$(".page5 .content").css("opacity", 0);
	$(".page5 .phone").css("opacity", 0);
	$(".page5 .musicIcon").css("opacity", 0);
	$(".page5 .continue").css("opacity", 0);
	hifiPanel.fadeIn("normal", moveHifi);
}

function moveHifi()
{
	showHifiTitle();
	setTimeout(showHifiContent, 300);
	setTimeout(showHifiPhone, 600);
	setTimeout(showHifiContinue, 900);
	setTimeout(showHifiMusicIcon, 1200);
}

function showHifiTitle()
{
	var title = parseInt($(".page5 .title").css("top"));
	var offset = 200;
	
	$(".page5 .title").css("top", title + offset);
	$(".page5 .title").animate({opacity: 1, top: title}, 1000);
}

function showHifiContent()
{
	var content = parseInt($(".page5 .content").css("top"));
	var offset = 200;
	
	$(".page5 .content").css("top", content + offset);
	$(".page5 .content").animate({opacity: 1, top: content}, 1000);
}

function showHifiPhone()
{
	var phone = parseInt($(".page5 .phone").css("top"));
	var offset = 200;
	
	$(".page5 .phone").css("top", phone + offset);
	$(".page5 .phone").animate({opacity: 1, top: phone}, 1000);
}

function showHifiMusicIcon()
{
	var musicIcon = parseInt($(".page5 .musicIcon").css("top"));
	var offset = 200;
	
	$(".page5 .musicIcon").css("top", musicIcon + offset);
	$(".page5 .musicIcon").animate({opacity: 1, top: musicIcon}, 1000);
}

function showHifiContinue()
{
	var continueX = parseInt($(".page5 .continue").css("top"));
	var offset = 200;
	
	$(".page5 .continue").css("top", continueX + offset);
	$(".page5 .continue").animate({opacity: 1, top: continueX}, 1000);
}

function onClickHifi(e)
{
	hifiPanel.fadeOut("normal", showCamera);
	totalScore += hifiScore;
	allCoinTxt.text(totalScore);
}

function showCamera()
{
	$(".page6 .title").css("opacity", 0);
	$(".page6 .content").css("opacity", 0);
	$(".page6 .phone").css("opacity", 0);
	$(".page6 .continue").css("opacity", 0);
	cameraPanel.fadeIn("normal", moveCamera);
}

function moveCamera()
{
	showCameraTitle();
	setTimeout(showCameraContent, 300);
	setTimeout(showCameraPhone, 600);
	setTimeout(showCameraContinue, 900);
}

function showCameraTitle()
{
	var title = parseInt($(".page6 .title").css("top"));
	var offset = 200;
	
	$(".page6 .title").css("top", title + offset);
	$(".page6 .title").animate({opacity: 1, top: title}, 1000);
}

function showCameraContent()
{
	var content = parseInt($(".page6 .content").css("top"));
	var offset = 200;
	
	$(".page6 .content").css("top", content + offset);
	$(".page6 .content").animate({opacity: 1, top: content}, 1000);
}

function showCameraPhone()
{
	var phone = parseInt($(".page6 .phone").css("top"));
	var offset = 200;
	
	$(".page6 .phone").css("top", phone + offset);
	$(".page6 .phone").animate({opacity: 1, top: phone}, 1000);
}

function showCameraContinue()
{
	var continueX = parseInt($(".page6 .continue").css("top"));
	var offset = 200;
	
	$(".page6 .continue").css("top", continueX + offset);
	$(".page6 .continue").animate({opacity: 1, top: continueX}, 1000);
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
		readyTxt.css("font-size", "200px");
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
		icon.on('click', onClickIcon);
		//icon.click(onClickIcon);
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
	var addOffsetX = -50;
	var addOffsetY = 180;
	var currentScore = 0;
	var randScore = parseInt(Math.random() * maxRandScore);
	
	currentScore = scoreArr[index] + randScore;
	$(this).hide();
	moverArr[index].moving = false;
	iconPool.push(index);
	addScoreTxt.text("+" + currentScore);
	addScoreTxt.css("left", (addOffsetX + thisX) + "px");
	addScoreTxt.css("top", (addOffsetY + thisY) + "px");
	//addScoreTxt.css("opacity", 1);
	//addScoreTxt.stop();
	//addScoreTxt.animate({opacity: 0}, 1000);
	totalScore += currentScore;
	allCoinTxt.text(totalScore);
	
	addScoreTxt.show();
	clearTimeout(addTimer);
	addTimer = setTimeout(hideAdd, 200);
}

function hideAdd()
{
	addScoreTxt.hide();
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
	winCoinTxt.text(totalScore);
	winPanel.fadeIn();
	$.post("./?m=game&a=score", {score: totalScore}, null);
}

function onClickWinShare(e)
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
