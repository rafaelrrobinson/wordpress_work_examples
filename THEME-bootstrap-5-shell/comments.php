<?php
/**
 * The template for displaying Comments
 * The area of the page that contains comments and the comment form.
 *
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
  <?php if ( have_comments() ) : ?>
  <h3>Comments</h3>

  <ol class="comment-list">
    <?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 34,
			) );
		?>
  </ol>
  
  <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
  <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
    <h1 class="screen-reader-text">
      <?php _e( 'Comment navigation', 'twentyfourteen' ); ?>
    </h1>
    <div class="nav-previous">
      <?php previous_comments_link( __( '&larr; Older Comments', 'twentyfourteen' ) ); ?>
    </div>
    <div class="nav-next">
      <?php next_comments_link( __( 'Newer Comments &rarr;', 'twentyfourteen' ) ); ?>
    </div>
  </nav>
  <!-- #comment-nav-below -->
  <?php endif; // Check for comment navigation. ?>
  <?php if ( ! comments_open() ) : ?>
  <p class="no-comments">
    <?php _e( 'Comments are closed.', 'twentyfourteen' ); ?>
  </p>
  <?php endif; ?>
  <?php endif; // have_comments() ?>
  <?php comment_form(); ?>
</div>
<!-- #comments -->