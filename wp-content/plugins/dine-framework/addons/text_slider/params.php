<?php
$params[] = array(
    'type' => 'textfield',
    'param_name' => 'timer',
    'heading' => esc_html__( 'Autoplay Timer?' , 'dine' ),
    'value' => '3000',
    'description'   => 'Enter number of milliseconds between 2 slides. Note that 1s = 1000ms.',
);

$params[] = array(
    'type' => 'colorpicker',
    'param_name' => 'color',
    'heading' => esc_html__( 'Text Color' , 'dine' ),
);

$params[] = array(
    'type' => 'textfield',
    'param_name' => 'size',
    'value' => '120px',
    'heading' => esc_html__( 'Font Size' , 'dine' ),
);

$params[] = array(
    'type' => 'dropdown',
    'param_name' => 'effect',
    'heading' => esc_html__( 'Effect?' , 'dine' ),
    'value' => array(
        'Rotate 2' => 'rotate-2',
        'Rotate 3' => 'rotate-3',
        'Type' => 'type',
        'Slide' => 'slide',
        'Zoom' => 'zoom',
        'Scale' => 'scale',
    ),
    'std'       => 'rotate-3',
);

$params[] = array(
    'type' => 'exploded_textarea',
    'param_name' => 'text',
    'heading' => esc_html__( 'Text' , 'dine' ),
    'description' => esc_html__( 'Each sentence per line. Press "enter" to have a new line.' , 'dine' ),
    'admin_label' => true,
    'value' => 'Dine with us,Always ready,Loved by people',
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

// DESIGN OPTIONS
//
$params[] = array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'Css', 'dine' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'dine' ),
);