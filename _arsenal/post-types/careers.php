
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
