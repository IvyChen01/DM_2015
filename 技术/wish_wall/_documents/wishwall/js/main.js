//页面处理
$(function(){
  showSearch();
    makeWish();
    clkShow();
    setDate();
    
    wall();
    searchWish();
    poWish();
});

//once
var wall=once(function(){
    $.post(
    "http://www.infinixmobility.com/wishwall",
        {key:once},
        function(){
            dohtml(data);
        }
    )
    })
function once(fn, context) { 
	var result;
	return function() { 
		if(fn) {
			result=fn.apply(context || this, arguments);
			fn = null;
		}
		return result;
	};
}
//showall
jQuery.fn.center=function(){
    this.css('position','absolute');
    this.css('top',($(window).height()-this.height())/2 +$(window).scrollTop()+'px');
    this.css('left',($(window).width()-this.width())/2+$(window).scrollLeft()+'px');
    return this;
}
function showWall(evt){
    $('.showall').fadeIn('slow');
    $('.showall p').html(evt);
    $('.showall').center();
    setTimeout(function(){
         $('.showall p').html();
        $('.showall').hide()},3000);
}

//搜索请求
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
     $.post("http://www.infinixmobility.com/wishwall/?m=wish&a=search",
            {
                keywords:$kword,
            },
        function(data){
            dojson();
     });
 };
    function dojson(data){
        var jsonObj=JSON.parse(data);
            init(jsonObj);
        function init(){
        if(    (jsonObj[0].code=="0")){ 
            dohtml(jsonObj[2]);
        }else{
            (jsonObj[1].msg!=='0')||((jsonObj[1].msg=='101001')&&(showWall("Not login.")))||((jsonObj[1].msg=='105001')&&(showWall("Content empty.")))||((jsonObj[1].msg=="105002")&&(showWall("Wished.")));
        }
           
        }
    } 
}
//loadwall
 function dohtml(data){
                 var colShow=$("div#wishmain");
                    var html='';
                    for(var i=0;i<data.length;i++){
                        setBall(data[i].bgcolor);
                        html+="<div class='wish' style='background:getcolor cover no-repeat;'>";
                        html+="<span class='wall'>";
                        html+="<img class='photo'  width='56px' height='56px' src='data[i].photo'>";
                        html+="<i class='name'>data[i].username</i>";
                        html+="<i class='time'>data[i].pubdate</i>";
                        html+="<i class='soli'>data[i].content</i>";
                        html+="</span></div>";
                    }
                        colShow.append(html);
            
            }

//make a wish
function poWish(){
    $('.submit').click(function(){
        var $lili=$('.cont-select span a i.arrd');//($('#cot').val()!=="")
        if($lili.length=='1'){
            posh();
        }else{
            showWall("Input content is empty.Or selected.");
            $('#cot').focus();
        }
    });
    function posh(){
        setBall();
        $cor=null;
        $content=$('#cot').innerText;
        $color=setColor[$cor];
            $('.cont-select span a i').click(function(){
            $cor=$(this).index();
        })
     $.post("http://www.infinixmobility.com/wishwall/?m=wish&a=doAdd",
            {
                content:$content,
                bgColor:$color,
            },
        function(data){
            djson();
     });
 };
    function djson(data){
        var jsonObj=JSON.parse(data);
            int(jsonObj);
        function int(){
        if(    (jsonObj[0].code=="0")){ 
                 location.reload();
        }else{
            (jsonObj[1].msg!=='0')||((jsonObj[1].msg=='101001')&&(showWall("Not login.")))||((jsonObj[1].msg=='105001')&&(showWall("Content empty.")))||((jsonObj[1].msg=="105002")&&(showWall("Wished.")));
        }
           
        }
    } 
    }

//set ballnoon
function setBall(color){
    setColor=new Array("Violet","Green","Yellow","Orange","Blue");
    getC=new Array("/image/tik1.png","/image/tik2.png","/image/tik3.png","/image/tik4.png","/image/tik5.png")
    getR=new Array("ti1","ti2","ti3","ti4","ti5")
    getco=null;
    getcolor=null;
    for(i=0;i<setDate.length;i++){
       if(setDate[i]==color){
        getcolor=getC[i];
        getco=getr[i];
       }
    }
}

