<?php get_header();
    // Start the loop.
    if ( have_posts() ) :
?>

<?php
if ( is_shop() || is_product_category() || is_product_tag() ) :

if ( is_shop() && ! is_search() ) {
    $shop_id = get_option( 'woocommerce_shop_page_id' );
    $show_header = ! $shop_id ||  'true' !== get_post_meta( $shop_id, '_dine_disable_title', true );
    $subtitle = trim( get_post_meta( $shop_id, '_dine_subtitle', true ) );
    
    if ( has_post_thumbnail( $shop_id ) ) {
        $tb = get_the_post_thumbnail_url( $shop_id, 'full' );
        $bg = ' style="background-image:url(' . esc_url( $tb ) .')"';
        $header_class = 'dine-parallax';
    } else {
        $bg = '';
        $header_class = '';
    }
    
} else {
    $show_header = true;
    $bg = '';
    $header_class = '';
    $subtitle = '';
}

if ( $show_header ) : ?>

<header id="page-header"<?php echo $bg;?> class="<?php echo esc_attr( $header_class ); ?>">
    
    <div class="container">
    
        <div class="dine-parallax-element">
        
            <h1 id="page-title"><?php woocommerce_page_title(); ?></h1>
            
        </div>

        <?php if ( $subtitle ) : ?>

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

<?php endif; ?>

<?php endif; // is_shop() ?>

<div class="page-wrapper" id="page-wrapper">
    
    <div class="container">

        <div id="primary" class="content-area">

                <?php
                    woocommerce_content();
                ?>
                <div class="clearfix"></div>

        </div><!-- #primary -->
        
        <?php dine_maybe_sidebar( 'shop' ); ?>
        
    </div><!-- .container -->
    
</div><!-- #page-wrapper -->
    
<?php
// End the loop.
endif;

get_footer();