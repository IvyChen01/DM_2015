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
<body>
<section id="body">
    <div class="main welcome">
        <div class="bg"><img src="/images/welcome.png" alt=""/></div>
        <a href="/" class="start"><img src="/images/start.png" alt="" /></a>
        <div class="shadow-panel">
            <div class="loading-img"><img src="/images/loading.gif" alt=""/></div>
        </div>
    </div>
</section>
</body>
<script src="/style/js/jquery-2.1.0.min.js"></script>
<script src="/style/js/jquery.cookie.js"></script>
<script>
    $.cookie("C2B_questions_answer",null)
    var bodyWidth=$(".main").width();
    $(".start img").width(bodyWidth*0.2875).height(bodyWidth*0.28125);
    $(".start").css({"bottom":"15%","left":"35%"})
    var timer=window.setInterval(function(){
        if($(".start img").get(0).complete){
            $(".shadow-panel").hide();
            clearInterval(timer);
        }
    },100)
</script>

</html>