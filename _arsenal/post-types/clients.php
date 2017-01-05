
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