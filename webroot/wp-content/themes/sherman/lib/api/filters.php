<?php
/* ========================================================
 *
 * Rendering filters for the front end
 *
 * ======================================================== */


if (!function_exists('sk_body_classes')) :
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function sk_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'sk_body_classes' );
endif; // sk_body_classes



if( !function_exists('sk_create_img_markup') ) :
/**
 * filter to render an image from a custom field
 * @param {Array} $img_obj // All the image data
 * @param {Array} $args // Arguments for the filter. Accepted arguments are:
 *   - img_size // the size of the image, registered in the functions.php
 */
function sk_create_img_markup($img_obj, $args = array()){
    $defaults = array(
        'img_size' => '',
    );
    $options = array_merge($defaults, $args);

    $img_src = $img_obj['url'];

    if($options['img_size'] && isset($img_obj['sizes'][$options['img_size']])){
        $img_src = $img_obj['sizes'][$options['img_size']];
    }

    return "<img src=\"$img_src\">";

}
add_filter('sk_image_markup', 'sk_create_img_markup');
endif; // sk_create_img_markup




if( !function_exists('sk_link_email') ) :
/**
 * render an email address as a linked link
 * @param {String} $email // The email address
 */
function sk_link_email( $email ){
    return "<a href=\"mailto:$email\">$email</a>";
}
add_filter('sk_link_email', 'sk_link_email');
endif; // sk_link_email




if( !function_exists('sk_sanitize_svg') ) :
/**
 * Sanitize any values coming through the CMS that should be output as HTML and make sure that
 *  it's svg code
 * @param {String} $markup // Markup coming from a text field in the CMS
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
 * @param {String} $id // the youtube ID, from the CMS
 */
function sk_youtube_video_embed($id){

    return "<div class=\"iframe-container\"><iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$id\" frameborder=\"0\" allowfullscreen></iframe></div>";
}
add_filter('sk_youtube', 'sk_youtube_video_embed');
endif; // sk_youtube_video_embed




if(!function_exists('sk_render_cta')) :
/**
 * Renders a full blown cta from a cta object
 * @param {Array} $cta // The CTA object from the ACF field
 */
function sk_render_cta($cta) {
    $title = $cta['title'] ? $cta['title'] : $cta['url'];
    $url = $cta['url'];

    return "<a href=\"$url\">$title</a>";
}
add_filter('sk_cta', 'sk_render_cta');
endif; // sk_render_cta



if (!function_exists('sk_wp_title')) :
/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function sk_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'sherman' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'sk_wp_title', 10, 2 );
endif; // sk_wp_title



if (!function_exists('sk_setup_author')) :
/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function sk_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'sk_setup_author' );
endif; // sk_setup_author
