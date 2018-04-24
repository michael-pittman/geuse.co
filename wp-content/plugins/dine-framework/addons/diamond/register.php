<?php
/**
 * Diamond Addon for Visual Composer
 *
 * @since 1.0
 */
if ( ! class_exists( 'Dine_Diamond' ) ) :

class Dine_Diamond extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/diamond/';
        $this->args = array(
            'base'      => 'diamond',
            'name'      => esc_html__( 'Diamond', 'dine' ),
            'desc'      => esc_html__( 'Displays Diamond', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        
        return 'background, color, animation, delay, css';
        
    }
    
}

$instance = new Dine_Diamond();
$instance->init();

endif;