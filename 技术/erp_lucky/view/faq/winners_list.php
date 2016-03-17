<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-7-4
 * Time: 下午2:17
 */
$pageId=3;
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link href="style/master.css" rel="stylesheet">
</head>
<body class="winners-list-page">
<?php include("inc/head.php") ?>
<div class="wrapper">
    <div class="main clearfix">
        <div class="question-model-title">恭喜，就是你</div>
        <div class="list-panel">
            <?php
			foreach ($_lucky as $_value)
			{
				$_date = date('Y-m-d');
				if ($_value['prize_time'] == $_date)
				{
					echo '<span class="employee-name">' . $_value['username'] . '</span>' . "\r\n";
					echo '<span class="employee-numbers">' . $_value['jobnum'] . '</span>' . "\r\n";
					echo '<span class="prize-name">' . $_value['prize_name'] . '</span>' . "\r\n";
				}
			}
			?>
        </div>
        <div class="data-panel">
            <script src="/style/js/jquery-1.9.1.min.js"></script>
            <script src="/style/calendar/js/calendar.js"></script>
            <link rel="stylesheet" href="/style/calendar/skin/default.css"/>
            <link rel="stylesheet" href="/style/calendar/skin/green.css"/>
            <div id="calendar"></div>
            <script>
				var luckyData = [];
                <?php
				foreach ($_lucky as $_value)
				{
					echo 'luckyData.push({"name":"' . $_value['username'] . '", "jobnum":"' . $_value['jobnum'] . '", "prize_name":"' . $_value['prize_name'] . '", "prize_time":"' . $_value['prize_time'] . '"});' . "\r\n";
				}
				?>

				$(function(){
                    $("#calendar").EVAN_calendar({
                        "width":400,
                        "height":300,
                        dayClick:function(obj){
                            obj.closest("span").siblings("span").removeClass("EVAN-calendar-today")
                            obj.closest("span").addClass("EVAN-calendar-today");


//                            var today=(new Date()).getFullYear()+"-"+(((new Date()).getMonth()+1)>9?((new Date()).getMonth()+1):"0"+((new Date()).getMonth()+1))+"-"+((new Date()).getDate()>9?(new Date()).getDate():"0"+(new Date()).getDate());
                              var today=$(".EVAN-calendar-year").text()+"-"+($(".EVAN-calendar-month").text()>9?$(".EVAN-calendar-month").text():"0"+$(".EVAN-calendar-month").text())+
                                  "-"+(obj.text()>9?obj.text():"0"+obj.text());
                            if (luckyData && luckyData.length >= 0) {
                                var doc=$(document.createDocumentFragment());
                                $.each(luckyData,function(i,v){
                                    if(v.prize_time == today){
                                        doc.append("<span class='employee-name'>"+ v.name+"</span><span class='employee-number'>"+ v.jobnum+"</span><span class='prize-name'>"+ v.prize_name+"</span>")
                                    }
                                })
                                $(".list-panel").empty().hide().append(doc).fadeIn();
                            }
                        }
                    });
                })
            </script>
        </div>
    </div>
</div>
<?php include("inc/footer.php");?>
</body>
</html>