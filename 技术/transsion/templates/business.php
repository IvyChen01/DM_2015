<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-4-17
 * Time: 上午11:21
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $_info['title']; ?></title>
    <?php
	if (!empty($_info['keywords'])) echo '<meta name="keywords" content="' . $_info['keywords'] . '" />';
    if (!empty($_info['description'])) echo '<meta name="description" content="' . $_info['description'] . '" />';
	?>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/style/master.css"/>
    <script src="/style/js/jquery-1.9.1.min.js"></script>
</head>
<?php
if ($_language_user == 'cn')
{
    echo "<body class='cn'><div id='wrapper'>";
    include("inc/cn_head.php");
}
else
{
    echo "<body class='en'><div id='wrapper'>";
    include("inc/head.php");
}
?>
    <div class="main">
        <div class="content">
            <div class="position"><a href="<?php echo $_menu_info['main_link']; ?>"><?php echo $_menu_info['main_name']; ?></a> > <span class="cur-pos"><?php echo $_menu_info['sub_name']; ?></span></div>
            <div class="page-title"><?php echo $_menu_info['sub_name']; ?></div>
        </div>
        
		<script type="text/javascript" src="style/js/map/jquery.js"></script>
<script type="text/javascript" src="style/js/map/raphael-min.js"></script>
<script type="text/javascript" src="style/js/map/worldMapConfig.js"></script>
<script type="text/javascript" src="style/js/map/map.js"></script>
<style media="screen">
    .stateTip, #StateTip{display:none; position:absolute; padding:8px; background:#fff; border:2px solid #2385B1; -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px; font-size:12px; font-family:Tahoma; color:#333;}
  .items{width:900px;height:400px;margin:0 auto}
    </style>
<div class="items" id="Item">
	<a href="javascript:;" class="fold"></a> 
	<div class="itemCon">
		<div id="WorldMap">
		</div>
	</div>
