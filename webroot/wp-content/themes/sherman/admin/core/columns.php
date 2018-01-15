<?php

/* ========================================================
 *
 * Modified columns
 *
 * ======================================================== */

if( !function_exists('sk_admin_news_columns') ) :
/**
 * set up the columns for the posts adimn page. Change POSTTYPE in the function name to the type of
 *  post you'd like to add the column to.
 * @param {Array} $columns // the list of columns
 */
function sk_admin_news_columns( $columns ) {
    $nuColumns = array();

    foreach($columns as $key => $title) {
        $nuColumns[$key] = $title;
        if ($key === 'title') // Put the Thumbnail column before the Author column
            $nuColumns['department'] = 'Department';
    }
    return $nuColumns;
}
add_action( 'manage_news_posts_columns' , 'sk_admin_news_columns' );
endif; // sk_admin_news_columns




if( !function_exists('sk_admin_custom_columns') ) :
/**
 * in the admin section, display custom columns
 * @param {String} $name // the name of the column, as set in sk_admin_POSTTYPE_columns functions
 */
function sk_admin_custom_columns($name) {
    global $post;
    switch ($name) {
        case 'department':
            $dept = get_field('nu_department');
            if ($dept) {
                foreach ($dept as $dIndex => $d) {
                    if ($dIndex > 0) {
                        echo ', ';
                    }
                    echo '<a href="/wp-admin/edit.php?post_type=' . $post->post_type . '&nu_department=' . $d->ID . '">' . $d->post_title . '</a>';
                }
            }
            break;
    }
}
add_action('manage_posts_custom_column',  'sk_admin_custom_columns');
endif; // sk_admin_custom_columns
