<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zero to Hero</title>
<link href="./css/index.min.css?v=2015.5.7_14.37" rel="stylesheet" type="text/css" />
<script src="./js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<?php if ($_isPic) {?>
<div class="comment-panel">
	<a href="<?php echo $_appUrl; ?>" target="_blank"><img class="c-img" src="<?php echo $_picInfo['pic']; ?>" /></a>
	<div class="c-right">
		<div class="c-right-in">
			<div class="c-auth">
				<img class="c-auth-pic" src="<?php echo $_picInfo['photo']; ?>" />
				<div class="c-detail">
					<p class="c-username"><?php echo $_picInfo['username']; ?></p>
					<p class="c-time"><?php echo $_picInfo['upload_time']; ?></p>
				</div>
				<div class="clear"></div>
			</div>
			<p class="c-likeline"><a href="javascript:void(0);" id="likeBtn">Like</a> · <a href="javascript:void(0);" id="commentBtn">Comment</a> · <a href="javascript:void(0);" id="shareBtn">Share</a></p>
			<div class="c-likes">
				<img src="images/comment_like.png" class="c-likes-img" /><span id="likeNumTxt"><?php echo $_picInfo['num']; ?></span> likes &nbsp;&nbsp;&nbsp;&nbsp;<span class="c-likes-join"><a href="<?php echo $_appUrl; ?>" target="_blank"><b>Join</b></a></span>
			</div>
			<ul class="c-list" id="commentList">
				<?php foreach ($_comment as $_row) { ?>
				<li>
					<img class="c-li-photo" src="<?php echo $_row['photo']; ?>" />
					<div class="c-li-detail">
						<p><span class="c-li-name"><?php echo $_row['username']; ?></span> <span class="c-li-commen"><?php echo $_row['content']; ?></span></p>
						<p class="c-li-time"><?php echo $_row['comment_time']; ?></p>
					</div>
				</li>
				<?php } ?>
			</ul>
			<div class="c-input">
				<div class="c-in-block">
					<img src="<?php echo $_selfPhoto; ?>" class="c-in-img" /><input type="text" id="commenTxt" />
				</div>
				<p class="c-tip">Press Enter to post.</p>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?php } else { ?>
404 Not Found!
<?php } ?>


<?php
/*
////// debug
echo '$_picInfo:<br />';
var_dump($_picInfo);
echo '$_comment:<br />';
var_dump($_comment);
echo '$_isLogin: ' . $_isLogin . '<br />';
echo '$_isPic: ' . $_isPic . '<br />';
*/
?>

<script type="text/javascript">
var isFb = <?php echo $_isFb ? "true" : "false"; ?>;
var isLike = false;

$(document).ready(function()
{
	$("#commenTxt").focus();
	$(document).keydown(onDownWindow);
	$("#likeBtn").click(onClickLike);
	$("#commentBtn").click(onClickComment);
	$("#shareBtn").click(onClickShare);
});

function onChange(value)
{
	var res = null;
	var commentStr = "";
	
	if (value.substr(0, 1) != "{")
	{
		alert("Unknown Error!");
		$("#commenTxt").select();
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			$("#commenTxt").val("");
			
			for (var key in res.comments)
			{
			commentStr += '<li><img class="c-li-photo" src="' + res.comments[key]["photo"] + '" /><div class="c-li-detail"><p><span class="c-li-name">' + res.comments[key]["username"] + '</span> <span class="c-li-commen">' + res.comments[key]["content"] + '</span></p><p class="c-li-time">' + res.comments[key]["comment_time"] + '</p></div></li>';
			}
			$("#commentList").html(commentStr);
			break;
		default:
			alert(res.info);
			$("#commenTxt").select();
	}
}

function onDownWindow(e)
{
	var currKey = 0, e = e || event;
	
	currKey = e.keyCode || e.which || e.charCode;
	switch (currKey)
	{
		case 13:
			//回车
			if ("" == $("#commenTxt").val())
			{
				alert("Comment Empty!");
				$("#commenTxt").select();
			}
			else
			{
				$.post("?m=fbzero&a=addComment", {picId: "<?php echo $_picInfo['pic_id'];?>", comment: $("#commenTxt").val()}, onChange);
			}
			break;
		default:
	}
}

function onClickLike(e)
{
	if (isLike)
	{
		alert("Liked Today!");
	}
	else
	{
		isLike = true;
		$.post("?m=fbzero&a=like", {picId: "<?php echo $_picInfo['pic_id'];?>"}, onLike);
	}
}

function onLike(value)
{
	var res = null;
	
	if (value.substr(0, 1) != "{")
	{
		alert("Unknown Error!");
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			$("#likeNumTxt").text(parseInt($("#likeNumTxt").text()) + 1);
			break;
		default:
			alert(res.info);
			$("#commenTxt").select();
	}
}

function onClickComment(e)
{
	$("#commenTxt").select();
}

function onClickShare(e)
{
	feed("<?php echo $_shareLink; ?>", "<?php echo $_picInfo['small_pic']; ?>");
}

if (isFb)
{
	window.fbAsyncInit = function()
	{
		FB.init({
			appId: "<?php echo $_fbAppId; ?>",
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

function login()
{
	FB.login(function(response){ document.location.href = "./"; });
}

function feed(link, picture)
{
	if (!isFb)
	{
		return;
	}
	
	FB.ui(
	  {
		method: 'feed',
		name: 'From Zero to Hero',
		link: link,
		picture: picture,
		caption: 'www.infinixmobility.com',
		description: 'Come to join us now! Time to show your photo from zero to hero.'
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
<?php if ($_configType == 5) { ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62692844-1', 'auto');
  ga('send', 'pageview');

</script>
<?php } else if ($_configType == 6) { ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62684835-1', 'auto');
  ga('send', 'pageview');

</script>
<?php } else if ($_configType == 7) { ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62694847-1', 'auto');
  ga('send', 'pageview');

</script>
<?php } else if ($_configType == 8) { ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62704947-1', 'auto');
  ga('send', 'pageview');

</script>
<?php } ?>
</body>
</html>
