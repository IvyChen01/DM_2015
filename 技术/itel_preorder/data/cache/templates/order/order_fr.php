<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>itel1505</title>
    <link rel="stylesheet" href="css/layout.css" media="screen" title="no title" charset="utf-8">
    <script src="js/jquery.js" charset="utf-8"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap-progressbar.min.css" media="screen" title="no title" charset="utf-8">
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/bootstrap-progressbar.min.js" charset="utf-8"></script>
    <script src="js/hammer.js" charset="utf-8"></script>
    <script src="js/jquery.hammer.js" charset="utf-8"></script>
  </head>
  <body>
<header class="header">
<nav class="navbar navbar-default">
   <div class="container">
     <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed pull-left headernavbtn" data-toggle="collapse" data-target="#nav-main">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="javascript:;" class="navbar-brand"><img src="image/itel-logo.png" class="img-responsive" alt="itel1505"></a>
    </div>
    <div class="header-container purchasecase">
        <h4 class="navbar-text pull-left btn disabled" style="width:92px"><img src="image/vision.png" class="img-responsive" style=""></h4>
        <p class="navbar-text pull-right btn btn-primary  btn-info btn-set" id="purchase">Acheter</p>
        <script type="text/javascript">
          $(function(){$('#purchase').click(function(){mScroll(pushhere)})
            function mScroll(id){$("html,body").stop(true);$("html,body").animate({scrollTop: $("#pushhere").offset().top-60}, 1000);}
          })
        </script>
    </div>
    <div class="navbar-collapse collapse" id="nav-main" aria-expanded="true">
        <ul class="nav navbar-nav headernvaul">
            <li><a href="">Design</a></li>
            <li><a href="">TruView™</a></li>
            <li><a href="">Camera</a></li>
            <li><a href="">Features</a></li>
            <li class="hidden-xs hidden-sm purchasepc"><a href="javascript:;" style="color:#42b5fd">Acheter</a></li>
            <script>
              $(function(){
                $('.purchasepc').click(function(){
                  $("html,body").stop(true);$("html,body").animate({scrollTop: $("#pushhere").offset().top-60}, 1000);
                })
              })
            </script>
        </ul>
    </div>
   </div>
</nav>
</header>
<section class="truview f11" style="margin-top:-20px;">
  <div class="container">
    <div class="row" style="margin-top:10px;margin-bottom:20px">
      <div class="col-md-12 col-xl-8">
        <h3 class="text-center" style="font-weight:600">Affichage TruView ™</h3>
        <h5 class="text-center" style="font-weight:600">Grand écran 5,0 "haute résolution"</h5>
        <h5 class="text-center" style="font-weight:600;margin-top:-10px">Écran IPS, angle de visibilité de 178 ° </h5>
        <h6 class="text-center h6nth1" style="  line-height: 16px;">Expérience visuelle spectaculaire - La Technologie TruView ™ NTSC 85% améliore </h6>
        <h6 class="text-center h6nth2" style="  line-height: 16px;margin-top:-10px">l'effet d’affichage des couleurs pour des images plus nettes et plus lumineuses, permettant un résultat avec des couleurs réelles. </h6>
        <div class="row text-center" style="margin-top:30px;font-size:12px;margin-bottom:60px;">
          <div class="col-xs-3 he4row">
            <span><p class="he4rowtitle">5.0HD</p>
                  <p class="he4rowcont">1280*720</p>
            </span>
          </div>
          <div class="col-xs-3 he4row">
            <span><p class="he4rowtitle">85%</p>
                  <p class="he4rowcont">NTSC</p>
            </span>
          </div>
          <div class="col-xs-3 he4row">
            <span><p class="he4rowtitle">296</p>
                  <p class="he4rowcont">PPI</p>
            </span>
          </div>
          <div class="col-xs-3 he4row">
            <span><p class="he4rowtitle">16.7M</p>
                  <p class="he4rowcont">ColorSpace</p>
            </span>
          </div>
        </div>
    <!--    <img src="image/truview.png" class="img-responsive center-block hidden-xs" alt="truview" />-->
        <div class="row">
          <div class="col-xs-8" style="left:16%">
            <img src="image/truview.png" class="img-responsive center-block" alt="truview" />
          </div>
        </div>
        </div></div></div>
</section>

