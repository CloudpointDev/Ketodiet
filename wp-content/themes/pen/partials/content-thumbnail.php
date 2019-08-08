<?php
/**
 * Template part for displaying the content featured image.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Pen
 */

if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {

	$content_id = pen_post_id();

	if ( is_singular() ) {
		$thumbnail_display = get_post_meta( $content_id, 'pen_content_thumbnail_display_override', true );
		if ( ! $thumbnail_display || 'default' === $thumbnail_display ) {
			$thumbnail_display = pen_option_get( 'content_thumbnail_display' );
		}
		if ( $thumbnail_display && 'no' !== $thumbnail_display ) {
			?>
		<div class="<?php echo esc_attr( pen_thumbnail_classes( 'content', $content_id ) ); ?>">
			<?php
			the_post_thumbnail( pen_content_thumbnail_size( 'content', $content_id ) );
			?>
		</div><!-- .post-thumbnail -->
			<?php
		}
	} else {
		$thumbnail_display = get_post_meta( $content_id, 'pen_list_thumbnail_display_override', true );
		if ( ! $thumbnail_display || 'default' === $thumbnail_display ) {
			$thumbnail_display = pen_option_get( 'list_thumbnail_display' );
		}
		if ( $thumbnail_display && 'no' !== $thumbnail_display ) {
			?>
		<a class="<?php echo esc_attr( pen_thumbnail_classes( 'list', $content_id ) ); ?>" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( pen_content_thumbnail_size( 'list', $content_id ) );
			?>
		</a>
			<?php
		}
	}
}
