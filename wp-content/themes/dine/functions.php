<?php
/**
 * Dine functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Dine
 * @since 1.0
 */

/**
 * Dine only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dine_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/dine
	 * If you're building a theme based on Dine, use a find and replace
	 * to change 'dine' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'dine' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Set the default content width.
	$GLOBALS['content_width'] = 1080;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'dine' ),
        'social' => esc_html__( 'Social Links', 'dine' ),
        'footer' => esc_html__( 'Footer Menu', 'dine' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
    
    // @since 2.0
    add_image_size( 'dine_grid', 600, 400, true );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
    
    // @since 1.1
	add_theme_support( 'woocommerce' );
    
}
add_action( 'after_setup_theme', 'dine_setup' );

/**
 * Register custom fonts.
 */
function dine_fonts_url() {
    
    $fonts_url = '';
	$fonts     = array();
    $subsets = trim( get_option( 'dine_font_subsets' ) );
    
    $font_positions = array(
        'nav' => array(
            'face' => 'Oswald',
            'weights' => '400',
        ),
        'heading' => array(
            'face' => 'Oswald',
            'weights' => '300,400,700',
        ),
        'body' => array(
            'face' => 'Lato',
            'weights' => '400,700',
        ),
        'text_slider' => array(
            'face' => 'Bahiana',
            'weights' => '400',
        ),
    );
    $google_fonts = dine_google_fonts();
    
    foreach ( $font_positions as $position => $font_data ) {
        
        $weight_std = $font_data[ 'weights' ];
            
        $face = get_option( "dine_{$position}_font", $font_data[ 'face' ] );
        if ( ! $face ) continue;

        $weights = trim( get_option( "dine_{$position}_font_weights", $weight_std ) );
        if ( $weights ) $face = "{$face}:{$weights}";
        $fonts[] = $face;
        
    }
    
    // remove duplicated elements
    $fonts = array_unique( $fonts );

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

    return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Dine 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function dine_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'dine-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'dine_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dine_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'dine' ),
		'id'            => 'main',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'dine' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'dine' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'dine' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'dine' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'dine' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'dine' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'dine' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'dine_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Dine 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function dine_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}
    
	return ' &hellip; ';
}
add_filter( 'excerpt_more', 'dine_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Dine 1.0
 */
function dine_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'dine_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function dine_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'dine_pingback_header' );

/**
 * Enqueue scripts and styles.
 */
function dine_scripts() {
    
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'dine-fonts', dine_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'dine-style', get_stylesheet_uri() );

    // Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
        
//    wp_enqueue_script( 'modernizr', get_theme_file_uri( '/assets/js/modernizr-custom.js' ), null, '3.3.1', true );
    
//    wp_enqueue_script( 'tweenmax', get_theme_file_uri( '/assets/js/TweenMax.min.js' ), null, '1.18.2', true );
//    wp_enqueue_script( 'ScrollMagic', get_theme_file_uri( '/assets/js/ScrollMagic.min.js' ) , null, '2.0.5', true );
//    wp_enqueue_script( 'animation.gsap', get_theme_file_uri( '/assets/js/animation.gsap.js' ), array( 'tweenmax' ), '2.0.5', true );
//    wp_enqueue_script( 'ScrollToPlugin', get_theme_file_uri( '/assets/js/ScrollToPlugin.min.js' ) , null, '1.18.2', true );
    
//    wp_enqueue_script( 'fitvids', get_theme_file_uri( '/assets/js/jquery.fitvids.js' ), array( 'jquery' ), '1.0', true );        
    
//    wp_enqueue_script( 'flickity', get_theme_file_uri( '/assets/js/flickity.pkgd.min.js' ), array( 'jquery' ), '2.0.5', true );    

//    wp_enqueue_script( 'superfish', get_theme_file_uri( '/assets/js/superfish.js' ), array( 'jquery' ), '1.7.9', true );
    
//    wp_enqueue_script( 'jquery-tipsy', get_theme_file_uri( '/assets/js/jquery.tipsy.js' ), array( 'jquery' ), '1.0', true );
    
//    wp_enqueue_script( 'jquery-inview', get_theme_file_uri( '/assets/js/jquery.inview.min.js' ), array( 'jquery' ), '1.0', true );
    
//    wp_enqueue_script( 'jquery-imagesloaded', get_theme_file_uri( '/assets/js/imagesloaded.pkgd.min.js' ), array( 'jquery' ), '4.1.0', true );
    
//    wp_enqueue_script( 'jquery-magnific-popup', get_theme_file_uri( '/assets/js/jquery.magnific-popup.js' ), array( 'jquery' ), '1.1.0', true );
    
//    wp_enqueue_script( 'dine-waypoints', get_theme_file_uri( '/assets/js/jquery.waypoints.js' ), array( 'jquery' ), '4.0.0', true );
    
//    wp_enqueue_script( 'dine-theme-files', get_theme_file_uri( '/assets/js/theme-files.js' ), array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'dine-main', get_theme_file_uri( '/assets/js/theme.min.js' ), array( 'jquery' ), '1.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    
    $jsdata = array();
    $jsdata[ 'header_sticky'] = 'true' === get_option( 'dine_header_sticky' ) ? true : false;
    $jsdata[ 'header_sticky_mobile'] = 'true' === get_option( 'dine_header_sticky_mobile' ) ? true : false;
    
    $header_h = absint( get_option( 'dine_header_height' ) );
    if ( ! $header_h ) $header_h = 100;
    $jsdata[ 'header_height' ] = $header_h;
    
    $header_sticky_h = absint( get_option( 'dine_header_sticky_height' ) );
    if ( ! $header_sticky_h ) $header_sticky_h = 80;
    $jsdata[ 'header_sticky_height' ] = $header_sticky_h;
        
    $jsdata = apply_filters( 'dine_jsdata', $jsdata );
	wp_localize_script( 'dine-main', 'DINE', $jsdata );
    
}
add_action( 'wp_enqueue_scripts', 'dine_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Templates for Visual Composer
 */
require get_parent_theme_file_path( '/inc/templates.php' );

/**
 * Sidebar for the theme
 */
require get_parent_theme_file_path( '/inc/sidebar.php' );

/**
 * Admin
 */
require_once get_template_directory() . '/inc/admin/admin.php';

/**
 * WooCommerce
 * @since 1.1
 */
require get_parent_theme_file_path( '/inc/woocommerce.php' );

/**
 * Customizer additions.
 */
require_once get_parent_theme_file_path ( '/inc/customizer/fonts.php' );
require_once get_parent_theme_file_path ( '/inc/helpers.php' );
require_once get_parent_theme_file_path ( '/inc/customizer/customizer.php' );
require_once get_parent_theme_file_path ( '/inc/customizer/register.php' );
require_once get_parent_theme_file_path ( '/inc/css.php' );

/**
 * Widgets
 */
require_once get_parent_theme_file_path ( '/widgets/social/register.php' );

if ( !function_exists( 'dine_social_array' ) ) :
/**
 * Returns an array of social icons
 *
 * @since 1.0
 */
function dine_social_array() {

    $social_arr = array(
        'facebook' => array( 'icon' => 'facebook', 'name' => esc_html__( 'Facebook', 'dine' ) ),
        'twitter' => array( 'icon' => 'twitter', 'name' => esc_html__( 'Twitter', 'dine' ) ),
        'pinterest' => array( 'icon' => 'pinterest-p', 'name' => esc_html__( 'Pinterest', 'dine' ) ),
        'instagram' => array( 'icon' => 'instagram', 'name' => esc_html__( 'Instagram', 'dine' ) ),
        'googleplus' => array( 'icon' => 'google-plus', 'name' => esc_html__( 'Google+', 'dine' ) ),
        'linkedin' => array( 'icon' => 'linkedin', 'name' => esc_html__( 'LinkedIn', 'dine' ) ),
        'tumblr' => array( 'icon' => 'tumblr', 'name' => esc_html__( 'Tumblr', 'dine' ) ),
        'youtube' => array( 'icon' => 'youtube-play', 'name' => esc_html__( 'YouTube', 'dine' ) ),
        'skype' => array( 'icon' => 'skype', 'name' => esc_html__( 'Skype', 'dine' ) ),
        'medium' => array( 'icon' => 'medium', 'name' => esc_html__( 'Medium', 'dine' ) ),
        'vimeo' => array( 'icon' => 'vimeo-square', 'name' => esc_html__( 'Vimeo', 'dine' ) ),
        'yahoo' => array( 'icon' => 'yahoo', 'name' => esc_html__( 'Yahoo!', 'dine' ) ),
        'flickr' => array( 'icon' => 'flickr', 'name' => esc_html__( 'Flickr', 'dine' ) ),
        'tripadvisor' => array( 'icon' => 'tripadvisor', 'name' => esc_html__( 'TripAdvisor', 'dine' ) ),
        'yelp' => array( 'icon' => 'yelp', 'name' => esc_html__( 'Yelp', 'dine' ) ),
        'foursquare' => array( 'icon' => 'foursquare', 'name' => esc_html__( 'Foursquare', 'dine' ) ),
        'paypal' => array( 'icon' => 'paypal', 'name' => esc_html__( 'Paypal', 'dine' ) ),
        'bloglovin' => array( 'icon' => 'heart', 'name' => esc_html__( 'Bloglovin', 'dine' ) ),
        'weibo' => array( 'icon' => 'weibo', 'name' => esc_html__( 'Weibo', 'dine' ) ),
        'vk' => array( 'icon' => 'vk', 'name' => esc_html__( 'VKontakte', 'dine' ) ),
        'home' => array( 'icon' => 'home', 'name' => esc_html__( 'Homepage', 'dine' ) ),
        'email' => array( 'icon' => 'envelope', 'name' => esc_html__( 'Email', 'dine' ) ),
        'rss' => array( 'icon' => 'rss', 'name' => esc_html__( 'Feed', 'dine' ) ),
    );
    
    return apply_filters( 'dine_social_array', $social_arr );
    
}
endif;

if ( ! function_exists( 'dine_social' ) ) :
/**
 * Displays social list
 *
 * @since 1.0
 */
function dine_social() {
    
    $social_class = array( 'social-list' );
    $social_array = dine_social_array();
    
    foreach ( $social_array as $optionid => $icondata ) {
        
        $url = get_option( "dine_social_{$optionid}", '' );
        
        if ( $url ) {
            
            $url = trim( $url );
        
            $title = ' title="' . esc_attr( $icondata[ 'name' ] ) . '"';
            $class = 'fa fa-' . $icondata['icon'];
            
            if ( 'email' === $optionid ) {
                $url = str_replace( 'mailto:', '', $url );
                $url = "mailto:{$url}";
                $target = '_self';
            }
            
            $return .= '<li class="' . esc_attr( "li-{$optionid}" ) . '"><a href="' . esc_url( $url ) . '" target="_blank"' . $title . '>';
            $return .= '<i class="' . esc_attr( $class ) . '"></i>';
            $return .= '</a></li>';
        
        }
        
    }
    
    // join class
    $social_class = join( ' ', $social_class );
    
    if ( ! empty ( $return ) ) 
        echo '<nav class="' . esc_attr( $social_class ) . '"><ul>' . $return . '</ul></nav>';

}   
endif;    

/**
 * Returns an array of supported social links (URL and icon name).
 *
 * @return array $social_links_icons
 */
function dine_social_links_icons() {
	// Supported social links icons.
	$social_links_icons = array(
		'behance.net'     => 'behance',
		'codepen.io'      => 'codepen',
		'deviantart.com'  => 'deviantart',
		'digg.com'        => 'digg',
		'dribbble.com'    => 'dribbble',
		'dropbox.com'     => 'dropbox',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'foursquare.com'  => 'foursquare',
		'plus.google.com' => 'google-plus',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'mailto:'         => 'envelope-o',
		'medium.com'      => 'medium',
		'pinterest.com'   => 'pinterest-p',
		'getpocket.com'   => 'get-pocket',
		'reddit.com'      => 'reddit-alien',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'slideshare.net'  => 'slideshare',
		'snapchat.com'    => 'snapchat-ghost',
		'soundcloud.com'  => 'soundcloud',
		'spotify.com'     => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'vine.co'         => 'vine',
		'vk.com'          => 'vk',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'yelp'            => 'yelp',
		'youtube.com'     => 'youtube',
        'tripadvisor'     => 'tripadvisor',
	);

	/**
	 * Filter Twenty Seventeen social links icons.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param array $social_links_icons
	 */
	return apply_filters( 'dine_social_links_icons', $social_links_icons );
}

/**
 * Displays icons in social links menu.
 *
 * @since 1.0
 */
function dine_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Get supported social icons.
	$social_icons = dine_social_links_icons();

	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social' === $args->theme_location ) {
        foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span><i class="fa fa-' . esc_attr( $value ) . '"></i>' , $item_output );
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'dine_nav_menu_social_icons', 10, 4 );

