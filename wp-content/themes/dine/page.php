<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Dine
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<?php if ( 'true' !== get_post_meta( get_the_ID(), '_dine_disable_title', true ) ) : 

if ( has_post_thumbnail( $page_id ) ) {
    $tb = get_the_post_thumbnail_url( $page_id, 'full' );
    $bg = ' style="background-image:url(' . esc_url( $tb ) .')"';
    $header_class = 'dine-parallax';
} else {
    $bg = '';
    $header_class = '';
}

?>

<header id="page-header"<?php echo $bg;?> class="<?php echo esc_attr( $header_class ); ?>">
    
    <div class="container">
    
        <div class="dine-parallax-element">
        
            <h1 id="page-title"><?php the_title(); ?></h1>
            
        </div>

        <?php $subtitle = trim( get_post_meta( get_the_ID(), '_dine_subtitle', true ) ); if ( $subtitle ) : ?>

        <div class="dine-parallax-element">
            
            <h2 id="page-subtitle"><?php echo wp_kses( $subtitle, dine_allowed_html() ); ?></h2>
            
        </div>

        <?php endif; ?>
        
        <?php if ( 'false' !== get_option ( 'dine_page_star_icon', 'true' ) ) : ?>
        
        <div class="dine-parallax-element">
        
            <div class="dine-divider type-icon divider-icon has-animation" data-delay="200">

                <div class="divider-inner">

                    <div class="divider-line line-left"></div>

                        <div class="icon-wrapper">

                            <?php if ( $icon = trim( get_option( 'dine_page_star_icon_replacement' ) ) ) $fa = "fa fa-{$icon}"; else $fa = 'fa fa-star'; ?>
                            
                            <span class="icon"><i class="<?php echo esc_attr( $fa ); ?>"></i></span>
                                
                        </div><!-- .icon-wrapper -->

                    <div class="divider-line line-right"></div>

                </div><!-- .divider-inner -->

            </div>
            
        </div><!-- .dine-parallax-element -->
        
        <?php endif; ?>
        
    </div>
    
    <div class="row-overlay"></div>

</header><!-- #page-header -->

<?php endif; ?>
    
<div class="page-wrapper" id="page-wrapper">

    <div class="container">

        <div id="primary" class="content-area">

            <?php
            while ( have_posts() ) : the_post();

                get_template_part( 'parts/content', 'page' );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>

        </div><!-- #primary -->

        <?php dine_maybe_sidebar( 'page' ); ?>

    </div>

</div><!-- #page-wrapper -->

<?php get_footer();
