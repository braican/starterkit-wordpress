<?php
/***************************************
 *
 * Sherman functions and definitions
 *
 * @package sherman
 *
 ***************************************/

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 640; /* pixels */
}


/**
 * hide the admin bar, if you want
 */
// add_filter('show_admin_bar', '__return_false');



if ( ! function_exists( 'sk_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function sk_setup() {


    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_theme_textdomain( 'sherman', get_template_directory() . '/languages' );


    /**
     * Add default posts and comments RSS feed links to head.
     */
    add_theme_support( 'automatic-feed-links' );


    /**
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support( 'post-thumbnails' );

    
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
    
    /**
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    /**
     * Enable support for Post Formats.
     * See http://codex.wordpress.org/Post_Formats
     */
    // add_theme_support( 'post-formats', array(
    //     'aside', 'image', 'video', 'quote', 'link'
    // ) );


    /**
     * Setup the WordPress core custom background feature. Uncomment
     *  this if you'd like the user to be able to control this stuff.
     */
    // add_theme_support( 'custom-background', apply_filters( 'sk_custom_background_args', array(
    //     'default-color' => 'ffffff',
    //     'default-image' => '',
    // ) ) );
}
endif; // sk_setup
add_action( 'after_setup_theme', 'sk_setup' );


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function sk_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'sherman' ),
        'id'            => 'sidebar-1',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'sk_widgets_init' );



/* --------------------------------------------
 * --scripts
 * -------------------------------------------- */

/**
 * Enqueue scripts and styles.
 */
function sk_scripts() {

    $env = defined('WP_ENV') ? WP_ENV : 'staging';

    //
    // if we're in the production environment, enqueue the minified,
    //  concatenated scripts. Otherwise, load them all individually
    //  for easier debugging.
    //
    if( $env === 'production'){

        // load up the one production, minified file
        wp_enqueue_script( 'sk_script-main', get_template_directory_uri() . '/js/build/production.min.js', array('jquery'), false, true );
    } else {
        // the arsenal
        sk_loadArsenal();

        // plugins
        wp_enqueue_script( 'sk_script-plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), false, true );

        // main
        wp_enqueue_script( 'sk_script-main', get_template_directory_uri() . '/js/main.js', array('sk_script-plugins', 'jquery'), false, true );
    }

    //
    // since we're compiling sass anyway, the style.css file is
    //  already minified and optimized
    //
    wp_enqueue_style( 'sk_script-style', get_template_directory_uri() . '/css/build/style.css' );
    
    //
    // comments
    //
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'sk_scripts' );


/**
 * Helper function that loads the individual arsenal javascripts, if
 *  they are present
 */
function sk_loadArsenal(){

    // the list of available scripts
    $arsenal = glob( get_template_directory() . '/js/arsenal/*.js');

    foreach( $arsenal as $script ){

        $filename = str_replace( get_template_directory() . '/js/arsenal/', '', $script);
        $path = get_template_directory() . '/js/arsenal/' . $filename;
        $uri = get_template_directory_uri() . '/js/arsenal/' . $filename;

        if( file_exists( $path ) ){
            wp_enqueue_script( "sk_script--$filename", $uri, array('jquery'), false, true);
        }
    }
}




/* --------------------------------------------
 * --includes
 * -------------------------------------------- */

/**
 * Implement the Custom Header feature. Comment this out if you don't
 *  need a banner image on the homepage (or other pages I guess).
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';



require get_template_directory() . '/inc/custom-taxonomies.php';

/**
 * theme api - generally front end functions
 */
require get_template_directory() . '/inc/api.php';

/**
 * custom filters
 */
require get_template_directory() . '/inc/filters.php';


/**
 * Arsenal
 */
$arsenal_postTypes = get_template_directory() . '/arsenal/post-types.php';
if( file_exists( $arsenal_postTypes ) ){
    require $arsenal_postTypes;
}



/* --------------------------------------------
 * --util
 * -------------------------------------------- */

/**
 * include svgs inline
 *
 * @param $svg (string)
 *   - the svg to include
 * @param $return (boolean)
 *   - whether to return the svg as a string or simply include the svg
 */
function include_svg( $svg, $return = false ){
    $svg_path = get_template_directory() . '/svg/build/' . $svg . '.svg';

    if(!file_exists($svg_path)){
        return false;
    }

    if($return){
        return file_get_contents($svg_path);
    }

    include( $svg_path );
}

