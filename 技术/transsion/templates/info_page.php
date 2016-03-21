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
            <div class="position"><a href="<?php echo $_menu_info['main_link']; ?>"><?php echo $_menu_info['main_name']; ?></a> > <span class="cur-pos"><?php echo $_menu_info['sub_name']; ?></span></div>
            <div class="page-title"><?php echo $_menu_info['sub_name']; ?></div>
        </div>
        
        <?php if (!empty($_info['banner_image'])) {
			if (empty($_brand_link)) {?>
				<div class="banner"><img src="<?php echo $_info['banner_image']; ?>" alt=""/></div>
		<?php } else { ?>
				<div class="banner"><a href="<?php echo $_brand_link; ?>" target="_blank"><img src="<?php echo $_info['banner_image']; ?>" alt=""/></a></div>
		<?php } } ?>
        <div class="content">
			<?php echo $_info['content']; ?>
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