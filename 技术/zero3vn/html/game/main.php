<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Infinix Zero3</title>
<link href="css/index.css?v=2016.3.16_17.13" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.2.min.js" type="text/javascript" language="javascript"></script>
<script src="js/jquery.rotate.min.js" type="text/javascript" language="javascript"></script>
<script src="js/mover.js?v=2016.3.16_17.13" type="text/javascript" language="javascript"></script>
<script src="js/lucky.js?v=2016.3.16_17.13" type="text/javascript" language="javascript"></script>
</head>

<body>
<div class="orderBox">
	<img class="bgpic" src="./images/banner2_1.jpg?v=3"/>
	<img class="bgpic" src="./images/banner2_2.jpg?v=3"/>
	<a href="http://www.lazada.vn/infinix-zero-3/?utm_source=FB&utm_medium=minisite&utm_campaign=ZERO3" target="_blank">
		<img class="bgpic" src="./images/banner2_3.jpg?v=3"/>
	</a>
	<img class="bgpic" src="./images/banner2_4.jpg?v=3"/>
</div>
<?php if (!Config::$isLocal) { ?>
<div class="videoBox">
	<div class="youtubeVideo">
		<iframe width="100%" height="640" src="https://www.youtube.com/embed/DeaobHTXtBU" frameborder="0" allowfullscreen></iframe>
	</div>
</div>
<?php } ?>
<div class="phoneBox">
	<img class="bgpic" src="./images/banner3_1.jpg?v=3"/>
	<img class="bgpic" src="./images/banner3_2.jpg?v=3"/>
	<img class="bgpic" src="./images/banner3_3.jpg?v=3"/>
	<img class="bgpic" src="./images/banner3_4.jpg?v=3"/>
</div>
<div class="loginBox">
	<?php if ($isLogin) { ?>
		<img class="bgpic" src="./images/8.jpg?v=3"/>
	<?php } else { ?>
		<a href="<?php echo $loginUrl; ?>" target="_self"><img class="bgpic" src="./images/8.jpg?v=3"/></a>
	<?php } ?>
