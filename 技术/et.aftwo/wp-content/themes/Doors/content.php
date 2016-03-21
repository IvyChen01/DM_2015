<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Doors
 * @subpackage Doors
 * @since Doors 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-header">
        <p></p>

        <?php
        if (has_post_thumbnail()) {
            ?>
            <p class="datea"><span><?php the_time('j') ?></span> <?php the_time('F') ?></p>
            <?php
            echo get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'img-responsive'));
        }
        ?>
        <h3><?php the_title(); ?></h3>
        <div class="entry-meta">
            <span><a href="#" class="text-capitalize"><i class="fa fa-user"></i> Posted by <?php echo get_the_author(); ?></a></span>
            <?php the_tags('<span> <i class="fa fa-tag"></i> ', '<i class="fa fa-tag"></i> ', '</span>'); ?>
            <span><a href="#"><i class="fa fa-comment"></i> <?php echo comments_number('0 Comments', '1 Comment', '% Comment'); ?></a></span>
        </div>
    </div>	
    <div class="entry-post">
        <?php the_content(); ?>
    </div>
    <div class="social-share">
        <?php
        if (shortcode_exists('social_share')) {
            echo do_shortcode('[social_share/]');
        }
        ?>
    </div><!--/social-share-->
    <?php
    $aboutauthorstatus = get_option('aboutauthorstatus', FALSE);
    if ($aboutauthorstatus == 'show'):
        ?>
        <div class="media author-details">
            <h2>ABOUT AUTHOR</h2>
            <a class="pull-left" href="#">
                <?php echo get_avatar(get_the_author_meta('ID')); ?>
            </a>
            <div class="media-body">							
                <p><?php echo get_user_meta(get_the_author_meta('ID'), 'description', true); ?></p>
                <div class="author-social">
                    <span><a href="#"><i class="fa fa-facebook"></i></a></span>
                    <span><a href="#"><i class="fa fa-twitter"></i></a></span>
                    <span><a href="#"><i class="fa fa-pinterest"></i></a></span>
                </div>
            </div>
        </div><!--author-details-->
    <?php endif; ?>
    <div class="wp_page_links">
        <?php
        wp_link_pages(array(
            'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'twentyfourteen') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
        ));
        ?>
    </div>
</article><!-- #post-## -->
