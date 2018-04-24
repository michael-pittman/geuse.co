<?php
if ( !class_exists( 'Dine_Customize' ) ) :
/**
 * Customizer
 *
 * @package Dine
 * @since 1.0
 */
class Dine_Customize {
    
    /**
	 *
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
        
        // Registers Settings here
        add_action( 'customize_register', array( $this , 'register' ), 1000 );
        
        // Live Preview JS, for page
        add_action( 'customize_preview_init', array( $this, 'customizer_live_preview' ) );
        
        // Javascript for Customizer, for iframe
        add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue' ) );
        
        // Customize Preview
        add_action( 'wp_head', array( $this, 'customizer_color_style' ), 1000 );
        
    }
    
    private static $prefix = 'dine_';
    
    /**
     * Enqueue script for customizer
     *
     * @since 1.0
     */
    function enqueue() {
        
        wp_enqueue_style( 'dine-customizer', get_template_directory_uri() . '/inc/customizer/assets/css/customizer.css' );
        
        wp_enqueue_script( 'dine-customizer', 
            get_template_directory_uri() . '/inc/customizer/assets/js/customizer.js', 
            array(
              'customize-controls',
              'iris',
              'underscore',
              'wp-util',

              // jQuery UI for Slide Element
              'jquery-ui-core',
              'jquery-ui-widget',
              'jquery-ui-mouse',
            ), 
            null, 
            true );
        
    }
    
    /**
     * This outputs the javascript needed to automate the live settings preview.
     * Also keep in mind that this function isn't necessary unless your settings 
     * are using 'transport'=>'postMessage' instead of the default 'transport'
     * => 'refresh'
     * 
     * Used by hook: 'customize_preview_init'
     *
     * @source: https://codex.wordpress.org/Plugin_API/Action_Reference/customize_preview_init
     */
    public static function customizer_live_preview()
    {
        
        wp_enqueue_script ( 
              'dine-themecustomizer',			//Give the script an ID
              get_template_directory_uri().'/inc/customizer/assets/js/theme-customizer.js', //Point to file
              array( 'jquery','customize-preview' ),	//Define dependencies
              '',						// Define a version (optional) 
              true						// Put script in footer?
        );
    }
    
    /**
     * Customizer Color Style
     *
     * @since 1.0
     */
    function customizer_color_style() {
        ?>

<style id="color-preview"></style>

        <?php
    }
    
