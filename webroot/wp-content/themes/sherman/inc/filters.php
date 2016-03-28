<?php

/* --------------------------------------------
 *
 * WordPress custom actions and filters
 *
 * -------------------------------------------- */


/* --------------------------------------------
 * --WYSIWYG
 * -------------------------------------------- */


/**
 * add block formats to the wysiwyg editor
 *
 * @param $init : the object that drives the wysiwyg
 * @return the modified object that represents the wysiwyg
 */
function sk_modify_wysiwyg( $init ) {
    $init['block_formats'] = 'Paragraph=p;Heading 3=h3';
    return $init;
}
add_filter('tiny_mce_before_init', 'sk_modify_wysiwyg');




/**
 * filter to add a style select dropdown to the WYSIWYG editor
 */
function sk_add_style_select( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter('mce_buttons_2', 'sk_add_style_select');




/**
 * filter to add a the actual styles to the wysiwyg
 */
function sk_custom_wysiwyg_classes( $init_array ) {  
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
add_filter( 'tiny_mce_before_init', 'sk_custom_wysiwyg_classes' );  



/* --------------------------------------------
 * --rendering fields
 * -------------------------------------------- */

/**
 * filter to render an image from a custom field
 *
 * @param $img_obj (array)
 *   - the image object from wordpress
 */
function sk_create_img_markup($img_obj){

    return '<img src="' . $img_obj['url'] . '">';

}
add_filter('sk_image_markup', 'sk_create_img_markup');



/**
 * render an email address as a linked link
 *
 * @param $email (string)
 *   - the email address
 */
function sk_link_email($email){
    $email = '<a href="mailto:' . $email . '">' . $email . '</a>';

    return $email;
}
add_filter('sk_link_email', 'sk_link_email');



/**
 * sanitize any values coming through the CMS that should be output
 *  as HTML and make sure that it's svg code
 */
function sk_sanitize_svg( $markup ){
    $markup = trim( $markup );

    $first = substr( $markup, 0, 5);
    $last = substr( $markup, -6);

    // check to make sure the string starts with a valid svg tag, and
    //  ends with the closing svg tag
    if( $first !== '<svg ' || $last !== '</svg>'){
        return '';
    }

    // check to ensure there are no script tags
    if( strpos( $markup, 'script' ) !== false ){
        return '';
    }

    return $markup;
}
add_filter('sk_sanitize_svg', 'sk_sanitize_svg');



/**
 * creates markup for a youtube video embed
 *
 * @param $markup (string)
 *   - the youtube ID, from the CMS
 */
function sk_youtube_video_embed($id){

    return '<div class="iframe-container"><iframe width="560" height="315" src="https://www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen></iframe></div>';
}
add_filter('sk_youtube', 'sk_youtube_video_embed');



/* --------------------------------------------
 * --thumbnails and scaling
 * -------------------------------------------- */


/**
 * filter to allow the upscaling of images to fit their assigned dimensions
 *
 * @link http://wordpress.stackexchange.com/questions/50649/how-to-scale-up-featured-post-thumbnail
 */
function sk_image_crop_dimensions($default, $orig_w, $orig_h, $new_w, $new_h, $crop) {
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
// add_filter('image_resize_dimensions', 'sk_image_crop_dimensions', 10, 6);



/* --------------------------------------------
 * --administrative filters
 * -------------------------------------------- */


/**
 * adds instructions for the featured image field
 *
 * @param $content (string)
 *   - the markup for the block
 */
function sk_add_featured_image_instruction( $content ) {
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
add_filter( 'admin_post_thumbnail_html', 'sk_add_featured_image_instruction');



/**
 * set up the columns for the posts adimn page. Change POSTTYPE in
 *  the function name to the type of post you'd like to add the
 *  column to.
 *
 * @param $columns (array)
 *   - the list of columns
 */
function sk_admin_POSTTYPE_columns( $columns ) {
    // $columns['new-column-name'] = 'Column Label';
    return $columns;
}
// add_action( 'manage_POSTTYPE_posts_columns' , 'sk_admin_POSTTYPE_columns' );


/**
 * in the admin section, display custom columns
 * @param $name (string)
 *   - the name of the column, as set in cc_admin_custom_post_columns
 */
function sk_admin_custom_columns($name) {
    global $post;
    switch ($name) {
        case 'new-column-name':
            echo "Test";
            break;
    }
}
// add_action('manage_posts_custom_column',  'sk_admin_custom_columns');



/**
 * hides admin menu items
 * @link - https://codex.wordpress.org/Function_Reference/remove_menu_page
 */
function sk_menu_page_removing() {
    remove_menu_page( 'edit-comments.php' );

}
add_action( 'admin_menu', 'sk_menu_page_removing' );