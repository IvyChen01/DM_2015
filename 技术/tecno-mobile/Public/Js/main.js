$(function(){
  var width=$(window).width();//this width
/*search*/
//toggle
$.fn.toggler = function( fn, fn2 ) {
    var args = arguments,guid = fn.guid || $.guid++,i=0,
    toggler = function( event ) {
      var lastToggle = ( $._data( this, "lastToggle" + fn.guid ) || 0 ) % i;
      $._data( this, "lastToggle" + fn.guid, lastToggle + 1 );
      event.preventDefault();
      return args[ lastToggle ].apply( this, arguments ) || false;
    };
    toggler.guid = guid;
    while ( i < args.length ) {
      args[ i++ ].guid = guid;
    }
    return this.click( toggler );
  };

if(width>780){
  $(".searchbtn").toggler(function(){
      $("nav").addClass("leftint");
      $("nav").removeClass("rightint");
      $(".search-int").addClass("showint");
      $(".search-int").removeClass("shint");
      $(".search-int").focus();
      if(width<1100){
         $("nav li a").addClass("paddingint");
        if(width<970){
          $("nav").hide();
        }
      }
    },function(){
      $("nav").removeClass("leftint");
      $("nav").addClass("rightint");
      $(".search-int").removeClass("showint");
      $(".search-int").addClass("shint");
      $(".search-int").blur();
      if(width<1100){
        $("nav li a").removeClass("paddingint");
        if(width<970){
          $("nav").show("slow");
        }
      }
    })
}
/*end search*/
/*addnav*/
  if(width>780){
    function delCss(){
      $(".addnav").css("transform","");
      $(".addnav").css("opacity","0");
      $(".addnav").css("visibility","hidden");
      $(".addnav").css("box-shadow","0");
      $(".addnav").css("height","0px");
      $("li.addall a").css("-webkit-transform","scale(1.0,1.0)");
      $("li.addall a").css("color","#414042");
    }
    $("li.addall").hover(function(){
    $(".addnav").css("transform","all 0.2s linear");
    $(".addnav").css("opacity","1");
    $(".addnav").css("visibility","visible");
    $(".addnav").css("box-shadow","0px 2px 5px -3px rgba(0,0,0,.5)");
    $(".addnav").css("height","167px");
    $("li.addall a").css("-webkit-transform","scale(1.1,1.1)");
    $("li.addall a").css("color","#1596B0");
    $("nav.slide ul li:not(.addall)").hover(function(){
      delCss();
    })
  /*  if($("header").mouseout()){
      delCss();
    }*///先进入后离开 then after
},function(){
  $(".addnav").hover(function(){},function(){
    delCss();
  })
})
}
/*end addnav*/
/*bxslider*/
function equalHeight(group) {
  tallest = 0;
  group.each(function() {
     thisHeight = $(this).height();
     if(thisHeight > tallest) {
        tallest = thisHeight;
     }
  });
  group.height(tallest);
}
//$(window).resize(function(){ location.reload(); })
$(function(){
 if(width>1050){
   $('#bxslider').bxSlider({
     mode: 'fade',
     auto: true,
     speed: 2000,
     controls:true
   });
 }
});
/*end bxslider*/
/*mouduletable*/
if($(window).width() > 1280){
		$('#moduletable').bxSlider({
			auto: true,
			slideWidth: 5000,
			minSlides: 3,
			maxSlides: 3,
			moveSlides: 1,
			pager: false
		});
	}
	else if($(window).width() > 640){
		$('#moduletable').bxSlider({
			slideWidth: 5000,
			minSlides: 2,
			maxSlides: 2,
			pager: false
		});
	}
	else{
		$('#moduletable').bxSlider({pager: false});
	}
  $(".trigger").click(function(e) {
    $("body,html").animate({scrollTop:$('#starproducts').offset().top},950);
  		if($(".moduletable").hasClass("first-scroll")){
  			$(".moduletable").addClass('open');

  			$(".star-product .closestar").addClass("visible");
  		}
  		else{
  			$(".moduletable").delay(500).queue(function(){
          $(".moduletable").addClass('open first-scroll').clearQueue();
  				$(".star-product .closestar").addClass("visible").clearQueue();
      	});
  		}
  		return false;
    });
  	$(".star-product .closestar").click(function(e) {
  		$(this).removeClass('visible');
  		$(".moduletable").removeClass("open");
  		return false;
    });
  	$(".feature-icon").click(function(e) {
  		$("#featured-products-wrapper").addClass("open");
  		return false;
  	});
  	$("#featured-products .close").click(function(e) {
  		$("#featured-products-wrapper").removeClass("open");
  		return false;
  	});
/*end mouduleable*/
/*purple green blue*/
        $("#moduletable li").each(function(index, elem){
            if(index == 0){
                $(this).addClass('green');
            }else{
                var previousLI = $(this).prev();
                var nextLI = $(this).next();

                if(previousLI.hasClass('green')){
                    $(this).addClass('blue');
                }else if(previousLI.hasClass('blue')){
                    $(this).addClass('purple');
                }else{
                    $(this).addClass('blue');
                }
            }
        });
/*end */
/*lastnews*/
if($(window).width()>1024){
  equalHeight($(".lastnews .block"));
}
if($(window).width()<=1024&&$(window).width()>=780){
  equalHeight($(".lastnews .updates-block"));
}
/*end lastnews*/
/*backtotop*/
$(window).scroll(function(){
  ($(this).scrollTop()>300)?$(".back-to-top").addClass('is-visible'):$(".back-to-top").removeClass('is-visible fade-out');
  if($(this).scrollTop()>1200){
    $(".back-to-top").addClass('fade-out')
  }
})
$('.back-to-top').on('click',function(evevt){
  event.preventDefault();
  $('body,html').animate({scrollTop:0,},700)
})
/*end backtotop*/
/*video popup*/
$(".video-popup").click(function(event){
  event.preventDefault();
  $(".overlay").show();
  $(".popup").show();
})
$(".popup .closevideo,.overlay").on("click",function(i){
  i.preventDefault();
  $(".popup").hide();
  $(".overlay").hide();
})
/*end video popup*/
/*lang selecte*/
$(".select-lang").click(function(e){
  e.preventDefault();
  $('.lang-popup').show();
})
$(".lang-popup ul li").click(function(){
  $(".lang-popup").hide();
})
/*end lang selecte*/
/*tele search*/
if($(window).width()<780){
  $(".searchbtn").click(function(){
    if($(".searchbox").is(".rightRs")){
      $(".searchbox").addClass("leftRs").removeClass("rightRs");
    }else if($(".searchbox").is(".leftRs")){

      $(".searchbox").addClass("rightRs").removeClass("leftRs");
    }
  })
}
$('.searchbtn').click(function(){
  if(!$(".search-int").val()==""){
    //do search
    $.post('path',{keywords:$(".search-int").val()},function(res){
      var res=null;
      res=$.parseJSON(value);
      if(0===res.code){alert('No result!')}else if(1==res.code){location.href="res.path"}
    })
  }
})
/*end tele search*/
/*product article height*/
if($(window).width() > 480){
        equalHeight($("#articles .item-wrapper"));
        equalHeight($("#products-list .item-wrapper"));
    }
/*product article height*/
/*article nav*/
$('.fourth li').click(function(){
  $('.fourth li').removeClass('fouactive');
  $(this).addClass('fouactive');
  //do html
})
/*end article nav*/
/*product article toggle*/
$('.articles-menu-btn').click(function(){$('.fourth').toggle('slow')})
$('.products-menu-btn').click(function(){$('.products-content-nav').toggle('slow')})
/*end product article toggle*/
/*load location item*/
function loadItems(elem){
    if(typeof $(elem).val() !== "undefined" && $(elem).val() != '' && parseInt($(elem).val()) > 0){
        var selectedValue = $(elem).val();
        $.ajax({
            type: "GET",
            data: {
                'cid': $(elem).val(),
                'task': 'listlocations'
            },
            url: BASE_URL_SITE+"ajax.php",
            cache: false,
            beforeSend: function(){
                $(".location-loader").show();
                $(".retail_center_pagination_parent").remove();
            },
            success: function (data) {
                $(".location-loader").hide();

                $(".locations-list").empty().html();
                if(typeof data !== "undefined"){
                    var locations = $.parseJSON(data);

                    $("#city option").each(function () {
                        $(this).removeAttr("selected");
                    });

                    $('#city > select > option[value="'+selectedValue+'"]').attr("selected", "selected");

                    $.each(locations, function(index, elem){
                        var li = "<li class='"+elem.type+"'>"+
                            "<div class='details'>"+
                            "<h2>"+elem.locationname+"</h2>"+
                            "<div class='info location'>"+elem.locationphysicaladdress+"</div>"+
                            "<div class='info email'><a href='mailto:"+elem.locationemailaddress+"'> "+elem.locationemailaddress+"</a></div>"+
                            "<div class='info phone'>"+elem.locationPhoneNumber+"</div>"+
                            "</div>"+
                            "</li>";

                        $(".locations-list").append(li);
                    });

                    $(".phone").each(function(index, elem){
                        if($(this).html() == '' || $(this).html() == 'undefined'){
                            $(this).remove();
                        }
                    });

                    if($(window).width() > 800){
                        equalHeight($(".details"));
                    }
                }else{
                    $("#city").find('option:selected').removeAttr("selected");
                    $(".locations-list").parent().empty().html("<div class='no-result'>No Locations to display</div>");
                }
            }
        });
    }
}
/*end load location item*/
/*data-video*/
$('.btn-play').click(function(){
  var data_video=$('.btn-play').attr('data-video');console.log(data_video);
  $("#ifrm").attr("src",data_video);
})
/*data-video*/
/*validator*/
if(typeof $.validator != 'undefined'){
    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || value.match(/[a-zA-Z]+/);
    }, "Non alphabetic characters not allowed.");

    $.validator.addMethod("phoneKE", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 &&
            phone_number.match(/^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/);
    }, INVALID_MOBILE_NUMBER);

    $.validator.addMethod("checkCaptcha", function(value, element) {
        return parseInt(value) === parseInt($(element).attr('rel'));
    }, CAPTCHA_INVALID);

    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || value.match(/^([a-zA-Z0-9_-]+)$/);
    }, "Only alphabet and numeric characters allowed.");

    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });

    $("#frm_contactus").validate({
        rules: {
            name: {
                required: true,
                alpha: true
            },
            mobile: {
                required: true,
                phoneKE: true
            },
            email: {
                required: true,
                email: true
            },
            enquiry: {
                required: true,
                rangelength: [10, 500]
            },
            captcha: {
                required: true,
                number: true,
                checkCaptcha: true
            }
        },
        messages: {
            name: {
                required: PLEASE_ENTER_YOUR_NAME,
                alpha: PLEASE_ENTER_A_VALID_NAME
            },
            mobile: {
                required: INVALID_MOBILE_NUMBER,
                phoneKE: INVALID_MOBILE_NUMBER
            },
            email: {
                required: PLEASE_ENTER_YOUR_EMAIL_ADDRESS,
                email: PLEASE_ENTER_A_VALID_EMAIL_ADDRESS
            },
            enquiry: {
                required: PLEASE_ENTER_YOUR_COMMENT,
                alphanumeric: PLEASE_ENTER_YOUR_COMMENT,
                rangelength: COMMENT_IS_TOO_LONG
            },
            captcha: {
                required: CAPTCHA_REQUIRED,
                number: CAPTCHA_REQUIRED_NUMERIC,
                checkCaptcha: CAPTCHA_INVALID
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                cache: false,
                beforeSubmit: function(formData, jqForm, options){
                    $(".btn_contactus").attr({'disabled': 'disabled'}).val(PROCESSING);
                },
                success: function(responseText, statusText, xhr, $form){
                    $(".btn_contactus").removeAttr('disabled').val(SUBMIT);

                    if(typeof responseText !== "undefined" && responseText != ''){
                        var data = $.parseJSON(responseText);

                        if(data.status == "success"){
                            $(".message").removeClass('error').addClass('success');
                            $(".message").empty().html(data.msg);
                            $(".message").stop().fadeIn("slow", function(){
                                $('html,body').animate({
                                        scrollTop: $(".message").offset().top - 100},
                                    'slow', function(){
                                        document.getElementById("frm_contactus").reset();
                                        $(".message").delay(3000).fadeOut("slow");
                                    }
                                );
                            });
                        }else{
                            $(".message").removeClass('success').addClass('error');
                            $(".message").empty().html(data.msg);
                            $(".message").stop().fadeIn("slow", function(){
                                $('html,body').animate({
                                        scrollTop: $(".message").offset().top - 100},
                                    'slow', function(){
                                        $(".message").delay(3000).fadeOut("slow");
                                    }
                                );
                            });
                        }
                    }else{
                        $(".message").removeClass('success').addClass('error');
                        $(".message").empty().html(ERROR_WHILE_PROCESSING);
                        $(".message").stop().fadeIn("slow", function(){
                            $('html,body').animate({
                                    scrollTop: $(".message").offset().top - 100},
                                'slow'
                            );
                        });
                    }
                }
            });
        }
    });
}
/*end validator*/


