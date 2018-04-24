<?php
if ( ! class_exists( 'Dine_Heading_Shortcode' ) ) :
/**
 * Heading Addon for Visual Composer
 *
 * @since 1.0
 */
class Dine_Heading_Shortcode extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/heading/';
        $this->args = array(
            'base'      => 'heading',
            'name'      => esc_html__( 'Heading', 'dine' ),
            'desc'      => esc_html__( 'Displays a stylish heading', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        
        return 'title, tag, subtitle, css';
        
    }
    
}

$instance = new Dine_Heading_Shortcode();
$instance->init();

endif;