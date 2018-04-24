<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Dine
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
    
</head>

<body <?php body_class(); ?>>
    
<div id="top"></div>
<div id="page" class="site">
	
    <?php

$classes = array( 'site-header' );

// Layout
$layout = get_option( 'dine_header_layout', 'left' );
if ( 'center' != $layout ) $layout = 'left';
$classes[] = 'header-' . $layout;

// Skin
$skin = get_option( 'dine_header_skin', 'light' );
if ( 'dark' != $skin ) $skin = 'light';
$classes[] = 'header-' . $skin;

// Sticky Header
if ( 'true' == get_option( 'dine_header_sticky' ) ) {
    $classes[] = 'header-sticky';
}

// Transparent Header
if ( is_singular() && 'true' == get_post_meta( get_the_ID(), '_dine_transparent_header', true ) ) {
    
    $classes[] = 'header-transparent';
    
} elseif ( is_home() ) {

    if ( ! is_front_page() ) {
        
        $page_id = get_option( 'page_for_posts' );
        if ( 'true' == get_post_meta( $page_id, '_dine_transparent_header', true ) ) {
            $classes[] = 'header-transparent';
        }
        
    } else {
    
        $header_img = trim( get_option( 'dine_blog_hero' ) );
        if ( $header_img ) {
            $classes[] = 'header-transparent';
        }
        
    }
    
}

if ( apply_filters( 'dine_transparent_header', false ) ) {
    $classes[] = 'header-transparent';
}

$classes = join( ' ', $classes );
    
    ?>
	<header id="masthead" class="<?php echo esc_attr( $classes ); ?>">

		<div class="masthead-inner">
            
            <div class="container">

                <?php get_template_part( 'parts/site-branding' ); ?>

                <?php get_template_part( 'parts/nav' ); ?>
                
                <?php get_template_part( 'parts/header-social' ); ?>
                
                <?php get_template_part( 'parts/header-button' ); ?>
                
                <a id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </a>

            </div><!-- .container -->

        </div><!-- .masthead-inner -->

	</header><!-- #masthead -->
    
    <div id="masthead-height"></div>

    <div id="content" class="site-content">