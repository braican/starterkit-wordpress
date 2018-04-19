<?php

/* ========================================================
 *
 * Formats for the WYSIWYG editor
 *
 * ======================================================== */

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