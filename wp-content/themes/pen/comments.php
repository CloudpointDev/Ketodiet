<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Pen
 */

$content_id = pen_post_id();

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
<?php
if ( have_comments() ) {
	$pen_comment_count    = get_comments_number();
	$pen_comments_display = false;
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
		$pen_comments_display = true;
	}
	?>
	<h2 class="comments-title">
	<?php
	if ( '1' === $pen_comment_count ) {
		printf(
			/* Translators: 1: title. */
			esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'pen' ),
			'<span>' . wp_kses( get_the_title(), wp_kses_allowed_html( 'post' ) ) . '</span>'
		);
	} else {
		printf( /* phpcs:ignore */
			/* Translators: 1: comment count number, 2: title. */
			esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $pen_comment_count, 'comments title', 'pen' ) ),
			esc_html( number_format_i18n( $pen_comment_count ) ),
			'<span>' . wp_kses( get_the_title(), wp_kses_allowed_html( 'post' ) ) . '</span>'
		);
	}
	?>
	</h2>
	<?php
	/* Are there comments to navigate through? */
	if ( $pen_comments_display ) {
		$label = sprintf(
			/* Translators: %s: either 'Top' or 'Bottom', both translated. */
			__( 'Comments Menu - %s', 'pen' ),
			__( 'Top', 'pen' )
		);
		?>
	<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation" aria-label="<?php echo esc_attr( $label ); ?>">
		<h2 class="screen-reader-text">
		<?php
		esc_html_e( 'Comment navigation', 'pen' );
		?>
		</h2>
		<div class="nav-links">
			<div class="nav-previous">
		<?php
		previous_comments_link( esc_html__( 'Older Comments', 'pen' ) );
		?>
			</div>
			<div class="nav-next">
		<?php
		next_comments_link( esc_html__( 'Newer Comments', 'pen' ) );
		?>
			</div>
		</div><!-- .nav-links -->
	</nav><!-- #comment-nav-above -->
		<?php
	}
	?>
	<ol class="comment-list">
	<?php
	wp_list_comments(
		array(
			'style'      => 'ol',
			'short_ping' => true,
		)
	);
	?>
	</ol><!-- .comment-list -->
	<?php
	/* Are there comments to navigate through? */
	if ( $pen_comments_display ) {
		$label = sprintf(
			/* Translators: %s: either 'Top' or 'Bottom', both translated. */
			__( 'Comments Menu - %s', 'pen' ),
			__( 'Bottom', 'pen' )
		);
		?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation" aria-label="<?php echo esc_attr( $label ); ?>">
		<h2 class="screen-reader-text">
		<?php
		esc_html_e( 'Comment navigation', 'pen' );
		?>
		</h2>
		<div class="nav-links">
			<div class="nav-previous">
		<?php
		previous_comments_link( esc_html__( 'Older Comments', 'pen' ) );
		?>
			</div>
			<div class="nav-next">
		<?php
		next_comments_link( esc_html__( 'Newer Comments', 'pen' ) );
		?>
			</div>
		</div><!-- .nav-links -->
	</nav><!-- #comment-nav-below -->
		<?php
	}
}

/* If comments are closed and there are comments, let's leave a little note, shall we? */
if ( ! comments_open() && $pen_comment_count && post_type_supports( get_post_type(), 'comments' ) ) {
	?>
	<p class="no-comments">
	<?php
	esc_html_e( 'Comments are closed.', 'pen' );
	?>
	</p>
	<?php
}

ob_start();
comment_form();
$comment_form = trim( ob_get_clean() );

if ( $comment_form ) {
	?>
	<div id="pen_respond_wrapper" class="<?php pen_class_animation( 'comments', 'echo', $content_id ); /* phpcs:ignore */ ?>">
	<?php
	echo $comment_form; /* phpcs:ignore */
	?>
	</div>
	<?php
}
?>
</div><!-- #comments -->
