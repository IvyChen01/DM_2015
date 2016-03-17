var isFb = false;
var appId = "";
var shareUrl = "";
var sharePic = "";
var restLucky = 0;
var srcPrizeId = 0;

var mover = null;
var blockAngle = 45;
var initAngle = 25;
var maxAngle = 360 * 60;
var randIndex = 0;
var lockStart = false;
var prizeId = 0;
var prizeNameArr = ['it1505', 'it1407', 'itel Umbrella', 'Tshirt', 'Selfie Stick', '', '', '', '', ''];

$(document).ready(function()
{
	isFb = ($("#isFb").val() == 1) ? true : false;
	appId = $("#appId").val();
	shareUrl = $("#shareUrl").val();
	sharePic = $("#sharePic").val();
	restLucky = parseInt($("#restLucky").val());
	srcPrizeId = parseInt($("#prizeId").val());
	
	setInterval(onMove, 20);
	mover = new Mover();
	mover.currentPlace = 0;
	$("#startBtn").click(onClickStart);
	$("#shareBtn").click(onClickShare);
	
	if (restLucky <= 0)
	{
		$("#mask").show();
		if (srcPrizeId > 0)
		{
			$("#awardName").text(prizeNameArr[srcPrizeId - 1]);
			$("#winDlg").show();
		}
		else
		{
			$("#loseDlg").show();
		}
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
	
	if (restLucky > 0 && !lockStart)
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
}

function onStart(value)
{
	var res = null;
	var newAngle = 0;
	var lastRound = 0;
	var rand0 = [0, 2, 3, 5, 7];
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
		
		if (prizeId >= 1 && prizeId  <= 10)
		{
			prizeName = prizeNameArr[prizeId - 1];
		}
		switch (prizeId)
		{
			case 1:
				randIndex = 6;
				break;
			case 2:
				randIndex = 1;
				break;
			case 3:
				randIndex = 4;
				break;
			case 4:
				randIndex = 4;
				break;
			case 5:
				randIndex = 4;
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
			$("#mask").show();
			if (prizeId > 0)
			{
				$("#awardName").text(prizeNameArr[prizeId - 1]);
				$("#winDlg").show();
			}
			else
			{
				$("#loseDlg").show();
			}
			lockStart = false;
		}
	}
}

function onClickShare(e)
{
	feed(shareUrl, sharePic);
}

function login()
{
	FB.login(function(response){ location.href = "./?a=main"; });
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
		name: 'itel survey',
		link: link,
		picture: picture,
		caption: 'www.itel-mobile.com',
		description: 'www.itel-mobile.com'
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
