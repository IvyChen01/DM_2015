var isLock = false;
var  answers_cookie = {};

function thisMovie(movieName)
{
	if (navigator.appName.indexOf("Microsoft") != -1)
	{
		return window[movieName + "_ie"];
	}
	else
	{
		return document[movieName + "_ff"];
	}
}

$(function()
{
    var hasSelected  = !getCookie('erp_answers') ? {} : $.parseJSON(getCookie('erp_answers'));
    $(".question-item").each(function(){
        if(hasSelected.length ==0) return;
        var item = $(this);
        if($(this).attr('multiselect') != 0){
            $.each(hasSelected[$(this).index()],function(i,v){
                item.find("li").eq(v).addClass('selected');
            })
        }
        else{
            item.find("li").eq(hasSelected[$(this).index()]).addClass('selected')
        }
    })

	$(".question-content li").click(function()
	{
		if (isLock)
		{
			return;
		}
		
		var item = $(this).parents(".question-item");
        var multiSelect = item.attr("multiSelect");
		
		if (multiSelect == 0)
		{
			//单选
			item.find("li").each(function()
			{
				$(this).removeClass("selected");
			});
			$(this).addClass("selected");
		}
		else
		{
			//多选
			if($(this).hasClass("selected"))
			{
				$(this).removeClass("selected");
			}
			else
			{
				$(this).addClass("selected");
			}
		}

        var qId = $(this).closest(".question-item").index(),
            answerId = $(this).index();
        answers_cookie = !getCookie('erp_answers') ? {} : $.parseJSON(getCookie('erp_answers'));
        if($(this).closest(".question-item").attr("multiselect") != 0){
            if(!answers_cookie[qId].length){
                answers_cookie[qId][0] = answerId;
            }
            else{
                for(var i = 0;i<answers_cookie[qId].length;i++){
                    if(answers_cookie[qId][i] == answerId) return;
                    else answers_cookie[qId].push(answerId);
                }
            }
        }
        else
        {
            answers_cookie[qId] = answerId;
        }
        setCookie('erp_answers',JSON.stringify(answers_cookie),1);
    });
	
    $(".submit-answer a").click(function()
	{
		if (isLock)
		{
			return;
		}
		
		var q1 = "";
		var q2 = "";
		var q3 = "";
		var q4 = "";
		var q1Arr = [];
		var q2Arr = [];
		var q3Arr = [];
		var q4Arr = [];
		var list = $(".question-item");
		var index = 0;
		var qIndex = 1;
		var itemIndex = 0;
		
		list.find("li").each(function()
		{
			if($(this).hasClass("selected"))
			{
				qIndex = Math.floor(index / 4) + 1;
				itemIndex = index % 4 + 1;
				switch (qIndex)
				{
					case 1:
						q1Arr.push(itemIndex);
						break;
					case 2:
						q2Arr.push(itemIndex);
						break;
					case 3:
						q3Arr.push(itemIndex);
						break;
					case 4:
						q4Arr.push(itemIndex);
						break;
					default:
				}
			}
			index++;
		});
		
		q1 = q1Arr.join(",");
		q2 = q2Arr.join(",");
		q3 = q3Arr.join(",");
		q4 = q4Arr.join(",");
		
		if (q1 == "")
		{
			alert("第1题没答！");
		}
		else if (q2 == "")
		{
			alert("第2题没答！");
		}
		else if (q3 == "")
		{
			alert("第3题没答！");
		}
		else if (q4 == "")
		{
			alert("第4题没答！");
		}
		else
		{
			isLock = true;
			$.post("?m=faq&a=check_answer", {answer: '{"p1":"' + q1 + '","p2":"' + q2 + '","p3":"' + q3 + '","p4":"' + q4 + '"}'}, onChange);
		}
    });
});

function onChange(value)
{
	var res = null;
	var answer = null;
	var luckyCode = 0;
	var newCode = 0;
	
	if (value.substr(0, 1) != "{")
	{
		alert("未知错误，请刷新重试！");
		return;
	}
	
	res = $.parseJSON(value);
	switch (res.code)
	{
		case 0:
			answer = res.ansewr;
			switch (answer.code)
			{
				case 0:
					window.scrollTo(0,190);
					$(".question-result:eq(0)").addClass("right");
					$(".question-result:eq(1)").addClass("right");
					$(".question-result:eq(2)").addClass("right");
					$(".question-result:eq(3)").addClass("right");
					luckyCode = res.lucky_code;
					turntable(luckyCode);
					try
					{
						thisMovie("luckySwf").runTo(luckyCode);
					}
					catch (e)
					{
					}
					break;
				case 1:
					if (answer.q1 == 1)
					{
						$(".question-result:eq(0)").addClass("right");
					}
					else
					{
						$(".question-result:eq(0)").addClass("wrong");
					}
					
					if (answer.q2 == 1)
					{
						$(".question-result:eq(1)").addClass("right");
					}
					else
					{
						$(".question-result:eq(1)").addClass("wrong");
					}
					
					if (answer.q3 == 1)
					{
						$(".question-result:eq(2)").addClass("right");
					}
					else
					{
						$(".question-result:eq(2)").addClass("wrong");
					}
					
					if (answer.q4 == 1)
					{
						$(".question-result:eq(3)").addClass("right");
					}
					else
					{
						$(".question-result:eq(3)").addClass("wrong");
					}
                    $(".fail-today").show();
					break;
				case 2:
					alert("未知错误，请刷新重试！");
					break;
				default:
					alert("未知错误，请刷新重试！");
			}
			break;
		default:
			alert(res.info);
	}
}
