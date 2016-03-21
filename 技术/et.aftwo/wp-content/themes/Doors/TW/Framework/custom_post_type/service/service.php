<?php

function register_service_post_types() {

    //register custom post

  
        register_post_type('service', array(
            'labels' => array(
                'name' => __('Our Service'),
                'singular_name' => __('Our Service')
            ),
            'public' => true,
            'supports' => array(
            'title',
                'thumbnail',
                'editor',
                'page-attributes',
            ),
            'has_archive' => true,
            'show_in_menu' => true,
            'menu_position' => 33,
            'rewrite' => array('slug' => 'our-service'),
                )
        );
   

   
}
 add_action('init', 'register_service_post_types');


function service_post_taxonomy() {
    register_taxonomy(
            'service-category', //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
            'service', //post type name. must be match with register custom post.
            array(
        'hierarchical' => true,
        'label' => 'Service Category', //Display name
        'query_var' => true,
        'show_admin_column' => true,
        'rewrite' => array(
            'slug' => 'service-category', // This controls the base slug that will display before each term
            'with_front' => true // Don't display the category base before
        )
            )
    );
}
 
add_action('init', 'service_post_taxonomy');



//
//
//add_action('init', 'register_service_post_type');
//
//function register_service_post_type() {
//
//
//
//
//    register_post_type('service', array(
//        'labels' => array(
//            'name' => __('Our Service', "tw"),
//            'singular_name' => __('Our Service', "tw"),
//            'add_new' => __('Add Service', "tw"),
//            'add_new_item' => __('Add Service', "tw"),
//            'edit_item' => __('Edit Service', "tw"),
//            'new_item' => __('New Service', "tw"),
//            'not_found' => __('No Service found', "tw"),
//            'not_found_in_trash' => __('No Service found in Trash', "tw"),
//            'menu_name' => __('Our Service', "tw"),
//        ),
//        'description' => 'Manipulating with our team',
//        'public' => true,
//        'show_in_nav_menus' => true,
//        'supports' => array(
//            'title',
//            'thumbnail',
//            'editor',
//            'page-attributes',
//        ),
//        'show_ui' => true,
//        'show_in_menu' => true,
//        'menu_position' => 33,
//        'has_archive' => true,
//        'menu_icon' => 'dashicons-feedback',
//        'query_var' => true,
//        'rewrite' => array('slug' => 'service'),
//        'capability_type' => 'post',
//        'map_meta_cap' => true
//            )
//    );
//
//    add_custom_taxonomies_service();
//    flush_rewrite_rules(false);
//}
//
//function add_custom_taxonomies_service() {
//    register_taxonomy('service', 'service', array(
//        'hierarchical' => true,
//        'labels' => array(
//            'name' => _x('Service', 'taxonomy general name', "tw"),
//            'singular_name' => _x('Service', 'taxonomy singular name', "tw"),
//            'search_items' => __('Search Locations', "tw"),
//            'all_items' => __('All Service', "tw"),
//            'parent_item' => __('Parent Location', "tw"),
//            'parent_item_colon' => __('Parent Location:', "tw"),
//            'edit_item' => __('Edit Location', "tw"),
//            'update_item' => __('Update Service', "tw"),
//            'add_new_item' => __('Add New Service', "tw"),
//            'new_item_name' => __('New Service', "tw"),
//            'menu_name' => __('Service Catagory', "tw"),
//        ),
//        'rewrite' => array(
//            'slug' => 'service',
//            'with_front' => false,
//            'hierarchical' => true
//        )
//    ));
//}
