<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>share wish</title>
  <script src="js/jquery.js" charset="utf-8"></script>
  <style media="screen">
  *{ margin:0; padding:0; list-style:none; }
  body{font:12px/1.5 tahoma,arial,"Hiragino Sans GB",宋体,sans-serif;color:#444;margin:0;min-width:500px;scoll=no;overflow:hidden;}
  body,div,form,img,ul,ol,li,dl,dt,dd,p{margin:0; padding:0; border:0;}
  ul,li,ol,dl,dt,dd{list-style:none;}
  h1,h2,h3,h4,h5,h6{ margin:0; padding:0; }
  .clearfix:after, .clearfix:after, .main:after, .left:after, .right:after, dl:after, dt:after, dd:after, ul:after, li:after {
      clear: both;
      content: ".";
      display: block;
      height: 0;
      overflow: hidden;
      visibility: hidden;
  }
  i,em,var{ font-style:normal;}
  .sharef{width:100%;height:100%;position:absolute;background:url(images/image/sharef.jpg) no-repeat;}
  .share-container>img:nth-child(1){width:400px;height:400px;background-size:cover;}
  .sh-content{width:380px;height:200px;top:-230px;position:relative;left:10px;}
  .share-container .sharebtnto{display:inline-block;padding:6px 10px;background:#eb5674;color:#fff;position:relative;top:-160px;left:150px;cursor:pointer;border-radius:5px;text-decoration:none;}
  .share-container .sharebtnto:hover{background:#fff;color:#eb5674;}
  .sharwall{display:inline-block;width:330px;height:160px;margin:20px 60px;}
  .sh-content a.sharphoto{border:none;width:56px;height:56px;display:inline-block;}
  .sharname{display: inline-block;line-height: 18px;top:-24px;position:relative;font-size:18px;margin-left:40px;width:180px;overflow:hidden;}
  .shartime{display:inline-block;line-height:14px;top:-20px;position:relative;font-size:14px;margin-left:100px;width:180px;overflow:hidden;}
  .sharsoli{display:block;line-height:20px;top:-20px;position:relative;font-size:16px;height:80px;overflow:hidden;overflow-y:auto;width:250px;padding:6px 10px;overflow:hidden;word-wrap:break-word;}
  </style>
  <script>
  $(function(){
    $('.share-container').center();
  })
  jQuery.fn.center=function(){
      this.css('position','absolute');
      this.css('top',($(window).height()-this.height())/2 +$(window).scrollTop()+50+'px');
      this.css('left',($(window).width()-this.width())/2+$(window).scrollLeft()+'px');
      return this;
  }
  </script>
  </head>
  <body>
    <div class="sharef">
      <div class="share-container">
        <img src="<?php echo $wishData['bgcolor']; ?>" alt="" />
        <div class="sh-content">
            <span class="sharwall">
              <img class="sharphoto" src="<?php echo $wishData['photo']; ?>"  width="56px" height="56px" />
              <i class="sharname"><?php echo $wishData['username']; ?></i>
              <i class="shartime"><?php echo $wishData['pubdate']; ?></i>
              <p class="sharsoli"><?php echo $wishData['content']; ?></p>
              </span>
        </div>

        <a class="sharebtnto"  href="./" target="_self">Make a wish</a>
      </div>
    </div>
  </body>
</html>
