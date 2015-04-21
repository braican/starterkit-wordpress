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


/**
 * hide the admin bar, if you want
 */
// add_filter('show_admin_bar', '__return_false');



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

    if ( function_exists( 'get_field' ) ) :
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
endif;
}



/* --------------------------------------------
 * --rendering
 * -------------------------------------------- */


/**
 * _s_the_page_blocks 
 * 
 * hooks into the ACF repeater field to render all the additional
 *  page blocks for a page. Calls tempaltes in the modules/ directoru
 */
function _s_the_page_blocks(){

    if ( function_exists( 'have_rows' ) ) :

        // replace this with whatever your repeater name is within ACF
        $blocks_repeater = '_s_page_blocks';

        // replace this with whatever the block title name is within ACF
        $module_title = '_s_page_block_title';

        if(have_rows($blocks_repeater)) : ?>
            <div class="secondary-content">

                <?php // loop through the rows of data ?>
                <?php while ( have_rows($blocks_repeater) ) : the_row(); ?>
                    <?php $module = get_sub_field($module_title); ?>

                    <div class="_s-module<?php echo $module ? " $module" : ""; ?>">
                    <?php
                        // //
                        // // - example implementation of getting the header field
                        // //    for each of the blocks
                        // //
                        // _s_the_field( $module_title , array(
                        //     'before'    => '<header class="page-module-title"><h2>',
                        //     'after'     => '</h2></header>',
                        //     'sub_field' => true
                        // ));

                        get_template_part('modules/module', $module);
                    ?>

                    </div><!-- .cc-module -->
                <?php endwhile; ?>

            </div><!-- .secondary-content -->
    <?php
        endif;

    endif;
}




/* --------------------------------------------
 * --filters
 * -------------------------------------------- */


//
// wysiwyg stuff
//


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




/**
 * _s_add_style_select
 *
 * filter to add a style select dropdown to the WYSIWYG editor
 */
function _s_add_style_select( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter('mce_buttons_2', '_s_add_style_select');




/**
 * _s_custom_wysiwyg_classes
 *
 * filter to add a the actual styles to the wysiwyg
 */
function _s_custom_wysiwyg_classes( $init_array ) {  
    // Define the style_formats array
    $style_formats = array(  
        // Each array child is a format with it's own settings
        array(  
            'title' => '.translation',  
            'block' => 'blockquote',  
            'classes' => 'translation',
            'wrapper' => true,
        ),
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );  
    
    return $init_array;  
  
} 
add_filter( 'tiny_mce_before_init', '_s_custom_wysiwyg_classes' );  

/**
 * style format arguments
 * https://codex.wordpress.org/TinyMCE_Custom_Styles
 *
 * inline     – Name of the inline element to produce for example “span”. The current text selection will be wrapped in this inline element.
 * block      – Name of the block element to produce for example “h1″. Existing block elements within the selection gets replaced with the new block element.
 * selector   – CSS 3 selector pattern to find elements within the selection by. This can be used to apply classes to specific elements or complex things like odd rows in a table. Note that if you combine both selector and block then you can get more nuanced behavior where the button changes the class of the selected tag by default, but adds the block tag around the cursor if the selected tag isn't found.
 * classes    – Space separated list of classes to apply to the selected elements or the new inline/block element.
 * styles     – Name/value object with CSS style items to apply such as color etc.
 * attributes – Name/value object with attributes to apply to the selected elements or the new inline/block element.
 * exact      – Disables the merge similar styles feature when used. This is needed for some CSS inheritance issues such as text-decoration for underline/strikethrough.
 * wrapper    – State that tells that the current format is a container format for block elements. For example a div wrapper or blockquote.
 */


//
// filters for rendering fields
//

/**
 * _s_create_img_markup 
 * 
 * filter to render an image from a custom field
 * @param $img_obj
 */
function _s_create_img_markup($img_obj){

    return '<img src="' . $img_obj['url'] . '">';

}
add_filter('_s_image_markup', '_s_create_img_markup');





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

    if(!file_exists($svg_path)){
        return false;
    }

    if($return){
        return file_get_contents($svg_path);
    }

    include( $svg_path );
}

