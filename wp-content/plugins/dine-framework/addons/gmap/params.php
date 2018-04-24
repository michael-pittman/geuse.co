<?php
$params[] = array(
    'type' => 'textarea',
    'heading' => 'Address',
    'param_name' => 'address',
    'value' => '145 Brooklyn Ave, Brooklyn, NY 11213',
    'admin_label' => true,
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Map Height',
    'value'     => '320',
    'description' => 'Enter an integer, eg. 400',
    'param_name' => 'height',
);

$zoom_levels = array();
for ( $i = 0; $i <= 19; $i ++ ) {
    $zoom_levels[ (string) $i ] = (string) $i;
}

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Map Type',
    'param_name' => 'map_type',
    'value' => array(
        'ROADMAP' => 'ROADMAP',
        'SATELLITE' => 'SATELLITE',
        'HYBRID' => 'HYBRID',
        'TERRAIN' => 'TERRAIN',
    ),
    'std' => 'ROADMAP',
);

$params[] = array(
    'type' => 'checkbox',
    'heading' => 'Controls',
    'param_name' => 'controls',
    'value' => array(
        'Zoom' => 'zoomControl',
        'Map Type' => 'mapTypeControl',
        'Scale' => 'scaleControl',
        'Street View' => 'streetViewControl',
        'Rotate Control' => 'rotateControl',
        'Full Screen Control' => 'fullscreenControl',
    ),
    'std' => '',
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Zoom Level',
    'param_name' => 'zoom',
    'value' => $zoom_levels,
    'std' => '16',
);

$params[] = array(
    'type' => 'checkbox',
    'heading' => 'Scrollwheel',
    'param_name' => 'scrollwheel',
    'value' => array( '' => 'true' ),
    'std' => '',
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Map Style',
    'param_name' => 'style',
    'value' => array(
        'Light' => 'light',
        'Dark' => 'dark',
        'Light Blue' => 'light-grey-blue',
        'None' => 'none',
    ),
    'std' => 'light',
);

$params[] = array(
    'type' => 'attach_image',
    'heading' => 'Marker Image',
    'param_name' => 'marker',
    'description' => 'Optimal size is 40x40. You should upload a png transparent image.',
);

// DESIGN OPTIONS
//
$params[] = array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'Css', 'dine' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'dine' ),
);