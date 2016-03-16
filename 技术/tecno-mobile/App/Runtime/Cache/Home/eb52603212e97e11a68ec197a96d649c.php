<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Products - TECNO</title>
    <link rel="stylesheet" href="/Public/css/grid.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/reset.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/default.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/jquery.bxslider.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/products.css" media="screen" title="no title" charset="utf-8">
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
				<li class="addall"><a href="<?php echo U('Home/Product/index','','');?>"  class="active"><?php echo (L("product")); ?></a>
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
          <!-- <li><a href="javascript:;"><div class="icon all"></div><i class="addnav-title">Tous les</i></a></li>
          <li><a href="javascript:;"><div class="icon phantom"></div><i class="addnav-title">Fantome</i></a></li>
          <li><a href="javascript:;"><div class="icon camon"></div><i class="addnav-title">Auuto</i></a></li>
          <li><a href="javascript:;"><div class="icon boom"></div><i class="addnav-title">Boom</i></a></li>
          <li><a href="javascript:;"><div class="icon other"></div><i class="addnav-title">Auuto</i></a></li>
          <li><a href="javascript:;"><div class="icon feature"></div><i class="addnav-title">Auuto</i></a></li>
          <li><a href="javascript:;"><div class="icon table"></div><i class="addnav-title">Auuto</i></a></li>
          <li><a href="javascript:;"><div class="icon acc"></div><i class="addnav-title">Auuto</i></a></li> -->
        </ul>
      </div>
    </section>
    <!--end addnav desktop-->

    <div class="content slide">
      <!--main wrapper-->
      <div class="products-main-wrapper">
        <div class="products-page-heading"><h2><?php echo (L("filter_filter")); ?></h2></div>
        <div class="products-page clearfloat">
          <a href="javascript:;" class="products-menu-btn"><img src="/Public/Img/logo/filter.png" alt="Filter" /></a>
          <ul class="products-content-nav">
            <li ><a href="<?php echo U('Home/Product/index','','');?>" class="categories mainlist">All</a></li>
            <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li id='goodsCat<?php echo ($vo['catId']); ?>'><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>" class="categories"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            <!-- <li><a href="javascript:;" class="categories">Fantôme</a></li>
            <li><a href="javascript:;" class="categories">Fantôme</a></li>
            <li><a href="javascript:;" class="categories">Fantôme</a></li>
            <li><a href="javascript:;" class="categories">Fantôme</a></li>
            <li><a href="javascript:;" class="categories">Fantôme</a></li>
            <li><a href="javascript:;" class="categories">Fantôme</a></li> -->
          </ul>
        </div>

        <!--products-list-->
        <div class="products-wrapper">
          <div class="category-wrapper-list">
            <ul id="products-list">
              <?php if(is_array($goodsList)): $i = 0; $__LIST__ = $goodsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li data-product-id="prod-<?php echo ($vo['goodsId']); ?>">
                <div class="item-wrapper">
                  <div class="content-prod">
                    <a href="<?php echo U('Home/Product/getGoodsDetail',array('goodsCatId1'=>$vo['goodsCatId1'],'goodsCatId2'=>$vo['goodsCatId2'],'goodsId'=>$vo['goodsId']));?>" class="pic"><img src="<?php echo ($vo['goodsImg']); ?>" /></a>
                    <h2><?php echo ($vo['goodsName']); ?></h2>
                  </div>
                  <div class="btns-wrapper">
                    <div class="content-btns clearfloat">
                      <a href="javascript:;" class="compare btn grey align-left" rel="<?php echo ($vo['goodsId']); ?>"><?php echo (L("compare")); ?></a>
                      <a href="<?php echo U('Home/Product/getGoodsDetail',array('goodsCatId1'=>$vo['goodsCatId1'],'goodsCatId2'=>$vo['goodsCatId2'],'goodsId'=>$vo['goodsId']));?>" class="btn blue align-right"><?php echo (L("more")); ?></a>
                    </div>
                  </div>
                </div>
              </li><?php endforeach; endif; else: echo "" ;endif; ?>
              <!-- <li data-product-id="prod-33">
                <div class="item-wrapper">
                  <div class="content-prod">
                    <a href="javascript:;" class="pic"><img src="/Public/Img/test/z-main.png" alt="Tecno Phantom" /></a>
                    <h2>Tecno phantom</h2>
                  </div>
                  <div class="btns-wrapper">
                    <div class="content-btns clearfloat">
                      <a href="javascript:;" class="compare btn grey align-left" rel="33">Compare</a>
                      <a href="javascript:;" class="btn blue align-right">More..</a>
                    </div>
                  </div>
                </div>
              </li>

              <li data-product-id="prod-33">
                <div class="item-wrapper">
                  <div class="content-prod">
                    <a href="javascript:;" class="pic"><img src="/Public/Img/test/z-main.png" alt="Tecno Phantom" /></a>
                    <h2>Tecno phantom</h2>
                  </div>
                  <div class="btns-wrapper">
                    <div class="content-btns clearfloat">
                      <a href="javascript:;" class="compare btn grey align-left" rel="33">Compare</a>
                      <a href="javascript:;" class="btn blue align-right">More..</a>
                    </div>
                  </div>
                </div>
              </li>



              <li data-product-id="prod-34">
                <div class="item-wrapper">
                  <div class="content-prod">
                    <a href="javascript:;" class="pic"><img src="/Public/Img/test/z-mini-main.png" alt="Mini Z Phantom TECNO" /></a>
                    <h2>Mini Z Phantom TECNO</h2>
                  </div>
                  <div class="btns-wrapper">
                    <div class="content-btns clearfloat">
                      <a href="javascript:;" class="btn blue align-center">More..</a>
                    </div>
                  </div>
                </div>
              </li>

              <li data-product-id="prod-34">
                <div class="item-wrapper">
                  <div class="content-prod">
                    <a href="javascript:;" class="pic"><img src="/Public/Img/test/z-mini-main.png" alt="Mini Z Phantom TECNO" /></a>
                    <h2>Mini Z Phantom TECNO</h2>
                  </div>
                  <div class="btns-wrapper">
                    <div class="content-btns clearfloat">
                      <a href="javascript:;" class="btn blue align-center">More..</a>
                    </div>
                  </div>
                </div>
              </li>
 -->

            </ul>
          </div>

          <!--compare-wrapper-->
          <div class="compare-wrapper">
            <ul><!--
              <li data-product-id="prod-20">
                <a href="javascript:;" class="closeprod">close</a>
                <img src="image/test/T463.png" alt="Tecno T463" />
                <h3>Tecno T463</h3>
              </li>

              <li data-product-id="prod-37">
                <a href="javascript:;" class="closeprod">close</a>
                <img src="image/test/t560-main.png" alt="Tecno T560" />
                <h3>Tecno T560</h3>
              </li>

              <li data-product-id="prod-29">
                <a href="javascript:;" class="closeprod">close</a>
                <img src="image/test/TV52.png" alt="Tecno TV52" />
                <h3>Tecno TV52</h3>
              </li>
