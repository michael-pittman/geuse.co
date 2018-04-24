<?php
if ( ! class_exists( 'Dine_Menu_Shortcode' ) ) :
/**
 * Menu
 *
 * @since 1.0
 */
class Dine_Menu_Shortcode extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/menu/';
        $this->args = array(
            'base'      => 'menu',
            'name'      => esc_html__( 'Menu', 'dine' ),
            'desc'      => esc_html__( 'Displays a food menu', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        return 'title, items';
    }
    
}

$instance = new Dine_Menu_Shortcode();
$instance->init();

endif;