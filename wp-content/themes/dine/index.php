<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Dine
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<?php if ( is_home() && ! is_front_page() ) :
$page_id = get_option( 'page_for_posts' );
?>

<?php if ( 'true' !== get_post_meta( $page_id, '_dine_disable_title', true ) ) : ?>

<?php if ( has_post_thumbnail( $page_id ) ) {
    $tb = get_the_post_thumbnail_url( $page_id, 'full' );
    $bg = ' style="background-image:url(' . esc_url( $tb ) .')"';
    $header_class = 'dine-parallax';
} else {
    $tb = $header_img;
    $header_class = '';
} ?>

<header id="page-header"<?php echo $bg;?> class="<?php echo esc_attr( $header_class ); ?>">
    
    <div class="container">

        <div class="dine-parallax-element">
            
            <h1 id="page-title"><?php single_post_title(); ?></h1>
            
        </div>

        <?php $subtitle = trim( get_post_meta( $page_id, '_dine_subtitle', true ) ); if ( $subtitle ) : ?>

        <div class="dine-parallax-element">
            
            <h2 id="page-subtitle"><?php echo wp_kses( $subtitle, dine_allowed_html() ); ?></h2>
            
        </div>

        <?php endif; ?>
        
        <div class="dine-parallax-element">
            
            <div class="dine-divider type-icon divider-icon has-animation" data-delay="200">

                <div class="divider-inner">

                    <div class="divider-line line-left"></div>

                            <div class="icon-wrapper">

                        <span class="icon"><i class="fa fa-star"></i></span>
                    </div><!-- .icon-wrapper -->

                    <div class="divider-line line-right"></div>

                </div><!-- .divider-inner -->

            </div>
            
        </div>

    </div>
    
    <div class="row-overlay"></div>

</header><!-- #page-header -->

<?php endif; // display title ?>

<?php elseif ( is_home() ) : // and is front page

$header_img = get_option( 'dine_blog_hero' );
if ( $header_img ) :
?>
<header id="page-header" style="background-image:url(<?php echo esc_url( $header_img ); ?>)" class="dine-parallax">
    
    <div class="container">
        
    </div>
    
</header>
<?php
endif;
?>
<?php elseif ( is_archive() ) : ?>

<header id="page-header">

    <div class="container">

        <h1 id="page-title"><?php the_archive_title(); ?></h1>
    
    </div>
        
</header>

<?php elseif ( is_search() ) : ?>

<header id="page-header">

    <div class="container">

        <h1 id="page-title"><?php echo get_query_var( 's' ); ?></h1>
    
    </div>
        
</header>
    
<?php endif; // is_home() or not ?>

<div id="page-wrapper" class="page-wrapper">

    <div class="container">

        <div id="primary" class="content-area">

            <?php
            if ( have_posts() ) :

                $layout = '';
                if ( ! is_home() ) $layout = get_option( 'dine_archive_style', '' );
                if ( ! $layout ) $layout = get_option( 'dine_blog_style', 'standard' );

                if ( 'grid' !== $layout && 'list' !== $layout ) $layout = 'standard';

                $cl = array( 'dine-blog' );
                $cl[] = 'blog-' . $layout;

                $cl = join( ' ', $cl );
                echo '<div class="' . esc_attr( $cl ). '">';

                /* Start the Loop */
                while ( have_posts() ) : the_post();

                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    get_template_part( 'parts/content', $layout );

                endwhile;

                echo '</div>';

                dine_pagination();

            else :

                get_template_part( 'parts/content', 'none' );

            endif;
            ?>

        </div><!-- #primary -->

        <?php dine_maybe_sidebar(); ?>

    </div>

</div>

<?php get_footer();