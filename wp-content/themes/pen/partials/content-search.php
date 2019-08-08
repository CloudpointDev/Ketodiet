<?php
/**
 * Template part for displaying results in search pages.
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
the_title(
	sprintf(
		'<h2 class="entry-title pen_content_title%1$s"><a href="%2$s" rel="bookmark">',
		pen_class_lists( 'title_display_override', $content_id ),
		esc_url( get_permalink() )
	),
	'</a></h2>'
);

echo pen_html_content_information( 'header', $content_id ); /* phpcs:ignore */
?>
	</header><!-- .pen_content_header -->
<?php
pen_sidebar_get( 'sidebar-content-top', $content_id );

$list_type = pen_option_get( 'list_type' );
if ( 'masonry' === $list_type ) {
	get_template_part( 'partials/content', 'thumbnail' );
}
?>
	<div class="entry-summary pen_summary">
<?php
if ( 'plain' === $list_type ) {
	get_template_part( 'partials/content', 'thumbnail' );
}
the_excerpt();
echo pen_html_author( array(), $content_id ); /* phpcs:ignore */
?>
	</div><!-- .pen_summary -->
<?php
pen_sidebar_get( 'sidebar-content-bottom', $content_id );

get_template_part( 'partials/content', 'search-footer' );

if ( $pen_is_singular ) {
	pen_html_jump_menu( 'content', $content_id );
}
?>
</article><!-- #post-<?php echo (int) $content_id; /* phpcs:ignore */ ?> -->
