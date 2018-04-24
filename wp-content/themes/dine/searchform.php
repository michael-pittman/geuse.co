<?php
/**
 * Template for displaying search forms in Dine
 *
 * @package WordPress
 * @subpackage Dine
 * @since 1.0
 * @version 1.0
 */
?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $unique_id ); ?>">
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'dine' ); ?></span>
	</label>
	<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'dine' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    
    <button type="submit" class="submit" title="<?php esc_html_e( 'Go' ,'dine' );?>"><i class="fa fa-search"></i></button>
	
</form>
