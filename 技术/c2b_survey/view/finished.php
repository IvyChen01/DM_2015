<?php if(!defined('VIEW')) exit('Request Error!'); ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8"/>
    <meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <link rel="stylesheet" href="style/master.css"/>
    <script src="style/js/jquery-2.1.0.min.js"></script>
</head>
<body>
<script>
    window.onload=function(){
        setTimeout(function() {
            window.scrollTo(0, 1)
        }, 0);
    };
</script>
<section id="body">
    <div class="main end-2">
        <div class="bg"><img src="/images/end_22.png" width="100%" alt=""/></div>
        <div class="prize-code"><?php echo $_lucky_code; ?></div>
    </div>
</section>
</body>
<script>
    $(function(){
        $(".prize-code").css("top",$(".end-2").width()*1000/640*0.6+"px")
    })

</script>

</html>