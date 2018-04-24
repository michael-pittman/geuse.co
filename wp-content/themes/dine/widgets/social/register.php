<?php
/**
 * Social Profile
 *
 * @package Dine
 *
 * @since 1.0
 */

if ( !class_exists( 'Dine_Widget_Social' ) ) :

add_action( 'widgets_init', function() {

    register_widget( 'Dine_Widget_Social' );

} );

class Dine_Widget_Social extends Dine_Widget {
	
    // initialize the widget
	function __construct() {
		$widget_ops = array(
            'classname' => 'widget_social', 
            'description' => esc_html__( 'Displays social profile from theme options.','dine' )
        );
		$control_ops = array('width' => 250, 'height' => 350);
		parent::__construct( 'dine-social', esc_html__( '(Dine) Social' , 'dine' ), $widget_ops, $control_ops );
	}
    
    // register fields
    // Dine_Widget class does the rest
    function fields() {
        include get_template_directory() . '/widgets/social/fields.php';
        return $fields;
    }
	
    // render it to frontend
	function widget( $args, $instance) {
        
        include get_template_directory() . '/widgets/social/widget.php';
        
	}
	
}

endif;