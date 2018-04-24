<?php
$imagebox_class = array( 'dine-imagebox' );

$image = trim( $image );
$image_css = '';
if ( $image ) {

    $img = wp_get_attachment_image_src( $image, 'full' );
    if ( $img ) {
        $image_css = ' style="background-image:url(' . esc_url( $img[0] ) . ')"';
    }

}

$overlay_css = '';
if ( $overlay ) {
    $overlay_css = ' style="background-color:' . esc_attr( $overlay ) . '"';
}

// Height CSS
$height_css = '';
if ( $ratio ) {
    $dims = explode( ':', $ratio );
    $w = isset( $dims[0] ) ? absint( $dims[0] ) : 0;
    $h = isset( $dims[1] ) ? absint( $dims[1] ) : 0;
    if ( $h > 0 && $w > 0 ) {
        $height_css = ' style="padding-bottom:' . ( $h/$w ) * 100 . '%;"';
    }
}

// Title CSS
$title_css = '';
if ( $text_color ) $title_css = ' style="color:' . esc_attr( $text_color ) . '"';

// Title weight
if ( $title_weight ) {
    $imagebox_class[] = 'title-weight-' . $title_weight;
}

// Link
$link = vc_build_link( $link );
$link[ 'url' ] = trim( $link[ 'url' ] );
if ( $link[ 'url' ] ) $imagebox_class[] = 'has-link';

// Animation
if ( 'true' == $animation ) {
    $imagebox_class[] = 'has-animation';
}

/**
 * Render
 */
$imagebox_class = join(' ',$imagebox_class);
?>

<div class="<?php echo esc_attr( $imagebox_class ); ?>">
    
    <div class="imagebox-inner">
    
        <div class="bg-thumb">
            <div class="bg-element"<?php echo $image_css; ?>></div>
            <div class="height-element"<?php echo $height_css; ?>></div>
        </div><!-- .bg-thumb -->
        
        <div class="imagebox-overlay"<?php echo $overlay_css; ?>></div>
        
        <?php if ( $title || $subtitle ) : ?>
        <div class="imagebox-text"<?php echo $title_css; ?>>
            
            <?php if ( $subtitle ) { ?>
            
            <div class="imagebox-subtitle-wrapper">
                <h3 class="imagebox-subtitle"><?php echo esc_html( $subtitle ); ?></h3>
            </div>
            
            <?php } ?>
        
            <?php if ( $title ) { ?>
            
            <div class="imagebox-title-wrapper">
                <h2 class="imagebox-title"><?php echo esc_html( $title ); ?></h2>
            </div>
            
            <?php } ?>
            
        </div><!-- .imagebox-text -->
        <?php endif; ?>
        
        <?php if ( $link[ 'url' ] ) {
        $target = ( trim($link[ 'target' ]) == '_blank' ) ? '_blank' : '_self';
        ?>
        
        <a href="<?php echo esc_url( $link[ 'url' ] ); ?>" target="<?php echo esc_attr( $target ); ?>" class="wrap-link"></a>
        
        <?php } ?>
    
    </div><!-- .imagebox-inner -->
    
</div><!-- .dine-imagebox -->