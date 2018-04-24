<?php /* --------------- FOOTER SIDEBAR --------------- */ ?>
<?php ob_start(); $cols = 0; ?>

<?php for ( $i = 1; $i <= 3; $i ++ ) : ?>

<?php if ( is_active_sidebar( 'footer-' . $i ) ) { $cols++; ?>

<aside class="widget-area footer-col">

    <?php dynamic_sidebar( 'footer-' . $i ); ?>

</aside><!-- #secondary -->

<?php } ?>

<?php endfor; ?>

<?php $footer_sidebar = trim ( ob_get_clean() ); ?>

<?php if ( $footer_sidebar ) { 

$class = array( 'footer-widgets' );
$class = join( ' ', $class );

?>

<div id="footer-sidebar" class="<?php echo esc_attr( $class ); ?>">

    <div class="container">

        <?php echo '<div class="footer-sidebar-wrapper column-' . absint($cols) . '">' . $footer_sidebar . '</div>'; ?>

    </div><!-- .container -->

</div><!-- #footer-sidebar -->

<?php } // footer sidebar ?>