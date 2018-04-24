<?php
if ( 2 > $column || 6 < $column ) $column = 4;
$items = vc_param_group_parse_atts( $items );
if ( $items && is_array( $items ) ) {

    echo '<div class="dine-counters column-' . $column . '">';

    foreach ( $items as $item ) {
        
        extract( wp_parse_args( $item, array(
            'title' => '',
            'desc' => '',
            'number' => 26,
        ) ) );

            $counter_class = array( 'dine-counter' );
            $counter_class = join(' ', $counter_class);

            $number = absint( $number );
            if ( $number <= 0 || $number > 10000000000000 ) $number = 26;
?>

        <div class="<?php echo esc_attr( $counter_class ); ?>" data-number="<?php echo $number; ?>">

            <div class="counter-inner">

                <div class="counter-number">
                    <span><?php echo $number; ?></span>
                </div><!-- .counter-number -->

                <?php if ( $title || $desc ) { ?>
                <div class="counter-text">

                    <?php if ( $title ) { ?>
                    <h3 class="counter-title">
                        <?php echo esc_html( $title ); ?>
                    </h3>
                    <?php } ?>

                    <?php if ( $desc ) { ?>
                    <div class="counter-desc">
                        <?php echo do_shortcode( $desc ); ?>
                    </div><!-- .counter-desc -->
                    <?php } ?>

                </div><!-- .counter-text -->
                <?php } // title or desc ?>

            </div><!-- .counter-inner -->

        </div><!-- .dine-counter -->

<?php } // endforeach
    
    echo '</div>';
    
} // endif
?>