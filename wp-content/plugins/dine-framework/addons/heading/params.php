<?php
$params[] = array(
    'type' => 'textfield',
    'heading' => 'Title',
    'param_name' => 'title',
    'value' => 'Your Heading',
    'admin_label' => true,
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Tag',
    'value' => array(
        'H1' => 'h1',
        'H2' => 'h2',
        'H3' => 'h3',
        'H4' => 'h4',
        'H5' => 'h5',
        'H6' => 'h6',
    ),
    'std'   => 'h2',
    'param_name' => 'tag',
);

$params[] = array (
    'type' => 'textfield',
    'heading' => 'Subtitle',
    'param_name' => 'subtitle',
);

// DESIGN OPTIONS
//
$params[] = array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'Css', 'dine' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'dine' ),
);