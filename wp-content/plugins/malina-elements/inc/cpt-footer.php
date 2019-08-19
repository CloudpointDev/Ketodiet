<?php

add_action('init', 'malina_post_type_footer');
function malina_post_type_footer() {
	register_post_type( 'malina-footer',
        array( 
        'menu_icon'=>'dashicons-align-center',	
		'label' => __('Footer', 'malina'), 
		'public' => true, 
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'has_archive' => false,
		'exclude_from_search' => true,
		'menu_position' => 20,
		'rewrite' => array(
			'slug' => 'footer-view',
			'with_front' => true,
		),
		'supports' => array(
				'title',
				'editor')
			) 
		);
}

?>