<?php
$params[] =  array (
    'type'      => 'colorpicker',
    'heading'   => 'Background',
    'param_name'=> 'background',
);

$params[] =  array (
    'type'      => 'colorpicker',
    'heading'   => 'Text Color',
    'param_name'=> 'color',
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Animation',
    'param_name' => 'animation',
    'value' => array(
        'None' => '',
        'Top' => 'top',
        'Bottom' => 'bottom',
        'Left' => 'left',
        'Right' => 'right',
        'Fade' => 'fade',
    ),
    'std' => '',
);

$params[] = array (
    'type' => 'textfield',
    'heading' => 'Animation Delay',
    'param_name' => 'delay',
    'description' => 'Enter number of milliseconds to delay. Note that 1s = 1000ms.',
    'value' => '',
    'dependency' => array(
        'element' => 'animation',
        'value' => array( 'top', 'bottom', 'left', 'right', 'fade' ),
    ),
);

$params[] =  array (
    'type'      => 'textarea_html',
    'heading'   => 'Content',
    'param_name'=> 'content',
    'admin_label' => true,
);

// DESIGN OPTIONS
//
$params[] = array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'Css', 'dine' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'dine' ),
);