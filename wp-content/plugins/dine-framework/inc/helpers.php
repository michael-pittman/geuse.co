<?php
add_shortcode( 'dropcap', 'dine_dropcap' );
if ( ! function_exists( 'dine_dropcap' ) ) :
/**
 * Dropcap Shortcode
 *
 * @since 1.0
 */
function dine_dropcap( $atts, $content = null ) {
    
    extract( shortcode_atts( array(
        'color' => '',
    ), $atts ) );
    
    $dropcap_css = '';
    if ( $color ) {
        $dropcap_css = ' style="' . esc_attr( 'color:' . $color ). ';"';
    }
    
    return '<span class="dine-dropcap"' . $dropcap_css . '>' . trim( $content ) . '</span>';
    
}
endif;

add_shortcode( 'link', 'dine_link_sc' );
if ( ! function_exists( 'dine_link_sc' ) ) :
/**
 * Link Shortcode
 *
 * @since 1.0
 */
function dine_link_sc( $atts, $content = null ) {
    
    extract( shortcode_atts( array(
        'text' => '',
        'url' => '',
        'link' => '',
        'target' => '',
    ), $atts ) );
    
    $url = trim( $url );
    $link = trim( $link );
    $text = trim( $text );
    if ( ! $url ) $url = $link;
    
    if ( '_blank' != $target ) $target = '_self';
    
    if ( ! $url || ! $text ) return;
    return '<a href="' . esc_url( $url ) . '" target="' . esc_attr( $target ). '" class="dine-nice-link">' . esc_html( $text ). '</a>';
    
}
endif;

add_shortcode( 'share', 'dine_share_sc' );
if ( ! function_exists( 'dine_share_sc' ) ) :
/**
 * Share Shortcode
 *
 * @since 1.0
 */
function dine_share_sc( $atts, $content = null ) {
    
    if ( function_exists( 'dine_entry_share' ) ) {
        ob_start();
        dine_entry_share();
        return ob_get_clean();
    }
    return;
    
}
endif;

add_shortcode( 'highlight', 'dine_highlight' );
if ( ! function_exists( 'dine_highlight' ) ) :
/**
 * Highlight Shortcode
 *
 * @since 1.0
 */
function dine_highlight( $atts, $content = null ) {
    
    return '<span class="dine-highlight">' . trim($content) . '</span>';
    
}
endif;

add_shortcode( 'spacer', 'dine_spacer' );
if ( ! function_exists( 'dine_spacer' ) ) :
/**
 * Spacer Shortcode
 *
 * @since 1.0
 */
function dine_spacer( $atts, $content = null ) {
    
    $css = '';
    $height = isset( $atts[ 'height' ] ) ? $atts[ 'height' ] : '';
    $height = trim( $height );
    if ( $height != '' ) {
        if ( is_numeric( $height ) ) $height .= 'px';
        $css = ' style="height:' . esc_attr($height) . '"';
    }
    
    return '<div class="dine-spacer"' . $css . '>' . trim($content) . '</div>';
    
}
endif;

add_shortcode( 'tooltip', 'dine_tooltip' );
if ( ! function_exists( 'dine_tooltip' ) ) :
/**
 * Tooltip Shortcode
 *
 * @since 1.0
 */
function dine_tooltip( $atts, $content = null ) {
    
    $title_attr = '';
    $title = isset( $atts[ 'title' ] ) ? $atts[ 'title' ] : '';
    $title = trim( $title );
    if ( $title != '' ) {
        $title_attr = ' title="' . esc_attr( $title ) . '"';
    }
    
    return '<span class="dine-tooltip hastip"' . $title_attr . '>' . trim($content) . '</span>';
    
}
endif;

if ( ! function_exists( 'dine_font_weight' ) ) :
/**
 * Lists all font weights possible
 *
 * @since 1.0
 */
function dine_font_weight() {
    
    return array(
        'Default' => '',
        '100' => '100',
        '200' => '200',
        '300' => '300',
        '400' => '400',
        '500' => '500',
        '600' => '600',
        '700' => '700',
        '800' => '800',
        '900' => '900',
    );
    
}
endif;

if ( ! function_exists( 'dine_font_style' ) ) :
/**
 * Lists all font styles possible
 *
 * @since 1.0
 */
function dine_font_style() {
    
    return array(
        'Default' => '',
        'Normal' => 'normal',
        'Italic' => 'italic',
    );
    
}
endif;

if ( ! function_exists( 'dine_text_transform' ) ) :
/**
 * Text transform states
 *
 * @since 1.0
 */
function dine_text_transform() {
    
    return array(
        'Default' => '',
        'None' => 'none',
        'UPPERCASE' => 'uppercase',
        'lowercase' => 'lowercase',
        'Capitalize' => 'capitalize',
    );
    
}
endif;

if ( ! function_exists( 'dine_border_style' ) ):
/**
 * Border Style
 *
 * @since 1.0
 */
function dine_border_style() {
    return array(
        'none' => esc_html__( 'None', 'dine' ),
        'solid' => esc_html__( 'Solid', 'dine' ),
        'dotted' => esc_html__( 'Dotted', 'dine' ),
        'dashed' => esc_html__( 'Dashed', 'dine' ),
        'double' => esc_html__( 'Double', 'dine' ),
    );
}
endif;

if ( ! function_exists( 'dine_button_params' ) ):
/**
 * Button Params
 *
 * @since 1.0
 */
function dine_button_params( $group = '', $modifications = array() ) {
    
    $params = array();
    include DINE_FRAMEWORK_PATH . 'addons/button/params.php';
    
    if ( $group ) {
        foreach ( $params as $i => $param ) {
            
            if ( isset( $modifications[ $param[ 'param_name' ] ] ) ) {
                $param = $modifications[ $param[ 'param_name' ] ];
            }
        
            if ( ! isset( $param[ 'group' ] ) ) {
                $param[ 'group' ] = $group;
            }
            $params[ $i ] = $param;
        
        }
    }
    
    return $params;
    
}
endif;