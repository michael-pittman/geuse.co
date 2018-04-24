<?php
$params[] = array (
    'type' => 'iconpicker',
    'heading' => 'Icon',
    'param_name' => 'icon',
    'description' => 'Select icon',
    'value' => 'fa fa-angle-down', // default value to backend editor admin_label
    'settings' => array(
        'emptyIcon' => false, // default true, display an "EMPTY" icon?
        'type' => 'fontawesome',
    ),
    'admin_label' => true,
);

$params[] = array(
    'type' => 'vc_link',
    'heading' => 'Icon Link',
    'param_name' => 'link',
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Icon title',
    'param_name' => 'title',
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Icon color',
    'param_name' => 'color',
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Hover color',
    'param_name' => 'hover_color',
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Hover background',
    'param_name' => 'hover_background',
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Icon Size',
    'param_name' => 'size',
    'value' => array(
        '24px' => '24',
        '28px' => '28',
        '32px' => '32',
        '36px' => '36',
        '40px' => '40',
        '44px' => '44',
    ),
    'std' => '24',
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Icon Align',
    'param_name' => 'align',
    'value' => array(
        'Inline'=> 'inline',
        'Left' => 'left',
        'Center' => 'center',
        'Right' => 'right',
    ),
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