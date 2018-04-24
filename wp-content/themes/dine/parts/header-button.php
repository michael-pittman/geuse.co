<?php 
$url = trim( get_option( 'dine_header_btn_url' ) );
$line1 = trim( get_option( 'dine_header_btn_first_line' ) );
$line2 = trim( get_option( 'dine_header_btn_second_line' ) );
if ( ! $url || ( ! $line1 && ! $line2 )  ) return;
?>
<div class="header-cta">

    <a href="<?php echo esc_url( $url ); ?>">
        
        <span>
        
            <?php if ( $line1 ) { ?>
            <span class="header-btn-line-1"><?php echo esc_html( $line1 ); ?></span>
            <?php } ?>

            <?php if ( $line2 ) { ?>
            <span class="header-btn-line-2"><?php echo esc_html( $line2 ); ?></span>
            <?php } ?>
            
        </span>
    
    </a>
    
</div><!-- .header-cta -->