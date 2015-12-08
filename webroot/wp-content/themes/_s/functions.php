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

    /**
     * Add default posts and comments RSS feed links to head.
     */
    add_theme_support( 'automatic-feed-links' );

    /**
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support( 'post-thumbnails' );
    
    /**
     * add image sizes 
     */
    // add_image_size('thumbnail-size', 368, 272, true);   


    /**
     * This theme uses wp_nav_menu() in one location.
     */
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', '_s' ),
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
    // add_theme_support( 'custom-background', apply_filters( '_s_custom_background_args', array(
    //     'default-color' => 'ffffff',
    //     'default-image' => '',
    // ) ) );
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


/* --------------------------------------------
 * --scripts
 * -------------------------------------------- */

/**
 * Enqueue scripts and styles.
 */
function _s_scripts() {

    $env = defined('WP_ENV') ? WP_ENV : 'staging';

    //
    // if we're in the production environment, enqueue the minified,
    //  concatenated scripts. Otherwise, load them all individually
    //  for easier debugging.
    if( $env === 'production'){

        // load up the one production, minified file
        wp_enqueue_script( '_s_script-main', get_template_directory_uri() . '/js/build/production.min.js', array('jquery'), false, true );
    } else {
        // the arsenal
        _s_loadArsenal();

        // plugins
        wp_enqueue_script( '_s_script-plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), false, true );

        // main
        wp_enqueue_script( '_s_script-main', get_template_directory_uri() . '/js/main.js', array('_s_script-plugins', 'jquery'), false, true );
    }

    //
    // since we're compiling sass anyway, the style.css file is
    //  already minified and optimized
    //
    wp_enqueue_style( '_s_script-style', get_template_directory_uri() . '/css/build/style.css' );
    
    //
    // comments
    //
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );


/**
 * Helper function that loads the individual arsenal javascripts, if
 *  they are present
 */
function _s_loadArsenal(){

    // the list of available scripts
    $arsenal = array(
        'modal',
        'slider'
    );

    foreach( $arsenal as $script ){
        
        $path = '/js/arsenal/enabled/' . $script . '.js';

        if( file_exists( get_template_directory() . $path ) ){
            wp_enqueue_script( "_s_script--$script", get_template_directory_uri() . $path, array('jquery'), false, true);
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

/**
 * Custom post types and taxonomies
 */
require get_template_directory() . '/inc/register-post_types-taxonomies.php';

/**
 * theme api
 */
require get_template_directory() . '/inc/api.php';



/* --------------------------------------------
 * --filters
 * -------------------------------------------- */


//
// WYSIWYG STUFF
//


/**
 * add block formats to the wysiwyg editor
 *
 * @param $init : the object that drives the wysiwyg
 * @return the modified object that represents the wysiwyg
 */
function _s_modify_wysiwyg( $init ) {
    $init['block_formats'] = 'Paragraph=p;Heading 3=h3';
    return $init;
}
add_filter('tiny_mce_before_init', '_s_modify_wysiwyg');




/**
 * filter to add a style select dropdown to the WYSIWYG editor
 */
function _s_add_style_select( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter('mce_buttons_2', '_s_add_style_select');




/**
 * filter to add a the actual styles to the wysiwyg
 */
function _s_custom_wysiwyg_classes( $init_array ) {  
    // Define the style_formats array
    $style_formats = array( 
        /**
         * Each array child is a format with it's own settings
         *
         * style format arguments
         * https://codex.wordpress.org/TinyMCE_Custom_Styles
         *
         * title      - the value that will appear in the "Formats" dropdown in the WYSIWYG
         * inline     – Name of the inline element to produce for example "span". The current text selection will be wrapped in this inline element.
         * block      – Name of the block element to produce for example "h1". Existing block elements within the selection gets replaced with the new block element.
         * selector   – CSS 3 selector pattern to find elements within the selection by. This can be used to apply classes to specific elements or complex things like odd rows in a table. Note that if you combine both selector and block then you can get more nuanced behavior where the button changes the class of the selected tag by default, but adds the block tag around the cursor if the selected tag isn't found.
         * classes    – Space separated list of classes to apply to the selected elements or the new inline/block element.
         * styles     – Name/value object with CSS style items to apply such as color etc.
         * attributes – Name/value object with attributes to apply to the selected elements or the new inline/block element.
         * exact      – Disables the merge similar styles feature when used. This is needed for some CSS inheritance issues such as text-decoration for underline/strikethrough.
         * wrapper    – State that tells that the current format is a container format for block elements. For example a div wrapper or blockquote.
         */
        array(  
            'title'   => '.translation',  
            'block'   => 'blockquote',  
            'classes' => 'translation',
            'wrapper' => true,
        ),
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );  
    
    return $init_array;  
  
} 
add_filter( 'tiny_mce_before_init', '_s_custom_wysiwyg_classes' );  



//
// RENDERING FIELDS
//

/**
 * filter to render an image from a custom field
 *
 * @param $img_obj (array)
 *   - the image object from wordpress
 */
function _s_create_img_markup($img_obj){

    return '<img src="' . $img_obj['url'] . '">';

}
add_filter('_s_image_markup', '_s_create_img_markup');



/**
 * render an email address as a linked link
 *
 * @param $email (string)
 *   - the email address
 */
function _s_link_email($email){
    $email = '<a href="mailto:' . $email . '">' . $email . '</a>';

    return $email;
}
add_filter('_s_link_email', '_s_link_email');



//
// THUMBNAILS AND SCALING
//


/**
 * filter to allow the upscaling of images to fit their assigned dimensions
 *
 * @link http://wordpress.stackexchange.com/questions/50649/how-to-scale-up-featured-post-thumbnail
 */
function _s_image_crop_dimensions($default, $orig_w, $orig_h, $new_w, $new_h, $crop) {
    if(!$crop)
        return null; // let the wordpress default function handle this

    $aspect_ratio = $orig_w / $orig_h;
    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);

    $s_x = floor( ($orig_w - $crop_w) / 2 );
    $s_y = floor( ($orig_h - $crop_h) / 2 );

    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}
// add_filter('image_resize_dimensions', '_s_image_crop_dimensions', 10, 6);



//
// ADMIN SECTION
//

/**
 * adds instructions for the featured image field
 *
 * @param $content (string)
 *   - the markup for the block
 */
function _s_add_featured_image_instruction( $content ) {
    global $post;

    if( !$post || ! isset($post->post_type) ){
        return $content;
    }

    $post_type = $post->post_type;

    $helper_text = '';

    switch ($post_type) {
        case 'post_type':
            $helper_text = "Additional text...";
            break;
    }


    return $helper_text . $content;
}
add_filter( 'admin_post_thumbnail_html', '_s_add_featured_image_instruction');



/**
 * set up the columns for the posts adimn page. Change POSTTYPE in
 *  the function name to the type of post you'd like to add the
 *  column to.
 *
 * @param $columns (array)
 *   - the list of columns
 */
function _s_admin_POSTTYPE_columns( $columns ) {
    // $columns['new-column-name'] = 'Column Label';
    return $columns;
}
// add_action( 'manage_POSTTYPE_posts_columns' , '_s_admin_POSTTYPE_columns' );


/**
 * in the admin section, display custom columns
 * @param $name (string)
 *   - the name of the column, as set in cc_admin_custom_post_columns
 */
function _s_admin_custom_columns($name) {
    global $post;
    switch ($name) {
        case 'new-column-name':
            echo "Test";
            break;
    }
}
// add_action('manage_posts_custom_column',  '_s_admin_custom_columns');





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