</div>
<div class="luckyBox">
	<div class="box">
		<div class="left">
			<!--<img class="arrow_left" src="./images/arrow_left.png"/>-->
			<p class="t1">Danh sách giải thưởng:</p>
			<p class="t2">2  điện  thoại  Infinix  Zero 3<br />
			20 voucher mua hàng trên LAZADA trị giá 500.000VND<br />
			80 Thẻ cào điện thoại trị giá 50.000 VND</p>
			<a id="startBtn" href="javascript:void(0);">
				<div class="panBox">
					<img id="pan" class="pan" src="./images/pan.png?v=3"/>
					<img class="arrow" src="./images/arrow.png?v=3"/>
					<p>Bắt đầu</p>
				</div>
			</a>
		</div>
		<div class="right">
			<!--<img class="arrow_right" src="./images/arrow_right.png"/>-->
			<p class="t1">Chớp lấy cơ hội để trúng giải Infinix  Zero 3 nhé<br />
	Thời gian tham gia: 2016/3/17 -2016/3/18</p>
			<p class="t3">Bước 1: Đăng nhập Facebook<br />
	Bước 2: Like fanpage Infinix<br />
	Bước 3: Chia sẻ post “Zero 3 – Nhiếp Ảnh Trong Tầm Tay” trên tường của bạn với hashtag #Infinix hoặc #Zero3 và<br />
	mời bạn bè cùng tham gia<br />
	Mỗi tài khoản Facebook có cơ hội 1 lần để rút thăm,<br />
	hãy chia sẻ bài đăng để nhân đôi cơ hội bạn nhé!<br />
	Infinix chịu trách nhiệm trả lời mọi thắc mắc.</p>
			<?php if (!Config::$isLocal) { ?>
			<div class="fbcontent">
				<div id="fb-root"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";  fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script><div class="fb-post" data-href="https://www.facebook.com/InfinixVN/posts/452190238238813" data-width="500"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/InfinixVN/posts/452190238238813"><p>&gt;#Infinix #Zero3 Nhi&#x1ebf;p &#x1ea2;nh Trong T&#x1ea7;m Tay&#xff1a;20.7MP&#xff0c;PDAF 0.1S mang &#x111;&#x1ebf;n cho b&#x1ea1;n tr&#x1ea3;i nghi&#x1ec7;m c&#x1ef1;c &#x111;&#x1ec9;nh khi ch&#x1ee5;p &#x1ea3;nh. &gt;H&#xe3;y c&#xf9;ng...</p>Posted by <a href="https://www.facebook.com/InfinixVN/">Infinix Mobile</a> on&nbsp;<a href="https://www.facebook.com/InfinixVN/posts/452190238238813">Tuesday, March 15, 2016</a></blockquote></div></div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="winnerBox">
	<div class="box">
		<div class="titleBar">
			<span class="title">Danh sách người chiến thắng </span>
			<ul id="winPage" class="winPage">
				<?php for ($i = 1; $i <= 2; $i++) { ?>
					<?php if ($page == $i) { ?>
						<li class="select"><img src="./images/page_select.png"/><p>3.<?php echo $i + 16; ?></p></li>
					<?php } else { ?>
						<li><a href="<?php echo $pageUrl; ?><?php echo $i; ?>" target="_self"><p>3.<?php echo $i + 16; ?></p></a></li>
					<?php } ?>
				<?php } ?>
			</ul>
		</div>
		<ul class="winnerList">
			<?php foreach ($winList as $value) { ?>
			<li>
				<div class="wrapper">
					<img class="photo" src="<?php echo $value['photo']; ?>"/>
					<p class="name"><?php echo $value['username']; ?></p>
					<p class="date"><?php echo Utils::mdate('m.d.Y', $value['luckydate']); ?></p>
					<p class="award"><?php echo Config::$prizeName[$value['prizeid'] - 1]; ?></p>
					<div class="awardImg"><img src="./images/award<?php echo $value['prizeid']; ?>.png"/></div>
				</div>
			</li>
			<?php } ?>
		</ul>
	</div>
	<div class="clear"></div>
</div>
<div class="winDlg">
	<div class="box">
		<img class="winDlgBg" src="./images/winDlgBg.png"/>
		<a id="winClose" href="javascript:void(0);"><img id="winClose" class="winClose" src="./images/winClose.jpg"/></a>
		<a id="winShareBtn" href="javascript:void(0);"><img id="fbshare" class="fbshare" src="./images/fbshare.png"/></a>
		<p id="winTip" class="winTip"></p>
	</div>
</div>
<?php if ($isLogin) { ?>
	<div class="infoBar">
		<img class="infoBg" src="./images/photobar.png"/>
		<img class="photo" src="<?php echo $photo; ?>"/>
		<p class="username"><?php echo $username; ?></p>
	</div>
<?php } else { ?>
	<div class="loginBar">
		<a href="<?php echo $loginUrl; ?>" target="_self"><img class="winDlgBg" src="./images/fblogin.png"/></a>
	</div>
<?php } ?>
<input type="hidden" id="isLocal" value="<?php if (Config::$isLocal) { echo 1; } else { echo 0; } ?>" />
<input type="hidden" id="isFb" value="<?php if (Config::$isFb) { echo 1; } else { echo 0; } ?>" />
<input type="hidden" id="appId" value="<?php echo Config::$fbAppId; ?>" />
<input type="hidden" id="shareUrl" value="<?php echo Config::$shareUrl; ?>" />
<input type="hidden" id="sharePic" value="<?php echo Config::$sharePic; ?>" />
<input type="hidden" id="restLucky" value="<?php echo $restLucky; ?>" />
<input type="hidden" id="restSecond" value="<?php echo $restSecond; ?>" />
<input type="hidden" id="isLogin" value="<?php if ($isLogin) { echo 1; } else { echo 0; } ?>" />
<input type="hidden" id="isScroll" value="<?php if ($isScroll) { echo 1; } else { echo 0; } ?>" />
<input type="hidden" id="isShared" value="<?php if ($isShared) { echo 1; } else { echo 0; } ?>" />
<input type="hidden" id="timeState" value="<?php echo $timeState; ?>" />
<?php echo Config::$countCode; ?>
</body>
</html>
