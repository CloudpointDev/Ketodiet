<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Pen
 */

$content_id = pen_post_id();

get_header(); ?>
<div id="primary" class="content-area">
	<main id="main" class="<?php echo esc_attr( pen_content_classes( $content_id ) ); ?>" role="main">
		<div class="pen_article_wrapper">
<?php
if ( have_posts() ) {
	?>
			<header class="page-header pen_content_header">
				<h1 class="page-title pen_content_title">
					<span class="pen_heading_main">
	<?php
	esc_html_e( 'Search results for:', 'pen' );
	?>
					</span>
					<span>
	<?php
	echo get_search_query(); /* phpcs:ignore */
	?>
					</span>
				</h1>
			</header><!-- .pen_content_header -->
	<?php
	$content_list_type = pen_list_type();
	if ( 'masonry' === $content_list_type ) {
		?>
			<div id="pen_masonry">
		<?php
	}
	/* Start the Loop */
	while ( have_posts() ) {
		the_post();
		/**
		 * Run the loop for the search to output the results.
		 * If you want to overload this in a child theme then include a file
		 * called content-search.php and that will be used instead.
		 */
		get_template_part( 'partials/content', 'search' );
	}
	if ( 'masonry' === $content_list_type ) {
		?>
			</div>
		<?php
	}
	get_template_part( 'partials/content', 'pagination' );
} else {
	get_template_part( 'partials/content', 'none' );
}
?>
		</div>
	</main>
<?php
if ( ! is_singular() ) {
	pen_html_jump_menu( 'list', $content_id );
}
?>
</div><!-- #primary -->
<?php
get_footer();
