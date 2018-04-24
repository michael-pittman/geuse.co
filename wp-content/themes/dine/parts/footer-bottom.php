<?php
$class = array( 'footer-bottom' );
$class = join( ' ', $class );
?>

<div id="footer-bottom" class="footer-bottom">

    <div class="container">
        
        <?php 
$logo = trim( get_option( 'dine_footer_logo' ) );
if ( $logo ) { ?>

        <div id="footer-logo">
        
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        
                <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( 'Footer Logo', 'dine' ); ?>" />
                
            </a>
            
        </div>
        
<?php } ?>
        
        <?php if ( has_nav_menu( 'footer' ) && $logo && 'false' !== get_option( 'dine_footer_star_icon', 'true' ) ) : // we need separator only when both elements exist ?>
        
        <div class="dine-divider type-icon divider-icon has-animation" data-delay="200">
    
            <div class="divider-inner">

                <div class="divider-line line-left"></div>

                        
                <div class="icon-wrapper">

                    <?php if ( $icon = trim( get_option( 'dine_footer_star_icon_replacement' ) ) ) $fa = "fa fa-{$icon}"; else $fa = 'fa fa-star'; ?>

                    <span class="icon"><i class="<?php echo esc_attr( $fa ); ?>"></i></span>

                </div><!-- .icon-wrapper -->

                <div class="divider-line line-right"></div>

            </div><!-- .divider-inner -->

        </div>
        
        <?php endif; // display star icon ?> 
        
        <?php if ( has_nav_menu( 'footer' ) ) :
        wp_nav_menu(array(
            'theme_location'	=>	'footer',
            'menu_id'           =>  'footernav',
            'depth'				=>	1,
            'container_class'	=>	'footernav',
        ));
        endif; ?>
        
    </div><!-- .container -->

</div><!-- #footer-bottom -->