//date
function setDate(){
dayName = new Array("", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")
monName = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")
now = new Date;
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

//search显示隐藏
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

//make a wish
function makeWish(){
$('.makeWish').click(function(){
    $('.container').hide();
    $('.cont').fadeIn();
})
/*    $('.submit').click(function(){//重载
    $('.cont').hide();
    $('.container').fadeIn();
    location.reload();
})*/
}

//点击显示
function clkShow(){
var aobj=$(".cont-select span a");
    aobj.each(function(){
    $(this).click(function(){
    aobj.find('i').css('display','none');
        aobj.find('i').removeClass('arrd');
        $(this).find('i').css('display','block');
        $(this).find('i').addClass('arrd');
    })
    })
}

//输入预览
function SwapTxt()
  {
      var txt= document.getElementById("cot").innerText;
      var str=removeStr(txt);
      document.getElementById("pre").innerHTML=str;
  }
//过滤
function removeStr(str) {
    str = str.replace(/<\/?[^>]*>/g, '');
    str = str.replace(/[ | ]*\n/g, '');
    str = str.replace(/&nbsp;/ig, '');
    return str;
}
//许愿提交验证
function preWish(){
    var $int=document.getElementById("cot").innerText;
    var $ball=$('.cont-select span a i.arrd');
//    function(){};
    if($int>0&&$ball==1){
//    post;//提交
    console.log(1)
    }
}





//post
var pageSize=10;
var pi=1;//全局页数
$(function(){
    //页数读取
    function getData(pagenumber){
        pi++;//页面自加，下一次新一页，后退回调
        $.get("shop-test.json",{pagesize:pageSize,pagenumber:pagenumber},function(data){
            if(data.length>0){
                var jsonObj=JSON.parse(data);
                initData(jsonObj);
            }
        });
        $.ajax({
            type:"post",
            url:"shop-test.json",
            data:{pagesize:pageSize,pagenumber:pagenumber},
            datatype:"json",
            sucess:function(){
                if(data.length>0){
                    var jsonObj=JSON.parse(data);
                    initData(jsonObj);
                }
            },
            beforeSend:function(){
                $(".loaddiv").show();
            },
            complete:function(){
                $(".loaddiv").hide();
            },
            error:function(){
                $(".loaddiv").hide();
           //     alert("commit error!");
                $(".end").show();//列表内容结束
            },
        });
    }
    
    //初始化，第一页
    getData(1);
    //html模板
    function initData(json){
        var colShow=$(".shop-container ul");
        var html='';
        for(var i=0;i<json.length;i++){
      /*      html+="<li>";
            html+="<div class='shop-item-img'>";
            html+="<a href='javascript:;'>";
            html+="<i class='shopimg' style='background:json[i].shopimg no-repeat;'>";
         // html+=json[i].shopimg,
            html+="</i></a></div>";
            html+="<div class='shop-item-inf'>";
            html+="<p class='shop-item-title'>";
            html+=json[i].title;
            html+="</p><P class='shop-item-txt'>";
            html+=json[i].text;
            html+="</P><p class='shop-price'>Price:<i class='price'>";
            html+=json[i].price;
            html+="</i></p><P class='shop-time'>Countdown:<i class='time'>";
            html+=json[i].time;
            html+="</i></P><p class='shop-market'>Vendor Market:<i class='market'>";
            html+=json[i].market;
            html+="</i></p><p class='pushbtn'><a href='javascript:;'>PURCCHASE</a></p></div></li>"; */
        }
            colShow.append(html);
    }
 getData(pi);
})
//随机浮动
var xPos = 300;
var yPos = 200;
var step = 1;
var delay = 30;
var height = 0;
var Hoffset = 0;
var Woffset = 0;
var yon = 0;
var xon = 0;
var pause = true;
var interval;
var div=document.getElementById("img");
div.style.top = yPos;
function changePos()
{
width = document.body.clientWidth;
height = document.body.clientHeight;
Hoffset = div.offsetHeight;
Woffset = div.offsetWidth;
div.style.left = xPos + document.body.scrollLeft;
div.style.top = yPos + document.body.scrollTop;
if (yon)
{yPos = yPos + step;}
else
{yPos = yPos - step;}
if (yPos < 0)
{yon = 1;yPos = 0;}
if (yPos >= (height - Hoffset))
{yon = 0;yPos = (height - Hoffset);}
if (xon)
{xPos = xPos + step;}
else
{xPos = xPos - step;}
if (xPos < 0)
{xon = 1;xPos = 0;}
if (xPos >= (width - Woffset))
{xon = 0;xPos = (width - Woffset);   }
}
function start()
{
div.visibility = "visible";
interval = setInterval('changePos()', delay);
}
function pause_resume()
{
if(pause)
{
clearInterval(interval);
pause = false;}
else
{
interval = setInterval('changePos()',delay);
pause = true;
}
}
start();
