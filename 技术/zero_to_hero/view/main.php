<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zero to Hero</title>
<link href="./css/index.min.css?v=2015.7.6_11.13" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="flashContent">
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="810" height="654" id="loading" align="middle">
		<param name="movie" value="swf/main.swf?type=<?php echo $_configType; ?>&v=2015.7.6_11.13" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="#FFFFFF" />
		<param name="play" value="true" />
		<param name="loop" value="true" />
		<param name="wmode" value="window" />
		<param name="scale" value="showall" />
		<param name="menu" value="true" />
		<param name="devicefont" value="false" />
		<param name="salign" value="" />
		<param name="allowScriptAccess" value="sameDomain" />
		<!--[if !IE]>-->
		<object type="application/x-shockwave-flash" data="swf/main.swf?type=<?php echo $_configType; ?>&v=2015.7.6_11.13" width="810" height="654">
			<param name="movie" value="swf/main.swf?type=<?php echo $_configType; ?>&v=2015.7.6_11.13" />
			<param name="quality" value="high" />
			<param name="bgcolor" value="#FFFFFF" />
			<param name="play" value="true" />
			<param name="loop" value="true" />
			<param name="wmode" value="window" />
			<param name="scale" value="showall" />
			<param name="menu" value="true" />
			<param name="devicefont" value="false" />
			<param name="salign" value="" />
			<param name="allowScriptAccess" value="sameDomain" />
		<!--<![endif]-->
			<a href="http://www.adobe.com/go/getflash">
				<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" />
			</a>
		<!--[if !IE]>-->
		</object>
		<!--<![endif]-->
	</object>
</div>
<script type="text/javascript">
var isFb = <?php echo $_isFb ? "true" : "false"; ?>;

function rank()
{
	document.location.href = "?m=fbzero&a=topTotal";
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
