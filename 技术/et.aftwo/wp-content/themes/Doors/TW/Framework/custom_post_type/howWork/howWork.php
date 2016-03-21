<?php
add_action( 'init', 'register_howWork_post_type' );
function register_howWork_post_type() {
   register_post_type( 'howwork',
		array(
			'labels' => array(
				'name'			=> __('We Work',"tw"),
				'singular_name' => __('We Work',"tw"),
				'add_new'		=> __('Add Work Style',"tw"),
				'add_new_item'	=> __('Add Work Style',"tw"),
				'edit_item'		=> __('Edit Work Style',"tw"),
				'new_item'		=> __('New Work Style',"tw"),
				'not_found'		=> __('No Work Style found',"tw"),
				'not_found_in_trash' => __('No Work Style found in Trash',"tw"),
				'menu_name'		=> __('We Work',"tw"),
			),
			'description' => 'Manipulating with our How We Wrork',
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
			'menu_position' => 36,
			'has_archive' => true,
                        'menu_icon' => 'dashicons-feedback',
			'query_var' => true,
			'rewrite' => array('slug' => 'howwork'),
			'capability_type' => 'post',
			'map_meta_cap'=>true
			
		)
	);
	
	add_custom_taxonomies_howWork();
	flush_rewrite_rules(false);
}
function add_custom_taxonomies_howWork() {
	register_taxonomy('howwork', 'howwork', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x( 'We Work', 'taxonomy general name',"tw" ),
			'singular_name' => _x( 'We Work', 'taxonomy singular name' ,"tw"),
			'search_items' =>  __( 'Search Locations' ,"tw"),
			'all_items' => __( 'All Testimonial' ,"tw"),
			'parent_item' => __( 'Parent Location' ,"tw"),
			'parent_item_colon' => __( 'Parent Location:' ,"tw"),
			'edit_item' => __( 'Edit Location' ,"tw"),
			'update_item' => __( 'Update Work Style' ,"tw"),
			'add_new_item' => __( 'Add New Style' ,"tw"),
			'new_item_name' => __( 'New Style' ,"tw"),
			'menu_name' => __( 'Work Catagory' ,"tw"),
		),
		'rewrite' => array(
			'slug' => 'howwork', 
			'with_front' => false, 
			'hierarchical' => true 
		)
		
	));
}