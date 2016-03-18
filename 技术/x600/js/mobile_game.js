var isLocal = false;
var isFb = false;
var appId = "";
var shareUrl = "";
var sharePic = "";

var isLogin = false;
var isClick = false;
var prizeId = 0;
var prizeName = "";

var moveTimer = null;
var mover = null;
var initRotate = -125;
var blockAngle = 36;
var randIndex = 0;

$(document).ready(function()
{
	isLocal = ($("#isLocal").val() == 1) ? true : false;
	isFb = ($("#isFb").val() == 1) ? true : false;
	appId = $("#appId").val();
	shareUrl = $("#shareUrl").val();
	sharePic = $("#sharePic").val();
	
	isLogin = ($("#isLogin").val() == 1) ? true : false;
	isClick = ($("#isClick").val() == 1) ? true : false;
	prizeId = parseInt($("#prizeId").val());
	prizeName = $("#prizeName").val();
	
	if (isLogin)
	{
		if (isClick)
		{
			$(".info").hide();
			$(".winners").show();
		}
		else
		{
			$(".info").hide();
			$(".pan").show();
			$("#satartBtn").show();
			$("#winnersBtn").hide();
		}
	}
	
	switch (prizeId)
	{
		case 1:
			$("#awardName").text("Infinix NOTE2");
			$("#awardTitle").text("Congratulations!");
			$("#awardDesc").text("Wow you just got a smartphone Infinix NOTE2! What a lucky guy!");
			break;
		case 2:
			$("#awardName").text("Power bank");
			$("#awardTitle").text("Congratulations!");
			$("#awardDesc").text("Wow you just got a Power bank! What a lucky guy!");
			break;
		case 3:
			$("#awardName").text("Recharge card");
			$("#awardTitle").text("Congratulations!");
			$("#awardDesc").text("Wow you just got a Recharge card! What a lucky guy!");
			break;
		default:
			$("#awardName").text("");
			$("#awardTitle").text("Oops…");
			$("#awardDesc").text("Try again on our InfiniXmas Wish on Dec. 14");
	}
	
	moveTimer = setInterval(onMove, 20);
	mover = new Mover();
	mover.currentPlace = initRotate;
	$('#phoneImg').rotate(initRotate);
	$("#satartBtn").click(onClickStart);
	$("#winnersBtn").click(onClickAward);
	$("#shareBtn").click(onClickShare);
	$("#likeBtn").click(onClickLike);
	
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
	var rand0 = [0, 2, 4, 6, 8];
	var rand2 = [7, 9];
	var rand3 = [3, 5];
	
	if (!isClick)
	{
		isClick = true;
		switch (prizeId)
		{
			case 0:
				randIndex = rand0[parseInt(Math.random() * rand0.length)];
				break;
			case 1:
				randIndex = 1;
				break;
			case 2:
				randIndex = rand2[parseInt(Math.random() * rand2.length)];
				break;
			case 3:
				randIndex = rand3[parseInt(Math.random() * rand3.length)];
				break;
			default:
		}
		
		newAngle = initRotate + 360 * 10 + blockAngle * randIndex;
		mover.currentPlace = mover.currentPlace % 360;
		mover.changeTo(mover.currentPlace + 500, newAngle - 500, newAngle);
		$.post("./?a=setClick", {}, null);
	}
}

function onClickAward(e)
{
	$(".pan").fadeOut("normal", showWiners);
}

function showWiners()
{
	//$(".winners").fadeIn();
	location.href="./?a=lucky";
}

function onMove()
{
	var newAngle = 0;
	var centerX = 346;
	var centerY = 530;
	var r = 165;
	
	if (mover.moving)
	{
		mover.move();
		$('#phoneImg').rotate(mover.currentPlace);
		if (!mover.moving)
		{
			newAngle = (initRotate + 34 + randIndex * blockAngle) * Math.PI / 180;
			$("#dot").css("left", (centerX + r * Math.cos(newAngle))  + "px");
			$("#dot").css("top", (centerY + r * Math.sin(newAngle))  + "px");
			$("#dot").show();
			$(".winDlg").fadeIn();
			$("#satartBtn").hide();
			$("#winnersBtn").show();
		}
	}
}

function onClickShare(e)
{
	feed(shareUrl, sharePic);
}

function onClickLike(e)
{
	$(".winDlg").fadeOut();
}

function login()
{
	FB.login(function(response){ location.href = "./"; });
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
		name: 'Infinix NOTE2',
		link: link,
		picture: picture,
		caption: 'www.infinixmobility.com/',
		description: 'Lottery, Win Infinix NOTE2!!!'
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
