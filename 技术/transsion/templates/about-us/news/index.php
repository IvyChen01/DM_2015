<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-4-17
 * Time: 上午11:21
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $_info['title']; ?></title>
    <?php
	if (!empty($_info['keywords'])) echo '<meta name="keywords" content="' . $_info['keywords'] . '" />';
    if (!empty($_info['description'])) echo '<meta name="description" content="' . $_info['description'] . '" />';
	?>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="/style/master.css"/>
    <script src="/style/js/jquery-1.9.1.min.js"></script>
    <script src="/style/js/newsModel.js"></script>
</head>
<?php
if ($_language_user == 'cn')
{
    echo "<body class='cn news-page'><div id='wrapper'>";
    include("inc/cn_head.php");
}
else
{
    echo "<body class='en news-page'><div id='wrapper'>";
    include("inc/head.php");
}
?>
    <div class="main">
        <div class="content">
            <div class="position"><a href="<?php echo $_menu_info['main_link']; ?>"><?php echo $_menu_info['main_name']; ?></a> > <span class="cur-pos"><?php echo $_menu_info['sub_name']; ?></span></div>

        </div>
        
        <?php if (!empty($_info['banner_image'])) { ?>
<!--        <div class="banner"><img src="--><?php //echo $_info['banner_image']; ?><!--" alt=""/></div>-->
        <?php } ?>
        <div class="content">
            <div class="news three-cols-type">
                <div class="top clearfix">
                    <div class="title"><?php echo $_menu_info['sub_name']; ?></div>
                    <div class="show-control">
                        <a class="three-cols act" href="javascript:;">2</a>
                        <a class="one-cols" href="javascript:;">1</a>
                    </div>
                </div>
                <div class="news-list clearfix">
                    <?php foreach ($_news as $_key => $_value) { ?>
                        <div class="news-item">
                            <div class="news-img">
                                <div class="news-pic"><img src="<?php echo $_value['image']; ?>" alt=""/></div>
                                <div class="cp-title">
                                    <span class="news-pub"><?php echo $_value['pubdate']; ?></span>
                                    <p class="news-shot"><?php echo $_value['title']; ?></p>
                                </div>
                            </div>
                            <div class="news-description">
                                <div class="news-wos">
                                    <p class="wos-pub"><?php echo $_value['pubdate']; ?></p>
                                    <p class="wos-title"><a href="<?php echo $_value['link']; ?>"><?php echo $_value['title']; ?></a></p>
                                    <p class="wos-detials"><a href="<?php echo $_value['link']; ?>"><?php echo $_value['content']; ?></a></p>
                                </div>
                                <div class="read-more"><a href="<?php echo $_value['link']; ?>">READ MORE ></a></div>
                            </div>
                            <div class="single-st">
                                <div class="single-left">
                                    <img src="<?php echo $_value['image']; ?>" alt=""/>
                                </div>
                                <div class="single-right">
                                    <p class="news-pub"><?php echo $_value['pubdate']; ?></p>
                                    <p class="news-shot"><a href="<?php echo $_value['link']; ?>"><?php echo $_value['title']; ?></a></p>
                                    <p class="wos-detials"><a href="<?php echo $_value['link']; ?>"><?php echo $_value['content']; ?></a></p>
                                    <div class="read-more"><a href="<?php echo $_value['link']; ?>">READ MORE ></a></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="reload"><a href="javascript:;"><span class="re-tl">RELOAD</span><span class="reload-icon"></span></a></div>
            </div>
        </div>
        <div class="content">
            <div class="cur-sub-nav clearfix">
                <?php foreach ($_menu_images as $_key => $_value) { ?>
                    <div class="cnav-item">
                        <a href="<?php echo $_value['link']; ?>" class="cnav-pic"><img src="<?php echo $_value['menu_image']; ?>" alt="<?php echo $_info_detail[$_value['id']]; ?>"/></a>
                        <a href="<?php echo $_value['link']; ?>" class="cnav-til"><?php echo $_info_detail[$_value['id']]; ?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
	if ($_language_user == 'cn')
	{
		include("inc/cn_footer.php");
	}
	else
	{
		include("inc/footer.php");
	}
	?>
</div>
</body>
</html>