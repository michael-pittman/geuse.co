<?php
if ( ! function_exists( 'dine_font_assignment' ) ) :
/*
 * Font Assignment
 *
 * @since 1.0
 */
function dine_font_assignment() {
    
    $normal_fonts = dine_normal_fonts();
    $google_fonts = dine_google_fonts();
    
    $font_assigns = array();
    $font_positions = array(
        'body' => 'Open Sans', 
        'heading' => 'Oswald',
    );
    $font_face_rules = '';
    foreach ( $font_positions as $position => $std ) {
        
        $type = get_option( "dine_{$position}_font_type" );
        if ( 'upload' != $type ) $type = 'standard';
        
        if ( 'standard' == $type ) {
            
            $font = get_option( "dine_{$position}_font", $std );
            
            if ( ! $font ) continue;
            
            if ( isset( $normal_fonts[ $font ] ) ) {
                $font = '"' . $normal_fonts[ $font ][ 'face' ] . '",' . $normal_fonts[ $font ][ 'category' ] ;
            } elseif ( isset( $google_fonts[ $font ] ) ) {
                $cat = $google_fonts[ $font ][ 'category' ];
                if ( 'handwriting' == $cat || 'display' == $cat ) {
                    $fallback = 'cursive';
                } else {
                    $fallback = $cat;
                }
                $font = '"' . $font . '",' . $fallback;
            }
            
            
        } elseif ( 'upload' == $type ) {
        
            $font_file = trim( get_option( "dine_{$position}_upload_font" ) );
            $font = '';
            if ( $font_file ) {
                
                $font = trim( get_option( "dine_{$position}_upload_font_name" ) );

                $fallback = get_option( "dine_{$position}_upload_font_fallback" );
                if ( 'serif' != $fallback ) $fallback = 'sans-serif';

                if ( ! $font ) {
                    $pathinfo = pathinfo( $font_file );
                    $font = sanitize_title_with_dashes ( $pathinfo[ 'filename' ] );
                }
                
                $font_face_rules .= "@font-face {font-family: {$font}; src: url({$font_file});}";
                $font = $font . ", {$fallback}";
            }
        
        }
        
        $font_assigns[ $position ] = $font;
        
    }
    
    return array(
        'assigns' => $font_assigns,
        'rules' => $font_face_rules,
    );
    
}
endif;

add_action( 'wp_enqueue_scripts', 'dine_customizer_style', 20 );
if ( ! function_exists( 'dine_customizer_style' ) ) :
/**
 * Prints inline style from Customizer
 *
 * @since 1.0
 */
