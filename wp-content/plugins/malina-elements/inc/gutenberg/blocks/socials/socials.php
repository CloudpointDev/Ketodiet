<?php
function malina_socials_block() {
	// Scripts.
	wp_register_script(
		'malinasocials-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/socials/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n' ) // Dependencies, defined above.
	);

	// Styles.
	wp_register_style(
		'malinasocials-block-editor-style', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/socials/editor.css', // Block editor CSS.
		array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
	);

	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/socials', array(
		'editor_script' => 'malinasocials-block-script',
		'attributes'      => array(
			'links_color' => array(
				'type' => 'string',
				'default' => ''
			),
			'bg_color' => array(
				'type' => 'string',
				'default' => ''
			),
			'block_id' => array(
				'type' => 'string',
				'default' => ''
			),
			'icons_align' => array(
				'type' => 'string',
				'default' => 'textcenter'
			),
		),
		'render_callback' => 'MalinaSocialsConvert',
	) );

}
add_action( 'init', 'malina_socials_block' );
function MalinaSocialsConvert($attributes){
	$out = '[malinasocials ';
	$out .= 'id="'.$attributes['block_id'].'" ';
	$out .= 'facebook="'.get_theme_mod('malina_social_facebook', '').'" ';
	$out .= 'twitter="'.get_theme_mod('malina_social_twitter', '').'" ';
	$out .= 'pinterest="'.get_theme_mod('malina_social_pinterest', '').'" ';
	$out .= 'vimeo="'.get_theme_mod('malina_social_vimeo', '').'" ';
	$out .= 'instagram="'.get_theme_mod('malina_social_instagram', '').'" ';
	$out .= 'tumblr="'.get_theme_mod('malina_social_tumblr', '').'" ';
	$out .= 'google_plus="'.get_theme_mod('malina_social_google_plus', '').'" ';
	$out .= 'forrst="'.get_theme_mod('malina_social_forrst', '').'" ';
	$out .= 'dribbble="'.get_theme_mod('malina_social_dribbble', '').'" ';
	$out .= 'flickr="'.get_theme_mod('malina_social_flickr', '').'" ';
	$out .= 'linkedin="'.get_theme_mod('malina_social_linkedin', '').'" ';
	$out .= 'skype="'.get_theme_mod('malina_social_skype', '').'" ';
	$out .= 'digg="'.get_theme_mod('malina_social_digg', '').'" ';
	$out .= 'yahoo="'.get_theme_mod('malina_social_yahoo', '').'" ';
	$out .= 'youtube="'.get_theme_mod('malina_social_youtube', '').'" ';
	$out .= 'deviantart="'.get_theme_mod('malina_social_deviantart', '').'" ';
	$out .= 'behance="'.get_theme_mod('malina_social_behance', '').'" ';
	$out .= 'paypal="'.get_theme_mod('malina_social_paypal', '').'" ';
	$out .= 'delicious="'.get_theme_mod('malina_social_delicious', '').'" ';
	$out .= 'rss="'.get_theme_mod('malina_social_rss', '').'" ';
	$out .= 'icon_color="'.$attributes['links_color'].'" ';
	$out .= 'bg_color="'.$attributes['bg_color'].'" ';
	$out .= 'icons_align="'.$attributes['icons_align'].'"';
	$out .=']';
	$css = '';
	return do_shortcode($out);
	
}