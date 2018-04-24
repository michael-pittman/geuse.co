<?php
$params[] = array(
    'type' => 'textfield',
    'param_name' => 'title',
    'heading' => esc_html__( 'Title' , 'dine' ),
    'value' => 'Make a Reservation',
    'admin_label' => true,
);

$params[] = array(
    'type' => 'textfield',
    'param_name' => 'id',
    'heading' => esc_html__( 'Restaurant ID' , 'dine' ),
    'description' => 'Open Table provides you this ID.',
    'admin_label' => true,
);