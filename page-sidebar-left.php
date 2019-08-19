<?php
/*
Template Name: Page: Left sidebar
*/
?>
<?php get_header(); ?>

<div id="page-wrap" class="container">

	<div id="content" class="sidebar-left span9">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if(!rwmb_get_value('malina_page_title_hide')){ ?>
				<header class="title">
					<h2 class="<?php echo rwmb_get_value('malina_page_title_position'); ?>"><?php echo esc_attr(get_the_title()); ?></h2>
				</header>
			<?php } ?>
			<div class="entry">

				<?php the_content(); ?>

				<?php wp_link_pages(array('before' =>'<div class="pagination_post aligncenter">', 'after'  =>'</div>', 'pagelink' => '<span>%</span>')); ?>

			</div>

		</article>

		<?php endwhile; endif; ?>
	</div> <!-- end content -->

	<?php get_sidebar(); ?>
	
</div> <!-- end page-wrap -->
	
<?php get_footer(); ?>