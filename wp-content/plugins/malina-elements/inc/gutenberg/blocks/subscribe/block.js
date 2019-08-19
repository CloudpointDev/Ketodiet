var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	PanelBody = wp.components.PanelBody,
	__ = wp.i18n.__,
	InspectorControls = wp.editor.InspectorControls,
	SelectControl = wp.components.SelectControl,
    ToggleControl = wp.components.ToggleControl,
    ColorPalette = wp.editor.ColorPalette,
    ColorPicker = wp.editor.ColorPicker,
	PanelColor = wp.components.PanelColor,
	TextAlign = [
		{ label: __('Left', 'malina-elements'), value: 'textleft' },
		{ label: __('Center', 'malina-elements'), value: 'textcenter' },
		{ label: __('Right', 'malina-elements'), value: 'textright' }
	];


registerBlockType( 'malina/subscribe', {
    title: __('Malina Subscribe', 'maline-elements'),

    icon: 'email-alt',

    category: 'malinaelements',

    edit: function( props ) {

		return [

			el( ServerSideRender, {
				block: 'malina/subscribe',
				attributes: props.attributes,
			} ),

			el( InspectorControls, {},
	            el( TextControl, {
					label: __('Subscribe block title', 'maline-elements'),
					value: props.attributes.title,
					onChange: ( value ) => { props.setAttributes( { title: value } ); },
				} ),
			)
			
		];
	},

	// We're going to be rendering in PHP, so save() can just return null.
	save: function() {
		return null;
	},
} );
