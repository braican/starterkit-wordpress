<?php

/* ========================================================
 *
 * API function calls for theming
 *
 * ======================================================== */




/* -------------------------------------------------
 * --getting fields
 * ------------------------------------------------- */


if( !function_exists('sk_the_field') ) :
/**
 * theme implementation of ACF's get_field - checks to ensure the
 *  value is there, and then wraps it in html
 *
 * @param string $field : The name of the field
 * @param array  $args  : Arguments to display this field
 *    - id (number)         : the post id to check this field for.
 *    - before (string)     : the html to appear before the field.
 *    - after  (string)     : the html to appear after the field.
 *    - filter (string)     : any filters to apply to the field.
 *    - filter_args (array) : an array of arguments to pass to the filter.
 *    - sub_field (boolean) : whether or not this field is a sub-field of a repeater.
 *    - default (string)    : if the field is undefined, render the default. Default is an empty string.
 *    - return (boolean)    : whether to return the value, or simply echo it. Default is false.
 *    - debug (boolean)     : enables debug mode. Default is false.
 */
function sk_the_field($field, $args = array() ){

    // lets check the existance of ACF
    if ( function_exists( 'get_field' ) === false ){
        return false;
    }

    // ok we're good - let's go
    global $post;

    $defaults = array(
        'id'          => 0,
        'before'      => '',
        'after'       => '',
        'filter'      => '',
        'filter_args' => array(),
        'sub_field'   => false,
        'default'     => '',
        'return'      => false,
        'debug'       => false,
    );
    
    $options = array_merge($defaults, $args);

    //
    // check to see if we have an ID set. if not, grab it from
    //  the global post variable
    //
    if($options['id']){
        $id = $options['id'];
    } else {
        if( !isset($post->ID)){
            return;
        }
        $id = $post->ID;
    }

    $val = $options['sub_field'] ? get_sub_field($field, $id) : get_field($field, $id) ;

    if( $val ){
        if($options['filter']){
            $val = apply_filters( $options['filter'], $val, $options['filter_args'] );
        }

        $markup = $options['before'] . $val . $options['after'];
        
        if($options['return']){
            return $markup;
        }

        echo $markup;

    } else if($options['default']){
        $markup = $options['before'] . $options['default'] . $options['after'];
        
        if($options['return']){
            return $markup;
        }

        echo $markup; 
    }
}
endif; // sk_the_field





if( !function_exists('sk_get_field') ) :
/**
 * Wrapper to call the sk_the_field function to return
 *
 * @param string $field : Field we want
 * @param array  $args  : see above
 */
function sk_get_field( $field, $args = array() ){
    $options = array_merge($args, array('return' => true));
    return sk_the_field($field, $options);
}
endif; // sk_get_field





if( !function_exists('sk_the_subfield') ) :
/**
 * Wrapper to call the sk_the_field with a subfield
 *
 * @param string $field : Field we want
 * @param array  $args  : see above
 */
function sk_the_subfield( $field, $args = array() ){
    $options = array_merge( $args, array('sub_field' => true) );
    sk_the_field($field, $options);
}
endif; // sk_the_subfield




if( !function_exists('sk_get_subfield') ) :
/**
 * Wrapper to call the sk_the_field to return and show a subfield
 *
 * @param string $field : Field we want
 * @param array  $args  : see above
 */
function sk_get_subfield( $field, $args = array() ){
    $options = array_merge($args, array('return' => true, 'sub_field' => true));
    return sk_the_field($field, $options);
}
endif; // sk_get_subfield




if( !function_exists('sk_block_field') ) :
/**
 * Wrapper to display a field within a block. Since the page blocks
 *  utilizes an ACF repeater field, this is an alias of sk_the_subfield()
 */
function sk_block_field( $field, $args = array() ){
    sk_the_subfield( $field, $args );
}
endif; // sk_block_field







/* --------------------------------------------
 * --rendering
 * -------------------------------------------- */


if( !function_exists('sk_the_page_blocks') ) :
/**
 * hooks into the ACF repeater field to render all the additional
 *  page blocks for a page. Calls tempaltes in the blocks/ directory
 */
function sk_the_page_blocks(){

    // check for the existance of ACF
    if ( function_exists( 'have_rows' ) === false ){
        return false;
    }

    // the page blocks repeater field
    $newBlocks = 'sk_page_blocks';


    if( have_rows( $newBlocks ) ) : ?>
    
        <div class="secondary-content">

            <?php // loop through the rows of data ?>
            <?php while ( have_rows($newBlocks) ) : the_row(); ?>
                <?php $block = get_row_layout(); ?>

                <section class="sk-block<?php echo $block ? " block--$block" : ""; ?>">
                    <?php
                        //
                        // - example implementation of getting the header field
                        //    for each of the blocks
                        //
                        // sk_block_field( 'sk_page_block_title' , array(
                        //     'before'    => '<header class="page-module-title"><h2>',
                        //     'after'     => '</h2></header>'
                        // ));

                        get_template_part('blocks/block', $block);
                    ?>

                </section><!-- .sk-module -->
            <?php endwhile; ?>

        </div><!-- .secondary-content -->
<?php
    endif;
}
endif; // sk_the_page_blocks