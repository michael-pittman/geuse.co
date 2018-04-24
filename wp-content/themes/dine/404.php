<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Dine
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<header id="page-header">

    <div class="container">

        <h1 id="page-title"><?php echo esc_html__( '404', 'dine' ); ?></h1>
    
    </div>
        
</header>

<div id="page-wrapper" class="page-wrapper">

    <div class="container">
        
        <div class="page-content">
            
            <p><?php echo esc_html__( 'It looks like nothing was found at this location. Maybe try a search?', 'dine' ); ?></p>

            <?php get_search_form(); ?>

        </div><!-- .page-content -->
        
	</div><!-- .container -->
    
</div><!-- #page-wrapper -->

<?php get_footer();
