<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>点击转盘抽奖</title>
<link href="style/index.min.css" rel="stylesheet" type="text/css" />
<script src="style/js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="main-title">
	<img src="style/images/title.png" />
</div>
<div class="pan-box">
	<div class="turntable" id="pan"></div>
	<div class="guide" id="guide"></div>
	<div id="win_form">
		<p id="win_tip">棒棒哒，恭喜你获得<br />XXX 一台！</p>
		<p class="department">
			<span id="department_label">部门：</span><input type="text" id="department"/><br />
			<span id="username_label">姓名：</span><input type="text" id="username"/><br />
		</p>
		<input type="button" id="okBtn" value="提交"/>
		<p id="fill_tip">请填写部门和姓名，否则无法领取奖品</p>
	</div>
	<div id="lose_form">
		<p>哎呀，没中，<br />明天再来吧！</p>
	</div>
</div>
<div class="footer">
	<p>版权所有&copy;传音控股</p>
</div>

	<?php
		/*
		<div class="debug">
		echo '$_is_lucky_today: ' . $_is_lucky_today . '<br />';
		echo '$_pan_flag: ' . $_pan_flag . '<br />';
		echo '$_is_win_today: ' . $_is_win_today . '<br />';
		echo '$_is_saved_info: ' . $_is_saved_info . '<br />';
		echo '$_department: ' . $_department . '<br />';
		echo '$_username: ' . $_username . '<br />';
		echo '$_lucky_code: ' . $_lucky_code . '<br />';
		echo '$_openid: ' . $_openid . '<br />';
		echo '$_key: ' . $_key . '<br />';
		</div>
		*/
	?>

<script type="text/javascript">
var isLuckToday = <?php echo $_is_lucky_today ? "true" : "false"; ?>;
var panFlag = <?php echo $_pan_flag; ?>;
var isWinToday = <?php echo $_is_win_today ? "true" : "false"; ?>;
var isSavedInfo = <?php echo $_is_saved_info ? "true" : "false"; ?>;
var department = "<?php echo $_department; ?>";
var username = "<?php echo $_username; ?>";
var luckyCode = <?php echo $_lucky_code; ?>;
var openid = "<?php echo $_openid; ?>";
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
				$("#win_form").show();
				$("#win_tip").html("棒棒哒，恭喜你获得<br />" + prize + danWei + "！");
				$("#department").hide();
				$("#username").hide();
				$("#okBtn").hide();
				$("#fill_tip").hide();
				$("#department_label").html("部门：" + department);
				$("#username_label").html("姓名：" + username);
			}
			else
			{
				alert("系统错误！");
			}
		}
		else
		{
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
					$("#win_form").show();
					$("#win_tip").html("棒棒哒，恭喜你获得<br />" + prize + danWei + "！");
					$("#department").hide();
					$("#username").hide();
					$("#okBtn").hide();
					$("#fill_tip").hide();
					$("#department_label").html("部门：" + department);
					$("#username_label").html("姓名：" + username);
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
				$("#win_form").show();
				$("#win_tip").html("棒棒哒，恭喜你获得<br />" + prize + danWei + "！");
				$("#department").focus();
				$("#okBtn").click(onClickOk);
			}
		}
		else
		{
			hidePan();
			$("#lose_form").show();
		}
	}
}
else
{
	$("#pan").click(onClickPan);
	$("#guide").click(onClickPan);
	$("#okBtn").click(onClickOk);
}

function onClickPan(e)
{
	if (!isRun && 0 == panFlag)
	{
		isRun = true;
		$.post("?m=weixin&a=click_pan", {openid: openid, key: key}, null);
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
	if(luckyCode >= 1 && luckyCode <= 6)
	{
		var prize = prizeConfig[luckyCode - 1];
		var danWei = prizeDanWei[luckyCode - 1];
		
		$("#win_form").show();
		$("#win_tip").html("棒棒哒，恭喜你获得<br />" + prize + danWei + "！");
		$("#department").focus();
	}
	else
	{
		$("#lose_form").show();
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
			$.post("?m=weixin&a=fill_lucky_info", {openid: openid, key: key, department: $("#department").val(), username: $("#username").val()}, onOk);
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
			$("#okBtn").hide();
			$("#fill_tip").hide();
			$("#department_label").html("部门：" + department);
			$("#username_label").html("姓名：" + username);
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

function hidePan()
{
	$("#pan").hide();
	$("#guide").hide();
}
</script>
</body>
</html>
