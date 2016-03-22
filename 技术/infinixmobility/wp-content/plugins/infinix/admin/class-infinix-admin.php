<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://66beta.com
 * @since      1.0.0
 *
 * @package    Infinix
 * @subpackage Infinix/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Infinix
 * @subpackage Infinix/admin
 * @author     66beta <orion6sky@gmail.com>
 */
class Infinix_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


    private $display;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        add_action( 'admin_menu', array( $this, 'remove_menus') );

		add_action( 'init', array( $this, 'create_smartphone_post_type') );
		add_action( 'init', array( $this, 'create_acc_post_type') );
        add_action( 'init', array( $this, 'create_key_banner_post_type') );
        // add_action( 'init', array( $this, 'create_news_post_type') );

		add_action( 'init', array( $this, 'create_support_faq_post_type') );
        add_action( 'init', array( $this, 'create_support_warranty_post_type') );
        add_action( 'init', array( $this, 'create_support_update_post_type') );
        add_action( 'init', array( $this, 'create_support_manual_post_type') );
        add_action( 'init', array( $this, 'create_support_service_network_post_type') );

        add_action( 'init', array( $this, 'create_smartphone_acc_taxonomy') );

        add_action( 'save_post', array($this, 'save_smartphone_metabox') );
        add_action( 'save_post', array($this, 'save_acc_metabox') );
        add_action( 'save_post', array($this, 'save_key_banner_metabox') );
        // add_action( 'save_post', array($this, 'save_news_metabox') );

        add_action( 'save_post', array($this, 'save_support_faq_metabox') );
        add_action( 'save_post', array($this, 'save_support_warranty_metabox') );
        add_action( 'save_post', array($this, 'save_support_update_metabox') );
        add_action( 'save_post', array($this, 'save_support_manual_metabox') );
        add_action( 'save_post', array($this, 'save_support_service_network_metabox') );

        add_action( 'manage_faq_posts_custom_column',  array( $this, 'faq_table_content' ), 10, 2 );
        add_filter( 'manage_faq_posts_columns', array( $this, 'faq_table_head' ) );
        add_filter( 'manage_edit-faq_sortable_columns', array( $this, 'faq_table_sorting' ) );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Infinix_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Infinix_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/infinix-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Infinix_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Infinix_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        // wp_enqueue_script( 'jquery' );
        // wp_enqueue_script( 'jquery-ui-core' );
        // wp_enqueue_script( 'jquery-ui-widget' );
        // wp_enqueue_script( 'jquery-ui-mouse' );
        // wp_enqueue_script( 'jquery-ui-draggable' );
        // wp_enqueue_script( 'jquery-ui-slider' );
        // wp_enqueue_script( 'jquery-ui-sortable' );
        // wp_enqueue_script( 'jquery-ui-tabs' );
        wp_enqueue_media();
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/infinix-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function remove_menus() {
        // remove_menu_page('upload.php');
        remove_menu_page('tools.php');
        remove_menu_page('edit.php');
        // remove_menu_page('edit.php?post_type=page');
        remove_menu_page('edit-comments.php');
        remove_menu_page('plugins.php');
        remove_menu_page('users.php');
        remove_submenu_page( 'index.php', 'update-core.php' );
        remove_submenu_page( 'options-general.php', 'options-writing.php' );
        remove_submenu_page( 'options-general.php', 'options-discussion.php' );
        remove_submenu_page( 'options-general.php', 'options-reading.php' );
        remove_submenu_page( 'options-general.php', 'options-media.php' );
        // global $submenu;
        // unset($submenu['themes.php'][5]); //themes
        // unset($submenu['themes.php'][6]); //customize
        // unset($submenu['themes.php'][7]); //widgets
        //unset($submenu['themes.php'][10]); //menu
        // unset($submenu['themes.php'][15]); //header
        // unset($submenu['themes.php'][20]); //background
    }

	public function create_smartphone_post_type() {
        register_post_type(
            'smartphone',
            array(
                'label' => __( 'Smartphone' ),
                'labels' => array(
                    'name' => __( 'Smartphones' ),
                    'singular_name' => __( 'Smartphone' ),
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New Smartphone',
                    'edit_item' => 'Edit Smartphone',
                    'new_item' => 'New Smartphone',
                    'view_item' => 'View Smartphone',
                    'search_items' => 'Search Smartphones',
                    'not_found' => 'No Smartphones Found',
                    'not_found_in_trash' => 'No Smartphones Found in Trash',
                    ),
                'public' => true,
                'has_archive' => true,
                'menu_icon' => 'dashicons-phone',
                'supports' => array( 'title', /*'thumbnail', 'editor'*/ ),
                'rewrite' => array('slug' => 'smartphone'),
                'register_meta_box_cb' => array( $this, 'register_smartphone_metabox' ),
            )
         );
    }
    public function create_smartphone_acc_taxonomy() {
        register_taxonomy(
            'series',
            array('smartphone','acc'),
            array(
                'labels' => array(
                    'name' => 'Series',
                    'singular_name' => 'Series',
                    'search_items' =>  'Search Series',
                    'all_items' => 'All Series',
                    'parent_item' => 'Parent',
                    'parent_item_colon' => 'Parent:',
                    'edit_item' => 'Edit Series',
                    'update_item' => 'Update Series',
                    'add_new_item' => 'Add New Series',
                    'new_item_name' => 'New Series',
                    'menu_name' => 'Series',
                    ),
                'hierarchical' => true,
                'show_admin_column' => true,
                'public' => true,
                'show_ui' => true,
                'query_var' => true,
                'show_in_nav_menus' => false,
                'rewrite' => array( 'slug' => 'series', 'with_front' => false ),
            )
        );
    }

    public function create_acc_post_type() {
        register_post_type(
            'acc',
            array(
                'label' => __( 'Accessories' ),
                'labels' => array(
                    'name' => __( 'Accessories' ),
                    'singular_name' => __( 'Accessory' ),
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New Accessory',
                    'edit_item' => 'Edit Accessory',
                    'new_item' => 'New Accessory',
                    'view_item' => 'View Accessory',
                    'search_items' => 'Search Accessories',
                    'not_found' => 'No Accessories Found',
                    'not_found_in_trash' => 'No Accessories Found in Trash',
                    ),
                'public' => true,
                'has_archive' => true,
                'menu_icon' => 'dashicons-admin-links',
                'supports' => array( 'title', /*'editor', 'thumbnail'*/ ),
                'rewrite' => array('slug' => 'acc'),
                'register_meta_box_cb' => array( $this, 'register_acc_metabox' ),
            )
         );
    }

    public function create_support_faq_post_type() {
        register_post_type(
            'faq',
            array(
                'label' => __( 'FAQs' ),
                'labels' => array(
                    'name' => __( 'FAQs' ),
                    'singular_name' => __( 'FAQ' ),
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New FAQ',
                    'edit_item' => 'Edit FAQ',
                    'new_item' => 'New FAQ',
                    'view_item' => 'View FAQ',
                    'search_items' => 'Search FAQs',
                    'not_found' => 'No FAQs Found',
                    'not_found_in_trash' => 'No FAQs Found in Trash',
                    ),
                'public' => true,
                'has_archive' => true,
                'menu_icon' => 'dashicons-info',
                'supports' => array( 'title', 'page-attributes' ),
                'rewrite' => array('slug' => 'support/faq'),
                'register_meta_box_cb' => array( $this, 'register_support_faq_metabox' ),
            )
         );
    }

    public function create_support_warranty_post_type() {
        register_post_type(
            'warranty',
            array(
                'label' => __( 'Warranty' ),
                'labels' => array(
                    'name' => __( 'Warranty' ),
                    'singular_name' => __( 'Warranty' ),
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New Country',
                    'edit_item' => 'Edit Country',
                    'new_item' => 'New Country',
                    'view_item' => 'View Country',
                    'search_items' => 'Search Country',
                    'not_found' => 'No Country Found',
                    'not_found_in_trash' => 'No Country Found in Trash',
                    ),
                'public' => true,
                'has_archive' => false,
                'menu_icon' => 'dashicons-admin-tools',
                'supports' => array( 'title' ),
                // 'rewrite' => array('slug' => 'support/warranty'),
                'register_meta_box_cb' => array( $this, 'register_support_warranty_metabox' ),
            )
         );
    }

    public function create_support_service_network_post_type() {
        register_post_type(
            'service_network',
            array(
                'label' => __( 'Service Network' ),
                'labels' => array(
                    'name' => __( 'Service Network' ),
                    'singular_name' => __( 'Service Network' ),
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New Country',
                    'edit_item' => 'Edit Country',
                    'new_item' => 'New Country',
                    'view_item' => 'View Country',
                    'search_items' => 'Search Country',
                    'not_found' => 'No Country Found',
                    'not_found_in_trash' => 'No Country Found in Trash',
                    ),
                'public' => true,
                'has_archive' => true,
                'menu_icon' => 'dashicons-location-alt',
                'supports' => array( 'title', 'page-attributes' ),
                'rewrite' => array('slug' => 'support/service-network'),
                'register_meta_box_cb' => array( $this, 'register_support_service_network_metabox' ),
            )
        );
    }

    public function create_support_update_post_type() {
        register_post_type(
            'update',
            array(
                'label' => __( 'Updates' ),
                'labels' => array(
                    'name' => __( 'Updates' ),
                    'singular_name' => __( 'Phone' ),
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New Phone',
                    'edit_item' => 'Edit Phone',
                    'new_item' => 'New Phone',
                    'view_item' => 'View Phone',
                    'search_items' => 'Search Phone',
                    'not_found' => 'No Phone Found',
                    'not_found_in_trash' => 'No Phone Found in Trash',
                    ),
                'public' => true,
                'has_archive' => false,
                'menu_icon' => 'dashicons-update',
                'supports' => array( 'title' ),
                // 'rewrite' => array('slug' => 'support/service-network'),
                'register_meta_box_cb' => array( $this, 'register_support_update_metabox' ),
            )
        );
    }

    public function create_support_manual_post_type() {
        register_post_type(
            'manual',
            array(
                'label' => __( 'Manuals' ),
                'labels' => array(
                    'name' => __( 'Manuals' ),
                    'singular_name' => __( 'Phone' ),
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New Phone',
                    'edit_item' => 'Edit Phone',
                    'new_item' => 'New Phone',
                    'view_item' => 'View Phone',
                    'search_items' => 'Search Phone',
                    'not_found' => 'No Phone Found',
                    'not_found_in_trash' => 'No Phone Found in Trash',
                    ),
                'public' => true,
                'has_archive' => false,
                'menu_icon' => 'dashicons-media-text',
                'supports' => array( 'title' ),
                // 'rewrite' => array('slug' => 'support/service-network'),
                'register_meta_box_cb' => array( $this, 'register_support_manual_metabox' ),
            )
        );
    }

    public function create_key_banner_post_type() {
        register_post_type(
            'key_banner',
            array(
                'label' => 'Key Banner',
                'labels' => array(
                    'name' => 'Key Banner',
                    'singular_name' => 'Banner',
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New Banner',
                    'edit_item' => 'Edit Banner',
                    'new_item' => 'New Banner',
                    'view_item' => 'View Banner',
                    'search_items' => 'Search Banner',
                    'not_found' => 'No Banner Found',
                    'not_found_in_trash' => 'No Banner Found in Trash',
                    ),
                'public' => true,
                'has_archive' => false,
                'menu_icon' => 'dashicons-format-gallery',
                'supports' => array( 'title', 'page-attributes' ),
                'register_meta_box_cb' => array( $this, 'register_key_banner_metabox' ),
            )
        );
    }

    // public function create_news_post_type() {
    //     register_post_type(
    //         'news',
    //         array(
    //             'label' => 'News',
    //             'labels' => array(
    //                 'name' => 'News',
    //                 'singular_name' => 'News',
    //                 'add_new' => 'Add New',
    //                 'add_new_item' => 'Add News',
    //                 'edit_item' => 'Edit News',
    //                 'new_item' => 'New News',
    //                 'view_item' => 'View News',
    //                 'search_items' => 'Search News',
    //                 'not_found' => 'No News Found',
    //                 'not_found_in_trash' => 'No News Found in Trash',
    //                 ),
    //             'public' => true,
    //             'has_archive' => false,
    //             'menu_icon' => 'dashicons-megaphone',
    //             'supports' => array( 'title', 'page-attributes' ),
    //             'register_meta_box_cb' => array( $this, 'register_news_metabox' ),
    //         )
    //     );
    // }

    // public function register_news_metabox() {
    //     require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/infinix-admin-display.php';
    //     add_meta_box( 'news_metabox', 'News Thumb & Detail', 'display_news_metabox', 'news' );
    // }

    public function register_key_banner_metabox() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/infinix-admin-display.php';
        add_meta_box( 'key_banner_metabox', 'Banner Image & Url', 'display_key_banner_metabox', 'key_banner' );
    }

    public function register_support_service_network_metabox() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/infinix-admin-display.php';
        add_meta_box( 'support_flag_metabox', 'Country Flag', 'display_support_flag_metabox', 'service_network' );
        add_meta_box( 'support_service_network_metabox', 'Service Network by City', 'display_support_service_network_metabox', 'service_network' );
    }

    public function register_support_faq_metabox() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/infinix-admin-display.php';
        add_meta_box( 'support_faq_qa_metabox', 'Questions', 'display_support_faq_qa_metabox', 'faq' );
    }

    public function register_support_update_metabox() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/infinix-admin-display.php';
        add_meta_box( 'support_phone_photo_metabox', 'Phone Photo', 'display_support_phone_photo_metabox', 'update' );
        add_meta_box( 'support_update_metabox', 'Download Files', 'display_support_update_metabox', 'update' );
    }

    public function register_support_manual_metabox() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/infinix-admin-display.php';
        add_meta_box( 'support_phone_photo_metabox', 'Phone Photo', 'display_support_phone_photo_metabox', 'manual' );
        add_meta_box( 'support_manual_metabox', 'Download Files', 'display_support_manual_metabox', 'manual' );
    }

    public function register_support_warranty_metabox() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/infinix-admin-display.php';
        add_meta_box( 'support_flag_metabox', 'Country Flag', 'display_support_flag_metabox', 'warranty' );
        add_meta_box( 'support_warranty_metabox', 'Warranty by Country', 'display_support_warranty_metabox', 'warranty' );
    }

    public function register_smartphone_metabox() {

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/infinix-admin-display.php';

        // add_meta_box( 'postimagediv', 'KV Banner', 'post_thumbnail_meta_box', 'smartphone' );
        add_meta_box( 'smartphone_kv_metabox', 'KV Banner', 'display_smartphone_kv_metabox', 'smartphone' );
        add_meta_box( 'smartphone_selling_point_metabox', 'Selling Points', 'display_smartphone_selling_point_metabox', 'smartphone' );
        add_meta_box( 'smartphone_buy_link_metabox', 'Buy Links', 'display_smartphone_buy_link_metabox', 'smartphone' );
        add_meta_box( 'smartphone_photo_metabox', 'Photos', 'display_smartphone_photo_metabox', 'smartphone' );
        add_meta_box( 'smartphone_feature_metabox', 'Features', 'display_smartphone_feature_metabox', 'smartphone' );
        add_meta_box( 'smartphone_video_metabox', 'Video', 'display_smartphone_video_metabox', 'smartphone' );
    }

    public function save_smartphone_metabox( $post_id ) {
        global $post;
        // 验证随机数
        if (!isset($_POST['infinix_nonce']) || !wp_verify_nonce($_POST['infinix_nonce'], basename(__FILE__))) return $post_id;
        // 若为autosave、ajax、批量修改状态，则啥都不做
        if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) return $post_id;
        // 若只是个修订，则啥都不做
        if ( isset($post->post_type) && $post->post_type == 'revision' ) return $post_id;
        // 若无权限，则啥都不做
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // 更新kv
        if( isset($_POST['_kv']) ) {
            $kv = isset($_POST['_kv']) ? $_POST['_kv'] : array();
            update_post_meta( $post_id, '_kv', $kv );
        } else {
            delete_post_meta( $post_id, '_kv' );
        }
        // 更新sp
        if( isset($_POST['_sp']) ) {
            $sections = isset($_POST['_sp']) ? $_POST['_sp'] : array();
            update_post_meta( $post_id, '_sp', $sections );
        } else {
            delete_post_meta( $post_id, '_sp' );
        }
        // 更新buy
        if( isset($_POST['_buy']) ) {
            $links = isset($_POST['_buy']) ? $_POST['_buy'] : array();
            update_post_meta( $post_id, '_buy', $links );
        } else {
            delete_post_meta( $post_id, '_buy' );
        }
        // 更新photo
        if( isset($_POST['_photos']) ) {
            $photos = isset($_POST['_photos']) ? $_POST['_photos'] : array();
            update_post_meta( $post_id, '_photos', $photos );
        } else {
            delete_post_meta( $post_id, '_photos' );
        }
        // 更新feature
        if( isset($_POST['_features']) ) {
            $features = isset($_POST['_features']) ? $_POST['_features'] : array();
            update_post_meta( $post_id, '_features', $features );
        } else {
            delete_post_meta( $post_id, '_features' );
        }
        // 更新video
        if( isset($_POST['_video']) ) {
            $features = isset($_POST['_video']) ? $_POST['_video'] : array();
            update_post_meta( $post_id, '_video', $features );
        } else {
            delete_post_meta( $post_id, '_video' );
        }
    }


    public function register_acc_metabox() {

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/infinix-admin-display.php';

        add_meta_box( 'acc_kv_metabox', 'KV Banner', 'display_acc_kv_metabox', 'acc' );
        add_meta_box( 'acc_selling_point_metabox', 'Selling Points', 'display_acc_selling_point_metabox', 'acc' );
    }

    public function save_acc_metabox( $post_id ) {
        global $post;
        if (!isset($_POST['infinix_nonce']) || !wp_verify_nonce($_POST['infinix_nonce'], basename(__FILE__))) return $post_id;
        if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) return $post_id;
        if ( isset($post->post_type) && $post->post_type == 'revision' ) return $post_id;
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // 更新kv
        if( isset($_POST['_acc_kv']) ) {
            $data = isset($_POST['_acc_kv']) ? $_POST['_acc_kv'] : array();
            update_post_meta( $post_id, '_acc_kv', $data );
        } else {
            delete_post_meta( $post_id, '_acc_kv' );
        }
        // 更新sp
        if( isset($_POST['_acc_sp']) ) {
            $data = isset($_POST['_acc_sp']) ? $_POST['_acc_sp'] : array();
            update_post_meta( $post_id, '_acc_sp', $data );
        } else {
            delete_post_meta( $post_id, '_acc_sp' );
        }
    }

    public function save_support_faq_metabox( $post_id ) {
        global $post;
        if (!isset($_POST['infinix_nonce']) || !wp_verify_nonce($_POST['infinix_nonce'], basename(__FILE__))) return $post_id;
        if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) return $post_id;
        if ( isset($post->post_type) && $post->post_type == 'revision' ) return $post_id;
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // 更新qa
        if( isset($_POST['_qa']) ) {
            $data = isset($_POST['_qa']) ? $_POST['_qa'] : array();
            update_post_meta( $post_id, '_qa', $data );
        } else {
            delete_post_meta( $post_id, '_qa' );
        }
    }

    public function save_support_warranty_metabox( $post_id ) {
        global $post;
        if (!isset($_POST['infinix_nonce']) || !wp_verify_nonce($_POST['infinix_nonce'], basename(__FILE__))) return $post_id;
        if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) return $post_id;
        if ( isset($post->post_type) && $post->post_type == 'revision' ) return $post_id;
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // 更新warranty
        if( isset($_POST['_flag']) ) {
            $data = isset($_POST['_flag']) ? $_POST['_flag'] : array();
            update_post_meta( $post_id, '_flag', $data );
        } else {
            delete_post_meta( $post_id, '_flag' );
        }
        if( isset($_POST['_qa']) ) {
            $data = isset($_POST['_qa']) ? $_POST['_qa'] : array();
            update_post_meta( $post_id, '_qa', $data );
        } else {
            delete_post_meta( $post_id, '_qa' );
        }
    }

    public function save_support_update_metabox( $post_id ) {
        global $post;
        if (!isset($_POST['infinix_nonce']) || !wp_verify_nonce($_POST['infinix_nonce'], basename(__FILE__))) return $post_id;
        if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) return $post_id;
        if ( isset($post->post_type) && $post->post_type == 'revision' ) return $post_id;
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // 更新warranty
        if( isset($_POST['_phone_photo']) ) {
            $data = isset($_POST['_phone_photo']) ? $_POST['_phone_photo'] : '';
            update_post_meta( $post_id, '_phone_photo', $data );
        } else {
            delete_post_meta( $post_id, '_phone_photo' );
        }
        if( isset($_POST['_laptop']) ) {
            $data = isset($_POST['_laptop']) ? $_POST['_laptop'] : array();
            update_post_meta( $post_id, '_laptop', $data );
        } else {
            delete_post_meta( $post_id, '_laptop' );
        }
        if( isset($_POST['_tfcard']) ) {
            $data = isset($_POST['_tfcard']) ? $_POST['_tfcard'] : array();
            update_post_meta( $post_id, '_tfcard', $data );
        } else {
            delete_post_meta( $post_id, '_tfcard' );
        }
    }

    public function save_support_manual_metabox( $post_id ) {
        global $post;
        if (!isset($_POST['infinix_nonce']) || !wp_verify_nonce($_POST['infinix_nonce'], basename(__FILE__))) return $post_id;
        if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) return $post_id;
        if ( isset($post->post_type) && $post->post_type == 'revision' ) return $post_id;
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // 更新manual
        if( isset($_POST['_phone_photo']) ) {
            $data = isset($_POST['_phone_photo']) ? $_POST['_phone_photo'] : '';
            update_post_meta( $post_id, '_phone_photo', $data );
        } else {
            delete_post_meta( $post_id, '_phone_photo' );
        }
        if( isset($_POST['_manual']) ) {
            $data = isset($_POST['_manual']) ? $_POST['_manual'] : array();
            update_post_meta( $post_id, '_manual', $data );
        } else {
            delete_post_meta( $post_id, '_manual' );
        }
    }

    public function save_support_service_network_metabox( $post_id ) {
        global $post;
        if (!isset($_POST['infinix_nonce']) || !wp_verify_nonce($_POST['infinix_nonce'], basename(__FILE__))) return $post_id;
        if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) return $post_id;
        if ( isset($post->post_type) && $post->post_type == 'revision' ) return $post_id;
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
        // 更新sn
        if( isset($_POST['_flag']) ) {
            $data = isset($_POST['_flag']) ? $_POST['_flag'] : array();
            update_post_meta( $post_id, '_flag', $data );
        } else {
            delete_post_meta( $post_id, '_flag' );
        }
        if( isset($_POST['_sn']) ) {
            $data = isset($_POST['_sn']) ? $_POST['_sn'] : array();
            update_post_meta( $post_id, '_sn', $data );
        } else {
            delete_post_meta( $post_id, '_sn' );
        }
    }

    public function save_key_banner_metabox( $post_id ) {
        global $post;
        if (!isset($_POST['infinix_nonce']) || !wp_verify_nonce($_POST['infinix_nonce'], basename(__FILE__))) return $post_id;
        if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) return $post_id;
        if ( isset($post->post_type) && $post->post_type == 'revision' ) return $post_id;
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
        // 更新sn
        if( isset($_POST['_banner']) ) {
            $data = isset($_POST['_banner']) ? $_POST['_banner'] : array();
            update_post_meta( $post_id, '_banner', $data );
        } else {
            delete_post_meta( $post_id, '_banner' );
        }
    }

    // public function save_news_metabox( $post_id ) {
    //     global $post;
    //     if (!isset($_POST['infinix_nonce']) || !wp_verify_nonce($_POST['infinix_nonce'], basename(__FILE__))) return $post_id;
    //     if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) return $post_id;
    //     if ( isset($post->post_type) && $post->post_type == 'revision' ) return $post_id;
    //     if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
    //         if (!current_user_can('edit_page', $post_id)) {
    //             return $post_id;
    //         }
    //     } elseif (!current_user_can('edit_post', $post_id)) {
    //         return $post_id;
    //     }
    //     // 更新sn
    //     if( isset($_POST['_news']) ) {
    //         $data = isset($_POST['_news']) ? $_POST['_news'] : array();
    //         update_post_meta( $post_id, '_news', $data );
    //     } else {
    //         delete_post_meta( $post_id, '_news' );
    //     }
    // }


    //自定义列表头
    public function faq_table_head( $columns ){
        $new_columns = array();
        $i = 0;
        foreach( $columns as $key => $value ) {
            if( $key == 'title' ) {
                $new_columns[$key] = $value;
                $i++;
                $new_columns['order'] = 'Order';
            }
            $new_columns[$key] = $value;
            $i++;
        }
        return $new_columns;
    }

    //显示自定义列
    public function faq_table_content( $column, $post_id ){
        switch ( $column ) {
            case 'order':
                $order = get_post_field( 'menu_order', $post_id, 'raw' );
                echo $order;
                break;
        }
    }
    //自定义排序列
    public function faq_table_sorting( $columns ) {
        $columns['order'] = 'order';
        return $columns;
    }

}
