<?php
/***************************************
 *
 * Sherman functions and definitions
 *
 * @package sherman
 *
 ***************************************/

/**
 * hide the admin bar, if you want
 */
// add_filter('show_admin_bar', '__return_false');


define('SHERMAN_THEME_URI', get_template_directory_uri());
define('SHERMAN_THEME_PATH', dirname(__FILE__) . '/');


/* -------------------------------------------------
 *
 * Requires
 *
 * ------------------------------------------------- */

require_once('lib/admin/Sherman_Admin.php');
require_once('lib/admin/Sherman_Site.php');


// Initialize site
add_action('after_setup_theme', function () {
    new Sherman_Admin();
    new Sherman_Site();
});
