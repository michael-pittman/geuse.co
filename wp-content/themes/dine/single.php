<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Dine
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="page-wrapper" id="page-wrapper">
    
    <div class="container">
    
        <div id="primary" class="content-area">

            <?php
                /* Start the Loop */
                while ( have_posts() ) : the_post();

                    get_template_part( 'parts/content' );

                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

                endwhile; // End of the loop.
            ?>
        </div><!-- #primary -->
        
	   <?php dine_maybe_sidebar(); ?>
            
    </div>
        
</div>

<?php get_footer();