<section class="visual fff">
  <div class="container my-fluid-container">
    <div class="row">
      <div class="col-md-12 col-xl-8 ">
        <div class="row" style="margin-top:20px">
          <div class="col-xl-8 hidden-lg hidden-md">
              <img src="image/visual.png" class="img-responsive center-block text-center" alt="visual" />
          </div>
          <!--case 1200-->
          <div class="col-lg-12 hidden-xs" style="margin-top:20px">
              <img src="image/visual2.png" class="img-responsive" alt="visual" />
          </div>
        </div>
        <h3 class="text-left" style="font-weight:600">Expérience visuelle spectaculaire.</h3>
        <h5 class="text-left" style="line-height:20px">La Technologie TruView ™ NTSC 85% améliore l'effet d’affichage des couleurs pour des images plus nettes et plus lumineuses, permettant un résultat avec des couleurs réelles. </h5>
        <h5 class="text-left" style="line-height:20px">La technique unique d'amélioration des couleurs de TruView ™ permet d’obtenir des images multi-angles en haute définitions, affichage des vidéos plus vif et lumineu.</h5>
  </div></div>
</div>
</section>

<section class="share fff">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-xl-8">
        <div class="row sharerowfff" style="margin-top:20px;margin-bottom:20px">
          <div class="col-xl-8 hidden-lg hidden-md">
              <img src="image/share.png" class="img-responsive center-block text-center"  />
          </div>
          <!--case 1200-->
          <div class="col-lg-12 hidden-xs" style="margin-top:80px">
              <img src="image/share2.png" class="img-responsive"  />
          </div>
        </div>
        <h3 class="text-left" style="font-weight:600">Partager devient facile</h3>
        <h5 class="text-left" style="line-height:20px">Écran IPS haute résolution, l’angle de visibilité atteint 178°
de sorte que partager des films et des jeux est une expérience agréable. Des images
claires et remarquables sous tous les angles.</h5>
        </div></div></div>
</section>

<section class="smoothergame f11">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-xl-8">
        <h3 class="text-center" style="margin-top:20px;font-weight:600">Gaming Fluide</h3>
        <h5 class="text-center" style="line-height:20px">La technologie ONECELL ™</h5>
        <h5 class="text-center" style="line-height:20px">permet 5 points de contacts sur l'écran et offre une</h5>
        <h5 class="text-center" style="line-height:20px">expérience plus fluide sur les jeux</h5>
        <h5 class="text-center" style="line-height:20px">tels que Piano Magic,</h5>
        <h5 class="text-center" style="line-height:20px">Fruit Ninja, iSTAR Drummer.</h5>

        <div class="row" style="">
          <div class="col-xl-8">
              <img src="image/orgin.png" class="img-responsive center-block text-center" />
          </div>
        </div>
        <h3 class="text-right" style="margin-top:-60px;font-weight:600">OnCell ™</h3>
        <h3 class="text-right" style="font-weight:600;margin-top:-10px">5 points de contacts</h3>
        <h5 class="text-right" style="margin-top:-7px;margin-bottom:20px"> Affichage plus superbe que jamais</h5>
        </div></div></div>
</section>

<section class="bodydesign fff">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-xl-8">
        <h3 class="text-center" style="margin-top:30px;font-weight:600">Monocoque résistante et design</h3>
        <h5 class="text-center" style="line-height:20px">La Monocoque à la mode de VISION se compose de pièces en mag-Aluma, 30% plus résistante mais aussi 20% plus légère que  les autres téléphones mobiles ordinaires, mince mais ferme.</h5>
        <div class="row" style="margin-top:-30px">
          <div class="col-xl-8">
              <img src="image/topbottom.png" class="img-responsive center-block text-center" />
          </div>
        </div>

        <h3 class="text-center " style="margin-top:0px;font-weight:600" >Prise confortable</h3>
        <h5 class="text-center " style="line-height:20px">Matière dépolie spécifique utilisée pour la coque arrière afin de fournir une prise en main confortable.</h5>
        <div class="row " style="margin-top:25px">
          <div class="col-xl-8 col-md-offset-2" style="height:410px;">
            <div class=""  id="phonecover" style="opacity:1">
              <ul class="changeImg">
              <li><img src="image/phonedes3.png" id="phonedes3" class="img-responsive center-block text-center" /></li>
              <li><img src="image/phonedes2.png" id="phonedes2" class="img-responsive center-block text-center" /></li>
              <li><img src="image/phonedes1.png" id="phonedes1" class="img-responsive center-block text-center" /></li>
              </ul>
            </div>
          </div>

          <script type="text/javascript">
            $(function(){
              flag=true;
              $(window).bind("scroll", function(event){
                        var thisButtomTop = parseInt($(window).height()) + parseInt($(window).scrollTop());
                        var thisTop = parseInt($(window).scrollTop());
                            var PictureTop = parseInt($("#phonecover").offset().top);
                             if (PictureTop >= thisTop && PictureTop <= thisButtomTop){
                               function doS(){
                               var switchSpeed = 1000;         //图片切换时间
                               var fadeSpeed = 1500;          //渐变时间
                               var timesRun = 0;
                               var interval=setInterval(function(){
                                 timesRun += 1;
                               if(timesRun===4){
                                 $('#phonedes1').addClass('hidden');
                                 $('#phonedes2').addClass('hidden');
                                 $('#phonedes3').removeClass('hidden');
                                 clearInterval(interval);
                               }
                               console.log(timesRun);
                                   $('#phonecover ul li img').last().fadeOut(fadeSpeed, function(){
                                       $(this).show().parent().prependTo($('#phonecover ul'));
                                   });
                               }, switchSpeed);
                    }
                    if(flag){
                      doS();
                      flag=false;

                    }

                    }
            })
            })
          </script>
        </div>
        <div class="pictureh3">
          <div class=" pullri" style="position:relative;z-index:999">
        <h3 class="text-left " style="margin-top:40px;font-weight:600">Qualité d'image supérieure</h3>
        <h5 class="text-left " style="line-height:20px">Les dernières lentilles américaine OV, 8.0MP améliorent grandements la qualité
