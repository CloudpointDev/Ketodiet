<?php

	$prevPost = get_previous_post();
	$nextPost = get_next_post();
	
	if(!empty($prevPost) || !empty($nextPost)) { ?>
	<div id="post-navigation" class="wrapper ">
		
		<div class="prev">
			<?php if(!empty($prevPost)) { $prevURL = get_permalink($prevPost->ID); ?>
			<a class="prev-post-label" href="<?php echo esc_url($prevURL); ?>" >
				<?php if( has_post_thumbnail($prevPost->ID) ){ echo '<figure>'.get_the_post_thumbnail($prevPost->ID, 'thumbnail').'</figure>'; } ?>
				<div class="prev-post-title">
					<span><i class="la la-angle-double-left"></i><?php esc_html_e('Previous post', 'malina'); ?></span>
					<h2><?php echo get_the_title($prevPost->ID); ?></h2>
				</div>
			</a>
			<?php } ?>
		</div>
		
		<div class="next">
			<?php if(!empty($nextPost)) { $nextURL = get_permalink($nextPost->ID); ?>
			<a class="next-post-label" href="<?php echo esc_url($nextURL); ?>">
				<div class="next-post-title">
					<span><?php esc_html_e('Next post', 'malina'); ?><i class="la la-angle-double-right"></i></span>
					<h2><?php echo get_the_title($nextPost->ID); ?></h2>
				</div>
				<?php if( has_post_thumbnail($nextPost->ID) ){ echo '<figure>'.get_the_post_thumbnail($nextPost->ID, 'thumbnail').'</figure>'; } ?>
			</a>
			<?php } ?>
		</div>
		
	</div>
<?php } ?>