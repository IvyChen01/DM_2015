<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html class="tele">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>About Us - Syinix</title>
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/tele.css" media="screen" title="no title" charset="utf-8"> -->
    <link href="<?php echo C('WEB_ROOT');?>/Static/Plugins/BJUI/themes/css/bootstrap.min.css" rel="stylesheet" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/tele.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <!--nav-->
    <header>
      <nav class="navbar navbar-inverse">
  <div class="container">
    <div class="row">
      <div class="col-md-12 dropdiv">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo U('Home/Index/index','','');?>">
        <img src="/Public/Img/logo.png" class="img-responsive hidden-md hidden-lg" alt="logo" />
        <img src="/Public/Img/log.png" class="img-responsive hidden-xs hidden-sm" alt="logo" />
      </a>
    </div>

    <div class="collapse navbar-collapse" id="navbar-collapse-1">
      <ul class="nav navbar-nav navleft">
        <li class="dropdown" id="addnav">
          <a href="<?php echo U('Home/Product/index','','');?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products</a>
          <ul class="dropdown-menu hidden-xs hidden-sm hidden" id="dropm1">
            <li class="hid97"><a href="<?php echo U('Home/Product/index','','');?>">All</a></li>
            <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            <!-- <li><a href="javascript:;">Irons</a></li>
            <li><a href="javascript:;">Kettles</a></li>
            <li><a href="javascript:;">Fan</a></li>
            <li><a href="javascript:;">Blenders</a></li>
            <li><a href="javascript:;">Water Dispenser</a></li>
            <li><a href="javascript:;">Refrigerators</a></li>
            <li><a href="javascript:;">Chest Freezers</a></li> -->
          </ul>
		  <ul class="dropdown-menu hidden-lg hidden-md">
            <li class="hid97"><a href="<?php echo U('Home/Product/index','','');?>">All</a></li>
            <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            <!-- <li><a href="javascript:;">Irons</a></li>
            <li><a href="javascript:;">Kettles</a></li>
            <li><a href="javascript:;">Fan</a></li>
            <li><a href="javascript:;">Blenders</a></li>
            <li><a href="javascript:;">Water Dispenser</a></li>
            <li><a href="javascript:;">Refrigerators</a></li>
            <li><a href="javascript:;">Chest Freezers</a></li> -->
          </ul>
        </li>
        <li class="dropdown">
          <a href="<?php echo U('Home/Index/service','','');?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Service</a>
          <ul class="dropdown-menu hidden-md hidden-lg">
            <li><a href="<?php echo U('Home/Index/service','','');?>">After-Sales Service</a></li>
            <!-- <li><a href="#">Authenticity</a></li>
            <li><a href="#">FAQs</a></li> -->
          </ul>
        </li>
        <li class="dropdown">
          <a href="<?php echo U('Home/Article/index','','');?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">News</a>
          <ul class="dropdown-menu hidden-md hidden-lg">
            <li><a href="<?php echo U('Home/Article/index','','');?>">Latest News</a></li>
           <!--  <li><a href="#">Brands News</a></li>
            <li><a href="#">News Promotions</a></li> -->
          </ul>
        </li>
        <li class="dropdown">
          <a href="<?php echo U('Home/Index/support','','');?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Support</a>
          <ul class="dropdown-menu hidden-md hidden-lg">
            <li><a href="<?php echo U('Home/Index/support','','');?>">Instruction Manuals</a></li>
           <!--  <li><a href="#">Find a Store</a></li>
            <li><a href="#">Contact Us</a></li> -->
          </ul>
        </li>
        <li class="dropdown actli">
          <a href="<?php echo U('Home/Index/aboutUs','','');?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About Us</a>
          <ul class="dropdown-menu hidden-md hidden-lg">
            <li><a href="<?php echo U('Home/Index/aboutUs','','');?>">about</a></li>
           <!--  <li><a href="#">Find a Store</a></li>
            <li><a href="#">Contact Us</a></li> -->
          </ul>
        </li>
        <li class="dropdown sellli hidden">
          <a href="javascript:;" class="dropdown-toggle hidden-sm hidden-md" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">购买</a>
        </li>
      </ul>
      <form class="navbar-form navbar-left" action="<?php echo U('Index/search');?>"  method="POST" role="search" id="frmid">
        <div class="form-group">
          <img src="/Public/Img/search.png" class="img-responsive hidden-md hidden-lg" id="stImg" onclick="return checkValue();"/>
          <input type="text" name="kw" class="form-control" placeholder="Search" id="intsch">>
        </div>
        <button type="submit" class="btn btn-default hidden">Submit</button>
        <a href="#" class="btn btn-search hidden-xs hidden-sm">
          <img src="/Public/Img/search.png" class="img-responsive center-block" alt="" onclick="return checkValue();"/>
        </a>
        <a href="#" class="btn btn-cose hidden-xs hidden-sm">
          <img src="/Public/Img/cose.png" class="img-responsive center-block" alt=""/>
        </a>
      </form>
    </div><!-- /.navbar-collapse -->
    </div>
    </div>
  </div><!-- /.container-fluid -->
