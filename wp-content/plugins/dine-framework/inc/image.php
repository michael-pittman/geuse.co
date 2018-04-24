<?php
if ( ! class_exists( 'Dine_VC_Single_Image' ) ) :
/**
 * We need to modify some options from VC Single Image
 *
 * @since 1.0
 */
class Dine_VC_Single_Image
{
    
    /**
	 * construct
	 */
	public function __construct() {
	}
    
    /**
	 * The one instance of class
	 *
	 * @since 1.0
	 */
	private static $instance;

	/**
	 * Instantiate or return the one class instance
	 *
	 * @since 1.0
	 * @return $instance
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
    
    /**
     * Initiate the class
     * contains action & filters
     *
     * @since 1.0
     */
    public function init() {
        
        add_action( 'vc_after_init', array( $this, 'params' ), 999 );
             
    }
    
    function params() {
        
        $param = WPBMap::getParam( 'vc_single_image', 'onclick' );
        unset($param['value'][esc_html__( 'Open prettyPhoto', 'js_composer' )]);
        $param['value'][ esc_html__( 'Open Lightbox', 'dine' ) ] = 'link_image';
        
        $param = WPBMap::getParam( 'vc_single_image', 'img_size' );
        $param['value'] = 'large';
        
        vc_update_shortcode_param( 'vc_single_image', $param );
        
    }
    
}

Dine_VC_Single_Image::instance()->init();

endif;