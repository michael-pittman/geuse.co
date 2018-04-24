<?php
$params[] = array(
    'type' => 'textfield',
    'heading' => 'Button Text',
    'value' => 'Click Me',
    'param_name' => 'text',
    'admin_label' => true,
);

$params[] = array (
    'type' => 'iconpicker',
    'heading' => 'Select Icon',
    'param_name' => 'icon',
    'description' => 'Select icon',
    'settings' => array(
        'emptyIcon' => true, // default true, display an "EMPTY" icon?
        'type' => 'fontawesome',
    ),
);

$params[] = array(
    'type' => 'vc_link',
    'heading' => 'Button Link',
    'param_name' => 'link',
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Button Style',
    'param_name' => 'style',
    'value' => array(
        'Primary' => 'primary',
        'Outline' => 'outline',
        'Fill' => 'fill',
    ),
    'std' => 'primary',
    'admin_label' => true,
);
  
$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Button Align',
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

$params[] = array (
    'type' => 'textarea',
    'heading' => 'Onclick Attribute',
    'description' => 'Use this option if you have a custom code for your click event.',
    'param_name' => 'onclick',
);

// CUSTOM BUTTON
//
$params[] = array(
    'type' => 'colorpicker',
    'heading' => 'Button Text Color',
    'param_name' => 'color',
    
    'dependency' => array(
        'element' => 'style',
        'value' => array( 'primary', 'outline', 'fill' ),
    ),
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Button Background',
    'param_name' => 'background',
    
    'dependency' => array(
        'element' => 'style',
        'value' => 'primary',
    ),
    
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Hover Color',
    'param_name' => 'hover_color',
    
    'preview' => array(
        'selector' => '.dine-btn:hover',
        'property' => 'color',
    ),
    
    'dependency' => array(
        'element' => 'style',
        'value' => array( 'primary', 'outline', 'fill' ),
    ),
    
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Hover Background',
    'param_name' => 'hover_background',
    
    'dependency' => array(
        'element' => 'style',
        'value' => array( 'primary', 'fill' ),
    ),
    
    'group' => 'Button Design',
);