<?php
/*
Template Name: Page: No Sidebar
*/
?>

<?php get_header(); ?>
	<div id="page-wrap">
		<div id="content" <?php post_class(); ?>>
		<div class="container">
			<div class="span12">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php the_content(); ?>
						
					<?php wp_link_pages(array('before' =>'<div class="pagination_post aligncenter">', 'after'  =>'</div>', 'pagelink' => '<span>%</span>')); ?>
					
				<?php endwhile; endif; ?></div>
			</div>
		</div> <!-- end content -->
	</div> <!-- end page-wrap -->
<?php get_footer(); ?>
