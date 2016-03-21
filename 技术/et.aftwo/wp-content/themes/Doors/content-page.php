<?php
/**
 * The template used for displaying page content
 *
 * @package Doors
 * @subpackage Doors
 * @since Doors 1.0
 */
$author = get_post_meta($post->ID, 'doors_author_meta', TRUE);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-header">
        <?php if (has_post_thumbnail()): ?>
            <p class="datea"><span><?php the_time('j') ?></span> <?php the_time('F') ?></p>
        <?php endif; ?>
        <?php
        if (has_post_thumbnail()) {
            echo get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'img-responsive'));
        }
        ?>
        <h3><?php echo get_the_title(); ?></h3>
    </div>	
    <div class="entry-post">
        <?php the_content(); ?>
        
        <?php wp_link_pages(); ?>
    </div>
    <?php if ($author == 'show'): ?>
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
    <div class="pagelinks">
        <?php
        wp_link_pages(array(
            'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'doors') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
        ));

        edit_post_link(__('Edit', 'doors'), '<span class="edit-link">', '</span>');
        ?>
    </div>
</article><!-- #post-## -->

