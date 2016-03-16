<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Distributeurs - TECNO</title>
    <link rel="stylesheet" href="/Public/css/grid.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/reset.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/default.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/jquery.bxslider.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/Public/css/experience.css" media="screen" title="no title" charset="utf-8">
    <link rel="shortcut icon" href="/Public/img/logo/favicon.ico">
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
				<li class="addall"><a href="<?php echo U('Home/Product/index','','');?>"><?php echo (L("product")); ?></a>
          <ul class="tele-products">
            <li><a href="<?php echo U('Home/Product/index','','');?>"><?php echo (L("all")); ?></a></li>
            <?php if(is_array($goodsCatslist)): $i = 0; $__LIST__ = $goodsCatslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Home/Product/goodsCatDetail',array('cid'=>$vo['catId']));?>"><?php echo ($vo['catName']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </li>
				<li><a href="<?php echo U('Home/Article/index','','');?>" ><?php echo (L("news")); ?></a></li>
				<li><a href="<?php echo U('Home/Index/service','','');?>" class="active"><?php echo (L("retail_center")); ?></a></li>
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
      <!--main-wrapper-->
      <div class="retail-centre-wrapper">
        <div class="retail-banner">
          <img src="/Public/Img/test/retail-centre-banner.jpg" alt="Magasin de TECNO" />
        </div>

        <div class="location-filter-wrapper">
          <div class="wrapper clearfloat">
            <h1 class="locale-title"><?php echo (L("find_store")); ?></h1>
            <!-- <select id='areaId1' name="areaId1"
						onchange='javascript:getAreaList("areaId2",this.value,0)'>
							<option value=''><?php echo (L("select")); ?></option>
							<?php if(is_array($areaList)): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['areaId']); ?>' <?php if($object['areaId1'] == $vo['areaId'] ): ?>selected<?php endif; ?>><?php echo ($vo['areaName']); ?>
							</option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select> <select id='areaId2' name="areaId2">
							<option value=''><?php echo (L("select")); ?></option>
					</select> -->
            
            <form id="frm_filter" class="" action="#" method="post">
              <div class="col-left">
                <div class="dd-wrapper">
                  <select class="dd" id="areaId1"   sb="19007767" name="areaId1" onchange='javascript:getAreaList("areaId2",this.value,0)'>
                    <option value='0'>Country</option>
                       <?php if(is_array($areaList)): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value='<?php echo ($vo['areaId']); ?>' <?php if($object['areaId1'] == $vo['areaId'] ): ?>selected<?php endif; ?>><?php echo ($vo['areaName']); ?>
							</option><?php endforeach; endif; else: echo "" ;endif; ?>
                    <!-- <option selected="selected">Pays</option>
                    <option value="9" selected="selected">Burundi</option>
                    <option value="6" >Cameroun</option>
                    <option value="11" selected="selected">RDC</option>
                    <option value="2">Égypte</option>
                    <option value="4">Éthiopie</option>
                    <option value="3">Ghana</option>
                    <option value="1">Kenya</option>
                    <option value="12">Mali</option>
                    <option value="5">Nigeria</option>
                    <option value="10">Rwanda</option>
                    <option value="8">Tanzanie</option>
                    <option value="7">Ouganda</option>
                    <option value="13" selected="selected">Zambie</option> -->
                  </select>
                  <div id="sbHolder_19007767" class="sbHolder">
                    <a href="javascript:;" id="sbToggle_19007767" class="sbToggle"></a>
                    <a href="javascript:;" id="sbSelectors_19007767" class="sbSelector">Country</a>
                    <ul id="sbOptions_19007767" class="sbOptions">
                      <?php if(is_array($areaList)): $i = 0; $__LIST__ = $areaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="#<?php echo ($vo['areaId']); ?>" datalist="<?php echo ($vo['areaId']); ?>"><?php echo ($vo['areaName']); ?></a></li>
							<!-- <option value='<?php echo ($vo['areaId']); ?>' <?php if($object['areaId1'] == $vo['areaId'] ): ?>selected<?php endif; ?>><?php echo ($vo['areaName']); ?>
							</option> --><?php endforeach; endif; else: echo "" ;endif; ?>
                      <!-- <li><a href="#Pays" rel="Pays">Pays</a></li>
                      <li><a href="#9" rel="9">Burundi</a></li>
                      <li><a href="#6" rel="6">Cameroun</a></li>
                      <li><a href="#11" rel="11">RDC</a></li>
                      <li><a href="#2" rel="2">Égypte</a></li>
                      <li><a href="#4" rel="4">Éthiopie</a></li>
                      <li><a href="#3" rel="3">Ghana</a></li>
                      <li><a href="#1" rel="1">Kenya</a></li>
                      <li><a href="#12" rel="12">Mali</a></li>
                      <li><a href="#5" rel="5">Nigeria</a></li>
                      <li><a href="#10" rel="10">Rwanda</a></li>
                      <li><a href="#8" rel="8">Tanzanie</a></li>
                      <li><a href="#7" rel="7">Ouganda</a></li>
                      <li><a href="#13" rel="13">Zambie</a></li> -->
                    </ul>
                  </div></div>
                  <div class="dd-wrapper">
                    <div id="boxCity">
                      <select id='areaId2' name="areaId2"  onchange='javascript:getShopList(this.value)'>
							<option value='0'>City</option>
					  </select>
                      <!-- <select id="city" name="city" onchange="loadItems(this)" sb="86803563">
                        <option selected="selected">City</option>
                        <option value="49" selected="selected">Bujumbura</option>
                      </select> -->
                      <div id="sbHolder_86803563" class="sbHolder">
                        <a href="javascript:;" id="sbToggle_86803563" class="sbToggle"></a>
                        <a href="javascript:;" id="sbSelector_86803563" class="sbSelector">City</a>
                        <ul id="sbOptions_86803563" class="sbOptions">
                          <li><a href="#City" rel="City">City</a></li>
                          <!-- <li><a href="#49" rel="49">Bujumbura</a></li> -->
                        </ul>
                      </div>
                    </div>
                  </div>



                <div class="location-loader">
                  <img src="/Public/Img/logo/loader.gif" alt="" />
                </div>

              </div>

              <div class="col-right">
                <ul class="checkboxes">
                  <li><label for="tecno_stores" class="tecno-stores">
                    <input type="checkbox" data-rel="one" checked id="tecno_stores" name="tecno_stores" value="">
                  TECNO STORES</label></li>
                  <li><label for="service_locations" class="service-locations">
                    <input type="checkbox" data-rel="two" id="service_locations" name="service_locations" value="">
                  SERVICE LOCATIONS</label></li>
                </ul>
              </div>
            </form>
          </div>
        </div>

        <div class="locations-list-wrapper">
          <div class="wrapper">
            <ul class="locations-list">
              <?php if(is_array($shopList)): $i = 0; $__LIST__ = $shopList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="one"><div class="details">
                <h2><?php echo ($vo['shopName']); ?></h2>
                <div class="info location">
                  <?php echo ($vo['shopAddress']); ?>
                </div>
                <div class="info email">
                  <?php echo ($vo['shopEmail']); ?>
                </div>
                <div class="info phone">
                  <?php echo ($vo['shopTel']); ?>
                </div>
              </div></li><?php endforeach; endif; else: echo "" ;endif; ?>
              <!-- <li class="one"><div class="details"><h2>TECNO Center</h2><div class="info location">
                TECNO Center
              </div></div></li>

              <li class="two"><div class="details">
                <h2>TECNO Rapair Center</h2>
                <div class="info location">
                  TECNO Center
                </div>
              </div></li>

              <li class="one"><div class="details">
                <h2>EL Batal</h2>
                <div class="info location">
                  22 Elsharkat Street - El wailey
                </div>
                <div class="info email">
                  +21283937233
                </div>
              </div></li>

              <li class="one"><div class="details">
                <h2>EL Batal</h2>
                <div class="info location">
                  22 Elsharkat Street - El wailey
                </div>
                <div class="info email">
                  +21283937233
                </div>
              </div></li>
 -->
            </ul>
          </div>
        </div>
      </div>
      <!--end main-wrapper-->

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

  <script src="<?php echo C('STATIC_PATH');?>Plugins/BJUI/js/jquery-1.9.1.js"></script>
  <script src="/Public/Js/jquery.bxslider.min.js" charset="utf-8"></script>
  <script src="/Public/Js/main.js" charset="utf-8"></script>
  <script src="/Public/Js/nav.js" charset="utf-8"></script>
  <script src="/Public/Js/common.js" charset="utf-8"></script>
  <script>
  $(function(){
		 $('#goodscat1').addClass('phantom');
		 $('#goodscat2').addClass('boom');
		 $('#goodscat3').addClass('other');
		 $('#goodscat4').addClass('feature');
		 $('#goodscat5').addClass('table');
		 
		 
	  });
  function getAreaList(objId,parentId,t,id){
	   var params = {};
	   params.parentId = parentId;
	   $('#'+objId).empty();
	   var html = [];
	   if(parentId==0){
		   html.push('<option value="">CITY</option>');
		   getShopList(0);
		   $('#'+objId).html(html.join(''));
	   }else{
		   $.post("<?php echo U('Home/Index/queryShowByList');?>",params,function(data,textStatus){
			    html.push('<option value="">CITY</option>');
				var json = WST.toJson(data);
				if(json.status=='1' && json.list.length>0){
					var opts = null;
					for(var i=0;i<json.list.length;i++){
						opts = json.list[i];
						html.push('<option value="'+opts.areaId+'" '+((id==opts.areaId)?'selected':'')+'>'+opts.areaName+'</option>');
					    
					}
				}
				$('#'+objId).html(html.join(''));
		   }); 
	   }
	   
  }
  function getShopList(areaId){
	  var params = {};
	   params.areaId = areaId;
	   $('.locations-list').empty();
	   var html = [];
	  $.post("<?php echo U('Home/Index/queryShopListById');?>",params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1' &&json.list !=null && json.list.length>0){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<li class="one"><div class="details">');
					html.push('<h2>'+opts.shopName+'</h2>');
					html.push('<div class="info location">'+opts.shopAddress+'</div>');
					html.push('<div class="info email">'+opts.shopEmail+'</div>');
					html.push('<div class="info phone">'+opts.shopTel+'</div>');
					html.push('</div></li>');
				}
			}
			$('.locations-list').html(html.join(''));
	   });
  }
  function select_en(){
	 	 url = '/index.php?m=Home&c=Index&a=service';
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
		 url = '/index.php?m=Home&c=Index&a=service';
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
$(function(){

  $('ul#sbOptions_19007767 li').on('click',function(){
    var datalist=$(this).find('a').attr('datalist');
var setText=$(this).find('a').html();
    getAreaListSet('sbOptions_86803563',datalist,0);
$('#sbSelectors_19007767').html(setText);
  function getAreaListSet(objId,parentId,t,id){
   var params = {};
   params.parentId = parentId;
   $('#'+objId).html();
   var html = [];
   if(parentId==0){
     html.push('<li><a  data-city="">CITY</a></li>');
     getShopList(0);
     $('#'+objId).html(html.join(''));
   }else{
     $.post("/index.php?m=Home&c=Index&a=queryShowByList",params,function(data,textStatus){
        html.push('<li><a  data-city="">CITY</a></li>');
      var json = WST.toJson(data);
      if(json.status=='1' && json.list.length>0){
        var opts = null;
        for(var i=0;i<json.list.length;i++){
          opts = json.list[i];
          html.push('<li><a datacity="'+opts.areaId+'" '+((id==opts.areaId)?'selected':'')+'>'+opts.areaName+'</a></li>');

        }
      }
      $('#'+objId).html(html.join(''));
     });
   }

}
  })


$('#sbOptions_86803563').on('click','li',function(){
    var datacity=$(this).find('a').attr('datacity');
var cityname=$(this).find('a').html();
$('#sbSelector_86803563').html(cityname);
    getShopListSet(datacity);
function getShopListSet(areaId){
	  var params = {};
	   params.areaId = areaId;
	   $('.locations-list').empty();
	   var html = [];
	  $.post("<?php echo U('Home/Index/queryShopListById');?>",params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1' &&json.list !=null && json.list.length>0){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<li class="one"><div class="details">');
					html.push('<h2>'+opts.shopName+'</h2>');
					html.push('<div class="info location">'+opts.shopAddress+'</div>');
					html.push('<div class="info email">'+opts.shopEmail+'</div>');
					html.push('<div class="info phone">'+opts.shopTel+'</div>');
					html.push('</div></li>');
				}
			}
			$('.locations-list').html(html.join(''));
	   });
  }
  })
})

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