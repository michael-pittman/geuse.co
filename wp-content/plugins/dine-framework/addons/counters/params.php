<?php

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Column?',
    'param_name' => 'column',
    'value' => array(
        '2 columns' => '2',
        '3 columns' => '3',
        '4 columns' => '4',
        '5 columns' => '5',
        '6 columns' => '6',
    ),
    'std' => '4',
    'admin_label' => true,
);

$params[] = array(
    'type' => 'param_group',
    'heading' => esc_html__( 'Counter Items', 'dine' ),
    'param_name' => 'items',
    'description' => esc_html__( 'Enter value for each counter item', 'dine' ),
    'params' => array(
        
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Number','dine' ),
            'param_name' => 'number',
            'heading' => esc_html__( 'Accept only whole numbers like 25, 1972..','dine' ),
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Title','dine' ),
            'param_name' => 'title',
            'admin_label' => true,
        ),
        
        array(
            'type' => 'textarea',
            'heading' => esc_html__( 'Description','dine' ),
            'param_name' => 'desc',
        ),

    ),
    
    'value' => json_encode( array(
        array(
            'title' => 'Cooks',
            'desc' => 'Anonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
            'number' => '26',
        ),
        array(
            'title' => 'Restaurants',
            'desc' => 'Anonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
            'number' => '191',
        ),
        array(
            'title' => 'Since',
            'desc' => 'Anonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
            'number' => '1896',
        ),
        array(
            'title' => 'Rated /100',
            'desc' => 'Anonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.',
            'number' => '92',
        ),
    ) ),
    
);