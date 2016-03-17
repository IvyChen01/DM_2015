/**
 * Created by rrr on 2015/3/9.
 */
var id = window.location.href.match(/userid=(\d+)$/)[1];

$(function(){
    $(".qt-ans li").click(function(){
        $(this).siblings("li").removeClass("dt-sled")
        $(this).addClass("dt-sled")
        $(".qt-mc .qt-nxt").addClass("active")
    })

    $(".st-mo").click(function(){
        $(".st-ho").removeClass("dt-sled")
        $(this).addClass("dt-sled")
        $(".dialog").css({"height":"500px","margin-top":"-250px;"});
        $(".st-cot").css("top","400px")
        $(".hqt-q").show()
    })
    $(".st-ho").click(function(){
        $(".hqt-q").hide()
        $(".st-mo").removeClass("dt-sled")
        $(this).addClass("dt-sled")
        $(".dialog").css({"height":"380px","margin-top":"-190px;"});
        $(".st-cot").css("top","290px")})

    $(".alt-bn").click(function(){
        var index = $(this).closest(".ans-tm").index();
        $(".qt-itm").removeClass("show");
        $(".qt-itm").eq(index).addClass("show");

        $(".dialog").fadeIn()
    })

    $(".st-cl").click(function(){$(".imf-dialog").fadeOut();})
    $(".st-vt").click(function(){
        $(".qt-box .qt-itm").each(function(k,v){
            if(k < 4) $(".ans-tm").eq(k).find(".ans-fn").text($(this).find(".dt-sled span").text())
            else if(k == 4) {
                $(".ans-tm").eq(k).find(".ans-fn").text($(this).find(".qtd-ms .dt-sled span").text());
                if($(this).find(".qtd-ms .dt-sled").index() == 1){
                    $(".ex-mm-ll").hide()
                }
                else if($(this).find(".qtd-ms .dt-sled").index() == 0){
                    $(".ans-tm").eq(k).find(".ex-mm-sd").text($(this).find(".hqt-q .dt-sled span").text());
                    $(".ex-mm-ll").show()
                }
            }
            else if(k == 5){
                $(".ans-tm").eq(k).find(".ans-ws textarea").val($(this).find("textarea").val());
            }
        })




        $(".imf-dialog").fadeOut();
    })
    bindUserInfo()

    $(".examine-submit a").bind({
        "click":function(){
            examine("/")
        }
    })

    $(".qt-ans textarea").focus(function(){
        var noteWords = 'Write here: Would you like to offer some constructive suggestions to help us improve our service?Would you like to offer some con structive suggestions to help us improve our service?'
        if($(this).val() == noteWords){
            $(this).val('')
        }
    }).blur(function(){
        var noteWords = 'Write here: Would you like to offer some constructive suggestions to help us improve our service?Would you like to offer some con structive suggestions to help us improve our service?'
        if(!$(this).val())
            $(this).val(noteWords)
    })
})
function bindQuestion(langId,ansArr){
    var questions = [],
        lang = ['EN','FR'],
        ansArr = ansArr || [1,0,2,1,[1,1],'hello,word',1];
    $.getJSON("/data/question.json",function(data){
        $.each(data,function(k,v){
            $.each(v,function(kk,vv){
                if(vv.lang == lang[langId]){
                    $(".ans-tm").eq(k).find(".ans-ff").text(vv.question[0].q)
                    if(k < 4){
                        $(".ans-tm").eq(k).find(".ans-fn").text(vv.question[0].a[ansArr[k]-1])
                        $(".qt-box .qt-itm").eq(k).find(".qt-ans li").eq(ansArr[k]-1).addClass("dt-sled")
                    }
                    else if(k == 4){
                        $(".ans-tm").eq(k).find(".ans-fn").text(vv.question[0].a[ansArr[k][0]-1])
                        if(ansArr[k][0] == 1){
                            $(".ans-tm").eq(4).find(".alt-bn").css({"display":"block","margin-top":"15px"})
                            $(".ex-mm-sd").text(vv.question[0].ma[ansArr[k][1]])
                            $(".ex-mm-ll").show();
                        }
                        $(".qt-box .qt-itm").eq(k).find(".qtd-ms li").eq(ansArr[k][0]-1).addClass("dt-sled")
                        if(ansArr[k][0] == 1) {
                            $(".hqt-q").show().find("li").eq(ansArr[k][1]).addClass("dt-sled");

                        }
                    }
                    else if(k == 5){
                        $(".ans-tm").eq(k).find(".ans-ws textarea").val(ansArr[5]);
                        $(".qt-box .qt-itm").eq(k).find("textarea").val(ansArr[5]);
                        if(ansArr[6] == 0) return
                        else{
                            $(".dialog").css({"height":"500px","margin-top":"-250px;"});
                            $(".st-cot").css("top","400px")
                            $(".ans-tm").eq(k).find(".qt-ans li").eq(ansArr[6]-1).addClass("dt-sled")
                        }
                    }

                }
            })
        })
    })
}

