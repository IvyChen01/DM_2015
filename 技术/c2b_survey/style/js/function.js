/**
 * Created by rrr on 14-5-26.
 */
Array.prototype.search = function (v) {
    var result = [];
    if (v.constructor.toString() == Array) {
        for (i = 0; i < v.length; i++) {
            for (j = 0; j < this.length; j++) {
                if (this[j].toString() == v[i].toString()) {
                    result.push(j);
                }
            }
        }
    }
    else if (v.constructor.toString() == String || v.constructor.toString() == Number) {
        for (j in this) {
            if (this[j] == v) {
                result.push(j);
            }
        }
    }
    if (result) return result;
    else return -1;
}
function getSelectOption_single() {
    var sled = [];
    $(".q-list li").each(function () {
        if ($(this).find("label").attr("isSed") == "true") {
            sled.push($(this).find("label").attr("o_index"));
            return;
        }
    })
    return sled;
}
function getSelectOption_multi() {
    var sled = [];
    $(".q-list li").each(function () {
        if ($(this).find("label").attr("isSed") == "true") {
            sled.push($(this).find("label").attr("o_index"));
        }
    })
    return sled;
}
function getSelection_options(questionId) {
    var answers, result=[];
    if ($.cookie("C2B_questions_answer") != undefined && $.cookie("C2B_questions_answer") != "null") {
        answers = JSON.parse($.cookie("C2B_questions_answer"));
    }
    if (answers) {
        for (i=0;i<answers.length;i++) {
            if (answers[i].id == parseInt(questionId)+1) result = answers[i].answer;
        }
    }
   return result;
}
function nextIndex_q1() {
    var q1_selection = getSelection_options(0);
    if (q1_selection.length == 0) {
        return -3;
    }
    else if (q1_selection.search(4).length > 0) {
        send_survey();
        return -5;
    }
    else {
        return 1;
    }
}
function nextIndex_q2() {
    var q1_selection = getSelection_options(0);
    var q2_selection = getSelection_options(1);
    var nextIndex;
    if (q2_selection.length == 0) nextIndex = -3;
    else{
            if ([0, 1, 2].search(q1_selection).length > 0) {
                nextIndex = 2;
            }
            else {
                nextIndex = 12;
            }
    }
    if (nextIndex) return nextIndex;
    else return -1;
}
function nextIndex_q3() {
    var q3_selection = getSelection_options(2);
    var q1_selection = getSelection_options(0);
    var nextIndex;
    if (q3_selection.length == 0) nextIndex = -3;
    else if (q3_selection.length > 3) {
        nextIndex = 3;
    }
    else {
        if ([0, 1].search(q1_selection).length == 0) {
            nextIndex = 12;
        }
        else {
            if (q3_selection.search(3).length > 0) nextIndex = 4;
            else {
                if (q3_selection.search(4).length > 0)  nextIndex = 5;
                else {
                    if (q3_selection.search(5).length > 0) nextIndex = 6;
                    else {
                        if (q3_selection.search(6).length > 0) nextIndex = 7;
                        else {
                            if (q3_selection.search(7).length > 0) nextIndex = 8;
                            else {
                                if (q3_selection.search(9).length > 0) nextIndex = 9;
                                else {
                                    if (q3_selection.search(10).length > 0) nextIndex = 10;
                                    else {
                                        if (q3_selection.search(14).length > 0) nextIndex = 11;
                                        else {
                                            nextIndex = 12;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if (nextIndex) return nextIndex;
    else -1;
}
//第四题
function nextIndex_q4() {
    var q4_selection = getSelection_options(3);
    var q1_selection = getSelection_options(0);
    var nextIndex;
    if (q4_selection.length == 0) {
        nextIndex = -3;
    }
    else{
        if(q4_selection.length>3){
            nextIndex=-4;
        }
        else {
            if ([0, 1].search(q1_selection).length== 0) {
                nextIndex = 12;
            }
            else {
                if (q4_selection.search(3).length > 0) nextIndex = 4;
                else {
                    if (q4_selection.search(4).length > 0)  nextIndex = 5;
                    else {
                        if (q4_selection.search(5).length > 0) nextIndex = 6;
                        else {
                            if (q4_selection.search(6).length > 0) nextIndex = 7;
                            else {
                                if (q4_selection.search(7).length > 0) nextIndex = 8;
                                else {
                                    if (q4_selection.search(9).length > 0) nextIndex = 9;
                                    else {
                                        if (q4_selection.search(10).length > 0) nextIndex = 10;
                                        else {
                                            if (q4_selection.search(14).length > 0) nextIndex = 11;
                                            else {
                                                nextIndex = 12;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if (nextIndex) return nextIndex;
    else return -1;
}
//第五题
function nextIndex_q5() {
    var q3_selection = getSelection_options(2);
    var q4_selection = getSelection_options(3);
    var q5_selection = getSelection_options(4);
    var nextIndex;
    if(q5_selection.length==0){
        nextIndex=-3;
    }
    else{
        if (q4_selection == -1) {
            if (q3_selection.search(4).length > 0)  nextIndex = 5;
            else {
                if (q3_selection.search(5).length > 0) nextIndex = 6;
                else {
                    if (q3_selection.search(6).length > 0) nextIndex = 7;
                    else {
                        if (q3_selection.search(7).length > 0) nextIndex = 8;
                        else {
                            if (q3_selection.search(9).length > 0) nextIndex = 9;
                            else {
                                if (q3_selection.search(10).length > 0) nextIndex = 10;
                                else {
                                    if (q3_selection.search(14).length > 0) nextIndex = 11;
                                    else {
                                        nextIndex = 12;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        else {
            if (q4_selection.search(4).length > 0)  nextIndex = 5;
            else {
                if (q4_selection.search(5).length > 0) nextIndex = 6;
                else {
                    if (q4_selection.search(6).length > 0) nextIndex = 7;
                    else {
                        if (q4_selection.search(7).length > 0) nextIndex = 8;
                        else {
                            if (q4_selection.search(9).length > 0) nextIndex = 9;
                            else {
                                if (q4_selection.search(10).length > 0) nextIndex = 10;
                                else {
                                    if (q4_selection.search(14).length > 0) nextIndex = 11;
                                    else {
                                        nextIndex = 12;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if (nextIndex) return nextIndex;
    else return -1;
}
//第六题
function nextIndex_q6() {
    var q3_selection = getSelection_options(2);
    var q4_selection = getSelection_options(3);
    var q6_selection = getSelection_options(5);
    var nextIndex;
   if(q6_selection.length==0){
       nextIndex=-3;
   }
    else{
       if (q4_selection == -1) {
           if (q3_selection.search(5).length > 0) nextIndex = 6;
           else {
               if (q3_selection.search(6).length > 0) nextIndex = 7;
               else {
                   if (q3_selection.search(7).length > 0) nextIndex = 8;
                   else {
                       if (q3_selection.search(9).length > 0) nextIndex = 9;
                       else {
                           if (q3_selection.search(10).length > 0) nextIndex = 10;
                           else {
                               if (q3_selection.search(14).length > 0) nextIndex = 11;
                               else {
                                   nextIndex = 12;
                               }
                           }
                       }
                   }
               }
           }
       }
       else {
           if (q4_selection.search(5).length > 0) nextIndex = 6;
           else {
               if (q4_selection.search(6).length > 0) nextIndex = 7;
               else {
                   if (q4_selection.search(7).length > 0) nextIndex = 8;
                   else {
                       if (q4_selection.search(9).length > 0) nextIndex = 9;
                       else {
                           if (q4_selection.search(10).length > 0) nextIndex = 10;
                           else {
                               if (q4_selection.search(14).length > 0) nextIndex = 11;
                               else {
                                   nextIndex = 12;
                               }
                           }
                       }
                   }
               }
           }
       }
   }
    if (nextIndex) return nextIndex;
    else return -1;
}
//第七题
function nextIndex_q7() {
    var q3_selection = getSelection_options(2);
    var q4_selection = getSelection_options(3);
    var q7_selection = getSelection_options(6);
    var nextIndex;

    if(q7_selection.length==0){
        nextIndex=-1;
    }
    else{
        if (q4_selection == -1) {
            if (q3_selection.search(6).length > 0) nextIndex = 7;
            else {
                if (q3_selection.search(7).length > 0) nextIndex = 8;
                else {
                    if (q3_selection.search(9).length > 0) nextIndex = 9;
                    else {
                        if (q3_selection.search(10).length > 0) nextIndex = 10;
                        else {
                            if (q3_selection.search(14).length > 0) nextIndex = 11;
                            else {
                                nextIndex = 12;
                            }
                        }
                    }
                }
            }
        }
        else {
            if (q4_selection.search(6).length > 0) nextIndex = 7;
            else {
                if (q4_selection.search(7).length > 0) nextIndex = 8;
                else {
                    if (q4_selection.search(9).length > 0) nextIndex = 9;
                    else {
                        if (q4_selection.search(10).length > 0) nextIndex = 10;
                        else {
                            if (q4_selection.search(14).length > 0) nextIndex = 11;
                            else {
                                nextIndex = 12;
                            }
                        }
                    }
                }
            }
        }
    }
    if (nextIndex) return nextIndex;
    else return -1;
}
//第八题
function nextIndex_q8() {
    var q3_selection = getSelection_options(2);
    var q4_selection = getSelection_options(3);
    var q8_selection = getSelection_options(7);
    var nextIndex;
    if(q8_selection.length==0){
        nextIndex=-3;
    }
    else{
        if (q4_selection == -1) {
            if (q3_selection.search(7).length > 0) nextIndex = 8;
            else {
                if (q3_selection.search(9).length > 0) nextIndex = 9;
                else {
                    if (q3_selection.search(10).length > 0) nextIndex = 10;
                    else {
                        if (q3_selection.search(14).length > 0) nextIndex = 11;
                        else {
                            nextIndex = 12;
                        }
                    }
                }
            }
        }
        else {
            if (q4_selection.search(7).length > 0) nextIndex = 8;
            else {
                if (q4_selection.search(9).length > 0) nextIndex = 9;
                else {
                    if (q4_selection.search(10).length > 0) nextIndex = 10;
                    else {
                        if (q4_selection.search(14).length > 0) nextIndex = 11;
                        else {
                            nextIndex = 12;
                        }
                    }
                }
            }
        }
    }
    if (nextIndex) return nextIndex;
    else return -1;
}
//第九题
function nextIndex_q9() {
    var q3_selection = getSelection_options(2);
    var q4_selection = getSelection_options(3);
    var q9_selection = getSelection_options(8);
    var nextIndex;
    if(q9_selection.length==0){
        nextIndex=-3;
    }
    else{
        if (q4_selection == -1) {
            if (q3_selection.search(9).length > 0) nextIndex = 9;
            else {
                if (q3_selection.search(10).length > 0) nextIndex = 10;
                else {
                    if (q3_selection.search(14).length > 0) nextIndex = 11;
                    else {
                        nextIndex = 12;
                    }
                }
            }
        }
        else {
            if (q4_selection.search(9).length > 0) nextIndex = 9;
            else {
                if (q4_selection.search(10).length > 0) nextIndex = 10;
                else {
                    if (q4_selection.search(14).length > 0) nextIndex = 11;
                    else {
                        nextIndex = 12;
                    }
                }
            }
        }
    }

    if (nextIndex) return nextIndex;
    else return -1;
}
//第十题
function nextIndex_q10() {
    var q3_selection = getSelection_options(2);
    var q4_selection = getSelection_options(3);
    var q10_selection = getSelection_options(9);
    var nextIndex;
    if(q10_selection.length==0){
        nextIndex=-3;
    }
    else{
        if (q4_selection == -1) {
            if (q3_selection.search(10).length > 0) nextIndex = 10;
            else {
                if (q3_selection.search(14).length > 0) nextIndex = 11;
                else {
                    nextIndex = 12;
                }
            }
        }
        else {
            if (q4_selection.search(10).length > 0) nextIndex = 10;
            else {
                if (q4_selection.search(14).length > 0) nextIndex = 11;
                else {
                    nextIndex = 12;
                }
            }
        }
    }
    if (nextIndex) return nextIndex;
    else return -1;
}
//第十一题
function nextIndex_q11() {
    var q3_selection = getSelection_options(2);
    var q4_selection = getSelection_options(3);
    var q11_selection = getSelection_options(10);
    var nextIndex;
    if(q11_selection.length==0){
        nextIndex=-3;
    }
    else{
        if (q4_selection == -1) {
            if (q3_selection.search(14).length > 0) nextIndex = 11;
            else {
                nextIndex = 12;
            }
        }
        else {
            if (q4_selection.search(14).length > 0) nextIndex = 11;
            else {
                nextIndex = 12;
            }
        }
    }
    if (nextIndex) return nextIndex;
    else return -1;
}
function nextIndex_q12() {
    var q12_selection = getSelection_options(11);
    if(q12_selection.length==0) return -3;
    else return 12;
}
function nextIndex_q13() {
    var nextIndex;
    var q13_selection = getSelection_options(12);
    if(q13_selection.length==0) nextIndex=-3;
    else if (q13_selection.search(0).length > 0) nextIndex = 13;
    else {
        nextIndex = 14;
    }
    if (nextIndex) return nextIndex;
    else return -1;
}
function nextIndex_q14() {
     return 14;
}
function nextIndex_q15() {
    var nextIndex;
    var q15_selection = getSelection_options(14);
    if(q15_selection.length==0) nextIndex=-3;
    else if (q15_selection.search(1).length > 0) {
        send_survey();
        nextIndex =-5;
    }
    else {
        nextIndex = 15;
    }
    if (nextIndex) return nextIndex;
    else return -1;
}
function nextIndex_q16() {
    var q15_selection = getSelection_options(15);
    if(q15_selection.length==0) return -3;
    else {
        send_survey();
        return -5;
    };
}

function saveAnswer(questionId, options) {
    var data;
    var customFill = $(".custom-fill").val() || ""
    if(customFill=="Please specify") customFill="";

    if ($.cookie("C2B_questions_answer") == undefined || $.cookie("C2B_questions_answer") == "null") {
        data = [];
    }
    else {
        data = JSON.parse($.cookie("C2B_questions_answer"))
    }
    var isset = false;
    if (data) {
        for (i in data) {
            if (data[i].id == parseInt(questionId)+1) {
                data[i].answer = options;
                data[i].fill = customFill;
                isset = true;
            }
        }
    }
    if (!isset) data.push({"id": parseInt(questionId)+1, "answer": options, "fill": customFill});
    $.cookie("C2B_questions_answer", JSON.stringify(data), { expires: 7 });
}
function onSubmit(value)
{
    var res = null;

    if (value.substr(0, 1) != "{")
    {
        alert("Unknown Error！");
        return;
    }

    res = $.parseJSON(value);
    switch (res.code)
    {
        case 0:
            $(".shadow-panel").show();
            window.location.reload();
            break;
        default:
            alert(res.info);
    }
}

function send_survey(){
    $(".shadow-panel").hide();
    var result;
    if ($.cookie("C2B_questions_answer") == undefined || $.cookie("C2B_questions_answer") == "null") {
        result = "";
    }
    else {
        result =$.cookie("C2B_questions_answer") ;
    }
    if(result) {
        $.post("?m=faq&a=answer", {data: JSON.stringify(JSON.parse(result))}, onSubmit);
    }
    else{
        alert("Unknown Error！");
    }

}

function getNextIndex(curQuestionIndex) {
    switch (curQuestionIndex.toString()) {
        case "1":
            return nextIndex_q1();
            break;
        case "2":
            return nextIndex_q2();
            break;
        case "3":
            return nextIndex_q3();
            break;
        case "4":
            return nextIndex_q4();
            break;
        case "5":
            return nextIndex_q5();
            break;
        case "6":
            return nextIndex_q6();
            break;
        case "7":
            return nextIndex_q7();
            break;
        case "8":
            return nextIndex_q8();
            break;
        case "9":
            return nextIndex_q9();
            break;
        case "10":
            return nextIndex_q10();
            break;
        case "11":
            return nextIndex_q11();
            break;
        case "12":
            return nextIndex_q12();
            break;
        case "13":
            return nextIndex_q13();
            break;
        case "14":
            return nextIndex_q14();
            break;
        case "15":
            return nextIndex_q15();
            break;
        case "16":
            return nextIndex_q16();
            break;

    }
}
