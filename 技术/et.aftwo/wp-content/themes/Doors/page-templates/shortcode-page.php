<?php
/**
 * Template Name: Shortcode Page
 *
 * @package Doors
 * @subpackage Doors
 * @since Doors 1.0
 */

get_header(); ?>
<?php
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
?>
<?php
get_footer();