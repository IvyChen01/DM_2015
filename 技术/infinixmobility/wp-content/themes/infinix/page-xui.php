<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Infinix
 */

get_header(1); ?>

<style>
    .xui-kv {background: url(/wp-content/uploads/images/xui-kv-bg.jpg) center center no-repeat;background-size: 100% auto;padding-bottom: 0;}
    .xui-kv-logo {text-align: center;margin-bottom: 15px;}
    .xui-kv-logo img {max-width: 80%;}

    .xui-section {padding: 15px 0;background-repeat: no-repeat;background-size: cover;background-position: center center;text-align: center;}
    .xui-section h2 {font-size: 16px;font-weight: bold;margin-top:0;color: #00b0a2;}
    .xui-section span {color: #00b0a2;font-size: 16px;}
    .xui-section h3 {font-size: 14px;margin-top: 0;}
    .xui-section p {max-width: 80%;margin:0 auto;font-size: 12px;color: #333;}
    .xui-section img {margin: 15px auto;}

    .xui-section-1 {background-color: #f5f5f5;}

    .xui-section-2 {background-image: url(/wp-content/uploads/images/xui-2-bg.jpg);}
    .xui-section-2 h2,.xui-section-2 h3,.xui-section-2 p {color: #fff;}
    .xui-section-2 img {max-width: 80px;}

    .xui-section-3 {padding-bottom: 0;}

    .xui-section-4 {padding: 0;background-color: #aeafb4;}
    .xui-section-4 img {margin: 0;}
    .xui-section-4 h2,.xui-section-4 p {color: #fff;}

    .xui-section-5 {padding-top: 0;}

    .xui-section-6 {background-color: #f5f5f5;}

    .xui-section-7 {padding-bottom: 0;}
    .xui-section-7 img {margin: 0 auto;}

    .xui-section-8 {background-color: #f5f5f5;}

    .xui-section-10 {background-image: url(/wp-content/uploads/images/xui-10-bg.jpg);}
    .xui-section-10 h2,.xui-section-10 span,.xui-section-10 p {color: #fff;}

    @media (min-width: 768px) {
        .xui-section {padding: 30px 0;}
        .xui-section h2 {font-size: 24px;}
        .xui-section span {font-size: 20px;}
        .xui-section h3 {font-size: 18px;margin-top: 0;}
        .xui-section p {max-width: 90%;font-size: 14px;}
        .xui-section img {margin: 30px auto;}
        .xui-section-2 img {max-width: 100%;}
        .xui-section-3 {padding-bottom: 0;}
        .xui-section-4 {padding: 0;text-align: left;}
        .xui-section-4 p {max-width: 100%;}
        .xui-section-4 img {margin: 0;}
        .xui-section-5 {padding-top: 0;}
        .xui-section-7 {padding-bottom: 0;text-align: left;}
        .xui-section-7 img {margin: 0;}
        .xui-section-7 p {max-width: 100%;}
    }
    @media (min-width: 992px) {
        .xui-kv img {margin: 30px auto;}
        .xui-section h2 {font-size: 36px;}
        .xui-section span {font-size: 30px;}
        .xui-section h3 {font-size: 24px;}
        .xui-section p {font-size: 18px;}
        .xui-section {padding: 60px 0;}
        .xui-section-3 {padding-bottom: 0;}
        .xui-section-4 {padding: 0;}
        .xui-section-4 img {margin: 0;}
        .xui-section-5 {padding-top: 0;}
        .xui-section-7 {padding-bottom: 0;}
        .xui-section-7 img {margin: 0;}
    }
    @media (min-width: 1200px) {
        .xui-kv img {margin: 60px auto;}
    }
</style>

<section class="xui-kv">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 xui-kv-logo"><img src="/wp-content/uploads/images/xui-kv-logo.png"></div>
            <div class="col-xs-12"><img src="/wp-content/uploads/images/xui-kv-1.png"></div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-1">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>21% improved performance</h2>
                <p>Background management is optimized via intelligent RAM management, regular system acceleration, and one key fast-clean memory. Overall performance is improved by 21% for ultra smooth operation with zero lag.</p>
            </div>
            <div class="col-xs-12">
                <img src="/wp-content/uploads/images/xui-1-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>20% longer battery life</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-2-1.png">
                <h3>Unique alarm synchronous heartbeat</h3>
                <p>minimizes system wake up to reduce background app power consumption.</p>
            </div>
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-2-2.png">
                <h3>Unique standby network management</h3>
                <p>In standby mode, XUI auto initiates standby network management to increase standby time by 28%.</p>
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-3">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>Chic wallpapers &amp; themes</h2>
                <p>Trendy color block design enables vivid pictures and crisp text. Meticulously designed icons, themes, and wallpapers are regularly updated. Theme design becomes available later, making your Smartphone even more personalized.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-3-1.jpg">
            </div>
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-3-2.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-4">
    <img class="" src="/wp-content/uploads/images/xui-4-bg-1.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 pull-right">
                <h2>Keep up with Android upgrade</h2>
                <p>XUI was optimized by lightweight methodology based on market trends and Android operation logic; this keeps the OS running smoothly and ensures fast version updates. With XUI, you can experience the lastest operating system.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <img src="/wp-content/uploads/images/xui-4-1.jpg">
            </div>
        </div>
    </div>
    <img src="/wp-content/uploads/images/xui-4-bg-2.jpg">
</section>

<section class="xui-section xui-section-5">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span>Stay in touch</span>
                <h2>one account, connected everywhere</h2>
                <p>Xaccounts are connected for your convenience. Register one account to access platform software including Xcontacts, Xclub, and User feedback.</p>
                <img src="/wp-content/uploads/images/xui-5-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-6">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span>Advanced power saving function</span>
                <h2>no more cry for low battery</h2>
                <p>With ultra power saving mode, users can set reminders or be prompted automatically when power falls below 10%. The interface for this mode includes 6 fixed apps. All background functions are terminated for minimal power consumption; this effectively doubles standby time so that you may continue to operate under low battery conditions.</p>
                <img src="/wp-content/uploads/images/xui-6-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-7">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 pull-right">
                <span>XContacts</span>
                <h2>never lose touch</h2>
                <p>Xcontacts keeps your contacts safe; login with Xcontacts and sync up via cloud. Simply download when switching mobile devices to save time and energy. A recycling function is included for convenient phone book updates.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <img src="/wp-content/uploads/images/xui-7-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-8">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span>Xender</span>
                <h2>swap phones with ease</h2>
                <p>Our unique fast transfer technology saves you both time and money. Login to Xender via X-Account when swapping phones to quickly transfer photos, videos, software, and other data formats. This process does not consume bandwidth and is significantly faster than Bluetooth. Xender also allows users to share content with friends across mobile devices.</p>
                <img src="/wp-content/uploads/images/xui-8-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-9">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>XClub-Infinix forum</h2>
                <p>Xclub is the official forum of Infinix. <br>Users can login via X-Account to share tips, download updates, provide feedback, and win prizes.</p>
                <img src="/wp-content/uploads/images/xui-9-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-10">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span>User feedback</span>
                <h2>talk with devs</h2>
                <p>XUI feedback platform brings users closer to devs. Login with X-Account to comment on user experience, make suggestions, or report bugs. As an important part of our process, feedback is carefully considered for future updates and fixes.</p>
                <img src="/wp-content/uploads/images/xui-10-1.png">
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