/**
 * Side Navigation
 *
 * @since 1.0
 */
add_action( 'wp_footer', 'dine_sidenav' );
function dine_sidenav() {
    
    if ( ! is_page() ) return;
    $nav = get_post_meta( get_the_ID(), '_dine_sidenav', true );
    if ( ! $nav ) return;
    
    wp_nav_menu( array(
        
        'menu' => $nav,
        'menu_id' => 'sidenav',
        'container_id' => 'sidenav-wrapper',
        'fallback_cb' => false,
        'depth' => 1,
        'link_before' => '<span>',
        'link_after' => '</span>',
    
    ) );
    
}

/**
 * Footer Scrollup
 *
 * @since 1.0
 */
add_action( 'wp_footer', 'dine_footer_scrollup' );
function dine_footer_scrollup() {
    
    if ( 'false' == get_option( 'dine_footer_scrollup', 'true' ) ) return;
    
    $goto = get_option( 'dine_goto' );
    if ( ! $goto ) $goto = esc_html__( 'Go To', 'dine' );
    
    $top = get_option( 'dine_top' );
    if ( ! $top ) $top = esc_html__( 'Top', 'dine' );
    
    ?>

<div id="scrollup">

    <a href="#top">
        <span class="goto"><?php echo esc_html( $goto ); ?></span>
        <span class="top-text"><?php echo esc_html( $top ); ?></span>
    </a>

</div>

<?php
    
}

