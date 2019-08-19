<?php
if( !function_exists('MalinaPostSlider') ){
	function MalinaPostSlider($atts, $content = null){
		wp_enqueue_script('owl-carousel');
		wp_enqueue_style( 'owl-carousel' );
	    extract(shortcode_atts(array(
	    	'slideshow' => true,
	    	'loop' => 'false',
	      	'number_posts' => '3',
	      	'orderby' => 'date',
	      	'order' => 'DESC',
	      	'thumbsize' => 'large',
	      	'description_style' => 'style_1',
	      	'cat_slug' => '',
	      	'post_ids' => '',
	      	'style' => '',
	      	'shadow' => 'true',
	      	'nav' => 'false',
	      	'overlay' => 'true',
	      	'overlay_color' => '',
	      	'show_categories' => 'true',
	      	'show_date' => 'true',
	      	'show_dots' => 'true',
	      	'slider_width' => 'standard'
	    ), $atts));

	    global $post;
		if ( is_front_page() ) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		} else {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}
		if($post_ids != ''){
			$post_ids = str_replace(' ', '', $post_ids);
			$post_ids = explode(',', $post_ids);
		} else {
			$post_ids = array();
		}
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $number_posts,
			'post__in' => $post_ids,
			//'paged' => $paged,
			'order'          => $order,
			'orderby'        => $orderby,
			'post_status'    => 'publish',
			'ignore_sticky_posts' => true,
			'meta_query' => array(
		        array(
		         'key' => '_thumbnail_id',
		         'compare' => 'EXISTS'
		        ),
		    )
		);

		if($cat_slug != '' && $cat_slug != 'all'){
			$str = $cat_slug;
			$arr = explode(',', $str);	  
			$args['tax_query'][] = array(
			  'taxonomy'  => 'category',
			  'field'   => 'slug',
			  'terms'   => $arr
			);
		}
		if($shadow == 'true'){
			$shadow = '';
		} else {
			$shadow = ' disable-shadow';
		}
		
		if( $style == 'center' ){
			$center = $loop = 'true';
			$items = '2';
			$margin = '35';
			$centerClass = 'post-slider-center';

		} elseif( $style == 'center2' ){
			$center = 'true';
			$items = '2';
			$margin = '0';
			$loop = 'true';
			$overlay = $show_date = 'false';
			$thumbsize = 'malina-masonry';
			$centerClass = 'post-slider-center';
			$description_style = 'style_4';

		} elseif ($style == 'three_per_row') {
			$center = 'false';
			$items = '3';
			$margin = '10';
			if($slider_width == 'fullwidth'){
				$margin = '25';
			}
			$centerClass = 'slider-three-per-row';
		} elseif ($style == 'two_per_row') {
			$center = 'false';
			$items = '2';
			$centerClass = '';
			$margin = '25';
			if($slider_width == 'fullwidth'){
				$centerClass = 'post-slider-fullwidth';
			}
		} else {
			$center = 'false';
			$items = '1';
			$centerClass = '';
			$margin = '0';
			if($slider_width == 'fullwidth'){
				$centerClass = 'post-slider-fullwidth';
			}
		}
		if( $overlay == 'true' && $overlay_color !== '' ){
			$overlay_css = 'style="background-color:'.$overlay_color.';"';
		} else {
			$overlay_css = '';
		}
		static $slider_id = 0;
		$out = '';
		$the_query = new WP_Query( $args );
		if( $the_query->have_posts() ) {
			$owl_custom = 'jQuery(document).ready(function($){
				"use strict";
				setTimeout(function(){
					var owl = $("#post-slider-'.++$slider_id.'").owlCarousel(
				    {
				        items: '.$items.',
				        center: '.$center.',
				        margin: '.$margin.',
				        dots: '.$show_dots.',
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
			$out .= '<div id="post-slider-'.$slider_id.'" class="owl-carousel post-slider '.$style.' '.$centerClass.' '.$slider_width.' post_more_'.$description_style.'">';
			static $post_count = 0;
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$post_count++;
				if( $the_query->current_post +1 == $the_query->post_count && $the_query->post_count % 2 != 0 ){
					$last = ' last-one';
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
							$out .= '<div class="overlay" '.$overlay_css.'></div>';
						}
						$out .= get_the_post_thumbnail($post->ID, $thumbsize).'</a></figure>';
					}
					$out .= '<div class="post-more '.$description_style.$shadow.'">';
					$out .= '<div class="post-more-inner">';
						if( $show_categories == 'true' ){
							$out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
						}
						$out .= '<h3><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.esc_attr(get_the_title()).'</a></h3>';
						if( $show_date == 'true' ){
							$out .= '<div class="meta-date"><time datetime="'.esc_attr(date(DATE_W3C)).'">'.get_the_time(get_option('date_format')).'</time></div>';
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
		}
		wp_reset_postdata();
		return $out;
	}
	add_shortcode('post_slider', 'MalinaPostSlider');
}
if( !function_exists('MalinaGridPosts') ){
	function MalinaGridPosts($atts, $content = null){
		extract(shortcode_atts(array(
	      	'num' => '6',
	      	'load_count' => '',
	      	'columns' => 'span4',
	      	'post_style' => 'style_1',
	      	'orderby' => 'date',
	      	'order' => 'DESC',
	      	'cat_slug' => '',
	      	'post_ids' => '',
	      	'post__not_in' => '',
	      	'pagination' => 'false',
	      	'thumbsize'		=> 'post-thumbnail',
	      	'text_align' => 'textcenter',
	      	'excerpt_count'	=> '15',
	      	'display_categories' => 'true',
	      	'display_date' => 'true',
	      	'display_comments' => 'true',
	      	'display_views' => 'true',
	      	'display_likes' => 'true',
	      	'display_read_time' => 'true',
	      	'ignore_featured' => 'true',
	      	'ignore_sticky_posts' => 'false'
	    ), $atts));

	    global $post;
	    global $paged;
		if ( is_front_page() ) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		} else {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}
		if($post_ids != ''){
			$post_ids = str_replace(' ', '', $post_ids);
			if (strpos($post_ids, ',') !== false){
				$post_ids = explode(',', $post_ids);
			} else {
				$post_ids = array($post_ids);
			}
		} else {
			$post_ids = array();
		}
		if($post__not_in != ''){
			$post__not_in = str_replace(' ', '', $post__not_in);
			if (strpos($post__not_in, ',') !== false){
				$post__not_in = explode(',', $post__not_in);
			} else {
				$post__not_in = array($post__not_in);
			}
		} else {
			$post__not_in = array();
		}
		$display_likes = ($display_likes === 'true' || $display_likes=='1');
		$display_views = ($display_views === 'true' || $display_views=='1');
		$display_read_time = ($display_read_time === 'true' || $display_read_time=='1');
		$display_comments = ($display_comments === 'true' || $display_comments=='1');
		$display_date = ($display_date === 'true' || $display_date=='1');
		$display_categories = ($display_categories === 'true' || $display_categories=='1');
		$ignore_sticky_posts = ($ignore_sticky_posts === 'true' || $ignore_sticky_posts=='1');
		$ignore_featured = ($ignore_featured === 'true' || $ignore_featured=='1' );
		$bottom_lines = '';
		if( $load_count == ''){
			$load_count = $num;
		}
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $num,
			'post__in' => $post_ids,
			'post__not_in' => $post__not_in,
			'paged' => $paged,
			'order'          => $order,
			'orderby'        => $orderby,
			'post_status'    => 'publish',	
			'ignore_sticky_posts' => $ignore_sticky_posts
		);
		if($cat_slug != '' && $cat_slug != 'all'){
			$str = str_replace(' ', '', $cat_slug);
			$arr = explode(',', $str);	  
			$args['tax_query'][] = array(
			  'taxonomy'  => 'category',
			  'field'   => 'slug',
			  'terms'   => $arr
			);
			$ignore_sticky_posts = true;
		}

		if($paged != 1 && !$ignore_sticky_posts) {
			$ignore_sticky_posts = true;
			$offset = $load_count + (($paged - 2) * $load_count);
            $args = array(
            	'posts_per_page' => $load_count,
            	'offset' => $offset,
            	'ignore_sticky_posts' => $ignore_sticky_posts
            );
		}
		static $post_section_id = 0;
		$out = '';
		++$post_section_id;
		query_posts( $args );
		if(($post_style == 'style_1' || $post_style == 'style_4') || $pagination == 'true' ){
			if( $post_style == 'style_4' ){
				$masonry = 'masonry';
			} else {
				$masonry = 'fitRows';
			}
			
			wp_enqueue_script('isotope');
			wp_enqueue_script('infinite-scroll');
			wp_enqueue_script('imagesloaded');
				$script = "(function($) {
					var win = $(window);
			    win.load(function(){
			        var isoOptionsBlog = {
	                    itemSelector: '.post',
	                    layoutMode: '".$masonry."',
	                    masonry: {
	                        columnWidth: '.post-size'
	                    },
	                    percentPosition:true,
	                };
			        var gridBlog2 = $('#latest-posts #blog-posts-".$post_section_id."');
			        gridBlog2.isotope(isoOptionsBlog);       
			        win.resize(function(){
			            gridBlog2.isotope('layout');
			        });
			        gridBlog2.infinitescroll({
			            navSelector  : '#pagination.pagination-".$post_section_id."',    // selector for the paged navigation 
			            nextSelector : '#pagination.pagination-".$post_section_id." a.next',  // selector for the NEXT link (to page 2)
			            itemSelector : '#blog-posts-".$post_section_id." .post',     // selector for all items you'll retrieve
			            loading: {
			                finishedMsg: 'No more items to load.',
			                msgText: '<i class=\"fa fa-spinner fa-spin fa-2x\"></i>'
			              },
			            animate      : false,
			            errorCallback: function(){
			                $('a.loadmore').removeClass('active').hide();
			                $('a.loadmore').addClass('hide');
			            },
			            appendCallback: true
			            },  // call Isotope as a callback
			            function( newElements ) {
			                var newElems = $( newElements ); 
			                newElems.imagesLoaded(function(){
			                    gridBlog2.isotope( 'appended', newElems );
			                    gridBlog2.isotope('layout');
			                    $('a.loadmore').removeClass('active');
			                });
			            }
			        );
			        $('a.loadmore').click(function () {
			            $(this).addClass('active');
			            gridBlog2.infinitescroll('retrieve');
			            return false;
			        });
			        setTimeout(function(){ $('.page-loading').fadeOut('fast', function (){});}, 100);
			    });
			    $(window).load(function(){ $(window).unbind('.infscr'); });
			})(jQuery)";
			wp_add_inline_script('isotope', $script);
		}
		if( have_posts() ) {
			$out .= '<div id="latest-posts">';
			$out .= '<div id="blog-posts-'.$post_section_id.'" class="row-fluid blog-posts">';
			while ( have_posts() ) {
				the_post();
				$tmpContent = get_the_content();
				$classes = join(' ', get_post_class($post->ID));
				$classes .= ' post';
				if(!$ignore_sticky_posts && is_sticky()){
					$out .= '<article class="textcenter span12 '.$classes.'">';
						$out .= '<div class="post-block-title">';
							if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
							$out .= '<header class="title">';
							$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
							$out .= '</header>';
						$out .= '</div>';
						$out .= '<div class="post-img-block">';
						$out .= malina_get_post_format_content(false, 'large');
						if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
						$out .= '</div>';	
						$out .= '<div class="post-content">';
							if( malina_post_has_more_link( get_the_ID() ) ){
								$out .= malina_get_the_content();
							} else {
								$out .= MalinaExcerpt($excerpt_count);
							}
							$out .= '</div>';
							$out .= '<div class="post-meta'.$bottom_lines.'">';
								$out .= '<div class="meta">';
									if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
									if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
								$out .= '</div>';
								$out .= '<div class="post-more"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark"><span>'.esc_html__('Read More', 'malina-elements').'</span><i class="la la-long-arrow-right"></i></a></div>';
								$out .= MalinaSharebox( get_the_ID() );
							$out .= '</div>';
					$out .= '</article>';
				} elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') && $post_style == 'style_1' ){
					$classes = str_replace('sticky ', '', $classes);
					$out .= '<article class="post-featured post-size span12 '.$classes.'">';
						$out .= '<div class="post-content-container">';
							$out .= '<div class="post-img-side">';
							$out .= malina_get_post_format_content(false, 'medium');
							if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
							$out .= '</div>';
							$out .= '<div class="post-content-side">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<header class="title">';
								$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
								$out .= '</header>';
							$out .= '<div class="post-content">';
							if( malina_post_has_more_link( get_the_ID() ) ){
								$out .= '<div class="post-excerpt">'.malina_get_the_content().'</div>';
							} else {
								$out .= '<div class="post-excerpt">'.MalinaExcerpt($excerpt_count).'</div>';
							}
							$out .= '</div>';
							if( $display_likes || $display_views ) {
								$out .= '<div class="post-meta footer-meta">';
								if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
								if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';

								$out .= '<div class="post-more"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark"><i class="la la-long-arrow-right"></i></a></div>';
								$out .= '</div>';
							}
							$out .= '</div>';
						$out .= '</div>';
					$out .= '</article>';
				} elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') && ($post_style == 'style_2' || $post_style == 'style_3' || $post_style == 'style_5') ){
					$classes = str_replace('sticky ', '', $classes);
					$out .= '<article class="post-featured post-featured-style2 span12 '.$classes.'">';
						$out .= '<div class="post-content-container '.$text_align.'">';						
						$out .= '<div class="post-content">';
							$out .= '<div class="post-img-block">';
							$out .= malina_get_post_format_content(false, 'large');
							if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
							$out .= '</div>';
							$out .= '<div class="post-title-block">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<header class="title">';
								$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
								$out .= '</header>';
							$out .= '</div>';
						$out .= '</div>';
						$out .= '</div>';
					$out .= '</article>';
				} elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') && $post_style == 'style_4'){
					$classes = str_replace('sticky ', '', $classes);
					$out .= '<article class="post-featured-style4 post-size '.$columns.' '.$classes.'">';
						$out .= '<div class="post-content-container '.$text_align.'">';						
							$out .= '<div class="post-content">';
								$out .= '<div class="post-img-block">';
									$out .= '<div class="meta-over-img">';
									$out .= '<header class="title">';
									if( $display_categories == 'true' ){
										$out .= '<div class="meta-categories">'.get_the_category_list(' ').'</div>';
									}
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '<div class="meta-date"><time datetime="'.get_the_date(DATE_W3C).'">'.get_the_time(get_option('date_format')).'</time></div>';
									$out .= '</header>';
									$out .= '</div>';
									if( has_post_thumbnail() ) {
										$out .= '<figure class="post-img"><a href="'.get_the_permalink().'" rel="bookmark">'.get_the_post_thumbnail($post->ID, 'malina-masonry').'</a></figure>';
									}
								$out .= '</div>';

							$out .= '</div>';
						$out .= '</div>';
					$out .= '</article>';
				} elseif( $post_style == 'style_2' || $post_style == 'style_3' ){
					$classes = str_replace('sticky ', '', $classes);
					if($post_style == 'style_3' ){
						static $i = 0;
						$i++;
						if($i % 2 == 0){
							$post_pos = 'even';
						} else {
							$post_pos = 'odd';
						}
					} else {
						$post_pos = '';
					}
					$out .= '<article class="post-size style_2 '.$post_pos.' span12 '.$classes.'">';
						$out .= '<div class="post-content-container '.$text_align.'">';
							$out .= '<div class="post-img-side">';
							$out .= malina_get_post_format_content(false, $thumbsize);
							if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
							$out .= '</div>';
							$out .= '<div class="post-content-side">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<header class="title">';
								$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
								$out .= '</header>';
							$out .= '<div class="post-content">';
							
							$out .= '<div class="post-excerpt">'.MalinaExcerpt($excerpt_count).'</div>';

							$out .= '</div>';
							if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments)) {
								$out .= '<div class="post-meta footer-meta">';
								if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
								if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
								if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
								if( comments_open() && $display_comments ){
									$out .= '<div class="meta-comment">'.MalinaCommentsNumber( get_the_ID() ).'</div>';
								}
								$out .= '</div>';
							}
							$out .= '</div>';
						$out .= '</div>';
					$out .= '</article>';
				} elseif($post_style == 'style_5') {
					$classes = str_replace('sticky ', '', $classes);
					$out .= '<article class="span12 post-size style_5 '.$text_align.' '.$classes.'">';
						$out .= '<div class="post-content-container">';
							$out .= '<div class="post-img-side">';
							$out .= malina_get_post_format_content(false, $thumbsize);
							if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
							$out .= '</div>';
							$out .= '<div class="post-content-side">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<header class="title">';
								$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
								$out .= '</header>';
							$out .= '<div class="post-content">';
							if( malina_post_has_more_link( get_the_ID() ) ){
								$out .= '<div class="post-excerpt">'.malina_get_the_content().'</div>';
							} else {
								$out .= '<div class="post-excerpt">'.MalinaExcerpt($excerpt_count).'</div>';
							}
							$out .= '</div>';
							if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
								$out .= '<div class="post-meta footer-meta">';
								if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
								if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
								if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
								if( comments_open() && $display_comments ){
									$out .= '<div class="meta-comment">'.MalinaCommentsNumber( get_the_ID() ).'</div>';
								}
								$out .= '<div class="post-more"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark"><i class="la la-long-arrow-right"></i></a></div>';
								$out .= '</div>';
							}
							$out .= '</div>';
						$out .= '</div>';
					$out .= '</article>';
				} else {
					$classes = str_replace('sticky ', '', $classes);
					$out .= '<article class="post-size '.$columns.' '.$post_style.' '.$classes.'">';
						$out .= '<div class="post-content-container '.$text_align.'">';
							$out .= '<div class="post-img-block">';
							$out .= malina_get_post_format_content(false, $thumbsize);
							if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
							$out .= '</div>';
							$out .= '<div class="post-content-block">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<header class="title">';
								$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
								$out .= '</header>';
							$out .= '<div class="post-content">';
							
							$out .= '<div class="post-excerpt">'.MalinaExcerpt($excerpt_count).'</div>';

							$out .= '</div>';
							if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
								$out .= '<div class="post-meta footer-meta">';
								if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
								if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
								if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
								if( comments_open() && $display_comments ){
									$out .= '<div class="meta-comment">'.MalinaCommentsNumber( get_the_ID() ).'</div>';
								}
								$out .= '</div>';
							}
							$out .= '</div>';
						$out .= '</div>';
					$out .= '</article>';
				}

			}
			$out .= '</div>';
			if( $pagination == 'true' && get_next_posts_link() ) {
				$out .= '<div id="pagination" class="hide pagination-'.$post_section_id.'">'.get_next_posts_link().'</div>';
				$out .= '<div class="loadmore-container"><a href="#" class="loadmore button"><span>'.esc_html__('Load More', 'malina-elements').'</span></a></div>';
			} elseif($pagination == 'standard') {
				$out .= '<div id="pagination">'.malina_custom_pagination().'</div>';
			}
			$out .= '</div>';
		}
		
		wp_reset_query();
		return $out;
	}
	add_shortcode('gridposts', 'MalinaGridPosts');
}
if( !function_exists('MalinaCarouselPosts') ){
	function MalinaCarouselPosts($atts, $content = null){
		wp_enqueue_script( 'owl-carousel' );
		wp_enqueue_style( 'owl-carousel' );
	    extract(shortcode_atts(array(
	      	'block_title' => '',
	      	'posts_count' => '3',
	      	'columns' => 'span4',
	      	'orderby' => 'date',
	      	'order' => 'DESC',
	      	'cat_slug' => '',
	      	'post_ids' => '',
	      	'post__not_in' => '',
	      	'thumbsize' => 'medium'
	    ), $atts));

	    global $post;
		if ( is_front_page() ) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		} else {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}
		if($post_ids != ''){
			$post_ids = str_replace(' ', '', $post_ids);
			if (strpos($post_ids, ',') !== false){
				$post_ids = explode(',', $post_ids);
			} else {
				$post_ids = array($post_ids);
			}
		} else {
			$post_ids = array();
		}
		if($post__not_in != ''){
			$post__not_in = str_replace(' ', '', $post__not_in);
			if (strpos($post__not_in, ',') !== false){
				$post__not_in = explode(',', $post__not_in);
			} else {
				$post__not_in = array($post__not_in);
			}
		} else {
			$post__not_in = array();
		}
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $posts_count,
			'post__in' => $post_ids,
			'post__not_in' => $post__not_in,
			//'paged' => $paged,
			'order'          => $order,
			'orderby'        => $orderby,
			'post_status'    => 'publish',
			'ignore_sticky_posts' => true
		);

		if($cat_slug != '' && $cat_slug != 'all'){
			$str = $cat_slug;
			$arr = explode(',', $str);	  
			$args['tax_query'][] = array(
			  'taxonomy'  => 'category',
			  'field'   => 'slug',
			  'terms'   => $arr
			);
		}
		switch ($columns) {
			case 'span6':
				$items = '2';
				break;
			case 'span4':
				$items = '3';
				break;
			case 'span3':
				$items = '4';
				break;
			case 'span2':
				$items = '6';
				break;
			default:
				$items = '5';
				break;
		}
		static $post_section_id = 0;
		$out = '';
		++$post_section_id;
		query_posts( $args );
		if( have_posts() ) {
			if($posts_count > $items){
				$columns = '';
				$owl_custom = 'jQuery(document).ready(function($){
					"use strict";
					setTimeout(function(){ var owl = $("#recent-posts-slider-'.$post_section_id.'").owlCarousel(
				    {
				        items: '.$items.',
				        margin: 0,
				        dots: false,
				        nav: true,
				        navText: [ \'<i class="la la-arrow-left"></i>\',\'<i class="la la-arrow-right"></i>\' ],
				        autoplay: true,
				        responsiveClass:true,
				        loop: false,
				        smartSpeed: 450,
				        autoHeight: false,
				        themeClass: "owl-recentposts"';
					    $owl_custom .= '});
						$(window).load(function(){
							owl.trigger(\'refresh.owl.carousel\');
						});
					}, 10);
				});';
				wp_add_inline_script('owl-carousel', $owl_custom);
			}
			if($block_title != ''){
				$out .= '<div class="block-title title"><h3>'.esc_html($block_title).'</h3></div>'; 
			}
			$out .= '<div id="recent-posts-slider-'.$post_section_id.'" class="recent-posts">';
			while ( have_posts() ) {
				the_post();
				$out .= '<div class="recent-post-item '.$columns.'">';
					if( has_post_thumbnail() ){
						$out .= '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail(get_the_ID(), $thumbsize).'</a></figure>';
					}
					$out .= '<div class="post-more">';
						$out .= '<div class="title"><h3><a href="'.esc_url(get_the_permalink()).'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.esc_attr(get_the_title()).'</a></h3></div>';
						$out .= '<div class="meta-date"><time datetime="'.esc_attr(date(DATE_W3C)).'">'.get_the_time(get_option('date_format')).'</time></div>';
					$out .= '</div>';
				$out .= '</div>';
			}
			$out .= '</div>';
			wp_reset_query();
		}
		return $out;
	}
	add_shortcode('carouselposts', 'MalinaCarouselPosts');
}
if( !function_exists('MalinaRecentPosts') ){
	function MalinaRecentPosts($atts, $content = null){
	    extract(shortcode_atts(array(
	      	'num' => '5',
	      	'orderby' => 'date',
	      	'order' => 'DESC',
	      	'cat_slug' => '',
	      	'post_ids' => '',
	      	'post__not_in' => '',
	      	'pagination' => 'false',
	      	'thumbsize'		=> 'post-thumbnail',
	      	'show_categories' => 'true',
	      	'show_lines' => 'true',
	      	'show_date' => 'true',
	      	'show_sharebox' => 'true',
	      	'show_readmore' => 'true',
	      	'content_size' => 'false',
	      	'ignore_featured' => 'true',
	      	'ignore_sticky_posts' => 'false'
	    ), $atts));

	    global $post;
	    global $paged;
		if ( is_front_page() ) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		} else {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}

		if($post_ids != ''){
			$post_ids = str_replace(' ', '', $post_ids);
			if (strpos($post_ids, ',') !== false){
				$post_ids = explode(',', $post_ids);
			} else {
				$post_ids = array($post_ids);
			}
		} else {
			$post_ids = array();
		}
		if($post__not_in != ''){
			$post__not_in = str_replace(' ', '', $post__not_in);
			if (strpos($post__not_in, ',') !== false){
				$post__not_in = explode(',', $post__not_in);
			} else {
				$post__not_in = array($post__not_in);
			}
		} else {
			$post__not_in = array();
		}
		$ignore_sticky_posts = ($ignore_sticky_posts === 'true');
		$ignore_featured = ($ignore_featured === 'true');
		$content_size = ($content_size === 'true');
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $num,
			'post__in' => $post_ids,
			'post__not_in' => $post__not_in,
			'paged' => $paged,
			'order'          => $order,
			'orderby'        => $orderby,
			'post_status'    => 'publish',	
			'ignore_sticky_posts' => $ignore_sticky_posts
		);
		if($cat_slug != '' && $cat_slug != 'all'){
			$str = str_replace(' ', '', $cat_slug);
			$arr = explode(',', $str);	  
			$args['tax_query'][] = array(
			  'taxonomy'  => 'category',
			  'field'   => 'slug',
			  'terms'   => $arr
			);
			$ignore_sticky_posts = true;
		}

		static $post_section_id = 0;
		$out = '';
		++$post_section_id;
		if( $show_lines == 'false'){
			$bottom_lines = ' disable-lines';
		} else {
			$bottom_lines = '';
		}
		if( ($show_date == 'false' && $show_sharebox == 'false') || ($show_readmore == 'false' && $show_sharebox == 'false') || ($show_date == 'false' && $show_readmore == 'false') ){
			$bottom_lines .= ' justify-center';
		}
		query_posts( $args );
		if( have_posts() ) {
			$out .= '<div id="latest-posts" class="row">';
			while ( have_posts() ) {
				the_post();
				$tmpContent = get_the_content();
				$classes = join(' ', get_post_class($post->ID));
				$classes .=' post';
				if(!$ignore_sticky_posts && is_sticky()){
					$out .= '<article class="style_2 '.$classes.'">';
						$out .= '<div class="post-content-container aligncenter">';
						$out .= malina_get_post_format_content(false, 'post-thumbnail');
						$out .= '<div class="post-content">';
							$out .= '<header class="title">';
							if( $show_categories == 'true' ){
								$out .= '<div class="meta-categories">'.get_the_category_list(' ').'</div>';
							}
							$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
							$out .= '</header>';
							if( malina_post_has_more_link( get_the_ID() ) ){
								$out .= '<div class="post-excerpt">';
								$out .= malina_get_the_content();
								$out .= '</div>';
							}
							$out .= wp_link_pages(array('before' =>'<div class="pagination_post">', 'after'  =>'</div>', 'pagelink' => '<span>%</span>', 'echo' => 0));
							if( !rwmb_get_value( 'malina_display_post_footer') ){
								$out .= '<div class="post-meta'.$bottom_lines.'">';
									if( $show_date == 'true' ){
										$out .= '<div class="meta meta-date">'.get_the_date().'</div>';
									}
									if( $show_readmore == 'true' ){
										$out .= '<div class="post-more"><a href="'.esc_url(get_the_permalink()).'" class="button" rel="bookmark">'.esc_html__('Read more', 'malina-elements').'</a></div>';
									}
									if( $show_sharebox == 'true' ){
										$out .= MalinaSharebox( get_the_ID() );
									}
								$out .= '</div>';
							}
							$out .= '</div>';
						$out .= '</div>';
					$out .= '</article>';
				} elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') && has_post_thumbnail() ){
					$classes = str_replace('sticky ', '', $classes);
					$out .= '<article class="post-featured '.$classes.'">';
						$out .= '<div class="post-content-container aligncenter">';						
						$out .= '<div class="post-content">';
							$out .= '<div class="meta-over-img">';
							if( $show_categories == 'true' ){
								$out .= '<div class="meta-date two-dots"><time datetime="'.date(DATE_W3C).'">'.get_the_time(get_option('date_format')).'</time></div>';
							}

							$out .= '<header class="title">';
							$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
							$out .= '</header>';
							$out .= '</div>';
							if( has_post_thumbnail() ) {
								$out .= '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail($post->ID, 'post-thumbnail').'</a></figure>';
							}
							$out .= wp_link_pages(array('before' =>'<div class="pagination_post">', 'after'  =>'</div>', 'pagelink' => '<span>%</span>', 'echo' => 0));
							$out .= '</div>';
						$out .= '</div>';
					$out .= '</article>';
				} else {
					$classes = str_replace('sticky', '', $classes);
					$out .= '<article class="'.$classes.'">';
						$out .= '<div class="post-content-container aligncenter">';
							$out .= '<header class="title">';
							if( $show_categories == 'true' ){
								$out .= '<div class="meta-categories">'.get_the_category_list(' ').'</div>';
							}
							$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
							$out .= '</header>';
						$out .= '<div class="post-content">';
							$out .= malina_get_post_format_content(false, $thumbsize);
							if( malina_post_has_more_link( get_the_ID() ) ){
								$out .= '<div class="post-excerpt">';
								if($content_size){
									$out .= '<div class="content-size">';
								}
								$out .= malina_get_the_content();
								if($content_size){
									$out .= '</div>';
								}
								$out .= '</div>';
							} else {
								$out .= '<div class="post-excerpt">';
								if($content_size){
									$out .= '<div class="content-size">';
								}
								$out .= get_the_excerpt();
								if($content_size){
									$out .= '</div>';
								}
								$out .= '</div>';
							}
							$out .= wp_link_pages(array('before' =>'<div class="pagination_post">', 'after'  =>'</div>', 'pagelink' => '<span>%</span>', 'echo' => 0));
							$out .= '</div>';
							if( !rwmb_get_value( 'malina_display_post_footer') ){
								$out .= '<div class="post-meta'.$bottom_lines.'">';
									if($content_size){
										$out .= '<div class="content-size">';
									}
									if( $show_date == 'true' ){
										$out .= '<div class="meta meta-date">'.get_the_date().'</div>';
									}
									if( $show_readmore == 'true' ){
										$out .= '<div class="post-more"><a href="'.esc_url(get_the_permalink()).'" class="button" rel="bookmark">'.esc_html__('Read more', 'malina-elements').'</a></div>';
									}
									if( $show_sharebox == 'true' ){
										$out .= MalinaSharebox( get_the_ID() );
									}
									if($content_size){
										$out .= '</div>';
									}
								$out .= '</div>';
							}
						$out .= '</div>';
					$out .= '</article>';
				}
			}
			$out .= '</div>';
		}
		if( $pagination == 'true' ) {
			if(malina_custom_pagination() != '') {
				$out .= '<div id="pagination" class="clearfix">'.malina_custom_pagination().'</div>';
			}
		}
		wp_reset_query();
		return $out;
	}
	add_shortcode('recentposts', 'MalinaRecentPosts');
}
if( !function_exists('MalinaSinglePosts') ){
	function MalinaSinglePosts($atts, $content = null){
	    extract(shortcode_atts(array(
	      	'post_ids' => '',
	      	'thumbsize' => 'post-thumbnail',
	      	'show_categories' => 'true'
	    ), $atts));

	    global $post;

		if($post_ids != ''){
			$post_ids = str_replace(' ', '', $post_ids);
			if (strpos($post_ids, ',') !== false){
				$post_ids = explode(',', $post_ids);
			} else {
				$post_ids = array($post_ids);
			}
		} else {
			$post_ids = array();
		}

		$show_categories = ($show_categories === 'true' || $show_categories == '1' );
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 1,
			'post__in' => $post_ids,
			'post_status'    => 'publish',	
			'ignore_sticky_posts' => true
		);

		$out = '';
		query_posts( $args );
		if( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				$tmpContent = get_the_content();
				$classes = join(' ', get_post_class($post->ID));
				$classes = str_replace('sticky ', '', $classes);
				$classes .= ' post';
				$out .= '<article class="single-post '.$classes.'">';
					$out .= '<div class="post-content-container aligncenter">';						
					$out .= '<div class="post-content">';
						$out .= '<div class="meta-over-img">';
						$out .= '<header class="title">';
						if( $show_categories == 'true' ){
							$out .= '<div class="meta-categories">'.get_the_category_list(' ').'</div>';
						}
						$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
						$out .= '</header>';
						$out .= '</div>';
						$out .= malina_get_post_format_content(false, $thumbsize);
						$out .= wp_link_pages(array('before' =>'<div class="pagination_post">', 'after'  =>'</div>', 'pagelink' => '<span>%</span>', 'echo' => 0));
						$out .= '</div>';
					$out .= '</div>';
				$out .= '</article>';
			}
		}
		if($paged > 1) {
			$out = '';
		}
		wp_reset_query();
		return $out;
	}
	add_shortcode('singlepost', 'MalinaSinglePosts');
}
if( !function_exists('MalinaListPosts') ){
	function MalinaListPosts($atts, $content = null){
		extract(shortcode_atts(array(
	      	'num' => '6',
	      	'orderby' => 'date',
	      	'order' => 'DESC',
	      	'cat_slug' => '',
	      	'post_ids' => '',
	      	'post__not_in' => '',
	      	'pagination' => 'false',
	      	'thumbsize'	=> 'post-thumbnail',
	      	'display_date' => 'true',
	      	'display_categories' => 'true',
	      	'display_likes' => 'true',
	      	'display_comments' => 'false',
	      	'display_views' => 'true',
	      	'display_read_time' => 'true',
	      	'display_readmore' => 'false',
	      	'excerpt_count'	=> '32',
	      	'ignore_featured' => 'false',
	      	'ignore_sticky_posts' => 'false'
	    ), $atts));

	    global $post;
	    global $paged;
		if ( is_front_page() ) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		} else {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}
		if($post_ids != ''){
			$post_ids = str_replace(' ', '', $post_ids);
			if (strpos($post_ids, ',') !== false){
				$post_ids = explode(',', $post_ids);
			} else {
				$post_ids = array($post_ids);
			}
		} else {
			$post_ids = array();
		}
		if($post__not_in != ''){
			$post__not_in = str_replace(' ', '', $post__not_in);
			if (strpos($post__not_in, ',') !== false){
				$post__not_in = explode(',', $post__not_in);
			} else {
				$post__not_in = array($post__not_in);
			}
		} else {
			$post__not_in = array();
		}
		$display_likes = ($display_likes === 'true');
		$display_views = ($display_views === 'true');
		$display_read_time = ($display_read_time === 'true');
		$display_comments = ($display_comments === 'true');
		$display_readmore = ($display_readmore === 'true');
		$display_date = ($display_date === 'true');
		$display_categories = ($display_categories === 'true');
		$ignore_sticky_posts = ($ignore_sticky_posts === 'true');
		$ignore_featured = ($ignore_featured === 'true');
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $num,
			'post__in' => $post_ids,
			'post__not_in' => $post__not_in,
			'paged' => $paged,
			'order'          => $order,
			'orderby'        => $orderby,
			'post_status'    => 'publish',	
			'ignore_sticky_posts' => $ignore_sticky_posts
		);
		if($paged != 1) {
			$ignore_sticky_posts = true;
			$offset = $num + (($paged - 2) * $num);
            $args = array(
            	'posts_per_page' => $num,
            	'offset' => $offset,
            	'ignore_sticky_posts' => $ignore_sticky_posts
            );
		}
		if($cat_slug != '' && $cat_slug != 'all'){
			$str = str_replace(' ', '', $cat_slug);
			$arr = explode(',', $str);	  
			$args['tax_query'][] = array(
			  'taxonomy'  => 'category',
			  'field'   => 'slug',
			  'terms'   => $arr
			);
			$ignore_sticky_posts = true;
		}

		$out = '';
		query_posts( $args );
		if( have_posts() ) {
			$out .= '<div id="latest-list-posts">';
			while ( have_posts() ) {
				the_post();
				$tmpContent = get_the_content();
				$classes = join(' ', get_post_class($post->ID));
				$classes .= ' post';
				if(!$ignore_sticky_posts && is_sticky()){
					$out .= '<article class="'.$classes.'">';
						$out .= '<div class="post-block-title">';
							if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
							$out .= '<header class="title">';
							$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
							$out .= '</header>';
						$out .= '</div>';
						$out .= '<div class="post-img-block">';
						$out .= malina_get_post_format_content(false, 'malina-slider');
						if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
						$out .= '</div>';	
						$out .= '<div class="post-content">';
							if( malina_post_has_more_link( get_the_ID() ) ){
								$out .= malina_get_the_content();
							} else {
								$out .= MalinaExcerpt($excerpt_count);
							}
							$out .= '</div>';
							$out .= '<div class="post-meta'.$bottom_lines.'">';
								$out .= '<div class="meta">';
									if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
									if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
								$out .= '</div>';
								if( $display_readmore ){
									$out .= '<div class="post-more"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark"><i class="la la-long-arrow-right"></i></a></div>';
								}
								$out .= MalinaSharebox( get_the_ID() );
							$out .= '</div>';
					$out .= '</article>';
				} elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') ){
					$classes = str_replace('sticky ', '', $classes);
					$out .= '<article class="post-featured '.$classes.'">';
						$out .= '<div class="post-content-container aligncenter">';						
						$out .= '<div class="post-content">';
							$out .= '<div class="post-img-block">';
							$out .= malina_get_post_format_content(false, 'malina-slider');
							if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
							$out .= '</div>';
							$out .= '<div class="post-title-block">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<header class="title">';
								$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
								$out .= '</header>';
							$out .= '</div>';
						$out .= '</div>';
						$out .= '</div>';
					$out .= '</article>';
				} else {
					$classes = str_replace('sticky ', '', $classes);
					$out .= '<article class="'.$classes.'">';
						$out .= '<div class="post-content-container">';
							$out .= '<div class="post-img-side">';
							$out .= malina_get_post_format_content(false, $thumbsize);
							if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
							$out .= '</div>';
							$out .= '<div class="post-content-side">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<header class="title">';
								$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
								$out .= '</header>';
							$out .= '<div class="post-content">';
							if( malina_post_has_more_link( get_the_ID() ) ){
								$out .= '<div class="post-excerpt">'.malina_get_the_content().'</div>';
							} else {
								$out .= '<div class="post-excerpt">'.MalinaExcerpt($excerpt_count).'</div>';
							}
							$out .= '</div>';
							if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) || $display_readmore ) {
								$out .= '<div class="post-meta footer-meta">';
								if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
								if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
								if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
								if( comments_open() && $display_comments ){
									$out .= '<div class="meta-comment">'.MalinaCommentsNumber( get_the_ID() ).'</div>';
								}
								if( $display_readmore ){
									$out .= '<div class="post-more"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark"><i class="la la-long-arrow-right"></i></a></div>';
								}
								$out .= '</div>';
							}
							$out .= '</div>';
						$out .= '</div>';
					$out .= '</article>';
				}
			}
			$out .= '</div>';
			if( $pagination == 'true' && get_next_posts_link() ) {
				$out .= '<div id="pagination" class="textleft">'.malina_custom_pagination().'</div>';
			}
		}
		wp_reset_query();
		return $out;
	}
	add_shortcode('listposts', 'MalinaListPosts');
}
if( !function_exists('MalinaAuthorInfo') ){
	function MalinaAuthorInfo( $atts, $content = null){
		extract(
			shortcode_atts( array(
				'username' => ''
				), $atts
			)
		);
		global $post;
		$out = '';
		if( $username == '' ){
			$userID = get_current_user_id();
		} else {
			$userInfo = get_user_by('login', $username);
			$userID = $userInfo->ID;
		}
		// retrieve our additional author meta info
		$user_meta_image = esc_attr( get_the_author_meta( 'user_meta_image', $userID ) );
		// make sure the field is set
		if ( isset( $user_meta_image ) && $user_meta_image ) {
		    // only display if function exists
		    if ( function_exists( 'malina_get_additional_user_meta_thumb' ) )
		        $userImage = '<img alt="'.esc_html__('author photo', 'malina-elements').'" src="'.esc_url(malina_get_additional_user_meta_thumb($userID, 'medium')).'" />';
		} else {
			$userImage = '<img alt="'.esc_html__('author photo', 'malina-elements').'" src="https://placeholdit.imgix.net/~text?txtsize=24&txt=User+Image&w=252&h=225&txttrack=0" />';
		}
		$out .= '<div class="author-info-shortcode row-fluid">';
		$out .= '<div class="author-image span4">'.$userImage.'</div>';
		$out .= '<div class="author-description span8">';
		$out .= '<h2 class="author-title ">'.esc_attr(get_the_author_meta( 'first_name', $userID )).' '.esc_attr(get_the_author_meta( 'last_name', $userID )).'</h2>';
		$out .= '<p>'.get_the_author_meta( 'description', $userID ).'</p>';
		$out .= '<div class="author-email"><a href="mailto:'.esc_attr(get_the_author_meta( 'user_email', $userID )).'">'.esc_attr(get_the_author_meta( 'user_email', $userID )).'</a></div>';
		$out .= '</div>';
		$out .= '</div>';

		return $out;
	}
	add_shortcode('malinauser', 'MalinaAuthorInfo');
}

