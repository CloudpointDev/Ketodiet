<div class="clear"></div>
<?php if( get_tags() ) {?><div class="post-meta-tags"><span class="meta-tags"><?php the_tags('<i class="fa fa-tags"></i>',', ', ''); ?></span></div><?php } ?>
<div class="post-meta">
	<?php
		$out = '';
		$out .= '<div class="meta">';
		if( function_exists('getPostLikeLink') && get_theme_mod('malina_single_post_likes', true) ) $out .= '<div class="post-like">'.getPostLikeLink( get_the_ID() ).'</div>';
		if( function_exists('malina_calculate_reading_time') && get_theme_mod('malina_single_post_read_time', true) ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
		if( function_exists('MalinaGetPostViews') && get_theme_mod('malina_single_post_views', true) ) $out .= '<div class="post-view">'.MalinaGetPostViews( get_the_ID() ).'</div>';
		$out .= '</div>';
		if( function_exists('MalinaSharebox') && get_theme_mod('malina_single_post_meta_sharebox', true) ){
			$out .= MalinaSharebox( get_the_ID() );
		}
		echo ''.$out;
	?>
</div>