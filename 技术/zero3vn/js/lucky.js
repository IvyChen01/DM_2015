var isLocal = false;
var isFb = false;
var appId = "";
var shareUrl = "";
var sharePic = "";
var restLucky = 0;
var restSecond = 0;
var isLogin = false;
var isScroll = false;
var isShared = false;
var timeState = 0;

var mover = null;
var blockAngle = 45;
var initAngle = 25;
var maxAngle = 360 * 60;
var randIndex = 0;
var lockStart = false;
var prizeId = 0;
var flashTimes = 0;

$(document).ready(function()
{
	isLocal = ($("#isLocal").val() == 1) ? true : false;
	isFb = ($("#isFb").val() == 1) ? true : false;
	appId = $("#appId").val();
	shareUrl = $("#shareUrl").val();
	sharePic = $("#sharePic").val();
	restLucky = parseInt($("#restLucky").val());
	restSecond = parseInt($("#restSecond").val());
	isLogin = ($("#isLogin").val() == 1) ? true : false;
	isScroll = ($("#isScroll").val() == 1) ? true : false;
	isShared = ($("#isShared").val() == 1) ? true : false;
	timeState = parseInt($("#timeState").val());
	onTime();
	setInterval(onMove, 20);
	setInterval(onTime, 1000);
	mover = new Mover();
	mover.currentPlace = 0;
	$("#startBtn").click(onClickStart);
	$("#winClose").click(onClickClose);
	$("#winShareBtn").click(onClickShare);
	
	if (isScroll)
	{
		$('html, body').animate({scrollTop:4540}, 0);
	}
	
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
	
	if (isLogin)
	{
		if (!lockStart)
		{
			switch (timeState)
			{
				case 1:
					//抽奖时间未到
					alert("Chương trình bắt đầu từ ngày 17 tháng 3 năm 2016");
					break;
				case 2:
					//开始抽奖
					if (restLucky > 0)
					{
						lockStart = true;
						restLucky--;
						prizeId = 0;
						randIndex = 0;
						newAngle = maxAngle + blockAngle * randIndex + initAngle;
						mover.currentPlace = mover.currentPlace % 360;
						mover.changeTo(mover.currentPlace + 500, newAngle - 500, newAngle);
						$.post("./?a=doLucky", {}, onStart);
					}
					else
					{
						alert("You have Played!");
					}
					break;
				case 3:
					//抽奖已结束
					alert("chương trình rút thăm đã kết thúc");
					break;
				default:
			}
		}
	}
	else
	{
		flashLogin();
	}
}

function onStart(value)
{
	var res = null;
	var newAngle = 0;
	var lastRound = 0;
	var rand0 = [0, 4];
	var rand1 = [1, 5];
	var rand2 = [3, 7];
	var rand3 = [2, 6];
	var prizeNameArr = ['Infinix Smartphone', 'Infinix Power Bank', 'Voucher Pulsa Mobile Phone @50,000', '', '', '', '', '', '', ''];
	var prizeName = "";
	
	try
	{
		res = $.parseJSON(value);
	}
	catch (err)
	{
		//服务端返回异常，json数据不能正常解析
		return;
	}
	
	if (0 == res.code)
	{
		prizeId = res.prizeId;
		restLucky = res.restLucky;
		if (prizeId >= 1 && prizeId <= 10)
		{
			prizeName = prizeNameArr[prizeId - 1];
		}
		switch (prizeId)
		{
			case 1:
				randIndex = rand1[parseInt(Math.random() * rand1.length)];
				$("#winTip").text("Wow you just got a " + prizeName + ". What a lucky guy!");
				break;
			case 2:
				randIndex = rand2[parseInt(Math.random() * rand2.length)];
				$("#winTip").text("Wow you just got a " + prizeName + ". What a lucky guy!");
				break;
			case 3:
				randIndex = rand3[parseInt(Math.random() * rand3.length)];
				$("#winTip").text("Wow you just got a " + prizeName + ". What a lucky guy!");
				break;
			default:
				randIndex = rand0[parseInt(Math.random() * rand0.length)];
				$("#winTip").text("Opps, Sorry, You haven’t got anything!");
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
			$(".winDlg").fadeIn();
			if (prizeId > 0)
			{
				//
			}
			else
			{
				//
			}
			lockStart = false;
		}
	}
	
	if (!isLogin)
	{
		if (flashTimes > 0)
		{
			if (flashTimes == 1)
			{
				$(".loginBar").show();
			}
			else
			{
				if (flashTimes % 4 == 0)
				{
					$(".loginBar").toggle();
				}
			}
			flashTimes--;
		}
	}
}

function flashLogin()
{
	flashTimes = 50;
}

function onTime()
{
	var d = 0;
	var h = 0;
	var m = 0;
	var s = 0;
	
	if (restSecond > 0)
	{
		restSecond--;
		d = parseInt(restSecond / 24 / 60 / 60);
		h = parseInt((restSecond % (24 * 60 * 60)) / 60 / 60);
		m = parseInt((restSecond % (60 * 60)) / 60);
		s = parseInt(restSecond % 60);
		$("#timeDay").text(d);
		$("#timeHour").text(h);
		$("#timeMinute").text(m);
		$("#timeSecond").text(s);
	}
	else
	{
		$("#timeDay").text("0");
		$("#timeHour").text("0");
		$("#timeMinute").text("0");
		$("#timeSecond").text("0");
	}
}

function showOrder()
{
	$(".orderBox").fadeIn("normal");
}

function onClickClose(e)
{
	$(".winDlg").fadeOut();
}

function onClickShare(e)
{
	if (!isShared)
	{
		isShared = true;
		$.post("./?a=doShare", {}, onShare);
	}
	feed(shareUrl, sharePic);
}

function onShare(value)
{
	var res = null;
	
	try
	{
		res = $.parseJSON(value);
	}
	catch (err)
	{
		//服务端返回异常，json数据不能正常解析
		return;
	}
	
	if (0 == res.code)
	{
		restLucky = res.restLucky;
	}
	else
	{
		alert(res.msg);
	}
}

function login()
{
	FB.login(function(response){ location.href = "./?a=lucky"; });
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
		name: 'Infinix Zero3',
		link: link,
		picture: picture,
		caption: 'www.infinixmobility.com',
		description: 'Play Game, Win Infinix Zero3!!!'
	},
	function(response) {
		//alert("Succeed!");
	});
}

function invite()
{
	FB.ui({method: 'apprequests',
	  message: 'Infinix'
	}, function (response){});
}

function addPage(redirect_uri)
{
	FB.ui({
	  method: 'pagetab',
	  redirect_uri: redirect_uri
	}, function(response){});
}
