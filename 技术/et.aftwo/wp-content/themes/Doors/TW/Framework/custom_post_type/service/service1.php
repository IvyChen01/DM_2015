<?php

function register_service_post_types() {

    //register custom post

    function erica_custom_post() {
        register_post_type('accordion-items', array(
            'labels' => array(
                'name' => __('Accordion Items'),
                'singular_name' => __('Accordion Item')
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'custom-fields',),
            'has_archive' => true,
            'rewrite' => array('slug' => 'accordion-item'),
                )
        );
    }

    add_action('init', 'erica_custom_post');
}




add_action('init', 'register_service_post_type');

function register_service_post_type() {




    register_post_type('service', array(
        'labels' => array(
            'name' => __('Our Service', "tw"),
            'singular_name' => __('Our Service', "tw"),
            'add_new' => __('Add Service', "tw"),
            'add_new_item' => __('Add Service', "tw"),
            'edit_item' => __('Edit Service', "tw"),
            'new_item' => __('New Service', "tw"),
            'not_found' => __('No Service found', "tw"),
            'not_found_in_trash' => __('No Service found in Trash', "tw"),
            'menu_name' => __('Our Service', "tw"),
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
        'menu_position' => 33,
        'has_archive' => true,
        'menu_icon' => 'dashicons-feedback',
        'query_var' => true,
        'rewrite' => array('slug' => 'service'),
        'capability_type' => 'post',
        'map_meta_cap' => true
            )
    );

    add_custom_taxonomies_service();
    flush_rewrite_rules(false);
}

function add_custom_taxonomies_service() {
    register_taxonomy('service', 'service', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => _x('Service', 'taxonomy general name', "tw"),
            'singular_name' => _x('Service', 'taxonomy singular name', "tw"),
            'search_items' => __('Search Locations', "tw"),
            'all_items' => __('All Service', "tw"),
            'parent_item' => __('Parent Location', "tw"),
            'parent_item_colon' => __('Parent Location:', "tw"),
            'edit_item' => __('Edit Location', "tw"),
            'update_item' => __('Update Service', "tw"),
            'add_new_item' => __('Add New Service', "tw"),
            'new_item_name' => __('New Service', "tw"),
            'menu_name' => __('Service Catagory', "tw"),
        ),
        'rewrite' => array(
            'slug' => 'service',
            'with_front' => false,
            'hierarchical' => true
        )
    ));
}
