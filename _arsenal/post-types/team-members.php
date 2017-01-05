
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