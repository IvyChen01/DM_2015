<?php if(!defined('VIEW')) exit(0); ?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="css/mobile.css?v=2015.5.23_18.18"/>
</head>
<body class="login">
<div class="appName">Zero2Hero</div>
<div class="header">
    <div class="page-title">Me</div>
</div>
<div class="container">
    <div class="content">
        <div class="best-rank-likes">
            <div class="photo">
                <img src="<?php echo $_userinfo['local_photo']; ?>"/>
            </div>
            <div class="rank-link">
                <span class="best-rank">Best rank: <span class="value"><?php echo $_bestRank; ?></span></span>
                <span class="best-links">Total likes: <span class="value"><?php echo $_totalLikes; ?></span></span>
            </div>
            <div class="to">
                <a href="?m=mwuser&a=profile" target="_self"><img src="images/mobile/m_left_2.png" alt=""/></a>
            </div>
        </div>
    </div>
</div>
<section id="historyBox">
    <div class="panel-title">
        History
    </div>
    <div class="history-list">
		<?php foreach ($_data as $_key => $_value) { ?>
        <div class="item">
            <div class="time">
                <span class="year"><?php echo $_value['upload_time']; ?></span>
            </div>
            <div class="photo-vf">
                <a href="?m=mwzero&a=viewPic&picId=<?php echo $_value['pic_id']; ?>&pageFlag=3" target="_self"><img src="<?php echo $_value['small_pic']; ?>" alt=""/></a>
            </div>
            <div class="mm-sh">
                <div class="history-rank">
                    <img src="images/mobile/rank.png" alt=""/>TOP
                    <span class="value"><?php echo $_value['rank']; ?></span>
                </div>
                <div class="history-likes">
                    likes
                    <span class="value"><?php echo $_value['num']; ?></span>
                </div>
                <div class="share">
                    <a href="#">
                        <img src="images/mobile/share.png" alt=""/>
                    </a>
                </div>
            </div>
            <div class="ver-line">
                <span class="top">.</span>
                <span class="bottom">.</span>
            </div>
        </div>
		<?php } ?>
    </div>
</section>
<div class="bottom-nav">
	<div class="link-rank"><a href="?m=mwzero&a=rank" target="_self">Rank</a></div>
	<div class="link-show"><a href="?m=mwzero&a=create" target="_self">Create</a></div>
	<div class="link-me"><a href="?m=mwzero&a=history" target="_self">Me</a></div>
</div>
</body>
</html>
