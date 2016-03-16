<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Product_contact</title>
    <link rel="stylesheet" href="/Public/css/grid.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/reset.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/default.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/jquery.bxslider.css" media="screen" title="no title" charset="utf-8">
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
				<li><a href="<?php echo U('Home/Index/index','','');?>" ><?php echo (L("home")); ?></a></li>
				<li class="addall"><a href="<?php echo U('Home/Product/index','','');?>" class="active"><?php echo (L("product")); ?></a>
          <ul class="tele-products">
            <li><a href="<?php echo U('Home/Index/index','','');?>"><?php echo (L("all")); ?></a></li>
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
        </ul>
      </div>
    </section>
    <!--end addnav desktop-->

    <div class="content slide">

      <!--products_contact-->
      <div class="products_contact">
        <div class="products_contact_mainwrapper">
          <div class="products_contact_page">
            <ul>
              <li class="products_contact_page_arrd"><a href="javascript:;"><?php echo (L("highlights")); ?></a></li>
              <li><a href="javascript:;"><?php echo (L("specifications")); ?></a></li>
            </ul>
          </div>

          <div class="products_contact_tour container">
            <div class="grid-d-4 grid-t-4">
              <div class="products_contact_prv">
                <ul class="bxslider3">
                <?php if(is_array($goodsImgs)): $i = 0; $__LIST__ = $goodsImgs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ivo): $mod = ($i % 2 );++$i;?><li><a href="javascript:;"><img src="<?php echo ($ivo['goodsImg']); ?>" /></a></li>
                  <!-- <li><a href="javascript:;"><img src="/Public/Img/test/Tecno_News.png" /></a></li>
                  <li><a href="javascript:;"><img src="/Public/Img/test/Tecno_News.png" /></a></li> --><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
              </div>
            </div>
            <div class="grid-d-8 grid-t-8 grid-m-12" id="products_contact_next_container">
              <div class="products_contact_next choselive">
                <h2 class="products_contact_highlights"><?php echo ($goodsDetail['goodsName']); ?> - Device Highlights</h2>
                <!-- <span class="products_star">
                  <input type="radio" name="star" id="star1" value="">
                  <label for="star1"></label>
                  <input type="radio" name="star" id="star2" value="">
                  <label for="star2"></label>
                  <input type="radio" name="star" id="star3" value="">
                  <label for="star3"></label>
                  <input type="radio" checked name="star" id="star4" value="">
                  <label for="star4" checked></label>
                  <input type="radio" checked name="star" id="star5" value="">
                  <label for="star5" checked></label>
                </span> -->
                <div class="products_contact_setdata">
                  <?php echo ($goodsDetail['goodsSpec']); ?>
                  <!-- <h2>Memory</h2>
                  <p>Internal:32GB ROM + 3GB RAM</p>

                  <h2>General</h2>
                  <p>2G Network:900/1800MHz</p>
                  <p>3G Network:900/2100MHz</p>
                  <p>4G Network:Band3.7.20</p>
                  <p>5G Network:No</p>
                  <p>Sim:Normal SIM + Micro SIM</p>

                  <h2>Data</h2>
                  <p>WLAN:Yes</p>
                  <p>Bluettoth:Yes</p>
                  <p>USB:5pin micro</p>

                  <h2>Display</h2>
                  <p>Size:5.5'</p> -->
                </div>

                <!-- <div class="products_contact_setdata_share">
                  <span class="srowlist">
                    <ul class="follow-list">
                          <li><a href="https://twitter.com/TecnoAfrica" class="twitter">Twitter</a></li>
                          <li><a href="https://www.facebook.com/TECNOMobileAfrica?fref=ts" class="facebook">Facebook</a></li>
                          <li><a href="https://www.youtube.com/user/TecnoTelecomLimited" class="youtube">Youtube</a></li>
                    </ul>
                  </span>
                </div> -->
              </div>


              <!--tab-->
              <div class="products_contact_next chosetab_product">
                <h2 class="products_contact_highlights"><?php echo ($goodsDetail['goodsName']); ?> - Device Specifications</h2>
                <?php echo ($goodsDetail['goodsDesc']); ?>
                <!-- <p>
                  TECNO C8 is one of the leading smart phones belonging to Excellent Capture V1.0 and it focuses on hotograph.Let your ideas break free from the darkness for the optimum brightness and easier focusing in low light.Record stunning nightscape.breathtaking scenery and every extraordinary moment.Bring out your beauty solely with this amazing little device.
                </p>
                <div class="products_contact_setdataSpecifications">
                  <h2>Memory</h2>
                  <p>Internal:32GB ROM + 3GB RAM</p>

                  <h2>General</h2>
                  <p>2G Network:900/1800MHz</p>
                  <p>3G Network:900/2100MHz</p>
                  <p>4G Network:Band3.7.20</p>
                  <p>5G Network:No</p>
                  <p>Sim:Normal SIM + Micro SIM</p>

                  <h2>Data</h2>
                  <p>WLAN:Yes</p>
                  <p>Bluettoth:Yes</p>
                  <p>USB:5pin micro</p>

                  <h2>Display</h2>
                  <p>Size:5.5'</p> -->
                </div>

                <div class="products_contact_setdata_share">
                  <span class="srowlist">
                    <ul class="follow-list">
                          <li><a href="https://twitter.com/TecnoAfrica" class="twitter">Twitter</a></li>
                          <li><a href="https://www.facebook.com/tecnomobile/" class="facebook">Facebook</a></li>
                          <li><a href="https://www.youtube.com/user/TecnoTelecomLimited" class="youtube">Youtube</a></li>
                    </ul>
                  </span>
                </div>
              </div>
            </div>
          </div>



        </div>
      </div>
      <!--products_contact-->


      <!--backtotop-->
      <a href="javascript:;" class="back-to-top fade-out">
        <span class="arrow"></span>
        <span class="text"><?php echo (L("back_to_top")); ?></span>
      </a>
      <!--end backtotop-->

      <!--overlay-->
      <div class="overlay"></div>
      <!--end overlay-->

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

  <script src="/Public/Js/jquery.js" charset="utf-8"></script>
  <script src="/Public/Js/jquery.bxslider.min.js" charset="utf-8"></script>
  <script src="/Public/Js/main.js" charset="utf-8"></script>
  <script src="/Public/Js/nav.js" charset="utf-8"></script>
  <script type="text/javascript">
  function select_en(){
	 	 url = '/index.php?m=Home&c=Product&a=getGoodsDetail&goodsCatId1=357&goodsCatId2=0&goodsId=324';
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
		 url = '/index.php?m=Home&c=Product&a=getGoodsDetail&goodsCatId1=357&goodsCatId2=0&goodsId=324';
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