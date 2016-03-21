<?php
add_action( 'init', 'register_carousel_post_type' );
function register_carousel_post_type() {
   register_post_type( 'slider',
		array(
			'labels' => array(
				'name'			=> __('Slider',"tw"),
				'singular_name' => __('Slider',"tw"),
				'add_new'		=> __('Add Slider Item',"tw"),
				'add_new_item'	=> __('Add Slider Item',"tw"),
				'edit_item'		=> __('Edit Slider Item',"tw"),
				'new_item'		=> __('New Slider Item',"tw"),
				'not_found'		=> __('No Slider Item found',"tw"),
				'not_found_in_trash' => __('No Slider Item found in Trash',"tw"),
				'menu_name'		=> __('Slider',"tw"),
			),
			'description' => 'Manipulating with our Carousel',
			'public' => true,
			'show_in_nav_menus' => true,
			'supports' => array(
				'title',
				'thumbnail',
				'editor',
				'page-attributes',
			),
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 31,
			'has_archive' => true,
                        'menu_icon' => 'dashicons-feedback',
			'query_var' => true,
			'rewrite' => array('slug' => 'slider'),
			'capability_type' => 'post',
			'map_meta_cap'=>true
			
		)
	);
	
	add_custom_taxonomies_carousel();
	flush_rewrite_rules(false);
}
function add_custom_taxonomies_carousel() {
	register_taxonomy('carousel_cat', 'slider', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x( 'Slider', 'taxonomy general name',"tw" ),
			'singular_name' => _x( 'Slider', 'taxonomy singular name' ,"tw"),
			'search_items' =>  __( 'Search Locations' ,"tw"),
			'all_items' => __( 'All Slider' ,"tw"),
			'parent_item' => __( 'Parent Location' ,"tw"),
			'parent_item_colon' => __( 'Parent Location:' ,"tw"),
			'edit_item' => __( 'Edit Location' ,"tw"),
			'update_item' => __( 'Update Slider' ,"tw"),
			'add_new_item' => __( 'Add New Slider' ,"tw"),
			'new_item_name' => __( 'New Slider' ,"tw"),
			'menu_name' => __( 'Slider Catagory' ,"tw"),
		),
		'rewrite' => array(
			'slug' => 'Slider', 
			'with_front' => false, 
			'hierarchical' => true 
		)
		
	));
}