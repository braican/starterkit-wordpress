<?php

/* ========================================================
 *
 * Setup for administrative display
 *
 * ======================================================== */

if( !function_exists('sk_menu_page_removing') ) :
/**
 * hides admin menu items
 * @link - https://codex.wordpress.org/Function_Reference/remove_menu_page
 */
function sk_menu_page_removing() {
    remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'sk_menu_page_removing' );
endif; // sk_menu_page_removing
