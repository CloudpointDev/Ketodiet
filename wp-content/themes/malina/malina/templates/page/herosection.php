<?php
	$paddings = rwmb_meta('malina_page_herosection_padding');
	if(!empty($paddings)){
		$top = !empty($paddings['top']) ? $paddings['top'].'px' : '0';
		$right = !empty($paddings['right']) ? $paddings['right'].'px' : '0';
		$bottom = !empty($paddings['bottom']) ? $paddings['bottom'].'px' : '0';
		$left = !empty($paddings['left']) ? $paddings['left'].'px' : '0';
		$style = 'style="padding:'.$top.' '.$right.' '.$bottom.' '.$left.';"';
	} else {
		$style = '';
	}
?>
<div id="blog-herosection" <?php echo ''.$style; ?> >
	<div class="bg" >
	<?php
	$out = '';
	$hellotext = rwmb_meta('malina_page_herosection_hellotext') != '' ? rwmb_meta('malina_page_herosection_hellotext') : '';
	if( has_post_thumbnail() ){
		$out .= '<div class="blog-herosection-image">';
		if( $hellotext != '' ){
			$out .= '<div class="herosection_text">'.$hellotext.'</div>';	
		}
		$out .= get_the_post_thumbnail(get_the_ID(), 'full').'</div>';
	}
	$post_ids = rwmb_meta('malina_page_herosection_posts');
	$posts_per_page = rwmb_meta('malina_page_herosection_posts_count');
	$nav = rwmb_meta('malina_page_herosection_nav');
	$slideshow = rwmb_meta('malina_page_herosection_slideshow');

	if(!$nav) {
		$nav = 'true';
	}
	if(!$slideshow){
		$slideshow = 'true';
	}
	$orderby = 'post__in';
	$post_type = 'post';
	if(!is_array($post_ids)){
		$post_ids = trim($post_ids);
		$post_ids = explode(',', $post_ids);
		$post_type = array('post', 'page');
	}
	if(empty($post_ids)){
		$post_ids = array();
		$orderby = 'date';
	}

	$args = array(
	    'post_type' => 'post',
	    'posts_per_page' => $posts_per_page,
		'post__in' => $post_ids,
	    'order'          => 'DESC',
	    'orderby'        => $orderby,
	    'post_status'    => 'publish',
	    'post__not_in' => get_option( 'sticky_posts' ),
	    'meta_query' => array(
	        array(
	         'key' => '_thumbnail_id',
	         'compare' => 'EXISTS'
	        )
	    )
    ); 
    $thumbsize = 'medium';
	query_posts( $args );
	if( have_posts() ) {
		wp_enqueue_script('owl-carousel');
		wp_enqueue_style( 'owl-carousel' );
		$owl_custom = 'jQuery(document).ready(function($){
				"use strict";
				setTimeout(function(){ var owl = $("#recent-posts-slider").owlCarousel(
			    {
			        items: 3,
			        margin: 0,
			        dots: false,
			        nav: '.$nav.',
			        navText: [ \'<i class="la la-arrow-left"></i>\',\'<i class="la la-arrow-right"></i>\' ],
			        autoplay: '.$slideshow.',
			        autoplayTimeout: 6000,
			        responsiveClass:true,
			        loop: false,
			        smartSpeed: 450,
			        autoHeight: false,
			        responsive:{
			            0:{
			                items:1,
			            },
			            480:{
			                items:2,
			            },
			            960:{
			                items:3
			            }
			        },
			        themeClass: "owl-recentposts"';
				    $owl_custom .= '});
					$(window).load(function(){
						owl.trigger(\'refresh.owl.carousel\');
					});
				}, 10);
			});';
		wp_add_inline_script('owl-carousel', $owl_custom);
		$out .= '<div id="recent-posts-slider" class="recent-posts">';
			while ( have_posts() ) {
				the_post();
				$out .= '<div class="recent-post-item">';
					if( has_post_thumbnail() ){
						$out .= '<div class="post-img">'.get_the_post_thumbnail(get_the_ID(), $thumbsize).'</div>';
					}
					$out .= '<div class="post-more">';
						$out .= '<div class="title"><h3><a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.esc_attr(get_the_title()).'</a></h3></div>';
						$out .= '<div class="meta-date"><time datetime="'.esc_attr(date(DATE_W3C)).'">'.get_the_time(get_option('date_format')).'</time></div>';
					$out .= '</div>';
				$out .= '</div>';
			}
		$out .= '</div>';
		echo ''.$out;
	}
	wp_reset_query();
	?>
	</div>
</div>