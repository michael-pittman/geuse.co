<?php
$text = trim( $text );
if ( ! $text ) $text = 'About';

$rotate = intval( $rotate );
$arctext_style = ' style="transform:rotate(' . $rotate . 'deg);';

if ( $color ) {
    $arctext_style .= 'color:' . $color . ';';
}

$arctext_style .= '"';

$link = vc_build_link( $link );
if ( $link[ 'url' ] ) {
    
    $open = '<a class="dine-arctext" href="' . esc_url( $link[ 'url' ] ) . '"' . $arctext_style;
    
    if ( $link[ 'target' ] ) {
        $open .= ' target="' . esc_attr( $link[ 'target' ] ) . '"';
    }
    
    $open .= '>';
    $close = '</a>';
} else {
    
    $open = '<div class="dine-arctext"' . $arctext_style . '>';
    $close = '</div>';
    
}
    
echo $open;
?>

    <span><?php echo esc_html( $text ); ?></span>

<?php echo $close;