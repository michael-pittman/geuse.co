<?php

if ( has_nav_menu( 'social' ) ) :

wp_nav_menu( array (
    'theme_location'	=>	'social',
    'menu_id'           =>  'header-social',
    'depth'				=>	1,
    'container_class'	=>	'header-social',
    'menu_class'        =>  'social-list',
    'link_before'        => '<span>',
    'link_after'        => '</span>',
) );

endif;