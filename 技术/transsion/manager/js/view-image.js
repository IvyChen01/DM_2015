/**
 * Created by rrr on 14-4-25.
 */
$(document).ready(function () {
    $(".img-val").bind({
        mouseover: function (e) {
            var bodyTop = $(document.documentElement).scrollTop() || $(document.body).scrollTop()
            var dialogTop = $(this).get(0).offsetTop - bodyTop + $(this).height() + 2;
            var dialogLeft = $(this).get(0).offsetLeft - $(document.documentElement).scrollLeft() + $(this).width() + 2;
            var e = e || window.event;
            var tar = e.target || e.srcElement;
            var imgWidth, imgHeight;
            if ($(tar).closest(".panel-set").hasClass("menu-set")) {
                imgWidth = 206, imgHeight = 129;
            }
            else if ($(tar).closest(".panel-set").hasClass("banner-set")) {
                imgWidth = 900, imgHeight = 230;
            }
            else if ($(tar).closest(".panel-set").hasClass("model-set")) {
                imgWidth = 300, imgHeight = 320;
                dialogTop -= 320;
            }
            if ($(tar).closest(".modify-item").hasClass("list-img")) {
                imgWidth = 285, imgHeight = 194;
            }
            else if ($(tar).closest(".modify-item").hasClass("list-banner")) {
                imgWidth = 900, imgHeight = 170;
                dialogLeft-=500;
            }

            $(".view-img-box img").width(imgWidth).height(imgHeight).attr("src", $(this).val());
            $(".view-img-box").show().css({"left": dialogLeft, "top": dialogTop});

        },
        mouseleave: function () {
            $(".view-img-box").hide();
        }
    })

})
