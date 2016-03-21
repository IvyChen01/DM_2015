<?php
add_action( 'init', 'register_testimonial_post_type' );
function register_testimonial_post_type() {
   register_post_type( 'testimonial',
		array(
			'labels' => array(
				'name'			=> __('Testimonial',"tw"),
				'singular_name' => __('Testimonial',"tw"),
				'add_new'		=> __('Add Testimonial',"tw"),
				'add_new_item'	=> __('Add Testimonial',"tw"),
				'edit_item'		=> __('Edit Testimonial',"tw"),
				'new_item'		=> __('New Testimonial',"tw"),
				'not_found'		=> __('No Testimonial found',"tw"),
				'not_found_in_trash' => __('No Testimonial found in Trash',"tw"),
				'menu_name'		=> __('Testimonial',"tw"),
			),
			'description' => 'Manipulating with our Testimonial',
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
			'menu_position' => 35,
			'has_archive' => true,
                        'menu_icon' => 'dashicons-feedback',
			'query_var' => true,
			'rewrite' => array('slug' => 'testimonial'),
			'capability_type' => 'post',
			'map_meta_cap'=>true
			
		)
	);
	
	
	flush_rewrite_rules(false);
}