<?php
/**
* Infinix functions and definitions
*
* @package Infinix
*/

// update_option('siteurl','http://infinixmobility.com/fr/');
// update_option('home','http://infinixmobility.com/fr/');

remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_generator' );

remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );

remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

remove_action( 'wp_head', 'rel_canonical');
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

remove_action( 'wp_head', 'start_post_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

// add_filter( 'start_post_rel_link', 'disable_stuff' );
// add_filter( 'parent_post_rel_link', 'disable_stuff' );
// add_filter( 'index_rel_link', 'disable_stuff' );
// add_filter( 'previous_post_rel_link', 'disable_stuff' );
// add_filter( 'next_post_rel_link', 'disable_stuff' );
if ( ! function_exists( 'disable_stuff' ) ) :
    function disable_stuff( $data ) {
        return false;
    }
endif;

add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );

function dequeue_jquery_migrate( &$scripts){
    if(!is_admin()){
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ) );
    }
}


if ( ! function_exists( 'infinix_setup' ) ) :
    function infinix_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
	// register_nav_menus( array( 'primary' => esc_html__( 'Primary Menu', 'infinix' ), ) );
	// add_theme_support( 'html5', array( 'search-form' ) );
  }
endif; // infinix_setup
add_action( 'after_setup_theme', 'infinix_setup' );

// function infinix_widgets_init() {
// 	register_sidebar( array(
// 		'name'          => esc_html__( 'Sidebar', 'infinix' ),
// 		'id'            => 'sidebar-1',
// 		'description'   => '',
// 		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
// 		'after_widget'  => '</aside>',
// 		'before_title'  => '<h1 class="widget-title">',
// 		'after_title'   => '</h1>',
// 	) );
// }
// add_action( 'widgets_init', 'infinix_widgets_init' );

function infinix_body_classes( $classes ) {
    $cpt = get_query_var('post_type');
	if ($cpt=='smartphone') {
        $classes[] = get_query_var('smartphone');
    }
	return $classes;
}
add_filter( 'body_class', 'infinix_body_classes' );

if ( ! function_exists( 'theme_image_url' ) ) :
    function theme_image_url() {
        return "http://" . $_SERVER['SERVER_NAME'] . "/wp-content/uploads/themes/";
    }
endif;

function cpt_disable_redirect_post() {
    $queried_post_type = get_query_var('post_type');
    if ( is_single() && ('faq' ==  $queried_post_type || 'service_network' == $queried_post_type  || 'key_banner' == $queried_post_type ) ) {
        wp_redirect( home_url(), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'cpt_disable_redirect_post' );


//theme customize
function infinix_customize_register($wp_customize){
    //product 1
    $wp_customize->add_section('product_1', array('title' => 'Product Banner 1'));
    $wp_customize->add_setting('product_1_url', array(
        'default'    => '#',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control('product_1_url', array(
        'label'    => 'Url:',
        'section'  => 'product_1',
        'settings' => 'product_1_url',
    ));
    $wp_customize->add_setting('product_1_img', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'product_1_img', array(
        'label'    => 'Image(760x275):',
        'section'  => 'product_1',
        'settings' => 'product_1_img',
    )));
    //product 2
    $wp_customize->add_section('product_2', array('title' => 'Product Banner 2'));
    $wp_customize->add_setting('product_2_url', array(
        'default'    => '#',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control('product_2_url', array(
        'label'    => 'Url:',
        'section'  => 'product_2',
        'settings' => 'product_2_url',
    ));
    $wp_customize->add_setting('product_2_img', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'product_2_img', array(
        'label'    => 'Image(380x275):',
        'section'  => 'product_2',
        'settings' => 'product_2_img',
    )));
    //product 3
    $wp_customize->add_section('product_3', array('title' => 'Product Banner 3'));
    $wp_customize->add_setting('product_3_url', array(
        'default'    => '#',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control('product_3_url', array(
        'label'    => 'Url:',
        'section'  => 'product_3',
        'settings' => 'product_3_url',
    ));
    $wp_customize->add_setting('product_3_img', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'product_3_img', array(
        'label'    => 'Image(380x275):',
        'section'  => 'product_3',
        'settings' => 'product_3_img',
    )));
    //product 4
    $wp_customize->add_section('product_4', array('title' => 'Product Banner 4'));
    $wp_customize->add_setting('product_4_url', array(
        'default'    => '#',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control('product_4_url', array(
        'label'    => 'Url:',
        'section'  => 'product_4',
        'settings' => 'product_4_url',
    ));
    $wp_customize->add_setting('product_4_img', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'product_4_img', array(
        'label'    => 'Image(380x550):',
        'section'  => 'product_4',
        'settings' => 'product_4_img',
    )));
    //Design Story
    $wp_customize->add_section('design_story', array('title' => 'Design Story'));
    $wp_customize->add_setting('design_story_url', array(
        'default'    => '#',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control('design_story_url', array(
        'label'    => 'Url:',
        'section'  => 'design_story',
        'settings' => 'design_story_url',
    ));
    $wp_customize->add_setting('design_story_img', array(
        'default'    => '',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'design_story_img', array(
        'label'    => 'Image(760x300):',
        'section'  => 'design_story',
        'settings' => 'design_story_img',
    )));
    //SNS
    $wp_customize->add_section('sns', array('title' => 'SNS Accounts'));
    $wp_customize->add_setting('sns_facebook_url', array(
        'default'    => '#',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control('sns_facebook_url', array(
        'label'    => 'Facebook Url:',
        'section'  => 'sns',
        'settings' => 'sns_facebook_url',
    ));
    $wp_customize->add_setting('sns_youtube_url', array(
        'default'    => '#',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control('sns_youtube_url', array(
        'label'    => 'Youtube Url:',
        'section'  => 'sns',
        'settings' => 'sns_youtube_url',
    ));
    $wp_customize->add_setting('sns_twitter_url', array(
        'default'    => '#',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control('sns_twitter_url', array(
        'label'    => 'Twitter Url:',
        'section'  => 'sns',
        'settings' => 'sns_twitter_url',
    ));
    //support email
    $wp_customize->add_section('support_email', array('title' => 'Support Email'));
    $wp_customize->add_setting('support_email', array(
        'default'    => '#',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control('support_email', array(
        'label'    => 'Support Email:',
        'section'  => 'support_email',
        'settings' => 'support_email',
    ));
    //sns widget
    $wp_customize->add_section('sns_widget', array('title' => 'SNS Widget'));
    $wp_customize->add_setting('sns_widget_facebook_name', array(
        'default'    => '#',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control('sns_widget_facebook_name', array(
        'label'    => 'Facebook Account:',
        'section'  => 'sns_widget',
        'settings' => 'sns_widget_facebook_name',
    ));
    $wp_customize->add_setting('sns_widget_twitter_name', array(
        'default'    => '#',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control('sns_widget_twitter_name', array(
        'label'    => 'Twitter Account:',
        'section'  => 'sns_widget',
        'settings' => 'sns_widget_twitter_name',
    ));
    $wp_customize->add_setting('sns_widget_twitter_id', array(
        'default'    => '#',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    $wp_customize->add_control('sns_widget_twitter_id', array(
        'label'    => 'Twitter Widget ID:',
        'section'  => 'sns_widget',
        'settings' => 'sns_widget_twitter_id',
    ));
}
add_action('customize_register', 'infinix_customize_register');
