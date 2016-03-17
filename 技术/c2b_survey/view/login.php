<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-5-19
 * Time: 下午4:33
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <link rel="stylesheet" href="/style/master.css"/>
    <script src="style/js/jquery-2.1.0.min.js"></script>
    <script src="/style/js/jquery.browser.js"></script>
</head>
<body>
<script>
    if($.browser.mozilla){}
    else if($.browser.msie){}
    else if($.browser.opera){}
    else if($.browser.webkit){}
    else{
        $("body").prepend($("<div class='no-script' style='z-index:101;background-color: #f2b701;color: #ff2151;position: absolute;width: 100%;height: 100%;top: 0;left: 0;'>This survey is only available to smartphone user.<br>Thank You!</div>"));
    }
</script>
<noscript>
    <div class="no-script" style="background-color: #f2b701;color: #ff2151;">This survey is only available to smartphone user.<br>
        Thank You!</div>
</noscript>
<section id="body">
<div class="home main">
    <div class="home-bg"><img src="/images/home.jpg" alt=""/></div>
    <div class="join-btn"><a href="javascript:;"><img src="/images/login.jpg" alt=""/></a></div>
</div>
    <script>
        $(function(){
            var bodyWidth=$("body").width();
            if(bodyWidth>1000) bodyWidth=1000;
            $(".join-btn img").width(bodyWidth*0.74)
            $(".home-bg").width(bodyWidth);
        })
    </script>
    <script>
        window.onload=function(){
            setTimeout(function() {
                window.scrollTo(0, 1)
            }, 0);
        };
    </script>
</section>
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
	
	$(".join-btn a").click(function(e){onLogin(e)});
	
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