d'image pour vous aider à saisir les moments précieux de votre vie d'une manière super
nette.</h5>
        </div>
        <div class="row" style="margin-top:-10px">
          <div class="col-xl-8 ">
              <img src="image/e60s.png" class="img-responsive center-block text-center e60s" />
          </div>
        </div>
        </div>
        <div class="row text-center  hidden-md " style="font-size:12px;margin-top:10px">
          <div class="col-xs-4 he4row des1 hidden-lg">
            <span><p class="he4rowtitle"><img src="image/descamera.png" style="width:30%;margin-top:15px" class="img-responsive center-block text-center" /></p>
                  <p class="he4rowcont">8.0MP/5.0MP</p>
            </span>
          </div>
          <div class="col-xs-4 he4row des1 hidden-lg">
            <span><p class="he4rowtitle"><img src="image/desf2.0.png" style="width:30%;margin-top:15px" class="img-responsive center-block text-center" /></p>
                  <p class="he4rowcont">Ouverture F2.0</p>
            </span>
          </div>
          <div class="col-xs-4 he4row hidden-lg">
            <span><p class="he4rowtitle"><img src="image/deshdr.png" style="width:40%;margin-top:25px" class="img-responsive center-block text-center" /></p>
                  <p class="he4rowcont" style="margin-top:13px">HDR vidéo</p>
            </span>
          </div>
        </div>
        <div class="row text-center rowhe4row hidden-md" style="font-size:12px;margin-bottom:60px;border-top:1px solid #e3e3e3">
          <div class="col-xs-4 he4row des1 hidden-lg">
            <span><p class="he4rowtitle"><img src="image/descmos.png" style="width:30%;margin-top:15px" class="img-responsive center-block text-center" /></p>
                  <p class="he4rowcont" style="margin-bottom:0">Stacking CMOS</p>
            </span>
          </div>
          <div class="col-xs-4 he4row des1 hidden-lg">
            <span><p class="he4rowtitle"><img src="image/desflash.png" style="width:30%;margin-top:10px" class="img-responsive center-block text-center" /></p>
                  <p class="he4rowcont" style="margin-bottom:0">Flash puissant</p>
            </span>
          </div>
          <div class="col-xs-4 he4row hidden-lg">
            <span><p class="he4rowtitle"><img src="image/deslens.png" style="width:25%;margin-top:10px" class="img-responsive center-block text-center" /></p>
                  <p class="he4rowcont" style="margin-bottom:0;margin-top:13px">Lentilles 5P</p>
            </span>
          </div>
        </div>

        <h3 class="text-center" style="margin-top:px;margin-bottom:px;font-weight:600">Luminosité plus confortable</h3>
        <div class="row" style="">
          <div class="col-xl-8">
            <div class="metercover" id="metercover" style="opacity:0.5">
              <img src="image/blur-meter.png" id="blurmeter" class="img-responsive center-block text-center" />
              <img src="image/meter.png" id="meter" class="img-responsive hidden center-block text-center" />
              <script type="text/javascript">
              $(function(){
                $(window).bind("scroll", function(event){
                          var thisButtomTop = parseInt($(window).height()) + parseInt($(window).scrollTop());
                          var thisTop = parseInt($(window).scrollTop());
                              var PictureTop = parseInt($("#metercover").offset().top);
                               if (PictureTop >= thisTop && PictureTop <= thisButtomTop) {
                                function setOP() {
                                  var opc=0.5;
                                while (opc<0.899) {
                                    opc=opc+0.1;
                                    $("#metercover").animate({
                                      opacity:1
                                    },1000,function(){
                                      $('#blurmeter').addClass('hidden');
                                      $('#meter').removeClass('hidden');
                                      return opc=1;
                                    });
                                  }
                                 }
                                 setOP();
                               }
                })
              })
              </script>
            </div>
          </div>
        </div>
        <h5 class="text-left greaterh3" style="line-height:20px;margin-bottom:20px">Qualité d'image supérieure--Les dernières lentilles américaine OV, 8.0MP améliorent grandements la qualité d'image pour vous aider à saisir les moments précieux de votre vie d'une manière supernette.</h5>
        </div></div></div>
