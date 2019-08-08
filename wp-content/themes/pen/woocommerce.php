<?php
/**
 * The template for displaying WooCommerce pages.
 *
 * This is the template that displays all WooCommerce pages by default.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Pen
 */

$content_id      = pen_post_id();
$pen_is_singular = is_singular();
get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="<?php echo esc_attr( pen_content_classes( $content_id ) ); ?>" role="main">
			<div class="pen_article_wrapper">
<?php
if ( $pen_is_singular ) {
	?>
				<article id="post-<?php echo $content_id; /* phpcs:ignore */ ?>" <?php echo pen_post_classes( array(), $content_id ); /* phpcs:ignore */ ?>>
	<?php
}

woocommerce_content();

if ( $pen_is_singular ) {
	?>
				</article>
	<?php
}
?>
			</div>
		</main>
<?php
pen_html_jump_menu( 'woocommerce', $content_id );
?>
	</div><!-- #primary -->
<?php
get_footer();
