var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	__ = wp.i18n.__,
	InspectorControls = wp.editor.InspectorControls,
	SelectControl = wp.components.SelectControl,
    ToggleControl = wp.components.ToggleControl,
	ImageSizes = [
		{ label: __('Medium', 'malina-elements'), value: 'medium' },
		{ label: __('Large', 'malina-elements'), value: 'large' },
		{ label: __('Post thumbnail', 'malina-elements'), value: 'post-thumbnail' },
		{ label: __('Malina masonry', 'malina-elements'), value: 'malina-masonry' },
		{ label: __('Malina extra medium', 'malina-elements'), value: 'malina-extra-medium' },
		{ label: __('Malina Slider', 'malina-elements'), value: 'malina-slider' },
		{ label: __('Full', 'malina-elements'), value: 'full' }
	];

registerBlockType( 'malina/singlepost', {
    title: __('Malina Single Post', 'maline-elements'),

    icon: 'megaphone',

    category: 'malinaelements',

    edit: function( props ) {
		return [
			/*
			 * The ServerSideRender element uses the REST API to automatically call
			 * php_block_render() in your PHP code whenever it needs to get an updated
			 * view of the block.
			 */
			el( ServerSideRender, {
				block: 'malina/singlepost',
				attributes: props.attributes,
			} ),
			/*
			 * InspectorControls lets you add controls to the Block sidebar. In this case,
			 * we're adding a TextControl, which lets us edit the 'foo' attribute (which
			 * we defined in the PHP). The onChange property is a little bit of magic to tell
			 * the block editor to update the value of our 'foo' property, and to re-render
			 * the block.
			 */
			el( InspectorControls, {},
				el( TextControl, {
					label: __('Post ID', 'maline-elements'),
					help: __("Enter posts ID to display only those record.", 'malina-elements') ,
					value: props.attributes.post_id,
					onChange: ( value ) => { props.setAttributes( { post_id: value } ); },
				} ),
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
                        label: __('Display categories?','malina-elements'),
                        help: __('Show categories above the title?', 'malina-elements'),
                        checked: props.attributes.display_categories,
                        onChange: function (event) {
                            props.setAttributes({display_categories: !props.attributes.display_categories});
                        }
                    }
                )
			),
		];
	},

	// We're going to be rendering in PHP, so save() can just return null.
	save: function() {
		return null;
	},
} );
