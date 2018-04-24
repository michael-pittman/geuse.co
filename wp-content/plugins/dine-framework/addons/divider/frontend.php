<?php
$divider_class = array( 'dine-divider' );

/**
 * Icon Type: icon or image
 */
if ( 'image' != $icon_type ) $icon_type = 'icon';
$divider_class[] = 'type-' . $icon_type;
$divider_class[] = 'divider-' . $icon_type;

/**
 * Icon HTML
 */
$icon_html = '';
if ( 'icon' === $icon_type ) {
    
    $icon_class = $icon;
    if ( ! $icon_class ) $icon_class = 'fa fa-star';
    if ( $icon_class ) {
        $icon_html = '<span class="icon"><i class="' . esc_attr( $icon_class ) . '"></i></span>';
    }
    
} else {
    
    $image = trim( $image );
    if ( $image ) {
    
        $img = wp_get_attachment_image( $image, 'full' );
        if ( $img ) {
            $image_width = absint( $image_width );
            $image_css = '';
            if ( $image_width > 0 ) {
                $image_css = ' style="width:' . $image_width . 'px;"';
            }
            $icon_html = '<span class="image"' . $image_css . '>' . $img . '</span>';
        }
        
    }
}

// Color
$divider_css = array();
if ( $color ) {
    $divider_css[] = "color:{$color}";
}
$divider_css = join( ';', $divider_css );

if ( $divider_css ) $divider_css = ' style="' . esc_attr( $divider_css ) . '"';

// Thickness
$line_css = array();
if ( $thickness ) {
    $line_css[] = "border-top-width:{$thickness}";
    $thickness = str_replace( 'px', '', $thickness );
    $thickness = absint( $thickness );
    $line_css[] = 'margin-top:-' . round( $thickness/2 ) . 'px';
}
$line_css = join( ';', $line_css );
if ( $line_css ) $line_css = ' style="' . esc_attr( $line_css ) . '"';

// Animation
$data_delay = '';
if ( 'true' == $animation ) {
    $divider_class[] = 'has-animation';
    $delay = str_replace( 'ms', '', $delay );
    $delay = absint( $delay );
    $data_delay = ' data-delay="' . $delay . '"';
}

/**
 * Render
 */
$divider_class = join(' ',$divider_class);
?>

<div class="<?php echo esc_attr( $divider_class ); ?>"<?php echo $divider_css; ?><?php echo $data_delay; ?>>
    
    <div class="divider-inner">
    
        <div class="divider-line line-left"<?php echo $line_css; ?>></div>

        <?php if ( $icon_html ) : ?>
        <div class="icon-wrapper">

            <?php echo $icon_html; ?>

        </div><!-- .icon-wrapper -->
        <?php endif; ?>

        <div class="divider-line line-right"<?php echo $line_css; ?>></div>
        
    </div><!-- .divider-inner -->
    
</div><!-- .dine-divider -->