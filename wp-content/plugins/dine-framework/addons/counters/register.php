<?php
/**
 * Counters Addon for Visual Composer
 *
 * @since 1.0
 */
if ( ! class_exists( 'Dine_Counters' ) ) :

class Dine_Counters extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/counters/';
        $this->args = array(
            'base'      => 'counters',
            'name'      => esc_html__( 'Counters', 'dine' ),
            'desc'      => esc_html__( 'Displays Counters', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        
        return 'column, items';
        
    }
    
}

$instance = new Dine_Counters();
$instance->init();

endif;