-->
              <li class="compare">
                <a href="javascript:;" class="compare-close">close</a>
                <a href="javascript:;" class="btn-compare" data-lang="eg">compare</a>
              </li>
            </ul>
          </div>
          <!--end compare-wrapper-->
        </div>
        <!--end product-list-->
        <div class="overlay"></div>

        <!--compare-popup-->
        <div class="" id="compare-popup">
          <a href="javascript:;" class="closepopup">close</a>
          <div class="comparing-wrapper">
            <table id="compare-table">
              <!-- <tr class="t-header">
                <td></td>
                <td><img src="/Public/Img/test/z-maim.png" alt="Tecno Phantom Z" /><h2>Tecno Phantom Z</h2></td>
                <td><img src="/Public/Img/test/z-maim.png" alt="Tecno Phantom Z" /><h2>Tecno Phantom Z</h2></td>
              </tr>
              <tr class="t-rating">
                <td>&nbsp;</td>
                <td><div class="no-star"></div></td>
                <td><div class="no-star"></div></td>
              </tr>
              <tr>
                <td>Plate-forme</td>
                <td>4.4.2 Android KitKat</td>
                <td>Android 5.0,Lollipop</td>
              </tr>
              <tr class="alternate">
                <td>Batterie</td>
                <td>Type:batterie Li-ion 3030mAh<br>Mise en veille:Jusqu a 375 hrs<br>Temps de conversation:Jusqu a 24 heures<br>Temps de la musiqu:<br></td>
                <td>Type:<br>Mise en veille:<br>Temps de conversation:<br>Temps de la musiqu:<br></td>
              </tr>
              <tr>
                <td>Donnees</td>
                <td>GPRS:Qui<br>Bord:Oui<br>3G:HSDPA 900/2100<br></td>
                <td>GPRS:Non<br>Bord:Non<br>3G:900/2100MHz<br></td>
              </tr>
              <tr class="alternate">
                <td>Appareil photo</td>
                <td>Primaire:16MP AF camera arriere avec double Flash<br>Secondaire:8megapixels,jusqu a photos de 3264x2448 pixels<br>Video:1080p@30fps<br></td>
                <td>Primaire:<br>Secondaire:<br>Video:<br></td>
              </tr>
              <tr class="t-rating">
                <td>&nbsp;</td>
                <td><div class="no-star"></div></td>
                <td><div class="no-star"></div></td>
              </tr>
              <tr>
                <td>Plate-forme</td>
                <td>4.4.2 Android KitKat</td>
                <td>Android 5.0,Lollipop</td>
              </tr>
              <tr class="alternate">
                <td>Batterie</td>
              </tr> -->
            </table>
          </div>
        </div>
        <!--end compare-popup-->


      </div>
      <!--end main wrapper-->

      <!--backtotop-->
      <a href="javascript:;" class="back-to-top fade-out">
        <span class="arrow"></span>
        <span class="text"><?php echo (L("back_to_top")); ?></span>
      </a>
      <!--end backtotop-->

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
  <script src="/Public/Js/products.js" charset="utf-8"></script>
  <script>
  $(function(){
		 $('#goodscat1').addClass('phantom');
		 $('#goodscat2').addClass('boom');
		 $('#goodscat3').addClass('other');
		 $('#goodscat4').addClass('feature');
		 $('#goodscat5').addClass('table');
		 
		 var cid = '<?php echo ($id); ?>';
		 if(cid){
			 $('.products-content-nav li').removeClass('products-cent-active');
			 $('#goodsCat<?php echo ($id); ?>').addClass('products-cent-active');
		 }else{
			 $('.products-content-nav li:first').addClass('products-cent-active');
		 }
		 
	  });
  function select_en(){
	 	 url = '/index.php?m=Home&c=Product&a=index';
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
		 url = '/index.php?m=Home&c=Product&a=index';
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