</section>

<section class="quad f11">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-xl-8">
        <h3 class="text-left rapider" style="margin-top:20px;font-weight:600">Plus rapide que jamais</h3>
        <h4 class="text-left rapider">Grâce au processeur Quad-Core,8 Go Rom + 1 Go de ram vous pouvez atteindre vos meilleurs scores de jeux</h4>
        <h5 class="text-left rapider" style="margin-top:10px;line-height:20px">Quad Core CPU et les 1 Go de RAM sont fait afin de vous aider à atteindre vos meilleurs scores de jeux ainsi qu’accomplir simultanément plusieurs tâches, vous serez plus rapide que quiconque.</h5>
        <div class="row" style="">
          <div class="col-xl-8">
              <img src="image/rade.png" class="img-responsive center-block text-center" />
          </div>
        </div>

        <div class="row" style="margin-top:20px">
          <div class="col-xl-8 hidden-lg hidden-md">
              <img src="image/picture.png" class="img-responsive center-block text-center" />
          </div>
          <div class="col-md-12 hidden-xs">
              <img src="image/picture2.png" class="img-responsive center-block text-center" />
          </div>
        </div>

        <h3 class="text-left" style="margin-top:20px;font-weight:600">Performance puissante</h3>
        <h5 class="text-left" style="margin-top:10px;line-height:20px">La combinaison de 1 Go de RAM, de la technologie avancée SAMSUNG DDR3 emmc5.0 ainsi que du processeur Quad-core permet un gaming fluide, plus de multi-tâches et même d’une économie de 20% de la battrie.</h5>

        <div class="row" style="margin-top:40px;">
          <div class="col-xl-8">
              <img src="image/zhizhu.png" class="img-responsive center-block text-center" />
          </div>
        </div>

        <h3 class="text-right" style="margin-top:20px;font-weight:600">Plus grande puissance de Batterie</h3>
        <h5 class="text-right" style="margin-top:0px">20% de puissance de batterie en plus</h5>
        <h5 class="text-right" style="margin-top:0px">permettant de se divertir plus longtemps.</h5>

        <div class="row pull-right" style="">
          <div class="col-xl-6">
            <img src="image/bettery.png" style="width:50%" class="img-responsive center-block " />
          </div>
        </div>
          <script type="text/javascript">
          $(function(){
            $(window).bind("scroll", function(event){
                    //窗口的高度+看不见的顶部的高度=屏幕低部距离最顶部的高度
                      var thisButtomTop = parseInt($(window).height()) + parseInt($(window).scrollTop());
                      var thisTop = parseInt($(window).scrollTop()); //屏幕顶部距离最顶部的高度
                          var PictureTop = parseInt($("#s1-progressbars").offset().top);
                           if (PictureTop >= thisTop && PictureTop <= thisButtomTop) {

                            function serT() {
                                 $('#h-default-themed .progress-bar').each(function () {
                                     var $pb = $(this);
                                     $pb.attr('data-transitiongoal', $pb.attr('data-transitiongoal-backup'));
                                     $pb.progressbar();
                                 });
                             }
                             serT();
                           }else if(PictureTop >= thisTop && PictureTop <= thisButtomTop+50){
                             function remove() {
                                 $('#h-default-themed .progress-bar').attr('data-transitiongoal', 0).progressbar();
                             }
                             remove();
                           }
            })
          })
          </script>
        <div class="row"  style="margin-top:120px">
          <div class="col-sm-8 col-md-8 col-md-offset-2" id="s1-progressbars">
            <div class="tab-pane fade active in" id="h-default-themed">
        <h5 class="hidden"> <button type="button" class="btn btn-primary" id="h-default-themed-start">start</button> <button type="button" class="btn btn-danger" id="h-default-themed-reset">reset</button></h5>
        <div class="bs-example">
            <div class="">
                <h5 class="text-left" style="margin-top:0px;color:#666;">Film *1.3X</h5>
                <div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" data-transitiongoal-backup="70" data-transitiongoal="100" aria-valuenow="40" style="width: 0%;"></div></div>
                <h5 class="text-left" style="color:#666;">Surface 3G * 1.3X</h5>
                <div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" data-transitiongoal-backup="70" data-transitiongoal="100" aria-valuenow="60" style="width: 0%;"></div></div>
                <h5 class="text-left" style="color:#666;">Jeux 3D*1.35X</h5>
                <div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" data-transitiongoal-backup="60" data-transitiongoal="80" aria-valuenow="80" style="width: 0%;"></div></div>
                <h5 class="text-left" style="color:#666;">Musique*1.3X</h5>
                <div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" data-transitiongoal-backup="75" data-transitiongoal="100" aria-valuenow="100" style="width: 0%;"></div></div>
                <h5 class="text-left" style="color:#666;">Veille*1.25X</h5>
                <div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" data-transitiongoal-backup="80" data-transitiongoal="100" aria-valuenow="100" style="width: 0%;"></div></div>
            </div>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#h-default-themed-start').click(function() {
                        $('#h-default-themed .progress-bar').each(function () {
                            var $pb = $(this);
                            $pb.attr('data-transitiongoal', $pb.attr('data-transitiongoal-backup'));
                            $pb.progressbar();
                        });
                    });
                    $('#h-default-themed-reset').click(function() {
                        $('#h-default-themed .progress-bar').attr('data-transitiongoal', 0).progressbar();
                    });
                });
            </script>
        </div>
        </div>
        </div>
        </div>

        <h3 class="text-center" style="margin-top:60px;font-weight:600">Connectez étroitement avec la 3G</h3>
        <h5 class="text-center greaterh3" style="margin-top:0px;line-height:20px">Parcourez vos sites vos boutiques en ligne préférés et restez à jour avec vos réseaux sociaux grâce à la connecvité 3G de VISION, il n'y a plus besoin de s’inquiéter d’être à la traîne.</h5>

        <div class="row" style="">
          <div class="col-xl-8">
            <img src="image/phone1.png" style="" class="img-responsive center-block " />
          </div>
        </div>

        <div class="row" style="margin-top:px">
          <div class="col-sm-8 col-md-8 col-md-offset-2">
            <div class="tab-pane fade active in" id="h-default-themed">
        <div class="bs-example">
            <div class="">
                <h4 class="text-center" style="margin-top:0px;color:#666;">Comparaison de la vitesse de téléchargement</h4>
                <h5 class="text-left" style="margin-top:0px;color:#666;">  2G   25Kbps</h5>
                <div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" data-transitiongoal-backup="10" data-transitiongoal="100" aria-valuenow="40" style="width: 0%;"></div></div>
                <h5 class="text-left" style="color:#666;">3G   500Kbps</h5>
                <div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" data-transitiongoal-backup="85" data-transitiongoal="100" aria-valuenow="60" style="width: 0%;"></div></div>
        </div>
        </div>
        </div>
        </div>
        </div>

        <div class="row" style="margin-top:30px;padding-top:20px;padding-bottom:20px">
          <div class="col-xs-6 hidden-lg hidden-md pull-left">
            <img src="image/weizhi.png" style="" class="img-responsive" />
          </div>
          <div class="col-md-3 col-md-offset-3 hidden-xs">
            <img src="image/weizhi.png" style="" class="img-responsive" />
          </div>
          <div class="col-xs-6 hidden-lg hidden-md pull-right">
            <h3 class="text-right" style="font-weight:600;font-size:16px">GPS et A-GPS</h3>
            <h5 class="text-right" style="line-height:20px">Partagez votre position avec vos amis où que vous êtes. Plus important, vous ne serez jamais perdu dans la jungle.</h5>

          </div>
          <div class="col-md-3 hidden-xs">
            <h3 class="text-right font-weight:600" style="">GPS et A-GPS</h3>
            <h5 class="text-center" style="">Partagez votre position avec vos amis où que vous êtes. Plus important, vous ne serez jamais perdu dans la jungle.</h5>
          </div>
        </div>

        <div class="row" style="margin-top:30px">
          <div class="col-xl-8">
            <img src="image/phone2.png" style="width:80%" class="img-responsive center-block " />
          </div>
        </div>


    <!--    <div class="row text-center" style="margin-top:30px;font-size:12px;margin-bottom:60px;">
          <div class="col-xs-4 he4row he5row">
            <span><p class="he4rowtitle"><img src="image/screen.png" style="width:50%;padding-top:5px" alt="img-responsive center-block " /></p>
                  <p class="he4rowcont" style="margin-bottom:0;color:#000">5.0’ HD Display 85% NTSC</p>
            </span>
          </div>
          <div class="col-xs-4 he4row he5row">
            <span><p class="he4rowtitle"><img src="image/cilp.png" style="width:50%;padding-top:5px" alt="img-responsive center-block " /></p>
                  <p class="he4rowcont" style="margin-bottom:0;color:#000">1.0GHz 64bit Quad Core</p>
            </span>
          </div>
          <div class="col-xs-4 he4row">
            <span><p class="he4rowtitle"><img src="image/fcam.png" style="width:50%;padding-top:5px" alt="img-responsive center-block " /></p>
                  <p class="he4rowcont" style="margin-bottom:0;color:#000">8.0MP / 5.0MP</p>
            </span>
          </div>
        </div> -->

        <!--轮播Carousel-->
        <div class="row text-center hidden-lg hidden-md" style="margin-top:10px;font-size:12px;margin-bottom:10px;height:80px">
          <div class="col-xl-12">
            <div id="myCarousel" class="carousel slide">
            <div class="carousel-inner">

              <div class="item active">
                <div class="row">
                  <div class="col-xs-4 he4row he5row">
                    <span><p class="he4rowtitle"><img src="image/screen.png" style="width:30%;padding-top:5px" alt="img-responsive center-block " /></p>
                          <p class="he4rowcont" style="margin-bottom:0;color:#000">5.0’ HD Display 85% NTSC</p>
                    </span>
                  </div>
                  <div class="col-xs-4 he4row he5row">
                    <span><p class="he4rowtitle"><img src="image/cilp.png" style="width:30%;padding-top:5px" alt="img-responsive center-block " /></p>
                          <p class="he4rowcont" style="margin-bottom:0;color:#000">1.0GHz 64bit Quad Core</p>
                    </span>
                  </div>
                  <div class="col-xs-4 he4row">
                    <span><p class="he4rowtitle"><img src="image/fcam.png" style="width:30%;padding-top:5px" alt="img-responsive center-block " /></p>
                          <p class="he4rowcont" style="margin-bottom:0;color:#000">8.0MP / 5.0MP</p>
                    </span>
                  </div>
                </div>
              </div>

              <div class="item">
                <div class="row">
                  <div class="col-xs-4 he4row he5row">
                    <span><p class="he4rowtitle"><img src="image/cpu.png" style="width:25%;padding-top:10px" alt="img-responsive center-block " /></p>
                          <p class="he4rowcont" style="margin-bottom:0;color:#000">8GB/1GB DDR3</p>
                    </span>
                  </div>
                  <div class="col-xs-4 he4row he5row">
                    <span><p class="he4rowtitle"><img src="image/unibody-design.png" style="width:25%;padding-top:15px" alt="img-responsive center-block " /></p>
                          <p class="he4rowcont" style="margin-bottom:0;padding-top:9px;color:#000">Unibody Design</p>
                    </span>
                  </div>
                  <div class="col-xs-4 he4row">
                    <span><p class="he4rowtitle"><img src="image/lte.png" style="width:25%;padding-top:10px" alt="img-responsive center-block " /></p>
                          <p class="he4rowcont" style="margin-bottom:0;color:#000">3G Network</p>
                    </span>
                  </div>
                </div>
              </div>

              <div class="item">
                <div class="row">
                  <div class="col-xs-4 he4row he5row col-xs-offset-2">
                    <span><p class="he4rowtitle"><img src="image/sim.png" style="width:25%;padding-top:5px" alt="img-responsive center-block " /></p>
                          <p class="he4rowcont" style="margin-bottom:0;color:#000">Dual SIM</p>
                    </span>
                  </div>
                  <div class="col-xs-4 he4row ">
                    <span><p class="he4rowtitle"><img src="image/battery.png" style="width:25%;padding-top:13px" alt="img-responsive center-block " /></p>
                          <p class="he4rowcont" style="margin-bottom:0;padding-top:5px;color:#000">2500mAh Battery</p>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <!-- 轮播（Carousel）导航 -->
           <a class="carousel-control left swipeleft" href="#myCarousel"
              data-slide="prev" style="  background: rgba(255,255,255,.1);font-size:40px;margin-top:-10px">&lsaquo;</a>
           <a class="carousel-control right swipeleft" href="#myCarousel"
              data-slide="next" style="  background: rgba(255,255,255,.1);font-size:40px;margin-top:-10px">&rsaquo;</a>
            </div>
          </div>
        </div>
        <script type="text/javascript">
          $(function(){
            $('#identifier').carousel({
              interval: false
            })
            //移动兼容
            $('#myCarousel').hammer().on('swipeleft', function(){
              $(this).carousel('next');
            });
            $('#myCarousel').hammer().on('swiperight', function(){
              $(this).carousel('prev');
            });
          })
        </script>


        </div></div></div>
