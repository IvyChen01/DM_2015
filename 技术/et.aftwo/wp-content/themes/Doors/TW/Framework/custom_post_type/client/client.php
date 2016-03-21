<?php
add_action( 'init', 'register_client_post_type' );
function register_client_post_type() {
   register_post_type( 'client',
		array(
			'labels' => array(
				'name'			=> __('Our Client',"tw"),
				'singular_name' => __('Our Client',"tw"),
				'add_new'		=> __('Add Client',"tw"),
				'add_new_item'	=> __('Add Client',"tw"),
				'edit_item'		=> __('Edit Client',"tw"),
				'new_item'		=> __('New Client',"tw"),
				'not_found'		=> __('No Client found',"tw"),
				'not_found_in_trash' => __('No Client found in Trash',"tw"),
				'menu_name'		=> __('Our Client',"tw"),
			),
			'description' => 'Manipulating with our Client',
			'public' => true,
			'show_in_nav_menus' => true,
			'supports' => array(
				'title',
				'thumbnail',
				'editor' => false,
				'page-attributes' => false,
			),
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 37,
			'has_archive' => true,
                        'menu_icon' => 'dashicons-feedback',
			'query_var' => true,
			'rewrite' => array('slug' => 'client'),
			'capability_type' => 'post',
			'map_meta_cap'=>true
			
		)
	);
	
add_custom_taxonomies_client();
    flush_rewrite_rules(false);
}

function add_custom_taxonomies_client() {
    register_taxonomy('our_client', 'client', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x('Our clients', 'taxonomy general name', "tw"),
            'singular_name' => _x('client', 'taxonomy singular name', "tw"),
            'search_items' => __('Search Locations', "tw"),
            'all_items' => __('All client', "tw"),
            'parent_item' => __('Parent Location', "tw"),
            'parent_item_colon' => __('Parent Location:', "tw"),
            'edit_item' => __('Edit Location', "tw"),
            'update_item' => __('Update client', "tw"),
            'add_new_item' => __('Add New client category', "tw"),
            'new_item_name' => __('New Team', "tw"),
            'menu_name' => __('Client Catagory', "tw"),
        ),
        'rewrite' => array(
            'slug' => 'client',
            'with_front' => false,
            'hierarchical' => true
        )
    ));
}