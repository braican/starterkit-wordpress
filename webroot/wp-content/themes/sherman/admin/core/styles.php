<?php

/* ========================================================
 *
 * Administrative styles
 *
 * ======================================================== */

if( !function_exists('sk_admin_styles') ) :
/**
 * Add custom css to the admin
 */
function sk_admin_styles() {
?>
    <style>
        .acf-repeater.-row table tr + tr td,
        .acf-repeater.-block table tr + tr td{
            border-top-color: #ccc;
            border-top-width: 2px;
        }
        .acf-repeater.-row table tr:nth-child(even) .acf-fields,
        .acf-repeater.-block table tr:nth-child(even) .acf-fields{
            background-color: #f9f9f9;
        }        
    </style>
<?php
}
add_action('admin_head', 'sk_admin_styles');
endif; // sk_admin_styles