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
</head>
<?php
if ($_language_user == 'cn')
{
    echo "<body class='cn'><div id='wrapper'>";
    include("inc/cn_head.php");
}
else
{
    echo "<body class='en'><div id='wrapper'>";
    include("inc/head.php");
}
?>
    <div class="main">
        <div class="content">
            <div class="position"><span class="cur-pos"><?php echo $_menu_info['main_name']; ?></span></div>
            <div class="page-title"><?php echo $_menu_info['main_name']; ?></div>
        </div>
        
        <?php if (!empty($_info['banner_image'])) { ?>
        <div class="banner"><img src="<?php echo $_info['banner_image']; ?>" alt=""/></div>
        <?php } ?>
        <div class="content">
			<?php echo $_info['content']; ?>
        </div>
        <div class="content">
            <div class="contact-method">
                <div class="contact-til">媒体联系</div>
                <div class="contact-list">
                    <ul>
                        <li><span class="con-li-icon"></span>86-755-33979200</li>
                        <li><span class="con-li-icon"></span>86-755-33979211</li>
                        <li><span class="con-li-icon"></span><a href="mailto:hello@transsion.com">hello@transsion.com</a></li>
                        <li><span class="con-li-icon"></span>深圳市南山区高新科技园南区高新南一道德赛科技大厦17楼</li>
                    </ul>
                </div>
<!--                <div class="hk-office office-addr">-->
<!--                    <span class="addr-til">香港地址: </span>-->
<!--                    <p class="addr-til-det">-->
<!--                        香港九龍油塘高輝道7號高輝工業大廈B座3樓-->
<!--                    </p>-->
<!--                </div>-->
<!--                <div class="sz-office office-addr">-->
<!--                    <span class="addr-til">深圳地址:</span>-->
<!--                    <p class="addr-til-det">-->
<!--                        深圳市南山区高新科技园深南大道9789号德赛科技大厦17层-->
<!--                    </p>-->
<!--                </div>-->
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
            <script>
                $(function(){
//                    $(".cnav-item").mouseover(function(){$(this).addClass("hover")}).mouseleave(function(){$(this).removeClass("hover")})
                })
            </script>
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
