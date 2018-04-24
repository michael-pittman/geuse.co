<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Dine
 * @since 1.0
 * @version 1.0
 */

if ( ! is_active_sidebar( 'main' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
    
	<?php dynamic_sidebar( 'main' ); ?>
    
</aside><!-- #secondary -->
