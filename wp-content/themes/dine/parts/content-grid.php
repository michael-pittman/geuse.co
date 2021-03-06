<?php
/**
 * Template part for displaying post grid
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Dine
 * @since 1.0
 * @version 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'dine-post-grid' ); ?>>
    
    <?php if ( '' !== get_the_post_thumbnail() ) : ?>
    
    <div class="post-thumbnail">

        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail( 'dine_grid' ); ?>
        </a>

    </div><!-- .post-thumbnail -->
    
	<?php endif; ?>
    
    <header class="grid-header">
		<?php

            the_title( '<h2 class="grid-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

			if ( 'post' === get_post_type() ) :
				echo '<div class="entry-meta">';

				    echo dine_time_link();
                    dine_entry_categories();

				echo '</div><!-- .entry-meta -->';
			endif;
			
		?>
	</header><!-- .grid-header -->

	<div class="grid-excerpt">
		
        <?php the_excerpt(); ?>

	</div><!-- .grid-excerpt -->

</article><!-- #post-## -->
