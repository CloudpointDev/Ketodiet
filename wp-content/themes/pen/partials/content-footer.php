<?php
/**
 * Template part for displaying the content footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Pen
 */

$content_id      = pen_post_id();
$pen_is_singular = is_singular();

ob_start();
// Hide tags for pages.
if ( 'post' === get_post_type() ) {
	/* Translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list();

	if ( $tags_list ) {
		/* Translators: %s: The tag name. */
		printf(
			'<span class="tags-links%1$s">%2$s</span>',
			pen_class_lists( 'tags_display_override', $content_id ), /* phpcs:ignore */
			sprintf(
				'<span class="pen_heading_tags">%1$s</span>%2$s',
				esc_html__( 'Tagged', 'pen' ),
				$tags_list /* phpcs:ignore */
			)
		); /* phpcs:ignore */
	}
}

if ( ! $pen_is_singular && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
	?>
	<span class="comments-link<?php pen_class_lists( 'button_comment_display_override', $content_id ); ?>">
	<?php
	comments_popup_link(
		sprintf(
			wp_kses(
				/* Translators: %s: post title */
				__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'pen' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		)
	);
	echo '</span>';
}

if ( ! $pen_is_singular ) {
	edit_post_link(
		sprintf(
			/* Translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'pen' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		sprintf(
			'<span class="edit-link%s">',
			pen_class_lists( 'button_edit_display_override', $content_id )
		),
		'</span>'
	);
}
$post_footer  = trim( ob_get_clean() );
$social_share = pen_html_share( 'footer', $content_id );
$entry_meta   = pen_html_content_information( 'footer', $content_id );
if ( $post_footer || $social_share || $entry_meta ) {
	?>
	<footer class="entry-footer pen_content_footer<?php echo pen_class_lists( 'footer_display_override', $content_id ); /* phpcs:ignore */ ?>">
		<div class="pen_actions">
	<?php
	echo $post_footer; /* phpcs:ignore */
	echo $social_share; /* phpcs:ignore */
	?>
		</div>
	<?php
	echo $entry_meta; /* phpcs:ignore */
	?>
	</footer><!-- .pen_content_footer -->
	<?php
}
