<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="css/mobile.css?v=2015.5.23_18.18"/>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/hammer.min.js"></script>
</head>
<body class="rank">
<div class="appName">Zero2Hero</div>
<div class="header non-ht">
	<div class="page-title">
		<div class="preview" id="previewBtn"><a href="javascript:void(0);">Preview</a></div>
		<div class="rank-sort current">Create</div>
		<div class="new-upload" id="uploadBtn"><a href="javascript:void(0);">Upload</a></div>
	</div>
</div>
<div class="upload-body">
	<div class="photo-bg"><img src="images/mobile/bg.jpg"></div>
	<div class="today-photo">
		<img id="topPhoto" src="images/mobile/photo4.png"/>
		<input id="topTxt" type="text" placeholder="Many years ago"/>
	</div>
	<div class="ago-photo">
		<img id="bottomPhoto" src="images/mobile/photo4.png"/>
		<input id="bottomTxt" type="text" placeholder="Nowadays"/>
	</div>
	<div class="ctrl-btn">
		<a href="javascript:;" class="more-bg"><img src="images/mobile/more_bg.png"></a>
		<!--<a href="javascript:void(0);" class="share"><img src="images/mobile/share2.png"></a>-->
	</div>
</div>
<div class="more-bg-box">
	<div class="wrapper">
		<div class="item">
			<img src="images/mobile/bg_small_3.jpg" alt=""/>
			<span class="selected-icon"><img src="images/mobile/chosen_bg.png" alt=""/></span>
		</div>
		<div class="item"><img src="images/mobile/bg_small_2.jpg" alt=""/></div>
		<div class="item"><img src="images/mobile/bg_small_4.jpg" alt=""/></div>
		<div class="item"><img src="images/mobile/bg_small_5.jpg" alt=""/></div>
		<div class="item"><img src="images/mobile/bg_small_6.jpg" alt=""/></div>
		<div class="item"><img src="images/mobile/bg_small_7.jpg" alt=""/></div>
		<div class="item"><img src="images/mobile/bg_small_8.jpg" alt=""/></div>
		<div class="item"><img src="images/mobile/bg_small_1.jpg" alt=""/></div>
	</div>
</div>
<div class="bottom-nav">
	<div class="link-rank"><a href="?m=mwzero&a=rank" target="_self">Rank</a></div>
	<div class="link-show"><a href="?m=mwzero&a=create" target="_self">Create</a></div>
	<div class="link-me"><a href="?m=mwzero&a=history" target="_self">Me</a></div>
</div>
<div class="dialog upload-dialog">
	<div class="title">&nbsp;&nbsp;Upload</div>
	<div id="selectBtn" class="upload-selected"><span>Select photo</span>
		<input type="file" onchange="selectImage(this);" />
	</div>
	<!--<div class="delete"><a href="#">Delete</a></div>-->
	<div class="bottom">
		<div class="cancel-btn"><a href="javascript:;">Cancel</a></div>
	</div>
</div>
<div class="dialog delete-dialog">
	<div class="title">Delete</div>
	<div class="alert-text">Really delete?</div>
	<div class="bottom">
		<div class="cancel-btn"><a href="javascript:;">Cancel</a></div>
		<div class="comfirm-btn"><a href="javascript:;">Ok</a></div>
	</div>
</div>
<canvas id="cv" class="c-cv" width="764px" height="616px">
Your browser does not support the canvas element.
</canvas>
<script type="text/javascript">
var cv = null;
var cxt = null;
var bg = null;
var frame1 = null;
var frame2 = null;
var top1 = null;
var top2 = null;
var top3 = null;
var top4 = null;
var logo = null;
var photo1 = null;
var photo2 = null;
var bgs = [];
var isLoadBg = false;
var isLoadFrame1 = false;
var isLoadFrame2 = false;
var isLoadTop1 = false;
var isLoadTop2 = false;
var isLoadTop3 = false;
var isLoadTop4 = false;
var isLoadLogo = false;
var isLoadPhoto1 = false;
var isLoadPhoto2 = false;
var bgIndex = 0;
var photoIndex = 0;

bg = new Image();
frame1 = new Image();
frame2 = new Image();
top1 = new Image();
top2 = new Image();
top3 = new Image();
top4 = new Image();
logo = new Image();
photo1 = new Image();
photo2 = new Image();

for (var i = 0; i < 8; i++)
{
	bgs[i] = new Image();
}

bg.onload = loadBg;
frame1.onload = loadFrame1;
frame2.onload = loadFrame2;
top1.onload = loadTop1;
top2.onload = loadTop2;
top3.onload = loadTop3;
top4.onload = loadTop4;
logo.onload = loadLogo;
photo1.onload = loadPhoto1;
photo2.onload = loadPhoto2;

