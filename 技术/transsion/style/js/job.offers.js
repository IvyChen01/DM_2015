/**
 * Created by rrr on 14-4-29.
 */
$(function(){
    $(".offers-cate-item").click(function(){
        var showIndex=$(".offers-cate-item").index($(this));
        $(".offers-cate-item").removeClass("cur").eq(showIndex).addClass("cur");
        $(".cate-det-item").removeClass("show").hide().eq(showIndex).fadeIn();
    })
})