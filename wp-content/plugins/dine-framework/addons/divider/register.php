<?php
/**
 * Divider Addon for Visual Composer
 *
 * @since 1.0
 */
if ( ! class_exists( 'Dine_Divider' ) ) :

class Dine_Divider extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/divider/';
        $this->args = array(
            'base'      => 'divider',
            'name'      => esc_html__( 'Divider', 'dine' ),
            'desc'      => esc_html__( 'Displays Divider', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        
        return 'icon_type, image, image_width, icon, color, thickness, animation, delay, css';
        
    }
    
}

$instance = new Dine_Divider();
$instance->init();

endif;