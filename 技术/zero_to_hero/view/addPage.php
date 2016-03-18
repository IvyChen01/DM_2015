<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zero to Hero</title>
</head>

<body>
<a href="javascript:addPage('<?php echo $_appSrcUrl; ?>');">addPage</a>
<script type="text/javascript">
var isFb = <?php echo $_isFb ? "true" : "false"; ?>;

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
</body>
</html>
