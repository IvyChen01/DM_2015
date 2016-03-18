<?php //if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>爆笑打乌龟</title>
<link href="css/common.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container">
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="550" height="450" id="loading" align="middle">
		<param name="movie" value="swf/loading.swf" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="#333333" />
		<param name="play" value="true" />
		<param name="loop" value="true" />
		<param name="wmode" value="window" />
		<param name="scale" value="showall" />
		<param name="menu" value="true" />
		<param name="devicefont" value="false" />
		<param name="salign" value="" />
		<param name="allowScriptAccess" value="sameDomain" />
		<!--[if !IE]>-->
		<object type="application/x-shockwave-flash" data="swf/loading.swf" width="550" height="450">
			<param name="movie" value="swf/loading.swf" />
			<param name="quality" value="high" />
			<param name="bgcolor" value="#333333" />
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
				<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="获得 Adobe Flash Player" />
			</a>
		<!--[if !IE]>-->
		</object>
		<!--<![endif]-->
	</object>
</div>
<br />
<div style="text-align: center;">
	user id: <?php echo $_['userId']; ?><br />
<a href="javascript:addPage('<?php echo $_['pagetab_uri']; ?>');">addPage</a><br />
</div>

<script type="text/javascript">
	window.fbAsyncInit = function()
	{
		FB.init({
			appId: "<?php echo $_['fbAppId']; ?>",
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
		FB.login(function(response){});
	}
	
	function feed(link, picture)
	{
		FB.ui(
		  {
		    method: 'feed',
		    name: 'Tecno app',
		    link: link,
		    picture: picture,
		    caption: 'Tecno app',
		    description: 'Tecno app'
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