/*news_contact*/
$(function(){
  $('.bxslider2').bxSlider({
    infiniteLoop:false,
    hideControlOnEnd:true,
    captions:true
  })
})
/*end news_contact*/

/*products_contact*/
$('.products_contact_page ul li').click(function(){
  $('.products_contact_page ul li').removeClass('products_contact_page_arrd');
  $(this).addClass('products_contact_page_arrd');
})
$(function(){
  $('.bxslider3').bxSlider({
    infiniteLoop:false,
    hideControlOnEnd:true
  })
})
/*endproducts_contact*/

/*products_contact tab*/
$('.products_contact_page ul li').click(function(){
  var $pLi=$(this).index();
  var $pDiv=$('#products_contact_next_container div.products_contact_next');
  for(var i=0;i<$pDiv.length;i++){
    $($pDiv[i]).addClass('chosetab_product');
  }
  $($pDiv[$pLi]).removeClass('chosetab_product').addClass('choselive');
})
/*end products_contact tab*/

/*unlist*/
$('#sbHolder_19007767').toggler(function(){
  $('#sbOptions_19007767').show();
},function(){
  $('#sbOptions_19007767').hide();
})
$('body').click(function(){
  $('#sbOptions_19007767').hide();
  $('#sbOptions_86803563').hide();
})
$("#sbHolder_86803563").toggler(function(){
  $('#sbOptions_86803563').show();
},function(){
  $('#sbOptions_86803563').hide();
})
/*end list*/


