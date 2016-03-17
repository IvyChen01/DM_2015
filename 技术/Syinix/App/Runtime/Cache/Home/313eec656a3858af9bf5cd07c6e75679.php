<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html class="tele">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Support - Syinix</title>
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
            <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="text-left"><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
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
            <!-- <li><a href="#">Brands News</a></li>
            <li><a href="#">News Promotions</a></li> -->
          </ul>
        </li>
        <li class="dropdown actli">
          <a href="<?php echo U('Home/Index/support','','');?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Support</a>
          <ul class="dropdown-menu hidden-md hidden-lg">
            <li><a href="<?php echo U('Home/Index/support','','');?>">Instruction Manuals</a></li>
            <!-- <li><a href="#">Find a Store</a></li>
            <li><a href="#">Contact Us</a></li> -->
          </ul>
        </li>
        <li class="dropdown">
          <a href="<?php echo U('Home/Index/aboutUs','','');?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About Us</a>
          <ul class="dropdown-menu hidden-md hidden-lg">
            <li><a href="<?php echo U('Home/Index/aboutUs','','');?>">about</a></li>
            <!-- <li><a href="#">Find a Store</a></li>
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
          <input type="text" name="kw" class="form-control" placeholder="Search" id="intsch">
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
            </ul>
        </div>
    </div>
  </div>
</section>
<!--/附加导航-->


<!--aboutusbg-->
<section class="aboutusbg">
<div class="container-fluid" style="padding:0">
    <?php if(is_array($adsList)): $i = 0; $__LIST__ = $adsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><img src="<?php echo ($avo["adFile"]); ?>" class="hidden-xs hidden-sm img-responsive" alt="First slide">
  <img src="<?php echo ($avo["adPhoneImg"]); ?>" class="hidden-lg hidden-md img-responsive" alt="First slide"><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</section>
<!--/aboutusbg-->

<!--support main-->
<section class="suppt">
<div class="container">
  <div class="row hidden-lg hidden-md">
    <div class="container-fulid">
      <div class="col-xs-12">
        <img src="/Public/Img/suppimg1.png" class="img-responsive center-block" alt="" />
        <p class="text-left supp3">
          Fan FSS18N-501
        </p>
      </div>
    </div>
  </div>
  <div class="row">
    
    <p class="text-left supp2">
     Welcome to Syinix personalized support platform. You can easily find instruction manuals, find a nearest store and also contact us. We do care your matters!
    </p>
<p class="text-center supp1">
      Instruction Manuals
    </p>
    <div class="col-md-6 hidden-xs hidden-sm">
      <img src="/Public/Img/suppimg1.png" class="img-responsive center-block" alt="" />
      <p class="text-left supp3">
        	IRDP-1001
      </p>
    </div>

    <div class="col-md-4 col-md-offset-1 ">
      <ul class="suppul" id="supul1">
        <span>Products</span>
        <li class="sp-arr">Irons</li>
        <li>Kettles</li>
        <li >Blenders</li>
        <li>Fans</li>
        <li>Water Dispensers</li>
        <li>Chest Freezers</li>
<li>Refrigerators</li>
<li>Juice Master</li>
      </ul>
      <ul class="suppul" id="supul2">
        <span>Model</span>
<li class="supulshow supulitem"><ul>
        <li class="sp-arr">IRDP-1001</li>
       <li>IRSP-2001</li>
</ul>
</li>
<li class="supulitem"><ul>
        <li class="sp-arr">CLS-1801</li>
        <li>CLD-1701</li><li>CLD-1702</li>
</ul>
</li>
<li class="supulitem"><ul>
        <li class="sp-arr">BLFPPK-201</li>
       <li>BLFSGK-101</li>
</ul>
</li>
<li class="supulitem"><ul>
        <li class="sp-arr">FSS16N-301</li>
       <li>FSS16N-501</li><li>FSS18N-501</li><li>FSS16R-501</li>
</ul>
</li>
<li class="supulitem"><ul>
        <li class="sp-arr">WDA1C01</li>
       <li>WDA1C01</li><li>WDA1F01</li><li>WDA1F01</li><li>WDA1F01</li>
</ul>
</li>
<li class="supulitem"><ul>
        <li class="sp-arr">FZ100F01</li>
       <li>FZ140F01</li><li>FZ170F01</li>
</ul>
</li>
<li class="supulitem"><ul>
        <li class="sp-arr">FD090AF01</li>
       <li>FD090AF01</li><li>FD132BF01</li><li>FD132BF01</li><li>FD518BF01</li>
</ul>
</li>
      </ul>


      <ul class="suppul supp4 text-center ">
        <span><a href="#">Download</a></span>
      </ul>
    </div>
  </div>

  <!--find a store-->
  <div class="container hidden">
  <div class="row suppr1">
    <div class="col-md-12 col-xs-12">
      <p class="text-center supp5">
        Find s Store
      </p>
    </div>
  </div>
  <div class="row suppr2">
    <div class="col-md-12 col-xs-12">
      <img src="/Public/Img/aboutcountry.png" class="img-responsive" alt="" />
    </div>
  </div>
  <div class="row text-center suppr3">
    <div class="col-md-3 col-xs-6">
<p>
  Nigeria
</p>
    </div>
    <div class="col-md-3 col-xs-6">
<p>
  Kenya
</p>
    </div>
    <div class="col-md-3 col-xs-6">
<p>
  Ghana
</p>
    </div>
    <div class="col-md-3 col-xs-6">
<p>
  Tanzania
</p>
    </div>
  </div>
  <div class="row sppur4">
<div class="col-md-12 col-xs-12">

</div>
  </div>
</div>
</div>
</section>
<!--/support main-->

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
         <!--  <a href="#">Irons</a>
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
          <a href="<?php echo U('Home/Index/support','','');?>">Instruction Manuals</a>
          <!--<a href="#">FAQs</a>
          <a href="#">Carlcare Centre</a> -->
        </span>
      </div>
      <div class="col-md-2">
        <h4 class="text-left supporth4"><a href="<?php echo U('Home/Index/aboutUs','','');?>">About Us</a></h4>
        <span class="support-item hidden-xs hidden-sm">
          <a href="<?php echo U('Home/Index/aboutUs','','');?>">Brand Story</a>
          <!-- <a href="#">News</a> -->
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
 <!--  <li><a href="#">News</a></li> -->
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

  /*find a store*/
    $(function(){
      $('#supul1 li').click(function(){
        $(this).addClass('sp-arr').siblings().removeClass();
  //      $('#jds1 div.jdsa').hide().eq($('.crdul li').index(this)).show();
      })
      $('#supul2 li ul li').click(function(){
        $(this).addClass('sp-arr').siblings().removeClass();
  //      $('#jds1 div.jdsa').hide().eq($('.crdul li').index(this)).show();
      })
      $('ul.supp4').click(function(){
        alert('coming soon…');
      })
    })
  /*/find a store*/
     /*form*/
  function checkValue(){
    var schVar=document.getElementById("intsch").value;
    if(schVar!==''){
    document.getElementById("frmid").submit();
    }
  }
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
$(function(){
$("#supul1 li").on("click",function(){
var indexthis=$(this).index(); 
$("#supul2 li.supulitem").removeClass("supulshow");
var supularry=$("#supul2 li.supulitem");
$(supularry[indexthis-1]).addClass("supulshow");
})

$("#supul2 ul li").click(function(){
$(".supp3").html($(this).html())
})
})
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