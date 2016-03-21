<?php
/**
 * Created by PhpStorm.
 * User: rrr
 * Date: 14-4-3
 * Time: 下午3:01
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $_title; ?></title>
    <?php
	if (!empty($_keywords)) echo '<meta name="keywords" content="' . $_keywords . '" />';
    if (!empty($_description)) echo '<meta name="description" content="' . $_description . '" />';
	?>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style/master.css"/>
    <script src="/style/js/jquery-1.9.1.min.js"></script>
    <script src="/style/js/index.js"></script>
    <script src="/style/js/newsModel.js"></script>
</head>
<?php
if ($_language_user == 'cn')
{
    $_temp_news = '最新新闻';
    $_temp_supplier = '成为供应商';
    $_temp_join = '加入我们';
    echo "<body class='cn'><div id='wrapper'>";
	include("inc/cn_head.php");
}
else
{
    $_temp_news = 'RECENT ARTICLES & NEWS';
    $_temp_supplier = 'TO BE OUR SUPPLIER';
    $_temp_join = 'JOIN US';
    echo "<body class='en'><div id='wrapper'>";
    include("inc/head.php");
}
?>
<div id="banner">
    <div id="slider">
        <div class="banner-wrap">
            <div class="banner-item"><a href="<?php echo $_banner_link1; ?>"><img src="<?php echo $_banner_image1; ?>" alt=""/></a></div>
            <div class="banner-item"><a href="<?php echo $_banner_link2; ?>"><img src="<?php echo $_banner_image2; ?>" alt=""/></a></div>
            <div class="banner-item"><a href="<?php echo $_banner_link3; ?>"><img src="<?php echo $_banner_image3; ?>" alt=""/></a></div>
            <div class="banner-item"><a href="<?php echo $_banner_link4; ?>"><img src="<?php echo $_banner_image4; ?>" alt=""/></a></div>
        </div>
        <script>
            $(".banner-item").width($("body").width());
            $(".banner-wrap").width($("body").width()*4);
        </script>
    </div>
    <div class="content">
        <div class="slider-btn">
            <a href="javascript:;" class="pre"><</a>
            <a href="javascript:;" class="next"><</a>
        </div>
        <div class="slider-bar">
            <ul>
                <li>
                    <a href="javascript:;" class="o-bar">1</a>
                    <a href="javascript:;" class="c-bar">1</a>
                    <a href="javascript:;" class="d-bar">1</a>
                </li>
                <li>
                    <a href="javascript:;" class="o-bar">2</a>
                    <a href="javascript:;" class="c-bar">2</a>
                    <a href="javascript:;" class="d-bar">1</a>

                </li>
                <li>
                    <a href="javascript:;" class="o-bar">3</a>
                    <a href="javascript:;" class="c-bar">3</a>
                    <a href="javascript:;" class="d-bar">1</a>

                </li>
                <li>
                    <a href="javascript:;" class="o-bar">4</a>
                    <a href="javascript:;" class="c-bar">4</a>
                    <a href="javascript:;" class="d-bar">1</a>
                </li>
            </ul>
        </div>
    </div>
    <script>
        $("#banner .content").height(Math.round($("body").width()/1920*490)+54);
        var Mtop=Math.round($("body").width()/1920*490)/2-33;
        $(".slider-btn a").css("top",Mtop+"px");
    </script>
</div>
<div id="index_main">
    <div class="content">
        <div class="news three-cols-type">
            <div class="top clearfix">
                <div class="title"><span class="title-icon"></span><?php echo $_temp_news; ?></div>
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

        <div class="sup-join">
            <div class="to-our-sup">
                <div class="title"><span class="title-icon"></span><?php echo $_temp_supplier; ?></div>
                <div class="sup-join-con">
                    <div class="sj-images">
                        <p class="sj-pic"><img src="<?php echo $_supplier_image; ?>" alt=""/></p>
                        <p class="sj-slo"><?php echo $_supplier_text; ?></p>
                    </div>
                    <div class="sj-read-more">
                        <a href="<?php echo $_supplier_link; ?>"><span>READ MORE ></span></a>
                    </div>
                </div>
            </div>
            <div class="join-us">
                <div class="title"><span class="title-icon"></span><?php echo $_temp_join; ?></div>
                <div class="sup-join-con">
                    <div class="sj-images">
                        <p class="sj-pic"><img src="<?php echo $_join_image; ?>" alt=""/></p>
                        <p class="sj-slo"><?php echo $_join_text; ?></p>
                    </div>
                    <div class="sj-read-more">
                        <a href="<?php echo $_join_link; ?>"><span>READ MORE ></span></a>
                    </div>
                </div>
            </div>
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
<script>
</script>
</body>
</html>