/*select lang*/
    window.onload=function(){
  var oflink = document.getElementById('sel');
  var aDt = oflink.getElementsByTagName('dt');
  var aUl = oflink.getElementsByTagName('ul');
  var aH3= oflink.getElementsByTagName('h3');
  for(var i=0;i<aDt.length;i++){
      aDt[i].index = i;
      aDt[i].onclick = function(ev){
          var ev = ev || window.event;
          var This = this;
          for(var i=0;i<aUl.length;i++){
              aUl[i].style.display = 'none';
          }
          aUl[this.index].style.display = 'block';
          document.onclick = function(){
              aUl[This.index].style.display = 'none';
          };
          ev.cancelBubble = true;
      };
  }
  for(var i=0;i<aUl.length;i++){
      aUl[i].index = i;
      (function(ul){
          var iLi = ul.getElementsByTagName('li');
          for(var i=0;i<iLi.length;i++){
              iLi[i].onmouseover = function(){
                  this.className = 'hover';
              };
              iLi[i].onmouseout = function(){
                  this.className = '';
              };
              iLi[i].onclick = function(ev){
                  var ev = ev || window.event;
                  aH3[this.parentNode.index].innerHTML = this.innerHTML;
                  ev.cancelBubble = true;
                  this.parentNode.style.display = 'none';
                  if(this.innerHTML=="ENGLISH"){location.href = "http://www.tecno-mobile.com/en";}
                  else if(this.innerHTML=="FRENCH"){location.href = "http://www.tecno-mobile.com/fr";}
                  else{location.href = "http://www.tecno-mobile.com/en";}
              };
          }
      })(aUl[i]);
  }
}
/*end select lang*/

})
