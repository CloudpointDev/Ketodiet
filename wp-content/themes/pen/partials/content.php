<?php
/**
 * Template part for displaying posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Pen
 */

$content_id      = pen_post_id();
$pen_is_singular = is_singular();
?>
<article id="post-<?php echo $content_id; /* phpcs:ignore */ ?>" <?php echo pen_post_classes( array(), $content_id ); /* phpcs:ignore */ ?>>
<?php
$background_image_dynamic = pen_content_title_background( $pen_is_singular, $content_id );
?>
	<header class="entry-header pen_content_header<?php echo pen_class_lists( 'header_display_override', $content_id ); /* phpcs:ignore */ ?>"<?php if ( $background_image_dynamic ) { echo ' style="background-image:url(' . $background_image_dynamic . ');background-size:cover"'; /* phpcs:ignore */ } ?>>
<?php
if ( $pen_is_singular ) {
	the_title( '<h1 class="entry-title pen_content_title">', '</h1>' );
} else {
	the_title(
		sprintf(
			'<h2 class="entry-title pen_content_title%1$s"><a href="%2$s" rel="bookmark">',
			pen_class_lists( 'title_display_override', $content_id ),
			esc_url( get_permalink() )
		),
		'</a></h2>'
	);
}

echo pen_html_content_information( 'header', $content_id ); /* phpcs:ignore */
echo pen_html_share( 'header', $content_id ); /* phpcs:ignore */

?>
	</header><!-- .pen_content_header -->

<?php
pen_sidebar_get( 'sidebar-content-top', $content_id );

$thumbnail = '';
$list_type = pen_option_get( 'list_type' );
if ( ! $pen_is_singular && 'masonry' === $list_type ) {
	ob_start();
	get_template_part( 'partials/content', 'thumbnail' );
	$thumbnail = trim( ob_get_clean() );
	echo $thumbnail; /* phpcs:ignore */
}

$list_excerpt_display = pen_option_get( 'list_excerpt' );

ob_start();
// get_the_content() does not support shortcodes etc.
if ( $pen_is_singular || ! $list_excerpt_display ) {
	the_content(
		sprintf(
			wp_kses(
				/* Translators: %s: Name of current post. */
				__( 'Continue reading %s', 'pen' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		)
	);
} elseif ( ! $pen_is_singular && $list_excerpt_display ) {
	the_excerpt();
}
$content = trim( ob_get_clean() );

ob_start();
if ( $pen_is_singular || 'plain' === $list_type ) {
	ob_start();
	get_template_part( 'partials/content', 'thumbnail' );
	$thumbnail = trim( ob_get_clean() );
	echo $thumbnail; /* phpcs:ignore */
}

if ( $content ) {
	?>
	<div class="pen_content_wrapper pen_inside">
	<?php
	echo $content; /* phpcs:ignore */

	pen_html_pagination_content( $content_id );
	?>
	</div>
	<?php
}

pen_sidebar_get( 'sidebar-content-bottom', $content_id );

$content = trim( ob_get_clean() );
if ( $content ) {
	$classes = array(
		'entry-content',
		'pen_content',
		trim( pen_class_lists( 'summary_display_override', $content_id ) ),
		$thumbnail ? 'pen_with_thumbnail' : 'pen_without_thumbnail',
	);
	$classes = trim( implode( ' ', array_filter( $classes ) ) );
	?>
	<div class="<?php echo esc_attr( $classes ); ?>">
	<?php
	echo $content; /* phpcs:ignore */
	echo pen_html_share( 'content', $content_id ); /* phpcs:ignore */
	echo pen_html_author( array(), $content_id ); /* phpcs:ignore */
	?>
	</div><!-- .pen_content -->
	<?php
}

get_template_part( 'partials/content', 'footer' );

echo pen_html_configuration_overview( $content_id ); /* phpcs:ignore */

if ( $pen_is_singular ) {
	pen_html_jump_menu( 'content', $content_id );
}
?>
</article><!-- #post-<?php echo (int) $content_id; /* phpcs:ignore */ ?> -->
