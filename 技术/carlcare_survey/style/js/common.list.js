/**
 * Created by rrr on 2015/3/10.
 */
var status = (function(){
    var href = window.location.search.match(/&a=([\w]+)$/);
    href = !href ? "" : href[1]
    switch (href){
        case '' :
            return 2;
        case 'tovisit':
            return 1;
        case 'failvisit':
            return 3
        default :
            return 2;
    }
})() ;
function getWeekValue(text){
    var selectWeek = 0 ;
    switch (text){
        case 'The first week' :
            selectWeek = 1;
            break;
        case 'The second week' :
            selectWeek = 2;
            break;
        case 'The third week' :
            selectWeek = 3;
            break;
        case 'The fourth week' :
            selectWeek = 4;
            break;
        case 'The fifth week' :
            selectWeek = 5;
            break;
        default :
            selectWeek = 0;
            break;
    }
    return selectWeek;
}
function bindData(obj){
    var
        country = (obj.country == 'Country' ? '' : obj.country) || '',
        year = obj.year || '',
        month = obj.month || '',
        week = getWeekValue(obj.week),
        type = status || 1,
        page = obj.page || 1;

    $(".bk-mt table tbody").empty().append($("<tr><td colspan='5' style='padding:120px;font-size: 40px;'>Loading....</td></tr>"));

    $.ajax({
        url         :       '/?m=survey&a=getList',
        type        :       'POST',
        async:false,
        data        :       {country : country,year : year,month : month,week : week,type:type,page : page},
        success     :       function(data){
            if(data.indexOf("{") != 0) {
                throw  new Error('Server error!');
                return;
            }
            var data = $.parseJSON(data);
            if(data.code != 0) {
                throw  new Error('Server error!');
                return;
            }

            $(".suc-cots").text(data.successNum)
            $(".dnt-cots").text(data.waitNum)
            $(".dnc-cots").text(data.failNum)

            var docFrg = $(document.createDocumentFragment());
            $(".lt-ctc ul").empty().append($("<li><a href=\"javascript:;\">Country</a></li>").bind({
                "click" : function(){
                    $(this).closest(".co-df-ul").children(".co-ul-selected").children("span").text($(this).children("a").text());
                    $(this).closest("ul").slideUp(200);
                    refreshDataBySort();
                    createCookie('selectCountry',$(this).text())
                }
            }))
            $(".lt-cts ul").empty().append($("<li><a href=\"javascript:;\">——</a></li>").bind({
                "click" : function(){
                    $(this).closest(".co-df-ul").children(".co-ul-selected").children("span").text($(this).children("a").text());
                    $(this).closest("ul").slideUp(200);
                    refreshDataBySort();
                    createCookie('selectYear',$(this).text())
                }
            }))
            $.each(data.countryList,function(k,v){
                $(".lt-ctc ul").append($("<li><a href=\"javascript:;\">" + v + "</a></li>").bind({
                    "click" : function(){
                        if(v == $(this).closest(".co-df-ul").children(".co-ul-selected").children("span").text) return;
                        $(this).closest(".co-df-ul").children(".co-ul-selected").children("span").text($(this).children("a").text());
                        $(this).closest("ul").slideUp(200,function(){
                            refreshDataBySort();
                        });
                        createCookie('selectCountry',$(this).text())
                    }
                }));
            })
            $.each(data.yearList,function(k,v){
                $(".lt-cts ul").append($("<li><a href=\"javascript:;\">" + v + "</a></li>").bind({
                    "click" : function(){
                        if(v == $(this).closest(".co-df-ul").children(".co-ul-selected").children("span").text) return;
                        $(this).closest(".co-df-ul").children(".co-ul-selected").children("span").text($(this).children("a").text());
                        $(this).closest("ul").slideUp(200,function(){
                            refreshDataBySort()
                        });
                        createCookie('selectYear',$(this).text())

                    }
                }));
            })
            if(data.data.length){
                $.each(data.data,function(k,v){
                    if(status == 3){
                        docFrg.append(
                            $("<tr>" +
                            "<td><span class='cus-number'> " + v.wo_number + " </span></td>" +
                            "<td><span class='cus-name'> " + v.customer_name + " </span></td>" +
                            "<td><span class='cus-country'> " + v.country + " </span></td>" +
                            "<td style='position: relative'><span class='cus-explain'> " +
                            //"" + v.feedback + " </span><span class='note'>" +
                            "" + (function(){
                                switch(Number(v.feedback)){
                                    case 0 :
                                        return 'Other';
                                        break;
                                    case 1 :
                                        return 'Normal';
                                        break;
                                    case 2 :
                                        return 'Non-customer answered';
                                        break;
                                    case 3 :
                                        return 'Busy';
                                        break;
                                    case 4 :
                                        return 'Respondent refused';
                                        break;
                                    case 5 :
                                        return 'Cannot connect';
                                        break;
                                    case 6 :
                                        return 'No answer';
                                        break;
                                    case 7 :
                                        return 'Incorrect number';
                                        break;
                                    default :
                                        return 'Other';
                                        break;
                                }
                            })() +"</span></td>" +
                            "<td><span style='color:red'>No</span></td>" +
                            "</tr>")
                        )
                        setTimeout(function(){
                            $(".cus-explain").bind({
                                "mouseover": function (event) {
                                    event.stopPropagation();
                                    $(this).siblings(".note").fadeIn();
                                },
                                "mouseleave": function (event) {
                                    event.stopPropagation();
                                    $(this).siblings(".note").fadeOut();
                                }
                            })
                        },1)

                    }
                   else if(status == 2){
                        docFrg.append(
                            $("<tr>" +
                            "<td><span class='cus-number'> " + v.wo_number + " </span></td>" +
                            "<td><span class='cus-name'> " + v.customer_name + " </span></td>" +
                            "<td><span class='cus-country'> " + v.country + " </span></td>" +
                            "<td><span class='cus-explain'> " + v.fill_time + " </span></td>" +
                            "<td><a class='cus-examine' href='/?m=survey&a=examine&userid=" + v.id + "'>REVIEW</a></td>" +
                            "</tr>")
                        )
                    }
                    else if(status ==1){
                        docFrg.append(
                            $("<tr>" +
                            "<td><span class='cus-number'> " + v.wo_number + " </span></td>" +
                            "<td><span class='cus-name'> " + v.customer_name + " </span></td>" +
                            "<td><span class='cus-country'> " + v.country + " </span></td>" +
                            "<td><span class='cus-explain' > " + (4 - v.dial_number) + " </span></td>" +
                            "<td><a class='cus-examine' href='?m=survey&a=visit&userid=" + v.id + "'>VISIT</a></td>" +
                            "</tr>")
                        )
                    }
                })
            }
            else{
                docFrg.append($("<tr><td colspan='5' style='padding:120px;font-size: 40px;'>Empty</td></tr>"))
            }
            pageTotal = data.pageCount;
            pagingBtn(page-1,0)
            $(".bk-mt table tbody").empty().hide().append(docFrg).fadeIn()

        },
        timeout     :       3000,
        error       :       function(){
            throw  new Error('Server error!');
        }
    })
}
function refreshDataBySort(page){
    var obj = {
        country     :       $(".lt-ctc .co-ul-selected span").text() == "Country" ? "" : $(".lt-ctc .co-ul-selected span").text(),
        year        :       $(".lt-cts .co-ul-selected span").text() == "——" ? "" : $(".lt-cts .co-ul-selected span").text(),
        month       :       $(".lt-ctm .co-ul-selected span").text() == "——" ? "" : $(".lt-ctm .co-ul-selected span").text(),
        week        :       $(".imf-week .co-ul-selected span").html() == "——" ? "" : $(".imf-week .co-ul-selected span").html(),
        page        :       page
    }
    bindData(obj)
}



