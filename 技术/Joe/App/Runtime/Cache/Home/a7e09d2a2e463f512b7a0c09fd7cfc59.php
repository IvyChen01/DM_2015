<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html class="tele">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Service - Syinix</title>
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
           <!--  <li><a href="javascript:;">Irons</a></li>
            <li><a href="javascript:;">Kettles</a></li>
            <li><a href="javascript:;">Fan</a></li>
            <li><a href="javascript:;">Blenders</a></li>
            <li><a href="javascript:;">Water Dispenser</a></li>
            <li><a href="javascript:;">Refrigerators</a></li>
            <li><a href="javascript:;">Chest Freezers</a></li> -->
          </ul>
        </li>
        <li class="dropdown actli">
          <a href="<?php echo U('Home/Index/service','','');?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Service</a>
          <ul class="dropdown-menu hidden-md hidden-lg">
            <li><a href="<?php echo U('Home/Index/service','','');?>">After-Sales Service</a></li>
           <!--  <li><a href="#">Authenticity</a></li>
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
        <li class="dropdown">
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
        <li class="dropdown hidden sellli">
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

<!--附加导航-->
<section class="addnav hidden-xs hidden-sm">
  <div class="row text-center productul">
    <div class="container-fluid">
        <div class="drop-container">
            <ul class="productlist">
              <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
  </div>
</section>
<!--/附加导航-->

    <!--附加分类导航-->
    <section class="nav-add hidden">
      <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <ul class="nav">
              <li><a href="#">HOME</a></li>
              <li><a href="#">INSTRUCTIONS</a></li>
              <li><a href="#">FAQ</a></li>
              <li><a href="#" class="add-active">CARLCARE</a></li>

            </ul>
          </div>
        </div>
      </div>
    </nav>
    </section>
    <!--/附加分类导航-->
<!--back to top-->
<div class="backTop">
  <a href="javascript:;"><img src="/Public/Img/back.jpg" class="img-responsive" alt="" /></a>
</div>

    <!--简介-->
    <section class="jianjie">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-xs-12 col-sm-12 jiand1">
            <?php if(is_array($adsList)): $i = 0; $__LIST__ = $adsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><img src="<?php echo ($avo["adFile"]); ?>" class="img-responsive hidden-xs hidden-sm" alt="" />
            <img src="<?php echo ($avo["adPhoneImg"]); ?>" class="img-responsive hidden-md hidden-lg" alt="" /><?php endforeach; endif; else: echo "" ;endif; ?>
          </div>
          
        </div>
      </div>
<div class="container">
<div class="row">
<div class="col-md-12 col-xs-12 col-sm-12">
            <p class="text-center jianp1">
              Warranty Conditions
            </p>
            <p class="text-left jianp3">
              1.Thank you for purchasing Syinix product. Your Syinix product is warranted against defects in materials or workmanship from the purchasing date when this card being fully completed by the purchaser at the point of purchase.<br>
              2.Syinix will not pay for unauthorized service of any type.<br>
              3.No responsibility is assumed for any special, incidental or consequential damages. The warranty does not cover damages resulting from accident, misuse or abuse, lack of reasonable care, the affixing of any attachment not provided with the product or loss of parts, not following instructions or subjecting the product to any but the specified voltage.<br>
              4.The warranty will become void if the equipment is not protected against power surges and fluctuations because of not using recommended voltage stabilizers.<br>
              5.This warranty will become void once the serial number of the equipment is altered, defaced or removed.<br>
              6.This warranty card is confined to the first purchaser of the product only and is not transferable.<br>
              7.This warranty covers only Syinix products purchased from authorized Syinix dealers in Nigeria. <br>
              8.The right of final interpretation belongs to Syinix.<br>
            </p>
          </div>
