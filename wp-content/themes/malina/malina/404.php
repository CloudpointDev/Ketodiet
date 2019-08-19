
<?php get_header(); ?>

	<div id="page-wrap">
		<div class="container">
			<div id="content" <?php post_class('span12'); ?>>
				<div id="error-404">
					<div class="entry">
						<h1 class="error-title"><?php esc_html_e('Oops', 'malina'); ?></h1>
						<div class="error-subtitle"><?php esc_html_e("We don't have the page you are looking for", 'malina'); ?></div>
						<a href="<?php echo esc_url(home_url('/')); ?>" class="button error-button"><?php esc_html_e('Return to home page','malina'); ?></a>
					</div>
				</div>
			</div> <!-- end content -->
		</div>
	</div> <!-- end page-wrap -->
<?php get_footer('blank'); ?>
