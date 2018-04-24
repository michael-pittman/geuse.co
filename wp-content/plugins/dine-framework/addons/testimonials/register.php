<?php
if ( ! class_exists( 'Dine_Testimonials_Shortcode' ) ) :
/**
 * Testimonials
 *
 * @since 1.0
 */
class Dine_Testimonials_Shortcode extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/testimonials/';
        $this->args = array(
            'base'      => 'testimonials',
            'name'      => esc_html__( 'Testimonials', 'dine' ),
            'desc'      => esc_html__( 'Displays testimonials', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        return 'testimonials';
    }
    
}

$instance = new Dine_Testimonials_Shortcode();
$instance->init();

endif;