$(document).ready(function()
{
	cv = document.getElementById("cv");
	cxt = cv.getContext("2d");
	bg.src = "images/mobile/bg_3.jpg";
	frame1.src = "images/mobile/frame1.png";
	frame2.src = "images/mobile/frame2.png";
	top1.src = "images/mobile/top1.png";
	top2.src = "images/mobile/top2.png";
	top3.src = "images/mobile/year1.png";
	top4.src = "images/mobile/year2.png";
	logo.src = "images/mobile/logo_left.png";
	
	for (var i = 0; i < 8; i++)
	{
		bgs[i].src = "images/mobile/bg_" + (i + 1) + ".jpg";
	}
	
	//photo1.src = "images/mobile/bg_2.jpg";
	//photo2.src = "images/mobile/bg_4.jpg";
	
	$("#selectBtn").click(onClickSelect);
	$("#topPhoto").click(onClickTopPhoto);
	$("#bottomPhoto").click(onClickBottomPhoto);
	$("#previewBtn").click(onClickPreview);
	$("#uploadBtn").click(onClickUpload);
	$("#cv").click(onClickCv);
});

function onClickSelect(e)
{
	$(this).closest(".dialog").hide();
}

function onClickTopPhoto(e)
{
	photoIndex = 0;
}

function onClickBottomPhoto(e)
{
	photoIndex = 1;
}

function onClickPreview(e)
{
	if (isLoadBg && isLoadFrame1 && isLoadFrame2 && isLoadTop1 && isLoadTop2 && isLoadTop3 && isLoadTop4 && isLoadLogo && isLoadPhoto1 && isLoadPhoto2)
	{
		drawPic();
		$("#cv").show();
	}
	else
	{
		alert("Upload two picture first.");
	}
}

function onClickUpload(e)
{
	if (isLoadBg && isLoadFrame1 && isLoadFrame2 && isLoadTop1 && isLoadTop2 && isLoadTop3 && isLoadTop4 && isLoadLogo && isLoadPhoto1 && isLoadPhoto2)
	{
		drawPic();
		isLoadPhoto1 = false;
		isLoadPhoto2 = false;
		$("#topPhoto").attr("src", "images/mobile/photo4.png");
		$("#bottomPhoto").attr("src", "images/mobile/photo4.png");
		$("#topTxt").val("");
		$("#bottomTxt").val("");
		$.post("?m=mwzero&a=uploadPic", {img: cv.toDataURL("image/jpeg", 0.9).replace("data:image/jpeg;base64,", "")}, onUpload);
	}
	else
	{
		alert("Upload two picture first.");
	}
}

function onUpload(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("Unknown error!");
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			alert("Upload completed!");
			break;
		default:
			alert(res.info);
	}
}

function onClickCv(e)
{
	$("#cv").hide();
}

function selectImage(file)
{
	var reader = null;
	
	if (!file.files || !file.files[0])
	{
		return;
	}
	reader = new FileReader();
	reader.onload = function(e)
	{
		switch (photoIndex)
		{
			case 0:
				$("#topPhoto").attr("src", e.target.result);
				photo1.src = e.target.result;
				isLoadPhoto1 = true;
				break;
			case 1:
				$("#bottomPhoto").attr("src", e.target.result);
				photo2.src = e.target.result;
				isLoadPhoto2 = true;
				break;
			default:
		}
	}
	reader.readAsDataURL(file.files[0]);
}

function loadBg()
{
	isLoadBg = true;
}

function loadFrame1()
{
	isLoadFrame1 = true;
}

function loadFrame2()
{
	isLoadFrame2 = true;
}

function loadTop1()
{
	isLoadTop1 = true;
}

function loadTop2()
{
	isLoadTop2 = true;
}

function loadTop3()
{
	isLoadTop3 = true;
}

function loadTop4()
{
	isLoadTop4 = true;
}

function loadLogo()
{
	isLoadLogo = true;
}

function loadPhoto1()
{
	//isLoadPhoto1 = true;
}

function loadPhoto2()
{
	//isLoadPhoto2 = true;
}

