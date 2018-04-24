<?php
$class = array( 'dine-heading' );

// Join
$class = join( ' ', $class );
?>
<div class="<?php echo esc_attr( $class ); ?>">
    
    <div class="heading-container">

        <?php echo "<{$tag} class=\"heading-title\">" . wp_kses_post( $title ) . "</{$tag}>"; ?>

    </div>
    
    <?php if ( $subtitle ) : ?>
    
    <h4 class="heading-subtitle">
    
        <?php echo wp_kses_post( $subtitle ); ?>
    
    </h4>
    
    <?php endif; ?>

</div><!-- .dine-heading -->