if (!function_exists( 'dine_image_full_quality' ) ) :
/**
 * Set highest quality for images
 *
 * Remove this filter in your child theme if you do not wanna set highest quality for images
 *
 * @since 1.0
 */
function dine_image_full_quality( $quality ) {
    return 100;
}
endif;
add_filter( 'jpeg_quality', 'dine_image_full_quality' );
add_filter( 'wp_editor_set_quality', 'dine_image_full_quality' );

if ( ! function_exists( 'dine_page_in_search_result' ) ) :
/**
 * Include/Exclude pages from search results
 *
 * @since 1.0
 */
function dine_page_in_search_result( $args, $post_type ) {
    
    $page_search_result = get_option( 'dine_page_search_result' );
    if ( 'false' === $page_search_result && 'page' === $post_type ) {
        $args[ 'exclude_from_search' ] = true;
    }
    
    return $args;
    
}
endif;
add_filter( 'register_post_type_args', 'dine_page_in_search_result', 10, 2 );

/**
 * Mobile Nav Markup
 *
 * @since 1.0
 */
add_action( 'wp_footer', 'dine_mobile_nav', 0 );
function dine_mobile_nav() {
?>
<div id="offcanvas">

    <?php if ( has_nav_menu( 'primary' ) ) { ?>
            
        <nav id="mobilenav" class="offcanvas-nav">

            <?php wp_nav_menu(array(
                'theme_location'	=>	'primary',
                'depth'				=>	3,
                'container_class'	=>	'menu',
                
                'after' => '<span class="indicator"></span>',
            ));?>

        </nav><!-- #wi-mainnav -->
    
    <?php } // primary menu
    
    if ( has_nav_menu( 'social' ) ) {

        wp_nav_menu( array (
            'theme_location'	=>	'social',
            'menu_id'           =>  'offcanvas-header-social',
            'depth'				=>	1,
            'container_class'	=>	'offcanvas-social',
            'menu_class'        =>  'social-list',
            'link_before'        => '<span>',
            'link_after'        => '</span>',
        ) );

    } 
                            
    
get_template_part( 'parts/header-button' ); 
    
    ?>
    
</div><!-- #offcanvas -->

<div id="offcanvas-overlay"></div>
<?php
}

/**
 * Visual Composer Compatibility
 *
 * @since 1.0
 */
add_action( 'vc_before_init', 'dine_vcSetAsTheme' );
function dine_vcSetAsTheme() {
    vc_set_as_theme();
}