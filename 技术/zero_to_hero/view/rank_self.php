<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zero to Hero</title>
<link href="css/index.min.css?v=2015.5.7_14.37" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="container">
	<div class="week-panel">
		<div class="nav-btn">
			<a href="./"><img src="images/home_off.png" class="home-off" /></a>
			<img src="images/rank_on.png" class="rank-on" />
		</div>
		<div class="week-main">
			<a href="?m=fbzero&a=topTotal"><div class="bar-con">Top 100</div></a>
			<a href="?m=fbzero&a=latest"><div class="bar-con">Latest Upload</div></a>
			<div class="bar-exp">My Ranking</div>
			<div class="week-list">
				<ul>
					<?php foreach ($_data as $_row) { ?>
					<li>
						<a href="<?php echo $_appUrl; ?>?m=fbzero&a=viewPic&picId=<?php echo $_row['pic_id']; ?>" target="_blank"><img class="main-pic" src="<?php echo $_row['small_pic']; ?>" /></a>
						<div class="week-details">
							<div class="week-left">
								<div class="week-top"><img src="images/name_icon.png" /><?php echo $_row['username']; ?></div>
								<div class="week-bottom"><img src="images/like_icon.png" />likes:<span id="like_<?php echo $_row['pic_id']; ?>"><?php echo $_row['num']; ?></span></div>
							</div>
							<div class="week-right"><a href="javascript:void(0);"><?php if (0 == $_row['liked']) { ?><img class="like-btn" flag="<?php echo $_row['pic_id']; ?>" src="images/like_btn.png" /><?php } ?></a></div>
						</div>
					</li>
					<?php } ?>
				</ul>
			</div>
			<div class="week-page-list"><?php echo $_pagelist; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function()
{
	$(".like-btn").click(onClickLike);
});

function onClickLike(e)
{
	var picId = $(this).attr("flag");
	
	$(this).hide();
	$("#like_" + picId).text(parseInt($("#like_" + picId).text()) + 1);
	$.post("?m=fbzero&a=like", {picId: picId}, null);
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
