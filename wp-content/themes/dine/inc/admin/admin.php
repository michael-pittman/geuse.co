<?php
if ( !class_exists( 'Dine_Admin' ) ) :
/**
 * Admin Class
 *
 * @since 1.0
 */
class Dine_Admin
{   
    
    /**
	 *
	 */
	public function __construct() {
	}
    
    /**
	 * The one instance of Dine_Admin
	 *
	 * @since 1.0
	 */
	private static $instance;

	/**
	 * Instantiate or return the one Dine_Admin instance
	 *
	 * @since 1.0
	 *
	 * @return Dine_Admin
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
        
        // metabox
        require_once get_template_directory() . '/inc/admin/framework/metabox/metabox.php';
        
        // widget framework
        require_once get_template_directory() . '/inc/admin/framework/widget/widget.php';
        
        // TGM
        require_once get_template_directory() . '/inc/admin/framework/tgm.php';
        
        // Post Format UI
        require_once get_template_directory() . '/inc/admin/framework/formatui/vp-post-formats-ui.php'; // This plugin has a high compatible ability so we don't need to check if it exists or not
        // correct the post format-ui url
        add_filter( 'vp_pfui_base_url', array( $this, 'vp_pfui_base_url' ) );
        
        // register plugins needed for theme
        add_action( 'tgmpa_register', array ( $this, 'register_required_plugins' ) );
        
        // Include media upload to sidebar area
        // This will be used when we need to upload something
        add_action( 'sidebar_admin_setup', array( $this, 'wp_enqueue_media' ) );
        
        // enqueue scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
        
        // localization
        add_action( 'dineadminjs', array( $this, 'l10n' ) );
        
        // metabox
        add_filter( 'dine_metaboxes', array( $this, 'metaboxes' ) );
        
        /**
         * Add a thumbnail column in edit.php
         *
         * Thank to: http://wordpress.org/support/topic/adding-custum-post-type-thumbnail-to-the-edit-screen
         *
         * @since 1.0
         */
        add_action( 'manage_posts_custom_column', array( $this, 'add_thumbnail_value_editscreen' ), 10, 2 );
        add_filter( 'manage_edit-post_columns', array( $this, 'columns_filter' ) , 10, 1 );
        
    }
    
    /**
     * Returns Format UI plugin base url
     *
     * @since 1.0
     */
    function vp_pfui_base_url() {
        return get_template_directory_uri() . '/inc/admin/framework/formatui/';
    }
    
    /**
     * Enqueue Media
     *
     * @since 1.0
     */
    function wp_enqueue_media() {
        wp_enqueue_media();
    }
    
    /**
     * Register Plugins
     *
     * Instagram Widget & Post Format UI is now a part of Theme package
     *
     * @since 1.0
     */
    function register_required_plugins (){
        
        $plugins = array (
            
            array(
                'name'     				=> esc_html__( 'Visual Composer', 'dine' ), // The plugin name
                'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
                'source'   				=> get_template_directory() . '/inc/admin/plugins/js_composer.zip', // The plugin source
                'version'               => '5.4.5',
            ),
            
            array (
                'name'     				=> esc_html__( '(Dine) Framework', 'dine' ), // The plugin name
                'slug'     				=> 'dine-framework', // The plugin slug (typically the folder name)
                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
                'source'   				=> get_template_directory() . '/inc/admin/plugins/dine-framework.zip', // The plugin source
                'version'               => '2.0',
            ),
            
            array(
                'name'     				=> esc_html__( 'Restaurant Reservations', 'dine' ), // The plugin name
                'slug'     				=> 'restaurant-reservations', // The plugin slug (typically the folder name)
                'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
            ),
            
            array(
                'name'     				=> esc_html__( 'Contact Form 7', 'dine' ), // The plugin name
                'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
            ),
            
        );

        $config = array(
            'id'           => 'tgmpa',
            'default_path' => '',
            'menu'         => 'tgma-install-plugins',
            'parent_slug'  => 'themes.php',
            'capability'   => 'edit_theme_options',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => true,
            'message'      => '',
        );

        tgmpa( $plugins, $config );
    }
    
    /**
     * Enqueue javascript & style for admin
     *
     * @since 1.0
     */
    function enqueue(){
        
        // We need to upload image/media constantly
        wp_enqueue_media();
        
        // admin css
        wp_enqueue_style( 'dine-admin', get_template_directory_uri() . '/assets/css/admin.css', array( 'wp-mediaelement' ) );
        
        // admin javascript
        wp_enqueue_script( 'dine-admin', get_template_directory_uri() . '/assets/js/admin.js', array( 'wp-mediaelement' ), null , true );
        
        // localize javascript
        $jsdata = apply_filters( 'dineadminjs', array() );
        wp_localize_script( 'dine-admin', 'DINE_ADMIN' , $jsdata );
        
    }
    
    /**
     * Localize some text
     *
     * @since 1.0
     */
    function l10n( $jsdata ) {
        
        if ( ! isset ( $jsdata[ 'l10n' ] ) ) $jsdata[ 'l10n' ] = array();
    
        $jsdata[ 'l10n' ] += array(
        
            'choose_image' => esc_html__( 'Choose Image', 'dine' ),
            'change_image' => esc_html__( 'Change Image', 'dine' ),
            'upload_image' => esc_html__( 'Upload Image', 'dine' ),
            
            'choose_images' => esc_html__( 'Choose Images', 'dine' ),
            'change_images' => esc_html__( 'Change Images', 'dine' ),
            'upload_images' => esc_html__( 'Upload Images', 'dine' ),
            
            'choose_file' => esc_html__( 'Choose File', 'dine' ),
            'change_file' => esc_html__( 'Change File', 'dine' ),
            'upload_file' => esc_html__( 'Upload File', 'dine' ),
        
        );
        
        return $jsdata;
    
    }
    
    /**
     * Metaboxes
     *
     * @return $metaboxes
     *
     * @since Dine 1.0
     */
    function metaboxes( $metaboxes ) {
        
        $all_navs = array( '' => esc_html__( 'Select Menu', 'dine' ) );
        $navs = get_terms( 'nav_menu' );
        foreach ( $navs as $nav ) {
            $all_navs[ strval( $nav->term_id) ] = $nav->name;
        }
        
        // PAGE SETTINGS
        //
        $metaboxes[] = array (
            
            'id' => 'page-settings',
            'screen' => array( 'page' ),
            'title' => esc_html__( 'Page Settings', 'dine' ),
            
            'tabs'  => array(
                'layout' => esc_html__( 'Settings', 'dine' ),
                'header' => esc_html__( 'Header', 'dine' ),
                'sidenav' => esc_html__( 'Side Navigation', 'dine' ),
            ),
            'fields' => array(
                
                // Layout
                array(
                    'id' => 'layout',
                    'name' => esc_html__( 'Page Layout', 'dine' ),
                    'type' => 'select',
                    'options' => array(
                        'fullwidth' => esc_html__( 'Fullwidth', 'dine' ),
                        'sidebar-right' => esc_html__( 'Sidebar Right', 'dine' ),
                        'sidebar-left' => esc_html__( 'Sidebar Left', 'dine' ),
                    ),
                    'std' => 'fullwidth',
                    'tab' => 'layout',
                ),
                
                array(
                    'id' => 'padding_top',
                    'name' => esc_html__( 'Content Padding Top', 'dine' ),
                    'type' => 'text',
                    'placeholder' => '60px',
                    'tab'   => 'layout',
                ),
                
                array(
                    'id' => 'padding_bottom',
                    'name' => esc_html__( 'Content Padding Bottom', 'dine' ),
                    'type' => 'text',
                    'placeholder' => '60px',
                    'tab'   => 'layout',
                ),
                
                array(
                    'id' => 'disable_title',
                    'name' => esc_html__( 'Disable Page Title', 'dine' ),
                    'type' => 'checkbox',
                    'tab' => 'layout',
                ),
                
                array(
                    'id' => 'subtitle',
                    'name' => esc_html__( 'Page Subtitle', 'dine' ),
                    'type' => 'text',
                    'tab' => 'layout',
                ),
                
                // Header
                array(
                    'id' => 'transparent_header',
                    'name' => esc_html__( 'Transparent Header?', 'dine' ),
                    'type' => 'checkbox',
                    'tab' => 'header',
                ),
                
                // Side Navigation
                array(
                    'id' => 'sidenav',
                    'name' => esc_html__( 'Side Navigation', 'dine' ),
                    'type' => 'select',
                    'options' => $all_navs,
                    'tab' => 'sidenav',
                ),
                
            ),
            
        );
        
        return $metaboxes;
    
    }

    /**
     * Add Thumbnail Column to edit screen
     *
     * @since 1.0
     */
    function columns_filter( $columns ) {
        $column_thumbnail = array( 'thumbnail' => esc_html__('Thumbnail','dine') );
        $columns = array_slice( $columns, 0, 1, true ) + $column_thumbnail + array_slice( $columns, 1, NULL, true );
        return $columns;
    }
    
    /**
     * Render Thumbnail for posts
     *
     * @since 1.0
     */
    function add_thumbnail_value_editscreen( $column_name, $post_id ) {

        $width = (int) 50;
        $height = (int) 50;

        if ( 'thumbnail' == $column_name ) {
            // thumbnail of WP 2.9
            $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
            // image from gallery
            $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
            if ($thumbnail_id)
                $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
            elseif ($attachments) {
                foreach ( $attachments as $attachment_id => $attachment ) {
                    $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
                }
            }
            if ( isset($thumb) && $thumb ) {
                echo $thumb;
            } else {
                echo '<em>' . esc_html__( 'None','dine' ) . '</em>';
            }
        }
    } 
    
}

Dine_Admin::instance()->init();

endif; // class exists