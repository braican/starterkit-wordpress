<?php
/**
 * Helper functions
 */

if(!function_exists('sk_has_social_links')) :
/**
 * Check to see if any of the social links have been filled out
 */
function sk_has_social_links(){
    $links = get_option('sk_social');

    foreach($links as $l){
        if($l) return true;
    }

    return false;
}
endif; // sk_has_social_links



if(!function_exists('include_svg')) :
/**
 * include svgs inline
 * @param {string} $svg // the svg to include
 * @param {boolean} $return // whether to return the svg as a string or simply include the svg
 */
function include_svg( $svg, $return = false ){
    $svg_path = get_template_directory() . '/svg/' . $svg . '.svg';

    if(!file_exists($svg_path)){
        return;
    }

    if($return){
        return file_get_contents($svg_path);
    }

    include( $svg_path );
}
endif;

