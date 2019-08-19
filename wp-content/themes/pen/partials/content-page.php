<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Pen
 */

$content_id      = pen_post_id();
$pen_is_singular = is_singular();
?>
<article id="post-<?php echo (int) $content_id; /* phpcs:ignore */ ?>" <?php echo pen_post_classes( array(), $content_id ); /* phpcs:ignore */ ?>>
<?php
$background_image_dynamic = pen_content_title_background( $pen_is_singular, $content_id );
?>
	<header class="entry-header pen_content_header<?php echo pen_class_lists( 'header_display_override', $content_id ); /* phpcs:ignore */ ?>"<?php if ( $background_image_dynamic ) { echo ' style="background-image:url(' . $background_image_dynamic . ');background-size:cover"'; /* phpcs:ignore */ } ?>>
<?php
the_title(
	sprintf(
		'<h1 class="page-title pen_content_title%s">',
		pen_class_lists( 'title_display_override', $content_id )
	),
	'</h1>'
);

echo pen_html_share( 'header', $content_id ); /* phpcs:ignore */
?>
	</header><!-- .pen_content_header -->
<?php
pen_sidebar_get( 'sidebar-content-top', $content_id );

ob_start();
the_content();
$content = trim( ob_get_clean() );

ob_start();
get_template_part( 'partials/content', 'thumbnail' );
$thumbnail = trim( ob_get_clean() );

ob_start();
echo $thumbnail; /* phpcs:ignore */
if ( $content ) {
	?>
	<div class="pen_content_wrapper pen_inside">
	<?php
	echo $content; /* phpcs:ignore */
	?>
	</div>
	<?php
}

pen_html_pagination_content( $content_id );

$classes = array(
	'entry-content',
	'pen_content',
	'clearfix',
	trim( pen_class_lists( 'summary_display_override', $content_id ) ),
	$thumbnail ? 'pen_has_thumbnail' : 'pen_without_thumbnail',
);
$classes = trim( implode( ' ', array_filter( $classes ) ) );

$content = trim( ob_get_clean() );
if ( $content ) {
	?>
	<div class="<?php echo esc_attr( $classes ); ?>">
	<?php
	echo $content; /* phpcs:ignore */
	echo pen_html_share( 'content', $content_id ); /* phpcs:ignore */
	?>
	</div><!-- .pen_content -->
	<?php
}

pen_sidebar_get( 'sidebar-content-bottom', $content_id );

$edit_link    = ( ! $pen_is_singular ) ? get_edit_post_link() : false;
$social_share = pen_html_share( 'footer', $content_id );
if ( $edit_link || $social_share ) {
	?>
	<footer class="entry-footer pen_content_footer<?php echo pen_class_lists( 'footer_display_override', $content_id ); /* phpcs:ignore */ ?>">
		<div class="pen_actions">
	<?php
	if ( $edit_link ) {
		edit_post_link(
			sprintf(
				/* Translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'pen' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
	echo $social_share; /* phpcs:ignore */
	?>
		</div>
	</footer><!-- .pen_content_footer -->
	<?php
}

echo pen_html_configuration_overview( $content_id ); /* phpcs:ignore */

if ( $pen_is_singular ) {
	pen_html_jump_menu( 'content', $content_id );
}
?>
</article><!-- #post-<?php echo (int) $content_id; /* phpcs:ignore */ ?> -->
