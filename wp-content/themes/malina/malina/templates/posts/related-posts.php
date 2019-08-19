<?php
//for use in the loop, list 3 post titles related to first tag on current post
$tags = wp_get_post_categories($post->ID);
if ($tags) {
?>				  
	<?php  
	$args=array(
		'category__in' => $tags,
		'post__not_in' => array($post->ID),
		'showposts'=>3,
		'meta_query' => array(
	        array(
	         'key' => '_thumbnail_id',
	         'compare' => 'EXISTS'
	        ),
	    )
	);
	$my_query = new WP_Query($args);
	$out = '';
	if( $my_query->have_posts() ) {
		$out .='<div id="related-posts" class="aligncenter">';
		$out .= '<h2><span>'. esc_html__('Related posts', 'malina').'</span></h2>';
		$out .= '<div class="row-fluid">';
		while ($my_query->have_posts()) : $my_query->the_post(); 
        $out .= '<div class="related-posts-item span4">';
        if( has_post_thumbnail() ) {
			$out .= '<figure class="post-img"><div class="overlay-bg"></div>'.get_the_post_thumbnail($post->ID, 'medium').'</figure>';
		}
		$out .= '<div class="overlay-data">';
		$out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
		$out .= '<h3 class="related-item-title"><a href="'.esc_url(get_permalink()).'" title="' . esc_attr(the_title_attribute('echo=0')) . '">'.get_the_title().'</a></h3>';
        $out .= '</div>';
        $out .= '</div>';
		endwhile;
		$out .= '<div class="clearfix"></div>';
  		$out .= '</div>';
  		$out .= '</div>';
		echo ''.$out;
		wp_reset_postdata();
		}
	}	
?>