    /**
     * Register Settings
     *
     * @since 1.0
     */
	function register( $wp_customize ) {
        
        // Include Custom Controls
        require_once get_template_directory() . '/inc/customizer/custom-controls.php';
        
        // Vars
        $prev_panel = $prev_section = '';
        
        // prefix
        $prefix = self::$prefix;
        
        // Get Registered Options
        $reg_options = Dine_Register::instance()->options();
        
        // Loop through all registered options
        foreach ( $reg_options as $id => $option ) {
            
            $defaults = array(
                'type' => null,
                'name' => null,
                'desc' => null,
                'options' => null,
                'priority' => null,
                'placeholder' => null,
                'json' => array(),
                'toggle' => null,
                'input_attrs' => array(),
                'active_callback' => null,
                'std' => null,
                'transport' => '',
                'selector'  => '',
                'css'       => '',
                
                'min' => '',
                'max' => '',
                'step' => '',
                'unit' => '',
                
                'section' => null,
                'section_title' => null,
                'section_desc' => null,
                'section_priority' => null,
                
                'panel' => null,
                'panel_title' => null,
                'panel_desc' => null,
                'panel_priority' => null,
            );
            extract( wp_parse_args( $option, $defaults ) );
            
            // 01 - PANEL
            // new panel appears
            if ( $panel ) {
                $panel_args = array();
                $panel_args[ 'title' ] = $panel_title ? $panel_title : $panel;
                if ( $panel_desc ) $panel_args[ 'description' ] = $panel_desc;
                if ( $panel_priority ) $panel_args[ 'priority' ] = $panel_priority;
                
                // add panel
                $prev_panel = $panel;
                if ( ! $wp_customize->get_panel( $panel ) ) {
                    $wp_customize->add_panel( $panel, $panel_args );
                }
            }
            
            // 02 - SECTION
            // new section appears
            if ( $section ) {
                $section_args = array();
                $section_args[ 'title' ] = $section_title ? $section_title : $section;
                if ( $section_desc ) $section_args[ 'description' ] = $section_desc;
                if ( $section_priority ) $section_args[ 'priority' ] = $section_priority;
                
                // we take previous panel unless panel specify to be false
                if ( $panel ) $section_args[ 'panel' ] = $panel;
                
                // add section
                $prev_section = $section;
                if ( ! $wp_customize->get_section( $section ) ) {
                    $wp_customize->add_section( $section, $section_args );
                }
            }
            
            // type is mandatory
            if ( ! $type ) continue;
            
            // OPTIONS IN DETAILS
            // Transport
            if ( 'postMessage' != $transport ) $transport = 'refresh';
            
            if ( $toggle ) {
                $json[ 'toggle' ] = $toggle;
            }
            
            // color preview
            // selector & property
            if ( 'postMessage' == $transport && 'color' == $type ) {
                if ( $css && ! $selector ) {
                    $selector = isset( $css[ 'selector' ] ) ? $css[ 'selector' ] : '';
                }
                if ( $selector ) $json[ 'selector' ] = $selector;
                
                if ( is_string( $css ) ) {
                    $json[ 'property' ] = $css;
                } elseif ( isset( $css[ 'property' ] ) ) {
                    $json[ 'property' ] = $css[ 'property' ];
                }
            }
            if ( 'slide' == $type ) {
                if ( $max ) {
                    $json[ 'max' ] = $max;
                }
                if ( $min ) {
                    $json[ 'min' ] = $min;
                }
                if ( $step ) {
                    $json[ 'step' ] = $step;
                }
                if ( $unit ) {
                    $json[ 'unit' ] = $unit;
                }
                if ( $std ) {
                    $json[ 'std' ] = $std;
                }
            }
            if ( $placeholder ) {
                $input_attrs[ 'placeholder' ] = $placeholder;
            }
            
            /**
             * Callback
             */
            if ( 'checkbox' === $type ) $callback = array( $this, 'sanitize_checkbox' );
            elseif ( 'number' === $type ) $callback = array( $this, 'sanitize_number' );
            elseif ( 'color' === $type ) $callback = array( $this, 'sanitize_hex_color' );
            else $callback = array( $this, 'no_sanitize' );
            
            
            
            // 01 - ADD SETTING
            //  
            $setting_args = array (
                'sanitize_callback' => $callback,
                'type'      => 'option',
                'default' => $std,
                'transport' => $transport,
            );
            $wp_customize->add_setting ( $id , $setting_args );
            
            // 02 - ADD CONTROL
            // 
            $control_args = array(
                'settings'      => $id,
                'section'       => $prev_section,
                'type'          => $type,
            );
            if ( $name ) $control_args[ 'label' ] = $name;
            if ( $desc ) $control_args[ 'description' ] = $desc;
            if ( $options ) $control_args[ 'choices' ] = $options;
            if ( $placeholder ) $control_args[ 'placeholder' ] = $placeholder;
            if ( $min ) $control_args[ 'min' ] = $min;
            if ( $input_attrs ) $control_args[ 'input_attrs' ] = $input_attrs;
            if ( $active_callback ) $control_args[ 'active_callback' ] = $active_callback;
            if ( $json ) $control_args[ 'json' ] = $json;
            
            // mime type
            if ( 'upload' == $type ) {
                if ( isset( $option[ 'mime_type' ] ) ) {
                    $control_args[ 'mime_type' ] = $option[ 'mime_type' ];
                }
            }
            
            $custom_controls = array (
                // built in
                'image'         => 'WP_Customize_Image_Control',
                'color'         => 'WP_Customize_Color_Control',
                'upload'        => 'WP_Customize_Upload_Control',
                
                // added
                'heading'       => 'Dine_Heading_Control',
                'message'       => 'Dine_Message_Control',
                'html'          => 'Dine_HTML_Control',
                'multicheckbox' => 'Dine_Multicheckbox_Control',
                'image_radio'   => 'Dine_Image_Radio_Control',
                'slide'         => 'Dine_Slide_Control',
            );
            
            if ( isset( $custom_controls[ $type ] ) ) {
                
                $control_class = $custom_controls[ $type ];
                $wp_customize->add_control ( new $control_class ( $wp_customize , $id, $control_args ) );
                
            } else {
                
                $wp_customize->add_control ( $id, $control_args );
            
            }
            
        } // Foreach Registered Options
        
        // remove static front page section while we can set it in Settings > Reading
        // And we only set it once
        $wp_customize->remove_section( 'static_front_page' );
        
    }
    
    /**
     * Callback function for checkbox
     *
     * @since 1.0
     */
    function sanitize_checkbox( $checked ) {
        return ( ( isset( $checked ) && ( true == $checked || 'on' == $checked ) ) ? true : false );
    }
    
    /**
     * Callback function for number
     *
     * @since 1.0
     */
    function sanitize_number( $value ) {
        return ( is_numeric( $value ) ) ? $value : intval( $value );
    }
    
    /**
     * Callback function in general cases
     *
     * @since 1.0
     */
    function no_sanitize( $value ) {
        return $value;
    }
    
    /**
     * Callback function for color
     *
     * @since 1.0
     */
    function sanitize_hex_color( $color ) {
        if ( '' === $color )
            return '';

        // 3 or 6 hex digits, or the empty string.
        if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
            return $color;
    }
    
}

Dine_Customize::instance()->init();

endif;