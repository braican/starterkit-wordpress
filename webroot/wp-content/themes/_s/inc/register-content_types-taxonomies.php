<?php

/* --------------------------------------------
 * --register content types and taxonomies
 * -------------------------------------------- */

/**
 * _s_content_types
 *
 * http://codex.wordpress.org/Function_Reference/register_post_type
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
}
add_action('init', '_s_content_types');


/**
 * _s_taxonomies
 *
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
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


add_action('init', '_s_taxonomies');

