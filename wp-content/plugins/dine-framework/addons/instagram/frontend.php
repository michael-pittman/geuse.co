<?php

$class = array( 'dine-instagram' );

$column = absint( $column );
if ( $column < 2 || $column > 10 ) $column = 3;
$class[] = 'column-' . $column;

if ( ! function_exists( 'dine_get_instagram_photos' ) ) $photos = null;
else $photos = dine_get_instagram_photos( $username, $number, $cache_time );

$class = join( ' ', $class );

if ( $photos && is_array( $photos ) ) :

?>

<div class="<?php echo esc_attr( $class ); ?>">

    <?php
    foreach ( $photos as $photo )  :

    if ( isset( $photo[ 'link' ] ) ) {
        $open = '<a href="' . esc_url( $photo[ 'link' ] ) . '" target="_blank" title="' . esc_attr( $photo[ 'description' ] ). '">';
        $close = '</a>';
    } else {
        $open = $close = '';
    }

    // SRC
    $src = '';
    $src = $photo[ 'large' ];
    if ( ! $src ) {
        $src = $photo[ 'medium' ];
    }
    if ( ! $src ) {
        $src = $photo[ 'thumbnail' ];
    }
    if ( ! $src ) continue;

    // ROLLOVER
    $rollover = '';
    if ( 'true' == $instagram_meta ) {

        $rollover .= '<span class="instagram-rollover"><span class="rollover-text">';

        $rollover .= '<span><i class="fa fa-heart"></i>' . $photo[ 'likes' ] . '</span>';
        $rollover .= '<span><i class="fa fa-comment"></i>' . $photo[ 'comments' ] . '</span>';

        $rollover .= '</span></span>';
        
        $rollover .= '<span class="instagram-overlay"></span>';

    }

        ?>

        <div class="dine-instagram-item">

            <figure class="instagram-item-image">

                <?php echo $open . '<img src="' . esc_url( $src ). '" alt="' . esc_attr( $photo[ 'description' ] ) . '" />' . $rollover . $close ; ?>

            </figure>

        </div><!-- .dine-instagram-item -->

    <?php endforeach; // photos
    
endif; // $photos & is_array( $photos )

?>
</div><!-- .dine-instagram -->