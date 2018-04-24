<?php
$html = '';

echo '<div class="dine-testimonials dine-flexslider"><div class="flexslider"><ul class="slides">';

$testimonials = vc_param_group_parse_atts( $testimonials );
if ( $testimonials && is_array( $testimonials ) ) {

    foreach ( $testimonials as $testimonial ) {
        
        extract( wp_parse_args( $testimonial, array(
            'name' => '',
            'from' => '',
            'text' => '',
            'rating' => '',
            'avatar' => '',
        ) ) );
        
        $text = trim( $text );
        if ( $text == '' ) continue;
        
        ?>

<li class="dine-testimonial">
    
    <div class="testimonial-content">
        
        <?php echo do_shortcode( $text ); ?>
        
    </div><!-- .testimonial-content -->
    
    <?php if ( $rating && 0 < $rating && $rating <= 5 ) { ?>
    
    <div class="testimonial-rating">
        
        <span style="width:<?php echo $rating * 20; ?>%">Rated <strong class="rating"><?php echo $rating; ?></strong> out of 5</span>
    
    </div><!-- .testimonial-rating -->
        
    <?php } ?>
    
    <div class="testimonial-meta">
        
        <?php if ( $avatar && $avatar = wp_get_attachment_image( $avatar, 'thumbnail' ) ) { ?>
        
        <div class="testimonial-avatar">
            <?php echo $avatar; ?>
        </div>
        
        <?php } ?>
        
        <div class="testimonial-meta-text">
            
            <?php if ( $name ) { ?>
            <h4 class="testimonial-name"><?php echo $name; ?></h4>
            <?php } ?>
            <?php if ( $from ) { ?>
            <div class="testimonial-from"><?php echo $from; ?></div>
            <?php } ?>
            
        </div><!-- .testimonial-meta-text -->
        
    </div><!-- .testimonial-meta -->
    
</li><!-- .dine-testimonial -->


<?php }
    
}

echo '</ul></div></div><!-- .dine-testimonials -->';