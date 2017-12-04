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