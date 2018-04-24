<?php
if ( ! class_exists( 'Dine_Gallery' ) ) :
/**
 * Gallery Addon for Visual Composer
 *
 * @since 1.0
 */
class Dine_Gallery extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/gallery/';
        $this->args = array(
            'base'      => 'dine_gallery',
            'name'      => esc_html__( 'Gallery', 'dine' ),
            'desc'      => esc_html__( 'Displays Image Gallery', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
    
        return 'images, lightbox, layout, column, ratio, caption, css';
    
    }
    
}

$instance = new Dine_Gallery();
$instance->init();

endif;