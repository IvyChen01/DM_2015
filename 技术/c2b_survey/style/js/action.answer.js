/**
 * Created by rrr on 14-5-26.
 */

$(function () {
    //next图标
    Marquee();
    function Marquee() {
        var nextWidth = $(".next").width();
        if ($(".dy2").width() == 60) {
            $(".dy2").animate({"width": "90px", "height": "90px", "margin-top": "-45px", "left": nextWidth / 2 - 15 + "px", "opacity": "0"}, 1200, "linear", function () {
                $(".dy2").stop().css({"width": "60px", "height": "60px", "margin-top": "-30px",  "left": "50%", "opacity": "1"})
                Marquee();
            })
        }
    }

    //最低高度
//    var minHeight
    //题目切换

    var questions;
    $.ajaxSettings.async = false;
    $.getJSON("/style/js/questions.list.json", function (data) {
        questions = data;
    });
    var curFrontColor = "#f2b701";
    var alowMaxSelect = 2;
    $(".q-list li label").click(function (e) {
        selectAction(e, $(this));
    })

    function selectAction(e, el) {
        if (e.stopPropagation) e.stopPropagation();
        e.preventDefault();
        if (el.find(".check-icon").hasClass("com-radio")) {
            if(el.attr("isSed")!="true"){
                $(".q-list li label").find(".com-radio span").css("background-color", curFrontColor);
                el.find(".com-radio span").css("background-color", "#fff");
                $(".q-list li label").attr("isSed",false);
                el.attr("isSed",true);
            }
        }
        if(el.find(".check-icon").hasClass("com-checkbox")) {
            if (el.attr("isSed") != "true") {
                if($(".cur-index").text()==3){
                    if(el.find(".options-font").text()=="No unsatisfying aspect"){
                        $(".q-list").find(".com-checkbox span").css("color", "#fff")
                        $(".q-list").find("label").attr("isSed", false);
                        el.find(".com-checkbox span").css("color", curFrontColor);
                        el.attr("isSed", true);
                    }
                    else{
                        $(".q-list li:last").find(".com-checkbox span").css("color", "#fff")
                        $(".q-list li:last").find("label").attr("isSed", false);
                        el.find(".com-checkbox span").css("color", curFrontColor);
                        el.attr("isSed", true);
                    }
                }
                else{
                    el.find(".com-checkbox span").css("color", curFrontColor);
                    el.attr("isSed", true);
                }

            }
            else {
                el.find(".com-checkbox span").css("color", "#fff");
                el.attr("isSed", false);
            }
        }
    }

    $(".dy1").click(function () {loadNextQuestion();});
    $(".dy2").click(function () {loadNextQuestion();});

    function refreshHtml(htmlArr, selectionModel, parent) {
        if (selectionModel == "radio") {
            for (i=0;i<htmlArr.length;i++) {
                var li = $("<li></li>").append($("<label>" +
                    "<span class='com-radio check-icon'><span></span></span>" +
                    "<div class='options-font'>" + htmlArr[i].op_p + "</div>" +
                    "</label>").attr("o_index",htmlArr[i].o_id).bind({
                    'click': function (e) {
                        selectAction(e, $(this));
                    }
                })).hide().appendTo(parent);
            }
        }
        else {
            //4题特殊情况
            var yetAnswer;
            var q3_selection_fill;
            var selecton_font="";
            if ($.cookie("C2B_questions_answer")!= "null"&&$.cookie("C2B_questions_answer")!=undefined) {
                yetAnswer=JSON.parse($.cookie("C2B_questions_answer"));
            }
            if(yetAnswer&&yetAnswer[2]){
                q3_selection_fill=yetAnswer[2].fill;
            }
            if(q3_selection_fill){
                selecton_font='Others <textarea class="custom-fill" onfocus="custom_fill_focus(this);" onblur="custom_fill_blur(this);">'+q3_selection_fill+'</textarea>';
            }
            for (i=0;i<htmlArr.length;i++) {
                var fina_font=htmlArr[i].op_p;
                if(q3_selection_fill&&fina_font.indexOf("Others")>-1&&parseInt($(".title .num").text())==4) {fina_font=selecton_font;}
                var li= $("<li></li>").append($("<label>" +
                    "<span class='com-checkbox check-icon'><span>√</span></span>" +
                    "<div class='options-font'>" + fina_font + "</div>" +
                    "</label>").attr("o_index",htmlArr[i].o_id).bind({
                    'click': function (e) {
                        selectAction(e, $(this));
                    }
                })).hide().appendTo(parent);
            }
        }

        $(".dy1").css("color", curFrontColor);
        $(".main").css("background-color",curFrontColor);

    }

    function nextQuestion(nextIndex) {
        var curQIndex = $(".cur-index").text();
        var nextIndex = nextIndex || 0;
        if(nextIndex==-1) { window.location.href="end_1.html";return;}
        else if(nextIndex==-2) { window.location.href="end_2.html";return;}
        else if(nextIndex==-3) {alert("Please complete this step before go to next.");return;}
        else if(nextIndex==-4) {alert("You can select at most 3 options.");return;}
        else if(nextIndex==-5) {$(".next").hide();return;}
        var showQuestion = questions[nextIndex];
        var sortQuestion;
        var docFrg = $(document.createDocumentFragment());
        var q_title=showQuestion.title;

        //前端样式
        $(".q-wrap .title").css("visibility", "hidden");
        $(".q-list ul li").remove();
        $(".cur-index").text(showQuestion.id);

        //获取第一题
        var q1_selection=getSelection_options(0);
        if(q1_selection!=-1){
            if(q1_selection.search(0).length>0){
                q_title=q_title.replace("{q1_selection_phone}"," "+questions[0].answer.options[0].op_p);
            }
            else if(q1_selection.search(1).length>0){
                q_title=q_title.replace("{q1_selection_phone}"," "+questions[0].answer.options[1].op_p);
            }
            else if(q1_selection.search(2).length>0||q1_selection.search(3).length>0){
                q_title=q_title.replace("{q1_selection_phone}"," TECNO phone");
            }
        }
        $(".title p").html(q_title);
        curFrontColor=showQuestion.bgColor;
        if(showQuestion.id==4){//第四题特殊，需要根据第三题来判断
            var q3_selection=getSelection_options(2);
            var q4_options=[],q3_options=questions[2].answer.options;
            var q3_len=q3_options.length,q4_len=q3_selection.length;
            for(i=0;i<q4_len;i++){
                for(j=0;j<q3_len;j++){
                    if(q3_options[j]["o_id"]==q3_selection[i]){
                        q4_options.push(q3_options[j])
                    }
                }
            }
            refreshHtml(q4_options, "checkbox", docFrg);
        }

        else{
            if (showQuestion.answer.sortCount) {//排序
                var unitArr = showQuestion.answer.options.slice(0, showQuestion.answer.sortCount);
                sortQuestion = unitArr.sort(function () {
                    return Math.random() > 0.5 ? -1 : 1;
                });
                if (showQuestion.answer.isSingleSelection == 1) {//单选题
                    refreshHtml(sortQuestion, "radio", docFrg);
                    var unSortOptions = showQuestion.answer.options.slice(showQuestion.answer.sortCount);
                    refreshHtml(unSortOptions, "radio", docFrg);
                }
                else {
                    refreshHtml(sortQuestion, "checkbox", docFrg);
                    var unSortOptions = showQuestion.answer.options.slice(showQuestion.answer.sortCount);
                    refreshHtml(unSortOptions, "checkbox", docFrg);
                }
            }
            else {//不排序
                if (showQuestion.answer.isSingleSelection == 1) {
                    refreshHtml(showQuestion.answer.options, "radio", docFrg)
                }
                else {
                    refreshHtml(showQuestion.answer.options, "checkbox", docFrg)
                }
            }
        }
        $(".q-list ul").append(docFrg)

        $(".q-wrap .title").css({"visibility": "inherit", "display": "none"}).fadeIn(300);
        $(".q-list ul li").fadeIn(300,function(){
        $(".shadow-panel").hide();
        });
        $(".com-radio span").css("background-color",curFrontColor);
        $(".shadow-panel").hide();

    }
    function loadNextQuestion(){
        var curIndex=$(".cur-index").text();
        if($(".q-list .check-icon").hasClass("com-radio")&&getSelectOption_single().length>0){
            saveAnswer(curIndex-1,getSelectOption_single());
        }
        else if($(".q-list .check-icon").hasClass("com-checkbox")&&getSelectOption_multi().length>0){
            saveAnswer(curIndex-1,getSelectOption_multi());
        }
        var nextIndex=getNextIndex(curIndex);
        nextQuestion(nextIndex);
    }
    //textarea 焦点事件

//页面初始化
//    $.cookie("C2B_questions_answer",null);
    (function(){
        var yetAnswer;
        var yetQuestionId=0;
        if ($.cookie("C2B_questions_answer")!= "null"&&$.cookie("C2B_questions_answer")!=undefined) {
            yetAnswer=JSON.parse($.cookie("C2B_questions_answer"));
        }
        if(yetAnswer){
            for(i=0;i<yetAnswer.length;i++){
                if(yetQuestionId<yetAnswer[i].id) yetQuestionId=yetAnswer[i].id;
            }
        }
        if(yetQuestionId!=0){
            yetQuestionId=getNextIndex(yetQuestionId);
        }
        if(yetQuestionId==3){
            if(yetAnswer[2].answer.length<4){
                yetQuestionId=nextIndex_q3();
            }
            else{
                yetQuestionId=3;
            }
        }
        if(yetQuestionId==16) yetQuestionId=15;
        nextQuestion(yetQuestionId);
    })()
})
