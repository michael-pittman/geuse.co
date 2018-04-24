<div class="site-branding">
    
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" id="logo">
    
    <?php

    $logo_type = get_option( 'dine_logo_type', 'text' );
    
    // custom logo image
    if ( 'image' == $logo_type ) {
    
        $logo = get_option( 'dine_logo' );
        if ( ! $logo ) $logo = get_template_directory_uri() . '/assets/images/logo.png';
        
        $trans_logo = get_option( 'dine_transparent_logo' );
        
        if ( $trans_logo ) echo '<img src="' . esc_url( $trans_logo ) . '" class="transparent-logo" alt="' . esc_html__( 'Transparent Logo', 'dine' ) . '" />';
        
        echo '<img src="' . esc_url( $logo ) . '" alt="' . esc_html__( 'Logo', 'dine' ) . '" />';
    
    // Text Logo
    } else { ?>
        
    <span class="text-logo"><?php bloginfo( 'name' ); ?></span>
        
    <?php } ?>
        
    </a><!-- #logo -->

</div><!-- .site-branding -->