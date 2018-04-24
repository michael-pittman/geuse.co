<?php
/**
 * Slider Addon for Visual Composer
 *
 * @since 1.0
 */
if ( ! class_exists( 'Dine_Slider' ) ) :

class Dine_Slider extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/slider/';
        $this->args = array(
            'base'      => 'slider',
            'name'      => esc_html__( 'Slider', 'dine' ),
            'desc'      => esc_html__( 'Displays Image Slider', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
    
        return 'images, style, autoplay, autoplay_timer, arrows, bullets, caption, css';
        
    }
    
}

$instance = new Dine_Slider();
$instance->init();

endif;