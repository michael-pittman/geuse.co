<?php
$fields = array(
    
    array(
        'id' => 'title',
        'type' => 'text',
        'name' => esc_html__( 'Title', 'dine' ),
        'std' => 'Follow Us',
    ),
    
);

foreach ( dine_social_array() as $id => $icon_data ) {
    
    if ( 'email' == $id ) {
        $name = esc_html__( 'Email', 'dine' );
        $placeholder = 'info@domain.com';
    } else {
        $name = sprintf( esc_html__( '%s URL', 'dine' ), $icon_data[ 'name' ] );
        $placeholder = 'http://';
    }
    
    $fields[] = array(
        'id' => $id,
        'type' => 'text',
        'name' => $name,
        'std' => '',
        'placeholder' => $placeholder,
    );
}