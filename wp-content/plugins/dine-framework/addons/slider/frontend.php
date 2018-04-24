<?php
$class = array( 'dine-slider' );

$images = explode ( ',', $images );
$images = array_map( 'trim', $images );
if ( empty( $images ) ) return;

$options = array(
    'cellSelector' => '.carousel-cell',
    'wrapAround' => true,
    'prevNextButtons' => ( 'true' === $arrows ),
    'pageDots' => ( 'true' === $bullets ),
    'autoPlay' => ( 'true' == $autoplay ) ? absint( $autoplay_timer ) : false,
);

if ( 'fullheight' == $style ) {
    $class[] = 'slider-fullheight';
} elseif ( 'carousel' == $style || 'fullheight_carousel' == $style ) {
    $class[] = 'slider-carousel';
    if ( 'fullheight_carousel' == $style ) {
        $class[] = 'slider-carousel-fullscreen';
    }
}

// CLASSES
$class = join( ' ', $class );

$attachments = get_posts( array(
    'posts_per_page' => -1,
    'orderby' => 'post__in',
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'post__in' => $images,
) );

if ( ! $attachments ) return;
?>
<div class="<?php echo esc_attr( $class ); ?>" data-options='<?php echo json_encode( $options ); ?>'>
    
    <div class="carousel">
        
        <?php foreach ( $attachments as $attachment ) : ?>

        <div class="carousel-cell">
            
            <?php
            if ( 'fullheight' !== $style ) {
                
                echo wp_get_attachment_image( $attachment->ID, 'full' ); 
                
            } else {
    
                echo '<div class="bg-thumb"><div class="bg-element" style="background-image:url(' . wp_get_attachment_url( $attachment->ID ) . ');"></div><div class="height-element"></div></div>';
    
            } ?>
            
            <?php if ( 'true' == $caption ) { $attachment_post = get_post( $attachment->ID ); ?>
            
            <?php if ( $attachment_post->post_excerpt || $attachment_post->post_content ) { ?>
            
            <div class="carousel-cell-caption">
                
                <?php if ( $attachment_post->post_excerpt ) { ?>
                <h3 class="carousel-cell-title" data-size="120">
                    <?php echo $attachment_post->post_excerpt; ?>
                </h3>
                <?php } ?>
                
                <?php if ( $attachment_post->post_content ) { ?>
                <div class="carousel-cell-text">
                    <p><?php echo $attachment_post->post_content; ?></p>
                </div>
                <?php } ?>
                
            </div><!-- .carousel-caption -->
            
            <div class="carousel-cell-overlay"></div>
            
            <?php } ?>
            
            <?php } ?>
            
        </div><!-- .carousel-cell -->

        <?php endforeach; // attachments ?>

    </div><!-- .carousel -->

</div><!-- .dine-slider -->