
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