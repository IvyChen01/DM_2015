<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>MAKE WISH</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="stylesheet" href="css/layst.css" media="screen" title="no title" charset="utf-8">
    <script src="js/jquery.js" charset="utf-8"></script>
    <script src="js/wish.js" charset="utf-8"></script>
    <script type="text/javascript">
      $(function(){
        var isFb = <?php echo $isFb; ?>;
        if (isFb)
        {
          window.fbAsyncInit = function()
          {
            FB.init({
              appId: "<?php echo $fbAppId; ?>",
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
          FB.login(function(response){ document.location.href = "./?m=wish&a=main"; });
        }
        //function feed(link, picture)
        function feed()
        {
			console.log('feedFB');
          var link = "<?php echo $shareUrl; ?>";
          var picture = "<?php echo $sharePic; ?>";

          if (!isFb)
          {
            return;
          }

          FB.ui(
            {
            method: 'feed',
            name: 'Wish Wall',
            link: link,
            picture: picture,
            caption: 'www.infinixmobility.com',
            description: 'Come to join us now!'
            },
            function(response) {
            //alert("Thanks!");
            location.href = "./?m=wish&a=main";
            }
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

        $('.wishdo').click(function(){feed()})
      })
        </script>
  </head>
  <body>
      <div class="addwish">
        <div class="fit">
            <p class="sy ft12">1111</p>
        </div>
        <div class="wishto">
            <P class="sy ft12">NOTE THE CONTENT</p>
            <textarea class="wishint ft10" rows="8" cols="8"></textarea>
            <ul>
              <li><i class="arr"></i></li>
              <li><i class=""></i></li>
              <li><i class=""></i></li>
              <li><i class=""></i></li>
              <li><i class=""></i></li>
            </ul>
            <a class="maketo sy ft12">SUBMIT</a>
        </div>
        <div class="wishdo">
         <img src="" width="100px" height="100px" alt="" />
          <i class="sename"></i>
          <i class="setime"></i>
          <i class="sesoli"></i>
          <a class="wishdobtn sy ft12" onclick="funconce()">Touch to SHARE</a>
        </div>
      </div>
  </body>
</html>
