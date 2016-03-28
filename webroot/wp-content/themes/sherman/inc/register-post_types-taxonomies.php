<?php

/* --------------------------------------------
 *
 * Register content types and taxonomies
 *
 * -------------------------------------------- */

/**
 * register content types
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function sk_content_types(){


    // //
    // // - register post type that has page for archive and single
    // //
    // register_post_type('post_type', array(
    //     'labels'       => array(
    //         'name'               => __( 'post_type', 'sherman' ),
    //         'singular_name'      => __( 'post_type', 'sherman' ),
    //         'add_new_item'       => __( 'Add new post_type', 'sherman' ),
    //         'edit_item'          => __( 'Edit post_type', 'sherman' ),
    //         'new_item'           => __( 'New post_type', 'sherman' ),
    //         'view_item'          => __( 'View post_type', 'sherman' ),
    //         'search_items'       => __( 'Search post_types', 'sherman' ),
    //         'not_found'          => __( 'No post_types found', 'sherman' ),
    //         'not_found_in_trash' => __( 'No post_types found in Trash', 'sherman' ),
    //     ),
    //     'supports' => array('title', 'editor', 'thumbnail'),
    //     'public'   => true,
    //     'rewrite'  => array(
    //         'slug' => 'post_type'
    //     )
    // ));


    // //    
    // // - register post type with NO single page
    // //
    // register_post_type('post_type', array(
    //     'labels'       => array(
    //         'name'               => __( 'post_type', 'sherman' ),
    //         'singular_name'      => __( 'post_type', 'sherman' ),
    //         'add_new_item'       => __( 'Add new post_type', 'sherman' ),
    //         'edit_item'          => __( 'Edit post_type', 'sherman' ),
    //         'new_item'           => __( 'New post_type', 'sherman' ),
    //         'view_item'          => __( 'View post_type', 'sherman' ),
    //         'search_items'       => __( 'Search post_types', 'sherman' ),
    //         'not_found'          => __( 'No post_types found', 'sherman' ),
    //         'not_found_in_trash' => __( 'No post_types found in Trash', 'sherman' ),
    //     ),
    //     'show_ui' => true,
    // ));

    //
    // case studies (supports archive and single)
    //
    register_post_type('case_studies', array(
        'labels'       => array(
            'name'               => __( 'Case Studies', 'sherman' ),
            'singular_name'      => __( 'Case Study', 'sherman' ),
            'add_new_item'       => __( 'Add new Case Study', 'sherman' ),
            'edit_item'          => __( 'Edit Case Study', 'sherman' ),
            'new_item'           => __( 'New Case Study', 'sherman' ),
            'view_item'          => __( 'View Case Study', 'sherman' ),
            'search_items'       => __( 'Search Case Studies', 'sherman' ),
            'not_found'          => __( 'No Case Studies found', 'sherman' ),
            'not_found_in_trash' => __( 'No Case Studies found in Trash', 'sherman' ),
        ),
        'description'  => __( "Case studies for this company.", 'sherman' ),
        'supports'     => array('title', 'editor', 'thumbnail'),
        'public'       => true,
        'hierarchical' => false,
        'rewrite'      => array(
            'slug' => 'case-study'
        )
    ));


    //
    // Clients
    //
    register_post_type('clients', array(
        'labels'       => array(
            'name'               => __( 'Clients', 'sherman' ),
            'singular_name'      => __( 'Client', 'sherman' ),
            'add_new_item'       => __( 'Add new Client', 'sherman' ),
            'edit_item'          => __( 'Edit Client', 'sherman' ),
            'new_item'           => __( 'New Client', 'sherman' ),
            'view_item'          => __( 'View Client', 'sherman' ),
            'search_items'       => __( 'Search Clients', 'sherman' ),
            'not_found'          => __( 'No Clients found', 'sherman' ),
            'not_found_in_trash' => __( 'No Clients found in Trash', 'sherman' ),
        ),
        'description'  => __( "This company's clients.", 'sherman' ),
        'supports'     => array('title', 'editor', 'thumbnail'),
        'hierarchical' => false,
        'show_ui'      => true,
    ));


    //
    // Careers
    //
    register_post_type('careers', array(
        'labels'       => array(
            'name'               => __( 'Careers', 'sherman' ),
            'singular_name'      => __( 'Career', 'sherman' ),
            'add_new_item'       => __( 'Add new Career', 'sherman' ),
            'edit_item'          => __( 'Edit Career', 'sherman' ),
            'new_item'           => __( 'New Career', 'sherman' ),
            'view_item'          => __( 'View Career', 'sherman' ),
            'search_items'       => __( 'Search Careers', 'sherman' ),
            'not_found'          => __( 'No Careers found', 'sherman' ),
            'not_found_in_trash' => __( 'No Careers found in Trash', 'sherman' ),
        ),
        'description'  => __( "Available careers.", 'sherman' ),
        'supports'     => array('title', 'editor'),
        'public'       => true,
        'hierarchical' => false,
        'rewrite'      => array(
            'slug' => 'careers'
        )
    ));


    //
    // Team
    //
    register_post_type('team_members', array(
        'labels'       => array(
            'name'               => __( 'Team Members', 'sherman' ),
            'singular_name'      => __( 'Team Member', 'sherman' ),
            'add_new_item'       => __( 'Add new Team Member', 'sherman' ),
            'edit_item'          => __( 'Edit Team Member', 'sherman' ),
            'new_item'           => __( 'New Team Member', 'sherman' ),
            'view_item'          => __( 'View Team Member', 'sherman' ),
            'search_items'       => __( 'Search Team Members', 'sherman' ),
            'not_found'          => __( 'No Team Members found', 'sherman' ),
            'not_found_in_trash' => __( 'No Team Members found in Trash', 'sherman' ),
        ),
        'description'  => __( "The team.", 'sherman' ),
        'supports'     => array('title', 'editor', 'thumbnail'),
        'hierarchical' => false,
        'show_ui'      => true,
    ));


    //
    // about content
    //
    register_post_type('timeline_event', array(
        'labels'       => array(
            'name'               => __( 'Timeline Events', 'sherman' ),
            'singular_name'      => __( 'Timeline Event', 'sherman' ),
            'add_new_item'       => __( 'Add new Event', 'sherman' ),
            'edit_item'          => __( 'Edit Event', 'sherman' ),
            'new_item'           => __( 'New Event', 'sherman' ),
            'view_item'          => __( 'View Event', 'sherman' ),
            'search_items'       => __( 'Search Events', 'sherman' ),
            'not_found'          => __( 'No Events found', 'sherman' ),
            'not_found_in_trash' => __( 'No Events found in Trash', 'sherman' ),
        ),
        'description'  => __( "Timeline events in this company's history.", 'sherman' ),
        'supports'     => array('title', 'editor', 'thumbnail'),
        'hierarchical' => false,
        'show_ui'      => true,
    ));


    //
    // Services
    //
    register_post_type('services', array(
        'labels'       => array(
            'name'               => __( 'Services', 'sherman' ),
            'singular_name'      => __( 'Service', 'sherman' ),
            'add_new_item'       => __( 'Add new Service', 'sherman' ),
            'edit_item'          => __( 'Edit Service', 'sherman' ),
            'new_item'           => __( 'New Service', 'sherman' ),
            'view_item'          => __( 'View Service', 'sherman' ),
            'search_items'       => __( 'Search Services', 'sherman' ),
            'not_found'          => __( 'No Services found', 'sherman' ),
            'not_found_in_trash' => __( 'No Services found in Trash', 'sherman' ),
        ),
        'description'  => __("The services this company provides.", 'sherman'),
        'supports'     => array('title', 'editor'),
        'hierarchical' => false,
        'show_ui'      => true,
    ));

    //
    // Locations
    //
    register_post_type('locations', array(
        'labels'       => array(
            'name'               => __( 'Locations', 'sherman' ),
            'singular_name'      => __( 'Location', 'sherman' ),
            'add_new_item'       => __( 'Add new Location', 'sherman' ),
            'edit_item'          => __( 'Edit Location', 'sherman' ),
            'new_item'           => __( 'New Location', 'sherman' ),
            'view_item'          => __( 'View Location', 'sherman' ),
            'search_items'       => __( 'Search Locations', 'sherman' ),
            'not_found'          => __( 'No Locations found', 'sherman' ),
            'not_found_in_trash' => __( 'No Locations found in Trash', 'sherman' ),
        ),
        'description'  => __("The locations of this company.", 'sherman'),
        'supports'     => array('title', 'editor', 'thumbnail'),
        'hierarchical' => false,
        'show_ui'      => true,
        'rewrite'      => false
    ));
}
add_action('init', 'sk_content_types');


/**
 * register taxonomies
 *
 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function sk_taxonomies(){

    // //
    // // - register taxonomy
    // //
    // register_taxonomy('tax_name', array('related_post_type'), array(
    //     'labels'                => array(
    //         'name'                       => __( 'tax_name', 'sherman' ),
    //         'separate_items_with_commas' => __( 'Separate tax_name with commas', 'sherman' ),
    //         'choose_from_most_used'      => __( 'Choose from the most used tax_name', 'sherman' ),
    //     ),
    //     'hierarchical'          => false,
    //     'show_admin_column'     => true,
    //     'update_count_callback' => '_update_post_term_count'
    // ));
    // register_taxonomy_for_object_type( 'tax_name', 'related_post_type' );

}
add_action('init', 'sk_taxonomies');