function dine_customizer_style() {
    
    $unit_arr = dine_unit_array();
    $style_arr = array();
    $media_query_arr = array();
    $css = '';
    
    $google_fonts = dine_google_fonts();
    
    $font_assigns = array();
    $font_positions = array(
        'body' => 'Open Sans', 
        'heading' => 'Oswald',
    );
    
    $options = dine_css_options();
    $defaults = array(
        'selector'  => '',
        'property'  => '',
        'unit'      => '',
        'conditional' => null,
        'screen'    => '',
        'max_screen'=> '',
    );
    
    /* Font Assigns
    --------------------- */
    $font_assignment = dine_font_assignment();
    
    $font_assigns = $font_assignment[ 'assigns' ];
    $css .= $font_assignment[ 'rules' ];
    
    /* Normal Options
    --------------------- */
    foreach ( $options as $id => $css_arr ) : 
    
    if ( is_numeric( $id ) ) continue;
    
    // array detect
    if ( isset( $css_arr[ 'property' ] ) ) {
        $css_arr = array( $css_arr );
    }
    
    foreach ( $css_arr as $option ) :
    
    extract( wp_parse_args( $option, $defaults ) );
    
    // Conditional CSS
    if ( is_callable( $conditional ) && ! call_user_func( $conditional ) ) continue;
    
    if ( in_array( $property, $unit_arr ) && '' == $unit )
        $unit = 'px';
    
    // just a convenstion
    // id with custom at its tag has been processed
    // adjust value accordingly
    $value = null;
    
    if ( null === $value ) $value = trim( get_option( $id ) );
    
    if ( '' === $value ) continue;
    
    if ( ! $selector || ! $property ) continue;
    if ( '' != $unit && is_numeric( $value ) ) {
        $value .= $unit;
    }
    if ( 'background-image' == $property ) {
        $value = "url({$value})";
    }
    
    if ( 'content' == $property ) {
        $value = str_replace( '"', '', $value );
        $value = str_replace( "'", '', $value );
        $value = '"' . $value . '"';
    }
    
    // font replacement
    if ( 'font-family' == $property ) {
        
        if ( isset( $google_fonts[ $value ] ) ) {
            $cat = $google_fonts[ $value ][ 'category' ];
            if ( 'handwriting' == $cat || 'display' == $cat ) {
                $fallback = 'cursive';
            } else {
                $fallback = $cat;
            }
            $value = '"' . $value . '",' . $fallback;
        }
        
    }
    
    // css3
    $properties = array( $property );
    switch( $property ) {
        case 'background-size':
            $properties = array( '-webkit-background-size', 'background-size' );
        break;
        case 'transition':
            $properties = array( '-webkit-transition', 'transition' );
        break;
        case 'transform':
            $properties = array( '-webkit-transform', 'transform' );
        break;
        default:
        break;
    }
    
    // screen
    $query = 'all';
    if ( $screen && $max_screen ) {
        $query = "@media only screen and (min-width: {$screen}) and (max-width: {$max_screen})";
    } elseif ( $screen ) {
        $query = "@media only screen and (min-width: {$screen})";
    } elseif ( $max_screen ) {
        $query = "@media only screen and (max-width: {$max_screen})";
    }
    
    if ( ! isset( $media_query_arr[ $query ] ) ) {
        $media_query_arr[ $query ] = array();
    }
    if ( ! isset( $media_query_arr[ $query ][ $selector ] ) ) {
        $media_query_arr[ $query ][ $selector ] = array();
    }
    
    foreach ( $properties as $property ) {
        $media_query_arr[ $query ][ $selector ][] = "{$property}:{$value}";
    }
    
    endforeach; // foreach $css_arr
    
    endforeach; // foreach $option
    
    /* Join CSS pieces
    --------------------- */
    foreach ( $media_query_arr as $query => $style_arr ) {
        
        if ( 'all' === $query ) {
            $open = $close = '';
        } else {
            $open = "{$query} {";
            $close = "}";
        }
        
        $css .= $open;
        
        foreach ( $style_arr as $selector => $pairs ) {
            $inside = join( ';', $pairs );
            $css .= "{$selector}{{$inside}}";
        }
        
        $css .= $close;
        
    }
    
    /* Complicated Options
    --------------------- */
    // content width
    $container = absint( get_option( 'dine_container_width' ) );
    if ( $container > 0 ) {
        $css .= '@media only screen and (min-width: 1280px) {.container{width:' . $container . 'px;}'; // only laptop screen
    }
    
    /**
     * Hook to append CSS
     */
    $css = apply_filters( 'dine_css', $css );

    // attach it to <head />
    if ( ! wp_add_inline_style( 'dine-framework', $css ) ) {
        wp_add_inline_style( 'dine-style', $css );
    }

}
endif;

if ( ! function_exists( 'dine_css_properties' ) ) :
/**
 * Returns array of css properties may we'll need to check it
 *
 * @since 1.0
 *
 * @return array of css properties 
 */
function dine_css_properties() {

    return array( 'color', 'background', 'background-color', 'background-image', 'background-position', 'background-size', 'background-repeat', 'background-attachment', 'border', 'border-style', 'border-color', 'border-width', 'border-radius', 'margin', 'padding', 'width', 'height', 'font-size', 'font-family', 'font-weight', 'font-style', 'text-transform', 'letter-spacing', 'text-decoration', 'text-align', 'line-height', 'box-shadow', 'opacity', 'transition', 'content', 'top', 'right', 'bottom', 'left' );
    
}
endif;

