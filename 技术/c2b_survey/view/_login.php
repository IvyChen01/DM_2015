<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>问卷调研</title>
</head>
<body>
<input type="button" id="loginBtn" value="Login" />

<script type="text/javascript">
	window.fbAsyncInit = function()
	{
		FB.init({
			appId: "<?php echo $_app_id; ?>",
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
	
	var loginBtn = document.getElementById("loginBtn");
	
	loginBtn.onclick = onLogin;
	
	function onLogin(e)
	{
		login();
	}
	
	function login()
	{
		FB.login(function(response) {
			window.location.reload();
		}, {scope: 'public_profile,email'});
	}
	
	function feed(link, picture)
	{
		FB.ui(
		  {
		    method: 'feed',
		    name: 'faq',
		    link: link,
		    picture: picture,
		    caption: 'faq',
		    description: 'faq'
		  },
		  function(response) {}
		);
	}
	
	function invite()
	{
		FB.ui({method: 'apprequests',
		  message: 'faq'
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
