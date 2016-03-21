<?php

if (session_id() == '') {
    session_start();
}

/**
 * Doors Wordpress Theme
 * 
 * Doors only works in WordPress.
 */
//==============================
// WPML
//==============================

function return_default_lan($id) {
    if (function_exists('icl_object_id')) {
        $id = icl_object_id($id, 'page', true, 'en');
    }

    $post = get_post($id);
    return $post->post_name;
}

//==============================
// WP Title
//==============================

function doors_wp_title($title, $sep) {
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo('name');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page() )) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep " . sprintf(__('Page %s', 'tw'), max($paged, $page));
    }

    return $title;
}

add_filter('wp_title', 'doors_wp_title', 10, 2);


//==================================
// Custom template tags for this theme.
//==================================
require get_template_directory() . '/inc/template-tags.php';





//============================================
// Load Language
//============================================

load_theme_textdomain('tw', get_template_directory() . '/languages');

// ============================================================================================
// Enables theme custom post types, widget, Shortcodes
// --------------------------------------------------------------------------------------------
$custom_post_type = array('carousel' => 31, 'portfolio' => 32, 'service' => 33, 'features' => 34, 'team' => 35, 'testimonial' => 36, 'client' => 37);
$aitThemeWidgets = array('categorylist', 'popularpost', 'recentpost', 'twitterfeed');
$twThemePageShortcode = array('section', 'sectiontitle', 'columns', 'heading', 'subtitle', 'client', 'team', 'portfolio', 'testimonial', 'recentPost', 'googlemap', 'skill', 'pricing', 'service', 'counter', 'paragraph', 'carousel', 'textblock', 'timer', 'newslatter', 'twitter', 'images', 'contactdetails', 'contacttime', 'formating', 'typography', 'content', 'contactform', 'abdescribe');
/*
 * Load THEME WAR Bootstrap
 * 
 * 
 *  */
require dirname(__FILE__) . '/TW/tw-bootstrap.php';

//============================================
// Widget Settings
//============================================

function tw_widgets_init() {
    twRegisterWidgetAreas(array(
        'sidebar-1' => array('name' => __('Main Sidebar', 'tw')),
        'sidebar-2' => array('name' => __('Twitter Feed', 'tw')),
        'footer-widgets' => array(
            'name' => __('Footer Widget Area', 'tw'),
            'before_widget' => '<div id="%1$s" class="box widget-container %2$s"><div class="box-wrapper">',
            'after_widget' => "</div></div>",
            'before_title' => '<div class="title-border-bottom"><div class="title-border-top"><div class="title-decoration"></div><h2 class="widget-title">',
            'after_title' => '</h2></div></div>',
        ),
            ), array(
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>',
    ));
}

add_action('widgets_init', 'tw_widgets_init');

function doors_enquee_all_style() {
    wp_enqueue_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');
}

add_action('wp_enqueue_scripts', 'doors_enquee_all_style');

//=======================================
// Set View Counter
//=======================================
function doors_PostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count += 1;
        update_post_meta($postID, $count_key, $count);
    }
}

//============================================
// Action After Theme Setup
//============================================

function doors_themeSetup() {
    add_editor_style(array('css/editor-style.css', tw_font_url()));
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(740, 300, true);
    add_image_size('square-big', 635, 635, TRUE);
    add_image_size('square-xx', 535, 535, TRUE);
    add_image_size('square-mid', 335, 335, TRUE);
    add_image_size('square-small', 235, 235, TRUE);
    add_image_size('square-xsmall', 135, 135, TRUE);
    add_image_size('blog-thumb', 240, 355, TRUE);
    add_image_size('portfolio-large', 770, 516, TRUE);



    register_nav_menu('primary-menu', __('Primary Menu', 'winter-admin'));
    register_nav_menu('footer-menu', __('Footer Menu', 'winter-admin'));

    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list',));

    add_theme_support('post-formats', array());
}

add_action('after_setup_theme', 'doors_themeSetup');

//=========================================
// SET Content Width
//=========================================

if (!isset($content_width))
    $content_width = 1170;

//=========================================
// Custome Post Class
//=========================================
function doors_post_classes($classes) {
    if (!post_password_required() && has_post_thumbnail()) {
        $classes[] = 'has-post-thumbnail';
    }
    return $classes;
}

add_filter('post_class', 'doors_post_classes');

//=================================================
// Enable Page excerpt
//=================================================

add_action('init', 'doors_enable_page_excerpt');

function doors_enable_page_excerpt() {
    add_post_type_support('page', 'excerpt');
}

//=================================================
// Check Plugin Activity
//=================================================

function doors_themename_is_plugin_active($plugin) {
    return in_array($plugin, (array) get_option('active_plugins', array()));
}

//=====================================
// Script for Sicky Menu
//=====================================
function doors_inner_scripts() {
    wp_enqueue_script('doors-inner', get_template_directory_uri() . '/TW/Assets/js/inner_page_script.js', array('main-js'), '1.0.0', true);
}

