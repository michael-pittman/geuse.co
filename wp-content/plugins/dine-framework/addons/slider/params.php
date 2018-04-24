<?php
$params[] = array(
    'type' => 'attach_images',
    'heading' => 'Upload images',
    'param_name' => 'images',
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Slider style?',
    'param_name' => 'style',
    'value' => array (
        'Auto' => 'auto',
        'Fullscreen' => 'fullheight',
        'Carousel' => 'carousel',
        'Fullscreen Carousel' => 'fullheight_carousel',
    ),
    'std' => 'auto',
);

$params[] = array(
    'type' => 'checkbox',
    'heading' => 'Slideshow Autoplay?',
    'param_name' => 'autoplay',
    'value' => array (
        'Enable' => 'true',
    ),
    'std' => '',
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Time between 2 slides?',
    'param_name' => 'autoplay_timer',
    'value' => array (
        '1s' => '1000',
        '2s' => '2000',
        '3s' => '3000',
        '4s' => '4000',
        '5s' => '5000',
        '6s' => '6000',
        '7s' => '7000',
        '8s' => '8000',
        '9s' => '9000',
        '10s' => '10000',
    ),
    'std' => '4000',
    'dependency' => array(
        'element' => 'autoplay',
        'value' => 'true',
    ),
);

$params[] = array(
    'type' => 'checkbox',
    'heading' => 'Next/Previous Control?',
    'param_name' => 'arrows',
    'value' => array (
        'Enable' => 'true',
    ),
    'std' => 'true',
);

$params[] = array(
    'type' => 'checkbox',
    'heading' => 'Bullets?',
    'param_name' => 'bullets',
    'value' => array (
        'Enable' => 'true',
    ),
    'std'   => '',
);

$params[] = array(
    'type' => 'checkbox',
    'heading' => 'Use image\'s title/description for slider text?',
    'param_name' => 'caption',
    'value' => array (
        'Yes' => 'true',
    ),
    'std'   => '',
);

// DESIGN OPTIONS
//
$params[] = array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'Css', 'dine' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'dine' ),
);