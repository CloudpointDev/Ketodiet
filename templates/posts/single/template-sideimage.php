<div id="page-wrap-blog" class="container">
	<div id="content" class="single">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article <?php post_class(); ?>>
					<div class="post-content-container">
						<div class="row">
							<?php
								echo '<div class="span6">';
									malina_single_post_format_content();
								echo '</div>';
							?>
							<?php 
								switch ( get_post_format() ) {
									case 'gallery':
									case 'link':
									case 'audio':
									case 'video':
									case 'image':
									case 'quote':
										echo '<div class="span6">';
										break;
									default:
										if( has_post_thumbnail() ) {
											echo '<div class="span6">';
										} else {
											echo '<div class="span12">';
										}
										break;
								}
								?>
								<div class="leftpad15">
									<?php get_template_part('templates/posts/title', 'block'); ?>

									<div class="post-content">
										<div class="post-excerpt">
											<?php the_content(); ?>
										</div>
										<?php wp_link_pages(array('before' =>'<div class="pagination_post aligncenter">', 'after'  =>'</div>', 'pagelink' => '<span>%</span>')); ?>
									</div>
								</div>
					
							</div>
							<div class="row">
								<div class="span12"><?php get_template_part( 'templates/posts/meta', 'single' ); ?></div>
							</div>
						</div>
						
					</div>
					<div class="span12">
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
					</div>
				</article>
				<?php 
					if( rwmb_meta('malina_post_sticky_sharebox') && function_exists('MalinaStickySharebox') ){
						MalinaStickySharebox(get_the_ID(), true);
					} elseif ( get_theme_mod( 'malina_single_post_sicky_sharebox', false ) && function_exists('MalinaStickySharebox') ){
						MalinaStickySharebox(get_the_ID(), true);
					}
				?>
				
		<?php endwhile; endif; ?>
	</div>
</div>
