<?php
if ( ! function_exists('dine_woocommerce_installed') ) :
function dine_woocommerce_installed() {
    return class_exists( 'WooCommerce' );
}
endif;

if ( !class_exists( 'Dine_WooCommerce' ) ) :
/**
 * WooCommerce class
 *
 * @since 1.1
 */
class Dine_WooCommerce
{   
    
    /**
	 * Construct
	 */
	public function __construct() {
	}
    
    /**
	 * The one instance of class
	 *
	 * @since 1.1
	 */
	private static $instance;

	/**
	 * Instantiate or return the one class instance
	 *
	 * @since 1.1
	 *
	 * @return class
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
     * @since 1.1
     */
    public function init() {
        
        // disable shop title
        add_filter( 'woocommerce_show_page_title', '__return_false' );
        
        // .container wrapper
        add_action('woocommerce_before_main_content', array( $this, 'wrapper_start' ), 10);
        add_action('woocommerce_after_main_content', array( $this, 'wrapper_end' ), 10);
        
        add_action( 'woocommerce_before_shop_loop_item', array( $this, 'content_product_thumbnail_open' ), 9 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 11 );
        add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'content_product_thumbnail_close' ), 12 );
        
        // Add to cart button
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 11 );
        
        // Sale Flash
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
        add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 14 );
        
        // Custom title
        remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
        add_action( 'woocommerce_shop_loop_item_title', array( $this, 'content_product_title' ), 10 );
        
        // single images markup
        add_filter( 'woocommerce_product_thumbnails_columns', function( $column ) { return 4; } ) ;
        
        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
        add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash', 14 );
        
        // WooCommerce Options
        add_filter( 'loop_shop_per_page', array( $this, 'products_per_page' ), 20 );
        add_filter('loop_shop_columns', array( $this, 'loop_columns' ), 999 );
        
        // Body Class
        if ( dine_woocommerce_installed() ) {
            
            // WooCommerce Options
            add_filter( 'dine_options', array( $this, 'options' ) );
            
            // Sidebar State
            add_filter( 'dine_sidebar_state', array( $this, 'sidebar_state' ) );
            
            add_action( 'widgets_init', array( $this, 'widgets_init' ) );
            
            add_filter( 'dine_transparent_header', array( $this, 'transparent_header' ) );
            
        }
        
        add_filter( 'body_class', array( $this, 'body_class' ) );
        
    }
    
    function transparent_header( $return ) {
        
        if ( is_shop() ) {
            
            $shop_id = get_option( 'woocommerce_shop_page_id' );
            if ( ! $shop_id ) return false;
            return 'true' == get_post_meta( $shop_id, '_dine_transparent_header', true );
            
        }
        
        return $return;
    
    }
    
    /**
     * Register Shop Sidebar
     */
    function widgets_init() {
        
        register_sidebar( array(
            'name'          => esc_html__( 'Shop Sidebar', 'dine' ),
            'id'            => 'shop',
            'description'   => esc_html__( 'Add widgets here to appear in the sidebar of WooCommerce pages.', 'dine' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
    
    }
    
    /**
     * Sidebar state of the shop
     */
    function sidebar_state( $sidebar_state ) {
        
        if ( is_shop() ) {
            
            $shop_id = get_option( 'woocommerce_shop_page_id' );
            if ( ! $shop_id ) return false;
            
            $state = get_post_meta( $shop_id, '_dine_layout', true );
            if ( 'sidebar-right' != $state && 'sidebar-left' != $state ) $state = 'fullwidth';
            
            if ( 'sidebar-right' === $state )
            
                return 'right';

            elseif ( 'sidebar-left' === $state )

                return 'left';

            else

                return false;
        
        } elseif ( is_woocommerce() ) {
            
            $state = get_option( 'dine_woocommerce_sidebar', 'fullwidth' );
            if ( 'sidebar-right' != $state && 'sidebar-left' != $state ) $state = 'fullwidth';
            
            if ( 'sidebar-right' === $state )
            
                return 'right';

            elseif ( 'sidebar-left' === $state )

                return 'left';

            else

                return false;
        
        }
        
        return $sidebar_state;
    
    }
    
    function content_product_thumbnail_open() {
    
        echo '<div class="product-thumbnail"><div class="product-thumbnail-inner">';
        
    }
    
    function content_product_thumbnail_close() {
        
        echo '</div></div>';
        
    }
    
    function content_product_title() {
        
        echo '<h3 class="product-title"><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h3>';
        
    }
    
    /**
     * Wrapper start
     *
     * @since 1.1
     */
    function wrapper_start() {
        
        echo '<div class="container">';
    
    }
    
    /**
     * Wrapper End
     *
     * @since 1.1
     */
    function wrapper_end() {
        
        echo '</div>';
    
    }
    
    /**
     * Single Product Image HTML
     *
     * We just wanna remove zoom class to replace it by iLightbox class
     *
     * @since 1.1
     */
    function single_product_image_html( $html, $post_id ) {
        
        global $post;
        
        $attachment_id    = get_post_thumbnail_id();
        $props            = wc_get_product_attachment_props( $attachment_id, $post );
        $image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
            'title'	 => $props['title'],
            'alt'    => $props['alt'],
        ) );
        
        // lightbox options
        $thumbnail_src = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
        $full_src = wp_get_attachment_image_src( $attachment_id, 'full' );
        $image_options = 'thumbnail:\'' . $thumbnail_src[0] . '\', width: ' . $full_src[1] . ', height:' . $full_src[2];
        
        $html = sprintf( 
            '<a href="%s" itemprop="image" class="woocommerce-main-image lightbox-link" title="%s" data-options="%s" rel="shop-thumbnail">%s</a>', 
            $props['url'], 
            $props['caption'],
            $image_options,
            $image 
        );
        
        return $html;
    
    }
    
    /**
     * Single Thumbnails HTML
     *
     * We just wanna remove zoom class to replace it by iLightbox class
     *
     * @since 1.1
     */
    function single_product_image_thumbnail_html( $html, $attachment_id ) {
        
        $full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
		$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
        $image_title     = get_post_field( 'post_excerpt', $attachment_id );
		$attributes = array(
			'title'                   => $image_title,
			'data-src'                => $full_size_image[0],
			'data-large_image'        => $full_size_image[0],
			'data-large_image_width'  => $full_size_image[1],
			'data-large_image_height' => $full_size_image[2]
		);
        
        $image_options = 'thumbnail:\'' . $thumbnail[0] . '\', width: ' . $full_size_image[1] . ', height:' . $full_size_image[2];
        
		$html  = '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '" class="lightbox-link" data-options=" ' . esc_attr( $image_options ) . '" rel="shop-thumbnail">';
		$html .= wp_get_attachment_image( $attachment_id, 'shop_thumbnail', false, $attributes );
 		$html .= '</a></div>';
		
        return $html;
    
    }
    
    /**
     * Custom number of products per page
     *
     * @since 1.1
     */
    function products_per_page( $ppp ) {
        
        $custom_ppp = absint( get_option( 'dine_products_per_page', 8 ) );
        if ( $custom_ppp > 0 ) return $custom_ppp;
        return $ppp;
        
    }
    
    /**
     * Custom shop column
     *
     * @since 1.1
     */
    function loop_columns() {
        $column = get_option( 'dine_shop_column', 4 );
        if ( 2 != $column && 3 != $column ) $column = 4;
		return absint( $column );
	}
    
    /**
     * Options
     *
     * @since 1.1
     */
    function options( $options ) {
        
        $options[ 'products_per_page' ] = array(
            'name' => esc_html__( 'Custom number of products per page', 'dine' ),
            'type' => 'text',
            'std' => 8,
            
            'section' => 'woocommerce',
            'section_title' => esc_html__( 'WooCommerce', 'dine' ),
            'section_priority' => 140,
        );
        
        $options[ 'shop_column' ] = array(
            'name' => esc_html__( 'Default Catalog Column Layout', 'dine' ),
            'type' => 'radio',
            'options' => array(
                '2' => esc_html__( '2 Columns', 'dine' ),
                '3' => esc_html__( '3 Columns', 'dine' ),
                '4' => esc_html__( '4 Columns', 'dine' ),
            ),
            'std' => '4',
        );
        
        $options[ 'woocommerce_sidebar' ] = array(
            'name' => esc_html__( 'Sidebar', 'dine' ),
            'type' => 'radio',
            'options' => array(
                'fullwidth' => esc_html__( 'Fullwidth', 'dine' ),
                'sidebar-left' => esc_html__( 'Sidebar Left', 'dine' ),
                'sidebar-right' => esc_html__( 'Sidebar Right', 'dine' ),
            ),
            'std' => 'fullwidth',
            'desc' => esc_html__( 'This options affect shop categories, tags & single products. To select sidebar state for main shop page, please edit your shop page & select it from Page Options.', 'dine' ),
        );
        
        return $options;
    
    }
    
    /**
     * Classes
     *
     * @since 1.1
     */
    function body_class( $classes ) {
    
        if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
            $key = array_search( 'sidebar-left', $classes );
            unset( $classes[ $key ] );
            $key = array_search( 'sidebar-right', $classes );
            unset( $classes[ $key ] );
            
            $column = get_option( 'dine_shop_column', 4 );
            if ( '3' != $column && '2' != $column ) $column = '4';
            $classes[] = 'columns-' . $column;
        }
        
        return $classes;
        
    }
    
}

Dine_WooCommerce::instance()->init();

endif;