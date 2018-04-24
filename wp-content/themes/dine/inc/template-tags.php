<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage Dine
 * @since 1.0
 */

if ( ! function_exists( 'dine_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function dine_posted_on() {

	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		esc_html__( 'by %s', 'dine' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
	);

	// Finally, let's write all of this to the page.
	echo '<span class="posted-on">' . dine_time_link() . '</span><span class="byline"> ' . $byline . '</span>';
}
endif;


if ( ! function_exists( 'dine_time_link' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 */
function dine_time_link() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ),
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	// Wrap the time string in a link, and preface it with 'Posted on'.
	return '<div class="entry-date">' . sprintf(
		/* translators: %s: post date */
		wp_kses( __( '<span class="screen-reader-text">Posted on</span> %s', 'dine' ), dine_allowed_html() ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	) . '</div>';
}
endif;

if ( ! function_exists( 'dine_entry_categories' ) ) :
/**
 * Prints post categories
 */
function dine_entry_categories() {
    
    if ( ! dine_categorized_blog() ) return;
    
    /* translators: used between list items, there is a space after the comma */
	$separate_meta = esc_html__( '/', 'dine' );
    ?>
    
<div class="entry-categories">

    <?php echo get_the_category_list( $separate_meta ); ?>

</div>
    <?php
}
endif;

if ( ! function_exists( 'dine_entry_tags' ) ) :
/**
 * Prints entry tags
 */
function dine_entry_tags() {
    
    $tags_list = get_the_tag_list();
    if ( $tags_list ) {
        ?>

<div class="entry-tags">

    <?php echo $tags_list; ?>

</div>
<?php
    }
    
}
endif;

/**
 * Display a front page section.
 *
 * @param $partial WP_Customize_Partial Partial associated with a selective refresh request.
 * @param $id integer Front page section to display.
 */
function dine_front_page_section( $partial = null, $id = 0 ) {
	if ( is_a( $partial, 'WP_Customize_Partial' ) ) {
		// Find out the id and set it up during a selective refresh.
		global $dinecounter;
		$id = str_replace( 'panel_', '', $partial->id );
		$dinecounter = $id;
	}

	global $post; // Modify the global post object before setting up post data.
	if ( get_theme_mod( 'panel_' . $id ) ) {
		global $post;
		$post = get_post( get_theme_mod( 'panel_' . $id ) );
		setup_postdata( $post );
		set_query_var( 'panel', $id );

		get_template_part( 'template-parts/page/content', 'front-page-panels' );

		wp_reset_postdata();
	} elseif ( is_customize_preview() ) {
		// The output placeholder anchor.
		echo '<article class="panel-placeholder panel dine-panel dine-panel' . $id . '" id="panel' . $id . '"><span class="dine-panel-title">' . sprintf( esc_html__( 'Front Page Section %1$s Placeholder', 'dine' ), $id ) . '</span></article>';
	}
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function dine_categorized_blog() {
	$category_count = get_transient( 'dine_categories' );

	if ( false === $category_count ) {
		// Create an array of all the categories that are attached to posts.
		$categories = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$category_count = count( $categories );

		set_transient( 'dine_categories', $category_count );
	}

	return $category_count > 1;
}


/**
 * Flush out the transients used in dine_categorized_blog.
 */
function dine_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'dine_categories' );
}
add_action( 'edit_category', 'dine_category_transient_flusher' );
add_action( 'save_post',     'dine_category_transient_flusher' );

if ( ! function_exists( 'dine_pagination' ) ) :
/**
 * Pagination
 */
function dine_pagination( $query = null ) {
    
    if ( ! $query ) {
        global $wp_query;
        $query = $wp_query;
    }
    
    $prev_label = esc_html__( 'Previous', 'dine' );
    
    $next_label = esc_html__( 'Next', 'dine' );
    
    $big = 999999999; // need an unlikely integer
	$pagination = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => ( is_front_page() && ! is_home() ) ? max( 1, get_query_var('page') ) : max( 1, get_query_var('paged') ),
		'total' => $query->max_num_pages,
		'type'			=> 'plain',
		'before_page_number'	=>	'<span>',
		'after_page_number'	=>	'</span>',
		'prev_text'    => '<span>' . $prev_label . '</span>',
		'next_text'    => '<span>' . $next_label . '</span>',
	) );
	
	if ( $pagination ) {
		echo '<div class="dine-pagination">' . $pagination  . '</div>';
	}

}
endif;

if ( ! function_exists( 'dine_comment_nav' ) ) :
/**
 * Comment Nav
 *
 * @since 1.0
 */
function dine_comment_nav() {

    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
    <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
        <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'dine' ); ?></h2>
        <div class="nav-links">

            <div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'dine' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'dine' ) ); ?></div>

        </div><!-- .nav-links -->
    </nav><!-- #comment-nav-above -->
    <?php endif; // Check for comment navigation.
    
}
endif;

if ( ! function_exists( 'dine_page_links' ) ) :
/**
 * Page Links
 *
 * @since 1.0
 */
function dine_page_links() {
    
    wp_link_pages( array(
        'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'dine' ) . '</span>',
        'after'       => '</div>',
        'link_before' => '<span class="page-number">',
        'link_after'  => '</span>',
    ) );
    
}
endif;