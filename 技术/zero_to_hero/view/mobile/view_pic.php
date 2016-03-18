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
<body class="viewPic">
<div class="header">
    <div class="page-title">
        <a href="<?php echo $_backUrl; ?>" target="_self" class="back" id="backBtn"><img src="images/mobile/m_left_2.png" alt=""/></a>
        <span id="titleTxt">Picture detail</span>
    </div>
</div>
<div class="usv-rks">
	<div class="usv-photo">
		<img src="<?php echo $_picInfo['photo']; ?>"/>
	</div>
	<div class="usv-name"><?php echo $_picInfo['username']; ?></div>
</div>
<div class="pic">
	<img src="<?php echo $_picInfo['pic']; ?>" />
</div>
<!--
<div class="usv-ctrl">
	<a class="likeBtn" picId="<?php echo 123; ?>" isLiked=<?php echo 123; ?> href="javascript:void(0);"><img src="<?php echo (123 == 1) ? 'images/mobile/xin_select.png' : 'images/mobile/xin.png' ?>" alt=""/></a>
	<a class="shareBtn" picId="<?php echo 123; ?>" href="javascript:void(0);"><img src="images/mobile/share.png" alt=""/></a>
	<a class="commentBtn" picId="<?php echo 123; ?>" href="javascript:void(0);"><img src="images/mobile/comment_btn.png" alt=""/></a>
</div>
-->
<div class="line"></div>
<div class="likeNumBox">
	<span><?php echo $_picInfo['num']; ?> Likes</span>
	<span>Top <?php echo $_picInfo['rank']; ?></span>
</div>
<!--
<ul class="commentList">
	<li>
		<div class="pic">
			<img src="" />
		</div>
		<div class="content">
			<p>King</p>
			<p>abadads</p>
			<p>2015-5-23</p>
		</div>
	</li>
</ul>
-->
<script>
var likeImg = new Image();
var likeSelectImg = new Image();

$(document).ready(function()
{
	likeImg.src = "images/mobile/xin.png";
	likeSelectImg.src = "images/mobile/xin_select.png";
	
	$(".likeBtn").click(onClickLike);
	$(".shareBtn").click(onClickShare);
});

function onClickLike(e)
{
	var isLiked = $(this).attr("isLiked");
	var picId = $(this).attr("picId");
	var likeNum = parseInt($(this).parent().siblings(".tal-rks").children(".tal-likes").children(".value").text());
	
	if (isLiked == 0)
	{
		$(this).attr("isLiked", 1);
		$(this).parent().siblings(".tal-rks").children(".tal-likes").children(".value").text(likeNum + 1);
		$(this).children("img").attr("src", "images/mobile/xin_select.png");
		$.post("?m=mwzero&a=like", {picId: picId}, onChange);
	}
}

function onChange(value)
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
			break;
		default:
			alert(res.info);
	}
}

function onClickShare(e)
{
	
}
</script>
</body>
</html>
