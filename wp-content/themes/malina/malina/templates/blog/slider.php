<?php
	$post_ids = get_theme_mod('malina_home_slider_posts','');
	$slideshow = get_theme_mod('malina_home_slider_slideshow','true');
	$loop = get_theme_mod('malina_home_slider_loop','false');
	$sliderwidth = get_theme_mod('malina_home_slider_width', 'fullwidth');
	$style = get_theme_mod('malina_home_slider_style', 'center');
	$description_style = 'style_1';
	$nav = 'false';
	if($loop){
		$loop = 'true';
	} else {
		$loop = 'false';
	}
	$overlay = get_theme_mod('malina_home_slider_overlay', 1);
	$show_date = get_theme_mod('malina_home_slider_show_date', 1);
	$readmore = get_theme_mod('malina_home_slider_readmore', false);
	$meta_categories = get_theme_mod('malina_home_slider_meta_categories', 1);
	$slider_height = get_theme_mod('malina_home_slider_height', '');
	$orderby = get_theme_mod('malina_home_slider_orderby', 'date');
	$slider_height_style = '';
	if($slider_height != ''){
		$slider_height_style = 'height:'.$slider_height.'px;';
	}
	$thumbsize = 'large';
	if( $style == 'center' ){
		$center = 'true';
		$items = '2';
		$margin = '25';
		$loop = 'true';
		$nav = 'true';
		$centerClass = 'post-slider-center';
		if($sliderwidth == 'container'){
			$thumbsize = 'post-thumbnail';
		}
	} elseif( $style == 'center2' ){
		$center = 'true';
		$items = '2';
		$margin = '0';
		$loop = 'true';
		$nav = 'true';
		$overlay = $show_date = 'false';
		$thumbsize = 'malina-masonry';
		$centerClass = 'post-slider-center';
		$description_style = 'style_4';
		if($sliderwidth == 'container'){
			$thumbsize = 'large';
		}

	} elseif ($style == 'three_per_row') {
		$center = 'false';
		$items = '3';
		$margin = '10';
		if($sliderwidth == 'fullwidth'){
			$margin = '25';
			$thumbsize = 'large';
		}
		$thumbsize = 'malina-extra-medium';
		$centerClass = 'slider-three-per-row';
		$description_style = 'style_3';
	} elseif ($style == 'two_per_row') {
		$center = 'false';
		$items = '2';
		$centerClass = '';
		$margin = '25';
		$description_style = 'style_2';
		$overlay = 'false';
		$show_date = 'false';
		if($sliderwidth == 'fullwidth'){
			$centerClass = 'post-slider-fullwidth';
		}
	} else {
		$center = 'false';
		$items = '1';
		$centerClass = '';
		$margin = '0';
		if($sliderwidth == 'fullwidth'){
			$centerClass = 'post-slider-fullwidth';
			$thumbsize = 'malina-fullwidth-slider';
		}
	}
	$args = array(
	    'post_type' => 'post',
	    'posts_per_page' => get_theme_mod('malina_home_slides_count','3'),
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
	if(!is_array($post_ids) && strlen($post_ids) && $post_ids != 'no'){
		$post_ids = trim($post_ids);
		$post_ids = explode(',', $post_ids);
		$args['post__in'] = $post_ids;
		$args['post_type'] = array('post', 'page');
	} elseif( is_array($post_ids) && !empty($post_ids) && !in_array('no', $post_ids)){
		$args['post__in'] = $post_ids;
		$args['post_type'] = array('post', 'page');
	}
	
    $out = '';
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ) {
		wp_enqueue_script('owl-carousel');
		wp_enqueue_style( 'owl-carousel' );
		$owl_custom = 'jQuery(document).ready(function($){
				"use strict";
				setTimeout(function(){var owl = $("#post-slider-blog").owlCarousel(
				    {
				        items: '.$items.',
				        center: '.$center.',
				        margin: '.$margin.',
				        dots: false,
				        nav: '.$nav.',
				        navText: [\'<i class="la la-arrow-left"></i>\',\'<i class="la la-arrow-right"></i>\'],
				        autoplay: '.$slideshow.',
				        responsiveClass:true,
				        loop: '.$loop.',
				        smartSpeed: 450,
				        autoHeight: false,
				        autoWidth:'.$center.',
				        themeClass: "owl-post-slider",';
				    if($style == 'three_per_row'){
				    	$owl_custom .= 'responsive:{
				            0:{
				                items:1,
				            },
				            782:{
				                items:2,
				            },
				            960:{
				                items:3
				            }
				        }';
				    }
				    $owl_custom .= '});
			}, 100);
				
			});';
			wp_add_inline_script('owl-carousel', $owl_custom);
		if($sliderwidth == 'container'){ $out .= '<div id="blog-page-slider" class="container"><div class="span12">'; }
		$out .= '<div id="post-slider-blog" class="owl-carousel post-slider '.$style.' '.$centerClass.' '.$sliderwidth.' post_more_'.$description_style.'">';
		static $post_count = 0;
		while( $the_query->have_posts() ) {
			$the_query->the_post();
			$post_count++;
			if( $the_query->current_post +1 == $the_query->post_count && $the_query->post_count % 2 != 0 ){
				$last = ' last-one';
				$thumbsize = 'large';
			} else {
				$last = '';
			}
			if( $style == 'center2' && $post_count == 1 ){

				$out .= '<div class="post-slider-double-item'.$last.'">';
			}
			$out .= '<div class="post-slider-item">';
				if( has_post_thumbnail() ) {
						$out .= '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">';
						if( $overlay ){
							$out .= '<div class="overlay"></div>';
						}
						$out .= '<img src="'.get_the_post_thumbnail_url($post->ID, $thumbsize).'" style="'.esc_attr($slider_height_style).'" alt="slider-item-image"></a></figure>';
					}
				$out .= '<div class="post-more '.$description_style.'">';
				$out .= '<div class="post-more-inner">';
					if( $meta_categories ){
						$out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
					}
					$out .= '<h3><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.esc_attr(get_the_title()).'</a></h3>';
					if( $show_date ){
						$out .= '<div class="meta-date"><time datetime="'.esc_attr(date(DATE_W3C)).'">'.get_the_time(get_option('date_format')).'</time></div>';
					}
					if( $readmore ){
						$out .= '<a href="'.get_the_permalink().'" class="post-more-button"><span>'.esc_html__('Read more', 'malina').'</span><i class="la la-long-arrow-right"></i></a>';
					}
				$out .= '</div>';
				$out .= '</div>';
			$out .= '</div>';
			if( $style == 'center2' && ( $post_count == 2 || $last == ' last-one' ) ){
				$out .= '</div>';
				$post_count = 0;
			}
		}
		$out .= '</div>';
		if($sliderwidth == 'container' ){ $out .= '</div></div>'; }
		echo ''.$out;
		
	}
	wp_reset_postdata();
?>