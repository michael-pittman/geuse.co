<?php
$params[] = array(
    'type' => 'attach_image',
    'heading' => 'Upload your image',
    'param_name' => 'image',
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Title',
    'param_name' => 'title',
    'value' => 'Open 24/24',
    'admin_label' => true,
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Title Weight',
    'param_name' => 'title_weight',
    'value' => array(
        'Default' => '',
        'Bold' => '700',
        'Normal' => '400',
        'Thin' => '300',
    ),
    'std' => '',
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Subtitle',
    'param_name' => 'subtitle',
    'value' => 'Since 1892',
    'admin_label' => true,
);

$params[] = array(
    'type' => 'vc_link',
    'heading' => 'Link',
    'param_name' => 'link',
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Box Ratio',
    'param_name' => 'ratio',
    'value' => '2:1',
);

$params[] = array(
    'type' => 'colorpicker',
    'heading' => 'Overlay Color',
    'param_name' => 'overlay',
    'value' => 'rgba(0,0,0,.3)',
);

$params[] = array(
    'type' => 'colorpicker',
    'heading' => 'Text Color',
    'param_name' => 'text_color',
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

// DESIGN OPTIONS
//
$params[] = array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'Css', 'dine' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'dine' ),
);