</section>

<section class="contect fff">
  <div class="container">
    <div class="row" style="margin-top:30px" id="pushhere">
      <div class="container-fluid" style="padding:0">
      <div class="col-md-12 col-sm-12 col-xs-12" style="padding:0">
        <img src="image/buy-gift.jpg"  class="img-responsive center-block " />
      </div>
      </div>
      </div>

      <div class="row" style="">
        <div class="col-md-8 col-md-offset-2">
          <h5 class="text-left" style="line-height:20px;margin-top:10px;font-size:14px">Du XX au XX, achète le dernier smartphone VISION de itel et enregistre ton email et numéro de téléphone afin d'obtenir un cadeau surprise. Veuillez noter que seul un nombre limité de cadeaux sont disponnibles. Premier arrivé, premier servi.</h5>
        </div>
      </div>


    <div class="row text-center contectrow" style="margin-top:20px">
      <div class="col-md-6 col-xs-12">
        <div class="row selerow">
          <div class="container">
            <div class="col-xs-12 col-md-4 col-md-offset-4">
              <h5 class="text-left" style="margin-top:20px;color:#333">Choisis ta région</h5>
              <div class="input-group" style="width:100%">
                <button class="btn btn-default btn-sm dropdown-toggle" type="button" style="width:100%" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="zSt">Côte d'Ivoire<span class="caret"></span></button>
                  <ul class="dropdown-menu text-center" id="zRegs" style="width:100%;">
                    <li><a href="javascript:;" class="text-center"> Côte d'Ivoire Abidjan </a></li>
                    <li><a href="javascript:;" class="text-center"> Côte d'Ivoire bouake </a></li>
                <!--    <li><a href="javascript:;" class="text-center"> Coate d'Ivoire Daloa </a></li>
                    <li><a href="javascript:;" class="text-center"> Ghana ACCRA  </a></li>
                    <li><a href="javascript:;" class="text-center"> Ghana KUMASI  </a></li>-->
                  </ul>
                  <script type="text/javascript">
                  $(function(){
                    $('#zRegs li').click(function(){
                      var i=($(this).index('#zRegs li'));
                    //  var $zL=[" Coate d'Ivoire Abidjan "," Coate d'Ivoire bouake "," Coate d'Ivoire Daloa "," Ghana ACCRA  "," Ghana KUMASI  "]
                     var $zL=[" Coate d'Ivoire Abidjan "," Coate d'Ivoire bouake "]
                      $('#zSt').html($zL[i]);

                      var $regs=[" Coate d'Ivoire","Ghana"],
                          $zeroNumber=["+00225","+00233"];
                      function isContains(str, substr) {
                            return new RegExp(substr).test(str);
                        }
                        if(isContains($zL[i],$regs[0])){
                            $('#basic-addon1').html($zeroNumber[0]);
                        }
                        if(isContains($zL[i],$regs[1])){
                            $('#basic-addon1').html($zeroNumber[1]);
                        }
                    });
                  })
                  </script>
              </div>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="container">
            <div class="col-xs-12 col-md-4 col-md-offset-4">
              <h5 class="text-left" style="margin-top:20px;color:#333">Nom</h5>
              <div class="input-group" style="width:100%"><input type="text" class="form-control" id="username" placeholder="name" aria-describedby="basic-addon1"></div>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="container">
            <div class="col-xs-12 col-md-4 col-md-offset-4">
              <h5 class="text-left" style="margin-top:20px;color:#333">E-mail</h5>
              <div class="input-group" style="width:100%"><input type="text" class="form-control" id="email" placeholder="E-mail" aria-describedby="basic-addon1"></div>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="container">
            <div class="col-xs-12 col-md-4 col-md-offset-4">
              <h5 class="text-left" style="margin-top:20px;color:#333">Téléphone</h5>
              <div class="input-group" style="width:100%"><span class="input-group-addon" id="basic-addon1">+00225</span><input type="text" class="form-control" id="tel" placeholder="Tel" aria-describedby="basic-addon1"></div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="container">
            <div class="col-xs-12 col-md-4 col-md-offset-4">
              <h5 class="text-left" style="margin-top:20px;color:#333">Vérification</h5>
              <div class="input-group"  style="width:100%"><span class="input-group-addon"><img id="verifyPic" src="?m=order&a=verify" class="" width="48px" height="20px" style="border:none" /></span><input type="text" id="verify" class="form-control" id="tel" placeholder="Verify" aria-describedby="basic-addon1"></div>
            </div>
          </div>
        </div>

        <div class="row " style="margin-bottom:50px">
          <div class="container">
            <div class="col-xs-12 col-md-4 col-md-offset-4">
              <h5 class="text-left" style="margin-top:20px;color:#333"></h5>
              <a class="btn btn-info" id="submitBtn" style="width:100%;color:#fff">Soumettre</a>
            </div>
          </div>
        </div>

      </div>
    </div>

    </div>
