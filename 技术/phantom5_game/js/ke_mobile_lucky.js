var isLocal = false;
var isFb = false;
var appId = "";
var shareUrl = "";
var sharePic = "";
var restLucky = 0;
var isShared = false;

var mover = null;
var blockAngle = 45;
var initAngle = 25;
var maxAngle = 360 * 60;
var randIndex = 0;
var lockStart = false;
var prizeId = 0;

$(document).ready(function()
{
	isLocal = ($("#isLocal").val() == 1) ? true : false;
	isFb = ($("#isFb").val() == 1) ? true : false;
	appId = $("#appId").val();
	shareUrl = $("#shareUrl").val();
	sharePic = $("#sharePic").val();
	restLucky = parseInt($("#restLucky").val());
	isShared = ($("#isShared").val() == 1) ? true : false;
	
	setInterval(onMove, 20);
	mover = new Mover();
	mover.currentPlace = 0;
	$("#startBtn").click(onClickStart);
	$("#shareBtn").click(onClickShare);
	$("#winShare").click(onClickWinShare);
	$("#winContinue").click(onClickWin);
	$("#lostShare").click(onClickLostShare);
	$("#lostContinue").click(onClickLost);
	
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

function onClickStart(e)
{
	var newAngle = 0;
	
	if (restLucky > 0 && !lockStart)
	{
		lockStart = true;
		restLucky--;
		$("#restNum").text(restLucky);
		prizeId = 0;
		randIndex = 0;
		newAngle = maxAngle + blockAngle * randIndex + initAngle;
		mover.currentPlace = mover.currentPlace % 360;
		mover.changeTo(mover.currentPlace + 500, newAngle - 500, newAngle);
		$.post("./?a=doLucky", {}, onStart);
	}
}

function onStart(value)
{
	var res = null;
	var newAngle = 0;
	var lastRound = 0;
	var rand0 = [0, 2, 6];
	var prizeNameArr = ['TECNO Phantom 5', 'Power Bank', 'Selfie Stick', '10% off Coupon for TECNO Smartphone', '5% off Coupon for TECNO Smartphone', 'TECNO Cup', 'TECNO Golf Umbrella', 'TECNO T-shirt', 'TECNO Fashion Bag', 'Wall Clock'];
	var prizeName = "";
	
	try
	{
		res = $.parseJSON(value);
	}
	catch (err)
	{
		//服务端返回异常，json数据不能正常解析
		alert("Unknown Error!");
		return;
	}
	
	if (0 == res.code)
	{
		prizeId = res.prizeId;
		restLucky = res.restLucky;
		$("#restNum").text(restLucky);
		if (prizeId >= 1 && prizeId  <= 10)
		{
			prizeName = prizeNameArr[prizeId - 1];
		}
		switch (prizeId)
		{
			case 1:
				randIndex = 4;
				$("#awardName").text(prizeName + "!");
				$("#winPic").attr("src", "./images/ke/mobile/page10/4.png");
				break;
			case 2:
				randIndex = 7;
				$("#awardName").text(prizeName + "!");
				$("#winPic").attr("src", "./images/ke/mobile/page10/5.png");
				break;
			case 3:
				randIndex = 5;
				$("#awardName").text(prizeName + "!");
				$("#winPic").attr("src", "./images/ke/mobile/page10/6.png");
				break;
			case 4:
				randIndex = 1;
				$("#awardName").text(prizeName + "!");
				$("#winPic").attr("src", "./images/ke/mobile/page10/2.png");
				break;
			case 5:
				randIndex = 1;
				$("#awardName").text(prizeName + "!");
				$("#winPic").attr("src", "./images/ke/mobile/page10/1.png");
				break;
			case 6:
				randIndex = 3;
				$("#awardName").text(prizeName + "!");
				$("#winPic").attr("src", "./images/ke/mobile/page10/3.png");
				break;
			case 7:
				randIndex = 3;
				$("#awardName").text(prizeName + "!");
				$("#winPic").attr("src", "./images/ke/mobile/page10/3.png");
				break;
			case 8:
				randIndex = 3;
				$("#awardName").text(prizeName + "!");
				$("#winPic").attr("src", "./images/ke/mobile/page10/3.png");
				break;
			case 9:
				randIndex = 3;
				$("#awardName").text(prizeName + "!");
				$("#winPic").attr("src", "./images/ke/mobile/page10/3.png");
				break;
			case 10:
				randIndex = 3;
				$("#awardName").text(prizeName + "!");
				$("#winPic").attr("src", "./images/ke/mobile/page10/3.png");
				break;
			default:
				randIndex = rand0[parseInt(Math.random() * rand0.length)];
		}
		lastRound = parseInt(mover.currentPlace / 360) + 5;
		newAngle = 360 * lastRound + blockAngle * randIndex + initAngle;
		mover.changeMove(newAngle - 500, newAngle);
	}
	else
	{
		alert(res.msg);
	}
}

function onMove()
{
	if (mover.moving)
	{
		mover.move();
		$('#pan').rotate(mover.currentPlace);
		if (!mover.moving)
		{
			if (prizeId > 0)
			{
				//$(".win").fadeIn();
				$(".win").show();
			}
			else
			{
				//$(".lost").fadeIn();
				$(".lost").show();
			}
			lockStart = false;
		}
	}
}

function onClickShare(e)
{
	if (!isShared)
	{
		isShared = true;
		restLucky++;
		$("#restNum").text(restLucky);
		$(".shareTip").hide();
		$.post("./?a=doShare", {}, null);
	}
	feed(shareUrl, sharePic);
}

function onClickWinShare(e)
{
	if (!isShared)
	{
		isShared = true;
		restLucky++;
		$("#restNum").text(restLucky);
		$(".shareTip").hide();
		$.post("./?a=doShare", {}, null);
	}
	//$(".win").fadeOut();
	$(".win").hide();
	feed(shareUrl, sharePic);
}

function onClickWin(e)
{
	//$(".win").fadeOut();
	$(".win").hide();
}

function onClickLostShare(e)
{
	if (!isShared)
	{
		isShared = true;
		restLucky++;
		$("#restNum").text(restLucky);
		$(".shareTip").hide();
		$.post("./?a=doShare", {}, null);
	}
	//$(".lost").fadeOut();
	$(".lost").hide();
	feed(shareUrl, sharePic);
}

function onClickLost(e)
{
	//$(".lost").fadeOut();
	$(".lost").hide();
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
