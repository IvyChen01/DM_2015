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

get_header(); ?>

<section class="about-banner">
    <img src="/wp-content/uploads/images/about-banner.jpg">
</section>

<h1 class="about-head">About Us</h1>

<section class="about-content">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                <img src="/wp-content/uploads/images/about.jpg">
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