</nav>
    </header>
    <!--/nav-->
<!--back to top-->
<div class="backTop">
  <a href="javascript:;"><img src="/Public/Img/back.jpg" class="img-responsive" alt="" /></a>
</div>

<!--附加导航-->
<section class="addnav hidden-xs hidden-sm">
  <div class="row text-center productul">
    <div class="container-fluid">
        <div class="drop-container">
            <ul class="productlist">
			  <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="text-left"><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
              <!--<li class="text-left"><a href="iron.html">Irons</a></li>
              <li class="text-left"><a href="kettle.html">Kettles</a></li>
              <li class="text-left"><a href="fan.html">Fan</a></li>
              <li class="text-left"><a href="blender.html">Blenders</a></li>
              <li class="text-left"><a href="javascript:;">Water Dispenser</a></li>
              <li class="text-left"><a href="javascript:;">Refrigerators</a></li>
              <li class="text-left"><a href="javascript:;">Chest Freezers</a></li>-->
            </ul>
        </div>
    </div>
  </div>
</section>
<!--/附加导航-->

<!--aboutusbg-->
<section class="productcover">
      <div class="container-fluid">
      <?php if(is_array($adsList)): $i = 0; $__LIST__ = $adsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><div class="item cover-cap">
          <div class="product-caption hidden">
            <h5 class="carsl"><?php echo ($avo["adName"]); ?></h5>
            <p  class="carslp">
              <?php echo ($avo["adDesc"]); ?>
            </p>
            <div class="carslps"><a href="<?php echo ($avo["adURL"]); ?>">Learn more <i class="carlpsi"></i></a><a href="<?php echo ($avo["adVideo"]); ?>">Watch the film <i class="carlsii"></i></a></div>
            <a href="iron.html" class="colink hidden-sm hidden-xs hidden">TAKE A TOUR</a>
          </div>
           <a href="#"><img src="<?php echo ($avo["adFile"]); ?>" class="hidden-xs hidden-sm img-responsive" alt="First slide">
                      <img src="<?php echo ($avo["adPhoneImg"]); ?>" class="hidden-lg hidden-md img-responsive" alt="First slide"></a>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</section>
<!--/aboutusbg-->

<!--title-->
<section class="title">
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h4 class="text-center title-head">About us</h4>
        <h3 class="text-left aboutp1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Syinix is a Japan-based professional home appliance brand. Since its foundation, it adheres to its ultimate goal of letting people’s life smarter and more easily. With the Japanese design style and always making it better, Syinix continuously pursues innovative functional design and a more exquisite detail of its products. Its finish design is embedded with understated and simple lines, thus it can help its customers restore a cozy family atmosphere.</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Syinix products enjoy unique finish design with the theme color of green which symbolizes nature and health. Syinix also owns professional laboratories to guarantee quality and safety of its products. Its products are featured with simple and optimized user experience, which embodies its brand artistic conception of being warm, comfortable, and easy to use. Syinix possesses a comprehensive product portfolio of home appliances with different models, including blenders, kettles, electric irons, juicers, citrus presses, refrigerators, chest freezers, water dispensers, rice cookers, fans, gas stoves, etc. Consumers are capable to enjoy a high quality and easy life with Syinix products. Syinix has always insisted on the brand spirit of pursuing excellence, learning from others and taking challenges. Moreover, it has always kept its brand original intention in mind of becoming a world-famous brand. It will continue to bring its superiority into full play as an international renowned home appliance brand, and let more people enjoy a better and wonderful life through Syinix products.</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Owing to such an emotional support, Syinix has enjoyed a rapid development, and already won numerous honors. It is always aimed at providing suitable home appliances at the best price, and constantly enriching its customers' life experience. Syinix has a top-notched team of designers, and high quality products certified by the international ISO9001 quality management system and CE safety certification adopted by the EU. It continuously strives to enrich the living experience for each family worldwide. In Africa, Syinix provides first-class after-sales services for its customers by cooperating with Carlcare Service Centre, which is a leading service brand for consumer electronics in Africa with many shops in African countries. All what Syinix has done is to offer you a smart and better life. Syinix will spare no efforts to develop into a leading home appliance brand of its kind now in Africa. </h3>
      </div>
    </div>
  </div>
</section>
<!--/title-->

