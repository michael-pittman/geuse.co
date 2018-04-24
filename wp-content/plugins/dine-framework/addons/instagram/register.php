<?php
if ( ! class_exists( 'Dine_Instagram' ) ) :
/**
 * Instagram Addon for Visual Composer
 *
 * @since 1.0
 */
class Dine_Instagram extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/instagram/';
        $this->args = array(
            'base'      => 'dine_instagram',
            'name'      => esc_html__( 'Instagram', 'dine' ),
            'desc'      => esc_html__( 'Displays Instagram Grid', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
    
        return 'username, number, cache_time, instagram_meta, column, css';
    
    }
    
}

$instance = new Dine_Instagram();
$instance->init();

endif;