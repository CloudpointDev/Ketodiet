<?php

/* ----------------------------------------------------- 
 * Post Slides Metabox
 * ----------------------------------------------------- */
add_filter( 'rwmb_meta_boxes', 'malina_register_meta_boxes' );
function malina_register_meta_boxes($meta_boxes) {
    $prefix = 'malina_';

	/* ----------------------------------------------------- */
	// Post Slides Metabox
	/* ----------------------------------------------------- */
	$meta_boxes[] = array(
		'id'		=> 'post_layout',
		'title'		=> esc_html__('Single Post Layout','malina-elements'),
		'pages'		=> array( 'post' ),
		'context' => 'normal',
		'fields'	=> array(
			array(
	    	   'name' => esc_html__('Single post layout', 'malina-elements'),
	    	   'desc' => esc_html__('Select layout type.', 'malina-elements'),
	    	   'id' => $prefix . 'post_layout',
	    	   'type' => 'select',
	    	   'options'  => array(
	    	   		'default' => esc_html__('Default', 'malina-elements'),
	    	   		'standard' => esc_html__('Standard', 'malina-elements'),
	    	   		'wide' => esc_html__('Wide', 'malina-elements'),
	    	   		'fullwidth' => esc_html__('Fullwidth', 'malina-elements'),
	    	   		'fullwidth-alt' => esc_html__('Fullwidth Alt', 'malina-elements'),
	    	   		'fullwidth-alt2' => esc_html__('Fullwidth Alt 2', 'malina-elements'),
	    	   		'sideimage' => esc_html__('Side', 'malina-elements')
	    	   	),
			   'std' => array('default')
	    	),
	    	array(
			    'name' => esc_html__('Post sidebar', 'malina-elements'),
			    'desc' => esc_html__('Select sidebar position.', 'malina-elements'),
			    'id'   => $prefix . 'post_sidebar',
			    'type' => 'select',
			    'options' => array(
			    	'default' => esc_html__('Default', 'malina-elements'),
			    	'sidebar-right' => esc_html__('Sidebar right', 'malina-elements'),
			    	'sidebar-left' => esc_html__('Sidebar left', 'malina-elements'),
			    	'none' => esc_html__('No sidebar', 'malina-elements'),
			    ),
			    'std'  => array('default'),
			),
			array(
	    	   'name' => esc_html__('Featured post', 'malina-elements'),
	    	   'desc' => esc_html__('Check this if you need to highlight post for posts list view.', 'malina-elements'),
	    	   'id' => $prefix . 'post_featured',
	    	   'type' => 'checkbox',
			   'std' => 0
	    	),
	    	array(
			    'name' => esc_html__('Post format on preview', 'malina-elements'),
			    'desc' => esc_html__('Select what you need to display on preview, featured image or post format (video, gallery, audio, etc.)', 'malina-elements'),
			    'id'   => $prefix . 'display_featured_img_instead',
			    'type' => 'select',
			    'options' => array(
			    	'true' => esc_html__('Default', 'malina-elements'),
			    	'default' => esc_html__('Show post format', 'malina-elements'),
			    	'false' => esc_html__('Show featured image', 'malina-elements')
			    ),
			    'std'  => array('true'),
			),
			array(
	    	   'name' => esc_html__('Disable footer?', 'malina-elements'),
	    	   'id' => $prefix . 'display_page_footer',
	    	   'type' => 'checkbox',
	    	   'std' => 0
	    	),
	    	array(
	    	   'name' => esc_html__('Sticky sharebox', 'malina-elements'),
	    	   'desc' => esc_html__('Check to enable vertical sticky sharebox.', 'malina-elements'),
	    	   'id' => $prefix . 'post_sticky_sharebox',
	    	   'type' => 'checkbox',
			   'std' => 0
	    	),
		)
	);
	$meta_boxes[] = array(
		'id'		=> 'post_standard',
		'title'		=> esc_html__('Post Embed','malina-elements'),
		'pages'		=> array( 'post' ),
		'context' => 'normal',
		'fields'	=> array(
			array(
				'name'	=> esc_html__('Embed Url','malina-elements'),
				'desc'	=> esc_html__('This area used for the media content. If you need to show some media embeds for "Standard" post format instead featured image, use this field. It supports ', 'malina-elements').'<a href="https://codex.wordpress.org/Embeds"> '.esc_html__('many media websites','malina-elements').'</a>',
				'id'	=> $prefix . 'post_format_embed',
				'type'	=> 'oembed',
			),
			array(
	    	   'name' => esc_html__('Display on single post?', 'malina-elements'),
	    	   'desc' => esc_html__('Check this if you need to display embed media on single post view. Featured image will be disabled.', 'malina-elements'),
	    	   'id' => $prefix . 'post_format_embed_replace',
	    	   'type' => 'checkbox',
			   'std' => 0
	    	),
		)
	);
	$meta_boxes[] = array(
		'id'		=> 'post_slides',
		'title'		=> esc_html__('Post Gallery','malina-elements'),
		'pages'		=> array( 'post' ),
		'context' => 'normal',
		'fields'	=> array(
			array(
				'name'	=> esc_html__('Post Gallery Images','malina-elements'),
				'desc'	=> esc_html__('Upload up to 30 project images for a slideshow - or only one to display a single image.','malina-elements'),
				'id'	=> $prefix . 'gallery_images',
				'type'	=> 'image_advanced',
				'max_file_uploads' => 30
			),
			array(
	    	   'name' => esc_html__('Gallery layout', 'malina-elements'),
	    	   'desc' => esc_html__('Select gallery layout type.', 'malina-elements'),
	    	   'id' => $prefix . 'gallery_post_layout',
	    	   'type' => 'select',
	    	   'options' => array(
			    	'slideshow' => esc_html__('Slideshow', 'malina-elements'),
			    	'slideshow_2' => esc_html__('Slideshow Alt', 'malina-elements'),
			    	'slideshow_thumb' => esc_html__('Slideshow with thumbs', 'malina-elements'),
			    ),
			    'std'  => array('slideshow'),
	    	),
	    	array(
	    	   'name' => esc_html__('Auto slideshow', 'malina-elements'),
	    	   'desc' => esc_html__('Check this if you need to have slideshow in your gallery.', 'malina-elements'),
	    	   'id' => $prefix . 'gallery_autoplay',
	    	   'type' => 'checkbox',
			   'std' => 0
	    	),
	    	array(
	    	   'name' => esc_html__('Auto height', 'malina-elements'),
	    	   'desc' => esc_html__('Check this if you need to resize slider height regarding to image size.', 'malina-elements'),
	    	   'id' => $prefix . 'gallery_autoheight',
	    	   'type' => 'checkbox',
			   'std' => 0
	    	),
	    	array(
	    	   'name' => esc_html__('Loop items', 'malina-elements'),
	    	   'desc' => esc_html__('Check this if you need to have loop in your gallery.', 'malina-elements'),
	    	   'id' => $prefix . 'gallery_loop',
	    	   'type' => 'checkbox',
			   'std' => 0
	    	),

		)
	);
	$meta_boxes[] = array(
		'id'		=> 'post_video',
		'title'		=> esc_html__('Post Video','malina-elements'),
		'pages'		=> array( 'post' ),
		'context' => 'normal',
		'fields'	=> array(
			array(
				'name'	=> esc_html__('Video URL','malina-elements'),
				'desc'	=> esc_html__('This area used for video post format. This field offers live preview the media content. It supports self-hosted video and video from ', 'malina-elements').'<a href="https://codex.wordpress.org/Embeds"> '.esc_html__('many media websites','malina-elements').'</a>',
				'id'	=> $prefix . 'post_format_video',
				'type'	=> 'oembed',
			),
		)
	);
	$meta_boxes[] = array(
		'id'		=> 'post_audio',
		'title'		=> esc_html__('Post audio','malina-elements'),
		'pages'		=> array( 'post' ),
		'context' => 'normal',
		'fields'	=> array(
			array(
				'name'	=> esc_html__('Audio','malina-elements'),
				'desc'	=> esc_html__('This area used for audio post format. You can use self-hosted audio (mp3, m4a, ogg, wav, wma) or from link to soundcloud, mixcloud, reverbnation, spotify item.','malina-elements'),
				'id'	=> $prefix . 'post_format_audio',
				'type'	=> 'text',
			)

		)
	);
	$meta_boxes[] = array(
		'id'		=> 'post_quote',
		'title'		=> esc_html__('Post Quote','malina-elements'),
		'pages'		=> array( 'post' ),
		'context' => 'normal',
		'fields'	=> array(
			array(
				'name'	=> esc_html__('Quote text','malina-elements'),
				'id'	=> $prefix . 'post_format_quote_text',
				'type'	=> 'textarea',
			),
			array(
				'name'	=> esc_html__('Quote author','malina-elements'),
				'id'	=> $prefix . 'post_format_quote_cite',
				'type'	=> 'text',
			),
			array(
				'name'	=> esc_html__('Background color','malina-elements'),
				'desc'	=> esc_html__('Leave empty to use default theme colors.','malina-elements'),
				'id'	=> $prefix . 'post_format_quote_bg_color',
				'type'	=> 'color',
			),
			array(
				'name'	=> esc_html__('Quote text color','malina-elements'),
				'desc'	=> esc_html__('Leave empty to use default theme colors.','malina-elements'),
				'id'	=> $prefix . 'post_format_quote_text_color',
				'type'	=> 'color',
			),
		)
	);
	$meta_boxes[] = array(
		'id'		=> 'post_link',
		'title'		=> esc_html__('Post link','malina-elements'),
		'pages'		=> array( 'post' ),
		'context' => 'normal',
		'fields'	=> array(
			array(
				'name'	=> esc_html__('Link','malina-elements'),
				'desc'	=> esc_html__('This area used for link post format. If you need extarnal link, please input.','malina-elements'),
				'id'	=> $prefix . 'post_format_link',
				'type'	=> 'text',
			),
			array(
				'name'	=> esc_html__('Title','malina-elements'),
				'desc'	=> esc_html__('Input title for your external link.','malina-elements'),
				'id'	=> $prefix . 'post_format_link_title',
				'type'	=> 'text',
			),
		)
	);

	global $wp_registered_sidebars;
	$sidebars = array();
	$sidebars['none'] = esc_html__('None', 'malina-elements');
	if(!empty($wp_registered_sidebars)){
		foreach ($wp_registered_sidebars as $sidebar ) {
			$sidebars[$sidebar['id']]=$sidebar['name'];
		}
	}
	unset($sidebars['wpmm']);
	$meta_boxes[] = array(
		'id'		=> 'header_style',
		'title'		=> esc_html__('Page settings','malina-elements'),
		'pages'		=> array( 'page' ),
		'context' => 'normal',
		'fields'	=> array(
			array(
	    	   'name' => esc_html__('Header variant', 'malina-elements'),
	    	   'desc' => esc_html__('Select header style. Default is style from theme options.', 'malina-elements'),
	    	   'id' => $prefix . 'header_variant',
	    	   'type' => 'select',
			    'options' => array(
			    	'default' => esc_html__('Default', 'malina-elements'),
			    	'header-version1' => esc_html__('Simple header', 'malina-elements'),
			    	'header-version2' => esc_html__('Side header', 'malina-elements'),
			    	'header-version3' => esc_html__('Vertical menu', 'malina-elements'),
			    	'header-version4' => esc_html__('Horizontal header', 'malina-elements'),
			    	'header-version5' => esc_html__('Header center logo', 'malina-elements'),
			    	'header-version6' => esc_html__('Overlay header', 'malina-elements'),
			    	'header-custom' => esc_html__('Header custom', 'malina-elements'),
			    ),
			    'std'  => array('default'),
	    	),
	    	array(
	    	   'name' => esc_html__('Header background', 'malina-elements'),
	    	   'desc' => esc_html__('Setup background parameters if you need custom header on this page.', 'malina-elements'),
	    	   'id' => $prefix . 'header_background',
	    	   'type' => 'background',
			   'std'  => '',
	    	),
	    	array(
	    	   'name' => esc_html__('Header bottom line', 'malina-elements'),
	    	   'desc' => esc_html__('Check this if you need to disable border line.', 'malina-elements'),
	    	   'id' => $prefix . 'header_bottom_border',
	    	   'type' => 'checkbox',
			   'std' => 0
	    	),
	    	array(
	    	   'name' => esc_html__('Body background', 'malina-elements'),
	    	   'desc' => esc_html__('Setup background parameters if you need custom background color on page.', 'malina-elements'),
	    	   'id' => $prefix . 'body_background',
	    	   'type' => 'color',
			   'std'  => '',
	    	),
	    	array(
			    'id' => $prefix . 'display_page_footer',
			    'name'      => esc_html__('Disable footer?', 'malina-elements'),
			    'type'      => 'switch',
			    'style'     => 'rounded',
			    'on_label'  => 'Yes',
			    'off_label' => 'No',
			),
			array(
	    	   'name' => esc_html__('Footer background', 'malina-elements'),
	    	   'desc' => esc_html__('Setup background parameters if you need custom background color on this page.', 'malina-elements'),
	    	   'id' => $prefix . 'footer_background',
	    	   'type' => 'background',
			   'std'  => '',
	    	),
	    	array(
				'name'	=> esc_html__('Footer socials color','malina-elements'),
				'desc'	=> esc_html__('Leave empty to use default theme colors.','malina-elements'),
				'id'	=> $prefix . 'footer_socials_color',
				'type'	=> 'color',
			),
	    	array(
	    	   'name' => esc_html__('Footer instagram', 'malina-elements'),
	    	   'id' => $prefix . 'display_instagram',
	    	   'type' => 'select',
			   'options' => array(
			   		'enable' => esc_html__('Enable', 'malina-elements'),
			    	'disbale' => esc_html__('Full disable', 'malina-elements'),
			    	'disable-items' => esc_html__('Disable items', 'malina-elements'),
			    	'disable-link' => esc_html__('Disable follow link', 'malina-elements')
			    ),
			    'std'  => array('enable'),
	    	),
	    	array(
	    	   'name' => esc_html__('Page sidebar', 'malina-elements'),
	    	   'desc' => esc_html__('Select your sidebar if you want to use another sidebar on this page. Works with next page templates: "Default template" and "Page: Left sidebar"','malina-elements'),
	    	   'id' => $prefix . 'page_sidebar',
	    	   'type' => 'select',
			   'options' => $sidebars,
			   'std'  => array('blog-widgets'),
	    	),
		)
	);
	$meta_boxes[] = array(
		'id'		=> 'page_title',
		'title'		=> esc_html__('Page title','malina-elements'),
		'pages'		=> array( 'page' ),
		'context' => 'side',
		'priority' => 'low',
		'fields'	=> array(
	    	array(
	    	   'name' => esc_html__('Hide title', 'malina-elements'),
	    	   'desc' => esc_html__('Check this to hide page title.', 'malina-elements'),
	    	   'id' => $prefix . 'page_title_hide',
	    	   'type' => 'checkbox',
			   'std' => 0
	    	),
	    	array(
	    	   'name' => esc_html__('Title position', 'malina-elements'),
	    	   'id' => $prefix . 'page_title_position',
	    	   'type' => 'select',
			   'options' => array(
			   		'textleft' => esc_html__('Left', 'malina-elements'),
			    	'textcenter' => esc_html__('Center', 'malina-elements'),
			    	'textright' => esc_html__('Right', 'malina-elements')
			    ),
			    'std'  => array('textcenter'),
	    	),
		)
	);
	$image_sizes = get_intermediate_image_sizes();
	$image_sizes[]= 'full';
	$image_sizes = array_combine($image_sizes, $image_sizes);
	$meta_boxes[] = array(
		'id'		=> 'page_hero_header',
		'title'		=> esc_html__('Page hero section','malina-elements'),
		'pages'		=> array( 'page' ),
		'context' => 'side',
		'priority' => 'low',
		'fields'	=> array(
	    	array(
	    	   'name' => esc_html__('Hero section', 'malina-elements'),
	    	   'id' => $prefix . 'page_hero_section',
	    	   'type' => 'select',
			   'options' => array(
			   		'disable' => esc_html__('Disable', 'malina-elements'),
			    	'herosection' => esc_html__('Image & posts carousel', 'malina-elements'),
			    	'slider' => esc_html__('Slider', 'malina-elements')
			    ),
			    'std'  => array('disable'),
	    	),
	    	array(
			    'name' => esc_html__('Section padding', 'malina-elements'),
			    'desc' => esc_html__('Do not set "px".', 'malina-elements'),
			    'id'   => $prefix . 'page_herosection_padding',
			    'type' => 'fieldset_text',
			    'options' => array(
			        'top'    => esc_html__('top','malina-elements'),
			        'right' => esc_html__('right','malina-elements'),
			        'bottom'   => esc_html__('bottom','malina-elements'),
			        'left'   => esc_html__('left','malina-elements')
			    ),
			    'clone' => false
			),
	    	array(
			    'type' => 'heading',
			    'name' => esc_html__('Image & posts carousel', 'malina-elements'),
			    'desc' => esc_html__('Use options below if you select "Image & posts carousel" hero section', 'malina-elements'),
			),
			array(
				'name'	=> esc_html__('Welcome text','malina-elements'),
				'id'	=> $prefix . 'page_herosection_hellotext',
				'desc' => esc_html__('Leave blank if you need not text over your featured image.', 'malina-elements'),
				'type'	=> 'text',
			),
			array(
			    'type' => 'heading',
			    'name' => '',
			    'desc' => esc_html__('For image use featured image option" hero section', 'malina-elements'),
			),
			array(
			    'name'        => esc_html__('Select posts to show', 'malina-elements'),
			    'id'          =>  $prefix . 'page_herosection_posts',
			    'type'        => 'post',
			    'post_type'   => 'post',
			    'multiple' => true,
			    // Field type.
			    'field_type'  => 'select_advanced',
			    'placeholder' => esc_html__('Select posts', 'malina-elements'),
			    'query_args'  => array(
			        'post_status'    => 'publish',
			        'posts_per_page' => - 1,
			    ),
			),
			array(
			    'name' => esc_html__('Posts count', 'malina-elements'),
			    'desc' => esc_html__('Select posts count to display posts', 'malina-elements'),
			    'id'   => $prefix . 'page_herosection_posts_count',
			    'type' => 'number',
			    'std' => 3,
			    'min'  => 3,
			    'step' => 1,
			),
			array(
	    	   'name' => esc_html__('Carousel slideshow', 'malina-elements'),
	    	   'id' => $prefix . 'page_herosection_slideshow',
	    	   'type' => 'select',
			   'options' => array(
			   		'true' => esc_html__('Yes', 'malina-elements'),
			    	'false' => esc_html__('No', 'malina-elements'),
			    ),
			    'std'  => array('true'),
	    	),
			array(
	    	   'name' => esc_html__('Carousel arrows', 'malina-elements'),
	    	   'id' => $prefix . 'page_herosection_nav',
	    	   'type' => 'select',
			   'options' => array(
			   		'true' => esc_html__('Show', 'malina-elements'),
			    	'false' => esc_html__('Hide', 'malina-elements'),
			    ),
			    'std'  => array('true'),
	    	),
			array(
			    'type' => 'heading',
			    'name' => esc_html__('Slider', 'malina-elements'),
			    'desc' => esc_html__('Use options below if you select "Slider" hero section', 'malina-elements'),
			),
			array(
			    'name'        => esc_html__('Select posts to show', 'malina-elements'),
			    'id'          =>  $prefix . 'page_herosection_slider_posts',
			    'type'        => 'post',
			    'post_type'   => 'post',
			    'multiple' => true,
			    // Field type.
			    'field_type'  => 'select_advanced',
			    'placeholder' => esc_html__('Select posts', 'malina-elements'),
			    'query_args'  => array(
			        'post_status'    => 'publish',
			        'posts_per_page' => - 1,
			        'order' => 'post__in'
			    ),
			),
			array(
			    'name' => esc_html__('Posts count', 'malina-elements'),
			    'desc' => esc_html__('Select posts count to display posts', 'malina-elements'),
			    'id'   => $prefix . 'page_herosection_slider_posts_count',
			    'type' => 'number',
			    'std' => 3,
			    'min'  => 3,
			    'step' => 1,
			),
			array(
	    	   'name' => esc_html__('Slider style', 'malina-elements'),
	    	   'id' => $prefix . 'page_herosection_slider_style',
	    	   'type' => 'select',
			   'options' => array(
		        	'center' => esc_html__('Centered', 'malina-elements'),
		        	'center2' => esc_html__('Two Centered', 'malina-elements'),
		        	'simple' => esc_html__( 'Simple', 'malina-elements' ),
		        	'two_per_row' => esc_html__( 'Two in row', 'malina-elements' ),
		        	'three_per_row' => esc_html__( 'Three per row', 'malina-elements' )
		        ),
			    'std'  => array('center'),
	    	),
	    	array(
	    	   'name' => esc_html__('Slider width', 'malina-elements'),
	    	   'id' => $prefix . 'page_herosection_slider_width',
	    	   'type' => 'select',
			   'options' => array(
		        	'fullwidth' => esc_html__('Fullwidth', 'malina-elements'),
		        	'container' => esc_html__( 'Container', 'malina-elements' )
		        ),
			    'std'  => array('fullwidth'),
	    	),
	    	array(
			    'name' => esc_html__('Slider height', 'malina-elements'),
			    'desc' => esc_html__('Enter slider height in (px)', 'malina-elements'),
			    'id'   => $prefix . 'page_slider_height',
			    'type' => 'number'
			),
	    	array(
	    	   'name' => esc_html__('Image size', 'malina-elements'),
	    	   'id' => $prefix . 'page_herosection_slider_image_size',
	    	   'type' => 'select',
			   'options' => $image_sizes,
			    'std'  => array('large'),
	    	),
			array(
	    	   'name' => esc_html__('Slider slideshow', 'malina-elements'),
	    	   'id' => $prefix . 'page_herosection_slider_slideshow',
	    	   'type' => 'select',
			   'options' => array(
			   		'true' => esc_html__('Yes', 'malina-elements'),
			    	'false' => esc_html__('No', 'malina-elements'),
			    ),
			    'std'  => array('true'),
	    	),
			array(
	    	   'name' => esc_html__('Slider loop', 'malina-elements'),
	    	   'id' => $prefix . 'page_herosection_slider_loop',
	    	   'type' => 'select',
			   'options' => array(
			   		'true' => esc_html__('Yes', 'malina-elements'),
			    	'false' => esc_html__('No', 'malina-elements'),
			    ),
			    'std'  => array('true'),
	    	),
	    	array(
	    	   'name' => esc_html__('Show date', 'malina-elements'),
	    	   'id' => $prefix . 'page_herosection_slider_date',
	    	   'type' => 'select',
			   'options' => array(
			   		'true' => esc_html__('Yes', 'malina-elements'),
			    	'false' => esc_html__('No', 'malina-elements'),
			    ),
			    'std'  => array('true'),
	    	),
	    	array(
	    	   'name' => esc_html__('Show readmore', 'malina-elements'),
	    	   'id' => $prefix . 'page_herosection_slider_readmore',
	    	   'type' => 'select',
			   'options' => array(
			   		'false' => esc_html__('No', 'malina-elements'),
			   		'true' => esc_html__('Yes', 'malina-elements'),
			    ),
			    'std'  => array('false'),
	    	),

		)
	);
	return $meta_boxes;
}
