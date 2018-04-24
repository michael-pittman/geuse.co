<?php
/**
 * Plugin Name: (Dine) Framework
 * Plugin URI: http://withemes.com
 * Description: Addon Elements for Visual Composer used in "Dine" theme.
 * Version: 2.0
 * Author: WiThemes
 * Author URI: http://withemes.com
 * Copyright: (c) 2017 WiThemes
 * Text Domain: dine
 */

// Do not load directly
if ( !defined ( 'ABSPATH' ) ) die ( '-1' ) ;

// Define things
define ( 'DINE_FRAMEWORK_VERSION', '2.0' ) ;
define ( 'DINE_FRAMEWORK_FILE', __FILE__ );
define ( 'DINE_FRAMEWORK_PATH', plugin_dir_path( DINE_FRAMEWORK_FILE ) );
define ( 'DINE_FRAMEWORK_URL', plugins_url ( '/', DINE_FRAMEWORK_FILE ) );

// Shortcode framework
require_once DINE_FRAMEWORK_PATH . 'inc/shortcode.php';

// helper shortcodes
require_once DINE_FRAMEWORK_PATH . 'inc/helpers.php';

// VC Shortcode Modifications
require_once DINE_FRAMEWORK_PATH . 'inc/row.php';

require_once DINE_FRAMEWORK_PATH . 'addons/arctext/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/button/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/booking/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/counters/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/diamond/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/gallery/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/gmap/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/heading/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/instagram/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/divider/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/icon/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/imagebox/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/list/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/menu/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/opentable/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/slider/register.php';
require_once DINE_FRAMEWORK_PATH . 'addons/testimonials/register.php';

require_once DINE_FRAMEWORK_PATH . 'addons/text_slider/register.php';

if ( !class_exists ( 'Dine_Framework ' )  ) :
/*
 * Main class
 *
 * @since 1.0
 */
class Dine_Framework 
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
        
        // Register lately so that everything has been registered
        add_action( 'init', array( $this, 'plugin_init' ), 100 );
        
    }
    
    /**
     * Plugin Init
     *
     * @since 1.0
     */
    function plugin_init() {
        
        load_plugin_textdomain( 'dine', false, dirname( plugin_basename(__FILE__) ) . '/languages' );
        
        add_action( 'wp_enqueue_scripts' , array( $this , 'enqueue' ) );
        
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            // add_action('admin_notices', 'dine_show_no_vc_error');
            return;
        }
        
        vc_set_shortcodes_templates_dir( DINE_FRAMEWORK_PATH . 'templates' );
        
        // Disable duplicated elmeents by default
        if ( 'true' !== get_option( 'dine_vc_duplicated_elements' ) ) {
            $elements = array(
                
                // Carousel
                // 'vc_images_carousel',
                
                // Gallery
                'vc_gallery',
                
                // Button
                'vc_btn',
                'vc_button',
                'vc_button2',
                
                // Display Posts
                'vc_masonry_grid',
                'vc_basic_grid',
                'vc_posts_slider',
                
                // Gallery
                'vc_masonry_media_grid',
                'vc_media_grid',
                
                // Google Map
                'vc_gmaps',
                
                // Iconbox
                // 'vc_icon',
                
                // Call to action
                // We'll develope our own element
                'vc_cta',
                
                // redundant slider revolution
                // 'rev_slider_vc',
            );
            
            foreach ( $elements as $element ) {
                vc_remove_element( $element );
            }
            
        }
        
        if ( 'true' !== get_option( 'dine_vc_deprecated_elements' ) ) {
            $elements = array(
                
                'vc_tabs',
                'vc_tour',
                'vc_accordion',
                'vc_cta_button',
                'vc_cta_button2',
                'vc_button',
                'vc_button2',
                
            );
            
            foreach ( $elements as $element ) {
                vc_remove_element( $element );
            }
            
        }
        
    }
    
    /**
     * Enqueue script for plugin
     *
     * @since 1.0
     */
    function enqueue() {
        
        // core plugin css & javascript
        // ~.~
        wp_enqueue_style( 'dine-framework', DINE_FRAMEWORK_URL . "css/framework.css", array( 'js_composer_front' ) );
        
        
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-effects-core' );
        wp_enqueue_script( 'jquery-ui-datepicker' );
        
        // those plugins have been combined into single file since v2.0
        // wp_enqueue_script( 'arctext', DINE_FRAMEWORK_URL . 'js/jquery.arctext.js', array( 'jquery' ) , null, true );
        // wp_enqueue_script( 'typed', DINE_FRAMEWORK_URL . 'js/typed.min.js',null, null, true );
        
        wp_enqueue_script( 'dine-framework', DINE_FRAMEWORK_URL . 'js/framework.min.js', array( 'jquery', 'jquery-ui-datepicker' ) , null, true );
        
    }
    
}	// class

Dine_Framework::instance()->init();

endif;