if( !function_exists('MalinaCategory') ){
	function MalinaCategory( $atts, $content = null){
		$suf = rand(0, 9999);
		extract(
			shortcode_atts( array(
				'id' => $suf,
				'category' => '',
				'button_label' => '',
				'bg_image_id' => '',
				'button_url' => '',
				'category_button_border_color' => '',
				'category_button_bg_color' => '',
				'category_button_text_color' => '',
				), $atts
			)
		);
		$out = '';
		$catObj = get_category_by_slug( $category );
		
        if(!empty($catObj)){
        	$style = '';
        	if($button_label == '') {
        		$category_label = $catObj->name;
        	} else {
        		$category_label = $button_label;
        	}
        	if( $button_url != '' ){
        		$category_url = esc_url( $button_url );
        	} else {
	        	$category_url = get_category_link($catObj->term_id);
	        }

			$imageSrc = wp_get_attachment_image_url($bg_image_id, 'medium');

			if($category_button_border_color !== ''){
				$style .= '.category-block-'.$id.'.category-block .category-button { border-color:'.$category_button_border_color.'; }';
			}
			if($category_button_bg_color !== ''){
				$style .= '.category-block-'.$id.'.category-block .category-button {background-color:'.$category_button_bg_color.'}';
			}
			if($category_button_text_color !== ''){
				$style .= '.category-block-'.$id.'.category-block .category-button {color:'.$category_button_text_color.';}';
			}
			
			if( $style !== '' ){
				wp_register_style( 'malina-shortcodes-style', false );
				wp_enqueue_style( 'malina-shortcodes-style' );
				wp_add_inline_style('malina-shortcodes-style', $style);
			}
			$out .= '<div class="category-block-'.$id.' category-block">';
			if($imageSrc){
				$out .= '<div class="category-img"><img src="'.esc_url($imageSrc).'" alt="category-image"></div>';
			}
			$out .= '<a href="'.esc_url($category_url).'" class="button category-button">'.esc_attr($category_label).'</a>';
			$out .= '</div>';
        }

		return $out;
	}
	add_shortcode('malinacategory', 'MalinaCategory');
}
if( !function_exists('MalinaFooter') ){
	function MalinaFooter( $atts, $content = null){
		extract(
			shortcode_atts( array(
				'bg_color' => '',
				), $atts
			)
		);
		global $wp_widget_factory;
		$out = '';
		if( get_theme_mod('malina_footer_instagram_access_token', '') != '' && rwmb_get_value('malina_display_instagram') != 'disable') {
			$out .= '<div id="before-footer" style="background-color:'.$bg_color.'">';
			$hide_items = $hide_link = false;
			if(rwmb_get_value('malina_display_instagram') == 'disable-items') {
				$hide_items = true;
			}
			if(rwmb_get_value('malina_display_instagram') == 'disable-link'){
				$hide_link = true;
			}
			ob_start();
			the_widget( 'widget_instagram', array('title'=>'', 'hide_items' => $hide_items, 'hide_link' => $hide_link, 'access_token'=>get_theme_mod('malina_footer_instagram_access_token', ''), 'pics'=>'6', 'pics_per_row'=>'6'));
			$out .= ob_get_contents();
			ob_end_clean();
			$out .= '</div>';
		}
		if($bg_color != ''){
			$style = '#footer, #before-footer {background-color:'.$bg_color.';}';
			wp_add_inline_style('malina-responsive', $style);
		}
		if( get_theme_mod('malina_footer_copyright', '') != '' || get_theme_mod('malina_footer_socials', true) ) {
			$out .= '<footer id="footer" style="background-color:'.$bg_color.'">';
				$out .= '<div class="container">';
					$out .= '<div class="span4">';
					if( get_theme_mod('malina_footer_copyright', '') != '' ) {
						$out .= '<div id="footer-copy-block">';
							$out .= '<div class="copyright-text">'.get_theme_mod('malina_footer_copyright', '').'</div>';
						$out .= '</div>';
					}	
					$out .= '</div>';
					$out .= '<div class="span4"></div>';
					$out .= '<div class="span4">';
						if( get_theme_mod('malina_footer_socials', true) && function_exists('malina_get_social_links') ) { 
							$out .= malina_get_social_links(false);
						}
					$out .= '</div>';	
				$out .= '</div>';
			$out .= '</footer>';
		}

	return $out;
	}
	add_shortcode('malinafooter', 'MalinaFooter');
}
if(!function_exists('MalinaSocials')){
	function MalinaSocials( $atts, $content = null) {
		$suf = rand(0, 9999);
	extract( shortcode_atts( array(
        'twitter'   => '',
        'forrst'  => '',
        'dribbble'  => '',
        'flickr'    => '',
        'facebook'  => '',
        'skype'   => '',
        'digg'  => '',
        'google_plus'  => '',
        'linkedin'  => '',
        'vimeo'  => '',
        'instagram' => '',
        'yahoo'  => '',
        'tumblr'  => '',
        'youtube'  => '',
        'picasa'  => '',
        'deviantart'  => '',
        'behance'  => '',
        'pinterest'  => '',
        'paypal'  => '',
        'delicious'  => '',
        'rss'  => '',
        'style' => 'simple',
        'icons_align' => 'textcenter',
        'bg_color' => '',
        'icon_color' => '',
        'icon_color_hover' => '',
        'text_color' => '',
        'id' => $suf
        ), $atts ) );
		$css = '';
		if( $bg_color !== '' ){
			$css .= '.social-icons.big_icon_text'.$id.' li a, .social-icons.simple'.$id.' li a {background-color:'.$bg_color.';}';
		}
		if( $icon_color !== '' ){
			$css .= '.social-icons.big_icon_text'.$id.' li a, .social-icons.simple'.$id.' li a {color:'.$icon_color.';}';
		}
		if( $icon_color_hover !== '' ){
			$css .= '.social-icons.big_icon_text'.$id.' li a:hover, .social-icons.simple'.$id.' li a:hover {color:'.$icon_color_hover.';}';
		}
		if( $text_color !== '' ){
			$css .= '.social-icons.big_icon_text'.$id.' li span {color:'.$bg_color.';}';
		}
		if( $css != '' ){
			wp_register_style( 'malina-shortcodes-style', false );
			wp_enqueue_style( 'malina-shortcodes-style' );
			wp_add_inline_style('malina-shortcodes-style', $css);
		}
        $out = '<div class="social-icons '.$icons_align.' '.$style.' '.$style.$id.'"><ul class="unstyled">';
		foreach ($atts as $key => $value) {
			switch ($key) {
				case 'twitter':
					if($twitter != "") {
					  $out .= '<li class="social-twitter"><a href="'.esc_url($twitter).'" target="_blank" title="'.esc_html__( 'Twitter', 'malina-elements').'"><i class="fa fa-twitter"></i></a><span>'.esc_html__( 'Twitter', 'malina-elements').'</span></li>';
					}
					break;
				case 'facebook':
					if($facebook != "") {
					  $out .= '<li class="social-facebook"><a href="'.esc_url($facebook).'" target="_blank" title="'.esc_html__( 'Facebook', 'malina-elements').'"><i class="fa fa-facebook"></i></a><span>'.esc_html__( 'Facebook', 'malina-elements').'</span></li>';
					}
				case 'forrst':
					if($forrst != "") {
					  $out .= '<li class="social-forrst"><a href="'.esc_url($forrst).'" target="_blank" title="'.esc_html__( 'Forrst', 'malina-elements').'"><i class="fa icon-forrst"></i></a><span>'.esc_html__( 'Forrst', 'malina-elements').'</span></li>';
					}
					break;
				case 'yahoo':
					if($yahoo != "") {
					  $out .= '<li class="social-yahoo"><a href="'.esc_url($yahoo).'" target="_blank" title="'.esc_html__( 'Yahoo', 'malina-elements').'"><i class="fa fa-yahoo"></i></a><span>'.esc_html__( 'Yahoo', 'malina-elements').'</span></li>';
					}
					break;
				case 'vimeo':
					if($vimeo != "") {
					  $out .= '<li class="social-vimeo"><a href="'.esc_url($vimeo).'" target="_blank" title="'.esc_html__( 'Vimeo', 'malina-elements').'"><i class="fa fa-vimeo-square"></i></a><span>'.esc_html__( 'Vimeo', 'malina-elements').'</span></li>';
					}
					break;
				case 'linkedin':
					if($linkedin != "") {
					  $out .= '<li class="social-linkedin"><a href="'.esc_url($linkedin).'" target="_blank" title="'.esc_html__( 'LinkedIn', 'malina-elements').'"><i class="fa fa-linkedin"></i></a><span>'.esc_html__( 'LinkedIn', 'malina-elements').'</span></li>';
					}
					break;
				case 'google_plus':
					if($google_plus != "") {
						$out .= '<li class="social-googleplus"><a href="'.esc_url($google_plus).'" target="_blank" title="'.esc_html__( 'Google plus', 'malina-elements').'"><i class="fa fa-google-plus"></i></a><span>'.esc_html__( 'Google plus', 'malina-elements').'</span></li>';
					}
					break;
				case 'instagram':
					if($instagram != '') {
						$out .= '<li class="social-instagram"><a href="' .esc_url($instagram). '" target="_blank" title="'.esc_html__( 'Instagram', 'malina-elements').'"><i class="fa fa-instagram"></i></a><span>'.esc_html__( 'Instagram', 'malina-elements').'</span></li>';
					}
					break;  
				case 'digg':
					if($digg != "") {
						$out .= '<li class="social-digg"><a href="'.esc_url($digg).'" target="_blank" title="'.esc_html__( 'Digg', 'malina-elements').'"><i class="fa fa-digg"></i></a><span>'.esc_html__( 'Digg', 'malina-elements').'</span></li>';
					}
					break;
				case 'skype':
					if($skype != "") {
						$out .= '<li class="social-skype"><a href="skype:'.$skype.'?call" title="'.esc_html__( 'Skype', 'malina-elements').'"><i class="fa fa-skype"></i></a><span>'.esc_html__( 'Skype', 'malina-elements').'</span></li>';
					}
					break;
				case 'flickr':
					if($flickr != "") { 
						$out .= '<li class="social-flickr"><a href="'.esc_url($flickr).'" target="_blank" title="'.esc_html__( 'Flickr', 'malina-elements').'"><i class="fa fa-flickr"></i></a><span>'.esc_html__( 'Flickr', 'malina-elements').'</span></li>';
					}
					break;
				case 'dribbble':
					if($dribbble != "") {
						$out .= '<li class="social-dribbble"><a href="'.esc_url($dribbble).'" target="_blank" title="'.esc_html__( 'Dribbble', 'malina-elements').'"><i class="fa fa-dribbble"></i></a><span>'.esc_html__( 'Dribbble', 'malina-elements').'</span></li>';
					}
					break;
				case 'tumblr':
					if($tumblr != "") {
						$out .= '<li class="social-tumblr"><a href="'.esc_url($tumblr).'" target="_blank" title="'.esc_html__( 'Tumblr', 'malina-elements').'"><i class="fa fa-tumblr"></i></a><span>'.esc_html__( 'Tumblr', 'malina-elements').'</span></li>';
					}
				break;
				case 'youtube':
					if($youtube != "") {
						$out .= '<li class="social-youtube"><a href="'.esc_url($youtube).'" target="_blank" title="'.esc_html__( 'YouTube', 'malina-elements').'"><i class="fa fa-youtube"></i></a><span>'.esc_html__( 'YouTube', 'malina-elements').'</span></li>';
					}
					break;
				case 'picasa':
					if($picasa != "") {
						$out .= '<li class="social-picasa"><a href="'.esc_url($picasa).'" target="_blank" title="'.esc_html__( 'Picasa', 'malina-elements').'"><i class="fa fa-picasa"></i></a><span>'.esc_html__( 'Picasa', 'malina-elements').'</span></li>';
					}
					break;
				case 'deviantart':
					if($deviantart != "") {
						$out .= '<li class="social-deviantart"><a href="'.esc_url($deviantart).'" target="_blank" title="'.esc_html__( 'DeviantArt', 'malina-elements').'"><i class="fa fa-deviantart"></i></a><span>'.esc_html__( 'DeviantArt', 'malina-elements').'</span></li>';
					}
					break;
				case 'behance':
					if($behance != "") {
						$out .= '<li class="social-behance"><a href="'.esc_url($behance).'" target="_blank" title="'.esc_html__( 'Behance', 'malina-elements').'"><i class="fa fa-behance"></i></a><span>'.esc_html__( 'Behance', 'malina-elements').'</span></li>';
					}
					break;
				case 'pinterest':
					if($pinterest != "") {
						$out .= '<li class="social-pinterest"><a href="'.esc_url($pinterest).'" target="_blank" title="'.esc_html__( 'Pinterest', 'malina-elements').'"><i class="fa fa-pinterest-p"></i></a><span>'.esc_html__( 'Pinterest', 'malina-elements').'</span></li>';
					}
					break;
				case 'paypal':
					if($paypal != "") {
						$out .= '<li class="social-paypal"><a href="'.esc_url($paypal).'" target="_blank" title="'.esc_html__( 'PayPal', 'malina-elements').'"><i class="fa fa-paypal"></i></a><span>'.esc_html__( 'PayPal', 'malina-elements').'</span></li>';
					}
					break;
				case 'delicious':
					if($delicious != "") {
						$out .= '<li class="social-delicious"><a href="'.esc_url($delicious).'" target="_blank" title="'.esc_html__( 'Delicious', 'malina-elements').'"><i class="fa fa-delicious"></i></a><span>'.esc_html__( 'Delicious', 'malina-elements').'</span></li>';
					}
					break;
				case 'rss':
				    if($rss != "") {
				      $out .= '<li class="social-rss"><a href="'.esc_url($rss).'" target="_blank" title="'.esc_html__( 'RSS', 'malina-elements').'"><i class="fa fa-rss"></i></a><span>'.esc_html__( 'RSS', 'malina-elements').'</span></li>';
				    }
				    break;
				default:
				# code...
				break;
			}
		}
		$out .= '</ul></div>';
        return $out;
	}
	add_shortcode('malinasocials', 'MalinaSocials');
}
if(!function_exists('MalinaInstagramPost')){
	function MalinaInstagramPost($atts, $content = null) {
		extract( shortcode_atts( array(
	        'media_url' => ''
        ), $atts ) );
        $api = wp_remote_get("http://api.instagram.com/oembed?url=".$media_url);   
		$apiObj = json_decode($api['body'],true);
		if ( !isset($apiObj['author_name']) ) {
	        // error handling
	        $out = esc_html__("Something went wrong: please, check your media url", 'malina-elements');

	    } else {
	    	$author_name = $apiObj['author_name'];
			$author_url = $apiObj['author_url'];
			$matches = explode('/p/', $media_url); 
			$matches = explode('/', $matches[1]);
			$media_id = $matches[0]; 
			if(strlen($media_id) < 9 ) {
				$media_id = 'BN6ni5KA7sj';
			}
	        $out = '<div class="instagram-item-post">
					<a href="'.esc_attr($media_url).'" target="_blank">
						<figure class="image instagram-image">
							<img src="https://instagram.com/p/'.esc_attr($media_id).'/media/?size=l">
						</figure>
					</a>
					<div class="instagram-meta">
						<div class="instagram-logo">
							<a href="'.esc_url($author_url).'" target="_blank">
								<i class="fa fa-instagram"></i>
								<span class="name">@'.$author_name.'</span>
							</a>
						</div>
						<a href="'.esc_attr($media_url).'" target="_blank">
						<div class="instagram-stats">
							<i class="fa fa-heart"></i>
						</div>
						</a>
					</div>
				</div>';
	    }
		return $out;
	}
	add_shortcode('malinainstapost', 'MalinaInstagramPost');
}
if(!function_exists('MalinaInstagram')){
	function MalinaInstagram($atts, $content = null) {
		extract( shortcode_atts( array(
			'title'=>'',
			'hide_link' => '',
			'access_token'=>'',
			'pics'=>'4',
			'pics_per_row'=>'4'
		), $atts ) );
		global $wp_widget_factory;
        $out = '';
        $out .= '<div class="malina-shortcode-instagram">';
        if( $title != '' ){
        	$out .= '<h3 class="insta-shortcode-title"><i class="fa fa-instagram"></i> '.$title.'</h3>';
        }
        ob_start();
		the_widget( 'malina_widget_instagram', array('title'=>'', 'hide_items' => false, 'hide_link' => $hide_link, 'access_token'=> $access_token, 'pics'=> $pics, 'pics_per_row'=> $pics_per_row));
		$out .= ob_get_contents();
		ob_end_clean();
		$out .= '</div>';
		return $out;
	}
	add_shortcode('malinainstagram', 'MalinaInstagram');
}
if(!function_exists('MalinaGoogleMap')){
	function MalinaGoogleMap($atts, $content = null) {
		extract( shortcode_atts( array(
	        'address' => 'Ontario, CA, USA',
	        'style' => 'style1',
	        'marker_icon' => '',
	        'map_height' => ''
        ), $atts ) );
        $out = '';
        if($address == ''){
        	return;
        }
        if($marker_icon != ''){
        	$marker_icon = wp_get_attachment_image_url($marker_icon, 'full');
        	$icon = 'icon:"'.esc_url($marker_icon).'",';
        } else {
        	$icon = '';
        }
        if($map_height != ''){
        	$map_height_style = 'style="height:'.$map_height.'px"';
        } else {
        	$map_height_style = '';
        }
        switch ($style) {
        	case 'style2':
        		$style_data = '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]';
        		break;
        	case 'style3':
        		$style_data = '[{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"visibility":"on"}]},{"featureType":"administrative","elementType":"labels","stylers":[{"visibility":"on"},{"color":"#716464"},{"weight":"0.01"}]},{"featureType":"administrative.country","elementType":"labels","stylers":[{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape.natural.landcover","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"geometry.stroke","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"visibility":"simplified"}]},{"featureType":"poi.attraction","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"simplified"},{"color":"#a05519"},{"saturation":"-13"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"simplified"},{"color":"#84afa3"},{"lightness":52}]},{"featureType":"water","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"visibility":"on"}]}]';
        		break;
        	case 'style4':
        		$style_data = '[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]';
        		break;
        	default:
        		$style_data = '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]';
        		break;
        }
        $out .= '<div class="map-container" '.$map_height_style.'><div id="map"></div></div>';
        $out .= '<script type="text/javascript">
			var map;
			function initMap() {
			  var styles = '.$style_data.';
			  map = new google.maps.Map(document.getElementById(\'map\'), {
			    center: {
			    	lat: -34.397, 
			    	lng: 150.644
			    },
			    zoom: 10,
			    navigationControl:!1,
			    mapTypeControl:!1,
			    scaleControl:!1,
			    streetViewControl:!1,
			    disableDefaultUI: true
			  });
			  map.setOptions({styles: styles});
				var address = "'.$address.'";
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode({
				  \'address\': address
				}, 
				function(results, status) {
				  if(status == google.maps.GeocoderStatus.OK) {
				     new google.maps.Marker({
				        position: results[0].geometry.location,
				        '.$icon.'
				        map: map
				     });
				     map.setCenter(results[0].geometry.location);
				  }
				});
			}
    	</script>
    	<script src="https://maps.googleapis.com/maps/api/js?key='.get_theme_mod('malina_google_map_api_key','AIzaSyBfbDATAIBSQEUY0YzOEjzcB8A1W2FNKSQ').'&libraries=places,geometry&callback=initMap&v=weekly"></script>';

		return $out;
	}
	add_shortcode('malinagooglemap', 'MalinaGoogleMap');
}
if(!function_exists('MalinaPageTitle')){
	function MalinaPageTitle($atts, $content = null) {
		extract( shortcode_atts( array(
	        'title_text' => ''
        ), $atts ) );
        if($title_text == ''){
        	$title_text = get_the_title() ? get_the_title() : esc_html__('Enter your title text','malina-elements');
        }
        $out = '';
        $out .= '<div class="before-content">';
			$out .= '<div class="container">';
				$out .= '<div class="span12">';
        			$out .= '<header class="title"><h2>'.esc_html($title_text).'</h2></header>';
        $out .= '</div></div></div>';
		return $out;
	}
	add_shortcode('malinapagetitle', 'MalinaPageTitle');
}

