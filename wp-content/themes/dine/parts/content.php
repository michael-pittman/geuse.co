<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Dine
 * @since 1.0
 * @version 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'dine-article' ); ?>>
    
    <?php if ( ! is_single() ) : ?>
    
    <div class="dine-divider type-icon divider-icon has-animation" data-delay="200">
    
        <div class="divider-inner">

            <div class="divider-line line-left"></div>

                    <div class="icon-wrapper">

                <span class="icon"><i class="fa fa-star"></i></span>
            </div><!-- .icon-wrapper -->

            <div class="divider-line line-right"></div>

        </div><!-- .divider-inner -->

    </div>
    
    <?php endif; ?>
    
	<?php
		if ( is_sticky() && is_home() ) :
			echo '<div class="sticky-label">' . esc_html__( 'Sticky Post', 'dine' ) . '</div>';
		endif;
	?>
	<header class="entry-header">
		<?php

            if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}

			if ( 'post' === get_post_type() ) :
				echo '<div class="entry-meta">';
					if ( is_single() ) :
						dine_posted_on();
					else :
						echo dine_time_link();
					endif;

                    dine_entry_categories();

				echo '</div><!-- .entry-meta -->';
			endif;
			
		?>
	</header><!-- .entry-header -->

	<?php if ( '' !== get_the_post_thumbnail() ) : ?>
    
    <?php if ( ! is_single() ) : ?>
    
		<div class="post-thumbnail">
            
            <a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'full' ); ?>
			</a>
            
		</div><!-- .post-thumbnail -->
    
    <?php else: ?>
    
        <div class="post-thumbnail">
            
            <?php the_post_thumbnail( 'full' ); ?>
            
		</div><!-- .post-thumbnail -->
    
    <?php endif; ?>
    
	<?php endif; ?>

	<div class="entry-content">
		<?php

if ( ! is_single() ) {
    $content_excerpt = get_option( 'dine_content_excerpt' );
    if ( 'excerpt' != $content_excerpt ) $content_excerpt  = 'content';
} else {
    $content_excerpt = 'content';
}

if ( 'content' == $content_excerpt ) {

    /* translators: %s: Name of current post */
    the_content( esc_html__( 'Continue reading', 'dine' ) );
    dine_page_links();
    
} else {

    the_excerpt();
    
    echo '<p><a href="' . get_permalink() . '" class="more-link">' . esc_html__( 'Read More', 'dine' ) . '</a></p>';

}
		?>
	</div><!-- .entry-content -->

	<?php if ( is_single() ) : ?>
		<?php dine_entry_tags(); ?>
	<?php endif; ?>

</article><!-- #post-## -->
