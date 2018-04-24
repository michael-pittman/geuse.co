<?php
$attrs = array();
$icon_class = array( 'dine-icon' );

if ( ! $icon ) $icon = 'fa fa-angle-down';
$icon_html = '<span class="icon"><i class="' . esc_attr( $icon ) . '"></i></span>';

// Align
if ( 'center' != $align && 'left' != $align && 'right' != $align ) {
    $align = 'inline';
}
$align_class = ' icon-wrapper-' . $align;

// CSS
$css = array();
$css_hover = array();
$id = '';
$css_style = '';
if ( $color ) {
    $css[] = 'color:' . $color;
    $icon_class[] = 'custom-color';
}
if ( $hover_color ) {
    $css_hover[] = 'color:' . $hover_color;
}
if ( $hover_background ) {
    $css_hover[] = 'background:' . $hover_background;
    $css_hover[] = 'border-color:' . $hover_background;
}

// Icon Size
$size = absint( $size );
if ( ! $size ) $size = 24;
$css[] = 'width:' . $size . 'px';
$css[] = 'height:' . $size . 'px';
$css[] = 'line-height:' . ( $size - 4 ) . 'px';

if ( $css && ! $css_hover ) {
    $attrs[] = 'style="' . esc_attr( join( ';', $css ) ) . '"';
} elseif ( $css_hover ) {
    $id = 'icon-' . rand( 0, 1000 );
    $css_style .= '#' . $id . '{' . join( ';', $css ) . '}';
    $css_style .= '#' . $id . ':hover{' . join( ';', $css_hover ) . '}';
    $css_style = '<style>' . $css_style . '</style>';
    $attrs[] = 'id="' . esc_attr( $id ). '"';
}

// Animation
if ( '' != $animation ) {
    $icon_class[] = 'dine-animation-element';
    $icon_class[] = 'animation-' . $animation;
    $delay = str_replace( 'ms', '', $delay );
    $delay = absint( $delay );
    $attrs[] = 'data-delay="' . $delay . '"';
}

// Title
$open_attrs = array();
if ( $title ) {
    $attrs[] = 'title="' . esc_attr( $title ) . '"';
}

// Link
$link = vc_build_link( $link );
$tag = 'span';
if ( $link[ 'url' ] ) {
    
    $attrs[] = 'href="' . esc_url( $link[ 'url' ] ) . '"';
    
    if ( $link[ 'target' ] ) {
        $attrs[] = 'target="' . esc_attr( $link[ 'target' ] ) . '"';
    }
    $tag = 'a';
}

/**
 * Render
 */
$icon_class = join( ' ', $icon_class );
$attrs[] = 'class="' . esc_attr( $icon_class ). '"';
$attrs = join( ' ', $attrs );

echo $css_style;
?>

<div class="dine-icon-wrapper<?php echo $align_class ; ?>">
    
    <?php echo '<' . $tag . ' ' . $attrs . '>' . $icon_html . '</' . $tag . '>' ; ?>
    
</div><!-- .dine-icon-wrapper -->