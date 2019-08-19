<?php
	$post_ids = rwmb_meta('malina_page_herosection_slider_posts');
	$post_count = rwmb_meta('malina_page_herosection_slider_posts_count');
	$slideshow = rwmb_meta('malina_page_herosection_slider_slideshow');
	$loop = rwmb_meta('malina_page_herosection_slider_loop');
	$sliderwidth = rwmb_meta('malina_page_herosection_slider_width');
	$style = rwmb_meta('malina_page_herosection_slider_style');
	$description_style = 'style_1';	
	$paddings = rwmb_meta('malina_page_herosection_padding');
	$slider_height = '';
	$slider_height = rwmb_meta('malina_page_slider_height');
	if( $slider_height != '' ){
		$slider_height = 'height:'.$slider_height.'px;';
	}
	$nav = 'false';
	$overlay = 'true';
	$show_date = rwmb_meta('malina_page_herosection_slider_date');
	$show_readmore = rwmb_meta('malina_page_herosection_slider_readmore');
	$thumbsize = rwmb_meta('malina_page_herosection_slider_image_size');
	if( $thumbsize == '' ){
		$thumbsize = 'large';
	}
	if(!empty($paddings)){
		$top = !empty($paddings['top']) ? $paddings['top'].'px' : '0';
		$right = !empty($paddings['right']) ? $paddings['right'].'px' : '0';
		$bottom = !empty($paddings['bottom']) ? $paddings['bottom'].'px' : '0';
		$left = !empty($paddings['left']) ? $paddings['left'].'px' : '0';
		$padding_css = 'padding:'.$top.' '.$right.' '.$bottom.' '.$left.';';
	} else {
		$padding_css = '';
	}
	if( $style == 'center' ){
		$center = 'true';
		$items = '2';
		$margin = '45';
		$loop = 'true';
		$nav = 'true';
		$centerClass = 'post-slider-center';
		if($sliderwidth == 'container'){
			$margin = '25';
		}
	}elseif( $style == 'center2' ){
		$center = 'true';
		$items = '2';
		$margin = '0';
		$loop = 'true';
		$nav = 'true';
		$overlay = $show_date = 'false';
		$centerClass = 'post-slider-center';
		$description_style = 'style_4';
	} elseif ($style == 'three_per_row') {
		$center = 'false';
		$items = '3';
		$margin = '10';
		if($sliderwidth == 'fullwidth'){
			$margin = '25';
		}
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
		}
	}
	$orderby = 'post__in';
	$post_type = 'post';
	if(!is_array($post_ids)){
		$post_ids = trim($post_ids);
		$post_ids = explode(',', $post_ids);
		$orderby = 'post__in';
		$post_type = array('post', 'page');
	}
	if(empty($post_ids)){
		$post_ids = array();
		$orderby = 'date';
	}
	$args = array(
	    'post_type' => $post_type,
	    'posts_per_page' => $post_count,
		'post__in' => $post_ids,
	    'order' => 'DESC',
	    'orderby' => $orderby,
	    'post_status' => 'publish',
	    'post__not_in' => get_option( 'sticky_posts' ),
	    'meta_query' => array(
	        array(
	         'key' => '_thumbnail_id',
	         'compare' => 'EXISTS'
	        )
	    )
    ); 
    $out = '';
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ) {
		wp_enqueue_script('owl-carousel');
		wp_enqueue_style( 'owl-carousel' );
		$owl_custom = 'jQuery(window).load(function(){
				"use strict";
				setTimeout(function(){var owl = jQuery("#post-slider-blog").owlCarousel(
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
		$out .= '<div id="post-slider-blog" class="owl-carousel post-slider '.$style.' '.$centerClass.' '.$sliderwidth.' post_more_'.$description_style.'" style="'.esc_attr($padding_css).'">';
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
						if( $overlay == 'true' ){
							$out .= '<div class="overlay"></div>';
						}
						$out .= '<img src="'.get_the_post_thumbnail_url($post->ID, $thumbsize).'" style="'.esc_attr($slider_height).'" alt="slider image"></a></figure>';
					}
				$out .= '<div class="post-more '.$description_style.'">';
				$out .= '<div class="post-more-inner">';
					$out .= '<div class="meta-categories">'.get_the_category_list(' ').'</div>';
					$out .= '<h3><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.esc_attr(get_the_title()).'</a></h3>';
					if( $show_date == 'true' ){
						$out .= '<div class="meta-date"><time datetime="'.esc_attr(date(DATE_W3C)).'">'.get_the_time(get_option('date_format')).'</time></div>';
					}
					if( $show_readmore == 'true' ){
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