if ( ! function_exists( 'dine_unit_array' ) ) :
/**
 * Returns array of css properties having px as default unit
 *
 * @since 1.0
 */
function dine_unit_array() {
    
    return array( 'font-size', 'background-size', 'border-width', 'border-radius', 'border-top-right-radius', 'border-top-left-radius', 'border-bottom-right-radius', 'border-bottom-left-radius', 'margin', 'margin-top', 'margin-right','margin-bottom', 'margin-left', 'padding', 'padding-top', 'padding-right', 'padding-bottom', 'padding-left', 'width', 'height', 'letter-spacing' );
    
}
endif;

if ( ! function_exists( 'dine_css_options' ) ) :
/**
 * Lists of css properties
 *
 * We'll render this function by tool 
 * so plz do not edit this function in your child theme
 *
 * @since 1.0
 */
function dine_css_options() {
    
    include get_template_directory() . '/inc/customizer/css-options.php';
    include get_template_directory() . '/inc/customizer/toggles.php';
    
    // list of elements will be ignored by toggle conditional
    $ignores = array();
    
    $options = array();
    
    foreach ( $toggles as $id => $option ) {
        
        $toggle = $option[ 'toggle' ];
        $choices = $option[ 'options' ];
        
        $real_value = get_option( $id );
        if ( '' == $real_value && isset( $option[ 'std' ] ) ) $real_value = $option[ 'std' ];
        
        $not_exclude = array();
        if ( isset( $toggle[ $real_value ] ) ) {
            $not_exclude = $toggle[ $real_value ];
            if ( is_string( $not_exclude ) ) $not_exclude = array( $not_exclude );
        }

        foreach ( $toggle as $val => $dependent_elements ) {

            // don't care about real value
            if ( $val === $real_value ) continue;

            if ( is_string( $dependent_elements ) ) $dependent_elements = array( $dependent_elements );
            foreach ( $dependent_elements as $dependent_element ) {

                // not intersect with the real value
                if ( ! in_array( $dependent_element, $not_exclude ) ) {
                    $ignores[] = $dependent_element;
                }

            }
        }
    
    }
    
    foreach ( $reg_options as $id => $option ) {
        
        if ( in_array( $id, $ignores ) ) continue;
        
        $options[ $id ] = $option;
    }
    
    return $options;
    
}
endif;

/**
 * Singular CSS
 *
 * @since 1.0
 */
add_action( 'wp_head', 'dine_page_css', 1000 );
if ( ! function_exists( 'dine_page_css' ) ):
/**
 * Page CSS based on metaboxes
 *
 * @since 1.0
 */
function dine_page_css() {
    
    $postid = null;
    $postid = dine_pageid();
    
    if ( ! $postid ) return;
    
    $options = array(
        'padding_top' => array(
            'property' => 'padding-top',
            'selector' => 'body #page-wrapper #primary, body #page-wrapper #secondary',
            'unit' => 'px',
        ),
        'padding_bottom' => array(
            'property' => 'padding-bottom',
            'selector' => 'body #page-wrapper #primary, body #page-wrapper #secondary',
            'unit' => 'px',
        ),
    );
    ?>
<style>
    
    <?php foreach ( $options as $id => $option ) : 
    extract( wp_parse_args( $option, array(
        'property' => '',
        'selector' => '',
        'unit' => '',
    ) ) );
    
    $value = trim ( get_post_meta( $postid, '_dine_' . $id, true ) ) ;
    if ( '' != $value ) {
    
        if ( $unit && is_numeric( $value ) ) 
            $value .= $unit;
        
        echo "{$selector}{{$property}:{$value};}";
    
    }
    endforeach; ?>

</style>

<?php
}
endif;