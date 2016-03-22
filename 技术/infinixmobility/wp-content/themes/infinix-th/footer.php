<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Infinix
 */

?>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 pull-right">
                    <ul class="nav navbar-nav navbar-right nav-language">
                        <li class="dropup">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">LANGUAGES</a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a role="menuitem" tabindex="-1" href="/">English</a></li>
                                <li><a role="menuitem" tabindex="-1" href="/fr">Français</a></li>
                                <li><a role="menuitem" tabindex="-1" href="/in">Indonesia</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <ul class="help-links">
                        <li><a href="mailto:<?php echo get_option("support_email")?>">ติดต่อเรา</a></li>
                    </ul>
                </div>
            </div>
            <hr class="help-hr">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <form action="//infinixmobility.us9.list-manage.com/subscribe/post?u=dcf170f04f3951b2480d4a6bc&amp;id=ad9e9e8df2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="form-inline" target="_blank" novalidate="">
                        <p>กรุณาใส่อีเมล์เพื่อรับข่าวสาร</p>
                        <label class="sr-only" for="">อีเมล์ แอดเดรส</label>
                        <input type="email" value="" name="EMAIL" id="mce-EMAIL" placeholder="อีเมล์ แอดเดรส" required>
                        <div style="position: absolute; left: -5000px;"><input type="text" name="b_dcf170f04f3951b2480d4a6bc_ad9e9e8df2" tabindex="-1" value=""></div>
                        <input type="submit" value="สมัครสมาชิก" name="subscribe" id="mc-embedded-subscribe">
                    </form>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <ul class="sns-list">
                        <li><a href="https://www.facebook.com/InfinixMobile">Facebook</a></li>
                        <li><a href="https://twitter.com/InfinixMobility">Twitter</a></li>
                        <li><a href="https://www.youtube.com/user/InfinixMobileNo1">YouTube</a></li>
                        <li><a href="https://instagram.com/infinixmobile">Instagram</a></li>
                        <li><a href="<?php echo site_url(); ?>/xui/">XUI</a></li>
                        <li><a href="http://bbs.infinixmobility.com">XClub</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="<?php bloginfo( 'template_url' ); ?>/js/jquery.min.js"></script>
    <script src="<?php bloginfo( 'template_url' ); ?>/js/bootstrap.min.js"></script>
    <script src="<?php bloginfo( 'template_url' ); ?>/js/modernizr.min.js"></script>
    <script src="<?php bloginfo( 'template_url' ); ?>/js/slick/slick.min.js"></script>
    <script src="<?php bloginfo( 'template_url' ); ?>/js/mustache.min.js"></script>
    <script src="<?php bloginfo( 'template_url' ); ?>/js/app.js"></script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-54295225-1', 'auto');
        ga('send', 'pageview');
    </script>
</body>
</html>
