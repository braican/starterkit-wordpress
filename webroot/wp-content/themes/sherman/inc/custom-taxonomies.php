<?php

/* --------------------------------------------
 *
 * Register taxonomies
 *
 * -------------------------------------------- */

    //
    // @link http://codex.wordpress.org/Function_Reference/register_taxonomy
    // 
    // 
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
    //



/**
 * Register taxonomies. Insert taxonomy registrations in here
 */
function sk_taxonomies(){

}
add_action('init', 'sk_taxonomies');

