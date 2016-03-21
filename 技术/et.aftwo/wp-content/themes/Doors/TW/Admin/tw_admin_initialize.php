<?php
/**
 * XpeedStudio WordPress Framework
 *
 * Copyright (c) 2014,  XpeedStudio, s.r.o. (http://XpeedStudio.com)
 */

//=================================
// Theme Option Menu
//=================================
add_action('admin_menu', 'tw_theme_menu');

function tw_theme_menu() {
	add_theme_page('Xpeed Studio Options', 'Doors Theme Option', 'edit_theme_options', 'tw_theme_option', 'tw_options');
}


function tw_options()
{
    require_once TW_ADMIN_DIR.'/script/options_settings.php';
}

function tw_frame_admin_enqueue()
{
    wp_enqueue_style( 'tw-option-style', get_template_directory_uri(). '/TW/Assets/css/optionFrameworkCss.css');
    wp_enqueue_style( 'tw-option-font', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');
    wp_enqueue_style( 'option-select', get_template_directory_uri().'/TW/Assets/css/rms_select.css');
    wp_enqueue_style( 'option-color', get_template_directory_uri().'/TW/Assets/css/colorpicker.css');
    wp_enqueue_style( 'tw_wp_admin_css', get_template_directory_uri() . '/TW/Assets/css/doors-admin-style.css');
    wp_enqueue_script('tw-cuostom-select-admin-js', get_template_directory_uri().'/TW/Assets/js/rms_select.js');
    wp_enqueue_script('tw-color-admin-js', get_template_directory_uri().'/TW/Assets/js/colorpicker.js');
    wp_enqueue_script('tw-drag-admin-js', get_template_directory_uri().'/TW/Assets/js/jquery.dragsort-0.5.2.min.js');
    wp_enqueue_script('tw-cuostom-admin-js', get_template_directory_uri().'/TW/Assets/js/admin_core.js');
}
add_action( 'admin_enqueue_scripts', 'tw_frame_admin_enqueue' );