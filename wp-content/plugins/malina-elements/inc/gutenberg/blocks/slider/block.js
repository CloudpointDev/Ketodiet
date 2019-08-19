var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	__ = wp.i18n.__,
	InspectorControls = wp.editor.InspectorControls,
	SelectControl = wp.components.SelectControl,
    ToggleControl = wp.components.ToggleControl,
    carousel = null,
    apiFetch = wp.apiFetch;
	TrueFalse = [{ label: 'Yes', value: 'true' }, { label: 'No', value: 'false' }],
	ImageSizes = [
		{ label: __('Medium', 'malina-elements'), value: 'medium' },
		{ label: __('Large', 'malina-elements'), value: 'large' },
		{ label: __('Post thumbnail', 'malina-elements'), value: 'post-thumbnail' },
		{ label: __('Malina masonry', 'malina-elements'), value: 'malina-masonry' },
		{ label: __('Malina extra medium', 'malina-elements'), value: 'malina-extra-medium' },
		{ label: __('Malina Slider', 'malina-elements'), value: 'malina-slider' },
		{ label: __('Full', 'malina-elements'), value: 'full' }
	],
	DescStyles = [
		{ label: __('Style 1', 'malina-elements'), value: 'style_1' }, 
		{ label: __('Style 2', 'malina-elements'), value: 'style_2' },
		{ label: __('Style 3', 'malina-elements'), value: 'style_3' },
		{ label: __('Style 4', 'malina-elements'), value: 'style_4' },
		{ label: __('Style 5', 'malina-elements'), value: 'style_5' },
	];

	const postSelections = [];
	const allPosts = apiFetch({path: "/wp/v2/posts/?per_page=100"}).then(posts => {
	    $.each( posts, function( key, val ) {
	        postSelections.push({label: val.title.rendered, value: val.id});
	    });
	    return postSelections;
	});

registerBlockType( 'malina/postslider', {
    title: __('Malina Slider Posts', 'maline-elements'),

    icon: 'slides',

    category: 'malinaelements',

    edit: function( props ) {

		return [
			el( 'div', { 
				className: 'malina-element-block'
				},
				el('h3',{className:'malina-block-title'}, 
					el('span',{className:'fa fa-images'},__('Posts slider', 'malina-elements'))
				)
			),

			el( InspectorControls, {},
				el( TextControl, {
					label: __('Posts count', 'maline-elements'),
					value: props.attributes.number_posts,
					onChange: ( value ) => { props.setAttributes( { number_posts: value } ); },
				} ),
				el( SelectControl,
	                {
	                	multiple: true,
	                    label: __('Select posts to show', 'maline-elements'),
	                    value: props.attributes.post_ids,
	                    onChange: ( value ) => { props.setAttributes( { post_ids: value } ); },
	                    options: postSelections,
	                }
	            ),
	            el( SelectControl,
	                {
	                    label: __('Description Style', 'maline-elements'),
	                    value: props.attributes.description_style,
	                    onChange: ( value ) => { props.setAttributes( { description_style: value } ); },
	                    options: DescStyles,
	                }
	            ),
	            el( SelectControl,
	                {
	                    label: __('Thumbnail size', 'maline-elements'),
	                    help : __('Select your image size to use.', 'malina-elements'),
	                    value: props.attributes.thumbsize,
	                    onChange: ( value ) => { props.setAttributes( { thumbsize: value } ); },
	                    options: ImageSizes,
	                }
	            ),
	            el( ToggleControl,
                    {
                        label: __('Overlay', 'malina-elements'),
                        checked: props.attributes.overlay,
                        onChange: function (event) {
                            props.setAttributes({overlay: !props.attributes.overlay});
                        }
                    }
                ),
				el( ToggleControl,
	                {
	                    label: __('Slideshow', 'maline-elements'),
	                    help: __('You can enable/disable slides autoplay','malina-elements'),
	                    checked: props.attributes.slideshow,
	                    onChange: function (event) {
                            props.setAttributes({slideshow: !props.attributes.slideshow});
                        }
	                }
	            ),
	            el( ToggleControl,
                    {
                        label: 'Loop',
                        help: __('You can enable/disable slides loop', 'malina-elements'),
                        checked: props.attributes.loop,
                        onChange: function (event) {
                            props.setAttributes({loop: !props.attributes.loop});
                        }
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Slider Arrows', 'malina-elements'),
                        checked: props.attributes.nav,
                        onChange: function (event) {
                            props.setAttributes({nav: !props.attributes.nav});
                        }
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Slider bullets', 'malina-elements'),
                        checked: props.attributes.show_dots,
                        onChange: function (event) {
                            props.setAttributes({show_dots: !props.attributes.show_dots});
                        }
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Show categories', 'malina-elements'),
                        checked: props.attributes.show_categories,
                        onChange: function (event) {
                            props.setAttributes({show_categories: !props.attributes.show_categories});
                        }
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Show date', 'malina-elements'),
                        checked: props.attributes.show_date,
                        onChange: function (event) {
                            props.setAttributes({show_date: !props.attributes.show_date});
                        }
                    }
                ),
			),
		];
	},

	// We're going to be rendering in PHP, so save() can just return null.
	save: function() {
		return null;
	},
} );
