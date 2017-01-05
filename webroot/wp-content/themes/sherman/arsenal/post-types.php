<?php

/* --------------------------------------------
 *
 * Register post types
 *
 * -------------------------------------------- */
    
    //
    // @link http://codex.wordpress.org/Function_Reference/register_post_type
    //
    
    //
    // /**
    //  * register post type that has page for archive and single
    //  */
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
    //

    
    //
    // /**
    //  * register post type with NO single page
    //  */
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


add_action('init', 'sk_content_types');

/**
 * register content types
 */
function sk_content_types(){

    
    
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


    

}
