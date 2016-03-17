var isFb = false;
var appId = "";
var shareUrl = "";
var sharePic = "";
var isPlayed = false;

$(document).ready(function()
{
	isFb = ($("#isFb").val() == 1) ? true : false;
	appId = $("#appId").val();
	shareUrl = $("#shareUrl").val();
	sharePic = $("#sharePic").val();
	isPlayed = ($("#isPlayed").val() == 1) ? true : false;
	
	$('span.submit').on('click', onClickSubmit);
	$('a.shfb').click(onClickShare);
	$('span.quotes ul li').on('click', onClickItem);
	
	if (isPlayed)
	{
		$('.main').removeClass('show-wrapper').addClass('item-wrapper');
		$('.thx').removeClass('item-wrapper').addClass('show-wrapper');
	}
	
	if (isFb)
	{
		window.fbAsyncInit = function()
		{
			FB.init({
				appId: appId,
				status: true,
				cookie: true,
				xfbml: true
			});
		};

		(function(d, s, id)
		{
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	}
});

function onClickSubmit(e)
{
	//submit
	var sum=0;
	var submit='';
	$('.quotes').each(function(){
	var _this=$(this);
	if(_this.attr('choice')){
	  sum=sum+1;
	  if(submit!==''){submit+=","}
	  var strArr=_this.attr('choice').split(':');
	  submit+='"'+strArr[0]+'"'+':'+'"'+strArr[1]+'"';
	}
	})
	submit="{"+submit;
	submit+="}";
	
	if(sum==10){
		var cho=JSON.parse(submit);
		$.post("?a=doAnswer", cho, onSubmit);
	}else{
		alert('How Much Do You Know About Infinix?');
	}
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
		alert("Unknown Erorr!");
		return;
	}
	
	if (0 == res.code)
	{
		$('.main').removeClass('show-wrapper').addClass('item-wrapper');
		$('.thx').removeClass('item-wrapper').addClass('show-wrapper');
	}
	else
	{
		alert(res.msg);
	}
}

function onClickShare(e)
{
	feed(shareUrl, sharePic);
}

function onClickItem(e)
{
	if($(window).width()>720){
	$(this).siblings('li').css('color','#666');
	$(this).css('color','#da3535');
	}else{
	$(this).siblings('li').css('background','#f1f1f1');
	$(this).siblings('li').css('color','#666');
	$(this).css('color','#fff');
	$(this).css('background','#ff9600')
	}

	var start_ptn = /<\/?[^>]*>/g;      //过滤标签开头
	var end_ptn = /[ | ]*\n/g;          //过滤标签结束
	var space_ptn = /&nbsp;/ig;         //过滤标签结尾
	//	var c1 = c.replace(start_ptn,"").replace(end_ptn).replace(space_ptn,"");
	var c2='';
	var choose='';
	  choose=''+$(this).parent().prev().find('i.quo').html().replace(space_ptn,"")+$(this).index();
	  $(this).parent().parent().attr("choice",choose);
}

function login()
{
	FB.login(function(response){ location.href = "./?a=main"; });
}

function feed(link, picture)
{
	if (!isFb)
	{
		window.open(link);
		return;
	}
	FB.ui(
	{
		method: 'feed',
		name: 'About Infinix',
		link: link,
		picture: picture,
		caption: 'www.infinixmobility.com',
		description: 'How Much Do You Know About Infinix?'
	},
	function(response) {
		//alert("Succeed!");
	});
}

function invite()
{
	FB.ui({method: 'apprequests',
	  message: 'Infinix'
	}, function (response){});
}

function addPage(redirect_uri)
{
	FB.ui({
	  method: 'pagetab',
	  redirect_uri: redirect_uri
	}, function(response){});
}
