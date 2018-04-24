<?php
$class = array( 'dine-list' );

// color
$style = '';
if ( $color ) {
    $class[] = 'custom-color';
    $style = ' style="color:' . esc_attr( $color ) . '"';
}

if ( ! $content ) {
    $content = '<ul><li>Your item 1</li><li>Your item 2</li><li>Your item 3</li></ul>';
}
$content = wpb_js_remove_wpautop( $content, true ); // fix unclosed/unwanted paragraph tags in $content
if ( ! $content ) return;

// Join
$class = join( ' ', $class );

?>
<div class="<?php echo esc_attr( $class ); ?>"<?php echo $style; ?>>
    
    <?php echo do_shortcode( $content ); ?>

</div><!-- .dine-list -->