<?php
if ( ! class_exists( 'Dine_Shortcode' ) ) :
/**
 * Generic class so that other shortcodes could be registered easier
 *
 * @since 1.0
 */
class Dine_Shortcode
{
    
    /**
	 * construct
	 */
	public function __construct() {
	}
    
    /**
     * Args to register this shortcode
     */
    public $args;
    
    public $path;
    
    // prefix
    private static $prefix = 'dine_';
    
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
        
        $args = $this->args;
        $prefix = self::$prefix;
        
        extract( wp_parse_args( $args, array( 'base' => '' ) ) );
        
        if ( ! $base ) return;
        
        // Register lately so that everything has been registered
        add_action( 'vc_before_init', array( $this, 'register' ) );
        
        add_shortcode( $base, array( $this, 'shortcode' ) );
        add_shortcode( $prefix . $base, array( $this, 'shortcode' ) ); // backup
        
    }
    
    /**
     * Params to register to frontend
     *
     * @since 1.0
     */
    public function params() {
        
        $params = array();
        include $this->path . 'params.php';
        return $params;
    
    }
    
    /**
     * Register the addon
     *
     * @since 1.0
     * @modified 1.0
     */
    function register() {
        
        $args = $this->args;
        
        $base = isset( $args[ 'base' ] ) ? $args[ 'base' ] : '';
        
        $defaults = array(
            'name'  => '',
            'desc'  => '',
            'category'=> array( esc_html__( 'Content', 'js_composer' ), esc_html__( 'Dine', 'dine' ) ),
            'weight'=> 190,
        );
        extract( wp_parse_args( $args, $defaults ) );
        
        $params = $this->params();
        
        if ( $base && $params ) {
            
            vc_map( array(
                'name'      => $name,
                'base'      => $base,
                'weight'    => $weight,
                'icon'      => DINE_FRAMEWORK_URL . 'images/' . $base . '.png',
                'category'  => $category,
                'description' => $desc,
                'params'    => $params,
            ) );
        }
        
    }
    
    public function extra_atts( $atts ) {
    
        return array();
        
    }
    
    public function param_list() {
    
        return '';
        
    }
    
    /**
     * Renders to frontend
     *
     * @since 1.0
     */
    public function shortcode( $atts, $content = null ) {
        
        $return = '';
        
        // get the base (shortcode name, eg. iconbox, button..)
        $args = $this->args;
        $base = isset( $args[ 'base' ] ) ? $args[ 'base' ] : '';
        
        // Extra atts that can be used for shortcode but not added to Visual Composer
        $extra_atts = $this->extra_atts( $atts );
        if ( function_exists( 'vc_map_get_attributes' ) )
        $atts = vc_map_get_attributes( $base, $atts );
        $atts = array_merge( $atts, $extra_atts );
        
        // set default array to extract
        $defaults = array();
        $param_list = $this->param_list();
        $param_list = explode( ',', $param_list );
        $param_list = array_map( 'trim', $param_list );
        foreach ( $param_list as $param_name ) {
            $defaults[ $param_name ] = '';
        }
        
        extract( shortcode_atts( $defaults, $atts ) );
        
        // get element id
        $element_id = $this->shortcode_id( $base );
        
        $element_class = array( 'dine-element', 'wpb_content_element', 'dine-element-' . $base );
        
        // css class
        // for element having atts
        if ( isset( $css ) ) {
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $base, $atts );
            $element_class[] = $css_class;
        }
        
        // animation
        $data_animation_delay = '';
        if ( isset( $animation ) && 'true' == $animation ) {
            $element_class[] = 'dine-animation-element';
            if ( isset( $animation_delay ) && $animation_delay ) {
                $data_animation_delay = ' data-delay="' . absint( $animation_delay ) . '"';
            }
        }
        
        // register a filter
        $element_class = apply_filters( 'dine_element_class', $element_class, $base, $atts );
        
        $element_class = join( ' ', $element_class );
        
        // get inner html
        ob_start();
        
        include $this->path . 'frontend.php';
        
        $inner_html = ob_get_clean();
        
        if ( ! $inner_html ) return;
        
        if ( $this->wrapper() ) {
            $return .= '<div class="' . esc_attr( $element_class ) . '" id="' . esc_attr( $element_id ) . '"' . $data_animation_delay . '>';

            $return .= $inner_html;

            $return .= '</div>'; // element class
        } else {
            $return .= $inner_html;   
        }
        
        return $return;
        
    }
    
    function wrapper() {
        return true;
    }
    
    /**
     * Returns shortcode ID for an element
     * 
     * @param $base the name of element, eg. iconbox
     *
     * @since 1.0
     */
    function shortcode_id( $base ) {
    
        global $dine_ids;
        
        if ( ! isset( $dine_ids ) )
            $dine_ids = array();
        
        if ( ! isset( $dine_ids[ $base ] ) )
            $dine_ids[ $base ] = array();
        
        $count = sizeof( $dine_ids[ $base ] ) + 1;
        $dine_ids[ $base ][] = "{$base}-{$count}";
        
        return "{$base}-{$count}";
        
    }
    
}

endif;