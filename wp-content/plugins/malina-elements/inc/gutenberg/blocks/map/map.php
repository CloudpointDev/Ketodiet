<?php
function malina_map_block() {
	// Scripts.
	wp_register_script(
		'malina-map-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/map/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n' ) // Dependencies, defined above.
	);

	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/map', array(
		'editor_script' => 'malina-map-block-script',
		'attributes'      => array(
			'address' => array(
				'type' => 'string',
			),
			'style' => array(
				'type' => 'string',
				'default' => 'style1'
			),
			'marker_icon' => array(
				'type' => 'number',
				'default' => ''
			),
			'marker_url' => array(
				'type' => 'string',
				'default' => ''
			),
			'map_height' => array(
				'type' => 'string',
				'default' => ''
			),
		),
		'render_callback' => 'MalinaMapConvert',
	) );

}
add_action( 'init', 'malina_map_block' );
function MalinaMapConvert($attributes){
	extract(shortcode_atts(array(
      	'address' => 'Ontario, CA, USA',
      	'style' => 'style4',
      	'marker_icon' => '',
      	'map_height' => ''
    ), $attributes));

	$out = '[malinagooglemap address="'.$address.'" style="'.$style.'" marker_icon="'.$marker_icon.'" map_height="'.$map_height.'"]';
	return do_shortcode($out);
}