<?php
add_action( 'init', 'register_portfolio_post_type' );
function register_portfolio_post_type() {
   register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name'			=> __('Portfolio',"tw"),
				'singular_name' => __('Portfolio',"tw"),
				'add_new'		=> __('Add Portfolio',"tw"),
				'add_new_item'	=> __('Add Portfolio',"tw"),
				'edit_item'		=> __('Edit Portfolio',"tw"),
				'new_item'		=> __('New Portfolio',"tw"),
				'not_found'		=> __('No Portfolio found',"tw"),
				'not_found_in_trash' => __('No Portfoliofound in Trash',"tw"),
				'menu_name'		=> __('Portfolio',"tw"),
			),
			'description' => 'Manipulating with our team',
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
			'menu_position' => 32,
			'has_archive' => true,
                        'menu_icon' => 'dashicons-feedback',
			'query_var' => true,
			'rewrite' => array('slug' => 'portfolio'),
			'capability_type' => 'post',
			'map_meta_cap'=>true
			
		)
	);
	
	add_custom_taxonomies_portfolio();
	flush_rewrite_rules(false);
}
function add_custom_taxonomies_portfolio() {
	register_taxonomy('portfolio', 'portfolio', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x( 'Portfolio', 'taxonomy general name',"tw" ),
			'singular_name' => _x( 'Portfolio', 'taxonomy singular name' ,"tw"),
			'search_items' =>  __( 'Search Locations' ,"tw"),
			'all_items' => __( 'All Portfolio' ,"tw"),
			'parent_item' => __( 'Parent Location' ,"tw"),
			'parent_item_colon' => __( 'Parent Location:' ,"tw"),
			'edit_item' => __( 'Edit Location' ,"tw"),
			'update_item' => __( 'Update Portfolio' ,"tw"),
			'add_new_item' => __( 'Add New Portfolio' ,"tw"),
			'new_item_name' => __( 'New Portfolio' ,"tw"),
			'menu_name' => __( 'Portfolio Catagory' ,"tw"),
		),
		'rewrite' => array(
			'slug' => 'portfolio', 
			'with_front' => false, 
			'hierarchical' => true 
		)
		
	));
}