<?php
add_action( 'init', 'register_team_post_type' );
function register_team_post_type() {
   register_post_type( 'team',
		array(
			'labels' => array(
				'name'			=> __('Our Team',"tw"),
				'singular_name' => __('Our Team',"tw"),
				'add_new'		=> __('Add Team Member',"tw"),
				'add_new_item'	=> __('Add Team Member',"tw"),
				'edit_item'		=> __('Edit Team Member',"tw"),
				'new_item'		=> __('New Team Member',"tw"),
				'not_found'		=> __('No Member found',"tw"),
				'not_found_in_trash' => __('No Team Member found in Trash',"tw"),
				'menu_name'		=> __('Our Team',"tw"),
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
			'menu_position' => 34,
			'has_archive' => true,
                        'menu_icon' => 'dashicons-feedback',
			'query_var' => true,
			'rewrite' => array('slug' => 'team'),
			'capability_type' => 'post',
			'map_meta_cap'=>true
			
		)
	);
	
	add_custom_taxonomies_team();
    flush_rewrite_rules(false);
}

function add_custom_taxonomies_team() {
    register_taxonomy('our_team', 'team', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x('Our Team', 'taxonomy general name', "tw"),
            'singular_name' => _x('Team', 'taxonomy singular name', "tw"),
            'search_items' => __('Search Locations', "tw"),
            'all_items' => __('All Team', "tw"),
            'parent_item' => __('Parent Location', "tw"),
            'parent_item_colon' => __('Parent Location:', "tw"),
            'edit_item' => __('Edit Location', "tw"),
            'update_item' => __('Update Team', "tw"),
            'add_new_item' => __('Add New Team', "tw"),
            'new_item_name' => __('New Team', "tw"),
            'menu_name' => __('Team Catagory', "tw"),
        ),
        'rewrite' => array(
            'slug' => 'team',
            'with_front' => false,
            'hierarchical' => true
        )
    ));
}