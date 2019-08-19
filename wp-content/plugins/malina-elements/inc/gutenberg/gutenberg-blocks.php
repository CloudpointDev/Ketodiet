<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'block_categories', function( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'malinaelements',
				'title' => esc_html__( 'Malina Elements', 'malina' ),
			),
		)
	);
}, 10, 2 );

require_once( realpath(dirname(__FILE__)) . '/blocks/gridposts/gridposts.php' );
require_once( realpath(dirname(__FILE__)) . '/blocks/singlepost/singlepost.php' );
require_once( realpath(dirname(__FILE__)) . '/blocks/category/category.php' );
require_once( realpath(dirname(__FILE__)) . '/blocks/contactform/contactform.php' );
require_once( realpath(dirname(__FILE__)) . '/blocks/sidebar/sidebar.php' );
require_once( realpath(dirname(__FILE__)) . '/blocks/slider/slider.php' );
require_once( realpath(dirname(__FILE__)) . '/blocks/socials/socials.php' );
require_once( realpath(dirname(__FILE__)) . '/blocks/map/map.php' );
require_once( realpath(dirname(__FILE__)) . '/blocks/subscribe/subscribe.php' );