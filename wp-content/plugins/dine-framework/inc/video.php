<?php
if ( ! class_exists( 'Dine_VC_Video' ) ) :
/**
 * We need to modify some options from VC Video
 *
 * @since 1.0
 */
class Dine_VC_Video
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
        
        add_action( 'vc_after_init', array( $this, 'params' ) );
             
    }
    
    function params() {
        
        $params[] = array(
            'type' => 'dropdown',
            'param_name' => 'thumbnail',
            'heading' => 'Video Thumbnail',
            
            'value' => array(
                'Thumbnail from YouTube/Vimeo' => 'video',
                'Upload your own thumbnail' => 'upload',
                'No thumbnail' => 'none',
            ),
            'std' => 'video',
            
            'group' => 'Video Thumbnail',
        );
        
        $params[] = array(
            'type' => 'attach_image',
            'param_name' => 'video_thumbnail',
            'heading' => 'Upload Thumbnail',
            'dependency' => array(
                'element' => 'thumbnail',
                'value' => 'upload',
            ),
            
            'group' => 'Video Thumbnail',
        );
        
        vc_add_params( 'vc_video', $params );
        
    }
    
}

Dine_VC_Video::instance()->init();

endif;