<?php
function malina_category_block() {
	// Scripts.
	wp_register_script(
		'malina-category-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/category/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n' ) // Dependencies, defined above.
	);

	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/category', array(
		'editor_script' => 'malina-category-block-script',
		'attributes'      => array(
			'title' => array(
				'type' => 'string',
				'default' => 'Category'
			),
			'mediaID' => array(
				'type' => 'number',
				'default' => ''
			),
			'mediaURL' => array(
				'type' => 'string',
				'default' => ''
			),
			'cat_url' => array(
				'type' => 'string',
				'default' => '#'
			),
			'image_height' => array(
				'type' => 'string',
				'default' => 'size-portrait'
			),
		),
		'render_callback' => 'MalinaCategoryCallback',
	) );

}
add_action( 'init', 'malina_category_block' );
function MalinaCategoryCallback($attributes){
	extract(shortcode_atts(array(
    	'title' => 'Read more',
      	'mediaID' => '',
      	'mediaURL' => '',
      	'cat_url' => '#',
      	'image_height' => 'size-portrait'
    ), $attributes));
	$out = '';
	$thumbsize = 'malina-masonry';
	if( $image_height == 'size-landscape' ){
		$$thumbsize = 'medium';
	}
	$out .= '<div class="category-block">';
		if( $mediaURL) {
			$out .= '<div class="category-img">';
				if( $mediaID ){
					$image_tmp = wp_get_attachment_image_src($mediaID, $thumbsize);
					$image_url = $image_tmp[0];
					if($image_url){
						$out .= '<img class="'.esc_attr($image_height).'" src="'.esc_url($image_url).'" alt="category-image">';
					}
				}
			$out .= '</div>';
		} 
		$out .= '<a href="'.esc_url($cat_url).'" class="button category-button">'.$title.'</a>'; 
	$out .= '</div>';
	return $out;	
}