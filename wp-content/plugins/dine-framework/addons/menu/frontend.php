<?php
$html = '';

echo '<div class="dine-menu-wrapper">';

if ( $title ) echo '<h2 class="dine-menu-heading">' . $title  .'</h2>';

echo '<div class="dine-menu">';

$items = vc_param_group_parse_atts( $items );
if ( $items && is_array( $items ) ) {

    foreach ( $items as $item ) {
        
        extract( wp_parse_args( $item, array(
            'price' => '',
            'name' => '',
            'desc' => '',
            'image' => '',
            'highlight' => '',
        ) ) );
        
        ?>

<div class="dine-menu-item<?php if ( 'true' === $highlight ) { echo ' highlighted'; } ?>">
    
    <?php if ( $image && $image = wp_get_attachment_image( $image, 'thumbnail' ) ) : ?>
    <div class="menu-item-image">
        
        <?php echo $image; ?>
        
    </div>
    <?php endif; ?>
    
    <div class="menu-item-text">
    
        <h3 class="menu-item-name"><?php echo $name; ?></h3>

        <span class="menu-item-price"><?php echo $price; ?></span>

        <div class="menu-item-desc">

            <?php echo do_shortcode( $desc ); ?>

        </div>
        
    </div>
    
</div><!-- .dine-menu-item -->


<?php }
    
}

echo '</div></div>';