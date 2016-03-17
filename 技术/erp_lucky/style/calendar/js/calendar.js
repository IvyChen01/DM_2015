/**
 * Created by rrr on 2014/7/4.
 */
$.fn.EVAN_calendar=function(options){

    var calendar=$(this);

    var defaults={
        skin:"green",
        width:400,
        height:320
    };
    var obj= $.extend(defaults,options);


    $.fn.EVAN_calendar.getDaysInMonth=function(year,month){
//        return (new Date(year+"/"+(parseInt(month)+1)+"/0")).getDate()
        var daysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31]
            ,month=month-1;
        if (month == 1) {
            if(year%4==0||(year%4==0&&year%100!=0)) return 29;
            else return 28;
        }
        else return daysInMonth[month];
    };
    var date=new Date(),
        today_year=date.getFullYear(),
        today_month=date.getMonth()+1,
        today=date.getDate(),
        today_1=today_year+"年"+today_month+"月",
        days_month=$.fn.EVAN_calendar.getDaysInMonth(today_year,today_month);

        $.fn.EVAN_calendar.prototype={
        getDayOfWeek:function(dayValue){return (new Date(Date.parse(dayValue))).getDay();},
        drawDay:function(year,month){
            var daysNum=$.fn.EVAN_calendar.getDaysInMonth(year,month);
            var day,docFrgDay=$(document.createDocumentFragment());
            daysNum=daysNum||30;
            for(i=1;i<=daysNum;i++){
                day=$("<span><a href='javascript:;'>"+i+"</a></span>").css({
                    "width":obj.width*0.13+"px",
                    "line-height":obj.height*(1-1/6-1/8)/5-10+"px",
                    "height":obj.height*(1-1/6-1/8)/5-10+"px"
                });

                day_a_width=obj.height*(1-1/6-1/8)/5-10<obj.width*0.13?obj.height*(1-1/6-1/8)/5-10:obj.width*0.13;

                day.children("a").css({
                    "width":day_a_width+"px",
                    "margin-top":-(obj.height*(1-1/6-1/8)/5-10)/2+"px",
                    "margin-left":-day_a_width/2+"px",
                    "border-radius":day_a_width/2+"px"
                }).bind({
                    click: function () {if(obj.dayClick) (obj.dayClick)($(this))},
                    mouseover: function () {if(obj.dayMouseover) (obj.dayMouseover)($(this))},
                    mouseleave: function () {if(obj.dayMouseleave) (obj.dayMouseleave)($(this))}
                });
                if(i==today&&year==today_year&&month==today_month) day.addClass("EVAN-calendar-today");
                if(i==1) day.css("margin-left",this.getDayOfWeek(year+"/"+month+"/1")*obj.width*0.13+"px")
                docFrgDay.append(day)
            }
            return docFrgDay;
        },
        refresh:function(){
            var curYear=$(".EVAN-calendar-year").text();
            var curMonth=$(".EVAN-calendar-month").text();
            $(".EVAN-calendar-content").hide().empty().append($.fn.EVAN_calendar.prototype.drawDay(curYear,curMonth)).fadeIn();
        },
        draw:function(){
            var doc_panel=$("<div class='EVAN-calendar-panel'></div>"),
                doc_day=$("<div class='EVAN-calendar-content'></div>").css({
                    "padding":"0"+" "+obj.width*0.045+"px"
                }).append(this.drawDay(today_year,today_month)),
                doc_title=$("<div class='EVAN-calendar-title'></div>").css({
                    "line-height":obj.height/6+"px"
//                    "padding-left":obj.width/10+"px"
                }).append($("<div class='EVAN-calendar-change-bar'></div>").append($("<a class='EVAN-calendar-last-year' href='javascript:;'><<</a>").bind({
                    click:function(){
                        var lastYear=~~$(".EVAN-calendar-year").text()-1;
                        $(".EVAN-calendar-year").text(lastYear)
                        $.fn.EVAN_calendar.prototype.refresh();
                    }
                }),$("<a href='javascript:;' class='EVAN-calendar-last-month'><</a>").bind({
                    click:function(){
                        var lastMonth=~~$(".EVAN-calendar-month").text()-1;
                        lastMonth=lastMonth>0?lastMonth:1;
                        $(".EVAN-calendar-month").text(lastMonth);
                        $.fn.EVAN_calendar.prototype.refresh();
                    }
                }),$("<span class='EVAN-calendar-year'>"+today_year+"</span>年<span class='EVAN-calendar-month'>"+today_month+"</span>月"+"<span></span>"
                ),$("<a href='javascript:;' class='EVAN-calendar-next-year'>>></a>").bind({
                    click:function(){
                        var nextYear=~~$(".EVAN-calendar-year").text()+1;
                        $(".EVAN-calendar-year").text(nextYear)
                        $.fn.EVAN_calendar.prototype.refresh();
                    }
                    }),
                    $("<a href='javascript:;' class='EVAN-calendar-next-month'>></a>").bind({
                    click:function(){
                        var nextMonth=~~$(".EVAN-calendar-month").text()+1;
                        nextMonth=nextMonth<13?nextMonth:12;
                        $(".EVAN-calendar-month").text(nextMonth)
                        $.fn.EVAN_calendar.prototype.refresh();
                    }
                }))),

                doc_week=$("<div class='EVAN-calendar-week-bar'></div>").css({
                    "height":obj.height/8-1+"px",
                    "padding":"0"+" "+obj.width*0.045+"px"
                })
                doc_week.append("<span>日</span><span>一</span><span>二</span><span>三</span><span>四</span><span>五</span><span>六</span>").children("span").css({
                    "width":obj.width*0.13+"px",
                    "line-height":obj.height/8-1+"px"
                });



            calendar.addClass("EVAN-calendar").css({"width":obj.width+"px","height":obj.height+"px"}).append(doc_panel.append(doc_title,doc_week,doc_day));
        },
        init:function(){
            this.draw();

//            $("head").append("<link href='skin/default.css' rel='stylesheet' type='text/css'>");
//            $("head").append("<link href='skin/"+obj.skin+".css' rel='stylesheet' type='text/css'>");


        }
    }
    $.fn.EVAN_calendar.prototype.init();
}