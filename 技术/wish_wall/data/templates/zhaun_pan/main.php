<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>点击转盘抽奖</title>
<link href="css/zhuan_pan.min.css?v=2015.3.12_0.10" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
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
		<p class="department">
			<span id="departmentLabel">部门：</span><input type="text" id="department"/><br />
			<span id="usernameLabel">姓名：</span><input type="text" id="username"/><br />
		</p>
		<input type="button" id="okBtn" value="提交"/>
		<p id="fillTip">请填写部门和姓名，否则无法领取奖品</p>
	</div>
	<div id="loseForm">
		<p>哎呀，没中，<br />明天再来吧！</p>
	</div>
</div>
<div class="footer">
	<p>版权所有&copy;传音控股</p>
</div>
<script type="text/javascript">
var isLuckToday = <?php echo $_isLuckyToday ? "true" : "false"; ?>;
var panFlag = <?php echo $_panFlag; ?>;
var isWinToday = <?php echo $_isWinToday ? "true" : "false"; ?>;
var isSavedInfo = <?php echo $_isSavedInfo ? "true" : "false"; ?>;
var department = "<?php echo $_department; ?>";
var username = "<?php echo $_username; ?>";
var luckyCode = <?php echo $_luckyCode; ?>;
var openId = "<?php echo $_openId; ?>";
var key = "<?php echo $_key; ?>";

var winWidth = $(window).width();
var winHeight = $(window).height();

//alert(winWidth + ":" + winHeight);

var prizeConfig = ['Infinix平板', 'TECNO Phantom Z', 'itel 1452', 'Oraimo蓝牙耳机', 'Oraimo充电宝', '彩票'];
var prizeDanWei = ['一台', '一台', '一台', '一个', '一个', '一张'];
var prize = "";
var danWei = "";

isRun = false;
isSubmit = false;

if (isLuckToday)
{
	if (0 == panFlag)
	{
		if (isSavedInfo)
		{
			if(luckyCode >= 1 && luckyCode <= 6)
			{
				hidePan();
				prize = prizeConfig[luckyCode - 1];
				danWei = prizeDanWei[luckyCode - 1];
				$("#winForm").show();
				$("#winTip").html("棒棒哒，恭喜你获得<br />" + prize + danWei + "！");
				$("#department").hide();
				$("#username").hide();
				$("#okBtn").hide();
				$("#fillTip").hide();
				$("#departmentLabel").html("部门：" + department);
				$("#usernameLabel").html("姓名：" + username);
			}
			else
			{
				alert("系统错误！");
			}
		}
		else
		{
			showPan();
			$("#pan").click(onClickPan);
			$("#guide").click(onClickPan);
			$("#okBtn").click(onClickOk);
		}
	}
	else
	{
		if (isWinToday)
		{
			if (isSavedInfo)
			{
				if(luckyCode >= 1 && luckyCode <= 6)
				{
					hidePan();
					prize = prizeConfig[luckyCode - 1];
					danWei = prizeDanWei[luckyCode - 1];
					$("#winForm").show();
					$("#winTip").html("棒棒哒，恭喜你获得<br />" + prize + danWei + "！");
					$("#department").hide();
					$("#username").hide();
					$("#okBtn").hide();
					$("#fillTip").hide();
					$("#departmentLabel").html("部门：" + department);
					$("#usernameLabel").html("姓名：" + username);
				}
				else
				{
					alert("系统错误！");
				}
			}
			else
			{
				hidePan();
				prize = prizeConfig[luckyCode - 1];
				danWei = prizeDanWei[luckyCode - 1];
				$("#winForm").show();
				$("#winTip").html("棒棒哒，恭喜你获得<br />" + prize + danWei + "！");
				$("#department").focus();
				$("#okBtn").click(onClickOk);
			}
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
	$("#okBtn").click(onClickOk);
}

function onClickPan(e)
{
	if (!isRun && 0 == panFlag)
	{
		isRun = true;
		$.post("?m=zhuanPan&a=clickPan", {openId: openId, key: key}, null);
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
			$.post("?m=zhuanPan&a=fillLuckyInfo", {openId: openId, key: key, department: $("#department").val(), username: $("#username").val()}, onOk);
		}
	}
}

function onOk(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("未知错误！");
		return;
	}
	res = $.parseJSON(value);
	if (0 == res.code)
	{
		alert("提交成功，请关注公众号领奖信息！");
		$("#department").hide();
		$("#username").hide();
		$("#okBtn").hide();
		$("#fillTip").hide();
		$("#departmentLabel").html("部门：" + res.department);
		$("#usernameLabel").html("姓名：" + res.username);
	}
	else
	{
		alert(res.msg);
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