</section>


<script type="text/javascript">
$(document).ready(function()
{
  $("#submitBtn").click(onClickSubmit);
});

function onClickSubmit(e)
{
  if ($("#username").val() == "")
  {
    alert("Name can not be empty!");
    $("#username").select();
    return;
  }
  if (!checkEmail($("#email").val()))
  {
    alert("Please enter the correct email!");
    $("#email").select();
    return;
  }
  if ($("#verify").val() == "")
  {
    alert("Verify can not be empty!");
    $("#verify").select();
    return;
  }
  var str= $("#zSt").html();
  str = str.replace(/<\/?[^>]*>/g,'');
  $.post("?m=order&a=order", {region:str, username: $("#username").val(), email:$("#email").val(), tel:$("#tel").val(), verify:$("#verify").val()}, onSubmit);
}

function onSubmit(value)
{
  var res = null;

  try
  {
    res = $.parseJSON(value);
  }
  catch (err)
  {
    //服务端返回异常，json数据不能正常解析
    alert("Unknown error!");
    return;
  }

  if (0 == res.code)
  {
    alert("Succeed! Thank you!");
    //$("#orderFrm")[0].reset();
    $('.purchasecase ,.truview,.visual,.share,.smoothergame,.bodydesign,.quad,.contect').fadeOut('slow').addClass('hidden');
    $('.sucess').removeClass('hidden').fadeIn('slow');
  }
  else
  {
    alert(res.msg);
    $("#verifyPic").attr("src", "?m=order&a=verify&rand=" + Math.random());
  }
}

