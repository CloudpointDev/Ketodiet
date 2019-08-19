<?php 
$sidebar_pos = malina_get_sidebar_position();
?>
<div id="page-wrap-blog" class="container">
	<?php if( get_theme_mod('malina_single_post_title_block', 'above') == 'above' ){
		get_template_part('templates/posts/title', 'block');
	} ?>
	<div class="wide-image">
		<?php
			malina_single_post_format_content();
		?>
	</div>
	<div class="container">
		<div id="content" class="<?php echo esc_attr($sidebar_pos); ?> single">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<article <?php post_class(); ?>>
						<div class="post-content-container">
							<?php if( get_theme_mod('malina_single_post_title_block', 'above') == 'under' ){
								get_template_part('templates/posts/title', 'block');
							} ?>
							<div class="post-content">
								<div class="post-excerpt">
									<?php the_content(); ?>
								</div>
								<?php wp_link_pages(array('before' =>'<div class="pagination_post aligncenter">', 'after'  =>'</div>', 'pagelink' => '<span>%</span>')); ?>
							</div>
		
							<?php get_template_part( 'templates/posts/meta', 'single' ); ?>
						</div>
						<?php 
							if ( '' !== get_the_author_meta( 'description' ) ) {
								get_template_part( 'templates/posts/biography' );
							}
		
							if( get_theme_mod( 'malina_single_post_navigation', true ) ){
								get_template_part( 'templates/posts/post-navigation' );
							}
		
							if( get_theme_mod( 'malina_single_post_related', 'false' ) == 'true' ){
								get_template_part( 'templates/posts/related-posts' );
							}
							
							comments_template();
							
						?>
					</article>
					<?php if( rwmb_meta('malina_post_sticky_sharebox') && function_exists('MalinaStickySharebox') ){
						MalinaStickySharebox(get_the_ID(), true);
					} elseif ( get_theme_mod( 'malina_single_post_sicky_sharebox', false ) && function_exists('MalinaStickySharebox') ){
						MalinaStickySharebox(get_the_ID(), true);
					} ?>
			<?php endwhile; endif; ?>
		</div>
		<?php 
			if( rwmb_meta( 'malina_post_sidebar' ) == 'sidebar-right' || rwmb_meta( 'malina_post_sidebar' ) == 'sidebar-left' ){
				get_sidebar();
			} elseif(  rwmb_meta( 'malina_post_sidebar' ) == 'default' && get_theme_mod('malina_single_post_sidebar', 'sidebar-right') != 'none' ){
				get_sidebar();
			}
		?>
	</div>
</div>
