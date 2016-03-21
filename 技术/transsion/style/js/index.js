/**
 * Created by rrr on 14-4-22.
 */
$(function () {
    $("#banner").bind({
        mouseover:function(e){
            $(".slider-btn a").fadeIn();
        },
        mouseleave:function(e){
            $(".slider-btn a").fadeOut();
        }
    });
    var clientWidth = $("body").width();

    function banner_turn(index, callback) {
        var scrollLeft = $("#slider").get(0).scrollLeft, turnLeft;
        turnLeft = index == undefined ? scrollLeft + clientWidth : index * clientWidth;
        if (index == undefined) {
            if (scrollLeft < clientWidth * 3) {
                $("#slider").stop().animate({"scrollLeft": turnLeft}, 600);
            }
            else {
                $("#slider").stop().animate({"scrollLeft": 0}, 600);
            }
        }
        else {
            $("#slider").stop().animate({"scrollLeft": turnLeft}, 600, callback);
        }

    }

    var banner_index = 0, barTimer, bannerTimer;

    function bar_turn(index) {
        var index = index == undefined ? banner_index : index, barArr = $(".slider-bar li");
        banner_index = index;
        if (index < 3) {
            barArr.eq(index).find(".d-bar").stop().animate({"width": "110px"}, 10000, "linear", function () {
                barArr.eq(index).find(".c-bar").width(0);
                barArr.eq(index).find(".d-bar").width(0);
            });
            barArr.eq(index + 1).find(".c-bar").stop().animate({"width": "110px"}, 10000, "linear");
            banner_index++;
        }
        else {
            barArr.eq(index).find(".d-bar").stop().animate({"width": "110px"}, 10000, "linear", function () {
                barArr.eq(index).find(".c-bar").width(0);
                barArr.eq(index).find(".d-bar").width(0);
            });
            barArr.eq(0).find(".c-bar").stop().animate({"width": "110px"}, 10000, "linear");
            banner_index = 0;
        }
    }

    function start(index) {
        bar_turn(index)
        barTimer = setInterval(bar_turn, 10600);
        bannerTimer = setInterval(banner_turn, 10600);
    }

    start();
    //bar click
    $(".slider-bar li").each(function () {
        $(this).click(function () {
            break_continue($(this).index())
        })
    })

    //pre  next
    $(".slider-btn .pre").click(function () {
        var index;
        switch (banner_index) {
            case 0:
                index = 2;
                break;
            case 1:
                index = 3;
                break;
            case 2:
                index = 0;
                break;
            case 3:
                index = 1;
                break;

        }
        break_continue(index);
    })
    $(".slider-btn .next").click(function () {break_continue(banner_index);})

    //break and continue
    function break_continue(index) {
        $(".slider-bar li").find(".c-bar,.d-bar").stop().width(0);
        $(".slider-bar li").eq(index).find(".d-bar").width(0);
        $(".slider-bar li").eq(index).find(".c-bar").width(110);
        if (barTimer) {
            clearInterval(bannerTimer);
            clearInterval(barTimer);
        }
        banner_turn(index, start(index));
    }

    $(".sup-join-con").mouseover(function () {
        $(this).find(".sj-slo").hide();
        $(this).find(".sj-read-more").fadeIn();
    }).mouseleave(function () {
        $(this).find(".sj-slo").show();
        $(this).find(".sj-read-more").fadeOut()
    })
})




