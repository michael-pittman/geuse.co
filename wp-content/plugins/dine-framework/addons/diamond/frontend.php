<?php
$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
if ( ! $content ) return;

$diamond_class = array( 'dine-diamond' );

// Color
$text_color_css = '';
if ( $color ) {
    $text_color_css = ' style="color:' . $color . ';"';
}

// Background
$bg_css = '';
if ( $background ) {
    $bg_css = ' style="background:' . $background . ';"';
}

// Animation
$data_delay = '';
if ( '' != $animation ) {
    $diamond_class[] = 'dine-animation-element';
    $diamond_class[] = 'animation-' . $animation;
    $delay = str_replace( 'ms', '', $delay );
    $delay = absint( $delay );
    $data_delay = ' data-delay="' . $delay . '"';
}

$diamond_class = join( ' ', $diamond_class );
?>

<div class="<?php echo esc_attr( $diamond_class ); ?>"<?php echo $text_color_css; ?><?php echo $data_delay; ?>>
    
    <div class="diamond-bg"<?php echo $bg_css; ?>></div>
    
    <div class="diamond-content">
    
        <?php echo do_shortcode( $content ); ?>
    
    </div><!-- .diamond-content -->
    
</div>