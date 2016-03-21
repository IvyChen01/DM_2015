<?php
/**
 * xpeedstudio WordPress Framework
 *
 * Copyright (c) 2014, xpeedstudio ,(http://xpeedstudio.com)
 */
//===================================
// Generate Custom Post type
//===================================
if (isset($custom_post_type) && !empty($custom_post_type)) {
    foreach ($custom_post_type as $key => $val) {
        $cup_name = $key;
        $position = $val;
        global $position;
        require TW_FRAMEWORK_DIR . '/custom_post_type/' . $cup_name . '/' . $cup_name . '.php';
        unset($position);
    }
}

//===================================
// Admin Hook Variable
//===================================
function tw_custom_admin_head() {
    ?>
    <script type="text/javascript"> var url = '<?php get_template_directory_uri(); ?>';</script>
    <?php
}

add_action('admin_head', 'tw_custom_admin_head');

//===================================
// Generate Widget
//===================================

if (isset($aitThemeWidgets) && !empty($aitThemeWidgets)) {
    foreach ($aitThemeWidgets as $widget) {
        require TW_FRAMEWORK_DIR . '/widget/tw_' . $widget . '_widget.php';
    }
}

//======================================
// Load Widgets Areas
//======================================

function twRegisterWidgetAreas($areas, $defaultParams = array()) {
    if (empty($defaultParams)) {
        $defaultParams = array(
            'before_widget' => '<div id="%1$s" class="box widget-container %2$s"><div class="box-wrapper">',
            'after_widget' => "</div></div>",
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        );
    }

    foreach ($areas as $id => $area) {
        $params = array_merge($defaultParams, $area, array('id' => $id));
        register_sidebar($params);
    }
}

//======================================
// Activate Shortcode
//======================================

if (isset($twThemePageShortcode) && !empty($twThemePageShortcode)) {
    foreach ($twThemePageShortcode as $short) {
        require TW_FRAMEWORK_DIR . '/shortcodes/' . $short . '/load.php';
    }
}

//======================================
// Register Shortcode Buttons In TinyMce
//======================================

function register_button($buttons) {
    global $twThemePageShortcode;
    if (isset($twThemePageShortcode) && !empty($twThemePageShortcode)) {
        foreach ($twThemePageShortcode as $shortcode) {
            if ($shortcode == 'formating' || $shortcode == 'typography' || $shortcode == 'content'):
                array_push($buttons, "|", $shortcode);
            endif;
        }
    }
    return $buttons;
}

function add_plugin($plugin_array) {
    global $twThemePageShortcode;
    if (isset($twThemePageShortcode) && !empty($twThemePageShortcode)) {
        foreach ($twThemePageShortcode as $shortcode) {
            if ($shortcode == 'formating' || $shortcode == 'typography' || $shortcode == 'content'):
                $plugin_array[$shortcode] = TW_FRAMEWORK_URL . '/shortcodes/' . $shortcode . '/tw-' . $shortcode . '.js';
            endif;
        }
    }
    return $plugin_array;
}

function my_recent_posts_button() {

    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }

    if (get_user_option('rich_editing') == 'true') {
        add_filter('mce_external_plugins', 'add_plugin');
        add_filter('mce_buttons', 'register_button');
    }
}

add_action('init', 'my_recent_posts_button');

//===============================================
// Load Some Extras
//===============================================
require TW_FRAMEWORK_DIR . '/extras/extra_load.php';

//==============================================
// Make Widget Availabel In Shortcode
//==============================================
add_filter('widget_text', 'do_shortcode');






//==========================================
// Extra Shortcode Inclide
//==========================================


require_once (TW_FRAMEWORK_DIR . '/shortcodes/extra_shortcode.php');

require_once TW_FRAMEWORK_DIR . '/extras/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'doors_required_theme_notification');

function doors_required_theme_notification() {
    $plugins = array(
        array(
            'name' => 'xs-subscribe',
            'slug' => 'xs-subscribe',
            'source' => get_template_directory_uri() . '/inc/plugins/xs-subscribe.zip',
            'required' => true,
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => 'Social Sharing Toolkit',
            'slug' => 'social-sharing-toolkit',
            'source' => get_template_directory_uri() . '/inc/plugins/social-sharing-toolkit.zip',
            'required' => true,
            'external_url' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
        array(
            'name' => 'WP User Avatar',
            'slug' => 'wp-user-avatar',
            'source' => get_template_directory_uri() . '/inc/plugins/wp-user-avatar.zip',
            'required' => false,
        ),
    );

    $config = array(
        'default_path' => '',
        'menu' => 'tgmpa-install-plugins',
        'has_notices' => true,
        'dismissable' => true,
        'dismiss_msg' => '',
        'is_automatic' => false,
        'message' => '',
        'strings' => array(
            'page_title' => __('Install Required Plugins', 'tgmpa'),
            'menu_title' => __('Install Plugins', 'tgmpa'),
            'installing' => __('Installing Plugin: %s', 'tgmpa'),
            'oops' => __('Something went wrong with the plugin API.', 'tgmpa'),
            'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.'), // %1$s = plugin name(s).
            'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.'), // %1$s = plugin name(s).
            'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.'), // %1$s = plugin name(s).
            'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.'), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.'), // %1$s = plugin name(s).
            'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.'), // %1$s = plugin name(s).
            'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.'), // %1$s = plugin name(s).
            'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.'), // %1$s = plugin name(s).
            'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins'),
            'activate_link' => _n_noop('Begin activating plugin', 'Begin activating plugins'),
            'return' => __('Return to Required Plugins Installer', 'tgmpa'),
            'plugin_activated' => __('Plugin activated successfully.', 'tgmpa'),
            'complete' => __('All plugins installed and activated successfully. %s', 'tgmpa'), // %s = dashboard link.
            'nag_type' => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa($plugins, $config);
}

function twitter_feed_shortcode() {
    ob_start();
    dynamic_sidebar('sidebar-2');
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}

add_shortcode('tw-twitter-feed-slide', 'twitter_feed_shortcode');


