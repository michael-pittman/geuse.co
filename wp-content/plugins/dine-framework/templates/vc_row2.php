<?php
/**
 * Customized VC Row by Dine theme to improve parallax & video background
 *
 * @since 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Params with indentation below are dropped
 *
 * They'll be replaced by Dine Parallax & Video Background
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
        * @var $parallax
        * @var $parallax_image
 * @var $css
 * @var $el_id
        * @var $video_bg
        * @var $video_bg_url
        * @var $video_bg_parallax
        * @var $parallax_speed_bg
        * @var $parallax_speed_video
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 
 * Params added by Dine
 * $parallax
 * $parallax_speed
 * $video_type
 * $video_url
 * $mp4
 * $webm
 * $overlay (background)
 */
$el_class = $full_height = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $css = $el_id = $parallax = $parallax_speed = $video_type = $video_url = $mp4 = $webm = $overlay = $css_animation = '';
$disable_element = '';
$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

$css_classes = array(
	'vc_row',
	'wpb_row', //deprecated
	'vc_row-fluid',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') ) || ( 'none' != $video_type ) ) {
	$css_classes[]='vc_row-has-fill';
}

if (!empty($atts['gap'])) {
	$css_classes[] = 'vc_column-gap-'.$atts['gap'];
}

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
	} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
		$css_classes[] = 'vc_row-no-padding';
	}
	$after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = 'vc_row-o-full-height';
	if ( ! empty( $columns_placement ) ) {
		$flex_row = true;
		$css_classes[] = 'vc_row-o-columns-' . $columns_placement;
		if ( 'stretch' === $columns_placement ) {
			$css_classes[] = 'vc_row-o-equal-height';
		}
	}
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = 'vc_row-flex';
}

$has_parallax = false;
if ( ( 'youtube' == $video_type || 'vimeo' == $video_type ) && $video_url ) {
    $has_parallax = true;
    $wrapper_attributes[] = "data-jarallax-video='" . $video_url . "'";
    
} elseif ( 'local' == $video_type && ( $mp4 || $webm ) ) {
    
    $has_parallax = true;
    $video_attr = array();
    if ( $mp4 ) {
        $video_attr[] = 'mp4:' . $mp4;
    }
    if ( $webm ) {
        $video_attr[] = 'webm:' . $webm;
    }
    $video_attr = join( ',', $video_attr );

    $wrapper_attributes[] = "data-jarallax-video='" . $video_attr . "'";
    
} elseif ( 'true' == $parallax ) {
    
    $has_parallax = true;
}

if ( $has_parallax ) {
    
    $css_classes[] = 'jarallax';
    
    $parallax_speed = floatval($parallax_speed);
    if ( $parallax_speed < 0 || $parallax_speed > 1 ) $parallax_speed = 0.7;
    
    $jarallax_args = array(
        'speed' => $parallax_speed,
    );
    $wrapper_attributes[] = "data-jarallax='" . json_encode( $jarallax_args ). "'";
}

// OVERLAY
$output_output = '';
if ( $overlay ) {
    $output_output = '<div class="row-overlay" style="background:' . $overlay . ';"></div>';
}

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= wpb_js_remove_wpautop( $content );
$output .= $output_output;
$output .= '</div>';
$output .= $after_output;

echo $output;