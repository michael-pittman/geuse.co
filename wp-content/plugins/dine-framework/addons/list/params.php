<?php
$params[] = array(
    'type' => 'textarea_html',
    'heading' => 'Enter the list',
    'param_name' => 'content',
    'value' => '<ul><li>Your item 1</li><li>Your item 2</li><li>Your item 3</li></ul>',
    'admin_label' => true,
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Color',
    'param_name' => 'color',
    'group' => esc_html__( 'Color', 'dine' ),
);

// DESIGN OPTIONS
//
$params[] = array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'Css', 'dine' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'dine' ),
);