function malinaGetFontsData( $fontsString ) {   
 
    // Font data Extraction
    $googleFontsParam = new Vc_Google_Fonts();      
    $fieldSettings = array();
    $fontsData = strlen( $fontsString ) > 0 ? $googleFontsParam->_vc_google_fonts_parse_attributes( $fieldSettings, $fontsString ) : '';
    return $fontsData;
     
}
 
// Build the inline style starting from the data
function malinaGoogleFontsStyles( $fontsData ) {
     
    // Inline styles
    $fontFamily = explode( ':', $fontsData['values']['font_family'] );
    $styles[] = 'font-family:' . $fontFamily[0];
    $fontStyles = explode( ':', $fontsData['values']['font_style'] );
    if( isset($fontStyles[1]) ){
    	$styles[] = 'font-weight:' . $fontStyles[1];
    }
    if( isset($fontStyles[2]) ){
    	$styles[] = 'font-style:' . $fontStyles[2];
    }
    
     
    $inline_style = '';     
    foreach( $styles as $attribute ){           
        $inline_style .= $attribute.'; ';       
    }   
     
    return $inline_style;
     
}
 
// Enqueue right google font from Googleapis
function malinaEnqueueGoogleFonts( $fontsData ) {
     
    // Get extra subsets for settings (latin/cyrillic/etc)
    $settings = get_option( 'wpb_js_google_fonts_subsets' );
    if ( is_array( $settings ) && ! empty( $settings ) ) {
        $subsets = '&subset=' . implode( ',', $settings );
    } else {
        $subsets = '';
    }
    $fontFamily = explode( ':', $fontsData['values']['font_family'] ); 
    // We also need to enqueue font from googleapis
    if ( isset( $fontsData['values']['font_family'] ) ) {
        wp_enqueue_style( 
            strtolower($fontFamily[0]), 
            '//fonts.googleapis.com/css?family=' . $fontsData['values']['font_family'] . $subsets
        );
    }
     
}

