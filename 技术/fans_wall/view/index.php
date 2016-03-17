<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Infinix Fans Wall</title>
<link href="css/index.css?v=2015.6.29_13.42" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/favicon.ico"/>
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="header">
	<img src="images/header_810.jpg" width="790px" />
</div>
<div class="sortBox">
	<a href="<?php echo $_sortLink; ?>" target="_self">
		<img src="images/sort_btn.png" class="btnImg"/>
		<p class="btnText"><?php echo $_sortText; ?></p>
	</a>
</div>
<div class="listBox">
	<ul>
		<?php
		$_index = 1;
		foreach ($_fans as $_value) {
		?>
		<li>
			<div class="listLeft">
				<div class="numBox">
					<img src="images/icon_item.png" />
					<p>#<?php echo $_index; ?></p>
				</div>
			</div>
			<div class="listMiddle">
				<img src="<?php echo $_value['photo']; ?>" width="342px" height="342px" />
			</div>
			<div class="listRight">
				<div class="rightWrap">
					<p class="t1"><?php echo $_value['username']; ?></p>
					<p class="t2">On wall from: <?php echo $_value['month']; ?> <?php echo $_value['day']; ?> <?php echo $_value['year']; ?></p>
					<p class="t3"><?php echo $_value['content']; ?></p>
					<div class="likeBox">
						<a class="likeBtn" picId="<?php echo $_value['id']; ?>" isLiked=<?php echo $_value['liked']; ?> href="javascript:void(0);"><img src="images/like.png" width="30px" height="30px" /></a>
						<span class="likeTxt"><?php echo $_value['like_num']; ?></span>
						<a class="shareBtn" picId="<?php echo $_value['id']; ?>" isShared=<?php echo $_value['shared']; ?> href="javascript:void(0);"><img src="images/share.png" width="30px" height="30px" /></a>
						<span class="shareTxt"><?php echo $_value['share_num']; ?></span>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</li>
		<?php
			$_index++;
		}
		?>
	</ul>
</div>
<script type="text/javascript">
$(document).ready(function()
{
	$(".likeBtn").click(onClickLike);
	$(".shareBtn").click(onClickShare);
});

function onClickLike(e)
{
	var isLiked = $(this).attr("isLiked");
	var picId = $(this).attr("picId");
	var likeNum = parseInt($(this).siblings(".likeTxt").text());
	
	if (isLiked == 0)
	{
		$(this).attr("isLiked", 1);
		$(this).siblings(".likeTxt").text(likeNum + 1);
		$.post("?m=fans&a=like", {id: picId}, onChange);
	}
	else
	{
		alert("Liked today!");
	}
}

function onClickShare(e)
{
	var isShared = $(this).attr("isShared");
	var picId = $(this).attr("picId");
	var likeNum = parseInt($(this).siblings(".shareTxt").text());
	
	feed("https://www.facebook.com/InfinixEgypt/app_982042125179995/", "http://www.infinixmobility.com/fb/fanswall/images/share_pic.jpg");
	
	if (isShared == 0)
	{
		$(this).attr("isShared", 1);
		$(this).siblings(".shareTxt").text(likeNum + 1);
		$.post("?m=fans&a=share", {id: picId}, onChange);
	}
	else
	{
		//alert("Shared today!");
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
			alert(res.msg);
	}
}

window.fbAsyncInit = function()
{
	FB.init({
		appId: "982042125179995",
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

function login()
{
	FB.login(function(response){ document.location.href = "./"; });
}

function feed(link, picture)
{
	FB.ui(
	  {
		method: 'feed',
		name: 'Infinix Fans Wall',
		link: link,
		picture: picture,
		caption: 'www.infinixmobility.com',
		description: 'Come to join us now!'
	  },
	  function(response) {}
	);
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
</script>
</body>
</html>
