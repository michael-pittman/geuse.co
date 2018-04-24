<?php
$params[] = array(
    'type' => 'textfield',
    'heading' => 'Enter the text',
    'param_name' => 'text',
    'value' => 'About',
    'description' => 'Please keep it short, less than 8 characters',
    'admin_label' => true,
);

$params[] = array(
    'type' => 'colorpicker',
    'heading' => 'Text Color',
    'param_name' => 'color',
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Rotate',
    'param_name' => 'rotate',
    'value' => '-45',
    'description' => 'Enter the angle you want your text to be rotated.',
);

$params[] = array(
    'type' => 'vc_link',
    'heading' => 'Link',
    'param_name' => 'link',
);

// DESIGN OPTIONS
//
$params[] = array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'Css', 'dine' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'dine' ),
);