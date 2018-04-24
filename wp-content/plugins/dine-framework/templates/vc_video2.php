<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $link
 * @var $el_class
 * @var $css
 * @var $css_animation
 * @var $el_width
 * @var $el_aspect
 * @var $align
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Video
 */
$title = $link = $el_class = $css = $css_animation = $el_width = $el_aspect = $align = $thumbnail = $video_thumbnail = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( '' === $link ) {
	return null;
}
$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

$video_w = 500;
$video_h = $video_w / 1.61; //1.61 golden ratio
/** @var WP_Embed $wp_embed */
global $wp_embed;
$embed = '';
if ( is_object( $wp_embed ) ) {
	$embed = $wp_embed->run_shortcode( '[embed width="' . $video_w . '"' . $video_h . ']' . $link . '[/embed]' );
}
$el_classes = array(
	'wpb_video_widget',
	'wpb_content_element',
	'vc_clearfix',
	$el_class,
	vc_shortcode_custom_css_class( $css, ' ' ),
	'vc_video-aspect-ratio-' . esc_attr( $el_aspect ),
	'vc_video-el-width-' . esc_attr( $el_width ),
	'vc_video-align-' . esc_attr( $align ),
);

// Added by withemes
// Attrs
$attrs = array();
$output = '';
$thumb = '';
if ( 'video' == $thumbnail && function_exists( 'dine_get_video_thumbnail' ) ) {
    $thumb = dine_get_video_thumbnail( $link );
} elseif ( 'upload' == $thumbnail && $video_thumbnail ) {
    $thumb = wp_get_attachment_url( $video_thumbnail );
}
$case = '';
if (strpos($link, 'youtube') > 0 || strpos($link, 'youtu.be') > 0) {
    $case = 'youtube';
} elseif (strpos($link, 'vimeo') > 0) {
    $case = 'vimeo';
}
if ( $thumb && $case == 'youtube' || $case == 'vimeo' ) {
    $output = '<div class="video-thumb" style="background-image:url(' . esc_url( $thumb ) . ')"></div><button class="video-play-btn"><i class="fa fa-play"></i></button>';
    $attrs[] = 'data-html="' . esc_attr( $embed ). '"';
    $attrs[] = 'data-video-type="' . esc_attr( $case ). '"';
    $el_classes[] = 'video-has-thumbnail';
} else {
    $output = $embed;
}
$attrs = join( ' ', $attrs );
// End added by withemes

$css_class = implode( ' ', $el_classes );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->getShortcode(), $atts );

$output = '
	<div class="' . esc_attr( $css_class ) . '" ' . $attrs . '>
		<div class="wpb_wrapper">
			' . wpb_widget_title( array(
		'title' => $title,
		'extraclass' => 'wpb_video_heading',
	) ) . '
			<div class="wpb_video_wrapper">' . $output . '</div>
		</div>
	</div>
';

echo $output;
