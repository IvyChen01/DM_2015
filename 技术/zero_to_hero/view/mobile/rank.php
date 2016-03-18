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
<div class="header">
    <div class="page-title">
        <div class="rank-sort current">Rank</div>
        <div class="new-add"><a href="?m=mwzero&a=latest" target="_self">Latest</a></div>
    </div>
</div>
<div class="list-box">
	<div class="wrapper">
		<section id="rankList" class="clearfix">
			<?php foreach ($_data as $_key => $_value) { ?>
			<div class="item">
				<div class="usv-rks">
					<div class="usv-photo">
						<img src="<?php echo $_value['photo']; ?>"/>
					</div>
					<div class="usv-name"><?php echo $_value['username']; ?></div>
				</div>
				<div class="photo-rks"><a href="?m=mwzero&a=viewPic&picId=<?php echo $_value['pic_id']; ?>&pageFlag=1" target="_self"><img src="<?php echo $_value['small_pic']; ?>"/></a></div>
				<div class="tal-rks">
					<div class="tal-top">
						<img src="images/mobile/rank.png"/>
						TOP
						<span class="value"><?php echo $_value['rank']; ?></span>
					</div>
					<div class="tal-likes">
						<span class="value"><?php echo $_value['num']; ?></span>
						likes
					</div>
				</div>
				<div class="usv-ctrl">
					<a class="likeBtn" picId="<?php echo $_value['pic_id']; ?>" isLiked=<?php echo $_value['liked']; ?> href="javascript:void(0);"><img src="<?php echo ($_value['liked'] == 1) ? 'images/mobile/xin_select.png' : 'images/mobile/xin.png' ?>" alt=""/></a>
					<a class="shareBtn" picId="<?php echo $_value['pic_id']; ?>" href="javascript:void(0);"><img src="images/mobile/share.png" alt=""/></a>
				</div>
			</div>
			<?php } ?>
		</section>
	</div>
</div>
<div class="bottom-nav">
	<div class="link-rank"><a href="?m=mwzero&a=rank" target="_self">Rank</a></div>
	<div class="link-show"><a href="?m=mwzero&a=create" target="_self">Create</a></div>
	<div class="link-me"><a href="?m=mwzero&a=history" target="_self">Me</a></div>
</div>
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

/*
$(function(){
	var hammer = new Hammer($(".rank-sort").get(0));
	hammer.on('tap',listSwipeLeft)

	var hammer2 = new Hammer($(".new-add").get(0));
	hammer2.on('tap',listSwipeRight)

	var hammer3 = new Hammer($(".list-box").get(0));
	hammer3.on("swipeleft",listSwipeRight)
	hammer3.on("swiperight",listSwipeLeft)

	function listSwipeLeft(){
		var el = $(".rank-sort");
		$(".list-box").animate({"scrollLeft":0},400)
		if(!el.hasClass("current")){
			$(".new-add").removeClass("current")
			el.addClass("current")
		}
	}
	function listSwipeRight(){
		var el = $(".new-add"),
				width = $("body").width();
		if(!$(".list-box .wrapper").hasClass("wrapper-left")){
			$(".rank-sort").removeClass("current")
			el.addClass("current")
			$(".list-box").animate({"scrollLeft": width},400)
		}
	}
})
*/
</script>
</body>
</html>