<section class="shr">
  <!--tele-->
  <div class="row share hidden-md hidden-lg text-center">
    <div class="col-xs-4">
      <a href="https://twitter.com/Syinix"><i class="tiwtter"></i></a>
    </div>
    <div class="col-xs-4">
      <a href="https://www.facebook.com/SyinixHomeAppliance"><i class="facebook"></i></a>
    </div>
    <div class="col-xs-4">
      <a href="https://www.youtube.com/channel/UCBuPQVnTImuODnDk8bfe1hw"><i class="youtabe"></i></a>
    </div>
  </div>
  <!--/tele-->
</section>
<!--support-->
<section class="support">
  <div class="container hidden-xs hidden-sm">
    <div class="row">
      <div class="col-md-2">
        <h4 class="text-left supporth4"><a href="<?php echo U('Home/Product/index','','');?>">Products</a></h4>
        <span class="support-item hidden-xs hidden-sm">
        <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          <!-- <a href="#">Irons</a>
          <a href="#">Kettles</a>
          <a href="#">Fans</a>
          <a href="#">Blenders</a>
          <a href="#">Water Dispensers</a>
          <a href="#">Refrigerators</a>
          <a href="#">Chest Freezers</a> -->
        </span>
      </div>
      <div class="col-md-2">
        <h4 class="text-left supporth4"><a href="<?php echo U('Home/Index/support','','');?>">Support</a></h4>
        <span class="support-item hidden-xs hidden-sm">
<a href="/index.php?m=Home&amp;c=Index&amp;a=support">Instruction Manuals</a>
          <!-- <a href="#">Instruction Manuals</a>
          <a href="#">FAQs</a>
          <a href="#">Carlcare Centre</a> -->
        </span>
      </div>
      <div class="col-md-2">
        <h4 class="text-left supporth4"><a href="<?php echo U('Home/Index/aboutUs','','');?>">About Us</a></h4>
        <span class="support-item hidden-xs hidden-sm">
<a href="/index.php?m=Home&amp;c=Index&amp;a=aboutUs">Brand Story</a>
          <!-- <a href="#">Brand Story</a>
          <a href="#">News</a> -->
        </span>
      </div>
      <div class="col-md-2">
        <h4 class="text-left supporth4">Follow Us On</h4>
        <span class="support-item hidden-xs hidden-sm">
          <a href="https://www.facebook.com/SyinixHomeAppliance">Facebook</a>
          <a href="https://twitter.com/Syinix">Twitter</a>
          <a href="https://www.youtube.com/channel/UCBuPQVnTImuODnDk8bfe1hw">YouTube</a>
        </span>
      </div>
      <div class="col-md-2">
        <h4 class="text-left supporth4">Contact Us</h4>
        <span class="support-item hidden-xs hidden-sm">
          <a href="#">Tel: 07000 syinix</a>
          <a href="mailto:hello@syinix.com">Email: hello@syinix.com</a>
        </span>
      </div>
    </div>
  </div>

  <!--tele-->
  <div class="container hidden-md hidden-lg">
    <div class="row">
      <div class="col-xs-12">

<div class="panel-group" id="accordion">
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title">
  <a data-toggle="collapse" data-parent="#accordion"
    href="#collapseTwo">
    Products
  </a>
</h4>
</div>
<div id="collapseTwo" class="panel-collapse collapse">
<div class="panel-body">
  <ul>
    <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    <!-- <li><a href="#">Irons</a></li>
    <li><a href="#">Kettles</a></li>
    <li><a href="#">Fans</a></li>
    <li><a href="#">Blenders</a></li>
    <li><a href="#">Water Dispensers</a></li>
    <li><a href="#">Refrigerators</a></li>
    <li><a href="#">Chest Freezers</a></li> -->
  </ul>
</div>
</div>
<div class="panel-heading">
<h4 class="panel-title">
  <a data-toggle="collapse" data-parent="#accordion"
    href="#collapseThree">
    Support
  </a>
</h4>
</div>
<div id="collapseThree" class="panel-collapse collapse">
<div class="panel-body">
<ul>
  <li><a href="<?php echo U('Home/Index/support','','');?>">Instruction Manuals</a></li>
  <!-- <li><a href="#">FAQs</a></li>
  <li><a href="#">Carlcare Centre</a></li>
  <li><a href="#">Find a Store</a></li> -->
</ul>
</div>
</div>

<div class="panel-heading">
<h4 class="panel-title">
  <a data-toggle="collapse" data-parent="#accordion"
    href="#collapseThree1">
    About Us
  </a>
</h4>
</div>
<div id="collapseThree1" class="panel-collapse collapse">
<div class="panel-body">
<ul>
  <li><a href="<?php echo U('Home/Index/aboutUs','','');?>">Brand Story</a></li>
  <!-- <li><a href="#">News</a></li> -->
