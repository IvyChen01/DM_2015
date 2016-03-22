<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home/ file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Infinix
 */

get_header(); ?>

<div class="key-banner">
    <div><a class="rpd-image-bg" data-bg="url(/wp-content/themes/infinix/images/kv_X553_m.jpg)" data-bg-d="url(/wp-content/themes/infinix/images/kv_X553.jpg)"></a></div>
    <div><a class="rpd-image-bg" href="<?php echo site_url(); ?>/smartphone/zero-3" data-bg="url(/wp-content/themes/infinix/images/kv-x552-m.jpg)" data-bg-d="url(/wp-content/themes/infinix/images/kv-x552.jpg)"></a></div>
    <div><a class="rpd-image-bg" href="<?php echo site_url(); ?>/smartphone/note-2" data-bg="url(/wp-content/themes/infinix/images/kv-x600-m.jpg)" data-bg-d="url(/wp-content/themes/infinix/images/kv-x600.jpg)"></a></div>
    <div><a class="rpd-image-bg" href="<?php echo site_url(); ?>/xui/" data-bg="url(/wp-content/themes/infinix/images/kv-xui-m.jpg)" data-bg-d="url(/wp-content/themes/infinix/images/kv-xui.jpg)"></a></div>
    <div><a class="rpd-image-bg" href="<?php echo site_url(); ?>/smartphone/hot-2/" data-bg="url(/wp-content/themes/infinix/images/kv-x510-m.jpg)" data-bg-d="url(/wp-content/themes/infinix/images/kv-x510.jpg)"></a></div>
</div>

<section class="key-product">
    <div class="row row-ng">
        <div class="product-item col-xs-12 col-sm-4">
            <a href="<?php echo site_url(); ?>/xui/">
                <img src="/wp-content/themes/infinix/images/product-3.jpg">
                <div class="product-title">Slim · Fast · Beautiful <span>Learn more</span></div>
            </a>
        </div>
        <div class="product-item col-xs-12 col-sm-4">
            <a href="<?php echo site_url(); ?>/acc/hot-2-flip-cover/">
                <img src="/wp-content/themes/infinix/images/product-2.jpg">
                <div class="product-title">More choices for you <span>Learn more</span></div>
            </a>
        </div>
        <div class="product-item col-xs-12 col-sm-4">
            <a href="<?php echo site_url(); ?>/smartphone/hot-note/">
                <img src="/wp-content/themes/infinix/images/product-1.jpg">
                <div class="product-title">Charge your life <span>Learn more</span></div>
            </a>
        </div>
    </div>
</section>

<section class="key-video">
    <a href="https://www.youtube.com/watch?v=OyFI32_llyM">
        <img class="rpd-image" data-src="/wp-content/themes/infinix/images/key-video-m.jpg" data-src-d="/wp-content/themes/infinix/images/key-video.jpg">
    </a>
</section>

<section class="video-pop">
    <div class="video-pop-content">
        <span class="video-pop-close">X</span>
        <div class="video-pop-inner"><iframe src="https://www.youtube.com/embed/OyFI32_llyM?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe></div>
    </div>
    <div class="video-pop-mask"></div>
</section>

<section class="key-forum">
    <a href="http://bbs.infinixmobility.com">
        <img class="rpd-image" data-src="/wp-content/themes/infinix/images/key-forum-m.jpg" data-src-d="/wp-content/themes/infinix/images/key-forum.jpg">
    </a>
</section>

<?php get_footer(); ?>
