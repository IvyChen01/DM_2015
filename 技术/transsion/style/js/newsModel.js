/**
 * Created by rrr on 14-4-23.
 */
$(function(){
    $(".news-item").bind({
        mouseover:function () {
            $(this).children(".news-description").fadeIn();
        },
        mouseleave:function(){
            $(this).children(".news-description").fadeOut();
        }
    })

    $(".one-cols").click(function(){
        if($(".news").hasClass("single-cols-type")){return;}
        else{
            $(".news-list").hide();
            $(".three-cols").removeClass("act");
            $(this).addClass("act");
            $(".news").removeClass("three-cols-type");
            $(".news").addClass("single-cols-type");
            $(".news-list").height($(".news-item").length*297).fadeIn(1000);
            $(".news-item").unbind();
        }
    })

    $(".three-cols").click(function(){
        if($(".news").hasClass("three-cols-type")){return;}
        else{
            $(".news-list").hide();
            $(".one-cols").removeClass("act");
            $(this).addClass("act");
            $(".news").removeClass("single-cols-type");
            $(".news").addClass("three-cols-type");
            $(".news-list").height(Math.round($(".news-item").length/3)*392).fadeIn(1000);
            $(".news-item").bind({
                mouseover:function () {
                    $(this).children(".news-description").fadeIn();
                },
                mouseleave:function(){
                    $(this).children(".news-description").fadeOut();
                }
            })
        }
    })

    //点击异步加载新闻
    var page_index=2;
    $(".reload a").click(function () {
        $.post("?m=news&a=get_cn_news", {"page": page_index}, load_news, "json").error(function () {
        })
        page_index++;
    });
    function load_news(data) {
        if (typeof data == "object" && Object.prototype.toString.call(data).toLowerCase() == "[object object]" && !data.length) {
            if (data.code == 0) {
                var doc = $(document.createDocumentFragment());
                var newsCount=data.data.length;
                $.each(data.data, function (i, v) {
                    doc.append($("<div class='news-item'></div>").append(
                            "<div class='news-img'>" +
                                "<div class='news-pic'><img src=" + v.image + "></div>" +
                                "<div class='cp-title'>" +
                                "<span class='news-pub'>" + v.pubdate + "</span><p class='news-shot'>" + v.title + "</p></div>" +
                                "</div>" +
                                "<div class='news-description'>" +
                                "<div class='news-wos'><p class='wos-pub'>" + v.pubdate + "</p><p class='wos-title'><a href='" + v.link + "'>"+ v.title+"</a></p><p class='wos-detials'><a href='" + v.link + "'>" + v.content + "</a></p>" +
                                "</div>" +
                                "<div class='read-more'><a href='" + v.link + "'>READ MORE ></a>" +
                                "</div>" +
                                "</div>" +
                                "<div class='single-st'>" +
                                "<div class='single-left'><img src='"+ v.image+"' alt=''/></div>" +
                                "<div class='single-right'>" +
                                "<p class='news-pub'>"+ v.pubdate+"</p><p class='news-shot'>"+ v.title+"</p><p class='wos-detials'>"+ v.content+"</p>" +
                                "<div class='read-more'><a href="+ v.link+">READ MORE ></a></div>" +
                                "</div>" +
                                "</div>"
                        ).bind({
                            mouseover:function(){
                                if(!$(".news").hasClass("single-cols-type")){
                                    $(this).children(".news-description").fadeIn();
                                }
                            },
                            mouseleave:function(){
                                if(!$(".news").hasClass("single-cols-type")){
                                    $(this).children(".news-description").fadeOut();
                                }
                            }
                        })
                    );
                })
                if(!$(".news").hasClass("single-cols-type")){
                    $(".news-list").append(doc).animate({height:$(".news-list").height()+392*Math.round(newsCount/3)});
                }
                else{
                    $(".news-list").append(doc).animate({height:$(".news-list").height()+297*newsCount});
                }
            }
        }
    }

})