</div>
<script type="text/javascript">
      $(function(){
        $('#WorldMap').SVGMap({
        mapWidth: 900,
        mapHeight: 600,
        mapName: 'world'
        });
        var mapObj = {};
        $('#WorldMap').SVGMap({
              external: mapObj
        });
        var evt=(function(){
          $("#Item").die().on("click",function(event){
                 var e=window.event || event;
                 if(e.stopPropagation){
                    e.stopPropagation();
                  }else{
                    e.cancelBubble = true;
                 }
            });
        })();
        var india=(function(){
      		mapObj.IN.attr({fill: '#f00'});
      		mapObj.IN.mouseout(function(){
      			this.animate({
                      fill: '#f00'
                  }, 250);
      		});})();
        var ma=(function(){
          mapObj.MA.attr({fill: '#fdd'});
      		mapObj.MA.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ly=(function(){
          mapObj.LY.attr({fill: '#fdd'});
      		mapObj.LY.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var eg=(function(){
          mapObj.EG.attr({fill: '#fdd'});
      		mapObj.EG.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var eh=(function(){
          mapObj.EH.attr({fill: '#fdd'});
      		mapObj.EH.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var mr=(function(){
          mapObj.MR.attr({fill: '#fdd'});
      		mapObj.MR.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ml=(function(){
          mapObj.ML.attr({fill: '#fdd'});
      		mapObj.ML.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ne=(function(){
          mapObj.NE.attr({fill: '#fdd'});
      		mapObj.NE.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var td=(function(){
          mapObj.TD.attr({fill: '#fdd'});
      		mapObj.TD.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var sd=(function(){
          mapObj.SD.attr({fill: '#fdd'});
      		mapObj.SD.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var er=(function(){
          mapObj.ER.attr({fill: '#fdd'});
      		mapObj.ER.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var dj=(function(){
          mapObj.DJ.attr({fill: '#fdd'});
      		mapObj.DJ.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var so=(function(){
          mapObj.SO.attr({fill: '#fdd'});
      		mapObj.SO.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var et=(function(){
          mapObj.ET.attr({fill: '#fdd'});
      		mapObj.ET.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var sn=(function(){
          mapObj.SN.attr({fill: '#fdd'});
      		mapObj.SN.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var gw=(function(){
          mapObj.GW.attr({fill: '#fdd'});
      		mapObj.GW.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var gn=(function(){
          mapObj.GN.attr({fill: '#fdd'});
      		mapObj.GN.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var bf=(function(){
          mapObj.BF.attr({fill: '#fdd'});
      		mapObj.BF.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ke=(function(){
          mapObj.KE.attr({fill: '#fdd'});
      		mapObj.KE.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ug=(function(){
          mapObj.UG.attr({fill: '#fdd'});
      		mapObj.UG.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var rw=(function(){
          mapObj.RW.attr({fill: '#fdd'});
      		mapObj.RW.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var bi=(function(){
          mapObj.BI.attr({fill: '#fdd'});
      		mapObj.BI.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var tz=(function(){
          mapObj.TZ.attr({fill: '#fdd'});
      		mapObj.TZ.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var cf=(function(){
          mapObj.CF.attr({fill: '#fdd'});
      		mapObj.CF.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var cg=(function(){
          mapObj.CG.attr({fill: '#fdd'});
      		mapObj.CG.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var cd=(function(){
          mapObj.CD.attr({fill: '#fdd'});
      		mapObj.CD.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ga=(function(){
          mapObj.GA.attr({fill: '#fdd'});
      		mapObj.GA.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var gq=(function(){
          mapObj.GQ.attr({fill: '#fdd'});
      		mapObj.GQ.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var cm=(function(){
          mapObj.CM.attr({fill: '#fdd'});
      		mapObj.CM.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ng=(function(){
          mapObj.NG.attr({fill: '#fdd'});
      		mapObj.NG.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var bj=(function(){
          mapObj.BJ.attr({fill: '#fdd'});
      		mapObj.BJ.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var tg=(function(){
          mapObj.TG.attr({fill: '#fdd'});
      		mapObj.TG.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var gh=(function(){
          mapObj.GH.attr({fill: '#fdd'});
      		mapObj.GH.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ci=(function(){
          mapObj.CI.attr({fill: '#fdd'});
      		mapObj.CI.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var lr=(function(){
          mapObj.LR.attr({fill: '#fdd'});
      		mapObj.LR.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var sl=(function(){
          mapObj.SL.attr({fill: '#fdd'});
      		mapObj.SL.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ao=(function(){
          mapObj.AO.attr({fill: '#fdd'});
      		mapObj.AO.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var zm=(function(){
          mapObj.ZM.attr({fill: '#fdd'});
      		mapObj.ZM.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var mw=(function(){
          mapObj.MW.attr({fill: '#fdd'});
      		mapObj.MW.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var mz=(function(){
          mapObj.MZ.attr({fill: '#fdd'});
      		mapObj.MZ.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var zw=(function(){
          mapObj.ZW.attr({fill: '#fdd'});
      		mapObj.ZW.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ls=(function(){
          mapObj.LS.attr({fill: '#fdd'});
      		mapObj.LS.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var sz=(function(){
          mapObj.SZ.attr({fill: '#fdd'});
      		mapObj.SZ.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var bw=(function(){
          mapObj.BW.attr({fill: '#fdd'});
      		mapObj.BW.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var na=(function(){
          mapObj.NA.attr({fill: '#fdd'});
      		mapObj.NA.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var mg=(function(){
          mapObj.MG.attr({fill: '#fdd'});
      		mapObj.MG.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ae=(function(){
          mapObj.AE.attr({fill: '#fdd'});
      		mapObj.AE.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var sa=(function(){
          mapObj.SA.attr({fill: '#fdd'});
      		mapObj.SA.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ir=(function(){
          mapObj.IR.attr({fill: '#fdd'});
      		mapObj.IR.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var tr=(function(){
          mapObj.TR.attr({fill: '#fdd'});
      		mapObj.TR.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var id=(function(){
          mapObj.ID.attr({fill: '#fdd'});
      		mapObj.ID.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var th=(function(){
          mapObj.TH.attr({fill: '#fdd'});
      		mapObj.TH.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var vn=(function(){
          mapObj.VN.attr({fill: '#fdd'});
      		mapObj.VN.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var ph=(function(){
          mapObj.PH.attr({fill: '#fdd'});
      		mapObj.PH.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var pk=(function(){
          mapObj.PK.attr({fill: '#fdd'});
      		mapObj.PK.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var bd=(function(){
          mapObj.BD.attr({fill: '#fdd'});
      		mapObj.BD.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
        var fr=(function(){
          mapObj.FR.attr({fill: '#fdd'});
      		mapObj.FR.mouseout(function(){
      			this.animate({
                      fill: '#fdd'
                  }, 250);
      		});
        })();
      });
    </script>
		
        <div class="content">
			<?php echo $_info['content']; ?>
        </div>
        
        <div class="content">
            <div class="cur-sub-nav clearfix">
                <?php foreach ($_menu_images as $_key => $_value) { ?>
                    <div class="cnav-item">
                        <a href="<?php echo $_value['link']; ?>" class="cnav-pic"><img src="<?php echo $_value['menu_image']; ?>" alt="<?php echo $_info_detail[$_value['id']]; ?>"/></a>
                        <a href="<?php echo $_value['link']; ?>" class="cnav-til"><?php echo $_info_detail[$_value['id']]; ?></a>
                    </div>
                <?php } ?>
            </div>
            <script>
//                $(function(){
//                    $(".cnav-item").mouseover(function(){$(this).addClass("hover")}).mouseleave(function(){$(this).removeClass("hover")})
//                })
            </script>
        </div>
    </div>
    <?php
	if ($_language_user == 'cn')
	{
		include("inc/cn_footer.php");
	}
	else
	{
		include("inc/footer.php");
	}
	?>
</div>
</body>
</html>