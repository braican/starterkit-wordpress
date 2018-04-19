<?php
//
// Rendering the page block functionality
//


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


