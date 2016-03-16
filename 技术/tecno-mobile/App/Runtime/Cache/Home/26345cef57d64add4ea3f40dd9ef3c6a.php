<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Buzz - TECNO</title>
    <link rel="stylesheet" href="/Public/css/grid.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/reset.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/default.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/jquery.bxslider.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/buzz.css" media="screen" title="no title" charset="utf-8">
    <link rel="shortcut icon" href="/Public/Img/logo/favicon.ico">
    <!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<![endif]-->
  </head>
  <body id="top" class="english">
    <!--nav-->
<header class="slide">
    			<ul id="navToggle" class="burger slide">
    				<li></li><li></li><li></li>
    			</ul>
    			<a href="<?php echo U('Home/Index/index','','');?>" class="head-brand"><img src="/Public/Img/logo/brand.png" class="img-res" alt="brand" /></a>


          <!--select lang-->
          <div class="select_down" id="sel">
            <dl class="">
              <dt><h3>CHANGE LANGUAGE</h3><a href="javascript:;"></a></dt>
              <ul>
                <li><a href="javascript:select_en()">English</a></li>
                <li><a href="javascript:select_fr()">French</a></li>
              </ul>
            </dl>
          </div>
          <!--end select lang-->

          <div class="searchbox rightRs">
            <input type="text" class="search-int" name="name" value="">
            <a href="javascript:;" class="searchbtn"><img src="/Public/Img/logo/tecno-search.png" alt="" /></a>
          </div>
    </header>
    <!--/nav-->
    <nav class="slide">
			<ul>
				<li><a href="<?php echo U('Home/Index/index','','');?>"><?php echo (L("home")); ?></a></li>
				<li class="addall"><a href="<?php echo U('Home/Product/index','','');?>"><?php echo (L("product")); ?></a>
          <ul class="tele-products">
             <li><a href="<?php echo U('Home/Product/index','','');?>"><?php echo (L("all")); ?></a></li>
            <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </li>
				<li><a href="<?php echo U('Home/Article/index','','');?>" class="active"><?php echo (L("news")); ?></a></li>
				<li><a href="<?php echo U('Home/Index/service','','');?>"><?php echo (L("retail_center")); ?></a></li>
				<li><a href="http://bbs.tecno-mobile.com/">TECNO SPOT</a></li>
				<li><a href="<?php echo U('Home/Index/contact','','');?>"><?php echo (L("contact_us")); ?></a></li>
			</ul>
		</nav>
