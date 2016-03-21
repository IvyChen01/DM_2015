var q1 = 0;
var q3 = 0;
var q4 = 0;
var q6 = 0;
var qs1 = "";
var qs2 = "";
var qs4 = "";
var qs5 = "";
var isPlayed = false;
var isEmail = false;

$(document).ready(function()
{
	isPlayed = ($("#isPlayed").val() == 1) ? true : false;
	isEmail = ($("#isEmail").val() == 1) ? true : false;
	
	$('div.wercty section').removeClass('wshow').addClass('whide');
	$('.process-wrapper').removeClass('whide').addClass('wshow');
	if (isPlayed)
	{
		$('.process ul li').removeClass('sur');
		$($('.process ul li')[7]).addClass('sur');
		if($(window).width()<720){$('.process-tele').removeClass('whide').addClass('wshow').css('width', '12.5%');}
		$('div.wercty section.wer8').removeClass('whide').addClass('wshow');
		
		if (isEmail)
		{
			$('span.lev a.levbtn').hide();
		}
	}
	else
	{
		$('div.wercty section.wer1').removeClass('whide').addClass('wshow');
	}
	
	$('.wer ul li.squ').on('click',function(){
		$(this).addClass('quo').siblings().removeClass('quo');
	});
	$('.wer1start').click(onClickStart);
	$('div.lift a.ft').on('click', onClickNext);
	$('div.lift a.li').on('click', onClickPrev);
	$('span.lev a.levbtn').on('click', onClickSubmit);
});

function setAnswer(num, q, qs)
{
	switch (num)
	{
		case 2:
			q1 = q;
			qs1 = qs;
			break;
		case 3:
			qs2 = parseInt(qs);
			break;
		case 4:
			q3 = q;
			break;
		case 5:
			q4 = q;
			qs4 = qs;
			break;
		case 6:
			qs5 = parseInt(qs);
			break;
		case 7:
			q6 = q;
			break;
		default:
	}
}

function onAnswer(value)
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
		//
	}
	else
	{
		alert(res.msg);
	}
}

function onEmail(value)
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
		alert("Succeed! Good Luck!");
	}
	else
	{
		alert(res.msg);
	}
}

function debugAnswer()
{
	console.log("q1: " + q1 + ", q3: " + q3 + ", q4: " + q4 + ", q6: " + q6 + ", qs1: " + qs1 + ", qs2: " + qs2 + ", qs4: " + qs4 + ", qs5: " + qs5);
}

function checkEmail(str)
{
	var re = /^([a-za-z0-9]+[_|-|.]?)*[a-za-z0-9]+@([a-za-z0-9]+[_|-|.]?)*[a-za-z0-9]+.[a-za-z]{2,3}$/;
	
	return re.test(str);
}

function onClickPrev(e)
{
	var index = $('div.wercty section.wshow').index();
	var widths=12.5*index;
	var sw=widths.toString()+'%';
	
	$($('div.wercty section.wer')[index]).removeClass('wshow').addClass('whide');
	$($('div.wercty section.wer')[index-1]).removeClass('whide').addClass('wshow');
	$('.process ul li').removeClass('sur');
	$($('.process ul li')[index-2]).addClass('sur');
	$('.process-tele').css('width',sw);
	
	//回到第1页，隐藏翻页按钮
	if (index == 2)
	{
		$('div.lift').removeClass('wshow').addClass('whide');
	}
}

function onClickNext(e)
{
	var index = $('div.wercty section.wshow').index();
	var widths=12.5*index;
	var sw=widths.toString()+'%';
	var temp = "";
	var num = 0;
	var ainx=$($('div.wercty section.wer')[index]).find('ul li.quo').index().toString();
	
	if (index == 3 || index == 6)
	{
		temp = $($('div.wercty section.wer')[index]).find('input').val().toString();
		num = parseInt("0" + temp);
		if (num <= 0)
		{
			alert("Please enter the correct number!");
			$($('div.wercty section.wer')[index]).find('input').focus();
			return;
		}
	}
	
	if (index == 6)
	{
		fixMoney(q1);
	}
	
	$($('div.wercty section.wer')[index]).removeClass('wshow').addClass('whide');
	$($('div.wercty section.wer')[index+1]).removeClass('whide').addClass('wshow');
	$('.process ul li').removeClass('sur');
	$($('.process ul li')[index]).addClass('sur');
	$('.process-tele').css('width',sw);
	
	if (index == 4 || index == 7)
	{
		setAnswer(index, parseInt(ainx) + 1, "");
	}
	else
	{
		temp = $($('div.wercty section.wer')[index]).find('input').val().toString();
		setAnswer(index, parseInt(ainx) + 1, temp);
	}
	
	//答题完毕，进入感谢页，隐藏翻页按钮
	if (index == 7)
	{
		$('div.lift').removeClass('wshow').addClass('whide');
		$.post("?a=doAnswer", {q1: q1, q3: q3, q4: q4, q6: q6, qs1: qs1, qs2: qs2, qs4: qs4, qs5: qs5}, onAnswer);
	}
}

