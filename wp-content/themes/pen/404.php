<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Pen
 */

$content_id = pen_post_id();

get_header(); ?>
<div id="primary" class="content-area error-404 not-found">
	<main id="main" class="<?php echo esc_attr( pen_content_classes( $content_id ) ); ?>" role="main">
		<div class="pen_article_wrapper">
			<header class="page-header pen_content_header">
				<h1 class="page-title pen_content_title">
<?php
esc_html_e( 'Oops! That page can&rsquo;t be found.', 'pen' );
?>
				</h1>
			</header><!-- .pen_content_header -->
			<article <?php echo pen_post_classes( array( 'pen_article' ), $content_id ); /* phpcs:ignore */ ?>>
				<div class="page-content pen_content clearfix">
					<div class="pen_content_wrapper pen_inside">
						<p>
<?php
esc_html_e( 'It looks like nothing was found at this location, sorry!', 'pen' );
?>
						</p>
<?php
if ( ! pen_html_search_box( $content_id ) ) {
	?>
						<div id="error-404-search">
	<?php
	get_search_form();
	?>
							</div>
	<?php
}
?>
					</div><!-- .pen_content -->
				</div><!-- .pen_content_wrapper -->
			</article>
		</div><!-- .pen_article_wrapper -->
	</main>
<?php
if ( is_singular() ) {
	pen_html_jump_menu( 'content', $content_id );
}
?>
</div><!-- #primary -->
<?php
get_footer();
