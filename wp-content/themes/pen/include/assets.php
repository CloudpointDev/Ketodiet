<?php
/**
 * JavaScript and CSS files.
 *
 * @package Pen
 */

defined( 'ABSPATH' ) || die();

if ( ! function_exists( 'pen_assets' ) ) {
	/**
	 * Enqueue scripts and styles.
	 */
	function pen_assets() {

		$css_files = array(
			'normalize'  => '/assets/css/normalize.css',
			'animate'    => '/assets/css/plugins/animate.css',
			'select2'    => '/assets/css/plugins/jquery.select2.css',
			'base'       => '/assets/css/pen-base.css',
			'fonts'      => '/assets/css/pen-fonts.css',
			'typography' => '/assets/css/pen-typography.css',
			'tables'     => '/assets/css/pen-tables.css',
			'layout'     => '/assets/css/pen-layout.css',
			'loading'    => '/assets/css/pen-loading.css',
			'buttons'    => '/assets/css/pen-buttons.css',
			'bottom'     => '/assets/css/pen-bottom.css',
			'comments'   => '/assets/css/pen-comments.css',
			'footer'     => '/assets/css/pen-footer.css',
			'header'     => '/assets/css/pen-header.css',
			'menus'      => '/assets/css/pen-menus.css',
			'navigation' => '/assets/css/pen-navigation.css',
			'forms'      => '/assets/css/pen-forms.css',
			'content'    => '/assets/css/pen-content.css',
			'thumbnails' => '/assets/css/pen-thumbnails.css',
			'author'     => '/assets/css/pen-author.css',
			'pagination' => '/assets/css/pen-pagination.css',
			'share'      => '/assets/css/pen-share.css',
			'search-bar' => '/assets/css/pen-search-bar.css',
			'top'        => '/assets/css/pen-top.css',
			'widgets'    => '/assets/css/pen-widgets.css',
		);

		// The key has to be the same as the slug in the inline CSS of the customize.php file.
		$css_files['css'] = '/assets/css/pen-general.css';

		if ( file_exists( PEN_THEME_DIRECTORY_URI . '/assets/css/custom.css' ) ) {
			$css_files['custom'] = '/assets/css/custom.css';
		}

		foreach ( $css_files as $key => $value ) {
			wp_enqueue_style( 'pen-' . $key, PEN_THEME_DIRECTORY_URI . $value, array(), PEN_THEME_VERSION );
		}

		wp_enqueue_script( 'jquery-fittext', PEN_THEME_DIRECTORY_URI . '/assets/js/plugins/jquery.fittext.js', array( 'jquery' ), '1.2', true );
		wp_enqueue_script( 'autosize', PEN_THEME_DIRECTORY_URI . '/assets/js/plugins/autosize.js', array(), '4.0', true );
		wp_enqueue_script( 'respond', PEN_THEME_DIRECTORY_URI . '/assets/js/plugins/respond.js', array( 'jquery' ), '1.4.2', true );
		wp_enqueue_script( 'pen-skip', PEN_THEME_DIRECTORY_URI . '/assets/js/skip-link-focus-fix.js', array( 'jquery' ), PEN_THEME_VERSION, true );

		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}

		ob_start();
		get_template_part( 'partials/site', 'navigation' );
		$navigation        = trim( ob_get_clean() );
		$navigation_easing = array();
		if ( $navigation ) {
			wp_enqueue_script( 'hoverIntent' );
			wp_enqueue_script( 'jquery-superfish', PEN_THEME_DIRECTORY_URI . '/assets/js/plugins/jquery.superfish.js', array( 'jquery' ), '1.7.9', true );
			$easing = pen_option_get( 'navigation_easing' );
			if ( $easing ) {
				wp_enqueue_script( 'jquery-easing', PEN_THEME_DIRECTORY_URI . '/assets/js/plugins/jquery.easing.js', array( 'jquery' ), '1.3', true );
				$navigation_easing = array(
					'height' => array( 'show', $easing ),
				);
			}
		}

		wp_enqueue_script( 'jquery-waypoints', PEN_THEME_DIRECTORY_URI . '/assets/js/plugins/jquery.waypoints.js', array( 'jquery' ), '4.0.1', true );

		$content_list_type = pen_list_type();
		if ( 'masonry' === $content_list_type ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'masonry' );
		}

		wp_enqueue_script( 'pen-modernizr', PEN_THEME_DIRECTORY_URI . '/assets/js/plugins/modernizr.js', array(), '3.6', true );

		$site_background_effect = pen_option_get( 'color_site_background_effect' );

		$trianglify        = false;
		$trianglify_colors = false;
		if ( 'trianglify' === $site_background_effect ) {
			$trianglify = true;
			/**
			 * Base64 is required to generate a DataURI for a SVG background.
			 */
			wp_enqueue_script( 'base64', PEN_THEME_DIRECTORY_URI . '/assets/js/plugins/base64.js', array( 'jquery' ), PEN_THEME_VERSION, true );
			$trianglify_colors = array(
				pen_option_get( 'color_site_background' ),
				pen_option_get( 'color_button_background_primary' ),
				pen_option_get( 'color_button_background_secondary' ),
				pen_option_get( 'color_header_background_primary' ),
				pen_option_get( 'color_header_background_secondary' ),
				pen_option_get( 'color_navigation_background_primary' ),
				pen_option_get( 'color_navigation_background_secondary' ),
			);
			wp_enqueue_script( 'trianglify', PEN_THEME_DIRECTORY_URI . '/assets/js/plugins/trianglify.js', array( 'jquery', 'base64' ), '2.0.0', true );
		}

		$shards        = false;
		$shards_colors = false;
		if ( 'shards' === $site_background_effect ) {
			$shards                      = true;
			$site_background             = new \Pen_Theme\Color( pen_option_get( 'color_site_background' ) );
			$site_background             = array_values( $site_background->getRgb() );
			$site_background[]           = 0.25;
			$header_background_primary   = new \Pen_Theme\Color( pen_option_get( 'color_header_background_primary' ) );
			$header_background_primary   = array_values( $header_background_primary->getRgb() );
			$header_background_primary[] = 0.25;
			$shards_colors               = array(
				$site_background,
				$header_background_primary,
			);
			wp_enqueue_script( 'shards', PEN_THEME_DIRECTORY_URI . '/assets/js/plugins/shards.js', array( 'jquery' ), '1.1', true );
		}

		wp_enqueue_script(
			'pen-js',
			PEN_THEME_DIRECTORY_URI . '/assets/js/pen-scripts.js',
			array_filter(
				array(
					'jquery',
					'jquery-masonry',
					$shards ? 'shards' : '',
					$trianglify ? 'trianglify' : '',
				)
			),
			PEN_THEME_VERSION,
			true
		);
		wp_localize_script(
			'pen-js',
			'pen_js',
			array(
				'url_home'                     => is_multisite() ? network_home_url( '/' ) : home_url( '/' ),
				'header_sticky'                => pen_option_get( 'header_sticky' ),
				'list_type'                    => $content_list_type,
				'trianglify_colors'            => $trianglify_colors,
				'shards_colors'                => $shards_colors,
				'navigation_arrows'            => pen_option_get( 'navigation_arrows' ) ? true : false,
				'navigation_easing'            => $navigation_easing,
				'navigation_mobile'            => pen_option_get( 'navigation_mobile_display' ) ? true : false,
				'animation_comments'           => pen_option_get( 'comments_animation_reveal' ),
				'animation_navigation_speed'   => pen_option_get( 'navigation_animation_speed' ),
				'animation_list'               => pen_option_get( 'list_animation_reveal' ),
				'animation_list_thumbnails'    => pen_option_get( 'list_thumbnail_animation_reveal' ),
				'animation_content'            => pen_option_get( 'content_animation_reveal' ),
				'animation_content_thumbnails' => pen_option_get( 'content_thumbnail_animation_reveal' ),
				/* phpcs:disable */
				'font_resize'                  => array(
					'site_title'                    => pen_option_get( 'font_resize_sitetitle' ),
				),
				'text'                         => array(
					'pen_theme'                     => esc_html__( 'Pen', 'pen' ),
					'enter_keyword'                 => esc_html__( 'Please enter some keywords.', 'pen' ),
					'close'                         => esc_html__( 'Close', 'pen' ),
					'menu'                          => esc_html__( 'Menu', 'pen' ),
					'overview_options_post'         => esc_attr__( 'Content Settings Overview', 'pen' ),
					'expand_collapse'               => esc_html__( 'Expand/Collapse', 'pen' ),
					'theme_specific'                => esc_attr__( 'This is a part of the Pen theme, so if you switch to another theme this nice little editing tool will be no longer available.', 'pen' ),
				),
				/* phpcs:enable */
			)
		);

		if ( file_exists( PEN_THEME_DIRECTORY_URI . '/assets/js/custom.js' ) ) {
			wp_enqueue_script( 'pen-custom', PEN_THEME_DIRECTORY_URI . '/assets/js/custom.js', array( 'jquery' ), PEN_THEME_VERSION, true );
		}

		wp_enqueue_script( 'html5shiv', PEN_THEME_DIRECTORY_URI . '/assets/js/plugins/html5.js', array(), '3.7.3', false );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	}
	add_action( 'wp_enqueue_scripts', 'pen_assets' );

}
