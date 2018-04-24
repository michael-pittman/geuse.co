<?php
/**
 * Imagebox Addon for Visual Composer
 *
 * @since 1.0
 */
if ( ! class_exists( 'Dine_Imagebox' ) ) :

class Dine_Imagebox extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/imagebox/';
        $this->args = array(
            'base'      => 'imagebox',
            'name'      => esc_html__( 'Imagebox', 'dine' ),
            'desc'      => esc_html__( 'Displays Imagebox', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        
        return 'image, title, title_weight, subtitle, link, ratio, overlay, text_color, animation, css';
        
    }
    
}

$instance = new Dine_Imagebox();
$instance->init();

endif;