function drawPic()
{
	var dx = 0;
	var topStr = "";
	var bottomStr = "";
	
	if (isLoadBg && isLoadFrame1 && isLoadFrame2 && isLoadTop1 && isLoadTop2 && isLoadTop3 && isLoadTop4 && isLoadLogo && isLoadPhoto1 && isLoadPhoto2)
	{
		cxt.clearRect(0, 0, cv.width, cv.height);
		cxt.drawImage(bg, 0, 0, 764, 616);
		cxt.drawImage(frame1, 22, 122);
		cxt.drawImage(frame2, 386, 107);
		
		cxt.rotate(4.5 * Math.PI / 180);
		if (photo1.width < photo1.height)
		{
			dx = (photo1.height - photo1.width) / 2;
			cxt.drawImage(photo1, 0, dx, photo1.width, photo1.width, 72, 128, 283, 283);
		}
		else
		{
			dx = (photo1.width - photo1.height) / 2;
			cxt.drawImage(photo1, dx, 0, photo1.height, photo1.height, 72, 128, 283, 283);
		}
		
		cxt.rotate(-5 * Math.PI / 180);
		if (photo2.width < photo2.height)
		{
			dx = (photo2.height - photo2.width) / 2;
			cxt.drawImage(photo2, 0, dx, photo2.width, photo2.width, 395, 124, 309, 309);
		}
		else
		{
			dx = (photo2.width - photo2.height) / 2;
			cxt.drawImage(photo2, dx, 0, photo2.height, photo2.height, 395, 124, 309, 309);
		}
		
		cxt.rotate(0.5 * Math.PI / 180);
		cxt.drawImage(top1, 130, 118);
		cxt.drawImage(top2, 470, 98);
		cxt.drawImage(top3, 175, 468);
		cxt.drawImage(top4, 485, 468);
		cxt.drawImage(logo, 18, 15);
		
		topStr = $("#topTxt").val();
		bottomStr = $("#bottomTxt").val();
		topStr = topStr.substr(0, 50);
		bottomStr = bottomStr.substr(0, 50);
		
		cxt.font = "18px arial";
		cxt.fillStyle = "#000000";
		cxt.rotate(4.5 * Math.PI / 180);
		cxt.fillText(topStr, 70, 443, 284);
		cxt.rotate(-4.5 * Math.PI / 180);
		cxt.fillText(bottomStr, 398, 462, 312);
	}
}
</script>
<script>
	$(function(){
		var bodyWidth = $("body").width(),
		bgItemWidth = (bodyWidth - 20) / 3,
		length      =  $(".more-bg-box .item").length,
		wrapperWidth = (bgItemWidth + 10) * length - 10;
		$(".upload-body").height(1022/720*bodyWidth)
		$(".more-bg-box .wrapper").width(wrapperWidth).find(".item>img").width(bgItemWidth)
		$(".today-photo img,.ago-photo img").click(function(){
			$(".upload-dialog").fadeIn()
		})
		$(".cancel-btn a").click(function(){
			$(this).closest(".dialog").fadeOut()
		})
		$(".upload-dialog .delete a").click(function(){
			$(".upload-dialog").fadeOut();
			$(".delete-dialog").fadeIn();
		});
		$(".ctrl-btn .more-bg").click(function(){
			var boxHeight = Math.round(bgItemWidth * (223/339))
			if($(".more-bg-box").height() === 0){
				$(".more-bg-box").height(boxHeight).css("opacity",1)
				$("body").animate({"scrollTop" : $("body").scrollTop() + boxHeight + "px"},300)
			}
			else{
				$("body").animate({"scrollTop" : $("body").scrollTop() - boxHeight + "px"},300,function(){
					$(".more-bg-box").height(0).css("opacity",0)
				})
			}

		});
		$(".more-bg-box .item img").click(function(){
			$(".more-bg-box .item").each(function(){
				if($(this).find(".selected-icon").length > 0){
					$(this).find(".selected-icon").remove();
				}
			});
			$(this).closest(".item").append('<span class="selected-icon"><img src="images/mobile/chosen_bg.png" alt=""/></span>');
			
			bgIndex = $(this).closest(".item").index();
			switch (bgIndex)
			{
				case 0:
					bg.src = "images/mobile/bg_3.jpg";
					break;
				case 1:
					bg.src = "images/mobile/bg_2.jpg";
					break;
				case 2:
					bg.src = "images/mobile/bg_4.jpg";
					break;
				case 3:
					bg.src = "images/mobile/bg_5.jpg";
					break;
				case 4:
					bg.src = "images/mobile/bg_6.jpg";
					break;
				case 5:
					bg.src = "images/mobile/bg_7.jpg";
					break;
				case 6:
					bg.src = "images/mobile/bg_8.jpg";
					break;
				case 7:
					bg.src = "images/mobile/bg_1.jpg";
					break;
				default:
					bg.src = "images/mobile/bg_3.jpg";
			}
		});
		
		var hammer = new Hammer($(".more-bg-box .wrapper").get(0));
		hammer.on("swipeleft",function(){
			var scrollLeft = $(".more-bg-box").get(0).scrollLeft;
			if(scrollLeft < bgItemWidth * (length - 3))
				$(".more-bg-box").stop().animate({"scrollLeft":bgItemWidth + scrollLeft + 10 + "px"},300)
		})
		hammer.on("swiperight",function(){
			var scrollLeft = $(".more-bg-box").get(0).scrollLeft;
			if(scrollLeft >= bgItemWidth)
				$(".more-bg-box").stop().animate({"scrollLeft":scrollLeft - bgItemWidth  -10 + "px"},300)
		})
	})
</script>
</body>
</html>
