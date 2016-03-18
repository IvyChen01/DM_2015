$(function(){
  showSearch();
    makeWish();
    clkShow();
    //setDate();
    searchWish();
    poWish();
    $('.content').focus(function(){  $('.content').html($('.content').val())});
    $('.cont-content span a').click(function(){  $('.content').html($('.content').val())})
    $('.share-container').cent();

});
jQuery.fn.center=function(){
    this.css('position','absolute');
    this.css('top',($(window).height()-this.height())/2 +$(window).scrollTop()+'px');
    this.css('left',($(window).width()-this.width())/2+$(window).scrollLeft()+'px');
    return this;
}
jQuery.fn.cent=function(){
    this.css('position','absolute');
    this.css('top',($(window).height()-this.height())/2 +$(window).scrollTop()-260+'px');
    this.css('left',($(window).width()-this.width())/2+$(window).scrollLeft()-200+'px');
    return this;
}
function showWall(evt,time,callback){
    $('.showall').fadeIn('slow');
    $('.showall p').html(evt);
    $('.showall').center();
    $('.showall').css('z-index','9999999');
    var sti=time||3000;
    setTimeout(function(){
         $('.showall p').html();
        $('.showall').hide()},sti);
    if(typeof callback == "function"){ callback();}
    $('body').click(function(){$('.showall').fadeOut('slow');})
}
function searchWish(){
    $('.search').click(function(){
       if(($('.int-btn').val()!=="")){
        sech();
    }else{
        showWall("Input search is empty.");
         $('.int-btn').focus();
    }
    })
 function sech(){
     $kword=$('.int-btn').val();
     $.post("?m=wish&a=search",
            {
                keywords:$kword,
            },
        function(value){
            dojson(value);
     });
 };
    function dojson(value){
        var jsonObj=JSON.parse(value);
            init(jsonObj);
        function init(){
        if((jsonObj.code=="0")){
            if (jsonObj.wishList == "")
		{
			showWall("Not found!");
		}else{
            function dohtml(data){
                 var colShow=$("#wishmain div.wish");
                 var att=data.length<colShow.length?data.length:colShow.length;
         //     showWall(data.length);
                //alert(data[0].photo);
                var htt='';
             htt+="<div class='wish'><span class='wall'><img class='photo' src='"
             htt+=data[0].photo
            htt+="'  width='56px' height='56px'><i class='name'>"
            htt+=data[0].username
            htt+="</i><i class='time'>"
            htt+=data[0].pubdate
            htt+="</i><i class='soli'>"
            htt+=data[0].content
            htt+="</i></span></div>";
              showWall(htt,5000);
                    }
            dohtml(jsonObj.wishList);
            }
        }
        }
        }
    }
//make a wish
function poWish(){
    $('.submit').click(function(){
        var $lili=$('.cont-select span a i.arrd');
        if(($lili.length=='1')&&($('#cot').val()!=="")){
            posh();
            isWished=true;
        }else{
            showWall("Input content is empty.Or selected.");
            $('#cot').focus();
        }
    });
    function posh(){
        setBall();
        $cor=null;
        $content=$('#cot').val();
        $color=''
        $color+="images/image/tik"
        $color+=adt+1;
        $color+=".png";
     $.post("?m=wish&a=doAdd",
            {
                content:$content,
                bgColor:$color,
            },
        function(data){
            djson(data);
     });
 };
    function djson(data){
        var jsonObj=JSON.parse(data);
            int(jsonObj);
        function int(){
        if((jsonObj.code!=="0")){
      //      showWall("Succeed! Thank you!",2000,ldo);

        setTimeout(function oneshare(){
            showWall("Succeed! Thank you!",0);
            setTimeout(function twoshare(){
              prvWish();
            },2000)
        },0)
      //      function ldo(){setTimeout("location.href='?m=wish&a=main'",2000);}
        }else{
            if(jsonObj.msg=='0'){showWall("Communication failure!");}
            if(jsonObj.msg=='101001'){showWall("No landing!");}
            if(jsonObj.msg=='105001'){showWall("Wishing content was empty!");}
            if(jsonObj.msg=='105002'){showWall("Once wished!");}
  //         (jsonObj.msg!=='0')||((jsonObj.msg=='101001')&&(showWall("Not login.")))||((jsonObj.msg=='105001')&&(showWall("Content empty.")))||((jsonObj.msg=="105002")&&(showWall("Wished.")));
        }
        sherUsername=jsonObj.username;
        sherPhoto=jsonObj.photo;
        sherTime=jsonObj.pubdate;
        }
    }
    }
