/**
 * Created by rrr on 2015/3/2.
 */
var id = window.location.href.match(/userid=(\d+)$/)[1];

$(function(){


    $(".qt-ans li").click(function(){
        $(this).siblings("li").removeClass("dt-sled")
        $(this).addClass("dt-sled")
        $(".qt-mc .qt-nxt").addClass("active")
    })

    $(".qt-dit").click(function(){
        $(".dg-di").fadeIn();
        //$(".qt-nxt").unbind('click')
    })

    $(".qt-nxt").click(function(){
        var
            index = 0,
            length = $(".qt-box .qt-itm").length;
        $(".qt-box .qt-itm").each(function(){if($(this).hasClass("show")) index = $(this).index()})

        if(index != 4 && index != 5){
            if(!$(".qt-box .show .dt-sled").length) {
                $(".dg-ne").fadeIn();
                return false;
            }
        }
        if(index < length - 1) {
            $(".qt-box .qt-itm").eq(index).removeClass("show")
            $(".qt-box .qt-itm").eq(index + 1).addClass("show")
        }
        else {
            submitAnswers("/?m=survey&a=thankyou&userid=" + id)
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
    $(".dg-ne a").click(function(){$(".dg-ne").fadeOut();})

    $(".st-cl").click(function(){$(".imf-dialog").fadeOut();})

    $(".qtd-ms li").click(function(){
        if($(".qtd-ms li").hasClass("dt-sled")) $(".qtd-ms li").removeClass("dt-sled");
        $(this).addClass("dt-sled")
    })
    $(".st-mo").click(function(){$(".hqt-q").show()})
    $(".st-ho").click(function(){$(".hqt-q").hide()})

    //dropped

    $(".dg-di .st-vt").click(function(){
        var exId = $(".dg-di .qtd-ms .dt-sled").index();
        if(exId == -1){
            alert('You must select a reason for the disconnect');
            return;
        }
        exId += 1;
        dropped(exId,"/?m=survey&a=tovisit");
    })

    setTimeout(bindUserInfo,1);
})
function bindUserInfo(){
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
function submitAnswers(href){
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
    $.ajax({
        url         :           '/?m=survey&a=fillForm',
        type        :           'POST',
        data        :           {id : id,q1:answers[0],q2:answers[1],q3:answers[2],q4:answers[3],q5:answers[4][0],q5_2:answers[4][1],q6:answers[5]},
        success     :           function(data){
           window.setTimeout(function(){window.location.href = href;},2000)
        },
        timeout     :           3000,
        error       :           function(){
            throw  new Error('Server error!');
        }

    })
}
function dropped(exId,href){
    var exId = exId;
    $.ajax({
        url         :           '/?m=survey&a=drop',
        type        :           'POST',
        data        :           {id : id,exception : exId},
        success     :           function(data) {
            if(data.indexOf("{") != 0) {
                throw  new Error('Server error!');
                return;
            }

            var data = JSON.parse(data);
            if(data.code == 0){
                window.setTimeout(function(){window.location.href = href},3000)
            }
        }
    })
}





























































