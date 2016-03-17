<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
<title>点击转盘抽奖</title>
<link href="css/zhuan_pan.min.css?v=2015.3.12_22.17" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="main-title">
	<img src="images/lucky/title.png" />
</div>
<div class="pan-box">
	<div class="turntable" id="pan"></div>
	<div class="guide" id="guide"></div>
	<div id="winForm">
		<p id="winTip">棒棒哒，恭喜你获得<br />XXX 一台！</p>
	</div>
	<div id="loseForm">
		<p>哎呀，没中，<br />明天再来吧！</p>
	</div>
</div>
<div class="footer">
	<p>版权所有&copy;传音控股</p>
</div>

	<?php
		/*
		echo '<div class="debug">';
		echo '$_openid: ' . $_openid . '<br />';
		echo '$_key: ' . $_key . '<br />';
		echo '$_isLuckyToday: ' . $_isLuckyToday . '<br />';
		echo '$_panFlag: ' . $_panFlag . '<br />';
		echo '$_isWinToday: ' . $_isWinToday . '<br />';
		echo '$_luckyCode: ' . $_luckyCode . '<br />';
		echo '</div>';
		*/
	?>

<script type="text/javascript">
var openid = "<?php echo $_openid; ?>";
var key = "<?php echo $_key; ?>";
var isLuckToday = <?php echo $_isLuckyToday ? "true" : "false"; ?>;
var panFlag = <?php echo $_panFlag; ?>;
var isWinToday = <?php echo $_isWinToday ? "true" : "false"; ?>;
var luckyCode = <?php echo $_luckyCode; ?>;

/*
var winWidth = $(window).width();
var winHeight = $(window).height();
alert(winWidth + ":" + winHeight);
*/

var prizeConfig = ['Infinix平板', 'TECNO Phantom Z', 'itel 1452', 'Oraimo蓝牙耳机', 'Oraimo充电宝', '彩票'];
var prizeDanWei = ['一台', '一台', '一台', '一个', '一个', '一张'];
var prize = "";
var danWei = "";

var isRun = false;
var isSubmit = false;

if (isLuckToday)
{
	if (0 == panFlag)
	{
		showPan();
		$("#pan").click(onClickPan);
		$("#guide").click(onClickPan);
	}
	else
	{
		if (isWinToday)
		{
			hidePan();
			prize = prizeConfig[luckyCode - 1];
			danWei = prizeDanWei[luckyCode - 1];
			$("#winForm").show();
			$("#winTip").html("棒棒哒，恭喜你获得<br />" + prize + danWei + "！");
		}
		else
		{
			hidePan();
			$("#loseForm").show();
		}
	}
}
else
{
	showPan();
	$("#pan").click(onClickPan);
	$("#guide").click(onClickPan);
}

function onClickPan(e)
{
	if (!isRun && 0 == panFlag)
	{
		isRun = true;
		$.post("?m=zhuanPan&a=clickPan", {openid: openid, key: key}, null);
		turntable(luckyCode);
	}
}

function turntable(luckyCode)
{
	var code = 0;
	var fixLucky = [2, 4, 3, 5, 7, 0, 1];
	var startDeg=360 / 16;
	
	if (luckyCode >= 0 && luckyCode <= 6)
	{
		code = fixLucky[luckyCode];
	}
	startDeg += 2160 + (~~code - 1) * 360 / 8;
	try
	{
		["Moz","0","Webkit","ms",""].forEach(function(brower){
			document.querySelector(".turntable").style[brower+"TransitionDuration"]="5s";
			document.querySelector(".turntable").style[brower+"Transform"]="rotate("+startDeg+"deg)";
		});
		setTimeout(function(){
			["Moz","0","Webkit","ms",""].forEach(function(brower){
				document.querySelector(".turntable").style[brower+"TransitionDuration"]="0s";
				document.querySelector(".turntable").style[brower+"Transform"]="rotate("+(startDeg-2160)+"deg)";
			});
			setTimeout(showTip, 500);
		}, 5100);
	}
	catch (e)
	{
	}
}

function showTip()
{
	hidePan();
	if (luckyCode >= 1 && luckyCode <= 6)
	{
		var prize = prizeConfig[luckyCode - 1];
		var danWei = prizeDanWei[luckyCode - 1];
		
		$("#winForm").show();
		$("#winTip").html("棒棒哒，恭喜你获得<br />" + prize + danWei + "！");
		$("#department").focus();
	}
	else
	{
		$("#loseForm").show();
	}
}

function onClickOk(e)
{
	if (!isSubmit && !isSavedInfo)
	{
		if ("" == $("#department").val() || "" == $("#username").val())
		{
			alert("请填写正确的部门和姓名！");
			$("#department").focus();
		}
		else
		{
			isSubmit = true;
			$.post("?m=zhuanPan&a=fillLuckyInfo", {openid: openid, key: key, department: $("#department").val(), username: $("#username").val()}, onOk);
		}
	}
}

function onOk(value)
{
	var res = null;
	var department = "";
	var username = "";
	
	if (value.substr(0, 1) != "{")
	{
		alert("未知错误！");
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			alert("提交成功，请关注公众号领奖信息！");
			department = res.department;
			username = res.username;
			$("#department").hide();
			$("#username").hide();
			$("#fillTip").hide();
			$("#departmentLabel").html("部门：" + department);
			$("#usernameLabel").html("姓名：" + username);
			break;
		case 1:
			alert("请勿重复提交！");
			break;
		case 2:
			alert("非法请求！");
			break;
		case 3:
			alert("请填写正确的部门和姓名！");
			$("#department").focus();
			isSubmit = false;
			break;
		default:
			alert("未知错误！");
			isSubmit = false;
	}
}

function showPan()
{
	$("#pan").show();
	$("#guide").show();
}

function hidePan()
{
	$("#pan").hide();
	$("#guide").hide();
}
</script>
</body>
</html>
