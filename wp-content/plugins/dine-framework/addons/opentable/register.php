<?php
if ( ! class_exists( 'Dine_OpenTable_Shortcode' ) ) :
/**
 * Open Table
 *
 * @since 1.0
 */
class Dine_OpenTable_Shortcode extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/opentable/';
        $this->args = array(
            'base'      => 'opentable',
            'name'      => esc_html__( 'Open Table', 'dine' ),
            'desc'      => esc_html__( 'Displays a reservation form', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        return 'title, id';
    }
    
}

$instance = new Dine_OpenTable_Shortcode();
$instance->init();

endif;