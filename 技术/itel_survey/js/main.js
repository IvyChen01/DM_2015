var q1 = 0;
var q2 = 0;
var q3 = 0;
var q4 = 0;
var q5 = 0;
var q6 = 0;
var q7 = 0;
var q4f = "";
var q5f = "";
var q6f = "";

$(document).ready(function()
{
	$(".q1").click(onClickQ1);
	$(".q2").click(onClickQ2);
	$(".q3").click(onClickQ3);
	$(".q4").click(onClickQ4);
	$(".q5").click(onClickQ5);
	$(".q6").click(onClickQ6);
	$(".q7").click(onClickQ7);
	$(".submit").click(onClickSubmit);
});

function onClickQ1(e)
{
	var index = $(".q1").index(this);
	
	$(".q1").removeClass("select");
	$(".q1").eq(index).addClass("select");
	q1 = index + 1;
}

function onClickQ2(e)
{
	var index = $(".q2").index(this);
	
	$(".q2").removeClass("select");
	$(".q2").eq(index).addClass("select");
	q2 = index + 1;
}

function onClickQ3(e)
{
	var index = $(".q3").index(this);
	
	$(".q3").removeClass("select");
	$(".q3").eq(index).addClass("select");
	q3 = index + 1;
}

function onClickQ4(e)
{
	var index = $(".q4").index(this);
	
	$(".q4").removeClass("select");
	$(".q4").eq(index).addClass("select");
	q4 = index + 1;
}

function onClickQ5(e)
{
	var index = $(".q5").index(this);
	
	$(".q5").removeClass("select");
	$(".q5").eq(index).addClass("select");
	q5 = index + 1;
}

function onClickQ6(e)
{
	var index = $(".q6").index(this);
	
	$(".q6").removeClass("select");
	$(".q6").eq(index).addClass("select");
	q6 = index + 1;
}

function onClickQ7(e)
{
	var index = $(".q7").index(this);
	
	$(".q7").removeClass("select");
	$(".q7").eq(index).addClass("select");
	q7 = index + 1;
}

function onClickSubmit(e)
{
	if (q1 == 0)
	{
		alert("No.1 can not be empty!");
		return;
	}
	if (q2 == 0)
	{
		alert("No.2 can not be empty!");
		return;
	}
	if (q3 == 0)
	{
		alert("No.3 can not be empty!");
		return;
	}
	if (q4 == 0)
	{
		alert("No.4 can not be empty!");
		return;
	}
	if (q5 == 0)
	{
		alert("No.5 can not be empty!");
		return;
	}
	if (q6 == 0)
	{
		alert("No.6 can not be empty!");
		return;
	}
	if (q7 == 0)
	{
		alert("No.7 can not be empty!");
		return;
	}
	q4f = $("#q4f").val();
	q5f = $("#q5f").val();
	q6f = $("#q6f").val();
	$.post("?a=doAnswer", {q1: q1, q2: q2, q3: q3, q4: q4, q5: q5, q6: q6, q7: q7, q4f: q4f, q5f: q5f, q6f: q6f}, onSubmit);
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
		location.href = "?a=lucky";
	}
	else
	{
		alert(res.msg);
	}
}
