<?php
/**
 * _s functions and definitions
 *
 * @package _s
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 640; /* pixels */
}

if ( ! function_exists( '_s_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function _s_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on _s, use a find and replace
     * to change '_s' to the name of your theme in all the template files
     */
    load_theme_textdomain( '_s', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', '_s' ),
    ) );
    
    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    /*
     * Enable support for Post Formats.
     * See http://codex.wordpress.org/Post_Formats
     */
    add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link'
    ) );

    // Setup the WordPress core custom background feature.
    add_theme_support( 'custom-background', apply_filters( '_s_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );
}
endif; // _s_setup
add_action( 'after_setup_theme', '_s_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function _s_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', '_s' ),
        'id'            => 'sidebar-1',
        'description'   => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', '_s_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _s_scripts() {
    wp_enqueue_style( '_s_script-style', get_stylesheet_uri() );

    wp_enqueue_script( '_s_script-plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), '20140725', true );

    wp_enqueue_script( '_s_script-main', get_template_directory_uri() . '/js/main.js', array('_s_script-plugins', 'jquery'), '20140725', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );

/**
 * Implement the Custom Header feature.
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

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/register-content_types-taxonomies.php';




/* --------------------------------------------
 * --functions
 * -------------------------------------------- */

/**
 * _s_the_field 
 * 
 * theme implementation of ACF's get_field - checks to ensure the
 *  value is there, and then wraps it in html
 * @param $field
 * @param $args
 *     - id (number)         : the post id to check this field for
 *     - before (string)     : the html to appear before the field
 *     - after  (string)     : the html to appear after the field
 *     - filter (string)     : any filters to apply to the field
 *     - sub_field (boolean) : whether or not this field is a sub-field of a repeater
 *     - default (string)    : if the field is undefined, render the default
 */
function _s_the_field($field, $args = array() ){

    global $post;

    $defaults = array(
        'id'        => 0,
        'before'    => '',
        'after'     => '',
        'filter'    => '',
        'sub_field' => false,
        'default'   => ''
    );
    
    $options = array_merge($defaults, $args);

    $id = $options['id'] ? $options['id'] : $post->ID;

    $val = $options['sub_field'] ? get_sub_field($field, $id) : get_field($field, $id) ;

    if( $val ){
        if($options['filter']){
            $val = apply_filters( $options['filter'], $val );
        }
        echo $options['before'] . $val . $options['after'];

    } else if($options['default']){
        echo $options['before'] . $options['default'] . $options['after'];
    }
}




/* --------------------------------------------
 * --filters
 * -------------------------------------------- */

/**
 * _s_modify_wysiwyg
 * @param $init : the object that drives the wysiwyg
 * @return the modified object that represents the wysiwyg
 */
function _s_modify_wysiwyg( $init ) {
    $init['block_formats'] = 'Paragraph=p;Heading 3=h3';
    return $init;
}
add_filter('tiny_mce_before_init', '_s_modify_wysiwyg');



/* --------------------------------------------
 * --util
 * -------------------------------------------- */

/**
 * include_svg
 * @param (string) svg : the svg to include
 * @param $return : whether to return the svg as a string or simply include the svg
 */
function include_svg( $svg, $return = false ){
    $svg_path = get_template_directory() . '/svg/' . $svg . '.svg';

    if($return){
        return file_get_contents($svg_path);
    }

    include( $svg_path );
}

