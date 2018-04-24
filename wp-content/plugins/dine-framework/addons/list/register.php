<?php
if ( ! class_exists( 'Dine_List_Shortcode' ) ) :
/**
 * List Addon for Visual Composer
 *
 * @since 1.0
 */
class Dine_List_Shortcode extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/list/';
        $this->args = array(
            'base'      => 'list',
            'name'      => esc_html__( 'List', 'dine' ),
            'desc'      => esc_html__( 'Displays a nice list', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        
        return 'color, css';
        
    }
    
}

$instance = new Dine_List_Shortcode();
$instance->init();

endif;