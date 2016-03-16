<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>tecno-mobile</title>
    <link rel="stylesheet" href="/Public/css/grid.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/reset.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/default.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/jquery.bxslider.css" media="screen" title="no title" charset="utf-8">
    <link rel="shortcut icon" href="/Public/Img/logo/favicon.ico">
    <style media="screen">
    @media(min-width:780px){
      .content.slide{height:100%}
    }
    </style>
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
				<li><a href="<?php echo U('Home/Index/index','','');?>" class="active"><?php echo (L("home")); ?></a></li>
				<li class="addall"><a href="<?php echo U('Home/Product/index','','');?>"><?php echo (L("product")); ?></a>
          <ul class="tele-products">
            <li><a href="<?php echo U('Home/Product/index','','');?>"><?php echo (L("all")); ?></a></li>
            <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            <!-- <li><a href="javascript:;">Phantom</a></li>
            <li><a href="javascript:;">Boom</a></li>
            <li><a href="javascript:;">Other Smart Phones</a></li>
            <li><a href="javascript:;">Tablets</a></li>
            <li><a href="javascript:;">Feature Phones</a></li> -->
          </ul>
        </li>
				<li><a href="<?php echo U('Home/Article/index','','');?>"><?php echo (L("news")); ?></a></li>
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
          <!-- <li><a href="javascript:;"><div class="icon phantom"></div><i class="addnav-title">Phantom</i></a></li>
          <li><a href="javascript:;"><div class="icon boom"></div><i class="addnav-title">Boom</i></a></li>
          <li><a href="javascript:;"><div class="icon other"></div><i class="addnav-title">Other Smart Phones</i></a></li>
          <li><a href="javascript:;"><div class="icon feature"></div><i class="addnav-title">Feature Phones</i></a></li>
          <li><a href="javascript:;"><div class="icon table"></div><i class="addnav-title">Tablets</i></a></li> -->
        </ul>
      </div>
    </section>
    <!--end addnav desktop-->

    <div class="content slide">
      <!--bxslider-->
      <div class="home-slide">
        <ul id="bxslider">
          <?php if(is_array($adsList)): $i = 0; $__LIST__ = $adsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($avo["adURL"]); ?>" style="background-image:url(<?php echo ($avo["adFile"]); ?>)"><img src="<?php echo ($avo["adFile"]); ?>" class="hide-dp" alt="" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="star-product hide-dl" id="starproducts">
          <a href="javascropt:;" class="closestar">×</a>
          <a href="#starproducts" class="trigger">
            <span class="scroll-arrow"></span>
            <?php echo (L("product_star")); ?>
          </a>
        </div>
      </div>

      <!--moduletable-->
      <div class="moduletable-container">
      <div class="moduletable">
        <div class="headerable">
          <?php echo (L("product_star")); ?>
        </div>
        <ul id="moduletable">
          <?php if(is_array($recommGoodsList)): $i = 0; $__LIST__ = $recommGoodsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rvo): $mod = ($i % 2 );++$i;?><li class="purple"><div class="pic"><img src="<?php echo ($rvo['goodsImg']); ?>" alt="" /></div>
            <div class="details"><h2><?php echo ($rvo['goodsName']); ?></h2>
              <div class="btn-container"><a href="<?php echo U('Home/Product/getGoodsDetail',array('goodsCatId1'=>$rvo['goodsCatId1'],'goodsCatId2'=>$rvo['goodsCatId2'],'goodsId'=>$rvo['goodsId']));?>" class="btn">Learn More</a></div>
            </div>
          </li><?php endforeach; endif; else: echo "" ;endif; ?>
         

          <!-- <li class="blue"><div class="pic"><img src="/Public/Img/test/ad_m6.png" alt="" /></div>
            <div class="details"><h2>J7</h2>
              <div class="btn-container"><a href="javascript:;" class="btn">En savoir plus</a></div>
            </div>
          </li>

          <li class="green"><div class="pic"><img src="/Public/Img/test/ad_z_mini.png" alt="" /></div>
            <div class="details"><h2>J7</h2>
              <div class="btn-container"><a href="javascript:;" class="btn">En savoir plus</a></div>
            </div>
          </li>

          <li class="blue"><div class="pic"><img src="/Public/Img/test/ad_h6.png" alt="" /></div>
            <div class="details"><h2>J7</h2>
              <div class="btn-container"><a href="javascript:;" class="btn">En savoir plus</a></div>
            </div>
          </li> -->
        </ul>
      </div></div>
      <!--end moduletable-->

      <!--last news-->
      <div class="lastnews">
        <ul>
          <li class="press-block block purple">
            <div class="icon-wrapper clearfloat">
              <span class="icon press"></span>
                <?php echo (L("press_reless")); ?></div>
              <ul class="press-list">
                 <?php if(is_array($articleList)): $i = 0; $__LIST__ = array_slice($articleList,0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$atvo): $mod = ($i % 2 );++$i;?><li class="press-item"><a href="<?php echo U('Home/Article/detail',array('cid'=>$atvo['cid'],'id'=>$atvo['id']));?>" class="clearfloat">
                  <span class="date-wrapper">
                    <span class="date"><?php echo ($atvo['day']); ?></span><span class="month"><?php echo ($atvo['mon']); ?>,<?php echo ($atvo['year']); ?></span>
                  </span>
                  <span class="details-wrapper"><span class="title"><?php echo ($atvo['title']); ?></span>
                    <span class="desc"><?php echo ($atvo['description']); ?>
                  </span>
                </a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                <!-- <li class="press-item"><a href="javascript:;" class="clearfloat">
                  <span class="date-wrapper">
                    <span class="date">9th</span><span class="month">Apr,15</span>
                  </span>
                  <span class="details-wrapper"><span class="title">Mini Z PHANTOM TECNO qui vous fascine</span>
                    <span class="desc">Étant le tout premier téléphone TECNO sortie pour 2015, le Phantom Z Mini (alias mini-Z</span>
                  </span>
                </a></li>

                <li class="press-item"><a href="javascript:;" class="clearfloat">
                  <span class="date-wrapper">
                    <span class="date">9th</span><span class="month">Apr,15</span>
                  </span>
                  <span class="details-wrapper"><span class="title">Mini Z PHANTOM TECNO qui vous fascine</span>
                    <span class="desc">Étant le tout premier téléphone TECNO sortie pour 2015, le Phantom Z Mini (alias mini-Z</span>
                  </span>
                </a></li>

                <li class="press-item"><a href="javascript:;" class="clearfloat">
                  <span class="date-wrapper">
                    <span class="date">9th</span><span class="month">Apr,15</span>
                  </span>
                  <span class="details-wrapper"><span class="title">Mini Z PHANTOM TECNO qui vous fascine</span>
                    <span class="desc">Étant le tout premier téléphone TECNO sortie pour 2015, le Phantom Z Mini (alias mini-Z</span>
                  </span>
                </a></li> -->

              </ul>
          </li>


          <li class="updates-block block grey">
            <div class="campaigns">
              <div class="icon-wrapper clearfloat">
                <span class="icon campaigns"></span>
                                <?php echo (L("campagnes")); ?>
              </div>
              <?php if(is_array($articleList2)): $i = 0; $__LIST__ = array_slice($articleList2,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$atvo2): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Home/Article/detail',array('cid'=>$atvo2['cid'],'id'=>$atvo2['id']));?>" class="pic-wrapper"><img src="<?php echo ($atvo2['thumbnail']); ?>" class="pic" alt="Campaignes" /></a>
              <div class="details-wrapper">
                <h2><?php echo ($atvo2['title']); ?></h2>
                <p>
                  <?php echo ($atvo2['description']); ?>
                </p>
                <a href="<?php echo U('Home/Article/detail',array('cid'=>$atvo2['cid'],'id'=>$atvo2['id']));?>"class="btn"><?php echo (L("learn_more")); ?></a>
              </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
          </li>

          <li class="updates-block block light-grey">
            <div class="reviews">
              <div class="icon-wrapper clearfloat">
                <span class="icon reviews"></span>
                    <?php echo (L("reviews")); ?>
              </div>
              <?php if(is_array($articleList3)): $i = 0; $__LIST__ = array_slice($articleList3,0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$atvo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Home/Article/detail',array('cid'=>$atvo['cid'],'id'=>$atvo['id']));?>" class="pic-wrapper video-popup" id="video-open">
                <img src="<?php echo ($atvo['thumbnail']); ?>" class="pic" alt="Reviews" />
                <div class="btn-play" data-video="<?php echo ($atvo['vediourl']); ?>">
                  <img src="/Public/Img/logo/video-play.png"  alt="Play" />
                </div>
              </a>
              <div class="details-wrapper">
                <h2><?php echo ($atvo['title']); ?></h2>
                <p>
                  <?php echo ($atvo['description']); ?>
                </p>
                <a href="<?php echo U('Home/Article/detail',array('cid'=>$atvo3['cid'],'id'=>$atvo['id']));?>" class="btn"><?php echo (L("learn_more")); ?></a>
              </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
          </li>

        </ul>
      </div>
      <!--end last news-->

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
          <iframe id="ifrm" frameboder="0" allowfullscreen></iframe>
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
             
            <!-- <li><a href="http://123.56.100.227/fr/component/products/category/4">Fantôme</a></li>
            <li><a href="http://123.56.100.227/fr/component/products/category/5">Boom</a></li>
            <li><a href="http://123.56.100.227/fr/component/products/category/2">Autres téléphones intelligents</a></li>
            <li><a href="http://123.56.100.227/fr/component/products/category/3">Tablettes</a></li>
            <li><a href="http://123.56.100.227/fr/component/products/category/1">Fonctionnalité des téléphones</a></li> -->
          </ul>

          <ul>
            <li class="title"><a href="<?php echo U('Home/Article/index','','');?>"><?php echo (L("news")); ?></a></li>
            <?php if(is_array($articleCatList)): $i = 0; $__LIST__ = $articleCatList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Article/articleCatDetail',array('catId'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            
            <!-- <li><a href="<?php echo U('Home/Article/index',array('catId'=>'38'));?>"><?php echo (L("press_reless")); ?></a></li> -->
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
  
  <!-- <script src="/Public/Js/jquery.js" charset="utf-8"></script> -->
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
	  });
  function select_en(){
 	 url = '/index.php?format=feed&type=rss&lang=en';
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
	 url = '/index.php?format=feed&type=rss&lang=en';
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