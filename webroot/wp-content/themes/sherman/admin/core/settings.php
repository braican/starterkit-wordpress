<?php

/* ========================================================
 *
 * Settings and API keys
 *
 * ======================================================== */

if( !function_exists('sk_google_maps_api_key') ) :
function sk_google_maps_api_key() {
    
    acf_update_setting('google_api_key', 'AIzaSyDMMeuFJJ4l_nGf2v-URQXJfFy_5ZXckYQ');
}

add_action('acf/init', 'sk_google_maps_api_key');
endif; // sk_google_maps_api_key