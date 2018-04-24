<?php
$params[] = array(
    'type' => 'attach_images',
    'heading' => 'Upload images',
    'param_name' => 'images',
);

$params[] = array (
    'type' => 'checkbox',
    'heading' => 'Lightbox',
    'param_name' => 'lightbox',
    'value' => array( 
        'Enable' => 'true',
    ),
    'std' => 'true',
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Layout',
    'param_name' => 'layout',
    'value' => array(
        'Grid' => 'grid',
        'Metro' => 'metro',
    ),
    'std' => 'grid',
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Column?',
    'param_name' => 'column',
    'value' => array(
        '2-Column' => '2',
        '3-Column' => '3',
        '4-Column' => '4',
        '5-Column' => '5',
        '6-Column' => '6',
    ),
    'std' => '3',
    'dependency' => array(
        'element' => 'layout',
        'value' => 'grid',
    ),
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Grid Image Ratio',
    'param_name' => 'ratio',
    'value' => array(
        'Landscape' => 'landscape',
        'Square' => 'square',
        'Portrait' => 'portrait',
        'Auto' => 'auto',
    ),
    'std' => 'landscape',
    'dependency' => array(
        'element' => 'layout',
        'value' => 'grid',
    ),
);

$params[] = array (
    'type' => 'checkbox',
    'heading' => 'Image Caption?',
    'param_name' => 'caption',
    'value' => array( 
        'Enable' => 'true',
    ),
    'std' => '',
);

// DESIGN OPTIONS
//
$params[] = array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'Css', 'dine' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'dine' ),
);