<?php
function malina_singlepost_block() {
	// Scripts.
	wp_register_script(
		'malina-singlepost-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/singlepost/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n' ) // Dependencies, defined above.
	);

	// Styles.
	wp_register_style(
		'malina-singlepost-block-editor-style', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/singlepost/editor.css', // Block editor CSS.
		array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
	);

	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/singlepost', array(
		'editor_script' => 'malina-singlepost-block-script',
		'editor_style' => 'malina-singlepost-block-editor-style',
		'attributes'      => array(
			'post_id' => array(
				'type' => 'string',
			),
			'thumbsize' => array(
				'type' => 'string',
				'default' => 'full'
			),
			'display_categories' => array(
				'type' => 'boolean',
				'default' => 1
			),
		),
		'render_callback' => 'MalinaSinglePostConvert',
	) );

}
add_action( 'init', 'malina_singlepost_block' );
function MalinaSinglePostConvert($attributes){
	extract(shortcode_atts(array(
      	'post_id' => '',
      	'thumbsize'		=> 'full',
      	'display_categories' => 'true',
    ), $attributes));

	$out = '[singlepost post_ids="'.$post_id.'" thumbsize="'.$thumbsize.'" show_categories="'.$display_categories.'"]';
	return do_shortcode($out);
}