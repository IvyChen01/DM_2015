<?php
/**
 * The Template for displaying all single posts
 *
 * @package Doors
 * @subpackage Doors
 * @since Doors 1.0
 */

get_header(); ?>
<section id="blog-details">
    <div class="container">
        <div class="row blog-item">
            <div class="col-md-8 col-sm-7 blog-content">
                <?php
                    // Start the Loop.
                    while ( have_posts() ) : the_post();
                        get_template_part( 'content', get_post_format() );
                        if(get_option('commentswithc', false) != 'commentOff'):
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
    </div>
</section>
<?php
get_footer();
