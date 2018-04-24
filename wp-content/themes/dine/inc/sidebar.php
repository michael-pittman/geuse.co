<?php
/**
 * Sidebar Class
 *
 * @since 1.0
 */
if ( ! class_exists( 'Dine_Sidebar' ) ) :

class Dine_Sidebar
{
    
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
        
        add_filter( 'body_class', array( $this, 'sidebar_class' ) );
        
        add_filter( 'dine_sidebar_state', array( $this, 'sidebar_state' ) );
        
        add_filter( 'dine_sidebar_state', array( $this, 'blank_fullwidth' ) );
        
    }
    
    function blank_fullwidth( $state ) {
        
        if ( is_page_template( 'template-blank.php' ) || is_page_template( 'template-frontpage.php' ) ) return false;
        return $state;
    
    }
    
    /**
     * Returns sidebar left, right or false
     *
     * @since 1.0
     */
    function sidebar_state( $sidebar_state ) {
        
        $layout = '';
        
        if ( is_home() && get_option( 'show_on_front' ) == 'page' && $page_id = get_option( 'page_for_posts' ) ) {
            
            $layout = get_post_meta( $page_id, '_dine_layout', true );
        
        } elseif ( is_archive() || is_search() ) {
            
            $layout = get_option( 'dine_archive_layout', 'sidebar-right' );
        
        } elseif ( is_single() ) {
            
            $layout = get_option( 'dine_single_layout', 'sidebar-right' );
        
        } elseif ( is_singular() ) {
        
            global $post;
            
            $layout = get_post_meta( get_the_ID(), '_dine_layout', true );
            
            if ( ! $layout ) $layout = 'fullwidth';
            
        } elseif ( is_404() ) {
            
            return false;
            
        }
        
        // final attempt
        if ( ! $layout ) {
        
            $layout = get_option( 'dine_layout', 'sidebar-right' );
        
        }
        
        if ( 'sidebar-right' === $layout )
            
            return 'right';
        
        elseif ( 'sidebar-left' === $layout )
            
            return 'left';
        
        else
            
            return false;
    }
    
    /**
     * Sidebar Class adds sidebar state to body (fullwidth, sidebar left, right...)
     *
     * @since 1.0
     */
    function sidebar_class( $classes ) {
        
        $sidebar_state = dine_sidebar_state();
        
        if ( ! $sidebar_state ) {
            $classes[] = 'dine-fullwidth dine-fullwidth';
        } else {
            $classes[] = 'has-sidebar sidebar-' . $sidebar_state;
        }
        
        return $classes;
    
    }
    
}

Dine_Sidebar::instance()->init();

endif;

if ( ! function_exists( 'dine_sidebar_state' ) ) :
/**
 * Check current page has sidebar or not
 *
 * @return boolan true or false
 *
 * @since 1.0
 */
function dine_sidebar_state() {
    return apply_filters( 'dine_sidebar_state', false );
}
endif;

if ( ! function_exists( 'dine_maybe_sidebar' ) ) :
/**
 * Maybe Sidebar gets sidebar depending theme option
 *
 * @since 1.0
 */
function dine_maybe_sidebar( $sidebar_name = '' ) {
    if ( dine_sidebar_state() ) get_sidebar( $sidebar_name );
}
endif;