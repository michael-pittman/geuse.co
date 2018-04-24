<?php
$params[] = array(
    'type' => 'textfield',
    'param_name' => 'title',
    'heading' => esc_html__( 'Heading' , 'dine' ),
    'value' => 'Dinner',
    'admin_label' => true,
);

$params[] = array(
    'type' => 'param_group',
    'heading' => esc_html__( 'Menu Items', 'dine' ),
    'param_name' => 'items',
    'description' => esc_html__( 'Enter value for each menu item', 'dine' ),
    'params' => array(

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Name','dine' ),
            'param_name' => 'name',
            'admin_label' => true,
        ),
        
        array(
            'type' => 'textarea',
            'heading' => esc_html__( 'Description','dine' ),
            'param_name' => 'desc',
        ),
        
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Price','dine' ),
            'param_name' => 'price',
        ),
        
        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Image','dine' ),
            'param_name' => 'image',
        ),
        
        array(
            'type' => 'checkbox',
            'value' => array( 'Yes' => 'true' ),
            'heading' => esc_html__( 'Highlight this','dine' ),
            'param_name' => 'highlight',
        ),

    ),
    
    'value' => json_encode( array(
        array(
            'name' => 'Calamari Fra Diavolo',
            'desc' => 'Our Fried Calamari Sauteed with Hot & Sweet Vinegar Peppers in Our Marinara Sauce',
            'price' => '$11.95',
        ),
        array(
            'name' => 'Mussels or Clams Italiano',
            'desc' => 'New Zealand Mussels or Little Neck Clams Served in a Garlic Wine Broth or Plum Tomato Sauce',
            'price' => '$10.95',
        ),
        array(
            'name' => 'Fried Zucchini',
            'desc' => 'Lightly Breaded and Fried',
            'price' => '$7.95',
        ),
        array(
            'name' => 'Eggplant Rollantine',
            'desc' => 'Rolled with Ricotta and Lightly Baked with Marinara and Mozzarella',
            'price' => '$9.95',
        ),
    ) ),
    
);