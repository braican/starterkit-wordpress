<?php
/* ========================================================
 *
 * Admin filters and functions
 *
 * ======================================================== */


class Sherman_Admin {
    function __construct() {
        // core
        require_once SHERMAN_THEME_PATH . 'lib/admin/core/dashboard.php';
        require_once SHERMAN_THEME_PATH . 'lib/admin/core/query.php';
        require_once SHERMAN_THEME_PATH . 'lib/admin/core/columns.php';
        require_once SHERMAN_THEME_PATH . 'lib/admin/core/media.php';
        require_once SHERMAN_THEME_PATH . 'lib/admin/core/customizer.php';

        // wysiwyg
        require_once SHERMAN_THEME_PATH . 'lib/admin/wysiwyg/blocks.php';
        require_once SHERMAN_THEME_PATH . 'lib/admin/wysiwyg/formats.php';

        // documentation
        require_once SHERMAN_THEME_PATH . 'lib/admin/documentation/featured_image.php';

        add_action('admin_enqueue_scripts', array($this, 'load_admin_styles'));
    }

    public function load_admin_styles() {
        wp_enqueue_style('custom_wp_admin_css', SHERMAN_THEME_URI . '/static/dist/style--admin.css', false, '1.0.0');
    }
}
