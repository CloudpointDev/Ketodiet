<?php
/**
 * Template part for displaying the content pagination.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Pen
 */

$content_id = pen_post_id();

ob_start();
if ( function_exists( 'wp_pagenavi' ) ) {
	wp_pagenavi();
} else {
	the_posts_navigation();
}
$pager = trim( ob_get_clean() );
if ( $pager ) {
	?>
	<div id="pen_pager" class="clearfix <?php pen_class_animation( 'list_pager', 'echo', $content_id ); /* phpcs:ignore */ ?>">
	<?php
	echo $pager; /* phpcs:ignore */
	?>
	</div>
	<?php
}
