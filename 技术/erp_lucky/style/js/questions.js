/**
 * Created by rrr on 14-6-18.
 */
$(function(){
    $(".qu-type-title li").click(function(){
        if(!$(this).hasClass("show")){
            $(".qu-type-title li").removeClass("show");
            $(this).addClass("show");
            $(".qu-type").hide();
            $(".qu-type").eq($(this).index()).fadeIn();
        }
    })
})