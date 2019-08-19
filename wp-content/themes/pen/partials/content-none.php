<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Pen
 */

$content_id = pen_post_id();
?>
<div class="no-results not-found">
	<div class="pen_article_wrapper">
		<header class="page-header pen_content_header<?php echo pen_class_lists( 'header_display_override', $content_id ); /* phpcs:ignore */ ?>">
			<h1 class="page-title pen_content_title<?php echo pen_class_lists( 'title_display_override', $content_id ); /* phpcs:ignore */ ?>">
<?php
esc_html_e( 'Nothing Found', 'pen' );
?>
			</h1>
		</header><!-- .pen_content_header -->
		<article <?php echo pen_post_classes( array( 'pen_article' ), $content_id ); /* phpcs:ignore */ ?>>
			<div class="page-content pen_content clearfix">
				<div class="pen_content_wrapper pen_inside">
<?php
if ( is_home() && current_user_can( 'publish_posts' ) ) {
	?>
					<p>
	<?php
	printf(
		wp_kses(
			// Translators: 1: Just a URL.
			__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'pen' ),
			array(
				'a' => array(
					'href' => array(),
				),
			)
		),
		esc_url( admin_url( 'post-new.php' ) )
	);
	?>
					</p>
	<?php
} elseif ( is_search() ) {
	?>
					<p>
	<?php
	esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'pen' );
	?>
					</p>
	<?php
} else {
	?>
					<p>
	<?php
	esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'pen' );
	?>
					</p>
	<?php
}
?>
				</div><!-- .pen_content_wrapper -->
			</div><!-- .pen_content -->
		</article>
	</div><!-- .pen_article_wrapper -->
</div><!-- .no-results -->
