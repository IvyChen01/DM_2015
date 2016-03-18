$(function(){
      $('.fit').click(function(){
        function fithide(){
          $('.fit').hide('slow')
        }
          setTimeout(fithide(),3000);
      })
  //搜索请求
      $('.makesearch').click(function(){
        $('.widbar').fadeOut('slow')
      })
  //许愿
      $('.makewish').click(function(){
        $('.widbar').fadeOut('slow')
      })
  //    $('.wishint').focus();
  $(function(){
    if ($('.wishint').focus) {
      $('.wishto').css('bottom','15%');
    }
  })
  //选择气球颜色
      function clkShow(){
      var aobj=$(".wishto ul li");
      aobj.each(function(){
      $(this).click(function(){
      aobj.find('i').css('display','none');
          aobj.find('i').removeClass('arr');
          $(this).find('i').css('display','block');
          $(this).find('i').addClass('arr');
      })
      })
  };
  clkShow();
  //maket
  $('.maketo').click(function(){makewish();});
  //search
  $('.sent-search').click(function(){searchwish();});
  //back
  $('.searchto a.searchtobtn').click(function(){
    local.href="?m=wish&a=main&d=mobile";
  })
  //share
})
//mode
function showWall(evt,time,callback){
    $('.fit').fadeIn('slow');
    $('.fit p').html(evt);
    $('.fit').css('z-index','999');
    var sti=time||3000;
    setTimeout(function(){
         $('.fit p').html();
        $('.fit').hide('slow')},sti);
      if(typeof callback == "function"){ callback();}
}
//makewish
function makewish(argument) {
  var $liarr=$('.wishto ul li i.arrd');
  var $textint=$('.wishint').val();
      $indexbg=null;
  var $bg=""
      $bg+="images/image/tik"
      $bg+=$indexbg+1
      $bg+=".png";
  if($liarr!==''&&$textint!='')
      {
        maketo();
      }
  else{
    if($liarr==''){showWall("Selected.")}
    if($textint==''){showWall("Input content is empty.")}
  }
  var aobj=$(".cont-select span a");
      aobj.each(function(index){
        $(this).click(function(){
          $indexbg=index
        }
      )});

  function maketo(){
    $('.addwish').css('background-image','url(../images/images/bgadd.jpg)');
    $('.addwish').css('background-size','cover');
    $('.wishto').fadeOut('slow');
    $('.wishdo').fadeIn('slow');
    showWall('Touch to share.',4000);
    	$.post("?m=wish&a=doAdd",{content:$textint,bgColor:$bg},function(data){
        var res=JSON.parse(data);
        if (0 == res.code)
        {
          showWall("Succeed! Thank you!");
      //    location.href = "?m=wish";
        sherUsername=res.username;
        sherPhoto=res.photo;
        sherTime=res.pubdate;
        sherTc=res.content;
    //    console.log(sherUsername);
    //    console.log(sherPhoto);
    //    console.log(sherTime);
        sherCon=$('.wishint').val();
      var maketoStr=''
          maketoStr+="<img src='"
          maketoStr+=sherPhoto
          maketoStr+="' width='100px' height='100px' />"
          maketoStr+="<i class='sename'>"
          maketoStr+=sherUsername
          maketoStr+="</i>"
          maketoStr+="<i class='setime'>"
          maketoStr+=sherTime
          maketoStr+="</i>"
          maketoStr+="<i class='sesoli'>"
          maketoStr+=sherCon
          maketoStr+="</i>"
          maketoStr+="<a class='wishdobtn sy ft12'>Touch to share</a>";

          $('.wishdo').html(maketoStr);
      //set fool
        }
        else
        {
          showWall("Wished.");console.log(res.code);
          $('.wishdo').hide();
          setTimeout(function(){location.href="?m=wish&a=main&d=mobile"},2000);
        }
      })

  }
}
//search wish
function searchwish(){
  var $intput=$('.sent input').val();
  if($intput!==''){
    showWall('Search sucess.',2000);
    dowish();
  }else{
    showWall('Input enpty.')
    $('.sent input').focus();
  }
  function dowish(){
    $('.content').fadeOut('slow');
    $('.searchto').fadeIn('slow');
    showWall('Touch to back.',4000);
    $('.searchto').click(function(){
       location.href="?m=wish&a=main&d=mobile";
    })
    $.post("?m=wish&a=search",{keywords:$intput},function(data){
      var res=JSON.parse(data);
      var wishStr="";
      if (0==res.code)
      {
        if(res.wishList=="")
        {
          showWall("Not found!");
          $('.searchto').hide();
        setTimeout(function(){
          location.href="?m=wish&a=pageSearch";
        },1000)
        }
        else
        {
//          for(var key in res.wishList[0])
//          {
            wishStr+="<img src='"
            wishStr+=res.wishList[0].photo
            wishStr+="'width='100px' height='100px' />"
            wishStr+="<i class='sename'>"
            wishStr+=res.wishList[0].username
            wishStr+="</i>"
            wishStr+="<i class='setime'>"
            wishStr+=res.wishList[0].pubdate
            wishStr+="</i>"
            wishStr+="<i class='sesoli'>"
            wishStr+=res.wishList[0].content
            wishStr+="</i>"
            wishStr+="<a class='searchtobtn sy ft12'>Back to home.</a>"
//          }
          $(".searchto").html(wishStr);
        console.log('search')
        }
      }
      else
      {
        showWall('Content error.');
      }
    })
}
}
