<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package sherman
 */

get_header(); ?>

	<div id="primary" class="content-area">
        
        <?php while ( have_posts() ) : the_post(); ?>
            
            <?php if ( '' !== $post->post_content ) : ?>
                <main id="main" class="site-main" role="main">
                    <?php get_template_part( 'content', 'page' ); ?>
                </main><!-- #main -->
            <?php endif; ?>

            <?php sk_the_page_blocks(); ?>

        <?php endwhile; // end of the loop. ?>

    </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
