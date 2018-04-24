<?php
/**
 * Icon Addon for Visual Composer
 *
 * @since 1.0
 */
if ( ! class_exists( 'Dine_Icon' ) ) :

class Dine_Icon extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/icon/';
        $this->args = array(
            'base'      => 'icon',
            'name'      => esc_html__( 'Icon', 'dine' ),
            'desc'      => esc_html__( 'Displays Icon', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function wrapper() {
        return false;
    }
    
    function param_list() {
        
        return 'icon, link, title, color, hover_color, hover_background, size, animation, delay, align';
        
    }
    
}

$instance = new Dine_Icon();
$instance->init();

endif;