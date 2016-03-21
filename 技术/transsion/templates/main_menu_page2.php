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
    <script src="/style/js/jquery-2.1.0.min.js"></script>
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
        	<div class="column-intro-2 clearfix">
                <div class="left-section">
                    <?php echo $_info['content']; ?>
                </div>
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
//                $(function(){
//                    $(".cnav-item").mouseover(function(){$(this).addClass("hover")}).mouseleave(function(){$(this).removeClass("hover")})
//                })
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