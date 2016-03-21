<?php
add_action( 'init', 'register_features_post_type' );
function register_features_post_type() {
   register_post_type( 'features',
		array(
			'labels' => array(
				'name'			=> __('Our Features',"tw"),
				'singular_name' => __('Our Features',"tw"),
				'add_new'		=> __('Add Features',"tw"),
				'add_new_item'	=> __('Add features',"tw"),
				'edit_item'		=> __('Edit Features',"tw"),
				'new_item'		=> __('New Features',"tw"),
				'not_found'		=> __('No Features found',"tw"),
				'not_found_in_trash' => __('No Features found in Trash',"tw"),
				'menu_name'		=> __('Our Features',"tw"),
			),
			'description' => 'Manipulating with our Features',
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
			'menu_position' => 33,
			'has_archive' => true,
                        'menu_icon' => 'dashicons-feedback',
			'query_var' => true,
			'rewrite' => array('slug' => 'features'),
			'capability_type' => 'post',
			'map_meta_cap'=>true
			
		)
	);
	
	flush_rewrite_rules(false);
}
