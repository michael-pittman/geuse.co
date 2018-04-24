<div id="navbar">
    
    <div id="navbar-inner">
    
        <?php if ( has_nav_menu( 'primary' ) ) : ?>

        <div class="main-navigation">

            <?php wp_nav_menu(array(
                'theme_location'	=>	'primary',
                'menu_id'           =>  'nav',
                'depth'				=>	3,
                'container_class'	=>	'menu',
                'menu_class'        =>  'menu main-menu',
            ));?>

        </div><!-- .main-navigation -->

        <?php else : ?>

        <div class="main-navigation">

            <em class="dine-notice">
                <?php printf( 
                esc_html__( '%s to setup your primary menu', 'dine' ),
                '<a href="' . admin_url( 'nav-menus.php' ) . '">' . esc_html__( 'Click here', 'dine' ) . '</a>' ); ?>
            </em>

        </div>

        <?php endif; ?>
        
    </div><!-- #navbar-inner -->

</div><!-- #navbar -->