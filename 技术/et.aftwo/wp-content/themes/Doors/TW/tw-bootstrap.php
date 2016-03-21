<?php
/**
 * Xpeed Studio WordPress Framework
 *
 * Copyright (c) 2014, Xpeed Studio, s.r.o. (http://XpeedStudio.com)
 */

define('THEME_DIR', get_template_directory());
define('THEME_URL', get_template_directory_uri());
define('THEME_CSS_DIR', THEME_DIR.'/css');
define('THEME_CSS_URL', THEME_URL.'/css');
define('THEME_JS_DIR', THEME_DIR.'/js');
define('THEME_JS_URL', THEME_URL.'/js');

define('THEME_STYLESHEET_URL', get_bloginfo('stylesheet_url'));
define('THEME_STYLESHEET_FILE', THEME_DIR . '/style.css');

define('TW_FRAMEWORK_DIR', THEME_DIR . '/TW/Framework');
define('TW_FRAMEWORK_URL', THEME_URL . '/TW/Framework');
define('TW_ADMIN_DIR', THEME_DIR . '/TW/Admin');
define("TW_ADMIN_URL", THEME_URL . '/TW/Admin');

/*
*   Load Xpeed Studio FRAMEWORK.
*
*
*
*/

require_once (TW_FRAMEWORK_DIR.'/bootstrap_load.php');
require_once (TW_ADMIN_DIR.'/admin_load.php');

//=========================================
// Enqueue All Style 
//=========================================
function tw_font_url() 
{
	$font_url = '';
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'winter' ) ) 
        {
		$font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
	}
        return $font_url;
}
function enqueue_all_style()
{
    wp_enqueue_style( 'winter-lato', tw_font_url(), array(), null );
    wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.2' );
    wp_enqueue_style( 'tw-style', get_stylesheet_uri(), array( 'genericons' ) );
    wp_enqueue_style( 'tw-ie', get_template_directory_uri() . '/css/ie.css', array( 'winter-style', 'genericons' ), '20131205' );
    wp_style_add_data( 'tw-ie', 'conditional', 'lt IE 9' );
    wp_enqueue_style('bootstrap-css', get_template_directory_uri().'/TW/Assets/css/bootstrap.min.css');
    wp_enqueue_style('font-awesome', get_template_directory_uri().'/TW/Assets/css/font-awesome.min.css');
    wp_enqueue_style('animate-css', get_template_directory_uri().'/TW/Assets/css/animate.css');
    wp_enqueue_style('font-css', get_template_directory_uri().'/TW/Assets/css/font.css');
    wp_enqueue_style('pretty-photo', get_template_directory_uri().'/TW/Assets/css/prettyPhoto.css');
    wp_enqueue_style( 'typography-select', get_template_directory_uri().'/TW/Assets/css/typography.css');
    wp_enqueue_style( 'theme-css', get_template_directory_uri().'/TW/Assets/css/theme.css');
    wp_enqueue_style('custom-css', get_template_directory_uri().'/TW/Assets/css/custom.css');
}
add_action('wp_enqueue_scripts', 'enqueue_all_style');


//=========================================
// Enqueue all JS
//=========================================
function enqueue_all_script()
{
    wp_enqueue_script('wtp-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20131209', true );
    wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/TW/Assets/js/bootstrap.min.js', array( 'wtp-script' ), '23222', true );
    wp_enqueue_script('wptui-js', get_template_directory_uri().'/TW/Assets/js/jquery-ui-1.10.3.custom.min.js', array('bootstrap-js'), '', TRUE);
    //wp_enqueue_script('analitic-code', get_template_directory_uri().'/TW/Assets/js/analyticgoogle.js', array('wptui-js'), '', TRUE);
    wp_enqueue_script('pretty-photo', get_template_directory_uri().'/TW/Assets/js/jquery.prettyPhoto.js', array('wptui-js'), '', TRUE);
    wp_enqueue_script('google-api', 'http://maps.google.com/maps/api/js?sensor=true', array('pretty-photo'), '', TRUE);
    wp_enqueue_script('gmap-js', get_template_directory_uri().'/TW/Assets/js/gmaps.js', array('google-api'), '', TRUE);
    wp_enqueue_script('parallax-js', get_template_directory_uri().'/TW/Assets/js/jquery.parallax.js', array('gmap-js'), '', TRUE);
    wp_enqueue_script('isotop-js', get_template_directory_uri().'/TW/Assets/js/jquery.isotope.min.js', array('parallax-js'), '', TRUE);
    wp_enqueue_script('easypiechart-js', get_template_directory_uri().'/TW/Assets/js/jquery.easypiechart.min.js', array('isotop-js'), '', TRUE);
    wp_enqueue_script('appear-js', get_template_directory_uri().'/TW/Assets/js/jquery.appear.js', array('easypiechart-js'), '', TRUE);
    wp_enqueue_script('inview-js', get_template_directory_uri().'/TW/Assets/js/jquery.inview.min.js', array('appear-js'), '', TRUE);
    wp_enqueue_script('wow-js', get_template_directory_uri().'/TW/Assets/js/wow.min.js', array('inview-js'), '', TRUE);
    wp_enqueue_script('countTo-js', get_template_directory_uri().'/TW/Assets/js/jquery.countTo.js', array('wow-js'), '', TRUE);
    wp_enqueue_script('smooth-js', get_template_directory_uri().'/TW/Assets/js/smooth-scroll.js', array('countTo-js'), '', TRUE);
   // wp_enqueue_script('canvas-js', get_template_directory_uri().'/TW/Assets/js/smoothscroll.js', array('smooth-js'), '', TRUE);
    wp_enqueue_script('main-js', get_template_directory_uri().'/TW/Assets/js/main.js', array('smooth-js'), '', TRUE);
    
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_all_script');

//============================================
// Parallax Background
//============================================
if (class_exists('MoreThumb')) {
        new MoreThumb(
            array(
                'label' => 'Parallax Background',
                'id' => 'parallax-image',
                'post_type' => 'page'
            )
        );
    }


