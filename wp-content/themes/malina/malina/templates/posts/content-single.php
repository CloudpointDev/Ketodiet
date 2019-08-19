<div class="post-content">
	<?php
		malina_single_post_format_content();

		if( get_theme_mod('malina_single_post_title_block', 'above') == 'under' ){
			get_template_part('templates/posts/title', 'block');
		}
	?>
	<div class="post-excerpt">
		<?php the_content(); ?>
	</div>
	<?php wp_link_pages(array('before' =>'<div class="pagination_post aligncenter">', 'after'  =>'</div>', 'pagelink' => '<span>%</span>')); ?>
</div>