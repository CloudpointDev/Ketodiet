<?php get_header(); ?>

<?php 
// Get Blog Layout from Theme Options
if(get_theme_mod('malina_sidebar_pos', 'sidebar-right') != 'none'){
	$sidebar_pos = get_theme_mod('malina_sidebar_pos', 'sidebar-right').' span9';
} else {
	$sidebar_pos ='span12';
}
if( !is_active_sidebar('blog-widgets') && get_theme_mod('malina_sidebar_pos', 'sidebar-right') != 'none') {
	$sidebar_pos .=' no_widgets_sidebar';
}
if( get_theme_mod('malina_home_hero_slider', 'none' ) == 'slider') {
	get_template_part('templates/blog/slider');
} elseif( get_theme_mod('malina_home_hero_slider', 'none' ) == 'herosection' ) {
	get_template_part('templates/blog/herosection');
}//end slider output if ?>
<div id="page-wrap-blog" class="container">
	<div id="content" class="<?php echo esc_attr($sidebar_pos); ?>">
		<div class="row">
			<?php
			$columns = get_theme_mod( 'malina_blog_columns', 'span6');
	      	$display_categories = get_theme_mod( 'malina_display_post_categories', true);
	      	$display_date = get_theme_mod( 'malina_display_post_date', true);
	      	$display_comments = get_theme_mod( 'malina_display_post_comments', false);
	      	$display_views = get_theme_mod( 'malina_display_post_views', true);
	      	if( function_exists('MalinaGetPostViews')){
	      		$display_views = get_theme_mod( 'malina_display_post_views', true);
	      	} else {
	      		$display_views = false;
	      	}
	      	if( function_exists('getPostLikeLink') ){
	      		$display_likes = get_theme_mod( 'malina_display_post_likes', true);
	      	} else {
	      		$display_likes = false;
	      	}
	      	if( function_exists('malina_calculate_reading_time') ){
	      		$display_read_time = get_theme_mod( 'malina_display_post_read_time', true);
	      	} else {
	      		$display_read_time = false;
	      	}
	      	
	      	$pagination = get_theme_mod( 'malina_display_post_pagination', 'standard');
	      	$display_readmore = 'true';
	      	$ignore_featured = get_theme_mod( 'malina_ignore_featured_posts', true);
	      	$ignore_sticky_posts = get_theme_mod( 'malina_ignore_sticky_posts', false);
	      	$bottom_lines = '';
	      	$text_align = get_theme_mod('malina_blog_elements_align','textcenter');
			$out = '';
			$post_style = get_theme_mod('malina_blog_style', 'style_1');
			$thumbsize = get_theme_mod('malina_blog_thumbnail_size','malina-extra-medium');
			if($post_style == 'style_4'){
				$thumbsize = 'malina-masonry';
			}
			if($post_style == 'style_2' || $post_style == 'style_3' ){
				$thumbsize = 'post-thumbnail';
			}
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
					\"use strict\";
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
				        var gridBlog2 = $('#latest-posts .blog-posts');
				        gridBlog2.isotope(isoOptionsBlog);       
				        win.resize(function(){
				            gridBlog2.isotope('layout');
				        });
				        gridBlog2.infinitescroll({
				            navSelector  : '#pagination',    // selector for the paged navigation 
				            nextSelector : '#pagination a.next',  // selector for the NEXT link (to page 2)
				            itemSelector : '.post',     // selector for all items you'll retrieve
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
				$out .= '<div id="blog-posts-page" class="row-fluid blog-posts">';
				while ( have_posts() ) {
					the_post();
					$classes = join(' ', get_post_class($post->ID));
					$classes .= ' post';
					if(!$ignore_sticky_posts && is_sticky() && strrpos($classes, 'sticky ')){
						$out .= '<article class="textcenter span12 '.$classes.'">';
							$out .= '<div class="post-block-title">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<header class="title">';
								$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
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
									$out .= get_the_excerpt();
								}
								$out .= '</div>';
								$out .= '<div class="post-meta'.$bottom_lines.'">';
									$out .= '<div class="meta">';
										if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
										if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
										if( comments_open() && $display_comments ){
											$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
										}
									$out .= '</div>';
									$out .= '<div class="post-more"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark"><span>'.esc_html__('Read more', 'malina').'</span><i class="la la-long-arrow-right"></i></a></div>';
									if(function_exists('MalinaSharebox')){
										$out .= MalinaSharebox( get_the_ID() );
									} else {
										$out .= '<div style="width:25%;"></div>';
									}
								$out .= '</div>';
						$out .= '</article>';
					} elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') && $post_style == 'style_1' ){
						$classes = str_replace('sticky ', '', $classes);
						$out .= '<article class="post-featured post-size span12 '.$classes.'">';
							$out .= '<div class="post-content-container">';
								$out .= '<div class="post-img-side">';
								$out .= malina_get_post_format_content(false, 'post-thumbnail');
								if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
								$out .= '</div>';
								$out .= '<div class="post-content-side">';
									if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
									$out .= '<header class="title">';
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '</header>';
								$out .= '<div class="post-content">';
								if( malina_post_has_more_link( get_the_ID() ) ){
									$out .= '<div class="post-excerpt">'.malina_get_the_content().'</div>';
								} else {
									$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
								}
								$out .= '</div>';
								if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
									$out .= '<div class="post-meta footer-meta">';
									if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
									if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
									if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
									if( comments_open() && $display_comments ){
										$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
									}
									$out .= '</div>';
								}
								$out .= '</div>';
							$out .= '</div>';
						$out .= '</article>';
					} elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') && ($post_style == 'style_2' || $post_style == 'style_3' || $post_style == 'style_5' ) ){
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
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
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
										$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
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
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '</header>';
								$out .= '<div class="post-content">';
								if( malina_post_has_more_link( get_the_ID() ) ){
									$out .= '<div class="post-excerpt">'.malina_get_the_content().'</div>';
								} else {
									$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
								}
								$out .= '</div>';
								if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
									$out .= '<div class="post-meta footer-meta">';
									if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
									if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
									if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
									if( comments_open() && $display_comments ){
										$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
									}
									$out .= '</div>';
								}
								$out .= '</div>';
							$out .= '</div>';
						$out .= '</article>';
					} elseif( $post_style == 'style_5' ) {
					$classes = str_replace('sticky ', '', $classes);
					$out .= '<article class="span12 post-size style_5 '.$classes.'">';
						$out .= '<div class="post-content-container">';
							$out .= '<div class="post-img-side">';
							$out .= malina_get_post_format_content(false, $thumbsize);
							if( $display_date ) $out .= '<div class="label-date"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
							$out .= '</div>';
							$out .= '<div class="post-content-side">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<header class="title">';
								$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
								$out .= '</header>';
							$out .= '<div class="post-content">';
							if( malina_post_has_more_link( get_the_ID() ) ){
								$out .= '<div class="post-excerpt">'.malina_get_the_content().'</div>';
							} else {
								$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
							}
							$out .= '</div>';
							if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
								$out .= '<div class="post-meta footer-meta">';
								if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
								if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
								if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
								if( comments_open() && $display_comments ){
									$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
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
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '</header>';
								$out .= '<div class="post-content">';
								if( malina_post_has_more_link( get_the_ID() ) ){
									$out .= '<div class="post-excerpt">'.malina_get_the_content().'</div>';
								} else {
									$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
								}
								$out .= '</div>';
								if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
									$out .= '<div class="post-meta footer-meta">';
									if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
									if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
									if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
									if( comments_open() && $display_comments ){
										$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
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
				$out .= '<div id="pagination" class="hide">'.get_next_posts_link().'</div>';
				$out .= '<div class="loadmore-container"><a href="#" class="loadmore button"><span>'.esc_html__('Load More', 'malina').'</span></a></div>';
			} else {
				if(malina_custom_pagination() != '') {
					$out .= '<div id="pagination">'.malina_custom_pagination().'</div>';
				}
			}
			$out .= '</div>';
			echo ''.$out;
		} else { ?>
				
				<h2><?php esc_html_e('Not Found', 'malina') ?></h2>
				
			<?php } ?>
		</div>
	</div>

<?php if(get_theme_mod('malina_sidebar_pos', 'sidebar-right') != 'none' && is_active_sidebar('blog-widgets') ){
		get_sidebar();
	} 
?>
</div>

<?php get_footer(); ?>