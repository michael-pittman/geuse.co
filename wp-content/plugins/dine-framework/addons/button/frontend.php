<?php
// button text is mandatory
if ( ! $text ) return;
$class = array( 'dine-btn' );
$attrs = array();

// link
$link = vc_build_link( $link );
if ( $link[ 'url' ] ) {
    $attrs[] = 'href="' . esc_url( $link[ 'url' ] ) . '"';
    if ( $link[ 'title' ] ) {
        $attrs[] = 'title="' . esc_attr( $link[ 'title' ] ) . '"';
    }
    if ( $link[ 'target' ] ) {
        $attrs[] = 'target="' . esc_attr( $link[ 'target' ] ) . '"';
    }
} elseif ( isset( $atts[ 'url' ] ) && $atts[ 'url' ] ) {
    $attrs[] = 'href="' . esc_url( $atts[ 'url' ] ) . '"';
    if ( isset( $atts[ 'target' ] ) && $atts[ 'target' ] ) {
        $attrs[] = 'target="' . esc_attr( $atts[ 'target' ] ) . '"';
    }
}

// style
$predefined_styles = array(
    'primary', 'outline', 'fill'
);
if ( ! in_array( $style, $predefined_styles ) ) $style = 'primary';
$class[] = 'btn-' . $style;

// icon
$icon_html = '';
if ( $icon ) {
    $icon_html = '<i class="' . esc_attr( $icon ) . '"></i>';
    $class[] = 'has-icon';
}

// onclick
if ( $onclick ) {
    $attrs[] = 'onclick="' . esc_attr( $onclick ) . '"';
}

// Animation
if ( '' != $animation ) {
    $class[] = 'dine-animation-element';
    $class[] = 'animation-' . $animation;
    $delay = str_replace( 'ms', '', $delay );
    $delay = absint( $delay );
    $attrs[] = 'data-delay="' . $delay . '"';
}

$class = join( ' ', $class );

// CSS
$css = array();
$css_hover = array();
$id = '';
$css_style = '';
if ( $color && ( 'primary' == $style || 'outline' == $style || 'fill' == $style ) ) {
    $css[] = 'color:' . $color;
}
if ( $background && 'primary' == $style ) {
    $css[] = 'background:' . $background;
}
if ( $hover_color && ( 'primary' == $style || 'outline' == $style || 'fill' == $style ) ) {
    $css_hover[] = 'color:' . $hover_color;
}
if ( $hover_background && ( 'primary' == $style || 'fill' == $style ) ) {
    $css_hover[] = 'background:' . $hover_background;
    if ( 'fill' == $style ) {
        $css_hover[] = 'border-color:' . $hover_background;
    }
}
if ( $css && ! $css_hover ) {
    $attrs[] = 'style="' . esc_attr( join( ';', $css ) ) . '"';
} elseif ( $css_hover ) {
    $id = 'btn-' . rand( 0, 1000 );
    $css_style .= '#' . $id . '{' . join( ';', $css ) . '}';
    $css_style .= '#' . $id . ':hover{' . join( ';', $css_hover ) . '}';
    $css_style = '<style>' . $css_style . '</style>';
    $attrs[] = 'id="' . esc_attr( $id ). '"';
}

$attrs[] = 'class="' . esc_attr( $class ). '"';
$attrs = join( ' ', $attrs );

echo $css_style;
?>
<a <?php echo $attrs; ?>><?php echo '<span>' . $text . '</span>' . $icon_html; ?></a>