function doors_front_scripts() {
    wp_enqueue_script('doors-front', get_template_directory_uri() . '/TW/Assets/js/front_page_script.js', array('main-js'), '1.0.0', true);
}

add_action('wp', 'doors_script_check_loadin');

function doors_script_check_loadin() {
    if (is_front_page() || is_home()) {
        add_action('wp_enqueue_scripts', 'doors_front_scripts');
    } else {
        add_action('wp_enqueue_scripts', 'doors_inner_scripts');
    }
}

//===========================================
// Color Preset Enqueue
//===========================================
function doors_color_enquee_all_style() {
    $color = get_option('presetcolor', false);
    if ($color != '') {
        wp_enqueue_style('color-preset', get_template_directory_uri() . '/TW/Assets/css/colors/' . $color . '.css');
    } else {
        wp_enqueue_style('color-preset', '');
    }
}

add_action('wp_enqueue_scripts', 'doors_color_enquee_all_style');

function enqueue_responsive_style() {

    wp_enqueue_style('responsive-css', get_template_directory_uri() . '/TW/Assets/css/responsive.css');
}

add_action('wp_enqueue_scripts', 'enqueue_responsive_style');


//=======================================
// Featured image box title
//=======================================

add_action('do_meta_boxes', 'doors_change_image_box');

function doors_change_image_box() {
    remove_meta_box('postimagediv', 'custom_post_type', 'side');
    add_meta_box('postimagediv', __('Slider Image'), 'post_thumbnail_meta_box', 'slider', 'side', 'low');
}

require_once 'inc/importer/bootstrap-importer.php';

//=========================================
// Menu Walker
//=========================================
if (!function_exists('Menu_Walker::start_el')) {


    class Menu_Walker extends Walker_Nav_Menu {

        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

            global $wp_query;

            $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            // add submenu class if current item is a top menu item
            $menu_link_class = '"';
            $bIsTopMenuItem = false;
            if (in_array("menu-item-has-children", $classes)) {

                $classes[] = 'dropdown';
                $menu_link_class = ' dropdown-toggle" data-toggle="dropdown"';
                $bIsTopMenuItem = true;
            }

            if ((in_array("current-menu-item", $classes)) || (in_array("current_page_item", $classes))) {

                $classes[] = 'active';
            }

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));


            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $atts = array();
            $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target) ? $item->target : '';
            $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';

            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            if ($item->object == 'page') {
                $page_post = get_post($item->object_id);
                $section_page = (get_post_meta($item->object_id, "doors_is_page_section", true) == 'yes');
                $disable_menu = (get_post_meta($item->object_id, "doors_menu_disable_page", true) == 'yes');
                $main_page_id = get_option('page_on_front');

                if (!$disable_menu || ( $page_post->ID == $main_page_id )) {

                    if (!$bIsTopMenuItem) {
                        if (!$section_page)
                            $attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
                        else {
                            if (is_front_page())
                                $attributes .= ' href="#' . return_default_lan($item->object_id) . '"';
                            else
                                $attributes .= ' href="' . home_url() . '#' . return_default_lan($item->object_id) . '"';
                        }
                    }

                    $item_output = $args->before;
                    if (!$bIsTopMenuItem) {
                        if ($section_page && is_front_page())
                            $item_output .= '<a class="collapse_menu1' . $menu_link_class . ' ' . $attributes . '>';
                        else
                            $item_output .= '<a class="external' . $menu_link_class . ' ' . $attributes . '>';
                    }
                    else {
                        $item_output .= '<a class="' . $menu_link_class . ' ' . $attributes . '>';
                    }

                    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
                    $item_output .= '</a>';
                    $item_output .= $args->after;

                    if ($section_page || ($page_post->ID == $main_page_id)) {
                        $class_names = $class_names ? ' class="scroll ' . esc_attr($class_names) . '"' : '';
                    } else {
                        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
                    }

                    $output .= $indent . '<li' . $id . $value . $class_names . '>';
                    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
                }
            } else {
                $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
                if (!$bIsTopMenuItem) {
                    $attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
                }

                $item_output = $args->before;
                $item_output .= '<a class="external' . $menu_link_class . ' ' . $attributes . '>';

                $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
                $item_output .= '</a>';
                $item_output .= $args->after;

                $output .= $indent . '<li' . $id . $value . $class_names . '>';
                $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
            }
        }

        function start_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"sub-menu dropdown-menu\">\n";
        }

    }

}
//===========================================
// Analytic Enqueue
//===========================================
if (get_option('google_tracking', false) != '') {
    add_action('wp_footer', 'google_analytic_hook_in_footer', 20);

    function google_analytic_hook_in_footer() {
        echo '<script teyp="text/javascript">';
        echo get_option('google_tracking', false);
        echo '</script>';
    }

}






