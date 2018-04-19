<?php

/* ========================================================
 *
 * Featured Image metabox help text
 *
 * ======================================================== */


if( !function_exists('sk_add_featured_image_instruction') ) :
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
endif; // sk_add_featured_image_instruction