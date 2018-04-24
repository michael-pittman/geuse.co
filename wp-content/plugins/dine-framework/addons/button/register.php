<?php
if ( ! class_exists( 'Dine_Button' ) ) :
/**
 * Button Addon for Visual Composer
 *
 * @since 1.0
 */
class Dine_Button extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/button/';
        $this->args = array(
            'base'      => 'button',
            'name'      => esc_html__( 'Button', 'dine' ),
            'desc'      => esc_html__( 'Displays Button', 'dine' ),
            'weight'    => 190,
        );
        
        add_filter ( 'dine_element_class', array( $this, 'button_class' ), 10, 3 );
        
    }
    
    function param_list() {
    
        return 'text, icon, reveal, link, style, size, align, onclick, color, background, hover_color, hover_background, animation, delay';
        
    }
    
    /**
     * Customize the class for button element
     *
     * @since 1.0
     */
    function button_class( $element_class, $base, $atts ) {
        
        if ( 'button' == $base ) {
            $outer_class = array( 'dine-button' );

            $align = isset( $atts[ 'align' ] ) ? $atts[ 'align' ] : 'inline';

            if ( 'center' == $align || 'left' == $align || 'right' == $align ) {
                
                $outer_class[] = 'button-inline';
                $outer_class[] = 'button-' . $align;
                
            }
            
            return $outer_class;
        }
        
        return $element_class;
    
    }
    
    /**
     * Extra atts
     */
    function extra_atts( $atts ) {
        return array(
            'url' => isset( $atts[ 'url' ] ) ? $atts[ 'url' ] : '',
            'target' => isset( $atts[ 'target' ] ) ? $atts[ 'target' ] : '',
        );
    }
    
}

$instance = new Dine_Button();
$instance->init();

endif;