<?php
/**
 * Booking Addon for Visual Composer
 *
 * @since 1.0
 */
if ( ! class_exists( 'Dine_Booking' ) ) :

class Dine_Booking extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/booking/';
        $this->args = array(
            'base'      => 'dine_booking',
            'name'      => esc_html__( 'Booking', 'dine' ),
            'desc'      => esc_html__( 'Displays Booking Form', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        
        return 'css';
        
    }
    
}

$instance = new Dine_Booking();
$instance->init();

endif;