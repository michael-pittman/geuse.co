<?php if ( function_exists( 'rtb_print_booking_form' ) ) { ?>
<div class="dine-restaurant-reservation">
    <?php echo rtb_print_booking_form(); ?>
</div>
<?php } else { ?>

<div class="error">
    <?php echo 'You have to install & activate <a href="https://wordpress.org/plugins/restaurant-reservations/" target="_blank">Restaurant Reservations</a> to display a booking form'; ?>
</div>
<?php } ?>