</ul>
</div>
</div>

<div class="panel-heading">
<h4 class="panel-title">
  <a data-toggle="collapse" data-parent="#accordion"
    href="#collapseThree2">
    Follow Us On
  </a>
</h4>
</div>
<div id="collapseThree2" class="panel-collapse collapse">
<div class="panel-body">
<ul>
  <li><a href="https://www.facebook.com/SyinixHomeAppliance">Facebook</a></li>
  <li><a href="https://twitter.com/Syinix">Twitter</a></li>
  <li><a href="https://www.youtube.com/channel/UCBuPQVnTImuODnDk8bfe1hw">youtabe</a></li>
</ul>
</div>
</div>

<div class="panel-heading">
<h4 class="panel-title">
  <a data-toggle="collapse" data-parent="#accordion"
    href="#collapseThree3">
    Contact Us
  </a>
</h4>
</div>
<div id="collapseThree3" class="panel-collapse collapse">
<div class="panel-body">
<ul>
  <li><a href="#">Tel: 07000 syinix</a></li>
  <li><a href="mailto:hello@syinix.com">Email: hello@syinix.com</a></li>
</ul>
</div>
</div>


</div>
</div>
      </div>
    </div>
  </div>
  <!--/tele-->
</section>
<!--/support-->

<!--contact-->
<section class="contact">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <p class="text-center"style="margin-top:10px">
          Copyright © 2015 Syinix. All rights reserved.
        </p>
      </div>
    </div>
  </div>
</section>
<!--/contact-->

  <!-- <script src="js/jquery.js" charset="utf-8"></script>
  <script src="js/bootstrap.min.js" charset="utf-8"></script> -->
   <script src="<?php echo C('STATIC_PATH');?>Plugins/BJUI/js/jquery-1.9.1.js"></script>
  <script src="<?php echo C('STATIC_PATH');?>Plugins/BJUI/plugins/bootstrap.min.js"></script>
  <script type="text/javascript">
  /*navul*/
  $(function(){
    $('ul.dropdown-menu li').hover(
      function(){
        $(this).find('ul.navul').removeClass('hidden')
      },
      function(){
        $(this).find('ul.navul').addClass('hidden')
      }
    )
  })
  /*/navul*/
  /*search*/
  $(function(){
    var $val=$('input.form-control').val();console.log($val);
    var $wid=$(document).width();
    if($wid>970){
    $('a.btn-search').click(function(){
  //    $('ul.navleft').addClass('hidden');
      if(($(document).width())>970){
//        alert('11')
      }
      $('input.form-control').css('visibility','visible');
    //  $('input.form-control').css('background','#fff');
      $('input.form-control').focus();
    })
    }
  })
  /*/search*/
  /*support*/
  $(function(){
    $('.support h4').click(function(){
      $(this).siblings('span.support-item').removeClass('hidden-xs');
      $(this).siblings('span.support-item').removeClass('hidden-sm');
      console.log('1');
    })
  })
  /*/support*/
  /*nav api*/
  $(function(){
    $wid=$(document).width();
    if($wid>970){
    $(document).off('click.bs.dropdown.data-api');
    function dropdownOpen() {
    var $dropdownLi = $('li.dropdown');
    $dropdownLi.mouseover(function() {
        $(this).addClass('open');
    }).mouseout(function() {
        $(this).removeClass('open');
    })
  }dropdownOpen();//调用
  }
  })
  /*/nav api*/
     /*form*/
  function checkValue(){
    var schVar=document.getElementById("intsch").value;
    if(schVar!==''){
    document.getElementById("frmid").submit();
    }
  }
   /*take a tour*/
  function tour(){
    var t = $(window).scrollTop();
    $('body,html').animate({'scrollTop':t+800},600)
}
  /*end*/
  /*addnav*/
$(function(){
$('#addnav').hover(function(){
  $('.addnav').fadeIn('slow')
  $('#navbar-collapse-1 ul.nav li:not(#addnav)').hover(function(){$('.addnav').fadeOut('slow');})
},function(){
  $('.drop-container').hover(function(){},function(){
    $('.addnav').fadeOut('slow');
  })
})
})
/*/addnav*/
  </script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-72584748-1', 'auto');
  ga('send', 'pageview');

</script>
  <script type="text/javascript">
    $(function(){
      $(document).scroll(function(){
        if($(document).scrollTop()>300){
          $('.backTop').show();
        }else{$('.backTop').hide();}
      })
      $('.backTop').click(function(){
        $('html,body').animate({scrollTop: '0px'}, 800);
      })
    })
  </script>
  </body>
</html>