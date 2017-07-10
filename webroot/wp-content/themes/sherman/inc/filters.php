<?php
/* ========================================================
 *
 * Custom theme actions and filters for the front end
 *
 * ======================================================== */




/* --------------------------------------------
 *
 * --rendering fields
 *
 * -------------------------------------------- */



if( !function_exists('sk_create_img_markup') ) :
/**
 * filter to render an image from a custom field
 *
 * @param object  $img_obj  All the image data
 * @param array   $args     Arguments for the filter. Accepted arguments are:
 *         
 */
function sk_create_img_markup( $img_obj, $args = array() ){

    $img_src = $img_obj['url'];

    if( $args && isset($args['img_size']) && isset( $img_obj['sizes'][ $args['img_size'] ] ) ){
        $img_src = $img_obj['sizes'][ $args['img_size'] ];
    }

    return '<img src="' . $img_src . '">';

}
add_filter('sk_image_markup', 'sk_create_img_markup');
endif; // sk_create_img_markup




if( !function_exists('sk_link_email') ) :
/**
 * render an email address as a linked link
 *
 * @param $email (string)
 *   - the email address
 */
function sk_link_email( $email ){
    $email = '<a href="mailto:' . $email . '">' . $email . '</a>';

    return $email;
}
add_filter('sk_link_email', 'sk_link_email');
endif; // sk_link_email




if( !function_exists('sk_sanitize_svg') ) :
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
endif; // sk_sanitize_svg




if( !function_exists('sk_youtube_video_embed')) :
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
endif; // sk_youtube_video_embed


