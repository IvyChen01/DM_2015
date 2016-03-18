<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="css/mobile.css?v=2015.5.23_18.18"/>
<script src="js/jquery-1.11.2.min.js"></script>
</head>
<body>
<div class="header">
	<div class="page-title">Resize</div>
</div>
<section id="resizeBox">
	<div class="resize-ori">
		<img src="images/mobile/resize.jpg">
	</div>
</section>
<div class="bottom-nav">
	<div class="resize-cancel"><a href="#">Cancel</a></div>
	<div class="resize-ok"><a href="#" >Ok</a></div>
</div>
<script>
	$(function(){
		var bodyH = $(window).height(),
			headerH = $(".header").height(),
			bottomH = $(".bottom-nav").height();
		var resizeBoxHeight = bodyH-headerH-bottomH;
		$("#resizeBox").height(bodyH-headerH-bottomH);
		var imgDivPos = resizeBoxHeight - $(".resize-ori").height();
		$("#resizeBox").css("padding-top",imgDivPos/2);
	});
</script>
</body>
</html>
