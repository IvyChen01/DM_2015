/**
 * Created by rrr on 14-4-23.
 */
$(document).ready(function(){
    $.post("/?m=news&a=get_recommend_news_cn",function(data){
        if (typeof data == "object" && Object.prototype.toString.call(data).toLowerCase() == "[object object]" && !data.length) {
            if (data.code == 0) {
                var doc = $(document.createDocumentFragment());
                $.each(data.data,function(i,v){
                    doc.append("<div class='recom-item'>" +
                        "<a class='recom-link' href='"+ v.link+"' >" +
                        "<img src='"+ v.image+"'>" +
                        "<span class='rec-date'>"+ v.pubdate+"</span>" +
                        "<div class='recom-desc'>"+ v.title+"</div>" +
                        "</a>" +
                        "</div>");
                })
                doc.appendTo(".recom-list");
            }
        }
        },"json").error(function(){})
});