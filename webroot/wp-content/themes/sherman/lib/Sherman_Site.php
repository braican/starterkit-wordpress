<?php
/**
 * Custom class for theme
 * 
 * @package sherman
 */

class Sherman_Site {
    function __construct() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         */
        load_theme_textdomain('sherman', SHERMAN_THEME_PATH . 'languages');

        /**
         * Enable theme support for:
         *  - Add default posts and comments RSS feed links to head.
         *  - Post Thumbnails
         *  - html5 markup
         */
        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

        
        /**
         * Add image sizes 
         */
        // add_image_size('thumbnail-size', 368, 272, true);   


        /**
         * Register nav menu locations
         */
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'sherman' ),
        ) );


        // register post types and taxonomies
        add_action('init', array($this, 'register_post_types'));
        add_action('init', array($this, 'register_taxonomies'));

        // enqueue js and css
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue'));

        // Remove wp emoji js file; we don't need the extra http request
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');

    }

    public function register_post_types() {
        require_once SHERMAN_THEME_PATH . 'lib/post_types/post-types.php';
    }
    public function register_taxonomies() {
        require_once SHERMAN_THEME_PATH . 'lib/post_types/taxonomies.php';
    }

    public function enqueue() {
        wp_enqueue_script('sk_script_main', SHERMAN_THEME_PATH . 'static/dist/production.js', array('jquery'), false, true );
        wp_enqueue_style('sk_script_style', SHERMAN_THEME_PATH . 'static/dist/style.css');

        //
        // comments
        //
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
}