function onClickSubmit(e)
{
	var email = $('#address').val();
	
	if (checkEmail(email))
	{
		$('span.lev a.levbtn').hide();
		$.post("?a=setEmail", {email: email}, onEmail);
	}
	else
	{
		alert("Please enter the correct email!");
	}
}

function onClickStart(e)
{
	$('div.wercty section.wer1').removeClass('wshow').addClass('whide');
    $('div.wercty section.wer2').removeClass('whide').addClass('wshow');
    $('.lift').removeClass('whide').addClass('wshow');
    $('.process ul li').removeClass('sur');
    $($('.process ul li')[1]).addClass('sur');
    if($(window).width()<720){$('.process-tele').removeClass('whide').addClass('wshow').css('width','12.5%');}
}

function fixMoney(type)
{
	switch (type)
	{
		case 1:
			$("#money1").html("1. &nbsp;&nbsp; Below 12,000 NGN");
			$("#money2").html("2. &nbsp;&nbsp; 12000 – 16,000 NGN");
			$("#money3").html("3. &nbsp;&nbsp; 16,001 – 20,000 NGN");
			$("#money4").html("4. &nbsp;&nbsp; 20,000 – 30,000 NGN");
			$("#money5").html("5. &nbsp;&nbsp; 30,001 – 40,000 NGN");
			$("#money6").html("6. &nbsp;&nbsp; 40,001 – 60,000 NGN");
			$("#money7").html("7. &nbsp;&nbsp; Above 60,000 NGN");
			$("#money8").html("8. &nbsp;&nbsp; I don’t know");
			break;
		case 2:
			$("#money1").html("1. &nbsp;&nbsp; Below 6000 KES");
			$("#money2").html("2. &nbsp;&nbsp; 6001 – 8000 KES");
			$("#money3").html("3. &nbsp;&nbsp; 8001 – 10,000 KES");
			$("#money4").html("4. &nbsp;&nbsp; 10,001 – 15,000 KES");
			$("#money5").html("5. &nbsp;&nbsp; 15,001 – 20,000 KES");
			$("#money6").html("6. &nbsp;&nbsp; 20,001 – 30,000 KES");
			$("#money7").html("7. &nbsp;&nbsp; Above 30,000 KES");
			$("#money8").html("8. &nbsp;&nbsp; I don’t know");
			break;
		case 3:
			$("#money1").html("1. &nbsp;&nbsp; Below 500 EGP");
			$("#money2").html("2. &nbsp;&nbsp; 501 – 650 EGP");
			$("#money3").html("3. &nbsp;&nbsp; 651 – 800 EGP");
			$("#money4").html("4. &nbsp;&nbsp; 801 – 1200 EGP");
			$("#money5").html("5. &nbsp;&nbsp; 1201 – 1600 EGP");
			$("#money6").html("6. &nbsp;&nbsp; 1601 – 2500 EGP");
			$("#money7").html("7. &nbsp;&nbsp; Above 25,00 EGP");
			$("#money8").html("8. &nbsp;&nbsp; I don’t know");
			break;
		case 4:
			$("#money1").html("1. &nbsp;&nbsp; Below 120,000 TZS");
			$("#money2").html("2. &nbsp;&nbsp; 120,001 – 170,000 TZS");
			$("#money3").html("3. &nbsp;&nbsp; 170,001 – 200,000 TZS");
			$("#money4").html("4. &nbsp;&nbsp; 200,001 – 320,000 TZS");
			$("#money5").html("5. &nbsp;&nbsp; 320,001 – 420,000 TZS");
			$("#money6").html("6. &nbsp;&nbsp; 420,001 – 650,000 TZS");
			$("#money7").html("7. &nbsp;&nbsp; Above 650,000 TZS");
			$("#money8").html("8. &nbsp;&nbsp; I don’t know");
			break;
		default:
			$("#money1").html("1. &nbsp;&nbsp; Below 60 USD");
			$("#money2").html("2. &nbsp;&nbsp; 60 – 80 USD");
			$("#money3").html("3. &nbsp;&nbsp; 81 - 100 USD");
			$("#money4").html("4. &nbsp;&nbsp; 101 - 150 USD");
			$("#money5").html("5. &nbsp;&nbsp; 151 - 200 USD");
			$("#money6").html("6. &nbsp;&nbsp; 201 - 300 USD");
			$("#money7").html("7. &nbsp;&nbsp; Above 300 USD");
			$("#money8").html("8. &nbsp;&nbsp; I don’t know");
	}
}
