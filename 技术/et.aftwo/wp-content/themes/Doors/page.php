<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package Doors
 * @subpackage Doors
 * @since Doors 1.0
 */

get_header(); ?>
<section id="blog-details">
    <div class="container">
        <?php
            $comment = get_post_meta($post->ID, 'newave_comment_section', TRUE);
            $showpagetitle = get_post_meta(get_the_ID(), 'doors_show_page_title', TRUE);
            $subtitle = get_post_meta(get_the_ID(), 'doors_page_subtitle', TRUE);
            $npage = get_post_meta(get_the_ID(), 'doors_normal_page', TRUE);
            if($showpagetitle == 'yes'):
        ?>
        <div class="row titlerow">
            <h3 class="sectiontitle wow fadeInDown" data-wow-duration="700ms" data-wow-delay="300ms"><?php echo get_the_title(); ?></h3>
            <hr class="title-border">
            <div class="clearfix"></div>
            <?php if($subtitle != ''): ?>
            <div class="col-sm-6 col-sm-offset-3">
                <p class="wow fadeInUp text-center" data-wow-duration="700ms" data-wow-delay="300ms">
                    <?php echo $subtitle; ?>
                </p>
            </div>
            <?php endif; ?>
        </div>
        <?php
            endif;
            if($npage == 'hide'):
        ?>
        <div class="row blog-item">
            <div class="col-md-12 col-sm-12 blog-content">
                <?php
                    // Start the Loop.
                    while ( have_posts() ) : the_post();
                        get_template_part( 'content', 'page' );
                        if($comment == 'show'):
                            if ( comments_open() || get_comments_number() ) 
                            {
                                comments_template();
                            }
                        endif;
                    endwhile;
                ?>
            </div><!-- #content -->
        </div>
        
        <?php
            else:
        ?>  
        <div class="row blog-item">
            <div class="col-md-8 col-sm-7 blog-content">
                <?php
                    // Start the Loop.
                    while ( have_posts() ) : the_post();
                        get_template_part( 'content', 'page' );
                        if($comment == 'show'):
                            if ( comments_open() || get_comments_number() ) 
                            {
                                comments_template();
                            }
                        endif;
                    endwhile;
                ?>
            </div><!-- #content -->
            <div class="col-md-4 col-sm-5">
                <div class="sidebar doorssidebar">
                    <?php
                        dynamic_sidebar('sidebar-1');
                    ?>                       
                </div>
            </div>
        </div>
        <?php
                endif;
        ?>
    </div>
</section>
<?php
get_footer();
