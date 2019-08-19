var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	__ = wp.i18n.__,
	InspectorControls = wp.editor.InspectorControls,
	SelectControl = wp.components.SelectControl,
    ToggleControl = wp.components.ToggleControl,
    carousel = null,
	TrueFalse = [{ label: 'Yes', value: 'true' }, { label: 'No', value: 'false' }];

registerBlockType( 'malina/sidebar', {
    title: __('Malina Sidebar', 'maline-elements'),

    icon: 'post-status',

    category: 'malinaelements',

    edit: function( props ) {

		return [
			el( 'div', { 
				className: 'malina-element-block'
				},
				el('h3',{className:'malina-block-title'}, 
					el('span',{className:'fa fa-columns'},__('Sidebar', 'malina-elements'))
				)
			),
			
		];
	},

	// We're going to be rendering in PHP, so save() can just return null.
	save: function() {
		return null;
	},
} );
