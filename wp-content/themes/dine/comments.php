<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Dine
 * @since 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() || !comments_open() ) {
	return;
}
?>
<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
    <h2 class="comments-title">
        <?php
            printf( _n( '1 Comment', '%s Comments', get_comments_number(), 'dine' ),
                number_format_i18n( get_comments_number() ) );
        ?>
    </h2>
    
    <?php dine_comment_nav(); ?>

    <ol class="comment-list">
        <?php
            wp_list_comments( array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' => 100,
            ) );
        ?>
    </ol><!-- .comment-list -->

    <?php dine_comment_nav(); ?>

	<?php 
    endif; // Check for have_comments().
    
	$commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $fields = array();

    $fields[ 'author' ] =  '<p class="comment-form-author"><label class="screen-reader-text" for="author">' . esc_html__( 'Name', 'dine' ) . '</label> ' .
    ( $req ? '<span class="required screen-reader-text">*</span>' : '' ) .
    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
    '" size="30"' . $aria_req . ' placeholder="' . esc_html__( 'Name', 'dine' ) . ( $req ? ' *' : '' ) .  '" /></p>';

    $fields[ 'email' ] = '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . esc_html__( 'Email', 'dine' ) . '</label> ' .
    ( $req ? '<span class="required screen-reader-text">*</span>' : '' ) .
    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    '" size="30"' . $aria_req . ' placeholder="' . esc_html__( 'Email', 'dine' ) . ( $req ? ' *' : '' ) . '" /></p>';

    $fields[ 'url' ] = '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'dine' ) . '</label>' .
    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
    '" size="30" placeholder="' . esc_html__( 'Website', 'dine' ) . '" /></p>';

    comment_form( array(
        
        'comment_field' =>  '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">' . _x( 'Comment', 'noun','dine' ) .
            '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . esc_html__( 'Comment', 'dine' ) . ' *' . '"></textarea></p>',
    
        'fields' => $fields,
        
        'logged_in_as' => '',
        'comment_notes_before' => '',
        
    ) );
	?>

</div><!-- #comments -->