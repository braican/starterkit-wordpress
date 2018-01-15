<?php

/* ========================================================
 *
 * Modified queries for the administrative end
 *
 * ======================================================== */

/**
 * Add administrative query vars
 */
function sk_admin_query_vars($vars) {
  $vars[] = 'nu_department';
  return $vars;
}
add_filter( 'query_vars', 'sk_admin_query_vars' );


/**
 * Set up the department query
 * @param {Object} $query // the query
 */
if( !function_exists('sk_admin_filter_by_dept') ) :
function sk_admin_filter_by_dept($query) {
    if(! is_admin()) return;

    $dept = $query->get('nu_department');

    if ($dept) {
        $query->set('meta_query', array(
            array(
                'key'     => 'nu_department',
                'value'   => '"' . $dept . '"',
                'compare' => 'LIKE',
            ),
        ));
    }
}
add_action( 'pre_get_posts', 'sk_admin_filter_by_dept' );
endif; // sk_admin_filter_by_dept