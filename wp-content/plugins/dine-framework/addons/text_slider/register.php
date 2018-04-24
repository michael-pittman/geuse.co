<?php
if ( ! class_exists( 'Dine_Text_Slider_Shortcode' ) ) :
/**
 * Testimonial Slider
 *
 * @since 1.0
 */
class Dine_Text_Slider_Shortcode extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/text_slider/';
        $this->args = array(
            'base'      => 'text_slider',
            'name'      => esc_html__( 'Text Slider', 'dine' ),
            'desc'      => esc_html__( 'Displays a text slider', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        
        return 'timer, color, size, effect, text, animation, delay, css';
        
    }
    
}

$instance = new Dine_Text_Slider_Shortcode();
$instance->init();

endif;