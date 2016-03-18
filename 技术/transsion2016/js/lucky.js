var restLucky = 0;
var isLogin = 0;
var isLockTime = false;
var mover = null;
var blockAngle = 30;
var initAngle = -15;
var maxAngle = 360 * 60;
var prizeId = 0;
var randIndex = 0;
var lockStart = false;
var prizeNameArr = [
		'您获得了 <span>TECNO C8</span> 1台！',
		'您获得了 <span>TECNO Phantom 5</span> 1台！',
		'您获得了 <span>TECNO pad 7C</span> 1台！',
		'您获得了 <span>TECNO pad 8H</span> 1台！',
		'您获得了 <span>itel it1505</span> 1台！',
		'您获得了 <span>Infinix X511</span> 1台！',
		'您获得了 <span>Infinix X405</span> 1台！',
		'您获得了 <span>Syinix原汁机</span> 1台！',
		'您获得了 <span>Oraimo充电宝</span> 1个！',
		'您获得了 <span>iflux应急灯</span> 1台！',
		'您获得了 <span>现金红包 8元</span>！',
		'您获得了 <span>现金红包 18元</span>！',
		'您获得了 <span>现金红包 28元</span>！'
	];
var randIndexArr = [5, 0, 2, 7, 1, 9, 11, 6, 8, 3, 4, 10, 10, 10];

$(document).ready(function()
{
	restLucky = parseInt($("#restLucky").val());
	isLogin = ($("#isLogin").val() == 1) ? true : false;
	isLockTime = ($("#isLockTime").val() == 1) ? true : false;
	mover = new Mover();
	mover.currentPlace = initAngle;
	$('#pan').rotate(initAngle);
	if (!isLogin)
	{
		lockStart = true;
		$("#mask").show();
		$("#loginPanel").show();
	}
	else
	{
		lockStart = false;
	}
	setInterval(onMove, 20);
	$("#loginBtn").click(onClickLogin);
	$("#start").click(onClickStart);
});

function onClickLogin(e)
{
	if ($("#jobnumTxt").val() == "")
	{
		alert("工号不能为空！");
		return;
	}
	if ($("#usernameTxt").val() == "")
	{
		alert("姓名不能为空！");
		return;
	}
	$.post("?a=doLogin", {jobnum: $("#jobnumTxt").val(), username: $("#usernameTxt").val()}, onLogin);
}

function onLogin(value)
{
	var res = null;
	
	try
	{
		res = $.parseJSON(value);
	}
	catch (err)
	{
		//服务端返回异常，json数据不能正常解析
		//alert("未知错误！");
		return;
	}
	
	switch (res.code)
	{
		case 0:
			restLucky = res.restLucky;
			$("#restTxt").text(restLucky);
			$("#mask").fadeOut();
			$("#loginPanel").fadeOut();
			lockStart = false;
			break;
		default:
			alert(res.msg);
	}
}

function onClickStart(e)
{
	var newAngle = 0;
	
	if (isLockTime)
	{
		alert("抽奖每天下午5点开始哦！");
	}
	else
	{
		if (!lockStart)
		{
			if (restLucky > 0)
			{
				lockStart = true;
				restLucky--;
				$("#restTxt").text(restLucky);
				prizeId = 0;
				randIndex = randIndexArr[0];
				newAngle = maxAngle + blockAngle * randIndex + initAngle + blockAngle / 2;
				mover.currentPlace = mover.currentPlace % 360;
				mover.changeTo(mover.currentPlace + 500, newAngle - 500, newAngle);
				$.post("?a=doLucky", {}, onStart);
			}
			else
			{
				alert("今天的抽奖次数已用完，请明天再来！");
			}
		}
	}
}

function onStart(value)
{
	var res = null;
	var newAngle = 0;
	var lastRound = 0;
	var prizeName = "";
	
	try
	{
		res = $.parseJSON(value);
	}
	catch (err)
	{
		//服务端返回异常，json数据不能正常解析
		//alert("未知错误！");
		return;
	}
	
	if (res.code == 0)
	{
		prizeId = res.prizeId;
		if (prizeId >= 1 && prizeId  <= 13)
		{
			randIndex = randIndexArr[prizeId];
			prizeName = prizeNameArr[prizeId - 1];
			$("#winTxt").html(prizeName);
			if (prizeId < 11)
			{
				$("#winPic").attr("src", "http://img.qumuwu.com/transsion/images/big3/prize" + prizeId + ".png?v=2016.1.19_18.38");
			}
			else
			{
				$("#winPic").attr("src", "http://img.qumuwu.com/transsion/images/big3/prize11.png?v=2016.1.19_18.38");
			}
		}
		else
		{
			randIndex = randIndexArr[0];
		}
		lastRound = parseInt(mover.currentPlace / 360) + 5;
		newAngle = 360 * lastRound + blockAngle * randIndex + initAngle + blockAngle / 2;
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
			$("#mask").fadeIn();
			if (prizeId >= 1 && prizeId  <= 13)
			{
				$("#winPanel").fadeIn();
			}
			else
			{
				$("#losePanel").fadeIn();
			}
			lockStart = false;
		}
	}
}
