
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