</div>
</div>
    </section>

    <!--title-->
    <section class="title hidden-xs hidden-sm">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h3 class="text-center jianp4">Syinix Service Policy</h3>
            <div class="row jianbtna">
              <div class="col-md-6">
                <a href="javascript:;" class=""><i class="jianbtn1 jianbtn1s"></i>
                  <i class="jiant1">Professional</i>
                  </a>
                  <p class="text-left jiandp">
                    All the after-sales service staff have possessing professional knowledge and skills and years of experience in maintenance and service.
                  </p>

              </div>
              <div class="col-md-6">
                <a href="javascript:;" class=""><i class="jianbtn1 jianbtn2s"></i><i class="jiant1">Timely</i></a>
                  <p class="text-left jiandp">
    We provide timely service anytime anywhere!
                  </p>

              </div>
              <div class="col-md-6">
                <a href="javascript:;" class=""><i class="jianbtn1 jianbtn3s"></i><i class="jiant1">Satisfying</i></a>
                  <p class="text-left jiandp">
                   With the powerful quality assurance system and experienced quality team, Carlcare is doing its best to provide every client the most satisfying after-sales service experience.
                  </p>

              </div>
              <div class="col-md-6" style="margin-top:-205px">
                <a href="javascript:;" class=""><i class="jianbtn1 jianbtn4s"></i><i class="jiant1">Reliable</i></a>
                  <p class="text-left jiandp">
                  You can purchase Syinix products without any hesitation as where there are our clients, there are our Carlcare service centers.
                  </p>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--/title-->

    <!--carlcare-->
    <section class="carl">
      <div class="container">
        <div class="row">
          <div class="col-md-12 crd1">
            <div class="row-cover">
              <div class="txt-caption">
                <h5 class="jianjp1">Carlcare Service Outlet</h5>

                <div class="row hidden-xs hidden-sm">
                  <div class="col-md-2  col-md-offset-8">
                    <ul class="crdul">
                      <li class="jianliact">Nigeria</li>
                      <li>Kenya</li>
                      <li>Ghana</li>
                      <li>Tanzania</li>
                    </ul>
                  </div>
                </div>

              </div>
            <img src="/Public/Img/jianb2.png" class="img-responsive center-block" alt="" />
          </div>
        </div>

        <div class="row hidden-md hidden-lg jiand2 ">
          <div class="col-xs-3 text-center jiand3 jiand2act">
            Nigeria
          </div>
          <div class="col-xs-3 text-center jiand3">
            Kenya
          </div>
          <div class="col-xs-3 text-center jiand3">
            Ghana
          </div>
          <div class="col-xs-3 text-center jiand3">
            Tanzania
          </div>
        </div>
      </div>
      </div>

      <div class="container" id="jdsq">
        <div class="row" id="jds1">
          <div class="jds1 jdsa">
          <div class="col-md-6 col-xs-12">
            <h5>Lagos</h5>
            <h5>1st Floor, No.77 Opebi Road,  Ikeja, Lagos, Nigeria  </h5>
            <h5>+23480022752273/08138615848</h5>
            <h5>service@carlcare.com</h5>
          </div>

          <div class="col-md-6 col-xs-12">
            <h5>Lagos</h5>
            <h5>2nd Floor, Digital Square, No.20 Obafemi  Awolowo Way, Ikeja, Lagos, Nigeria</h5>
            <h5>+2349036003533</h5>
            <h5>service@carlcare.com</h5>
          </div>

          <div class="col-md-6 col-xs-12">
            <h5>Lagos</h5>
            <h5>No 55,kofo, abayomi avenue, apapa, Lagos State, Nigeria </h5>
            <h5>+2348091339530</h5>
            <h5>service@carlcare.com</h5>
          </div>

          <div class="col-md-6 col-xs-12">
            <h5>Lagos</h5>
            <h5>Ground and 1st Floor, No.1205 Ahmodu Ojikutu Street, off Bishop Oluwole Street, Victoria Island, Lagos, Nigeria</h5>
            <h5>+2348066153123/9039209279</h5>
            <h5>service@carlcare.com</h5>
          </div>

          <div class="col-md-6 col-xs-12">
            <h5>Abuja</h5>
            <h5>1st Floor,NO.16 Gwani Street(near King's Care Hospital), off IBB Way, Wuse Zone 4, Abuja, FCT, Nigeria.</h5>
            <h5>+2348181176195</h5>
            <h5>service@carlcare.com</h5>
          </div>

          <div class="col-md-6 col-xs-12">
            <h5>Onitsha</h5>
            <h5>1st Floor, 44B New Market Rd, Onitsha, Anambra, Nigeria</h5>
            <h5>+2348177250277</h5>
            <h5>service@carlcare.com</h5>
          </div>

          <div class="col-md-6 col-xs-12">
            <h5>Port Harcourt</h5>
            <h5>2nd Floor, No.17 Rumuobikani, Trans-amadi Rd, Part-Harcourt,River,Nigeria</h5>
            <h5>+2348181700046/8181700074</h5>
            <h5>service@carlcare.com</h5>
          </div>

          <div class="col-md-6 col-xs-12">
            <h5>Kano</h5>
            <h5>1st Floor,NO.32 Beirut Rd, Kano Contact, Kano,Nigeria</h5>
            <h5>+2348096969680</h5>
            <h5>service@carlcare.com</h5>
          </div>

          <div class="col-md-6 col-xs-12">
            <h5>Kaduna</h5>
            <h5>3rd Floor, G5/F6 Ya Ahmed House, Ahmed Bello Way, Kaduna, Kaduna, Nigeria</h5>
            <h5>+2349095724673</h5>
            <h5>service@carlcare.com</h5>
          </div>

          <div class="col-md-6 col-xs-12">
            <h5>Benin</h5>
            <h5>No.5-7, Isekhere Street, Off Ibewe Rd, Ring Rd, Benin City, Edo, Nigeria</h5>
            <h5>+2348172951002</h5>
            <h5>service@carlcare.com</h5>
          </div>

          <div class="col-md-6 col-xs-12">
            <h5>Ibadan</h5>
            <h5>3rd Floor, Isolak Building,Queen Elizabeth Rd,Ibadan, Oyo, Nigeria</h5>
            <h5>+2348172005296</h5>
            <h5>service@carlcare.com</h5>
          </div>
        </div>

      <div class="jds2 jdsa hidd">
        <div class="col-md-6 col-xs-12">
          <h5>Nairobi</h5>
          <h5>5th Floor,Cardinal Otunga Plaza,Koinange Kaunda Street,Nairobi,Kenya</h5>
          <h5>+254717446052</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Luthuli</h5>
          <h5>2nd Floor,Complex House,Luthuli Avenue,Nairobi,Kenya</h5>
          <h5>+254716400500</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Meru</h5>
          <h5>1st Floor, Town Mobile Center(Next to Uchumi Supermarket), Ghana Street, Meru, Kenya</h5>
          <h5>+254702133888</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Nyeri</h5>
          <h5>Room 104, Ground Floor, Prestige Plaza, Kimathi Street, Nyeri,Kenya</h5>
          <h5>+254728116767</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Mombasa</h5>
          <h5>Room No.A2, 2nd Floor(opp Fayaz Mini Bakery), Hospital Street, Mombasa,Kenya</h5>
          <h5>+254704433444</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Eldoret</h5>
          <h5>Room 22, 1st Floor, Dalsa Center(opposite Lincon Hotel), Oloo Street, Block 6/14, Eldoret,Kenya</h5>
          <h5>+254706188199</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Nakuru</h5>
          <h5>Room 06/07, 3rd Floor, Nakura, Shopper Paradise Kenyatta Avuenue, Nakuru, Kenya</h5>
          <h5>+254705618555</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Kisumu</h5>
          <h5>Mezanine Floor, Block D, Nakumatt Mega Plaza(next to the Star Newspaper Office),Oginga Odinga Street, Kisumu, Kenya</h5>
          <h5>+254701616050</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Ilorin</h5>
          <h5>2nd Floor,Ostrich Bakery Building, 155 Ibrahim Taiwo Rd,Ilorin,Kwara, Nigeria</h5>
          <h5>+2349092961418</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Owerri</h5>
          <h5>Ground Floor, No.20 Mbonu Ojike street, Ikenegbu, Owerri, Imo, Nigeria</h5>
          <h5>+2349081941110/9081941111 </h5>
          <h5>service@carlcare.com</h5>
        </div>
      </div>

      <div class="jds3 jdsa hidd">
        <div class="col-md-6 col-xs-12">
          <h5>Accra</h5>
          <h5>2nd Floor, Tip Toe Lane Odo Rice ,Kwame Nkrumaa Circle, Accra, Ghana</h5>
          <h5>+233503895973</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Accra</h5>
          <h5>1st Floor, next to Allied Oil Filling Station, Odorkor Main Traffic Light, Accra, Ghana</h5>
          <h5>+233503895975</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Kumasi</h5>
          <h5>3rd Floor, near Top Man Shoes, Adum,Kumasi, Ghana</h5>
          <h5>+233503895977</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Tamale</h5>
          <h5>1st Floor, opposite the Taxi Ran, Main Traffic Light, Tamale, Ghana</h5>
          <h5>+233503895981</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Takoradi</h5>
          <h5>1st Floor, closed to Mexico Hotel, Kintampo Road, Takoradi, Ghana</h5>
          <h5>+233503895979</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Accra</h5>
          <h5>3rd Floor, E & J PLAZA, Kokomlemle , Circle, Accra, Ghana</h5>
          <h5>+233207326108/207326104</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Kumasi</h5>
          <h5>Plot No.294 O.T.B ADUM, Kumasi,Ghana</h5>
          <h5>+233201259221</h5>
          <h5>service@carlcare.com</h5>
        </div>
      </div>

      <div class="jds4 jdsa hidd">
        <div class="col-md-6 col-xs-12">
          <h5>Dar es salaam</h5>
          <h5>3rd Floor, Block H, Plot No.3, Jangwani Street, Kariakoo, Dar es salaam, Tanzania</h5>
          <h5>+255222182203</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Dar es salaam</h5>
          <h5>M Floor,NHC House, Avenue PLOT NO 43/53, Samora Street,Dar es salaam, Tanzania</h5>
          <h5>+255222110486</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Mwanza</h5>
          <h5>2nd Floor,  Block "T", Plot No.93, Rwagasore Street ,Mwanza,Tanzania</h5>
          <h5>+255786905000</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Arusha</h5>
          <h5>3rd Floor, Plot No.35(oppsite Arusha Bus Stand), Zaramo Street, Arusha Region,Tanzania</h5>
          <h5>+255758032741</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Dodoma</h5>
          <h5>1st Floor,  Block 8, Plot No.27, Uhuru, Dodoma Municipality, Tanzania</h5>
          <h5>+255759002625</h5>
          <h5>service@carlcare.com</h5>
        </div>

        <div class="col-md-6 col-xs-12">
          <h5>Mbeya</h5>
          <h5>1st Floor, Kabwe Building, Mwanjelwa, Mbeya,Tanzania</h5>
          <h5>+255765948183</h5>
          <h5>service@carlcare.com</h5>
        </div>
      </div>

      </div>
      </div>
    </section>
    <!--/carlcare-->

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
         <!--  <a href="#">Instruction Manuals</a>
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
 <!--  <li><a href="#">FAQs</a></li>
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
  /*choice country tab*/
  $(function(){
    $('.crdul li').click(function(){
      $(this).addClass('jianliact').siblings().removeClass();
      $('#jds1 div.jdsa').hide().eq($('.crdul li').index(this)).show();
    })
    $('.jiand2 div.jiand3').click(function(){
      $(this).addClass('jiand2act').siblings().removeClass('jiand2act');
      $('#jds1 div.jdsa').hide().eq($('.jiand2 div.jiand3').index(this)).show();
    })
  })
  /*/choice country*/
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