//分页

var pageTotal = 0;
function showNote(){
}
function pagingBtn(curIndex,refresh) {

    if(pageTotal == 0) {
        $(".pagination").hide().find(".pg-bx").empty();
        return
    }
    $(".pagination").show()
    var curIndex = curIndex||'';
    if(curIndex > pageTotal) return;


    var doc = $(document.createDocumentFragment());

    pagingBtn.createBtn = function (i,index) {
        if(i == index){
            return $($("<a class='pg-nm cur' href='javascript:'> " + (i + 1) + " </a>"))
        }
        return $($("<a class='pg-nm' href='javascript:'> " + (i + 1) + " </a>")).click(function(){pagingBtn(i,1)})
    }

    var pageCount = pageTotal > 10 ? 10 : pageTotal;

    if (!curIndex || curIndex < 5 || pageTotal <= 10 ) {
        for (var i = 0; i < pageCount; i++) {
            doc.append(pagingBtn.createBtn(i,curIndex))
        }
    }
    else if(curIndex > pageTotal - 5){
        for(var j = curIndex -5 - (5 - (pageTotal - curIndex)); j < curIndex ; j ++){
            doc.append(pagingBtn.createBtn(j,curIndex))
        }
        for(var k = curIndex; k < pageTotal; k ++){
            doc.append(pagingBtn.createBtn(k,curIndex))
        }
    }
    else{
        for(var j = curIndex -5; j < curIndex ; j ++){
            doc.append(pagingBtn.createBtn(j,curIndex))
        }
        for(var k = curIndex; k < curIndex +5  ; k ++){
            doc.append(pagingBtn.createBtn(k,curIndex))
        }
    }

    $(".pagination .pg-bx").empty().append(doc);
    if(!refresh) return;
    curIndex = curIndex ? curIndex + 1 : 1;
    refreshDataBySort(curIndex)

}
$(".pagination .pre").click(function(){
    var index = (~~$(".pagination .pg-bx .cur").text() -1) -1;
    index = index >= 0 ? index : 0;
    pagingBtn(index,1)
})
$(".pagination .next").click(function(){
    var index = ((~~$(".pagination .pg-bx .cur").text() -1) +1);
    if(pageTotal -1 < index) return
    pagingBtn(index,1)
})
;
function uploadData(){
    $("#ajaxUploadFileLoading").show();
    var uploadYear = $(".imf-dialog .imf-year .co-ul-selected span").text() == '——' ? '' : $(".imf-dialog .imf-year .co-ul-selected span").text(),
        uploadMonth = $(".imf-dialog .imf-month .co-ul-selected span").text() == '——' ? '' : $(".imf-dialog .imf-month .co-ul-selected span").text(),
        uploadWeek = getWeekValue($(".imf-dialog .data-import-week .co-ul-selected span").text());
    $.ajaxFileUpload
    (
        {
            url:'/?m=survey&a=import',
            secureuri:false,
            fileElementId:'fileToUpload',
            dataType: 'json',
            data:{name: 'logan', id: 'id', year: uploadYear, month: uploadMonth, week: uploadWeek},
            success: function (data, status)
            {

                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {
                        alert(data.error);
                    }else
                    {
                        alert(data.msg);
                    }
                }
                $("#ajaxUploadFileLoading").hide();

            },
            error: function (data, status, e)
            {
                alert(e);
                $("#ajaxUploadFileLoading").hide();

            }
        }
    )
    return false;
}
function createCookie(name,value){
    if($.cookie(name)) $.removeCookie(name);
    $.cookie(name ,value)
};
function checkExits(weekText)
{
    var uploadYear = $(".imf-dialog .imf-year .co-ul-selected span").text() == '——' ? '' : $(".imf-dialog .imf-year .co-ul-selected span").text(),
        uploadMonth = $(".imf-dialog .imf-month .co-ul-selected span").text() == '——' ? '' : $(".imf-dialog .imf-month .co-ul-selected span").text(),
        uploadWeek = getWeekValue(weekText)
    $.post("/?m=survey&a=checkExist", {year: uploadYear, month: uploadMonth, week: uploadWeek}, function(value){
        var res = null;
        if (value.substr(0, 1) != "{")
        {
            alert("Unknow error!");
            return;
        }
        res = $.parseJSON(value);


        switch (res.code)
        {
            case 0:
                //本周无数据，无需提示是否覆盖原数据，直接上传
                uploadData();
                break;
            case 1:
                //本周数据已存在，提示是否覆盖原数据
                if(confirm("Data already exist, whether the coverage?")){
                    uploadData();

                }
                break;
            default:
                alert("Unknow error!");
        }
    });
}
function dataExport(){
    var year = $(".imr-dialog .imf-year .co-ul-selected span").text(),
        month = $(".imr-dialog .imf-month .co-ul-selected span").text(),
        week = $(".imr-dialog .data-import-week .co-ul-selected span").text();
    year = (year == '——' ? '' : year) || '';
    month = (month == '——' ? '' : month) || '';
    week = (week == '——' ? '' : week) || '';
    window.open("/?m=survey&a=export&year=" + year + '&month=' + month + "&week=" + week)
}
$(function(){
    $(".co-ul-selected").click(function () {
        $(this).siblings("ul").slideToggle(200);
    })
    $(".co-df-ul ul li").click(function () {
        $(this).closest(".co-df-ul").children(".co-ul-selected").children("span").text($(this).children("a").text());
        $(this).closest("ul").slideUp(200)
    });
    (function(){
        var sortObj = {
            country        :       $.cookie('selectCountry') || '',
            year           :       $.cookie('selectYear') || '',
            month          :       $.cookie('selectMonth') || '',
            week           :       $.cookie('selectWeek') || ''
        }
        $(".lt-ctc .co-ul-selected span").text(sortObj.country || 'Country')
        $(".lt-cts .co-ul-selected span").text(sortObj.year || '——')
        $(".lt-ctm .co-ul-selected span").text(sortObj.month || '——')
        $(".imf-week .co-ul-selected span").text(sortObj.week || '——')
        bindData(sortObj)

    })()

    $(".lt-ctm ul li").click(function(){
        if($(this).children("a").text() == $(this).closest(".co-df-ul").children(".co-ul-selected").children("span").text) return;
        $(this).closest(".co-df-ul").children(".co-ul-selected").children("span").text($(this).children("a").text());
        $(this).closest("ul").slideUp(20,function(){
            refreshDataBySort();
        })
        createCookie('selectMonth',$(this).text())
    })
    $(".date-box .imf-week ul li").click(function(){
        if($(this).children("a").text() == $(this).closest(".co-df-ul").children(".co-ul-selected").children("span").text) return;
        $(this).closest(".co-df-ul").children(".co-ul-selected").children("span").text($(this).children("a").text());
        $(this).closest("ul").slideUp(20,function(){
            refreshDataBySort()
        })
        createCookie('selectWeek',$(this).text())
    })
    $(".data-import-week ul li").mouseup(function(){
       // checkExits($(this).find("a").text())
    })
    $(".data-file-upload").bind({
        "click"  : function(){
            checkExits( $(".imf-dialog .data-import-week .co-ul-selected span").text())
        }
    })
    $(".data-cx a").click(function () {
        $(".imf-dialog").fadeIn();
        $(".data-cx").addClass("active");
    })
    $(".data-vx a").click(function () {
        $(".imr-dialog").fadeIn();
        $(".data-vx").addClass("active");
    })
    $(".st-qt").click(function () {
        $(".imf-dialog").fadeOut()
        $(".data-cx").removeClass("active");
    })
    $(".close-dialog a").click(function () {
        $(".imf-dialog").fadeOut()
        $(".data-cx").removeClass("active");
    })
    $(".imr-dialog .close-dialog a").click(function () {
        $(".imr-dialog").fadeOut()
        $(".data-cx").removeClass("active");
    })
    $(".bow-cot input").change(function () {
        $(".fs-pas").val($(this).val());
    })
    $(".imr-te li").click(function(){
        $(this).siblings("li").removeClass("dt-sled")
        $(this).addClass("dt-sled")
        $(".qt-mc .qt-nxt").addClass("active")
    })
    $(".rp-dc").click(function(){
        dataExport()
    })
})