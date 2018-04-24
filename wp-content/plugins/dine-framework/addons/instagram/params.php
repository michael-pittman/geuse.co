<?php

// Instagram
$params[] = array(
    'type' => 'textfield',
    'heading' => 'Instagram Username',
    'param_name' => 'username',
    'admin_label' => true,
);

$instagram_numbers = array();
for ( $i = 1; $i<=12; $i++ ) : 
$instagram_numbers[ $i . ' photos' ] = strval( $i );
endfor;

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Number of photos',
    'param_name' => 'number',
    'value'     => $instagram_numbers,
    'std'       => '6',
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Cache Time',
    'param_name' => 'cache_time',
    'value' => array(
        esc_html__( 'Half Hours', 'dine' ) => (string) ( HOUR_IN_SECONDS/ 2 ),
        esc_html__( 'An Hour', 'dine' ) => (string) ( HOUR_IN_SECONDS ),
        esc_html__( 'Two Hours', 'dine' ) => (string) ( HOUR_IN_SECONDS * 2 ),
        esc_html__( 'Four Hours', 'dine' ) => (string) ( HOUR_IN_SECONDS * 4 ),
        esc_html__( 'A Day', 'dine' ) => (string) ( DAY_IN_SECONDS ),
        esc_html__( 'A Week', 'dine' ) => (string) ( WEEK_IN_SECONDS ),
    ),
    'std' => (string) ( HOUR_IN_SECONDS * 2 ),
);

$params[] = array(
    'type' => 'checkbox',
    'heading' => 'Show Instagram Meta (likes, comments)',
    'param_name' => 'instagram_meta',
    'value' => array(
        'Enable' => 'true',
    ),
    'std' => '',
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Column?',
    'param_name' => 'column',
    'value' => array(
        '1-Column' => '1',
        '2-Column' => '2',
        '3-Column' => '3',
        '4-Column' => '4',
        '5-Column' => '5',
        '6-Column' => '6',
        '7-Column' => '7',
        '8-Column' => '8',
        '9-Column' => '9',
        '10-Column' => '10',
    ),
    'std' => '3',
);

// DESIGN OPTIONS
//
$params[] = array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'Css', 'dine' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'dine' ),
);