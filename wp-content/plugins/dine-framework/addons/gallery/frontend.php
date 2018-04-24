<?php
$images = explode ( ',', $images );
$images = array_map( 'trim', $images );
if ( empty( $images ) ) return;

$gallery_class = array( 'dine-gallery' );

// Attachments
$attachments = get_posts( array(
    'posts_per_page' => -1,
    'orderby' => 'post__in',
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'post__in' => $images,
) );

// layout
if ( 'metro' !== $layout ) {
    $layout = 'grid';
}
$gallery_class[] = 'gallery-' . $layout;

if ( 'grid' === $layout ) {
    
    $column = absint( $column );
    if ( $column < 2 || $column > 6 ) $column = 3;
    $gallery_class[] = 'column-' . $column;

    // Ratio
    if ( 'auto' != $ratio && 'square' != $ratio && 'portrait' != $ratio ) $ratio = 'landscape';
    $gallery_class[] = 'gallery-' . $ratio;
    
}

if ( 'true' == $lightbox ) {
    $gallery_class[] = 'dine-lightbox-gallery';
}

$gallery_class = join( ' ', $gallery_class );
$count = 0;
?>

<div class="<?php echo esc_attr( $gallery_class ); ?>">
    
    <?php foreach ( $attachments as $attachment ) : $count++; ?>

    <figure class="dine-gallery-item">
        
        <div class="dine-gallery-item-inner">
    
            <?php

            $title = trim( $attachment->post_title );
            $img_caption = trim( $attachment->post_excerpt );

            if ( 'true' == $lightbox ) {

                $fullsize = wp_get_attachment_image_src( $attachment->ID, 'full' );

                $open = '<a href="' . esc_url( $fullsize[0] ) . '" class="lightbox-link">';
                $close = '</a>';
            } else {
                $open = $close = '';
            }

            if ( 'grid' === $layout && 2 === $column ) {
                $img_thumb = 'large';
            } elseif ( 'grid' === $layout ) {
                $img_thumb = 'medium';
            } else {
                
                if ( $count % 6 === 1 || $count %6 === 4 ) {
                    $img_thumb = 'large';
                } else {
                    $img_thumb = 'medium';
                }
                
            }
            $img = wp_get_attachment_image( $attachment->ID, $img_thumb );

            ?>

            <?php echo $open . $img . $close ; ?>

            <div class="height-element"></div>

            <div class="loading-icon"></div>
            
            <?php if ( 'true' == $caption && $img_caption ) { ?>
            
            <span class="gallery-item-caption"><?php echo $img_caption; ?></span>
            
            <?php } // caption ?>
            
        </div>
    
    </figure><!-- .dine-gallery-item -->
    
    <?php endforeach; // $attachments ?>

</div><!-- .dine-gallery -->