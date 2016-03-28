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



/**
 * wrapper to call the sk_the_field function to return
 * @param $field
 * @param $args - see above
 */
function sk_get_field($field, $args = array() ){
    $options = array_merge($args, array('return' => true));
    return sk_the_field($field, $options);
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
function sk_module_field( $field, $args = array() ){

    $options = array_merge( $args, array('sub_field' => true) );

    sk_the_field($field, $options);

}




/* --------------------------------------------
 * --rendering
 * -------------------------------------------- */


/**
 * hooks into the ACF repeater field to render all the additional
 *  page blocks for a page. Calls tempaltes in the modules/ directory
 */
function sk_the_page_blocks(){

    // check for the existance of ACF
    if ( function_exists( 'have_rows' ) === false ){
        return false;
    }

    // the page blocks repeater field
    $blocks_repeater = 'sk_page_blocks';

    if( have_rows($blocks_repeater) ) : ?>
        <div class="secondary-content">

            <?php // loop through the rows of data ?>
            <?php while ( have_rows($blocks_repeater) ) : the_row(); ?>
                <?php $module = get_sub_field( 'sk_page_block_module' ); ?>

                <section class="sk-module<?php echo $module ? " module--$module" : ""; ?>">
                    <?php
                        // //
                        // // - example implementation of getting the header field
                        // //    for each of the blocks
                        // //
                        // sk_the_field( 'sk_page_block_title' , array(
                        //     'before'    => '<header class="page-module-title"><h2>',
                        //     'after'     => '</h2></header>',
                        //     'sub_field' => true
                        // ));

                        get_template_part('modules/module', $module);
                    ?>

                </section><!-- .sk-module -->
            <?php endwhile; ?>

        </div><!-- .secondary-content -->
<?php
    endif;
}

