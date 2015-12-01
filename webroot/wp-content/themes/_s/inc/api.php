<?php

/* --------------------------------------------
 *
 * API function calls for theming
 *
 * -------------------------------------------- */



/**
 * theme implementation of ACF's get_field - checks to ensure the
 *  value is there, and then wraps it in html
 *
 * @param $field
 * @param $args
 *     - id (number)         : the post id to check this field for
 *     - before (string)     : the html to appear before the field
 *     - after  (string)     : the html to appear after the field
 *     - filter (string)     : any filters to apply to the field
 *     - sub_field (boolean) : whether or not this field is a sub-field of a repeater
 *     - default (string)    : if the field is undefined, render the default
 */
function _s_the_field($field, $args = array() ){

    if ( function_exists( 'get_field' ) ) :
        global $post;

        $defaults = array(
            'id'        => 0,
            'before'    => '',
            'after'     => '',
            'filter'    => '',
            'sub_field' => false,
            'default'   => ''
        );
        
        $options = array_merge($defaults, $args);

        $id = $options['id'] ? $options['id'] : $post->ID;

        $val = $options['sub_field'] ? get_sub_field($field, $id) : get_field($field, $id) ;

        if( $val ){
            if($options['filter']){
                $val = apply_filters( $options['filter'], $val );
            }
            echo $options['before'] . $val . $options['after'];

        } else if($options['default']){
            echo $options['before'] . $options['default'] . $options['after'];
        }
    endif;
}



/**
 * wrapper to call the _s_the_field function to return
 * @param $field
 * @param $args - see above
 */
function _s_get_field($field, $args = array() ){
    $options = array_merge($args, array('return' => true));
    return cc_the_field($field, $options);
}



/**
 * Wrapper to display a field within a module. Since the page blocks
 *  utilizes an ACF repeater field, all the fields within the modules
 *  are actually sub fields
 *
 * @param $field (string)
 *   - the name of the field
 * @param $args (array)
 *   - the arguments for this field. See above for complete list
 *       of arguments
 */
function _s_module_field( $field, $args = array() ){

    $options = array_merge( $args, array('sub_field' => true) );

    _s_the_field($field, $options);

}



/* --------------------------------------------
 * --rendering
 * -------------------------------------------- */


/**
 * hooks into the ACF repeater field to render all the additional
 *  page blocks for a page. Calls tempaltes in the modules/ directory
 */
function _s_the_page_blocks(){

    if ( function_exists( 'have_rows' ) ) :

        // replace this with whatever your repeater name is within ACF
        $blocks_repeater = '_s_page_blocks';

        // replace this with whatever the block title name is within ACF
        $module_title = '_s_page_block_title';

        if(have_rows($blocks_repeater)) : ?>
            <div class="secondary-content">

                <?php // loop through the rows of data ?>
                <?php while ( have_rows($blocks_repeater) ) : the_row(); ?>
                    <?php $module = get_sub_field($module_title); ?>

                    <div class="_s-module<?php echo $module ? " $module" : ""; ?>">
                    <?php
                        // //
                        // // - example implementation of getting the header field
                        // //    for each of the blocks
                        // //
                        // _s_the_field( $module_title , array(
                        //     'before'    => '<header class="page-module-title"><h2>',
                        //     'after'     => '</h2></header>',
                        //     'sub_field' => true
                        // ));

                        get_template_part('modules/module', $module);
                    ?>

                    </div><!-- .cc-module -->
                <?php endwhile; ?>

            </div><!-- .secondary-content -->
    <?php
        endif;

    endif;
}

