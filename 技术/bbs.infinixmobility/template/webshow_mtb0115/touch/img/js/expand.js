
$('.float-open').bind('click', function() {
    $('#mwp').toggleClass('open-right');
    $('body').toggleClass('open-body');
    //document.ontouchmove = function(e){ e.preventDefault(); }
});
$('.float-close').bind('click', function() {
	$('#mwp').removeClass('open-right');
	$('body').removeClass('open-body');
	//document.ontouchmove = function(e){ return true; }
});


$(document).ready(function(){
    $(".a_menu").toggle(function(){
		 $("#signin_menu").show('fast');
       },function(){
         $("#signin_menu").hide('slow');
       });
});


$(function(){
    var mh1 = $("#mwp").outerHeight();
	var mw = $(window).width();
	var mh = document.body.scrollHeight+document.documentElement.scrollTop;
    var whf = document.documentElement.clientHeight;
	var mht = $("#ttoolbar").outerHeight();
	var mhb = $("#btoolbar").outerHeight();
	var mhnv = $("#side_nv .nv_c").outerHeight()
	var mhtt = mht+0;
	var mhbb = mhb+5;
	var mwscroll = (mw-10)/5
	var mvsmilie = mw-45;
	var wfloading = (mw-150)/2;
    mh = mh > 600 ? mh : 600;
	$(".cc_home_h .s1 img").css({"width":mw});
//	$(".float-news").css({"height":mh + 43});
	$(".nv_c").css({"height":mh + 43});
	$(".t_blank").css({"height":mhtt});
//	$(".b_blank").css({"height":mhbb});
	$(".scroll #position em").css({"width":mwscroll});
	//$("#infscr-loading").css({"left":200});
	$(".search-btn-toggle a").click(function(){
	   if($("#searchform").css("display") == "none"){
			$("#searchform").fadeIn('fast');
	   }else{
	   		$("#searchform").fadeOut('fast');
	   }
	});


});

$(document).ready(function() {
    $(window).scroll(function() {
        if ($(document).scrollTop() >= $(document).height() - $(window).height()) {
			//$('#ttoolbar').fadeIn();
		}else{
            if ($(document).scrollTop() >= 50) {
			   // $('#ttoolbar').fadeOut();
	        }else if($(document).scrollTop() < 50){
		       // $('#ttoolbar').fadeIn();
            }
		}
	});
});


$(document).ready(function(){
	$(window).scroll(function(){
		if($.browser.msie && $.browser.version=="6.0")$("#btoolbar").css("top",$(window).height()-$("#btoolbar").height()+$(document).scrollTop());
	});
});


$(document).ready(function(){
$('a#scrollToBottom').click(function(){
$('html, body, .content').animate({scrollTop: $(document).height()}, 300);
return false;
});
}) 

function showMenu(id){
	$(".p_pop:not(#" + id +"_menu)").css("display", "none");        //others must be hidden
	if( $("#"+id+"_menu").css("display") == "none" ){
		$("#"+id+"_menu").css("display","block");
	}
	else if($("#"+id+"_menu").css("display") == "block")    {
		$("#"+id+"_menu").css("display","none");
	}
}

var slider = new Swipe(document.getElementById('slider'), {
      callback: function(e, pos) {
        var i = bullets.length;
        while (i--) {
          bullets[i].className = ' ';
        }
        bullets[pos].className = 'on';

      }
    }),
    bullets = document.getElementById('position').getElementsByTagName('em');
function view_a(a) {
    for(var i=1;i<=4;i++){
		document.getElementById('box_a' + i).style.display = 'none';
		document.getElementById('tab_a' + i).className = '';
    }
	    document.getElementById('box_a'+a).style.display='block';
	    document.getElementById('tab_a'+a).className='on';
}	
