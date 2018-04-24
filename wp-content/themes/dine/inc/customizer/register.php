<?php
define( 'DINE_REGISTER_URL', get_template_directory_uri() . '/inc/customizer/' );
define( 'DINE_REGISTER_PATH', get_template_directory() . '/inc/customizer/' );

if ( !class_exists( 'Dine_Register' ) ) :
/**
 * Register Options
 *
 * @since 1.0
 */
class Dine_Register
{   
    
    private static $prefix = 'dine_';
    
    /**
	 * Construct
	 */
	public function __construct() {
	}
    
    /**
	 * The one instance of Dine_Register
	 *
	 * @since 1.0
	 */
	private static $instance;

	/**
	 * Instantiate or return the one Dine_Register instance
	 *
	 * @since 1.0
	 *
	 * @return Dine_Register
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
    }
    
    /**
     * List of all options
     *
     * shorthand is a replacement for property, type and preview way. For instance, if you type shorthand: width then
     * preview should be css, type should be text, property should be width & unit often be px
     *
     * @since 1.0
     */
    public function options() {
        
        // Var
        $options = array();
        
        /* Header
        ---------------------------------------- */
        $options[ 'header_layout' ] = array(
            'type'      => 'radio',
            'name'      => esc_html__( 'Header Layout', 'dine' ),
            'options'   => array(
                'left'          => esc_html__( 'Logo Left', 'dine' ),
                'center'        => esc_html__( 'Logo Center', 'dine' ),
            ),
            'std'       => 'left',
            
            'section'   => 'header',
            'section_title'=> esc_html__( 'Header', 'dine' ),
            'panel'     => 'header',
            'panel_title' =>  esc_html__( 'Header', 'dine' ),
            'panel_priority' => 30,
        );
        
        // Header Design
        //
        $options[] = array(
            'type'      => 'heading',
            'name'      => esc_html__( 'Header Design', 'dine' ),
        );
        
        $options[ 'header_height' ] = array(
            'shorthand' => 'height',
            'name'      => esc_html__( 'Header Height', 'dine' ),
            'desc'      => esc_html__( 'This is the normal header height. To setup "header sticky height", let see the section "Header Sticky".', 'dine' ),
            'selector'  => '#masthead .container, #masthead-height',
            'min'       => 40,
            'max'       => 200,
            'step'      => 2,
            'std'       => 100,
        );
        
        $options[ 'header_skin' ] = array(
            'type'      => 'radio',
            'options'   => array(
                'light' => esc_html__( 'Light', 'dine' ),
                'dark' => esc_html__( 'Dark', 'dine' ),
            ),
            'std'       => 'light',
            'name'      => esc_html__( 'Header Skin', 'dine' ),
            'desc'      => esc_html__( 'If you choose "dark skin", please go to "Header Menu" section to change menu items color.', 'dine' ),
        );
        
        $options[ 'header_background_color' ] = array(
            'shorthand' => 'background-color',
            'name'      => esc_html__( 'Header Background Color', 'dine' ),
            'selector'  => '#masthead, #masthead.header-dark',
        );
        
        $options[ 'header_background_image' ] = array(
            'shorthand' => 'background-image',
            'name'      => esc_html__( 'Header Background Image', 'dine' ),
            'selector'  => '#masthead',
        );
        
        $options[ 'header_background_size' ] = array(
            'shorthand' => 'background-size',
            'name'      => esc_html__( 'Header Background Size', 'dine' ),
            'selector'  => '#masthead',
        );
        
        $options[ 'header_background_repeat' ] = array(
            'shorthand' => 'background-repeat',
            'name'      => esc_html__( 'Header Background Repeat', 'dine' ),
            'selector'  => '#masthead',
        );
        
        $options[ 'header_background_position' ] = array(
            'shorthand' => 'background-position',
            'name'      => esc_html__( 'Header Background Position', 'dine' ),
            'selector'  => '#masthead',
        );
        
        // Sticky Header
        //
        $options[] = array(
            'type'      => 'heading',
            'name'      => esc_html__( 'Sticky Header', 'dine' ),
        );
        
        $options[ 'header_sticky' ] = array(
            'shorthand' => 'enable',
            'name'      => esc_html__( 'Sticky Header?', 'dine' ),
            'std'       => 'false',
            'toggle'    => array(
                'true' => array( 'header_sticky_height', 'header_sticky_mobile' ),
            ),
        );
        
        $options[ 'header_sticky_mobile' ] = array(
            'shorthand' => 'enable',
            'name'      => esc_html__( 'Sticky Header on mobile?', 'dine' ),
            'std'       => 'false',
        );
        
        $options[ 'header_sticky_height' ] = array(
            'shorthand' => 'height',
            'name'      => esc_html__( 'Shrunk Header Height', 'dine' ),
            'std'       => '80',
        );
        
        /* Logo
        ---------------------------------------- */
        $options[ 'logo_type' ] = array(
            'type'      => 'radio',
            'options'   => array(
                'text'  => esc_html__( 'Text Logo', 'dine' ),
                'image' => esc_html__( 'Image Logo', 'dine' ),
            ),
            'std'      => 'text',
            
            'toggle'    => array(
                'text' => array( 'logo_color', 'logo_font_size', 'logo_letter_spacing' ),
                'image' => array( 'logo', 'logo_width', 'transparent_logo' ),
            ),
            
            'section'   => 'logo',
            'section_title'=> esc_html__( 'Logo', 'dine' ),
            'panel'     => 'header',
        );
        
        $options[ 'logo_color' ] = array(
            'shorthand' => 'color',
            'name'      => esc_html__( 'Logo Color', 'dine' ),
            'selector'  => '.text-logo',
            'std'       => '#111',
        );
        
        $options[ 'logo_font_size' ] = array(
            'shorthand' => 'font-size-em',
            'selector'  => '.text-logo',
            'std'       => '3',
            'max'       => '4',
            'min'       => '1',
        );
        
        $options[ 'logo_letter_spacing' ] = array(
            'shorthand' => 'letter-spacing',
            'selector'  => '.text-logo',
            'std'       => '1',
            'max'       => '5',
            'min'       => '0',
        );
        
        /* IMAGE LOGO
        ------------------ */
        $options[ 'logo' ] = array(
            'type'      => 'image',
            'name'      => esc_html__( 'Upload Your Logo', 'dine' ),
        );
        
        $options[ 'logo_width' ] = array(
            'shorthand' => 'width',
            'name'      => esc_html__( 'Logo Width', 'dine' ),
            'std'       => '86',
            'selector'  => '#logo img',
            'max'       => '480',
            'min'       => '30',
            'step'      => '1',
        );
        
        $options[ 'logo_margin_top' ] = array(
            'shorthand' => 'margin-top',
            'name'      => esc_html__( 'Logo Margin Top', 'dine' ),
            'std'       => '0',
            'selector'  => '.site-branding',
            'max'       => '100',
            'min'       => '0',
            'step'      => '2',
        );
        
        $options[ 'transparent_logo' ] = array(
            'type'      => 'image',
            'name'      => esc_html__( 'Transparent Logo', 'dine' ),
            'desc'      => esc_html__( 'This logo will be used for transparent header.', 'dine' ),
        );
        
        /* Navigation
        ---------------------------------------- */
        $options[] = array(
            'type'      => 'heading',
            'name'      => esc_html__( 'First Level', 'dine' ),
            
            'section'   => 'header_nav',
            'section_title'=> esc_html__( 'Header Menu', 'dine' ),
            'panel'     => 'header',
        );
        
        $options[ 'nav_font' ] = array(
            'shorthand' => 'font-family',
            'name'      => esc_html__( 'Menu Item Font', 'dine' ),
            'selector'  => '#nav',
            'std'       => 'Oswald',
        );
        
        $options[ 'nav_size' ] = array(
            'shorthand' => 'font-size',
            'name'      => esc_html__( 'Menu Item Size', 'dine' ),
            'selector'  => '#nav > li > a',
            'min'       => '9',
            'std'       => '12',
            'max'       => '20',
        );
        
        $options[ 'nav_weight' ] = array(
            'shorthand' => 'font-weight',
            'selector'  => '#nav > li > a',
            'std'       => '400',
            'name'      => esc_html__( 'Menu Item Weight', 'dine' ),
        );
        
        $options[ 'nav_text_transform' ] = array(
            'shorthand' => 'text-transform',
            'name'      => esc_html__( 'Menu Text Transform', 'dine' ),
            'selector'  => '#nav',
            'std'       => 'uppercase',
        );
        
        $options[ 'nav_letter_spacing' ] = array(
            'shorthand' => 'letter-spacing',
            'selector'  => '#nav > li > a',
            'std'       => '1',
            'name'      => esc_html__( 'Menu Item Spacing', 'dine' ),
        );
        
        $options[ 'nav_color' ] = array(
            'shorthand' => 'color',
            'selector'  => '#nav > li > a, #hamburger',
            'name'      => esc_html__( 'Menu Item Color', 'dine' ),
            'std'       => '#333',
        );
        
        $options[ 'nav_active_color' ] = array(
            'shorthand' => 'color',
            'selector'  => '#nav > li:hover > a, #nav > li.current-menu-item > a, #nav > li.current-menu-ancestor > a',
            'name'      => esc_html__( 'Active Item Color', 'dine' ),
        );
        
        // DROPDOWN
        //
        $options[] = array(
            'type'      => 'heading',
            'name'      => esc_html__( 'Dropdown', 'dine' ),
        );
        
        $options[ 'nav_dropdown_background' ] = array(
            'shorthand' => 'background-color',
            'name'      => esc_html__( 'Dropdown Background', 'dine' ),
            'std'       => '#111',
            'selector'  => '#nav ul ',
        );
        
        $options[ 'nav_dropdown_color' ] = array(
            'shorthand' => 'color',
            'name'      => esc_html__( 'Dropdown Item Color', 'dine' ),
            'std'       => '#999',
            'selector'  => '#nav ul',
        );
        
        $options[ 'nav_dropdown_hover_color' ] = array(
            'shorthand' => 'color',
            'name'      => esc_html__( 'Item Active Color', 'dine' ),
            'std'       => '#fff',
            'selector'  => '#nav ul li:hover > a, #nav ul li.active > a, #nav ul li.current-menu-item > a, #nav ul li.current-menu-ancestor > a',
        );
        
        /* Header CTA
        ---------------------------------------- */
        $options[ 'header_btn_first_line' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Button First Line', 'dine' ),
            'placeholder'=> 'Book a',
            
            'section'   => 'header_btn',
            'section_title'=> esc_html__( 'Header Button', 'dine' ),
            'panel'     => 'header',
        );
        
        $options[ 'header_btn_second_line' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Button Second Line', 'dine' ),
            'placeholder'=> 'table',
        );
        
        $options[ 'header_btn_url' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Button URL', 'dine' ),
            'placeholder'=> 'http://',
        );
        
        /* Footer
        -------------------------------------------------------------------------------- */
        $options[] = array(
            'name' => esc_html__( 'Footer Widgets Area', 'dine' ),
            'type'  => 'heading',
            
            'section' => 'footer',
            'section_title' => esc_html__( 'Footer', 'dine' ),
            'section_priority' => 40,
        );
        
        $options[ 'footer_sidebar_background' ] = array(
            'name' => esc_html__( 'Widgets Area Background Color', 'dine' ),
            'shorthand'  => 'background-color',
            'selector' => '#footer-sidebar',
            'std' => '#12171b',
        );
        
        // Copyright Area
        $options[] = array(
            'name' => esc_html__( 'Copyright Area', 'dine' ),
            'type'  => 'heading',
        );
        
        $options[ 'footer_bottom_background' ] = array(
            'name' => esc_html__( 'Copyright Area Background Color', 'dine' ),
            'shorthand'  => 'background-color',
            'selector' => '#footer-bottom',
            'std' => '#000',
        );
        
        $options[ 'footer_logo' ] = array(
            'name' => esc_html__( 'Footer Logo', 'dine' ),
            'type'  => 'image',
        );
        
        $options[ 'footer_logo_width' ] = array(
            'name' => esc_html__( 'Footer Logo Width', 'dine' ),
            'shorthand'  => 'width',
            'selector'  => '#footer-logo img',
            'std'       => 80,
            'max'       => 400,
            'min'       => 40,
            'step'      => 2,
        );
        
        $options[ 'footer_star_icon' ] = array(
            'shorthand' => 'enable',
            'name'      => esc_html__( 'Displays "star icon" in footer', 'dine' ),
            'std'       => 'true',
            'toggle'    => array(
                'true' => array( 'footer_star_icon_replacement' ),
            ),
        );
        
        $options[ 'footer_star_icon_replacement' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Replace "star icon" by another one', 'dine' ),
            'desc'      => 'You can see the <a href="http://fontawesome.io/icons/" target="_blank">list of all icons here</a>',
            'placeholder' => 'Eg. leaf',
        );
        
        // Scroll up button
        $options[] = array(
            'name' => esc_html__( 'Scroll Up Button', 'dine' ),
            'type'  => 'heading',
        );
        
        $options[ 'footer_scrollup' ] = array(
            'name' => esc_html__( 'Show scroll up button', 'dine' ),
            'shorthand'  => 'enable',
            'std'       => 'true',
        );
        
        $options[ 'goto' ] = array(
            'name' => esc_html__( '"Go to" word', 'dine' ),
            'type'  => 'text',
            'std' => 'Go To',
        );
        
        $options[ 'top' ] = array(
            'name' => esc_html__( '"Top" word', 'dine' ),
            'type'  => 'text',
            'std' => 'Top',
        );
        
        /* Blog
        -------------------------------------------------------------------------------- */
        $options[] = array(
            
            'name' => esc_html__( 'Blog', 'dine' ),
            'type' => 'heading',
            
            'section' => 'blog',
            'section_title' => esc_html__( 'Blog', 'dine' ),
            'section_priority' => 50,
        );
        
        $options[ 'blog_hero' ] = array(
            
            'name' => esc_html__( 'Blog Hero Image', 'dine' ),
            'type' => 'image',
            'desc' => esc_html__( 'This option is only used when you set the front page as blog. If you set blog to a page, please set featured image for that page.', 'dine' ),
            
        );    
        
        $options[ 'layout' ] = array(
            
            'name' => esc_html__( 'Blog Sidebar Layout', 'dine' ),
            'type' => 'radio',
            'options' => array(
                'fullwidth'   => esc_html__( 'Fullwidth', 'dine' ),
                'sidebar-left'=> esc_html__( 'Sidebar Left', 'dine' ),
                'sidebar-right'      => esc_html__( 'Sidebar Right', 'dine' ),
            ),
            'std' => 'sidebar-right',
            'desc' => esc_html__( 'This option is only used when you set the front page as blog. If you set blog to a page, please use "page options" to set layout.', 'dine' ),
            
        );
        
        $options[ 'content_excerpt' ] = array(
            
            'name' => esc_html__( 'Displays content or excerpt?', 'dine' ),
            'type' => 'radio',
            'options' => array(
                'content'   => esc_html__( 'Post Content', 'dine' ),
                'excerpt'=> esc_html__( 'Post Excerpt', 'dine' ),
            ),
            'std' => 'content',
            
        );
        
        // Blog Style
        $options[] = array(
            
            'name' => esc_html__( 'Blog Style', 'dine' ),
            'type' => 'heading',
            
        );
        
        $options[ 'blog_style' ] = array(
            
            'name' => esc_html__( 'Blog Style', 'dine' ),
            'type' => 'radio',
            'options' => array(
                'standard'   => esc_html__( 'Standard', 'dine' ),
                'grid'=> esc_html__( 'Grid', 'dine' ),
                'list'      => esc_html__( 'List', 'dine' ),
            ),
            'std' => 'standard',
            'desc' => esc_html__( 'This applies for main blog', 'dine' ),
        );
        
        $options[ 'archive_style' ] = array(
            
            'name' => esc_html__( 'Archive Style', 'dine' ),
            'type' => 'radio',
            'options' => array(
                ''   => esc_html__( 'Same as main blog', 'dine' ),
                'standard'   => esc_html__( 'Standard', 'dine' ),
                'grid'=> esc_html__( 'Grid', 'dine' ),
                'list'      => esc_html__( 'List', 'dine' ),
            ),
            'std' => '',
            'desc' => esc_html__( 'This applies for archive pages such as category, tag, author page..', 'dine' ),
        );
        
        // Single
        $options[] = array(
            
            'name' => esc_html__( 'Single Post', 'dine' ),
            'type' => 'heading',
            
        );
        
        $options[ 'single_layout' ] = array(
            
            'name' => esc_html__( 'Single Post Layout', 'dine' ),
            'type' => 'radio',
            
            'options' => array(
                'fullwidth'   => esc_html__( 'Fullwidth', 'dine' ),
                'sidebar-left'=> esc_html__( 'Sidebar Left', 'dine' ),
                'sidebar-right'      => esc_html__( 'Sidebar Right', 'dine' ),
            ),
            'std' => 'sidebar-right',
            
        );
        
        /* Typography
        -------------------------------------------------------------------------------- */
        $options[ 'body_font' ] = array(
            'shorthand' => 'font-family',
            'selector'  => 'body',
            'std'       => 'Lato',
            'name'      => esc_html__( 'Body Font', 'dine' ),
            
            'section'     => 'body_font',
            'section_title'=> esc_html__( 'Body Font', 'dine' ),
            'panel'     => 'fonts',
            
            'panel_title'=> esc_html__( 'Fonts', 'dine' ),
            'panel_priority'=> 100,
        );
        
        $options[ 'body_font_weights' ] = array(
            'type'      => 'multicheckbox',
            'options'   => array(
                '100' => '100',
                '200' => '200',
                '300' => '300',
                '400' => '400',
                '500' => '500',
                '600' => '600',
                '700' => '700',
                '800' => '800',
                '900' => '900',
            ),
            'std'       => '400,700',
            'name'      => esc_html__( 'Body Font Weights', 'dine' ),
        );
        
        $options[ 'body_font_size' ] = array(
            'name'      => esc_html__( 'Body Text Size', 'dine' ),
            'shorthand' => 'font-size',
            'std'       => '13',
            'max'       => '20',
            'min'       => '10',
            'selector'  => 'body',
        );
        
        $options[ 'body_letter_spacing' ] = array(
            'name'      => esc_html__( 'Text Spacing', 'dine' ),
            'shorthand' => 'letter-spacing',
            'std'       => '0.5',
            'max'       => '2',
            'min'       => '0',
            'selector'  => 'body',
        );
        
        // Heading Fonts
        // 
        $options[ 'heading_font' ] = array(
            'shorthand' => 'font-family',
            'selector'  => dine_heading_selector(),
            'std'       => 'Oswald',
            'name'      => esc_html__( 'Heading Font', 'dine' ),
            
            'section'     => 'heading_font',
            'section_title'=> esc_html__( 'Heading Font', 'dine' ),
            'panel'     => 'fonts',
        );
        
        $options[ 'heading_font_weights' ] = array(
            'type'      => 'multicheckbox',
            'options'   => array(
                '100' => '100',
                '200' => '200',
                '300' => '300',
                '400' => '400',
                '500' => '500',
                '600' => '600',
                '700' => '700',
                '800' => '800',
                '900' => '900',
            ),
            'std'       => '300,400,700',
            'name'      => esc_html__( 'Font weights to load', 'dine' ),
            'desc'      => esc_html__( 'To optimize loading time, let see only weights you need.', 'dine' ),
        );
        
        $options[ 'heading_weight' ] = array(
            'name'      => esc_html__( 'Default Weight', 'dine' ),
            'shorthand' => 'font-weight',
            'std'       => '400',
            'selector'  => 'h1, h2, h3, h4, h5, h6',
        );
        
        $options[ 'heading_text_transform' ] = array(
            'name'      => esc_html__( 'Heading Text Tranform', 'dine' ),
            'shorthand' => 'text-transform',
            'std'       => 'uppercase',
            'selector'  => 'h1, h2, h3, h4, h5, h6',
        );
        
        $options[ 'heading_letter_spacing' ] = array(
            'name'      => esc_html__( 'Heading Spacing', 'dine' ),
            'shorthand' => 'letter-spacing',
            'std'       => '0.5',
            'selector'  => 'h1, h2, h3, h4, h5, h6',
        );
        
        // Text Slider Font
        // 
        $options[ 'text_slider_font' ] = array(
            'shorthand' => 'font-family',
            'selector'  => '.cd-headline',
            'std'       => 'Bahiana',
            'name'      => esc_html__( 'Text Slider Font', 'dine' ),
            
            'section'     => 'text_slider_font',
            'section_title'=> esc_html__( 'Text Slider Font', 'dine' ),
            'panel'     => 'fonts',
        );
        
        $options[ 'text_slider_font_weights' ] = array(
            'type'      => 'multicheckbox',
            'options'   => array(
                '100' => '100',
                '200' => '200',
                '300' => '300',
                '400' => '400',
                '500' => '500',
                '600' => '600',
                '700' => '700',
                '800' => '800',
                '900' => '900',
            ),
            'std'       => '400',
            'name'      => esc_html__( 'Font weights to load', 'dine' ),
            'desc'      => esc_html__( 'To optimize loading time, let see only weights you need.', 'dine' ),
        );
        
        $options[ 'text_slider_weight' ] = array(
            'name'      => esc_html__( 'Default Weight', 'dine' ),
            'shorthand' => 'font-weight',
            'std'       => '400',
            'selector'  => '.cd-headline',
        );
        
        $options[ 'text_slider_transform' ] = array(
            'name'      => esc_html__( 'Text Slider Text Tranform', 'dine' ),
            'shorthand' => 'text-transform',
            'std'       => 'uppercase',
            'selector'  => '.cd-headline',
        );
        
        // Font Subsets
        // 
        $options[ 'font_subsets' ] = array(
            'type'      => 'multicheckbox',
            'name'      => esc_html__( 'Font Subsets', 'dine' ),
            'options'   => array(
                "latin" => 'Latin',
                "latin-ext" => 'Latin Extended',
                'greek' => 'Greek',
                "greek-ext" => 'Greek Extended',
                "cyrillic" => 'Cyrillic',
                "cyrillic-ext" => 'Cyrillic Extended',
                'vietnamese' => 'Vietnamese',
            ),
            'desc' => esc_html__( 'Note that not each font supports only certain languages, not all.', 'dine' ),
            
            'section'     => 'font_subsets',
            'section_title'=> esc_html__( 'Font Subsets', 'dine' ),
            'panel'     => 'fonts',
        );
        
        /* Style
        ------------------------------------------------------------------------------------------------------------------------ */
        $options[] = array(
            'name'      => esc_html__( 'Container', 'dine' ),
            'type'      => 'heading',
            
            'section'   => 'style',
            'section_title' => esc_html__( 'Style', 'dine' ),
            'section_priority' => 101,
        );
        
        $options[ 'container_width' ] = array (
            
            'shorthand' => 'width',
            'std'       => '1080',
            'min'       => '800',
            'max'       => '1280',
            'step'      => '10',
            'name'      => esc_html__( 'Container Width', 'dine' ),
            
        );
        
        /* Colors
        ------------------- */
        $options[] = array(
            'type'      => 'heading',
            'name'      => esc_html__( 'Colors', 'dine' ),
        );
        
        $options[ 'accent' ] = array(
            'type'      => 'color',
            'name'      => esc_html__( 'Accent Color', 'dine' ),
            'std'       => '#ab3f1b',
            'css'       => array(
                array(
                    'property' => 'color',
                    'selector' => '.header-cart a:hover, .woocommerce .star-rating span:before, a, #nav > li > a:hover, #nav > li.active > a, #nav > li.current-menu-item > a, #nav > li.current-menu-ancestor > a, .tagcloud a:hover, #footer-sidebar .tagcloud a:hover, .offcanvas-nav .menu > ul > li.current-menu-item > a, .offcanvas-nav .menu > ul > li.current-menu-ancestor > a, .offcanvas-nav .menu > ul > li.active > a, .offcanvas-nav .menu > ul ul > li:hover > a, .offcanvas-nav .menu > ul ul > li.current-menu-item > a, .offcanvas-nav .menu > ul ul > li.current-menu-ancestor > a, .counter-number, .testimonial-rating span:before',
                ),
                
                array(
                    'property' => 'background-color',
                    'selector' => 'button.mfp-arrow:hover, .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce span.onsale, .woocommerce ul.products li.product .onsale, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce a.add_to_cart_button:hover, .woocommerce #review_form #respond .form-submit input:hover, button, input[type="button"], input[type="reset"], input[type="submit"], .dine-btn, .sticky .sticky-label, .bypostauthor .comment-author .fn, #scrollup a, input.wpcf7-submit[type="submit"]:hover, body .picker--focused .picker__day--selected, body .picker__day--selected, body .picker__day--selected:hover, .offcanvas-social .social-list a, .dine-menu-item.highlighted, .dine-menu-item.highlighted .menu-item-price, #ui-datepicker-div .ui-state-highlight, #ui-datepicker-div .ui-widget-content .ui-state-highlight, #ui-datepicker-div .ui-widget-header .ui-state-highlight, .dine-testimonials .flex-control-paging li a:hover, .dine-testimonials .flex-control-paging li a.flex-active, .mejs-controls .mejs-time-rail .mejs-time-current',
                ),
                
                array(
                    'property' => 'border-color',
                    'selector' => 'blockquote, button.mfp-arrow:hover, .dine-testimonials .flex-control-paging li a.flex-active',
                )
            ),
        );
        
        // Text Color
        $options[] = array(
            'type'      => 'heading',
            'name'      => esc_html__( 'Text Color', 'dine' ),
        );
        
        $options[ 'body_text_color' ] = array(
            'shorthand' => 'color',
            'name'      => esc_html__( 'Site Text Color', 'dine' ),
            'selector'  => 'body',
            'std'       => '#595959',
        );
        
        $options[ 'heading_text_color' ] = array(
            'shorthand' => 'color',
            'name'      => esc_html__( 'Heading Text Color', 'dine' ),
            'selector'  => 'h1, h2, h3, h4, h5, h6',
            'std'       => '#111',
        );
        
        // Selection
        $options[] = array(
            'type'      => 'heading',
            'name'      => esc_html__( 'Selection', 'dine' ),
        );
        
        $options[ 'selection_background' ] = array(
            'type'      => 'color',
            'name'      => esc_html__( 'Selection Background', 'dine' ),
            
            'css'       => array(
                array(
                    'selector' => '::-moz-selection',
                    'property' => 'background-color',
                ),
                array(
                    'selector' => '::selection',
                    'property' => 'background-color',
                ),
            ),
        );
        
        $options[ 'selection_color' ] = array(
            'type'      => 'color',
            'name'      => esc_html__( 'Selection Text Color', 'dine' ),
            
            'css'       => array(
                array(
                    'selector' => '::-moz-selection',
                    'property' => 'color',
                ),
                array(
                    'selector' => '::selection',
                    'property' => 'color',
                ),
            ),
        );
        
        /* Misc
        ---------------------------------------- */
        $options[ 'page_search_result' ] = array(
            'shorthand' => 'enable',
            'name'      => esc_html__( 'Include pages in search results', 'dine' ),
            'std'       => 'true',
            
            'section'   => 'misc',
            'section_title' => esc_html__( 'Miscellaneous', 'dine' ),
            'section_priority' => 120,
        );
        
        $options[ 'page_star_icon' ] = array(
            'type'      => 'enable',
            'name'      => esc_html__( 'Displays "star icon" on pages', 'dine' ),
            'std'       => 'true',
            'toggle'    => array(
                'true' => array( 'page_star_icon_replacement' ),
            ),
        );
        
        $options[ 'page_star_icon_replacement' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Replace "star icon" by another one', 'dine' ),
            'desc'      => 'You can see the <a href="http://fontawesome.io/icons/" target="_blank">list of all icons here</a>',
            'placeholder' => 'Eg. leaf',
        );
        
        $options[ 'google_maps_api_key' ] = array(
            'type'      => 'text',
            'name'      => esc_html__( 'Google Maps API', 'dine' ),
            'desc'      => 'Google Maps API is required when you use Google Map. Get API Key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a>',
        );
        
        // @hook `dine_options` so that outer options are welcome
        $options = apply_filters( 'dine_options', $options );
        
        require get_template_directory() . '/inc/customizer/processor.php';
        
        return $final;
        
    }
    
}

endif; // class exists