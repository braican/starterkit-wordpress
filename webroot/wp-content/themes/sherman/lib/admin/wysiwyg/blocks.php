<?php

/* ========================================================
 *
 * Add HTML block options to the WYSIWYG editor
 *
 * ======================================================== */


/**
 * add block formats to the wysiwyg editor
 *
 * @param $init : the object that drives the wysiwyg
 * @return the modified object that represents the wysiwyg
 */
function sk_modify_wysiwyg( $init ) {
    $init['block_formats'] = 'Paragraph=p;';
    return $init;
}
add_filter('tiny_mce_before_init', 'sk_modify_wysiwyg');