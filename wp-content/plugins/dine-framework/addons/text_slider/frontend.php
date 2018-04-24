<?php
// supports old version
$text = trim( $text );
$lines = explode( ',', $text );

$slider_css = array();
$attrs = array();
if ( $color ) {
    $slider_css[] = "color:{$color}";
}
if ( $size ) {
    if ( is_numeric( $size ) ) $size .= 'px';
    $slider_css[] = "font-size:{$size}";
}
$slider_css = join( ';', $slider_css );
if ( $slider_css ) {
    $slider_css = 'style="' . esc_attr( $slider_css ) . '"';
}

$all_effects = array( 'rotate-2', 'rotate-3', 'slide', 'type', 'zoom', 'scale' );
if ( ! in_array( $effect, $all_effects ) ) $effect = 'rotate-3';

$slider_class = array( 'cd-headline', $effect );
$word_wrapper_class = 'cd-words-wrapper';
if ( 'type' == $effect || 'rotate-2' == $effect || 'rotate-3' == $effect || 'scale' == $effect ) $slider_class[] = 'letters';
if ( 'type' == $effect ) $word_wrapper_class .= ' waiting';

// Animation
if ( '' != $animation ) {
    $slider_class[] = 'dine-animation-element';
    $slider_class[] = 'animation-' . $animation;
    $delay = str_replace( 'ms', '', $delay );
    $delay = absint( $delay );
    $attrs[] = 'data-delay="' . $delay . '"';
}

$slider_class = join( ' ', $slider_class );
$attrs[] = $slider_css;
$attrs[] = 'data-timer="' . esc_attr( $timer ). '"';

if ( count( $lines ) > 1 ) {
    
    $attrs[] = 'class="' . esc_attr( $slider_class ) . '"';
    $attrs = join( ' ', $attrs );
    
    echo '<div ' . $attrs . '><span class="' . esc_attr( $word_wrapper_class ). '">';

    foreach ( $lines as $i => $line ) {

        if ( ! $i ) {
            $class = 'is-visible text-slide';
        } else {
            $class = 'text-slide';
        }

        echo '<b class="' . esc_attr( $class ) . '">' . $line . '</b>';

    }

    echo '</span></div>';
    
} elseif ( count( $lines ) == 1 ) {
    
    $single_class = 'cd-headline cd-single-headline';
    if ( '' != $animation ) {
        $single_class .= ' dine-animation-element';
        $single_class .= ' animation-' . $animation;
    }
    $attrs[] = 'class="' . esc_attr( $single_class ) . '"';
    $attrs = join( ' ', $attrs );
    
    echo '<div ' . $attrs . '><span>';
    
    echo $lines[0];
    
    echo '</span></div>';

}