function bindUserInfo(){
    var id = window.location.href.match(/userid=(\d+)$/)[1];
    $.ajax({
        url         :       '/?m=survey&a=getCustomer',
        type        :       'GET',
        data        :       {id:id},
        success     :       function(data){
            if(data.indexOf("{") != 0) {
                throw  new Error('Server error!');
                return;
            }

            var data = JSON.parse(data);
            var langId = data.data.language ||0,
                ansArr = [
                    ~~data.data.q1,
                    ~~data.data.q2,
                    ~~data.data.q3,
                    ~~data.data.q4,
                    [~~data.data.q5,~~data.data.q5_2],
                    data.data.q6,
                    ~~data.data.q7
                ];
            bindQuestion(langId,ansArr)
            $(".pi-tb tbody tr:eq(0) td").eq(0).text(data.data.country)
            $(".pi-tb tbody tr:eq(0) td").eq(1).text(data.data.wo_number)
            $(".pi-tb tbody tr:eq(0) td").eq(2).text(data.data.customer_name)
            $(".pi-tb tbody tr:eq(0) td").eq(3).text(data.data.phone)
            $(".pi-tb tbody tr:eq(0) td").eq(4).text(data.data.model)


        },
        timeout     :       3000,
        error       :       function(){
            throw  new Error('Server error!');
        }

    })

}
function examine(href){
    var typeEx = $(".ex-in li.dt-sled").index();
    if(typeEx == -1){
        alert("Classification can not be empty!");
        return;
    }
    var answers = [];
    $(".qt-itm").each(function(k,v){
        if(k < 4){
            answers[k] = $(this).find("li.dt-sled").index();
            answers[k] = answers[k] != -1 ? answers[k] +1 : 0;
        }
        else if(k == 4){
            answers[k] = [];
            answers[k][0] = $(this).find(".qtd-ms li.dt-sled").index();
            answers[k][0] = answers[k][0] != -1 ? answers[k][0] + 1 : 0;
            answers[k][1] = $(this).find(".hqt-q li.dt-sled").index();
            answers[k][1] = answers[k][1] != -1 ? answers[k][1] + 1 : 0;
        }
        else if(k == 5){
            answers[k] = $(this).find(".qt-ans textarea").val()
        }
    })
    answers[6] = typeEx + 1;
    $.ajax({
        url         :           '/?m=survey&a=changeForm',
        type        :           'POST',
        data        :           {id : id,q1:answers[0],q2:answers[1],q3:answers[2],q4:answers[3],q5:answers[4][0],q5_2:answers[4][1],q6:answers[5],q7 : answers[6]},
        success     :           function(data){
            window.setTimeout(function(){window.location.href = href;},2000)
        },
        timeout     :           3000,
        error       :           function(){
            throw  new Error('Server error!');
        }

    })
}