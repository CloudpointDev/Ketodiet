<?php
function malina_contactform_block() {
	// Scripts.
	wp_register_script(
		'malinacontactform-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/contactform/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n' ) // Dependencies, defined above.
	);

	// Styles.
	wp_register_style(
		'malinacontactform-block-editor-style', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/contactform/editor.css', // Block editor CSS.
		array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
	);

	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/contactform', array(
		'editor_script' => 'malinacontactform-block-script',
		'attributes'      => array(
			'contactform' => array(
				'type' => 'string',
				'default' => ''
			),
		),
		'render_callback' => 'MalinaContactFormConvert',
	) );

}
add_action( 'init', 'malina_contactform_block' );
function MalinaContactFormConvert($attributes){
	$out = '';
	$out = $attributes['contactform'];
	if($out != ''){
		return do_shortcode($out);
	} else {
		return esc_html__('You need to insert shortcode for your form from "Contact Form 7" plugin or similar.', 'malina-elements');
	}
	
}