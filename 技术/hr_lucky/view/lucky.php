<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
<title>点击转盘抽奖</title>
<link href="css/zhuan_pan.min.css?v=2015.3.15_17.1" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.9.1.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<img src="http://www.geyaa.com/transsion_hr_images/bg3.png" class="bg" />
<img src="http://www.geyaa.com/transsion_hr_images/start3.jpg" id="startPage" />
<div class="pan-box">
	<img src="http://www.geyaa.com/transsion_hr_images/pan3.png" class="turntable" id="pan" />
	<img src="http://www.geyaa.com/transsion_hr_images/arrow3.png" class="guide" id="guide" />
</div>
<div id="dialog">
	<img src="http://www.geyaa.com/transsion_hr_images/dialog3.png" class="dialog-bg" />
	<div class="text-block">
		<p id="tip">tip</p>
	</div>
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
		echo '$_getCode: ' . $_getCode . '<br />';
		echo '$_loseCode: ' . $_loseCode . '<br />';
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
var getCode = "<?php echo $_getCode; ?>";
var loseCode = <?php echo $_loseCode; ?>;

//var winWidth = $(window).width();
//var winHeight = $(window).height();
//alert(winWidth + ":" + winHeight);

var prizeConfig = ['酷炫手表', '运动水壶', '创意水杯', '充电宝', '蓝牙耳机'];
var prizeDanWei = ['一个', '一个', '一个', '一个', '一个'];
var prize = "";
var danWei = "";

var isRun = false;
var isEnter = false;

$(document).ready(function(){
	resizeWindow();
	$(window).resize(resizeWindow);
	
	if (isLuckToday)
	{
		if (0 == panFlag)
		{
			showStartPage();
			$("#startPage").click(onClickStart);
		}
		else
		{
			if (isWinToday)
			{
				showTip();
			}
			else
			{
				showLose();
			}
		}
	}
	else
	{
		showStartPage();
		$("#startPage").click(onClickStart);
	}
});

function resizeWindow()
{
	var winWidth = $(window).width();
	var winHeight = $(window).height();
	var panWidth = 0;
	var dialogWidth = 0;
	var dialogHeight = 0;
	var guideLeft = 0;
	var guideTop = 0;
	
	if (winWidth <= 320)
	{
		panWidth = 240;
		dialogWidth = 258;
		dialogHeight = 186;
		guideLeft = 88;
		guideTop = 90;
	}
	else
	{
		panWidth = 301;
		dialogWidth = 299;
		dialogHeight = 216;
		guideLeft = 119;
		guideTop = 120;
	}
	
	$(".turntable").css("width", panWidth + "px");
	$(".turntable").css("height", panWidth + "px");
	$(".dialog-bg").css("width", dialogWidth + "px");
	$(".dialog-bg").css("height", dialogHeight + "px");
	$(".text-block").css("width", dialogWidth + "px");
	$(".text-block").css("height", dialogHeight + "px");
	$(".pan-box").css("left", (winWidth - panWidth) / 2);
	$(".guide").css("left", guideLeft + "px");
	$(".guide").css("top", guideTop + "px");
	$(".dialog-bg").css("left", (winWidth - dialogWidth) / 2);
	$(".text-block").css("left", (winWidth - dialogWidth) / 2);
}

function onClickStart(e)
{
	if (!isEnter)
	{
		isEnter = true;
		hideStartPage();
		showPan();
		$("#pan").click(onClickPan);
		$("#guide").click(onClickPan);
	}
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

function turntable(aLuckyCode)
{
	var code = 0;
	var fixLucky = [0, 4, 5, 3, 7, 1];
	var fixZero = [0, 2, 6];
	var startDeg = startDeg = 360 / 9;
	
	if (aLuckyCode >= 0 && aLuckyCode <= 5)
	{
		if (0 == aLuckyCode)
		{
			code = fixZero[loseCode];
		}
		else
		{
			code = fixLucky[aLuckyCode];
		}
	}
	startDeg += 2160 + (~~code - 1) * 360 / 9;
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
	var prize = '';
	var danWei = '';
	
	hidePan();
	$("#dialog").show();
	if (luckyCode >= 1 && luckyCode <= 5)
	{
		prize = prizeConfig[luckyCode - 1];
		danWei = prizeDanWei[luckyCode - 1];
		$("#tip").html("<p class='title'>DUANG</p>恭喜你获得了<br /><p class='prize-name'>" + prize + danWei + "！</p><br /><p class='bold'>获奖兑换码：" + getCode + "</p><p class='red'>（注意截图保存）</p>");
	}
	else
	{
		switch (loseCode)
		{
			case 0:
				$("#tip").html("<p class='title'>呵呵，没中</p>中奖这东西，<br />一是要看天赋，二是要看运气。<br />天赋是看你天生有没有运气，<br />运气呢是要看你天赋怎么样。");
				break;
			case 1:
				$("#tip").html("<p class='title2'>呵呵，没中</p><br />抽奖得趁早，<br />明天早点试试~");
				break;
			case 2:
				$("#tip").html("<p class='title2'>呵呵，没中</p><br />青山不改，绿水长流<br />大侠，咱们后会有期<br />");
				break;
			default:
				$("#tip").html("<p class='title'>呵呵，没中</p>中奖这东西，<br />一是要看天赋，二是要看运气。<br />天赋是看你天生有没有运气，<br />运气呢是要看你天赋怎么样。");
		}
	}
}

function showLose()
{
	hidePan();
	$("#dialog").show();
	switch (loseCode)
	{
		case 0:
			$("#tip").html("<p class='title'>呵呵，没中</p>中奖这东西，<br />一是要看天赋，二是要看运气。<br />天赋是看你天生有没有运气，<br />运气呢是要看你天赋怎么样。");
			break;
		case 1:
			$("#tip").html("<p class='title2'>呵呵，没中</p><br />抽奖得趁早，<br />明天早点试试~");
			break;
		case 2:
			$("#tip").html("<p class='title2'>呵呵，没中</p><br />青山不改，绿水长流<br />大侠，咱们后会有期<br />");
			break;
		default:
			$("#tip").html("<p class='title'>呵呵，没中</p>中奖这东西，<br />一是要看天赋，二是要看运气。<br />天赋是看你天生有没有运气，<br />运气呢是要看你天赋怎么样。");
	}
}

function showStartPage()
{
	$("#startPage").show();
}

function hideStartPage()
{
	$("#startPage").hide();
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
