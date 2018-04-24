<?php
if ( ! class_exists( 'Dine_VC_Row' ) ) :
/**
 * We need to modify some options from VC Row
 *
 * @since 1.0
 */
class Dine_VC_Row
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
        
        add_action( 'vc_after_init', array( $this, 'row_params' ) );
             
    }
    
    function row_params() {
        
        // Remove Params
        vc_remove_param( 'vc_row', 'parallax' );
        vc_remove_param( 'vc_row', 'parallax_image' );
        
        // vc_remove_param( 'vc_row', 'video_bg' );
        // vc_remove_param( 'vc_row', 'video_bg_url' );
        vc_remove_param( 'vc_row', 'video_bg_parallax' );
        vc_remove_param( 'vc_row', 'parallax_speed_bg' );
        vc_remove_param( 'vc_row', 'parallax_speed_video' );
        
        vc_remove_param( 'vc_section', 'parallax' );
        vc_remove_param( 'vc_section', 'parallax_image' );
        
        // vc_remove_param( 'vc_section', 'video_bg' );
        // vc_remove_param( 'vc_section', 'video_bg_url' );
        vc_remove_param( 'vc_section', 'video_bg_parallax' );
        vc_remove_param( 'vc_section', 'parallax_speed_bg' );
        vc_remove_param( 'vc_section', 'parallax_speed_video' );
    
        $params = array();
        $params[] = array(
            'type' => 'checkbox',
            'param_name' => 'parallax',
            'value' => array(
                'Enable' => 'true',
            ),
            'std' => '',
            'heading' => 'Parallax',
        );
        
        $params[] = array(
            'type' => 'checkbox',
            'param_name' => 'elements_fade',
            'value' => array(
                'Enable' => 'true',
            ),
            'std' => '',
            'heading' => 'Elements fade out',
            'dependency' => array(
                'element' => 'parallax',
                'value' => 'true',
            )
        );
        
        $params[] = array(
            'type' => 'colorpicker',
            'param_name' => 'overlay',
            'heading' => 'Background Overlay',
            'description' => 'Note that you can use opacity for overlay color.',
            
            'group' => 'Design Options',
        );
        
        vc_add_params( 'vc_row', $params );
        
        vc_add_params( 'vc_section', $params );
        
    }
    
}

Dine_VC_Row::instance()->init();

endif;