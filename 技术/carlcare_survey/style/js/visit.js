/**
 * Created by rrr on 2015/2/28.
 */
$(function(){
    var id = window.location.href.match(/userid=(\d+)$/)[1];

    $(".co-ul-selected").click(function () {
        $(this).siblings("ul").slideToggle(200);
    })
    $(".co-df-ul ul li").click(function () {
        $(this).closest(".co-df-ul").children(".co-ul-selected").children("span").text($(this).children("a").text()).attr("value",$(this).index()+1);
        $(this).closest("ul").slideUp(200)
    })
    $(".lt-vs .co-df-ul ul li").click(function () {
            $(".cur-dial-nb").text(4 - ~~$(this).find("a").text())
    })
    $(".yes-st").click(function(){
         sliderRg($(this))
    })
    $(".lt-vs .st-th>li").eq(2).find(".yes-st").click(function(){
        if(!$(".lt-vs li").eq(3).find(".no-st").hasClass("cur")&&!$(this).hasClass("cur")){
            $(".qt-mc").show()
        }
        $(".lt-vs .st-th>li").eq(3).find(".yes-st").click(function(){
            sliderRg($(this))
            if(!$(".lt-vs li").eq(2).find(".no-st").hasClass("cur")&&!$(this).hasClass("cur")){
                $(".qt-mc").show()
            }
        })
        $(".lt-vs .st-th>li").eq(3).find(".no-st").bind({
            "click":function(){
                sliderRgNo($(this))
            }
        })
    })
    $(".lt-vs .st-th>li").eq(2).find(".no-st").click(function(){
        $(".lt-vs .st-th>li").eq(3).find(".yes-st").unbind("click")
        $(".lt-vs .st-th>li").eq(3).find(".no-st").unbind("click")
    })
    $(".lt-vs .st-th>li").eq(3).find(".yes-st").click(function(){
        if(!$(".lt-vs li").eq(2).find(".no-st").hasClass("cur")&&!$(this).hasClass("cur")){
            $(".qt-mc").show()
        }
    })


    $(".no-st").click(function(){sliderRgNo($(this))})
    $(".imf-dialog .st-cot .st-cl").click(function(){$(".imf-dialog").fadeOut();})
    $(".mt2-dialog .st-cot .st-cl").click(function(){$(".mt2-dialog").fadeOut();})
    $(".imf-dialog .st-cot .st-vt").click(function(){
        submitTouch("/?m=survey&a=tovisit")
    })
    $(".mt2-dialog .st-cot .st-vt").click(function(){
        submitTouch("/?m=survey&a=question&userid=" + id)
    })
    $(".cot-as .at-a").click(function(){
        var curVal = Number($(".cot-as input[type = 'text']").val());
        $(".cot-as input[type = 'text']").val(curVal == 3 ? 3 : curVal + 1);
    })
    $(".cot-as .at-d").click(function(){
        var curVal = Number($(".cot-as input[type = 'text']").val());
        $(".cot-as input[type = 'text']").val(curVal == 0  ? 0 : curVal - 1) ;
    })
    $(".qt-nxt").click(function(){
        if(!$(".step-3 .yes-st").hasClass("cur") || !$(".step-4 .yes-st").hasClass("cur")) return;
        submitTouch("/?m=survey&a=question&userid=" + id)
    })
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
                $(".lt-vs .lt-ctn .co-ul-selected span").text(data.data.dial_number).attr("value",data.data.dial_number)
                $(".pi-tb tbody tr:eq(0) td").eq(0).text(data.data.country)
                $(".pi-tb tbody tr:eq(0) td").eq(1).text(data.data.wo_number)
                $(".pi-tb tbody tr:eq(0) td").eq(2).text(data.data.customer_name)
                $(".pi-tb tbody tr:eq(0) td").eq(3).text(data.data.phone)
                $(".pi-tb tbody tr:eq(0) td").eq(4).text(data.data.model)
                $(".cus-name").text(data.data.customer_name)
                $(".cur-dial-nb").text(4-data.data.dial_number)

            },
            timeout     :       3000,
            error       :       function(){
                throw  new Error('Server error!');
            }

        })

    }
    function submitTouch(href){
        var
            dial_number = $(".lt-ctn .co-ul-selected span").attr("value") || 0,
            ex_number = $(".lt-ceb .co-ul-selected span").attr("value") ||0,
            lang_number = $(".lt-lang .co-ul-selected span").attr("value") ||0,
            st_3 = (function(){
                if($(".step-3 .yes-st").hasClass("cur")) return 1
                else if($(".step-3 .no-st").hasClass("cur")) return 2;
                else return 0;
            })(),
            st_4 = (function(){
                if($(".step-4 .yes-st").hasClass("cur")) return 1
                else if($(".step-4 .no-st").hasClass("cur")) return 2;
                else return 0;
            })();

        $.ajax({
            url         :       '/?m=survey&a=dial',
            type        :       'POST',
            data        :        {id : id,dialNum : dial_number,feedback : ex_number,language : lang_number,isTakeBack : st_3,isAcceptInterview:st_4},
            success     :        function(data){
                if(data.indexOf("{") != 0) {
                    throw  new Error('Server error!');
                    return;
                }
                var data = JSON.parse(data);
                if(data.code == 0) {
                    window.location.href = href;
                }
                else{
                    throw  new Error('Server error!');
                }
            }
        })
    }
    function sliderRg(selector){
        var selector = selector;
        if(!$(this).hasClass("cur")){
            var that = selector;
            if(that.siblings(".vm-d").css("display") == 'none' || !selector.siblings(".vm-d").css("display")){
                selector.siblings(".vm-d").show();
                that.addClass("cur")
            }
            else{
                selector.siblings(".vm-d").animate({"left":0},200,function(){
                    that.addClass("cur").siblings(".no-st").removeClass("cur");
                })
            }

        }
        $(".imf-dialog").fadeOut();
    }
    function sliderRgNo(selector){
        var selector  = selector;
        if(!selector.hasClass("cur")){
            var that = selector;
            if(that.siblings(".vm-d").css("display") == 'none' || !selector.siblings(".vm-d").css("display")){
                selector.siblings(".vm-d").show().css("left",61);
                that.addClass("cur")
            }
            else{
                selector.siblings(".vm-d").animate({"left":61},200,function(){
                    that.addClass("cur").siblings(".yes-st").removeClass("cur");
                })
            }
        }
        $(".qt-mc").hide().unbind("click")
        if(selector.closest("li").hasClass("step-4")){
            $(".mt2-dialog").fadeIn()
        }
        else{
            $(".imf-dialog").fadeIn();

        }
    }

    bindUserInfo()

})