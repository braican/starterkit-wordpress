<?php

/* --------------------------------------------
 * --register content types and taxonomies
 * -------------------------------------------- */

/**
 * register content types
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function _s_content_types(){


    // //
    // // - register post type that has page for archive and single
    // //
    // register_post_type('post_type', array(
    //     'labels'   => array(
    //         'name'         => 'post_type',
    //         'add_new_item' => 'Add new post_type',
    //         'edit_item'    => 'Edit post_type'
    //     ),
    //     'supports' => array('title', 'editor', 'thumbnail'),
    //     'public'   => true,
    //     'rewrite'  => array(
    //         'slug' => 'post_type'
    //     )
    // ));


    //
    // - register post type with NO single page
    //
    // register_post_type('post_type', array(
    //     'labels'  => array(
    //         'name'         => 'post_type',
    //         'add_new_item' => 'Add new post_type',
    //         'edit_item'    => 'Edit post_type'
    //     ),
    //     'show_ui' => true,
    // ));

    //
    // case studies (supports archive and single)
    //
    register_post_type('case_studies', array(
        'labels'       => array(
            'name'               => 'Case Studies',
            'singular_name'      => 'Case Study',
            'add_new_item'       => 'Add new Case Study',
            'edit_item'          => 'Edit Case Study',
            'new_item'           => 'New Case Study',
            'view_item'          => 'View Case Study',
            'search_items'       => 'Search Case Studies',
            'not_found'          => 'No Case Studies found',
            'not_found_in_trash' => 'No Case Studies found in Trash',
        ),
        'description'  => "Case studies for this company.",
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
            'name'               => 'Clients',
            'singular_name'      => 'Client',
            'add_new_item'       => 'Add new Client',
            'edit_item'          => 'Edit Client',
            'new_item'           => 'New Client',
            'view_item'          => 'View Client',
            'search_items'       => 'Search Clients',
            'not_found'          => 'No Clients found',
            'not_found_in_trash' => 'No Clients found in Trash',
        ),
        'description'  => "This company's clients.",
        'supports'     => array('title', 'editor', 'thumbnail'),
        'hierarchical' => false,
        'show_ui'      => true,
    ));


    //
    // Careers
    //
    register_post_type('careers', array(
        'labels'       => array(
            'name'               => 'Careers',
            'singular_name'      => 'Career',
            'add_new_item'       => 'Add new Career',
            'edit_item'          => 'Edit Career',
            'new_item'           => 'New Career',
            'view_item'          => 'View Career',
            'search_items'       => 'Search Careers',
            'not_found'          => 'No Careers found',
            'not_found_in_trash' => 'No Careers found in Trash',
        ),
        'description'  => "Available careers.",
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
            'name'               => 'Team Members',
            'singular_name'      => 'Team Member',
            'add_new_item'       => 'Add new Team Member',
            'edit_item'          => 'Edit Team Member',
            'new_item'           => 'New Team Member',
            'view_item'          => 'View Team Member',
            'search_items'       => 'Search Team Members',
            'not_found'          => 'No Team Members found',
            'not_found_in_trash' => 'No Team Members found in Trash',
        ),
        'description'  => "The team.",
        'supports'     => array('title', 'editor', 'thumbnail'),
        'hierarchical' => false,
        'show_ui'      => true,
    ));


    //
    // about content
    //
    register_post_type('timeline_event', array(
        'labels'       => array(
            'name'               => 'Timeline Events',
            'singular_name'      => 'Timeline Event',
            'add_new_item'       => 'Add new Event',
            'edit_item'          => 'Edit Event',
            'new_item'           => 'New Event',
            'view_item'          => 'View Event',
            'search_items'       => 'Search Events',
            'not_found'          => 'No Events found',
            'not_found_in_trash' => 'No Events found in Trash',
        ),
        'description'  => "Timeline events in this company's history.",
        'supports'     => array('title', 'editor', 'thumbnail'),
        'hierarchical' => false,
        'show_ui'      => true,
    ));


    //
    // Services
    //
    register_post_type('services', array(
        'labels'       => array(
            'name'               => 'Services',
            'singular_name'      => 'Service',
            'add_new_item'       => 'Add new Service',
            'edit_item'          => 'Edit Service',
            'new_item'           => 'New Service',
            'view_item'          => 'View Service',
            'search_items'       => 'Search Services',
            'not_found'          => 'No Services found',
            'not_found_in_trash' => 'No Services found in Trash',
        ),
        'description'  => "The services this company provides.",
        'supports'     => array('title', 'editor'),
        'hierarchical' => false,
        'show_ui'      => true,
    ));
}
add_action('init', '_s_content_types');


/**
 * register taxonomies
 *
 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function _s_taxonomies(){

    // //
    // // - register taxonomy
    // //
    // register_taxonomy('tax_name', array('related_post_type'), array(
    //     'labels'                => array(
    //         'name'                       => 'tax_name',
    //         'separate_items_with_commas' => 'Separate tax_name with commas',
    //         'choose_from_most_used'      => 'Choose from the most used tax_name'
    //     ),
    //     'hierarchical'          => false,
    //     'update_count_callback' => '_update_post_term_count'
    // ));
    // register_taxonomy_for_object_type( 'tax_name', 'related_post_type' );

}
add_action('init', '_s_taxonomies');

