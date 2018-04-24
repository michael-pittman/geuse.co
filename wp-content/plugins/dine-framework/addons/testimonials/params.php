<?php
$params[] = array(
    'type' => 'param_group',
    'heading' => esc_html__( 'Testimonials', 'dine' ),
    'param_name' => 'testimonials',
    'description' => esc_html__( 'Enter value for each testimonial', 'dine' ),
    'params' => array(

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Name','dine' ),
            'param_name' => 'name',
            'admin_label' => true,
        ),
        
        array(
            'type' => 'textarea',
            'heading' => esc_html__( 'Content','dine' ),
            'param_name' => 'text',
        ),
        
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'From','dine' ),
            'param_name' => 'from',
        ),
        
        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Avatar','dine' ),
            'param_name' => 'avatar',
        ),
        
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Rating','dine' ),
            'description' => esc_html__( 'A number between 0 - 5, eg. 4.8','dine' ),
            'param_name' => 'rating',
        ),

    ),
    
    'value' => json_encode( array(
        array(
            'name' => 'Bob Lumithon',
            'from' => 'United States',
            'text' => 'Your theme is very easy to customize and absolutely perfect for any restaurant! I love it so so much! Thank you for such a masterpiece!',
            'rating' => '5.0',
        ),
        array(
            'name' => 'Alex',
            'from' => 'United Kingdom',
            'text' => 'Anonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation',
            'rating' => '4.8',
        ),
        array(
            'name' => 'Rose Limon',
            'from' => 'France',
            'text' => 'Rullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputat',
        ),
    ) ),
);