if(!function_exists('MalinaLogoElement')){
	function MalinaLogoElement($atts, $content = null) {
		$suf = rand(0, 9999);
		extract( shortcode_atts( array(
			'id' => $suf,
	        'text_logo' => '',
	        'default_font' => 'true',
	        'logo_font' => '',
	        'logo_font_size' => '',
	        'custom_logo' => '',
	        'logo_width' => ''
        ), $atts ) );
        $out = $style = '';

        if($logo_width !== ''){
        	$style .= '.logo.logo-'.$id.' img { width: '.$logo_width.'px; }';
        }
        if( $default_font !== 'true' && $logo_font_size !== '' ){
        	$style .= '.logo.logo-'.$id.' .logo_text { font-size:'.$logo_font_size.'px; }';
        }
        if( $default_font !== 'true' ){
        	// Build the data array
		    $logo_font = malinaGetFontsData( $logo_font );
		    // Build the inline style
		    $text_font_inline_style = malinaGoogleFontsStyles( $logo_font );         
		    // Enqueue the right font   
		    malinaEnqueueGoogleFonts( $logo_font );

        	$style .= '.logo.logo-'.$id.' .logo_text { '.$text_font_inline_style.' }';
        }
        if( $style != '' ){
			wp_register_style( 'malina-shortcodes-style', false );
			wp_enqueue_style( 'malina-shortcodes-style' );
			wp_add_inline_style('malina-shortcodes-style', $style);
		}
        $out .= '<div class="logo logo-'.$id.'">';
	        if( $custom_logo != '' ){
	        	$logo_image = wp_get_attachment_image_url($custom_logo, 'full');
				$out .= '<a href="'.esc_url(home_url()).'/" class="logo_main"><img src="'.esc_url($logo_image).'" alt="'.esc_attr(get_bloginfo('name')).'" /></a>';
	        } elseif( $text_logo != '' ){
				$out .= '<a href="'.esc_url(home_url()).'/" class="logo_text">'.esc_attr($text_logo).'</a>';
	        } elseif( get_theme_mod('malina_media_logo','') != "" ) {
				$out .= '<a href="'.esc_url(home_url()).'/" class="logo_main"><img src="'.esc_url(get_theme_mod('malina_media_logo')).'" alt="'.esc_attr(get_bloginfo('name')).'" /></a>';
			} else {
				$out .= '<a href="'.esc_url(home_url()).'/" class="logo_text">'.esc_attr(get_bloginfo('name')).'</a>';
			}
		$out .= '</div>';

		return $out;
	}
	add_shortcode('malinalogo', 'MalinaLogoElement');
}
if(!function_exists('MalinaMenuElement')){
	function MalinaMenuElement($atts, $content = null) {
		$suf = rand(0, 9999);
		extract( shortcode_atts( array(
			'id' => $suf,
	        'menu_id' => '',
	        'default_font' => 'true',
	        'menu_font' => '',
	        'menu_font_size' => '',
	        'menu_items_color_initial' => '',
	        'menu_items_color_hover' => '',
	        'menu_position' => 'flex-end',
	        'menu_place' => 'header',
	        'enable_search' => 'false'
        ), $atts ) );
        $out = $style = '';

        if( $default_font !== 'true' && $menu_font_size !== '' ){
        	$style .= '#navigation-block.navigation-block-'.$id.' .wp-megamenu-wrap .wpmm-nav-wrap > ul > li > a,';
        	$style .= '#navigation-block.navigation-block-'.$id.' #navigation .menu li a, #navigation-block.navigation-block-'.$id.' .dl-menuwrapper li a { font-size:'.$logo_font_size.'px; }';
        }
        if( $default_font !== 'true' ){
        	// Build the data array
		    $menu_font = malinaGetFontsData( $menu_font );
		    // Build the inline style
		    $text_font_inline_style = malinaGoogleFontsStyles( $menu_font );         
		    // Enqueue the right font   
		    malinaEnqueueGoogleFonts( $menu_font );
		    $style .= '#navigation-block.navigation-block-'.$id.' .wp-megamenu-wrap .wpmm-nav-wrap > ul > li > a,';
        	$style .= '#navigation-block.navigation-block-'.$id.' #navigation .menu li a, #navigation-block.navigation-block-'.$id.' .dl-menuwrapper li a { '.$text_font_inline_style.' }';
        }
        if($menu_items_color_initial !== ''){
        	$style .= '#navigation-block.navigation-block-'.$id.' .wp-megamenu-wrap .wpmm-nav-wrap > ul > li > a,';
        	$style .= '#navigation-block.navigation-block-'.$id.' #navigation .menu li a, #navigation-block.navigation-block-'.$id.' .dl-menuwrapper li a { color:'.$menu_items_color_initial.'; }';
        }
        if($menu_items_color_hover !== ''){
        	$style .= '#navigation-block.navigation-block-'.$id.' .wp-megamenu-wrap .wpmm-nav-wrap > ul > li > a:hover,';
        	$style .= '#navigation-block.navigation-block-'.$id.' #navigation .menu li a:hover, #navigation-block.navigation-block-'.$id.' .dl-menuwrapper li a:hover { color:'.$menu_items_color_hover.'; }';
        }
        $style .= '#header #navigation-block.navigation-block-'.$id.', #footer-custom #navigation-block.navigation-block-'.$id.' {justify-content:'.$menu_position.'}';
        
        if( $style != '' ){
			wp_register_style( 'malina-shortcodes-style', false );
			wp_enqueue_style( 'malina-shortcodes-style' );
			wp_add_inline_style('malina-shortcodes-style', $style);
		}
        $out .= '<div id="navigation-block" class="navigation-block-'.$id.'">';
        if( $enable_search == 'true' ){
        	add_filter('wp_nav_menu_items','malina_menu_item_search', 10, 2);
        }
        if($menu_place == 'header'){
        	$depth = 0;
        } else {
        	$depth = 1;
        }
        $wpmm_nav_location_settings = get_wpmm_option('main_navigation');
		if(function_exists('wp_megamenu') && !empty($wpmm_nav_location_settings['is_enabled']) && $menu_place == 'header'){
			ob_start();			
			wp_megamenu(array('theme_location' => 'main_navigation'));
			$out .= ob_get_contents();
			ob_end_clean();
		} else {
			$out .= '<nav id="navigation">';
				$out .= '<ul id="nav" class="menu">';
					$out .= wp_nav_menu(array('container' => false, 'menu_id' => 'nav', 'items_wrap'=>'%3$s', 'fallback_cb' => false, 'echo' => false, 'depth' => $depth ));
				$out .= '</ul>';
			$out .= '</nav>';
		}


		$out .= '</div>';

		return $out;
	}
	add_shortcode('malinamenu', 'MalinaMenuElement');
}
if(!function_exists('MalinaHeroSectionElement')){
	function MalinaHeroSectionElement($atts, $content = null) {
		$suf = rand(0, 9999);
		extract( shortcode_atts( array(
			'id' => $suf,
	        'image_column' => '',
	        'thumbsize' => 'full',
	        'column_bg_color' => '',
	        'section_height' => '',
	        'title' => '',
	        'default_font' => 'true',
	        'title_font_family' => '',
	        'title_font_size' => '',
	        'title_color' => '',
	        'icon' => '',
	        'icon_color' => '',
	        'link_text' => '',
	        'link_url' => 'false',
	        'link_color' => ''
        ), $atts ) );
        $out = $style = '';

        if( $default_font !== 'true' ){
        	// Build the data array
		    $title_font_family = malinaGetFontsData( $title_font_family );
		    // Build the inline style
		    $text_font_inline_style = malinaGoogleFontsStyles( $title_font_family );         
		    // Enqueue the right font   
		    malinaEnqueueGoogleFonts( $title_font_family );
		    $style .= '#herosection.herosection'.$id.' .text-middle h2,';
        	$style .= '#herosection.herosection'.$id.' .link-bottom a { '.$text_font_inline_style.' }';
        }
        if( $section_height !== '' ){
        	$style .= '#herosection.herosection'.$id.'{height:'.$section_height.';}';
        }
        if( $column_bg_color !== '' ){
        	$style .= '#herosection.herosection'.$id.'.flex-grid .flex-column.second-column {background-color:'.$column_bg_color.';}';
        }
        if( $title_font_size !== '' ){
        	$style .= '#herosection.herosection'.$id.' .text-middle h2 {font-size:'.$title_font_size.'px;}';
        } 
        if( $title_color !== '' ){
        	$style .= '#herosection.herosection'.$id.' .text-middle h2 {color:'.$title_color.';}';
        }
        if( $icon_color !== '' ){
        	$style .= '#herosection.herosection'.$id.' .top-icon i {color:'.$icon_color.';}';
        }
        if( $link_color !== '' ){
        	$style .= '#herosection.herosection'.$id.' .bottom-link a {color:'.$link_color.';}';
        }       
        if( $style != '' ){
			wp_register_style( 'malina-shortcodes-style', false );
			wp_enqueue_style( 'malina-shortcodes-style' );
			wp_add_inline_style('malina-shortcodes-style', $style);
		}
        $image = wp_get_attachment_image_url($image_column, $thumbsize);
		$out .= '<section id="herosection" class="herosection'.$id.' flex-grid flex-grid-2">';
		$out .= '<div class="first-column flex-column">';
		$out .= '<figure class="full-height-image"><img src="'.esc_url($image).'" alt="hero-image"></figure>';
		$out .= '</div>';
		$out .= '<div class="second-column flex-column">';
			if($icon != '') {
				$out .= '<div class="icon-top"><i class="'.$icon.'"></i></div>';
			}
			$out .= '<div class="text-middle"><h2>'.$title.'</h2></div>';
			if( $link_url != '' && $link_text != '') {
				$out .= '<div class="link-bottom"><a href="'.esc_url($link_url).'">'.esc_html($link_text).'</a></div>';
			}
		$out .= '</div>';
		$out .= '</section>';
		

		return $out;
	}
	add_shortcode('malinaherosection', 'MalinaHeroSectionElement');
}
if(!function_exists('MalinaAboutmeSectionElement')){
	function MalinaAboutmeSectionElement($atts, $content = null) {
		$suf = rand(0, 9999);
		extract( shortcode_atts( array(
			'id' => $suf,
	        'image' => '',
	        'thumbsize' => 'full',
	        'section_bg_color' => '',
	        'title' => '',
	        'text' => '',
	        'default_font' => '',
	        'title_font_family' => '',
	        'title_font_size' => '',
	        'title_color' => '',
	        'signature_image' => ''
        ), $atts ) );
        $out = $style = '';

        if( $default_font !== 'true' ){
        	// Build the data array
		    $title_font_family = malinaGetFontsData( $title_font_family );
		    // Build the inline style
		    $text_font_inline_style = malinaGoogleFontsStyles( $title_font_family );         
		    // Enqueue the right font   
		    malinaEnqueueGoogleFonts( $title_font_family );
		    $style .= '#aboutmesection.aboutmesection'.$id.' .section-title h3 { '.$text_font_inline_style.' }';
        }
        if( $section_bg_color !== '' ){
        	$style .= '#aboutmesection.aboutmesection'.$id.' {background-color:'.$section_bg_color.';}';
        }
        if( $title_font_size !== '' ){
        	$style .= '#aboutmesection.aboutmesection'.$id.' .section-title h3 {font-size:'.$title_font_size.'px;}';
        } 
        if( $title_color !== '' ){
        	$style .= '#aboutmesection.aboutmesection'.$id.' .section-title h3 {color:'.$title_color.';}';
        }       
        if( $style != '' ){
			wp_register_style( 'malina-shortcodes-style', false );
			wp_enqueue_style( 'malina-shortcodes-style' );
			wp_add_inline_style('malina-shortcodes-style', $style);
		}
        $image_url = wp_get_attachment_image_url($image, $thumbsize);
        $signature_image_url = wp_get_attachment_image_url($signature_image, "full");
		$out .= '<section id="aboutmesection" class="aboutmesection'.$id.'">';
			$out .= '<div class="container">';
				$out .= '<div class="flex-grid flex-grid-2">';
					$out .= '<div class="first-column span6">';
						if( $title != '' ){
							$out .= '<div class="section-title"><h3>'.$title.'</h3></div>';
						}
						if( $text != '' ){
							$out .= '<div class="text">'.$text.'</div>';
						}
						if( $signature_image != '' ){
							$out .= '<div class="signature_image"><img src="'.esc_url($signature_image_url).'" alt="signature image"></div>';
						}
					$out .= '</div>';
					$out .= '<div class="second-column span6">';
						if( $image != '' ){
							$out .= '<figure class="profile-image"><img src="'.esc_url($image_url).'" alt="profile image"></figure>';
						}
					$out .= '</div>';
				$out .= '</div>';
			$out .= '</div>';
		$out .= '</section>';
		

		return $out;
	}
	add_shortcode('malinaaboutmesection', 'MalinaAboutmeSectionElement');
}
add_filter( 'widget_text', 'shortcode_unautop', 7);
add_filter( 'widget_text', 'do_shortcode', 7);
add_filter( 'the_content', 'do_shortcode', 120);

// Remove Empty Paragraphs
add_filter("the_content", "malina_the_content_filter");
function malina_the_content_filter($content) {
	// array of custom shortcodes requiring the fix 
	$block = join("|", array('post_slider'));
	$array = array(
		'<p>[' => '[', 
		']</p>' => ']', 
		']<br />' => ']',
		']<br>' => ']',	
		'<br>[' => '[',
		'<p></p>' => '',
		'<p><script' => '<script',
		'<p><style' => '<style',
		'</style></p>' => '</style>',
		'</script><br />' => '</script>',
		'</script></p>' => '</script>'
	);
	$content = strtr($content, $array);
	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]", $content); 
	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]", $rep);
	return $rep;
}
?>