<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://66beta.com
 * @since      1.0.0
 *
 * @package    Infinix
 * @subpackage Infinix/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Infinix
 * @subpackage Infinix/public
 * @author     66beta <orion6sky@gmail.com>
 */
class Infinix_Public {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'wp_ajax_support_update_phone_list', array($this, 'support_update_phone_list_callback') );
		add_action( 'wp_ajax_nopriv_support_update_phone_list', array($this, 'support_update_phone_list_callback') );
		add_action( 'wp_ajax_support_update_phone', array($this, 'support_update_phone_callback') );
		add_action( 'wp_ajax_nopriv_support_update_phone', array($this, 'support_update_phone_callback') );

		add_action( 'wp_ajax_support_manual_phone_list', array($this, 'support_manual_phone_list_callback') );
		add_action( 'wp_ajax_nopriv_support_manual_phone_list', array($this, 'support_manual_phone_list_callback') );
		add_action( 'wp_ajax_support_manual_phone', array($this, 'support_manual_phone_callback') );
		add_action( 'wp_ajax_nopriv_support_manual_phone', array($this, 'support_manual_phone_callback') );

		add_action( 'wp_ajax_support_service_network_location_list', array($this, 'support_service_network_location_list_callback') );
		add_action( 'wp_ajax_nopriv_support_service_network_location_list', array($this, 'support_service_network_location_list_callback') );
		add_action( 'wp_ajax_support_service_network_city', array($this, 'support_service_network_city_callback') );
		add_action( 'wp_ajax_nopriv_support_service_network_city', array($this, 'support_service_network_city_callback') );

		add_action( 'wp_ajax_support_faq', array($this, 'support_faq_callback') );
		add_action( 'wp_ajax_nopriv_support_faq', array($this, 'support_faq_callback') );

		add_action( 'wp_ajax_support_warranty_location_list', array($this, 'support_warranty_location_list_callback') );
		add_action( 'wp_ajax_nopriv_support_warranty_location_list', array($this, 'support_warranty_location_list_callback') );
		add_action( 'wp_ajax_support_warranty', array($this, 'support_warranty_callback') );
		add_action( 'wp_ajax_nopriv_support_warranty', array($this, 'support_warranty_callback') );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/infinix-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/infinix-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'ajax_x', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( $this->plugin_name ),
		) );
	}

	public function support_update_phone_list_callback() {
		check_ajax_referer( $this->plugin_name );

		$query = new WP_Query( array(
			'post_type' => 'update',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => 1000
			) );
		$json = array();
		if ( count($query->posts) >0 ) {
			$json['result'] = true;
			foreach ($query->posts as $phone) {
				$json['data'][] = array(
					'id' => $phone->ID,
					'name' => $phone->post_title
				);
			}
		} else {
			$json['result'] = false;
		}
		wp_send_json($json);
		wp_die();
	}

	public function support_manual_phone_list_callback() {
		check_ajax_referer( $this->plugin_name );

		$query = new WP_Query( array(
			'post_type' => 'manual',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => 1000
			) );
		$json = array();
		if ( count($query->posts) >0 ) {
			$json['result'] = true;
			foreach ($query->posts as $phone) {
				$json['data'][] = array(
					'id' => $phone->ID,
					'name' => $phone->post_title
				);
			}
		} else {
			$json['result'] = false;
		}
		wp_send_json($json);
		wp_die();
	}

	public function support_manual_phone_callback() {
		check_ajax_referer( $this->plugin_name );

		$image = get_post_meta( $_POST['post_id'], '_phone_photo', true );
		$manual = get_post_meta( $_POST['post_id'], '_manual', true );
		$json = array();
		if ( $manual ) {
			$json['result'] = true;
			$json['image'] = $image;
			$json['manual'] = $manual;
		} else {
			$json['result'] = false;
		}
		wp_send_json($json);
		wp_die();
	}

	public function support_service_network_location_list_callback() {
		check_ajax_referer( $this->plugin_name );

		$query = new WP_Query( array(
			'post_type' => 'service_network',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => 1000
			) );
		$json = array();
		if ( count($query->posts) >0 ) {
			$json['result'] = true;
			$index = 1;
			foreach ($query->posts as $country) {
				$city = get_post_meta( $country->ID, '_sn', true );
				$json['data'][] = array(
					'id' => $country->ID,
					'name' => $country->post_title,
					'city' => $city,
					'index' => $index++
				);
			}
		} else {
			$json['result'] = false;
		}
		wp_send_json($json);
		wp_die();
	}

	public function support_update_phone_callback() {
		check_ajax_referer( $this->plugin_name );

		$image = get_post_meta( $_POST['post_id'], '_phone_photo', true );
		$laptop = get_post_meta( $_POST['post_id'], '_laptop', true );
		$tfcard = get_post_meta( $_POST['post_id'], '_tfcard', true );
		$json = array();
		if ( $laptop || $tfcard ) {
			$json['result'] = true;
			$json['image'] = $image;
			$json['laptop'] = $laptop;
			$json['tfcard'] = $tfcard;
		} else {
			$json['result'] = false;
		}
		wp_send_json($json);
		wp_die();
	}

	public function support_service_network_city_callback() {
		check_ajax_referer( $this->plugin_name );

		$id = $_POST['post_id'];
		$city = $_POST['city'];

		$query = get_post_meta( $id, '_sn', true );
		$json = array();
		if ( $query ) {
			foreach ($query as $item) {
				if ($item['city'] == $city) {
					$json['result'] = true;
					$json['country'] = get_the_title($id);
					$json['data'] = $item;
					$json['flag'] = get_post_meta( $id, '_flag', true );
					wp_send_json($json);
					wp_die();
				}
			}

		}
		$json['result'] = false;
		wp_send_json($json);
		wp_die();
	}

	public function support_faq_callback() {
		check_ajax_referer( $this->plugin_name );

		$query = new WP_Query( array(
			'post_type' => 'faq',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => 1000
			) );
		$json = array();
		if ( count($query->posts) >0 ) {
			$json['result'] = true;
			$index = 1;
			foreach ($query->posts as $item) {
				$qa = get_post_meta( $item->ID, '_qa', true );
				$json['title'][] = array(
					'title' => $item->post_title,
					'index' => $index
				);
				$json['content'][] = array(
					'qa' => $qa,
					'index' => $index++
				);
			}
		} else {
			$json['result'] = false;
		}
		wp_send_json($json);
		wp_die();
	}

	public function support_warranty_location_list_callback() {
		check_ajax_referer( $this->plugin_name );

		$query = new WP_Query( array(
			'post_type' => 'warranty',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => 1000
			) );
		$json = array();
		if ( count($query->posts) >0 ) {
			$json['result'] = true;
			foreach ($query->posts as $item) {
				$json['data'][] = array(
					'id' => $item->ID,
					'country' => $item->post_title,
				);
			}
		} else {
			$json['result'] = false;
		}
		wp_send_json($json);
		wp_die();
	}

	public function support_warranty_callback() {
		check_ajax_referer( $this->plugin_name );

		$id = $_POST['post_id'];
		$query = get_post_meta( $id, '_qa', true );
		$json = array();
		if ( $query ) {
			$json['result'] = true;
			$json['flag'] = get_post_meta( $id, '_flag', true );
			$json['country'] = get_the_title($id);
			$json['data'] = $query;
		} else {
			$json['result'] = false;
		}
		wp_send_json($json);
		wp_die();
	}

}
