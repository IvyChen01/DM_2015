<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=0.4, minimum-scale=0.4, maximum-scale=0.4, user-scalable=no" />
<title>itel survey</title>
<link href="css/game.css?v=2015.12.25_14.04" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="login">
	<a href="<?php echo $loginUrl; ?>" target="_self">
		<img src="./images/h1.jpg" class="h1" />
		<p class="t1">Nous vous souhaitons une saison de Noel
	spéciale en rejoignant le groupe et en nous disant
	ce que vous attendez d’Itel. Nous nous efforcerons
	de réaliser vos souhaits dans un futur proche. </p>
		<div class="joinBtn"><span>Join & enjoy</span></div>
	</a>
	<div class="phones">
		<a href="http://www.itel-mobile.com/?m=product&a=smartDetail&id=12" target="_blank"><img src="./images/p1.jpg" /></a><a href="http://www.itel-mobile.com/?m=product&a=smartDetail&id=20" target="_blank"><img src="./images/p2.jpg" /></a><a href="http://www.itel-mobile.com/?m=product&a=smartDetail&id=23" target="_blank"><img src="./images/p3.jpg" /></a><a href="http://www.itel-mobile.com/?m=product&a=smartDetail&id=18" target="_blank"><img src="./images/p4.jpg" /></a>
	</div>
	<a href="<?php echo $loginUrl; ?>" target="_self">
		<img src="./images/m1.jpg" class="xmaxPic" />
	</a>
</div>
<?php echo Config::$countCode; ?>
</body>
</html>
