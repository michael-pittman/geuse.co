<?php
// Icon Type
$params[] =  array (
    'type'      => 'dropdown',
    'heading'   => 'Icon type',
    'param_name'=> 'icon_type',
    'value'     => array(
        'Icon'  => 'icon',
        'Image' => 'image',
    ),
    'std'   => 'icon',
);

$params[] = array(
    'type' => 'attach_image',
    'heading' => 'Upload your image',
    'param_name' => 'image',
    'dependency' => array(
        'element' => 'icon_type',
        'value' => 'image',
    ),
);

$params[] =  array (
    'type'      => 'textfield',
    'heading'   => 'Image Width',
    'param_name'=> 'image_width',
    'dependency'     => array(
        'element'  => 'icon_type',
        'value' => 'image',
    ),
    'value'   => '50',
    'description' => 'Enter a number. Default is 50px',
);
    
$params[] = array (
    'type' => 'iconpicker',
    'heading' => 'Select Icon',
    'param_name' => 'icon',
    'description' => 'Select icon',
    'value' => 'fa fa-star', // default value to backend editor admin_label
    'settings' => array(
        'emptyIcon' => false, // default true, display an "EMPTY" icon?
        'type' => 'fontawesome',
    ),
    
    'dependency'     => array(
        'element'  => 'icon_type',
        'value' => 'icon',
    ),
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Divider Color',
    'param_name' => 'color',
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Line Thickness',
    'param_name' => 'thickness',
    'value' => array(
        '1px' => '1px',
        '2px' => '2px',
        '3px' => '3px',
        '4px' => '4px',
        '5px' => '5px',
        '6px' => '6px',
    ),
    'std' => '1px',
);

$params[] = array (
    'type' => 'checkbox',
    'heading' => 'Animation',
    'param_name' => 'animation',
    'value' => array(
        'Enable' => 'true',
    ),
    'std'   => '',
);

$params[] = array (
    'type' => 'textfield',
    'heading' => 'Animation Delay',
    'param_name' => 'delay',
    'description' => 'Enter number of milliseconds to delay. Note that 1s = 1000ms.',
    'value' => '',
    'dependency' => array(
        'element' => 'animation',
        'value' => 'true',
    ),
);

// DESIGN OPTIONS
//
$params[] = array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'Css', 'dine' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'dine' ),
);