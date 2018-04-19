<?php
/* ========================================================
 *
 * Admin filters and functions
 *
 * ======================================================== */


// core
require __DIR__ . '/core/dashboard.php';
require __DIR__ . '/core/styles.php';
require __DIR__ . '/core/query.php';
require __DIR__ . '/core/columns.php';
require __DIR__ . '/core/media.php';
require __DIR__ . '/core/customizer.php';


// wysiwyg
require __DIR__ . '/wysiwyg/blocks.php';
require __DIR__ . '/wysiwyg/formats.php';

// documentation
require __DIR__ . '/documentation/featured_image.php';


class Sherman_Admin {
    function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'load_admin_styles'));
    }

    public function load_admin_styles() {
        wp_register_style('custom_wp_admin_css', get_template_directory_uri() . '/static/dist/style--admin.css', false, '1.0.0');
        wp_enqueue_style('custom_wp_admin_css');
    }
}
