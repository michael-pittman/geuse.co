<?php
if ( ! class_exists( 'Dine_Arctext_Shortcode' ) ) :
/**
 * Arctext Addon for Visual Composer
 *
 * @since 1.0
 */
class Dine_Arctext_Shortcode extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/arctext/';
        $this->args = array(
            'base'      => 'arctext',
            'name'      => esc_html__( 'Arctext', 'dine' ),
            'desc'      => esc_html__( 'Displays arc text', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        
        return 'text, color, rotate, link, css';
        
    }
    
}

$instance = new Dine_Arctext_Shortcode();
$instance->init();

endif;