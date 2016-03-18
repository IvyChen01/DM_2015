var q1 = "";
var q2 = "";
var q3 = "";
var q3_1 = false;
var q3_2 = false;
var q3_3 = false;
var q3_4 = false;
var qs3 = "";
var q4 = "";
var q5 = "";
var q6 = "";
var q7 = "";
var q8 = "";
var q9 = "";
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
		$($('.process ul li')[10]).addClass('sur');
		if($(window).width()<720){$('.process-tele').removeClass('whide').addClass('wshow').css('width', '9.09%');}
		$('div.wercty section.wer11').removeClass('whide').addClass('wshow');
		
		if (isEmail)
		{
			$('span.lev a.levbtn').hide();
		}
	}
	else
	{
		$('div.wercty section.wer1').removeClass('whide').addClass('wshow');
	}
	
	$('.wer ul li.squ').on('click', onClickOption);
	$('.wer1start').click(onClickStart);
	$('div.lift a.ft').on('click', onClickNext);
	$('div.lift a.li').on('click', onClickPrev);
	$('span.lev a.levbtn').on('click', onClickSubmit);
	$("#chk1").click(onClickChk1);
	$("#chk2").click(onClickChk2);
	$("#chk3").click(onClickChk3);
	$("#chk4").click(onClickChk4);
});

/*
 * index从2开始
 * 4多选
 * 4, 9, 10有填空
 */
function setAnswer(num, q, qs)
{
	switch (num)
	{
		case 2:
			q1 = q;
			break;
		case 3:
			q2 = q;
			break;
		case 4:
			q3 = "";
			if (q3_1)
			{
				q3 = "1";
			}
			if (q3_2)
			{
				if (q3 == "")
				{
					q3 = "2";
				}
				else
				{
					q3 += ",2";
				}
			}
			if (q3_3)
			{
				if (q3 == "")
				{
					q3 = "3";
				}
				else
				{
					q3 += ",3";
				}
			}
			if (q3_4)
			{
				if (q3 == "")
				{
					q3 = "4";
				}
				else
				{
					q3 += ",4";
				}
				qs3 = qs;
			}
			else
			{
				qs3 = "";
			}
			break;
		case 5:
			q4 = q;
			break;
		case 6:
			q5 = q;
			break;
		case 7:
			q6 = q;
			break;
		case 8:
			q7 = q;
			break;
		case 9:
			q8 = qs;
			break;
		case 10:
			q9 = qs;
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
	//console.log("q1: " + q1 + ", q2: " + q2 + ", q3: " + q3 + ", q3_1: " + q3_1 + ", q3_2: " + q3_2 + ", q3_3: " + q3_3 + ", q3_4: " + q3_4 + ", qs3: " + qs3 + ", q4: " + q4 + ", q5: " + q5 + ", q6: " + q6 + ", q7: " + q7 + ", q8: " + q8 + ", q9: " + q9);
}

function checkEmail(str)
{
	var re = /^([a-za-z0-9]+[_|-|.]?)*[a-za-z0-9]+@([a-za-z0-9]+[_|-|.]?)*[a-za-z0-9]+.[a-za-z]{2,3}$/;
	
	return re.test(str);
}

function onClickPrev(e)
{
	var index = $('div.wercty section.wshow').index();
	var widths=9.09*index;
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
	var widths=9.09*index;
	var sw=widths.toString()+'%';
	var temp = "";
	var num = 0;
	var ainx=$($('div.wercty section.wer')[index]).find('ul li.quo').index().toString();
	
	//$($('div.wercty section.wer')[index]).find('input').focus();
	//alert();
	
	$($('div.wercty section.wer')[index]).removeClass('wshow').addClass('whide');
	$($('div.wercty section.wer')[index+1]).removeClass('whide').addClass('wshow');
	$('.process ul li').removeClass('sur');
	$($('.process ul li')[index]).addClass('sur');
	$('.process-tele').css('width',sw);
	
	if (index == 4 || index == 9 || index == 10)
	{
		temp = $($('div.wercty section.wer')[index]).find('input').val().toString();
		setAnswer(index, parseInt(ainx) + 1, temp);
	}
	else
	{
		setAnswer(index, parseInt(ainx) + 1, "");
	}
	
	//////// debug
	//debugAnswer();
	
	//答题完毕，进入感谢页，隐藏翻页按钮
	if (index == 10)
	{
		$('div.lift').removeClass('wshow').addClass('whide');
		$.post("?a=doAnswer", {q1: q1, q2: q2, q3: q3, qs3: qs3, q4: q4, q5: q5, q6: q6, q7: q7, q8: q8, q9: q9}, onAnswer);
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
    if($(window).width()<720){$('.process-tele').removeClass('whide').addClass('wshow').css('width','9.09%');}
}

function onClickOption(e)
{
	$(this).addClass('quo').siblings().removeClass('quo');
}

function onClickChk1(e)
{
	q3_1 = !q3_1;
	if (q3_1)
	{
		$(this).addClass('quo');
	}
	else
	{
		$(this).removeClass('quo');
	}
}

function onClickChk2(e)
{
	q3_2 = !q3_2;
	if (q3_2)
	{
		$(this).addClass('quo');
	}
	else
	{
		$(this).removeClass('quo');
	}
}

function onClickChk3(e)
{
	q3_3 = !q3_3;
	if (q3_3)
	{
		$(this).addClass('quo');
	}
	else
	{
		$(this).removeClass('quo');
	}
}

function onClickChk4(e)
{
	q3_4 = !q3_4;
	if (q3_4)
	{
		$(this).addClass('quo');
	}
	else
	{
		$(this).removeClass('quo');
	}
}
