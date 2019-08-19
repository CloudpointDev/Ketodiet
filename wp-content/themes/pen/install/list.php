<?php
/**
 * Recommended plugins.
 *
 * @package Pen
 */

if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
	require __DIR__ . '/class-tgm-plugin-activation.php';
}

if ( ! function_exists( 'pen_install_recommended_plugins' ) ) {
	/**
	 * Recommended plugins for this awesome theme.
	 *
	 * @since Pen 1.2.8
	 * @return void
	 */
	function pen_install_recommended_plugins() {
		$plugins = array(
			array(
				'name'     => esc_html__( 'Pen Extra Features', 'pen' ),
				'slug'     => 'pen-extra-features',
				'required' => false,
			),
		);
		$config  = array(
			'id'           => 'pen',
			'menu'         => 'pen-theme-install-plugins',
			'has_notices'  => true,
			'dismissable'  => true,
			'is_automatic' => false,
			'strings'      => array(
				'page_title' => esc_html__( 'Recommended Plugins', 'pen' ),
				'menu_title' => esc_html__( 'Recommended Plugins', 'pen' ),
			),
		);

		tgmpa( $plugins, $config );
	}
	add_action( 'tgmpa_register', 'pen_install_recommended_plugins' );
}
