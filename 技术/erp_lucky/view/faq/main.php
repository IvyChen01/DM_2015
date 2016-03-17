<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-6-17
 * Time: 上午10:30
 */
$pageId=1;
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link href="style/master.css" rel="stylesheet">
</head>
<body>
<?php include("inc/head.php") ?>
<div class="wrapper">
    <div class="main clearfix">
        <div class="question-model-title">先答题，再抽奖</div>
        <?php if($_answered==0){ ?>
        <div class="question-panel">
            <span class="que-til"></span>
            <div class="question-list clearfix">
                <?php $_faq_index = 1; ?>
        <?php foreach ($_faq as $value) { ?>
            <div class="question-item clearfix"
                <?php
                if ($value['question_type'] == 1)
                {
                    echo 'multiSelect="0"';
                }
                else
                {
                    echo 'multiSelect="1"';
                }
                ?> >
                <span class="question-result"></span>
                <div class="question-content">
                    <span class="qu-it-til"><?php echo $_faq_index++; echo '.' . $value['question']; echo ($value['question_type'] == 1) ? '' : '(多选)'; ?></span>
                    <?php if ($value['question_type'] == 1) { ?>
                        <!--单选题-->
                        <ul>
                            <li><label><span class="check-icon radio"><span></span></span><?php echo $value['option1']; ?></label></li>
                            <li><label><span class="check-icon radio"><span></span></span><?php echo $value['option2']; ?></label></li>
                            <li><label><span class="check-icon radio"><span></span></span><?php echo $value['option3']; ?></label></li>
                            <li><label><span class="check-icon radio"><span></span></span><?php echo $value['option4']; ?></label></li>
                        </ul>
                    <?php } else { ?>
                        <!--多选题-->
                        <ul>
                            <li><label><label><span class="check-icon checkbox"><span>√</span></span><?php echo $value['option1']; ?></label></li>
                            <li><label><span class="check-icon checkbox"><span>√</span></span><?php echo $value['option2']; ?></label></li>
                            <li><label><span class="check-icon checkbox"><span>√</span></span><?php echo $value['option3']; ?></label></li>
                            <li><label><span class="check-icon checkbox"><span>√</span></span><?php echo $value['option4']; ?></label></li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

    </div>
    <div class="submit-answer"><a href="javascript:;">提交答案并抽奖</a></div>
</div>
<div class="lottery-panel">
    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="564" height="564" id="luckySwf_ie" name="luckySwf_ie">
		<param name="movie" value="swf/main.swf" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="#ffffff" />
		<param name="play" value="true" />
		<param name="loop" value="true" />
		<param name="wmode" value="transparent" />
		<param name="scale" value="showall" />
		<param name="menu" value="true" />
		<param name="devicefont" value="false" />
		<param name="salign" value="" />
		<param name="allowScriptAccess" value="sameDomain" />
		<!--[if !IE]>-->
			<div class="turntable"></div>
			<div class="guide"></div>
		<!--<![endif]-->
	</object>
</div>
        <?php } else {?>
            <div class="lot-yet">英雄，系统说你今日已经抽过奖了，明天继续可好！</div>
        <?php }?>


    </div>
</div>
<div class="lot-result">
    <span class="title">恭喜你中了！！！！</span>
    <p class="prize"><span class="prize-name">充电宝2014款</span>*1个</p>
    <p class="bar-btn"><a href="javascript:;" class="tomorrow-continue">明日继续</a>
<!--        <a class="jiathis_button_tools_1">炫耀一下</a>-->
    </p>
</div>
<div class="fail-today">
    <span class="title">英雄:</span>
    <p class="ad-yet">今日您已战败，是否择日再战?</p>
    <p class="bar-btn"><a href="/?m=faq&a=show_question" class="rest-ag">我不服</a><a href="javascript:;" class="tomorrow-continue">明日继续</a></p>
</div>
<script src="style/js/jquery-1.9.1.min.js"></script>
<script src="style/js/turntable.js"></script>
<script src="style/js/answer.js"></script>
<script src="style/js/cookie.js"></script>
<?php include("inc/footer.php") ?>
<script>
    $(function(){
        $(".tomorrow-continue").click(function(){$(".lot-result,.fail-today").fadeOut();})
    })
</script>
<!--<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>-->
</body>
</html>