//show wish
function prvWish(){
  var $li="";
      $li+="images/image/tic"
      $li+=adt+1
      $li+=".png";
  var $val=$('#cot').val();
  $('.container').hide();
  $('.cont').hide();
  $('.sharef').fadeIn();
  var sharhtml=""
      sharhtml+="<img src='"
      sharhtml+=$li
      sharhtml+="'"
      sharhtml+=" alt='' />"
      sharhtml+="<div class='sh-content'>"
      sharhtml+="<span class='sharwall'>"
      sharhtml+="<img class='sharphoto' src='"
      sharhtml+=sherPhoto
      sharhtml+="'"
      sharhtml+="width='56px' height='56px'></img>"
      sharhtml+="<i class='sharname'>"
      sharhtml+=sherUsername
      sharhtml+="</i><i class='shartime'>"
      sharhtml+=sherTime
      sharhtml+="</i><p class='sharsoli'>"
      sharhtml+=$val
      sharhtml+="</p></span></div><a class='sharebtn' onclick='funconce();return;'>SHARE</a>"

      $('.share-container').html(sharhtml);
}
//set ballnoon
function setBall(color){
    setColor=new Array("Violet","Green","Yellow","Orange","Blue");
    getC=new Array("images/image/tik1.png","images/image/tik2.png","images/image/tik3.png","images/image/tik4.png","images/image/tik5.png")
    getR=new Array("ti1","ti2","ti3","ti4","ti5")
    getco=null,getcolor=null;
    for(i=0;i<setBall.length;i++){
       if(setBall[i]==color){
        getcolor=getC[i];
        getco=getR[i];
       }
    }
}
//date
function setDate(){
dayName = new Array("", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")
monName = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")
now=new Date;
    var strDay;
if ((now.getDate()==1) || (now.getDate() != 11) && (now.getDate() % 10 == 1))
	strDay = "st ";
else if ((now.getDate() == 2) || (now.getDate() != 12) && (now.getDate() % 10 == 2))
	strDay = "nd ";
else if ((now.getDate() == 3) || (now.getDate() != 13) && (now.getDate() % 10 == 3))
	strDay = "rd ";
else
	strDay = "th ";
     setdata=(
/*dayName[now.getDay()]
+*/
now.getDate()
+
strDay
+
monName[now.getMonth()]
);
}
function showSearch(){
  $('.sl-search').hover(function(){
    $('.sl-search').hide();
    $('.sl-int').fadeIn();
    $('.int-btn').focus();
  })
 /* if($.trim($('#proj_id').val()).length==0){
    $('.sl-int').mouseleave(function(){
      $('.int-btn').blur();
      $('.sl-int').hide();
      $('.sl-search').show();
    })
  }*/
}
function makeWish(){

	$('.makeWish').click(function(){
		if (isWished)
		{
			feed();
		}
		else
		{
			$('.container').hide();
			$('.cont').fadeIn();
		}
	})
}
function clkShow(){
    adt=null;
var aobj=$(".cont-select span a");
    aobj.each(function(index){
    $(this).click(function(){
       adt=index;
    aobj.find('i').css('display','none');
        aobj.find('i').removeClass('arrd');
        $(this).find('i').css('display','block');
        $(this).find('i').addClass('arrd');
    })
    })
}
function SwapTxt()
  {
      var txt= document.getElementById("cot").innerText;
      var str=removeStr(txt);
      document.getElementById("pre").innerHTML=str;
  }
function removeStr(str) {
  //  str = str.replace(/<\/?[^>]*>/g, '');
//    str = str.replace(/[ | ]*\n/g, '');
  //  str = str.replace(/&nbsp;/ig, '');
    return str;
}
function preWish(){
    var $int=document.getElementById("cot").innerText;
    var $ball=$('.cont-select span a i.arrd');
    if($int>0&&$ball==1){
//    post;//提交
    }
}