function checkEmail(str)
{
  var re = /^([a-za-z0-9]+[_|-|.]?)*[a-za-z0-9]+@([a-za-z0-9]+[_|-|.]?)*[a-za-z0-9]+.[a-za-z]{2,3}$/;

  return re.test(str);
}
</script>
<footer style="overflow:hidden">
  <section class="sucess hidden">
    <div class="row">
      <div class="container">
        <div class="col-xs-6 col-xs-offset-3 sucessimg" style="margin-top:40px">
          <img src="image/sucess.png" class="img-responsive center-block text-center" alt="" />
          <h3 class="text-center sucessh3" style="margin-top:30px">Merci pour votre Achat</h3>
        </div>
      </div>
    </div>
    <div class="row sucessbtn">
      <div class="container">
        <div class="col-xs-12 text-center">
          <a href="javascript:;" class="btn btn-info subtn">Retour en haut de page</a>
        </div>
        <script type="text/javascript">
          $(function(){
            $('.subtn').click(function(){
              var $height=window.screen.height;
              if($height<650){
                $('.purchasecase').removeClass('hidden').fadeIn('slow');
              }
              $('.truview,.visual,.share,.smoothergame,.bodydesign,.quad,.contect').removeClass('hidden').fadeIn('slow');
              $('.sucess').addClass('hidden');
              $('html, body').animate({scrollTop:0}, 'slow');
            });
          })
        </script>
      </div>
    </div>
  </section>
</footer>
<?php echo Config::$countCode; ?>
  </body>
</html>
