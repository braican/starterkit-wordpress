
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