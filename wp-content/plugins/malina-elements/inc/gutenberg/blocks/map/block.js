var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	components = wp.components,
	__ = wp.i18n.__,
	InspectorControls = wp.editor.InspectorControls,
	SelectControl = wp.components.SelectControl,
    ToggleControl = wp.components.ToggleControl,
    MediaUpload = wp.editor.MediaUpload,
	MapStyles = [
		{ label: __('Blue water', 'malina-elements'), value: 'style1' },
		{ label: __('Simple grayscale', 'malina-elements'), value: 'style2' },
		{ label: __('Light monochrome', 'malina-elements'), value: 'style3' },
		{ label: __('Dark theme', 'malina-elements'), value: 'style4' }
	];

registerBlockType( 'malina/map', {
    title: __('Malina Google Map', 'maline-elements'),

    icon: 'location-alt',

    category: 'malinaelements',

    edit: function( props ) {
    	var onSelectImage = function( media ) {
			return props.setAttributes( {
				marker_url: media.url,
				marker_icon: media.id,
			} );
		};
		return [
			el( 'div', { 
				className: 'malina-google-map-block'
				},
				el('h3',{className:'malina-google-map-title'}, 
					el('span',{className:'fa fa-map'},__('Malina google map', 'malina-elements'))
				)
			),
			el( InspectorControls, {},
				el( TextControl, {
					label: __('Address', 'maline-elements'),
					help: __("Enter your address", 'malina-elements') ,
					value: props.attributes.address,
					onChange: ( value ) => { props.setAttributes( { address: value } ); },
				} ),
	            el( SelectControl,
	                {
	                    label: __('Map style', 'maline-elements'),
	                    help : __('Select your map style', 'malina-elements'),
	                    value: props.attributes.style,
	                    onChange: ( value ) => { props.setAttributes( { style: value } ); },
	                    options: MapStyles,
	                }
	            ),
	            el('p',{}, __('Map marker', 'malina-elements') 

	            ),
	            el( MediaUpload, {
						onSelect: onSelectImage,
						type: 'image',
						value: props.attributes.marker_icon,
						render: function( obj ) {
							return el( components.Button, {
								className: props.attributes.marker_icon ? 'image-button' : 'button button-large',
								onClick: obj.open
								},
								! props.attributes.marker_icon ? __( 'Upload Image', 'malina-elements' ) : el( 'img', { src: props.attributes.marker_url } )
							);
						}
					}
				),
				el( TextControl, {
					label: __('Map height', 'maline-elements'),
					help: __("Enter your map height without 'px'", 'malina-elements') ,
					value: props.attributes.map_height,
					onChange: ( value ) => { props.setAttributes( { map_height: value } ); },
				} ),
			),
		];
	},

	// We're going to be rendering in PHP, so save() can just return null.
	save: function() {
		return null;
	},
} );
