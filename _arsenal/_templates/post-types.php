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

    
    //sk_insert_types//
    

}
