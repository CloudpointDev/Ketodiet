<?php

add_action( 'init', 'malina_elements_vc_shortcodes' );
function malina_elements_vc_shortcodes() {
	$imageSizes = get_intermediate_image_sizes();
	$imageSizes[]= 'full';
	$suf = rand(0, 9999);
    vc_add_shortcode_param( 'hidden_id', 'malina_hidden_id_settings_field' );
	function malina_hidden_id_settings_field( $settings, $value ) {
	   return '<div class="hidden_id_param_block" style="display:none;">'
	             .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
	             esc_attr( $settings['param_name'] ) . ' ' .
	             esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />' .
	             '</div>'; // This is html markup that will be outputted in content elements edit form
	}
	$text_transform = array(
		esc_html__('Default', 'malina-elements' ) => 'default',
		esc_html__('Uppercase', 'malina-elements' ) => 'uppercase',
		esc_html__('Lowercase', 'malina-elements' ) => 'lowercase',
		esc_html__('Capitalize', 'malina-elements' ) => 'capitalize'
	);
	vc_map( 
		array(
			"name" => __("Malina Posts Slider", 'malina-elements'),
			"base" => "post_slider",
			"icon" => 'malina-element-icon dashicons dashicons-slides',
			"category" => __('Malina Elements', 'malina-elements'),
			'front_enqueue_js' => array(MALINA_PLUGIN_URL.'js/owl.carousel.min.js'),
			'description' => __('Slider with your posts', 'malina-elements'),
			"params" => array(
				array(
					"type" => "dropdown",            
					"heading" => __("Autoplay", 'malina-elements'),
					"param_name" => "slideshow",
					"value" => array(
					   __('Enable', 'malina-elements')=>'true',
					   __('Disable', 'malina-elements')=>'false',
					),
					"description" => __("Disable or Enable Autoplay.", 'malina-elements'),
					"std" => array('true')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Loop", 'malina-elements'),
					"param_name" => "loop",
					"value" => array(
					   __('Enable', 'malina-elements')=>'true',
					   __('Disable', 'malina-elements')=>'false',
					),
					"description" => __("If you want to have continuous slider, please select enable", 'malina-elements'),
					"std" => array('false')
				),		
				array(
					"type" => "textfield",            
					"heading" => __("Slider count", 'malina-elements'),
					"param_name" => "number_posts",
					"value" => '3',
					'admin_label' => true,
					"description" => __("Enter number of slides to display (Note: Enter '-1' to display all slides).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Category slug", 'malina-elements'),
					"param_name" => "cat_slug",
					"value" => '',
					"description" => __("This help you to retrieve items from specific category. More than one separate by commas.", 'malina-elements')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Post IDs", 'malina-elements'),
					"param_name" => "post_ids",
					"value" => '',
					"description" => __("Enter posts IDs to display only those records (Note: separate values by commas (,)).", 'malina-elements')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Order by", 'malina-elements'),
					"param_name" => "orderby",
					"value" => array(
					   __('Date', 'malina-elements')=>'date', 
					   __('Last modified date', 'malina-elements') => 'modified',
					   __('Popularity', 'malina-elements')=>'comment_count',
					   __('Title', 'malina-elements')=>'title',
					   __('Random', 'malina-elements')=>'rand',
					   __('Preserve post ID order', 'malina-elements') => 'post__in',
					),
					"description" => __('Select how to sort retrieved posts.', 'malina-elements'),
					"std" => array('date')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Sort order", 'malina-elements'),
					"param_name" => "order",
					"value" => array(
					   __('Descending', 'malina-elements')=>'DESC', 
					   __('Ascending', 'malina-elements')=>'ASC'
					),
					"description" => __('Select ascending or descending order.', 'malina-elements'),
					"std" => array('DESC')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Image size", 'malina-elements'),
					"param_name" => "thumbsize",
					"value" => $imageSizes,
					"description" => __('Select your image size to use in slider.', 'malina-elements'),
					"std" => array('large')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Slider Style", 'malina-elements'),
					"param_name" => "style",
					"value" => array(
					   __('Centered', 'malina-elements')=>'center',
					   __('Two Centered', 'malina-elements')=>'center2',
					   __('Simple', 'malina-elements')=>'simple',
					   __('Two in row', 'malina-elements') => 'two_per_row',
					   __('Three in row', 'malina-elements') => 'three_per_row',
					),
					"std" => array('simple')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Description Style", 'malina-elements'),
					"param_name" => "description_style",
					"value" => array(
					   __('Style 1', 'malina-elements')=>'style_1',
					   __('Style 2', 'malina-elements') => 'style_2',
					   __('Style 3', 'malina-elements') => 'style_3',
					   __('Style 4', 'malina-elements') => 'style_4',
					   __('Style 5', 'malina-elements') => 'style_5',
					),
					"std" => array('style_1')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Navigation arrows", 'malina-elements'),
					'description' => __('Display navigation arrows.', 'malina-elements'),
					"param_name" => "nav",
					"value" => array(
					   __('Show', 'malina-elements') => 'true',
					   __('Hide', 'malina-elements') => 'false',
					),
					"std" => array('true')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Overlay", 'malina-elements'),
					'description' => __('Display overlay on image. Your image with displays with some saturation.', 'malina-elements'),
					"param_name" => "overlay",
					"value" => array(
					   __('Show', 'malina-elements') => 'true',
					   __('Hide', 'malina-elements') => 'false',
					),
					"std" => array('true')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Show meta categories?", 'malina-elements'),
					"param_name" => "show_categories",
					"value" => array(
					   __('Show', 'malina-elements') => 'true',
					   __('Hide', 'malina-elements') => 'false',
					),
					"std" => array(true)
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Show date?", 'malina-elements'),
					"param_name" => "show_date",
					"value" => array(
					   __('Show', 'malina-elements') => 'true',
					   __('Hide', 'malina-elements') => 'false',
					),
					"std" => array('true')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Slider width", 'malina-elements'),
					"param_name" => "slider_width",
					"value" => array(
					   __('Fullwidth', 'malina-elements') => 'fullwidth',
					   __('Standard', 'malina-elements') => 'standard',
					),
					"std" => array('standard')
				),
			)
		)
	);
	/*vc_map( 
		array(
			"name" => __("Malina List Posts", 'malina-elements'),
			"base" => "listposts",
			"icon" => 'malina-element-icon dashicons dashicons-admin-post',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show WP posts. Latest, Popular or from specific category, etc.', 'malina-elements'),
			"params" => array(		
				array(
					"type" => "textfield",            
					"heading" => __("Post count", 'malina-elements'),
					"param_name" => "num",
					"value" => '3',
					'admin_label' => true,
					"description" => __("Enter number of posts to display (Note: Enter '-1' to display all posts).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Category slug", 'malina-elements'),
					"param_name" => "cat_slug",
					"value" => '',
					"description" => __("This help you to retrieve items from specific category. More than one separate by commas.", 'malina-elements')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Post IDs", 'malina-elements'),
					"param_name" => "post_ids",
					"value" => '',
					"description" => __("Enter posts IDs to display only those records (Note: separate values by commas (,)).", 'malina-elements')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Post IDs Exclude", 'malina-elements'),
					"param_name" => "post__not_in",
					"value" => '',
					"description" => __("Enter posts IDs to exclude those records (Note: separate values by commas (,)).", 'malina-elements')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Sort order", 'malina-elements'),
					"param_name" => "order",
					"value" => array(
					   __('Descending', 'malina-elements')=>'DESC', 
					   __('Ascending', 'malina-elements')=>'ASC'
					),
					"description" => __('Select ascending or descending order.', 'malina-elements'),
					"std" => array('DESC')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Thumbnail size", 'malina-elements'),
					"param_name" => "thumbsize",
					"value" => $imageSizes,
					"description" => __('Select your image size to use.', 'malina-elements'),
					"std" => array('medium')
				),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Display date?", 'malina-elements'),
		            "param_name" => "display_date",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display categories?", 'malina-elements'),
		            "param_name" => "display_categories",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Display likes?", 'malina-elements'),
		            "param_name" => "display_likes",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display read time?", 'malina-elements'),
		            "param_name" => "display_read_time",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display views count?", 'malina-elements'),
		            "param_name" => "display_views",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Display comments count?", 'malina-elements'),
		            "param_name" => "display_comments",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('false')
		        ),
		        array(
					"type" => "dropdown",            
					"heading" => __("Display read more?", 'malina-elements'),
					"param_name" => "display_readmore",
					"value" => array(
					   __('Yes', 'malina-elements') => 'true',
					   __('No', 'malina-elements') => 'false',
					),
					"std" => array('true')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Post excerpt count", 'malina-elements'),
					"param_name" => "excerpt_count",
					"value" => '32',
					"description" => __("Enter number of words in post excerpt.", 'malina-elements')            
				),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Pagination", 'malina-elements'),
		            "param_name" => "pagination",
		            "value" => array(__('Enable','malina-elements')=>'true', __('Disable', 'malina-elements')=>'false'),
		            "description" => __('Enable or Disable pagination for posts.', 'malina-elements'),
		            "std" => array('false')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Disable featured posts style", 'malina-elements'),
		            "param_name" => "ignore_featured",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Disable style for featured posts. Do not highlight them.', 'malina-elements'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Ignore sticky posts", 'malina-elements'),
		            "param_name" => "ignore_sticky_posts",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Do you want to ignore sticky posts?', 'malina-elements'),
		            "std" => array('false')
		        ),
			)
		)
	);*/
	vc_map( 
		array(
			"name" => __("Malina Recent Posts", 'malina-elements'),
			"base" => "gridposts",
			"icon" => 'malina-element-icon dashicons dashicons-layout',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show WP posts in grid.', 'malina-elements'),
			"params" => array(	
				array(
					"type" => "textfield",            
					"heading" => __("Post count", 'malina-elements'),
					"param_name" => "num",
					"value" => '3',
					'admin_label' => true,
					"description" => __("Enter number of posts to display (Note: Enter '-1' to display all posts).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Load more posts count", 'malina-elements'),
					"param_name" => "load_count",
					"value" => '',
					"description" => __("Enter number of posts to load (leave balnk to use the same value as per page).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Category slug", 'malina-elements'),
					"param_name" => "cat_slug",
					"value" => '',
					"description" => __("This help you to retrieve items from specific category. More than one separate by commas.", 'malina-elements')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Post IDs", 'malina-elements'),
					"param_name" => "post_ids",
					"value" => '',
					"description" => __("Enter posts IDs to display only those records (Note: separate values by commas (,)).", 'malina-elements')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Post IDs Exclude", 'malina-elements'),
					"param_name" => "post__not_in",
					"value" => '',
					"description" => __("Enter posts IDs to exclude those records (Note: separate values by commas (,)).", 'malina-elements')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Order by", 'malina-elements'),
					"param_name" => "orderby",
					"value" => array(
					   __('Date', 'malina-elements')=>'date', 
					   __('Last modified date', 'malina-elements') => 'modified',
					   __('Popularity', 'malina-elements')=>'comment_count',
					   __('Title', 'malina-elements')=>'title',
					   __('Random', 'malina-elements')=>'rand',
					   __('Preserve post ID order', 'malina-elements') => 'post__in',
					),
					"description" => __('Select how to sort retrieved posts.', 'malina-elements'),
					"std" => array('date')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Sort order", 'malina-elements'),
					"param_name" => "order",
					"value" => array(
					   __('Descending', 'malina-elements')=>'DESC', 
					   __('Ascending', 'malina-elements')=>'ASC'
					),
					"description" => __('Select ascending or descending order.', 'malina-elements'),
					"std" => array('DESC')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Post view style", 'malina-elements'),
					"param_name" => "post_style",
					"value" => array(
					   __('Simple', 'malina-elements')=>'style_1',
					   __('Featured','malina-elements') => 'style_2', 
					   __('Featured even/odd', 'malina-elements')=>'style_3',
					   __('Masonry', 'malina-elements')=>'style_4',
					   __('List', 'malina-elements') => 'style_5'
					),
					"description" => __('Select posts style on preview.', 'malina-elements'),
					"std" => array('style_1')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Posts per row", 'malina-elements'),
					"param_name" => "columns",
					"value" => array(
					   __('Two', 'malina-elements')=>'span6',
					   __('Three', 'malina-elements')=>'span4',
					   __('Four', 'malina-elements')=>'span3',
					   __('Five', 'malina-elements')=>'one_fifth',
					   __('Six', 'malina-elements')=>'span2',
					),
					"description" => __("Select posts count per row.", 'malina-elements'),
					"std" => array('span4'),
					"dependency" => array(
				        "element" => "post_style",
				        "value" => array('style_1', 'style_4')
				    )
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Thumbnail size", 'malina-elements'),
					"param_name" => "thumbsize",
					"value" => $imageSizes,
					"description" => __('Select your image size to use.', 'malina-elements'),
					"std" => array('medium')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Post excerpt count", 'malina-elements'),
					"param_name" => "excerpt_count",
					"value" => '15',
					"description" => __("Enter number of words in post excerpt. 0 to hide it.", 'malina-elements')            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Align elements", 'malina-elements'),
					"param_name" => "text_align",
					"value" => array(
					   __('Left', 'malina-elements')=>'textleft',
					   __('Center', 'malina-elements')=>'textcenter',
					   __('Right', 'malina-elements')=>'textright'
					),
					"description" => __("Select position for text, meta info, categories, etc.", 'malina-elements'),
					"std" => array('textcenter')
				),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display categories?", 'malina-elements'),
		            "param_name" => "display_categories",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Show categories above the title?', 'malina-elements'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display time reading?", 'malina-elements'),
		            "param_name" => "display_read_time",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Show estimate time to read the post?', 'malina-elements'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display comments count?", 'malina-elements'),
		            "param_name" => "display_comments",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Show comments count in meta?', 'malina-elements'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display date label?", 'malina-elements'),
		            "param_name" => "display_date",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display views?", 'malina-elements'),
		            "param_name" => "display_views",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display likes?", 'malina-elements'),
		            "param_name" => "display_likes",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Pagination", 'malina-elements'),
		            "param_name" => "pagination",
		            "value" => array(
		            	__('Load more','malina-elements')=>'true',
		            	__('Standard','malina-elements')=>'standard',
		            	__('Disable', 'malina-elements')=>'false'
		            ),
		            "description" => __('Select pagination for posts.', 'malina-elements'),
		            "std" => array('false')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Disable featured posts style", 'malina-elements'),
		            "param_name" => "ignore_featured",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Disable style for featured posts. Do not highlight them.', 'malina-elements'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Ignore sticky posts", 'malina-elements'),
		            "param_name" => "ignore_sticky_posts",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Show sticky posts?', 'malina-elements'),
		            "std" => array('false')
		        ),
			)
		)
	);
	vc_map( 
		array(
			"name" => __("Malina Carousel Posts", 'malina-elements'),
			"base" => "carouselposts",
			"icon" => 'malina-element-icon dashicons dashicons-leftright',
			'front_enqueue_js' => array(MALINA_PLUGIN_URL.'js/owl.carousel.min.js'),
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show WP posts in grid.', 'malina-elements'),
			"params" => array(
				array(
					"type" => "textfield",            
					"heading" => __("Posts block title", 'malina-elements'),
					"param_name" => "block_title",
					"value" => '',
					'admin_label' => true,
					"description" => __("Enter posts block title e.g. 'Latest posts'. Leave blank if you need not to display it.", 'malina-elements')            
				),		
				array(
					"type" => "textfield",            
					"heading" => __("Post count", 'malina-elements'),
					"param_name" => 'posts_count',
					"value" => '3',
					"description" => __("Enter number of posts to display (Note: Enter '-1' to display all posts).", 'malina-elements')            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Posts per view", 'malina-elements'),
					"param_name" => "columns",
					"value" => array(
					   __('Two per view', 'malina-elements')=>'span6',
					   __('Three per view', 'malina-elements')=>'span4',
					   __('Four per view', 'malina-elements')=>'span3',
					   __('Five per view', 'malina-elements')=>'one_fifth',
					   __('Six per view', 'malina-elements')=>'span2',
					),
					"description" => __("Select posts count per view.", 'malina-elements'),
					"std" => array('one_fifth')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Category slug", 'malina-elements'),
					"param_name" => "cat_slug",
					"value" => '',
					"description" => __("This help you to retrieve items from specific category. More than one separate by commas.", 'malina-elements')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Post IDs", 'malina-elements'),
					"param_name" => "post_ids",
					"value" => '',
					"description" => __("Enter posts IDs to display only those records (Note: separate values by commas (,)).", 'malina-elements')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Order by", 'malina-elements'),
					"param_name" => "orderby",
					"value" => array(
					   __('Date', 'malina-elements')=>'date', 
					   __('Last modified date', 'malina-elements') => 'modified',
					   __('Popularity', 'malina-elements')=>'comment_count',
					   __('Title', 'malina-elements')=>'title',
					   __('Random', 'malina-elements')=>'rand',
					   __('Preserve post ID order', 'malina-elements') => 'post__in',
					),
					"description" => __('Select how to sort retrieved posts.', 'malina-elements'),
					"std" => array('date')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Sort order", 'malina-elements'),
					"param_name" => "order",
					"value" => array(
					   __('Descending', 'malina-elements')=>'DESC', 
					   __('Ascending', 'malina-elements')=>'ASC'
					),
					"description" => __('Select ascending or descending order.', 'malina-elements'),
					"std" => array('DESC')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Thumbnail size", 'malina-elements'),
					"param_name" => "thumbsize",
					"value" => $imageSizes,
					"description" => __('Select your image size to use.', 'malina-elements'),
					"std" => array('medium')
				),
			)
		)
	);
	/*vc_map( 
		array(
			"name" => __("Malina Recent Posts", 'malina-elements'),
			"base" => "recentposts",
			"icon" => 'malina-element-icon dashicons dashicons-format-aside',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show WP posts. Latest, Popular or from specific category, etc.', 'malina-elements'),
			"params" => array(		
				array(
					"type" => "textfield",            
					"heading" => __("Post count", 'malina-elements'),
					"param_name" => "num",
					"value" => '3',
					'admin_label' => true,
					"description" => __("Enter number of posts to display (Note: Enter '-1' to display all posts).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Category slug", 'malina-elements'),
					"param_name" => "cat_slug",
					"value" => '',
					"description" => __("This help you to retrieve items from specific category. More than one separate by commas.", 'malina-elements')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Post IDs", 'malina-elements'),
					"param_name" => "post_ids",
					"value" => '',
					"description" => __("Enter posts IDs to display only those records (Note: separate values by commas (,)).", 'malina-elements')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Post IDs Exclude", 'malina-elements'),
					"param_name" => "post__not_in",
					"value" => '',
					"description" => __("Enter posts IDs to exclude those records (Note: separate values by commas (,)).", 'malina-elements')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Order by", 'malina-elements'),
					"param_name" => "orderby",
					"value" => array(
					   __('Date', 'malina-elements')=>'date', 
					   __('Last modified date', 'malina-elements') => 'modified',
					   __('Popularity', 'malina-elements')=>'comment_count',
					   __('Title', 'malina-elements')=>'title',
					   __('Random', 'malina-elements')=>'rand',
					   __('Preserve post ID order', 'malina-elements') => 'post__in',
					),
					"description" => __('Select how to sort retrieved posts.', 'malina-elements'),
					"std" => array('date')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Sort order", 'malina-elements'),
					"param_name" => "order",
					"value" => array(
					   __('Descending', 'malina-elements')=>'DESC', 
					   __('Ascending', 'malina-elements')=>'ASC'
					),
					"description" => __('Select ascending or descending order.', 'malina-elements'),
					"std" => array('DESC')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Thumbnail size", 'malina-elements'),
					"param_name" => "thumbsize",
					"value" => $imageSizes,
					"description" => __('Select your image size to use.', 'malina-elements'),
					"std" => array('medium')
				),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Content size", 'malina-elements'),
		            "param_name" => "content_size",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Content width less than featured image.', 'malina-elements'),
		            "std" => array('false')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Show categories?", 'malina-elements'),
		            "param_name" => "show_categories",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Show categories above the title?', 'malina-elements'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Show bottom lines?", 'malina-elements'),
		            "param_name" => "show_lines",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Show date?", 'malina-elements'),
		            "param_name" => "show_date",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Show read more?", 'malina-elements'),
		            "param_name" => "show_readmore",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Show sharebox?", 'malina-elements'),
		            "param_name" => "show_sharebox",
		            "value" => array(__('Yes','malina-elements') => 'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Pagination", 'malina-elements'),
		            "param_name" => "pagination",
		            "value" => array(__('Enable','malina-elements')=>'true', __('Disable', 'malina-elements')=>'false'),
		            "description" => __('Enable or Disable pagination for posts.', 'malina-elements'),
		            "std" => array('false')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Disable featured posts style", 'malina-elements'),
		            "param_name" => "ignore_featured",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Disable style for featured posts. Do not highlight them.', 'malina-elements'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Ignore sticky posts", 'malina-elements'),
		            "param_name" => "ignore_sticky_posts",
		            "value" => array(__('True','malina-elements')=>'true', __('False', 'malina-elements')=>'false'),
		            "description" => __('Show sticky posts?', 'malina-elements'),
		            "std" => array('false')
		        ),
			)
		)
	);*/
	vc_map( 
		array(
			"name" => __("Malina Single Posts", 'malina-elements'),
			"base" => "singlepost",
			"icon" => 'malina-element-icon dashicons dashicons-megaphone',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show WP post. Just input post ID. You can find post ID in browser address bar while editing post.', 'malina-elements'),
			"params" => array(		
				array(
					"type" => "textfield",            
					"heading" => __("Post ID", 'malina-elements'),
					"param_name" => "post_ids",
					"value" => '',
					"description" => __("Enter posts ID to display only those record.", 'malina-elements')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Thumbnail size", 'malina-elements'),
					"param_name" => "thumbsize",
					"value" => $imageSizes,
					"description" => __('Select your image size to use.', 'malina-elements'),
					"std" => array('post-thumbnail')
				),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Show categories?", 'malina-elements'),
		            "param_name" => "show_categories",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Show categories above the title?', 'malina-elements'),
		            "std" => array('true')
		        ),
			)
		)
	);
	/*vc_map( 
		array(
			"name" => __("Malina Footer", 'malina-elements'),
			"base" => "malinafooter",
			"icon" => 'malina-element-icon dashicons dashicons-align-center',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show page footer.', 'malina-elements'),
			"params" => array(		
				array(
					"type" => "colorpicker",            
					"heading" => __("Custom footer background", 'malina-elements'),
					"param_name" => "bg_color",
					"value" => ''
				)
			)
		)
	);*/
	vc_map( 
		array(
			"name" => __("Malina Socials", 'malina-elements'),
			"base" => "malinasocials",
			"icon" => 'malina-element-icon dashicons dashicons-networking',
			"category" => array(__('Malina Elements', 'malina-elements'), __('Malina Footer', 'malina-elements'), __('Malina Header', 'malina-elements') ),
			'description' => __('Show social icons: facebook, twitter, pinterest, etc.', 'malina-elements'),
			"params" => array(		
				array(
					"type" => "textfield",            
					"heading" => __("Facebook", 'malina-elements'),
					"param_name" => "facebook",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Twitter", 'malina-elements'),
					"param_name" => "twitter",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Pinterest", 'malina-elements'),
					"param_name" => "pinterest",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Instagram", 'malina-elements'),
					"param_name" => "instagram",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Tumblr", 'malina-elements'),
					"param_name" => "tumblr",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Forrst", 'malina-elements'),
					"param_name" => "forrst",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Flickr", 'malina-elements'),
					"param_name" => "flickr",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Dribbble", 'malina-elements'),
					"param_name" => "dribbble",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Skype", 'malina-elements'),
					"param_name" => "skype",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Digg", 'malina-elements'),
					"param_name" => "digg",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Google plus", 'malina-elements'),
					"param_name" => "google_plus",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Linkedin", 'malina-elements'),
					"param_name" => "linkedin",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Vimeo", 'malina-elements'),
					"param_name" => "vimeo",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Yahoo", 'malina-elements'),
					"param_name" => "yahoo",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Youtube", 'malina-elements'),
					"param_name" => "youtube",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Picasa", 'malina-elements'),
					"param_name" => "picasa",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Deviantart", 'malina-elements'),
					"param_name" => "deviantart",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Behance", 'malina-elements'),
					"param_name" => "behance",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("PayPal", 'malina-elements'),
					"param_name" => "Paypal",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Delicious", 'malina-elements'),
					"param_name" => "delicious",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Rss", 'malina-elements'),
					"param_name" => "rss",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to rss.", 'malina-elements')            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Icons style", 'malina-elements'),
					"param_name" => "style",
					"value" => array(
					   __('Simple', 'malina-elements')=>'simple',
					   __('Big Icon+Text', 'malina-elements')=>'big_icon_text'
					),
					"std" => array('simple')
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Circle background color", 'malina-elements'),
					"param_name" => "bg_color",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements'),
					"dependency" => array(
				        "element" => "style",
				        "value" => "big_icon_text"
				    )        
				),	
				array(
					"type" => "colorpicker",            
					"heading" => __("Icon color initial", 'malina-elements'),
					"param_name" => "icon_color",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements'),       
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Icon color hover", 'malina-elements'),
					"param_name" => "icon_color_hover",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements'),       
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Circle text color", 'malina-elements'),
					"param_name" => "text_color",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements'),
					"dependency" => array(
				        "element" => "style",
				        "value" => "big_icon_text"
				    )        
				),
				array(
					"type" => "hidden_id",            
					"heading" => '',
					"param_name" => "id",
					"value" => $suf,
					"description" => ''            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Icons align", 'malina-elements'),
					"param_name" => "icons_align",
					"value" => array(
					   __('Center', 'malina-elements') => 'textcenter',
					   __('Right', 'malina-elements') => 'textright',
					   __('Left', 'malina-elements') => 'textleft',
					),
					"std" => array('textcenter')
				),
			)
		)
	);
	vc_map( 
		array(
			"name" => __("Malina User Info", 'malina-elements'),
			"base" => "malinauser",
			"icon" => 'malina-element-icon dashicons dashicons-admin-users',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show user information.', 'malina-elements'),
			"params" => array(		
				array(
					"type" => "textfield",            
					"heading" => __("Username", 'malina-elements'),
					"param_name" => "username",
					"value" => '',
					'admin_label' => true,
					"description" => __("Enter username parameter to display information.", 'malina-elements')            
				),
			)
		)
	);
	/*$menus_list = array();
	$menus_list['none'] = __('None', 'malina-elements');
	$menus = get_terms('nav_menu');
	if( !empty($menus) ){
		foreach($menus as $menu){
		  $menus_list[$menu->term_id] = $menu->name;
		}
	}
	vc_map( 
		array(
			"name" => __("Malina Menu", 'malina-elements'),
			"base" => "malinamenu",
			"icon" => 'malina-element-icon dashicons dashicons-menu',
			"category" => array( __('Malina Header', 'malina-elements'), __('Malina Footer', 'malina-elements') ), 
			'description' => __('Show your header menu.', 'malina-elements'),
			"params" => array(
				array(
					"type" => "dropdown",            
					"heading" => __("Select your menu", 'malina-elements'),
					"param_name" => "menu_id",
					"value" => $menus_list,
					"std" => array('none'),
					"description" => __("You need to create your menu under appearances->menus.", 'malina-elements')            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Menu place", 'malina-elements'),
					"param_name" => "menu_place",
					"value" => array(
					   __('Header', 'malina-elements') => 'header',
					   __('Footer', 'malina-elements') => 'footer',
					),
					"std" => array('header'),
					"description" => __("Select place where do you want to insert menu.", 'malina-elements')            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Use default theme font", 'malina-elements'),
					"param_name" => "default_font",
					"value" => array(
					   __('Yes', 'malina-elements') => 'true',
					   __('No', 'malina-elements') => 'false',
					),
					"std" => array('true'),
					"description" => __("Leave blank to use your default menu font.", 'malina-elements')            
				),
				array(
					'type' => 'google_fonts',
					'param_name' => 'menu_font',
					'value' => '',
					'settings' => array(
						'fields' => array(
							'font_family' => 'Montserrat:regular,italic',
							'font_family_description' => __( 'Select font family.', 'malina-elements' ),
							'font_style_description' => __( 'Select font styling.', 'malina-elements' ),
						),
					),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => "false"
				    )
				),
				array(
					"type" => "textfield",            
					"heading" => __("Menu font size", 'malina-elements'),
					"param_name" => "menu_font_size",
					"value" => '12',
					"description" => __("Enter value in px. Do not set (px).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Menu text transform", 'malina-elements'),
					"param_name" => "menu_text_transform",
					"value" => $text_transform,
					"description" => __("Select text transform.", 'malina-elements'),
					"std" => array('uppercase')           
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Menu item color (initial)", 'malina-elements'),
					"param_name" => "menu_items_color_initial",
					"value" => '',            
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Menu item color (hover)", 'malina-elements'),
					"param_name" => "menu_items_color_hover",
					"value" => '',           
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Menu position", 'malina-elements'),
					"param_name" => "menu_position",
					"value" => array(
					   __('Right', 'malina-elements') => 'flex-end',
					   __('Center', 'malina-elements') => 'center',
					   __('Left', 'malina-elements') => 'flex-start',
					),
					"std" => array('flex-end'),           
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Enable search icon?", 'malina-elements'),
					"param_name" => "enable_search",
					"value" => array(
					   __('Yes', 'malina-elements') => 'true',
					   __('No', 'malina-elements') => 'false',
					),
					"std" => array('true'),
					"description" => __("Enable search icon to show at the end of the menu.", 'malina-elements') ,
					"dependency" => array(
				        "element" => "menu_place",
				        "value" => "header"
				    )           
				),
				array(
					"type" => "hidden_id",            
					"heading" => '',
					"param_name" => "id",
					"value" => $suf,
					"description" => ''            
				),
			)
		)
	);
	vc_map( 
		array(
			"name" => __("Malina Logo", 'malina-elements'),
			"base" => "malinalogo",
			"icon" => 'malina-element-icon dashicons dashicons-admin-home',
			"category" => array(__('Malina Footer', 'malina-elements'), __('Malina Header', 'malina-elements')),
			'description' => __('Show your site logo.', 'malina-elements'),
			"params" => array(
				array(
					"type" => "textfield",            
					"heading" => __("Text logo", 'malina-elements'),
					"param_name" => "text_logo",
					"value" => '',
					"description" => __("Leave blank to use your default logo.", 'malina-elements')            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Use default theme settings", 'malina-elements'),
					"param_name" => "default_font",
					"value" => array(
					   __('Yes', 'malina-elements') => 'true',
					   __('No', 'malina-elements') => 'false',
					),
					"std" => array('true'),
					"description" => __("Leave blank to use your default logo font.", 'malina-elements')            
				),
				array(
					'type' => 'google_fonts',
					'param_name' => 'logo_font',
					'value' => '',
					'settings' => array(
						'fields' => array(
							'font_family' => 'Nothing You Could Do:regular',
							'font_family_description' => __( 'Select font family.', 'malina-elements' ),
							'font_style_description' => __( 'Select font styling.', 'malina-elements' ),
						),
					),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => "false"
				    )
				),
				array(
					"type" => "textfield",            
					"heading" => __("Logo font size", 'malina-elements'),
					"param_name" => "logo_font_size",
					"value" => '',
					"description" => __("Enter value in px. Do not set (px).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => 'false'
				    )            
				),		
				array(
					"type" => "attach_image",            
					"heading" => __("Image logo", 'malina-elements'),
					"param_name" => "custom_logo",
					"value" => '',
					"description" => __("Leave blank to use your default logo.", 'malina-elements')          
				),
				array(
					"type" => "textfield",            
					"heading" => __("Logo image width", 'malina-elements'),
					"param_name" => "logo_width",
					"value" => '',
					"description" => __("Enter value, you can use px, %, em, etc. ", 'malina-elements'),           
				),
				array(
					"type" => "hidden_id",            
					"heading" => '',
					"param_name" => "id",
					"value" => $suf,
					"description" => ''            
				),
			)
		)
	);*/
	vc_map( 
		array(
			"name" => __("Malina Instagram", 'malina-elements'),
			"base" => "malinainstagram",
			"icon" => 'malina-element-icon dashicons dashicons-format-image',
			"category" => array( __('Malina Elements', 'malina-elements'), __('Malina Footer', 'malina-elements') ),
			'description' => __('Show your instagram feeds.', 'malina-elements'),
			"params" => array(		
				array(
					"type" => "textfield",            
					"heading" => __("Title", 'malina-elements'),
					"param_name" => "title",
					"value" => '',
					'admin_label' => true,
					"description" => __("Enter instagram block title.", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Access token", 'malina-elements'),
					"param_name" => "access_token",
					"value" => get_theme_mod('malina_footer_instagram_access_token', ''),
					'admin_label' => true,
					"description" => '<a target="_blank" href="https://instagram.com/oauth/authorize/?client_id=1677ed07ddd54db0a70f14f9b1435579&redirect_uri=http://instagram.pixelunion.net&response_type=token">'.esc_html__('Get your Access Token','malina-elements').'</a>',            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Items count", 'malina-elements'),
					"param_name" => "pics",
					"value" => '4',
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Items per row", 'malina-elements'),
					"param_name" => "pics_per_row",
					"value" => array(
					   __('One per row', 'malina-elements')=>'1',
					   __('Two row', 'malina-elements')=>'2',
					   __('Three per row', 'malina-elements')=>'3',
					   __('Four per row', 'malina-elements') => '4',
					   __('Six per row', 'malina-elements')=>'6',
					),
					"description" => __('Select items count per row', 'malina-elements'),
					"std" => array('4')
				),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Follow link", 'malina-elements'),
		            "param_name" => "hide_link",
		            "value" => array(__('Hide','malina-elements')=>'true', __('Show', 'malina-elements')=>'false'),
		            "description" => __('Show or hide follow link', 'malina-elements'),
		            "std" => array('true')
		        ),

			)
		)
	);
	$options = array();
	$options['Uncategorised'] = 'uncategorised';
    $query1 = get_terms( 'category', array('hide_empty' => false));
    if( $query1 ){
        foreach ( $query1 as $post ) {
            $options[ $post->name ] = $post->slug;
        }
    }
	vc_map( 
		array(
			"name" => __("Malina Category", 'malina-elements'),
			"base" => "malinacategory",
			"icon" => 'malina-element-icon dashicons dashicons-category',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show special block with link to category.', 'malina-elements'),
			"params" => array(
				array(
		            "type" => "dropdown",            
		            "heading" => __("Category", 'malina-elements'),
		            "param_name" => "category",
		            "value" => $options,
		            "description" => __('Select category to show.', 'malina-elements'),
		            'admin_label' => true,
		        ),	
		        array(
					"type" => "hidden_id",            
					"heading" => '',
					"param_name" => "id",
					"value" => $suf,
					"description" => ''            
				),	
				array(
					"type" => "textfield",            
					"heading" => __("Button label", 'malina-elements'),
					"param_name" => "button_label",
					"value" => '',
					"description" => __("Enter button label, if empty label is equal to category name.", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Button url", 'malina-elements'),
					"param_name" => "button_url",
					"value" => '',
					"description" => __("Enter button url, if empty url is equal to category url.", 'malina-elements')            
				),
				array(
					"type" => "attach_image",            
					"heading" => __("Category image", 'malina-elements'),
					"param_name" => "bg_image_id",
					"value" => '',
					"description" => __("Select image for category block", 'malina-elements')          
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Button Border color", 'malina-elements'),
					"param_name" => "category_button_border_color",
					"value" => '',
					"description" => __("Leave empty to use default style.", 'malina-elements')          
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Button background color", 'malina-elements'),
					"param_name" => "category_button_bg_color",
					"value" => '',
					"description" => __("Leave empty to use default style.", 'malina-elements')          
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Button text color", 'malina-elements'),
					"param_name" => "category_button_text_color",
					"value" => '',
					"description" => __("Leave empty to use default style.", 'malina-elements')          
				)
			)
		)
	);
	/*vc_map( 
		array(
			"name" => __("Malina Google Map", 'malina-elements'),
			"base" => "malinagooglemap",
			"icon" => 'malina-element-icon dashicons dashicons-location',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Display styled google map', 'malina-elements'),
			"params" => array(
				array(
					"type" => "textfield",            
					"heading" => __("Location", 'malina-elements'),
					"param_name" => "address",
					"value" => 'Ontario, CA, USA',
					"description" => __("Enter your location.", 'malina-elements'),
					'admin_label' => true,            
				),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Style", 'malina-elements'),
		            "param_name" => "style",
		            "value" => array(
		            	esc_html__('Blue water','malina-elements') => 'style1',
		            	esc_html__('Simple grayscale','malina-elements') => 'style2',
		            	esc_html__('Light monochrome','malina-elements') => 'style3'
		            ),
		            "description" => __('Select google map style.', 'malina-elements'),
		            'admin_label' => true,
		        ),		
				array(
					"type" => "attach_image",            
					"heading" => __("Map marker", 'malina-elements'),
					"param_name" => "marker_icon",
					"value" => '',
					"description" => __("Select image for your map location icon. Leave blank to use default marker.", 'malina-elements')          
				),
			)
		)
	);
	vc_map( 
		array(
			"name" => __("Malina Page Title", 'malina-elements'),
			"base" => "malinapagetitle",
			"icon" => 'malina-element-icon dashicons dashicons-editor-textcolor',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Display custom page title', 'malina-elements'),
			"params" => array(
				array(
					"type" => "textfield",            
					"heading" => __("Title custom text", 'malina-elements'),
					"param_name" => "title_text",
					"value" => '',
					"description" => __("Enter your page title text. Leave blank to use default page title text.", 'malina-elements'),
					'admin_label' => true,            
				)
			)
		)
	);
	/*
	vc_map( 
		array(
			"name" => __("Malina Hero Section", 'malina-elements'),
			"base" => "malinaherosection",
			"icon" => 'malina-element-icon dashicons dashicons-welcome-view-site',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Display section with image, title, and link divided into two columns.', 'malina-elements'),
			"params" => array(
				array(
					"type" => "attach_image",            
					"heading" => __("First column image", 'malina-elements'),
					"param_name" => "image_column",
					"value" => '',
					"description" => __("Select image for your left column in section.", 'malina-elements')          
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Image size", 'malina-elements'),
					"param_name" => "thumbsize",
					"value" => $imageSizes,
					"description" => __('Select your image size to use in column.', 'malina-elements'),
					"std" => array('full')
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Second column background color", 'malina-elements'),
					"param_name" => "column_bg_color",
					"value" => '',
					"description" => __("Leave empty to use default style.", 'malina-elements')          
				),
				array(
					"type" => "textfield",            
					"heading" => __("Section height", 'malina-elements'),
					"param_name" => "section_height",
					"value" => '',
					"description" => __("Enter your section height", 'malina-elements'),           
				),
				array(
					"type" => "textarea",            
					"heading" => __("Text", 'malina-elements'),
					"param_name" => "title",
					"value" => '',
					"description" => __("Enter your section title text.", 'malina-elements'),
					'admin_label' => true,            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Text font family", 'malina-elements'),
					"param_name" => "default_font",
					"value" => array(
					   __('Default', 'malina-elements') => 'true',
					   __('Google font', 'malina-elements') => 'false',
					),
					"std" => array('true'),
					"description" => __("Leave blank to use your default title font family.", 'malina-elements')            
				),
				array(
					'type' => 'google_fonts',
					'param_name' => 'title_font_family',
					'value' => '',
					'settings' => array(
						'fields' => array(
							'font_family' => 'Montserrat:regular,italic',
							'font_family_description' => __( 'Select font family.', 'malina-elements' ),
							'font_style_description' => __( 'Select font styling.', 'malina-elements' ),
						),
					),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => "false"
				    )
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Text color", 'malina-elements'),
					"param_name" => "title_color",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements')          
				),
				array(
					"type" => "textfield",            
					"heading" => __("Text font size", 'malina-elements'),
					"param_name" => "title_font_size",
					"value" => '68',
					"description" => __("Enter value in px. Do not set (px).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => 'false'
				    )            
				),
				array(
		            'type' => 'iconpicker',
		            'heading' => __( 'Icon', 'malina-elements' ),
		            'param_name' => 'icon',
		            'value' => 'fa fa-bookmark', // default value to backend editor admin_label
		            'settings' => array(
		               'emptyIcon' => false,
		               // default true, display an "EMPTY" icon?
		               'iconsPerPage' => 4000,
		               // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
		            ),
		            'description' => __( 'Select icon from library.', 'malina-elements' ),
		        ),
				array(
					"type" => "colorpicker",            
					"heading" => __("Icon color", 'malina-elements'),
					"param_name" => "icon_color",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements')          
				),
				array(
					"type" => "textfield",            
					"heading" => __("Link text", 'malina-elements'),
					"param_name" => "link_text",
					"value" => '',
					"description" => __("Enter your link text.", 'malina-elements'),            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Link url", 'malina-elements'),
					"param_name" => "link_url",
					"value" => '',
					"description" => __("Enter your link URL. You can add anchor to another section to have scroll to it.", 'malina-elements'),            
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Link color", 'malina-elements'),
					"param_name" => "link_color",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements')          
				),
				array(
					"type" => "hidden_id",            
					"heading" => '',
					"param_name" => "id",
					"value" => $suf,
					"description" => ''            
				),
			)
		)
	);
	vc_map( 
		array(
			"name" => __("Malina Aboutme Section", 'malina-elements'),
			"base" => "malinaaboutmesection",
			"icon" => 'malina-element-icon dashicons dashicons-admin-users',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Display about me section with your image, name, and description.', 'malina-elements'),
			"params" => array(
				array(
					"type" => "attach_image",            
					"heading" => __("Image", 'malina-elements'),
					"param_name" => "image",
					"value" => '',
					"description" => __("Select image for your section.", 'malina-elements')          
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Image size", 'malina-elements'),
					"param_name" => "thumbsize",
					"value" => $imageSizes,
					"description" => __('Select your image size to use in column.', 'malina-elements'),
					"std" => array('full')
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Section background color", 'malina-elements'),
					"param_name" => "section_bg_color",
					"value" => '',
					"description" => __("Leave empty to use default style.", 'malina-elements')          
				),
				array(
					"type" => "textfield",            
					"heading" => __("Title", 'malina-elements'),
					"param_name" => "title",
					"value" => '',
					"description" => __("Enter your section title text.", 'malina-elements'),
					'admin_label' => true,            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Title font family", 'malina-elements'),
					"param_name" => "default_font",
					"value" => array(
					   __('Default', 'malina-elements') => 'true',
					   __('Google font', 'malina-elements') => 'false',
					),
					"std" => array('true'),
					"description" => __("Leave blank to use your default title font family.", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Title font size", 'malina-elements'),
					"param_name" => "title_font_size",
					"value" => '36',
					"description" => __("Enter value in px. Do not set (px).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => 'false'
				    )            
				),
				array(
					'type' => 'google_fonts',
					'param_name' => 'title_font_family',
					'value' => '',
					'settings' => array(
						'fields' => array(
							'font_family' => 'Montserrat:regular,italic',
							'font_family_description' => __( 'Select font family.', 'malina-elements' ),
							'font_style_description' => __( 'Select font styling.', 'malina-elements' ),
						),
					),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => "false"
				    )
				),
				array(
					"type" => "textarea",            
					"heading" => __("Text", 'malina-elements'),
					"param_name" => "text",
					"value" => '',
					"description" => __("Enter your section text.", 'malina-elements'),
					'admin_label' => true,            
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Section text color", 'malina-elements'),
					"param_name" => "text_color",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements')          
				),
				array(
					"type" => "attach_image",            
					"heading" => __("Signature image", 'malina-elements'),
					"param_name" => "signature_image",
					"value" => '',
					"description" => __("Select/upload your signature image.", 'malina-elements'),            
				),
				array(
					"type" => "hidden_id",            
					"heading" => '',
					"param_name" => "id",
					"value" => $suf,
					"description" => ''            
				),
			)
		)
	);*/
}
?>