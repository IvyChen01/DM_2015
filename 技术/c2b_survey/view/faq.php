<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8"/>
    <meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <link rel="stylesheet" href="style/master.css"/>

</head>
<body >
<script>
    window.onload=function(){
        setTimeout(function() {
            window.scrollTo(0, 1)
        }, 0);
    };
</script>
<section id="body" class="faq">
    <div class="main " >
        <div class="top-title">TECNO Smartphone User Satisfaction Survey</div>
        <div class="q-wrap clearfix" >
            <div class="title"><span class="num"><span class="cur-index"></span>
                    <span class="ques-total">.</span>
                </span>
                <p></p></div>
            <div class="q-list" id="options">
                <ul>
                </ul>
            </div>
        </div>
        <div class="next">
            <div class="dy1">Next</div>
            <div class="dy2"></div>
        </div>
    </div>
    <div class="shadow-panel">
        <div class="loading-img"><img src="/images/loading.gif" alt=""/></div>
    </div>
</section>
<script src="style/js/jquery-2.1.0.min.js"></script>
<script>

    function custom_fill_focus(el){
        if($(el).val()=="Please specify"){
            $(el).val("");
        }
    }
    function custom_fill_blur(el){
        if($(el).val()==""){
            $(el).val("Please specify");
        }
    }
</script>
<script src="style/js/jquery.cookie.js"></script>
<script src="style/js/function.js"></script>
<script src="style/js/action.answer.js"></script>

<script>
</script>
</body>
</html>