<!--div tecnonav-->
    <!--addnav desktop-->
    <section>
      <div class="addnav">
        <ul>
          <li><a href="<?php echo U('Home/Product/index','','');?>"><div class="icon all"></div><i class="addnav-title"><?php echo (L("all")); ?></i></a></li>
           <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>"><div class="icon" id="goodscat<?php echo ($i); ?>"></div><i class="addnav-title"><?php echo ($vo['catName']); ?></i></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
    </section>
    <!--end addnav desktop-->

    <div class="content slide">


      <!--buzz main wrapper-->
      <div class="buzz-main-wrapper">
        <div class="buzz-nav-wrapper articles-menu clearfloat">
          <a href="javascript:;" class="articles-menu-btn"><img src="/Public/Img/logo/mobile-menu-icon.png" alt="Menu" /></a>
          <ul class="fourth">
            <?php if(is_array($articleCatList)): $i = 0; $__LIST__ = array_slice($articleCatList,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li id='articleCat<?php echo ($vo['catId']); ?>'><a href="<?php echo U('Home/Article/articleCatDetail',array('catId'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </div>


        <!--articles-wrapper-->
        <div class="articles-wrapper">
          <ul id="articles">
            <?php if(is_array($articleList)): $i = 0; $__LIST__ = $articleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pvo): $mod = ($i % 2 );++$i;?><li><div class="item-wrapper">
              <div class="content-articles">
                <a href="<?php echo U('Home/Article/detail',array('cid'=>$pvo['cid'],'id'=>$pvo['id']));?>" class="pic"><img src="<?php echo ($pvo['thumbnail']); ?>"  /></a>
                <h2><?php echo ($pvo['title']); ?></h2>
                <p><?php echo ($pvo['description']); ?></p>
              </div>
              <div class="btns-wrapper">
                <div class="content clearfloat">
                  <a href="<?php echo U('Home/Article/detail',array('cid'=>$pvo['cid'],'id'=>$pvo['id']));?>" class="btn blue">Read Article</a>
                </div>
              </div>
            </div></li><?php endforeach; endif; else: echo "" ;endif; ?>
            

            <!-- <li><div class="item-wrapper">
              <div class="content-articles">
                <a href="javascript:;" class="pic"><img src="/Public/Img/test/crownawards.jpg" alt="" /></a>
                <h2>TECNO,sponsor de la Kenya Blog Awards 2015</h2>
                <p>La société Tecno s’est lancé dans l’aventure parce qu'elle croit que les blogueurs jouent un rôle énorme dans la prise de décision des consommateurs.</p>
              </div>
              <div class="btns-wrapper">
                <div class="content clearfloat">
                  <a href="javascript:;" class="btn blue">Lire l'Article</a>
                </div>
              </div>
            </div></li>

            <li><div class="item-wrapper">
              <div class="content-articles">
                <a href="javascript:;" class="pic"><img src="/Public/Img/test/TECNO-innovation_thumb.jpg" alt="" /></a>
                <h2>TECNO,sponsor de la Kenya Blog Awards 2015</h2>
                <p>La société Tecno s’est lancé dans l’aventure parce qu'elle croit que les blogueurs jouent un rôle énorme dans la prise de décision des consommateurs.</p>
              </div>
              <div class="btns-wrapper">
                <div class="content clearfloat">
                  <a href="javascript:;" class="btn blue">Lire l'Article</a>
                </div>
              </div>
            </div></li>

            <li><div class="item-wrapper">
              <div class="content-articles">
                <a href="javascript:;" class="pic"><img src="/Public/Img/test/L6-thumb.jpg" alt="" /></a>
                <h2>TECNO,sponsor de la Kenya Blog Awards 2015</h2>
                <p>La société Tecno s’est lancé dans l’aventure parce qu'elle croit que les blogueurs jouent un rôle énorme dans la prise de décision des consommateurs.</p>
              </div>
              <div class="btns-wrapper">
                <div class="content clearfloat">
                  <a href="javascript:;" class="btn blue">Lire l'Article</a>
                </div>
              </div>
            </div></li> -->

          </ul>
        </div>
        <!--end articles-wrapper-->

      </div>
      <!--end main wrapper-->


      <!--backtotop-->
      <a href="javascript:;" class="back-to-top fade-out">
        <span class="arrow"></span>
        <span class="text"><?php echo (L("back_to_top")); ?></span>
      </a>
      <!--end backtotop-->

      <!--overlay-->
      <div class="overlay"></div>
      <!--end overlay-->
      <!--popup-->
      <div class="popup">
        <a href="javascript:;" id="video-close" class="closevideo"></a>
        <div class="video-content">
          <iframe src="https://www.youtube.com/embed/3rFqbin4h38" frameboder="0" allowfullscreen></iframe>
        </div>
      </div>
      <!--end popup-->

      <!--footer-->
      <div class="footer clearfloat">
        <div class="logo-wrapper clearfloat">
          <a href="<?php echo U('Home/Index/index','','');?>" class="logoset"><img src="/Public/Img/logo/footer-logo.png" alt="TECNO Mobile" /></a>
          <div class="copyright">
            <strong>© 2015 TECNO Mobile.</strong>
          </div>
          <ul class="social">
            <li><a href="https://www.facebook.com/tecnomobile/" target="_block" class="icon facebook">Facebook</a></li>
            <li><a href="https://twitter.com/TecnoAfrica" target="_block" class="icon twitter">Twitter</a></li>
            <li><a href="https://www.youtube.com/user/TecnoTelecomLimited" target="_block" class="icon rss">Youtube</a></li>
          </ul>
          <div class="language-selector">
            <div class="lang-popup">
              <ul>
                <li><a href="<?php echo U('Home/Index/index',array('l'=>'en-gb'));?>">English</a></li>
                <!-- <li><a href="<?php echo U('Home/Index/index','','');?>">العربية</a></li> -->
                <li><a href="<?php echo U('Home/Index/index',array('l'=>'fr-fr'));?>">French</a></li>
              </ul>
            </div>
            <a href="javascript:;" class="select-lang">CHange Language</a>
          </div>
        </div>

        <div class="links-wrapper">
          <ul>
            <li class="title"><a href="<?php echo U('Home/Product/index','','');?>"><?php echo (L("product")); ?></a></li>
            <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>

          <ul>
            <li class="title"><a href="<?php echo U('Home/Article/index','','');?>"><?php echo (L("news")); ?></a></li>
            
            <?php if(is_array($articleCatList)): $i = 0; $__LIST__ = $articleCatList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Article/articleCatDetail',array('catId'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>

          <ul>
            <li class="title"><a href="javascript:void(0);"><?php echo (L("links")); ?></a></li>
            <li><a href="http://www.carlcare.com/"><?php echo (L("carlcare")); ?></a></li>
            <li><a href="/TERMS_AND_CONDITIONS.pdf"><?php echo (L("terms")); ?></a></li>
			<li><a href="http://bbs.tecno-mobile.com/">TECNO forum</a></li>
          </ul>
        </div>
      </div>
      <!--end footer-->

		</div>

   <script src="<?php echo C('STATIC_PATH');?>Plugins/BJUI/js/jquery-1.9.1.js"></script>
  <script src="/Public/Js/jquery.bxslider.min.js" charset="utf-8"></script>
  <script src="/Public/Js/main.js" charset="utf-8"></script>
  <script src="/Public/Js/nav.js" charset="utf-8"></script>
  <script>
  $(function(){
		 $('#goodscat1').addClass('phantom');
		 $('#goodscat2').addClass('boom');
		 $('#goodscat3').addClass('other');
		 $('#goodscat4').addClass('feature');
		 $('#goodscat5').addClass('table');
		 var cid = '<?php echo ($id); ?>';
		 if(cid){
			 $('.fourth li').removeClass('fouactive');
			 $('#articleCat<?php echo ($id); ?>').addClass('fouactive');
		 }else{
			 $('.fourth li:first').addClass('fouactive');
		 }
	  });
  function select_en(){
	 	 url = '/index.php?m=Home&c=Article&a=index';
	 	 var reg = 'l=';
	 	 var r = url.match(reg);
	 	 var regurl = 'index.php';
	 	 var rs = url.match(regurl);
	 	 if(rs==null){
		    url = url + "index.php?l=en-gb"; 
		 }else{
		    if(r==null){
		    	url = url + "&l=en-gb";
		    }else{
		    	url = url.replace('en-gb','');
				url = url.replace('fr-fr','');
				url = url + "en-gb"; 
		    }
				
		}
	 	location.href  = url;
	 }
	 function select_fr(){
		 url = '/index.php?m=Home&c=Article&a=index';
	 	 var reg = 'l=';
	 	 var r = url.match(reg);
	 	 var regurl = 'index.php';
	 	 var rs = url.match(regurl);
	 	 if(rs==null){
		    url = url + "index.php?l=fr-fr"; 
		 }else{
		    if(r==null){
		    	url = url + "&l=fr-fr";
		    }else{
		    	url = url.replace('en-gb','');
				url = url.replace('fr-fr','');
				url = url + "fr-fr"; 
		    }
				
		}
	 	 location.href  = url;
	 }
  </script>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
 
  ga('create', 'UA-59533821-2', 'auto');
  ga('send', 'pageview');
 
</script>
  </body>
</html>