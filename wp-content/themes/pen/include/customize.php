<?php
/**
 * Theme Customizer.
 *
 * @package Pen
 */

defined( 'ABSPATH' ) || die();

if ( ! function_exists( 'pen_customize_color' ) ) {
	/**
	 * Adds color options.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param array                $variables    Common variables.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_customize_color( &$wp_customize, $variables ) {

		$preset = esc_html( pen_preset_get( 'color' ) );

		$panel = 'pen_panel_colors';
		$wp_customize->add_panel(
			$panel,
			array(
				'title'    => __( 'Colors', 'pen' ),
				'priority' => 1,
			)
		);

		// Moves the default WP "Colors" section to this panel.
		$wp_customize->get_section( 'colors' )->title    = __( 'General', 'pen' );
		$wp_customize->get_section( 'colors' )->priority = 1;
		$wp_customize->get_section( 'colors' )->panel    = 'pen_colors';

		/**
		 * General.
		 */
		$section = 'pen_section_colors_general';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'General', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_color_shadow[$preset]";
		$label      = __( 'Shadows', 'pen' );
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_site_shadow_display[$preset]";
		$label      = __( 'Shadow display', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_site_background[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Background', 'pen' ),
				__( 'Site', 'pen' )
			)
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_site_background_effect[$preset]";
		$label      = __( 'Site Background Effect', 'pen' );
		$choices    = array(
			'none'       => __( 'None', 'pen' ),
			'trianglify' => __( 'Trianglify', 'pen' ),
			'shards'     => __( 'Shards', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_color_text[$preset]";
		$label      = __( 'Text', 'pen' );
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_link[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Links', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_link_hover[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Links', 'pen' ),
			__( 'Hover', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_button_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Background', 'pen' ),
				__( 'Buttons', 'pen' )
			),
			__( 'Top', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_button_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Background', 'pen' ),
				__( 'Buttons', 'pen' )
			),
			__( 'Bottom', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_button_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Text Color', 'pen' ),
			__( 'Buttons', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_button_border[$preset]";
		$label      = __( 'Buttons Border', 'pen' );
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		/**
		 * Header.
		 */
		$section = 'pen_section_colors_header';
		$wp_customize->add_section(
			$section,
			array(
				'title'              => __( 'Header', 'pen' ),
				'panel'              => $panel,
				'description_hidden' => true,
			)
		);

		$setting_id = "pen_color_header_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Background', 'pen' ),
			__( 'Primary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_header_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Background', 'pen' ),
			__( 'Secondary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_header_background_angle[$preset]";
		$label      = __( 'Angle', 'pen' );
		$choices    = array(
			'to right'  => __( 'Horizontal', 'pen' ),
			'125deg'    => __( 'Diagonal', 'pen' ),
			'to bottom' => __( 'Vertical', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_color_header_text_shadow[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Text Shadow', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_text_shadow_display[$preset]";
		$label      = __( 'Text Shadow', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_sitetitle[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Site Title', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_sitetitle_hover[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Site Title', 'pen' ),
			__( 'Hover', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_sitedescription[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Site Description', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_sitedescription_hover[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Site Description', 'pen' ),
			__( 'Hover', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_phone[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Phone', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_phone_hover[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Phone', 'pen' ),
			__( 'Hover', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_link[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Links', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_link_hover[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Links', 'pen' ),
			__( 'Hover', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Text', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_field_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Background', 'pen' ),
				_x( 'Form Fields', 'noun', 'pen' )
			),
			__( 'Top', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_field_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Background', 'pen' ),
				_x( 'Form Fields', 'noun', 'pen' )
			),
			__( 'Bottom', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_field_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Text Color', 'pen' ),
			_x( 'Form Fields', 'noun', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_header_search_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			_x( 'Search Button', 'noun', 'pen' ),
			__( 'Top', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_header_search_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Search Button', 'pen' ),
			__( 'Bottom', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_header_search_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Text', 'pen' ),
			_x( 'Search Button', 'noun', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_header_button_users_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, such as Shopping cart button. */
				__( '%s Button', 'pen' ),
				_x( 'Login/Register', 'noun', 'pen' )
			),
			__( 'Primary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_header_button_users_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, such as Shopping cart button. */
				__( '%s Button', 'pen' ),
				_x( 'Login/Register', 'noun', 'pen' )
			),
			__( 'Secondary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_header_button_users_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Text Color', 'pen' ),
			_x( 'Login/Register', 'noun', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		/**
		 * Navigation colors.
		 */
		$section = 'pen_section_colors_navigation';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Navigation', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_color_navigation_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Background', 'pen' ),
			__( 'Primary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_navigation_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Background', 'pen' ),
			__( 'Secondary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_navigation_background_angle[$preset]";
		$label      = __( 'Angle', 'pen' );
		$choices    = array(
			'to right'  => __( 'Horizontal', 'pen' ),
			'125deg'    => __( 'Diagonal', 'pen' ),
			'to bottom' => __( 'Vertical', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_color_navigation_background_submenu_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Background', 'pen' ),
				__( 'Submenu', 'pen' )
			),
			__( 'Primary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_navigation_background_submenu_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Background', 'pen' ),
				__( 'Submenu', 'pen' )
			),
			__( 'Secondary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_navigation_background_submenu_angle[$preset]";
		$label      = __( 'Angle', 'pen' );
		$choices    = array(
			'to right'  => __( 'Horizontal', 'pen' ),
			'125deg'    => __( 'Diagonal', 'pen' ),
			'to bottom' => __( 'Vertical', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_color_navigation_text_shadow[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Text Shadow', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_navigation_text_shadow_display[$preset]";
		$label      = __( 'Text Shadow', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_navigation_link[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Links', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_navigation_link_hover[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Links', 'pen' ),
			__( 'Hover', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_navigation_link_submenu[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Links', 'pen' ),
				__( 'Submenu', 'pen' )
			)
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_navigation_link_hover_submenu[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Menu Links. */
				__( '%s Links', 'pen' ),
				__( 'Submenu', 'pen' )
			),
			__( 'Hover', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_navigation_text_shadow_submenu[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Text Shadow', 'pen' ),
			__( 'Submenus', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_navigation_text_shadow_display_submenu[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Text Shadow', 'pen' ),
			__( 'Submenus', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'postMessage', $label );

		/**
		 * Search.
		 */
		$section = 'pen_section_colors_search';
		$wp_customize->add_section(
			$section,
			array(
				'title'       => __( 'Search Bar', 'pen' ),
				'panel'       => $panel,
				'description' => sprintf(
					/* Translators: 1: opening tag for a hyperlink, e.g. <a href="#">, 2: closing tag for a hyperlink, e.g. </a>. */
					__( 'Please make sure you have the search box added to the top of the content area through %1$sCustomize &rarr; Header &rarr; Search%2$s, otherwise changes that you will make in this section cannot be previewed live like the rest of the settings.', 'pen' ),
					sprintf(
						'<a href="%s" class="pen_customizer_shortcut" data-type="section" data-target="pen_section_header_search">',
						esc_url( add_query_arg( array( 'autofocus[section]' => 'pen_section_header_search' ), $variables['url_customize'] ) )
					),
					'</a>'
				),
			)
		);

		$setting_id = "pen_color_search_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Background', 'pen' ),
			__( 'Primary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_search_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Background', 'pen' ),
			__( 'Secondary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_search_background_angle[$preset]";
		$label      = __( 'Angle', 'pen' );
		$choices    = array(
			'to right'  => __( 'Horizontal', 'pen' ),
			'125deg'    => __( 'Diagonal', 'pen' ),
			'to bottom' => __( 'Vertical', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_color_search_field_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Background', 'pen' ),
				_x( 'Search Fields', 'noun', 'pen' )
			),
			__( 'Top', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_search_field_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Background', 'pen' ),
				_x( 'Search Fields', 'noun', 'pen' )
			),
			__( 'Bottom', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_search_field_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Text Color', 'pen' ),
			_x( 'Form Fields', 'noun', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_search_button_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			_x( 'Search Button', 'noun', 'pen' ),
			__( 'Top', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_search_button_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			_x( 'Search Button', 'noun', 'pen' ),
			__( 'Bottom', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_search_button_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Text', 'pen' ),
			_x( 'Search Button', 'noun', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_search_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Text', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_search_link[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Links', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_search_link_hover[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Links', 'pen' ),
			__( 'Hover', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_search_text_shadow[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Text Shadow', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_search_text_shadow_display[$preset]";
		$label      = __( 'Text Shadow', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'postMessage', $label );

		/**
		 * Content.
		 */
		$section = 'pen_section_colors_content';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Content', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_color_content_title_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Header Background. */
				__( '%s Background', 'pen' ),
				__( 'Content Title', 'pen' )
			),
			__( 'Primary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_content_title_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Header Background. */
				__( '%s Background', 'pen' ),
				__( 'Content Title', 'pen' )
			),
			__( 'Secondary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_content_title_background_angle[$preset]";
		$label      = __( 'Angle', 'pen' );
		$choices    = array(
			'to right'  => __( 'Horizontal', 'pen' ),
			'125deg'    => __( 'Diagonal', 'pen' ),
			'to bottom' => __( 'Vertical', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_color_content_title_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Text Color', 'pen' ),
			__( 'Content Title', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_content_title_text_shadow[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Text Shadow', 'pen' ),
				__( 'Content Title', 'pen' )
			)
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_content_title_text_shadow_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Text Shadow', 'pen' ),
			__( 'Content Title', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_content_title_link[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Link', 'pen' ),
				__( 'Content Title', 'pen' )
			)
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_content_title_link_hover[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Link', 'pen' ),
				__( 'Content Title', 'pen' )
			),
			__( 'Hover', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_content_background_primary[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Background', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id  = "pen_color_content_thumbnail_frame[$preset]";
		$label       = sprintf(
			'%1$s (%2$s)',
			__( 'Featured Images Frame', 'pen' ),
			__( 'Full Content', 'pen' )
		);
		$description = sprintf(
			/* Translators: 1: Setting name, 2: Link to that setting, e.g. Customize &rarr; Content. */
			__( 'Make sure the %1$s is enabled in %2$s', 'pen' ),
			__( 'Thumbnail Frame', 'pen' ),
			sprintf(
				/* Translators: 1: Link to Customize section, 2: Link text. */
				'<a href="%1$s" class="pen_customizer_shortcut" data-type="section" data-target="pen_section_content">%2$s</a>',
				esc_url( add_query_arg( array( 'autofocus[section]' => 'pen_section_content' ), $variables['url_customize'] ) ),
				sprintf(
					'%1$s &rarr; %2$s &rarr; %3$s',
					_x( 'Customize', 'Customize section', 'pen' ),
					__( 'Content', 'pen' ),
					__( 'Full Content View', 'pen' )
				)
			)
		);
		$choices = array(
			'#ffffff' => __( 'Light', 'pen' ),
			'#000000' => __( 'Dark', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label, $description );

		$setting_id = "pen_color_content_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Text', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_content_link[$preset]";
		$label      = __( 'Links', 'pen' );
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_content_link_hover[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Links', 'pen' ),
			__( 'Hover', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_content_field_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Header Background. */
				__( '%s Background', 'pen' ),
				_x( 'Form Fields', 'noun', 'pen' )
			),
			__( 'Top', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_content_field_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Header Background. */
				__( '%s Background', 'pen' ),
				_x( 'Form Fields', 'noun', 'pen' )
			),
			__( 'Bottom', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_content_field_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Text Color', 'pen' ),
			__( 'Form Fields', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		/**
		 * Lists.
		 */
		$section = 'pen_section_colors_list';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'List Views', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id  = "pen_color_list_thumbnail_frame[$preset]";
		$label       = sprintf(
			'%1$s (%2$s)',
			__( 'Featured Images Frame', 'pen' ),
			__( 'Plain List', 'pen' )
		);
		$description = sprintf(
			/* Translators: 1: Setting name, 2: Link to that setting, e.g. Customize &rarr; Content. */
			__( 'Make sure the %1$s is enabled in %2$s', 'pen' ),
			__( 'Thumbnail Frame', 'pen' ),
			sprintf(
				/* Translators: 1: Link to Customize section, 2: Link text. */
				'<a href="%1$s" class="pen_customizer_shortcut" data-type="section" data-target="pen_section_content">%2$s</a>',
				esc_url( add_query_arg( array( 'autofocus[section]' => 'pen_section_content' ), $variables['url_customize'] ) ),
				sprintf(
					'%1$s &rarr; %2$s &rarr; %3$s',
					_x( 'Customize', 'Customize section', 'pen' ),
					__( 'Content', 'pen' ),
					__( 'List Views', 'pen' )
				)
			)
		);
		$choices = array(
			'#ffffff' => __( 'Light', 'pen' ),
			'#000000' => __( 'Dark', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label, $description );

		$setting_id = "pen_color_list_thumbnail_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Header Background. */
				__( '%s Background', 'pen' ),
				__( 'Thumbnails', 'pen' )
			),
			__( 'Primary', 'pen' )
		);
		$description = __( 'Only for the jQuery Masonry layouts.', 'pen' );
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_color_list_thumbnail_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Header Background. */
				__( '%s Background', 'pen' ),
				__( 'Thumbnails', 'pen' )
			),
			__( 'Secondary', 'pen' )
		);
		$description = __( 'Only for the jQuery Masonry layouts.', 'pen' );
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		/**
		 * Bottom.
		 */
		$section = 'pen_section_colors_bottom';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Bottom', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_color_bottom_background_transparent[$preset]";
		$label      = __( 'Transparent Background', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_bottom_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Background', 'pen' ),
			__( 'Primary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_bottom_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Background', 'pen' ),
			__( 'Secondary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_bottom_background_angle[$preset]";
		$label      = __( 'Angle', 'pen' );
		$choices    = array(
			'to right'  => __( 'Horizontal', 'pen' ),
			'125deg'    => __( 'Diagonal', 'pen' ),
			'to bottom' => __( 'Vertical', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_color_bottom_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Text', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_bottom_link[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Links', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_bottom_link_hover[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Links', 'pen' ),
			__( 'Hover', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_bottom_text_shadow[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Text Shadow', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_bottom_text_shadow_display[$preset]";
		$label      = __( 'Text Shadow', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_bottom_headings[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Headings', 'pen' )
		);
		$description = __( 'Only applies to widgets with no color scheme.', 'pen' );
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label, $description );

		$setting_id = "pen_color_bottom_headings_text_shadow[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Headings Shadow', 'pen' )
		);
		$description = __( 'Only applies to widgets with no color scheme.', 'pen' );
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label, $description );

		$setting_id = "pen_color_bottom_headings_text_shadow_display[$preset]";
		$label      = __( 'Headings Shadow', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_bottom_field_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Header Background. */
				__( '%s Background', 'pen' ),
				_x( 'Form Fields', 'noun', 'pen' )
			),
			__( 'Top', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_bottom_field_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Header Background. */
				__( '%s Background', 'pen' ),
				_x( 'Form Fields', 'noun', 'pen' )
			),
			__( 'Bottom', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_bottom_field_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Text Color', 'pen' ),
			_x( 'Form Fields', 'noun', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		/**
		 * Footer.
		 */
		$section = 'pen_section_colors_footer';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Footer', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_color_footer_background_transparent[$preset]";
		$label      = __( 'Transparent Background', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_footer_background_primary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Background', 'pen' ),
			__( 'Primary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_footer_background_secondary[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Background', 'pen' ),
			__( 'Secondary', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_footer_background_angle[$preset]";
		$label      = __( 'Angle', 'pen' );
		$choices    = array(
			'to right'  => __( 'Horizontal', 'pen' ),
			'125deg'    => __( 'Diagonal', 'pen' ),
			'to bottom' => __( 'Vertical', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_color_footer_text[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Text', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_footer_link[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Links', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_footer_link_hover[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Links', 'pen' ),
			__( 'Hover', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_color_footer_text_shadow[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Color', 'pen' ),
			__( 'Text Shadow', 'pen' )
		);
		pen_control_color( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_color_footer_text_shadow_display[$preset]";
		$label      = __( 'Text Shadow', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'postMessage', $label );

		if ( PEN_THEME_HAS_WOOCOMMERCE ) {

			/**
			 * WooCommerce.
			 */
			$section = 'pen_section_colors_woocommerce';
			$wp_customize->add_section(
				$section,
				array(
					'title' => __( 'WooCommerce', 'pen' ),
					'panel' => $panel,
				)
			);

			$setting_id = "pen_color_cart_header_content_background_primary[$preset]";
			$label      = sprintf(
				'%1$s (%2$s)',
				sprintf(
					/* Translators: %s: Part of the theme, such as Shopping cart button. */
					__( '%s Background', 'pen' ),
					__( 'Shopping Cart Dropdown', 'pen' )
				),
				__( 'Top', 'pen' )
			);
			pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

			$setting_id = "pen_color_cart_header_content_background_secondary[$preset]";
			$label      = sprintf(
				'%1$s (%2$s)',
				sprintf(
					/* Translators: %s: Part of the theme, such as Shopping cart button. */
					__( '%s Background', 'pen' ),
					__( 'Shopping Cart Dropdown', 'pen' )
				),
				__( 'Bottom', 'pen' )
			);
			pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

			$setting_id = "pen_color_cart_header_content_background_angle[$preset]";
			$label      = __( 'Angle', 'pen' );
			$choices    = array(
				'to right'  => __( 'Horizontal', 'pen' ),
				'125deg'    => __( 'Diagonal', 'pen' ),
				'to bottom' => __( 'Vertical', 'pen' ),
			);
			pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

			$setting_id = "pen_color_cart_header_content_text[$preset]";
			$label      = sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Text Color', 'pen' ),
				__( 'Shopping Cart', 'pen' )
			);
			pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

			$setting_id = "pen_color_cart_header_content_link[$preset]";
			$label      = sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Color', 'pen' ),
				sprintf(
					/* Translators: %s: Some elements, such as Header links. */
					__( '%s Links', 'pen' ),
					__( 'Shopping Cart', 'pen' )
				)
			);
			pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

			$setting_id = "pen_color_cart_header_content_link_hover[$preset]";
			$label      = sprintf(
				'%1$s (%2$s)',
				sprintf(
					/* Translators: %s: Some elements, such as Header links. */
					__( '%s Links', 'pen' ),
					__( 'Shopping Cart', 'pen' )
				),
				__( 'Hover', 'pen' )
			);
			pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

			$setting_id = "pen_color_cart_badge_sale_background_primary[$preset]";
			$label      = sprintf(
				'%1$s (%2$s)',
				__( 'Sale Badges', 'pen' ),
				__( 'Primary', 'pen' )
			);
			pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

			$setting_id = "pen_color_cart_badge_sale_background_secondary[$preset]";
			$label      = sprintf(
				'%1$s (%2$s)',
				__( 'Sale Badges', 'pen' ),
				__( 'Secondary', 'pen' )
			);
			pen_control_color( $wp_customize, $setting_id, $section, 'refresh', $label );

		}
	}
}

if ( ! function_exists( 'pen_customize_typography' ) ) {
	/**
	 * Adds typography options.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param array                $variables    Common variables.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_customize_typography( &$wp_customize, $variables ) {

		$preset      = 'preset_1';
		$preset_font = esc_html( pen_preset_get( 'font_family' ) );

		$list_fonts = array_merge(
			array(
				'default' => __( 'Default', 'pen' ),
			),
			pen_fonts_all()
		);

		$list_sizes = array(
			'0.5em'   => __( 'Very Small', 'pen' ),
			'0.75em'  => __( 'Small', 'pen' ),
			'default' => __( 'Default', 'pen' ),
			'2em'     => __( 'Large', 'pen' ),
			'3em'     => __( 'Very Large', 'pen' ),
		);

		$panel = 'pen_panel_typography';
		$wp_customize->add_panel(
			$panel,
			array(
				'title'    => __( 'Typography', 'pen' ),
				'priority' => 2,
			)
		);

		/**
		 * General.
		 */
		$section = 'pen_section_typography_general';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'General', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_font_family_site[$preset_font]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font', 'pen' ),
			__( 'Base', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_family_headings[$preset_font]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font', 'pen' ),
			__( 'Headings', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_family_title_list[$preset_font]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font', 'pen' ),
				__( 'Content Title', 'pen' )
			),
			__( 'In Lists', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_size_title_list[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font Size', 'pen' ),
				__( 'Content Title', 'pen' )
			),
			__( 'In Lists', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

		$setting_id = "pen_font_family_title_content[$preset_font]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font', 'pen' ),
				__( 'Content Title', 'pen' )
			),
			__( 'Full Content', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_size_title_content[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font Size', 'pen' ),
				__( 'Content Title', 'pen' )
			),
			__( 'Full Content', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

		$setting_id = "pen_font_family_forms[$preset_font]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font', 'pen' ),
			__( 'Forms', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_family_buttons[$preset_font]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font', 'pen' ),
			__( 'Buttons', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		/**
		 * Header.
		 */
		$section = 'pen_section_typography_header';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Header', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_font_family_sitetitle[$preset_font]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font', 'pen' ),
			__( 'Site Title', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_size_sitetitle[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font Size', 'pen' ),
			__( 'Site Title', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

		$setting_id  = "pen_font_resize_sitetitle[$preset]";
		$label       = sprintf(
			'%1$s (%2$s)',
			__( 'Site Title Font Resize', 'pen' ),
			__( 'Small Screens', 'pen' )
		);
		$description = sprintf(
			/* Translators: %s: Some property, such as font size. */
			__( 'Automatic %s', 'pen' ),
			__( 'Font Size', 'pen' )
		);

		$choices = array(
			'none'    => __( 'Disabled', 'pen' ),
			'dynamic' => __( 'Dynamic', 'pen' ),
			'resize'  => __( 'Shrink to fit', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label, $description );

		$setting_id = "pen_font_family_sitedescription[$preset_font]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font', 'pen' ),
			__( 'Site Description', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_size_sitedescription[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font Size', 'pen' ),
			__( 'Site Description', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

		$setting_id = "pen_font_family_phone_header[$preset_font]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font', 'pen' ),
			__( 'Phone', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_size_phone_header[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font Size', 'pen' ),
			__( 'Phone', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

		$setting_id = "pen_font_size_social_header[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font Size', 'pen' ),
				__( 'Social Links', 'pen' )
			),
			__( 'Header', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

		/**
		 * Navigation font.
		 */
		$section = 'pen_section_typography_navigation';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Navigation', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_font_family_navigation[$preset_font]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font', 'pen' ),
				__( 'Navigation', 'pen' )
			),
			__( 'Menu Parents', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_size_navigation[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font Size', 'pen' ),
			__( 'Navigation', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

		$setting_id = "pen_font_family_navigation_submenu[$preset_font]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font', 'pen' ),
				__( 'Navigation', 'pen' )
			),
			__( 'Submenus', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		/**
		 * Sidebars.
		 */
		$section = 'pen_section_typography_sidebars';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Sidebars', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_font_family_widget_title_top[$preset_font]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'Top', 'pen' ),
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font', 'pen' ),
				__( 'Widget Title', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_size_widget_title_top[$preset]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'Top', 'pen' ),
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font Size', 'pen' ),
				__( 'Widget Title', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

		$setting_id = "pen_font_family_widget_title_left[$preset_font]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'Left', 'pen' ),
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font', 'pen' ),
				__( 'Widget Title', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_size_widget_title_left[$preset]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'Left', 'pen' ),
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font Size', 'pen' ),
				__( 'Widget Title', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

		$setting_id = "pen_font_family_widget_title_right[$preset_font]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'Right', 'pen' ),
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font', 'pen' ),
				__( 'Widget Title', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_size_widget_title_right[$preset]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'Right', 'pen' ),
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font Size', 'pen' ),
				__( 'Widget Title', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

		$setting_id = "pen_font_family_widget_title_bottom[$preset_font]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'Bottom', 'pen' ),
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font', 'pen' ),
				__( 'Widget Title', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_size_widget_title_bottom[$preset]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'Bottom', 'pen' ),
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font Size', 'pen' ),
				__( 'Widget Title', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

		/**
		 * Footer fonts.
		 */
		$section = 'pen_section_typography_footer';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Footer', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_font_family_phone_footer[$preset_font]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font', 'pen' ),
			__( 'Phone', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_fonts, $label );

		$setting_id = "pen_font_size_phone_footer[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Font Size', 'pen' ),
			__( 'Phone', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

		$setting_id = "pen_font_size_social_footer[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Some elements, such as Header links. */
				__( '%s Font Size', 'pen' ),
				__( 'Social Links', 'pen' )
			),
			__( 'Footer', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $list_sizes, $label );

	}
}

if ( ! function_exists( 'pen_customize_header' ) ) {
	/**
	 * Adds header options.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param array                $variables    Common variables.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_customize_header( &$wp_customize, $variables ) {

		$preset = 'preset_1';

		$panel = 'pen_panel_header';
		$wp_customize->add_panel(
			$panel,
			array(
				'title'    => __( 'Header', 'pen' ),
				'priority' => 3,
			)
		);

		/*
		 * Layout.
		 */
		$section = 'pen_section_header_general';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'General', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_site_header_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Site Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_header_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_header_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_header_sticky[$preset]";
		$label      = __( 'Sticky Header', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_header_sitetitle_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Site Title', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_header_sitetitle_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Site Title', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_header_sitetitle_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Site Title', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_header_sitedescription_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Site Description', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_header_sitedescription_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Site Description', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_header_sitedescription_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Site Description', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_header_alignment[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Alignment', 'pen' ),
			__( 'Header', 'pen' )
		);
		$choices = array(
			'left'   => __( 'Left', 'pen' ),
			'center' => __( 'Center', 'pen' ),
			'right'  => __( 'Right', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'postMessage', $choices, $label );

		$setting_id = "pen_phone_header_animation_reveal[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
				__( '%s Animation', 'pen' ),
				__( 'Phone Number', 'pen' )
			),
			__( 'Header', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_phone_header_animation_delay_reveal[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
				__( '%s Animation Delay', 'pen' ),
				__( 'Phone Number', 'pen' )
			),
			__( 'Header', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_social_header_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Social Links', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_social_header_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Social Links', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_button_users_header_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Login/Register button. */
				__( '%s Button', 'pen' ),
				_x( 'Login/Register', 'noun', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_encourage_register[$preset]";
		$label      = __( 'Encourage visitors to register', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_encourage_register_url[$preset]";
		$label      = sprintf(
			'%s:',
			sprintf(
				/* Translators: %s: Part of the site, e.g. Custom Registration Page. */
				__( 'Custom %s Page', 'pen' ),
				__( 'Registration', 'pen' )
			)
		);
		$description  = __( 'Leave empty if you do not have any registration page.', 'pen' );
		$description .= sprintf(
			'<br>%1$s<br>%2$s',
			__( 'Examples:', 'pen' ),
			'https://example.com/register<br>#registration-form'
		);
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_button_users_header_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, such as Shopping cart button. */
				__( '%s Button', 'pen' ),
				_x( 'Login/Register', 'noun', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_button_users_header_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, such as Shopping cart button. */
				__( '%s Button', 'pen' ),
				_x( 'Login/Register', 'noun', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		/*
		 * Search.
		 */
		$section = 'pen_section_header_search';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Search', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_search_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Search box', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_search_location[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			__( '%s Location', 'pen' ),
			__( 'Search box', 'pen' )
		);
		$choices = array(
			'header'  => __( 'Header', 'pen' ),
			'content' => __( 'Content Area', 'pen' ),
		);
		pen_control_radio( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_search_header_animation_reveal[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
				__( '%s Animation', 'pen' ),
				__( 'Search box', 'pen' )
			),
			__( 'Header', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_search_header_animation_delay_reveal[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation delay. */
				__( '%s Animation Delay', 'pen' ),
				__( 'Search box', 'pen' )
			),
			__( 'Header', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		/*
		 * Navigation.
		 */
		$section = 'pen_section_header_navigation';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Navigation', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_navigation_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Main Navigation Menu', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_navigation_mobile_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Mobile Navigation Menu', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_navigation_animation_reveal[$preset]";
		$label      = __( 'Animation on page load', 'pen' );
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_navigation_animation_delay_reveal[$preset]";
		$label      = __( 'Animation Delay', 'pen' );
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_navigation_separator[$preset]";
		$label      = __( 'Dropdown Menu Separator', 'pen' );
		$choices    = array(
			0 => __( 'None', 'pen' ),
		);
		for ( $i = 1; $i <= 10; $i++ ) {
			/* Translators: %d the style number. */
			$choices[ $i ] = sprintf( __( 'Style %d', 'pen' ), $i );
		}
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_navigation_separator_submenu[$preset]";
		$label      = __( 'Submenu Separator', 'pen' );
		$choices    = array(
			0 => __( 'None', 'pen' ),
		);
		for ( $i = 1; $i <= 10; $i++ ) {
			/* Translators: %d the style number. */
			$choices[ $i ] = sprintf( __( 'Style %d', 'pen' ), $i );
		}
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_navigation_hover[$preset]";
		$label      = __( 'Hover Style', 'pen' );
		$choices    = array(
			0 => __( 'None', 'pen' ),
		);
		for ( $i = 1; $i <= 10; $i++ ) {
			/* Translators: %d the style number. */
			$choices[ $i ] = sprintf( __( 'Style %d', 'pen' ), $i );
		}
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_navigation_arrows[$preset]";
		$label      = __( 'Dropdown arrows', 'pen' );
		$choices    = array(
			0 => __( 'None', 'pen' ),
		);
		for ( $i = 1; $i <= 10; $i++ ) {
			/* Translators: %d the style number. */
			$choices[ $i ] = sprintf( __( 'Style %d', 'pen' ), $i );
		}
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_navigation_easing[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Dropdown', 'pen' )
		);
		$choices = array(
			''              => __( 'None', 'pen' ),
			'easeInBack'    => 'easeInBack',
			'easeInBounce'  => 'easeInBounce',
			'easeInCirc'    => 'easeInCirc',
			'easeInCubic'   => 'easeInCubic',
			'easeInElastic' => 'easeInElastic',
			'easeInExpo'    => 'easeInExpo',
			'easeInQuad'    => 'easeInQuad',
			'easeInQuart'   => 'easeInQuart',
			'easeInQuint'   => 'easeInQuint',
			'easeInSine'    => 'easeInSine',
			'swing'         => 'swing',
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_navigation_animation_speed[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, such as Dropdown Animation Speed. */
			__( '%s Animation Speed', 'pen' ),
			__( 'Dropdown', 'pen' )
		);
		$choices = array(
			2000 => __( 'Very Slow', 'pen' ),
			1000 => __( 'Slow', 'pen' ),
			500  => __( 'Normal', 'pen' ),
			250  => __( 'Fast', 'pen' ),
			100  => __( 'Very Fast', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_navigation_alignment[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Alignment', 'pen' ),
			__( 'Navigation', 'pen' )
		);
		$choices = array(
			'left'   => __( 'Left', 'pen' ),
			'center' => __( 'Center', 'pen' ),
			'right'  => __( 'Right', 'pen' ),
		);
		pen_control_radio( $wp_customize, $setting_id, $section, 'postMessage', $choices, $label );

	}
}

if ( ! function_exists( 'pen_customize_content_list' ) ) {
	/**
	 * Adds "Content list" options.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param array                $variables    Common variables.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_customize_content_list( &$wp_customize, $variables ) {

		$preset = 'preset_1';

		$panel = 'pen_panel_content';
		$wp_customize->add_panel(
			$panel,
			array(
				'title'    => __( 'Content', 'pen' ),
				'priority' => 4,
			)
		);

		$section = 'pen_section_list';
		$wp_customize->add_section(
			$section,
			array(
				'title'       => __( 'List Views', 'pen' ),
				'panel'       => $panel,
				'description' => __( 'The following options apply to both "Plain list" and "jQuery Masonry" layouts.', 'pen' ),
			)
		);

		$setting_id = "pen_list_type[$preset]";
		$label      = __( 'Layout', 'pen' );
		$choices    = array(
			'masonry' => __( 'jQuery Masonry', 'pen' ),
			'plain'   => __( 'Plain List', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id  = "pen_list_masonry_columns[$preset]";
		$label       = sprintf(
			'%1$s: %2$s',
			__( 'jQuery Masonry', 'pen' ),
			__( 'Columns', 'pen' )
		);
		$description = __( 'Maximum number of columns', 'pen' );
		$choices     = array(
			'2' => __( 'Two', 'pen' ),
			'3' => __( 'Three', 'pen' ),
			'4' => __( 'Four', 'pen' ),
			'5' => __( 'Five', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label, $description );

		$setting_id = "pen_list_masonry_thumbnail_effect[$preset]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'jQuery Masonry', 'pen' ),
			__( 'Thumbnails Effect', 'pen' )
		);
		$choices    = array(
			'none'     => __( 'None', 'pen' ),
			'zoom_in'  => __( 'Zoom in', 'pen' ),
			'zoom_out' => __( 'Zoom out', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_list_masonry_thumbnail_style[$preset]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'jQuery Masonry', 'pen' ),
			__( 'Thumbnails Style', 'pen' )
		);
		$choices    = array(
			0 => __( 'None', 'pen' ),
		);
		for ( $i = 1; $i <= 25; $i++ ) {
			/* Translators: %d the style number. */
			$choices[ $i ] = sprintf( __( 'Style %d', 'pen' ), $i );
		}
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_list_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Content List', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_list_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Content List', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id  = "pen_list_effect[$preset]";
		$label       = __( 'Content List Effect', 'pen' );
		$description = __( 'This may not work in conjunction with some of the animations in the "Content list animation" above.', 'pen' );
		$choices     = array(
			'none'         => __( 'None', 'pen' ),
			'enlarge'      => __( 'Enlarge', 'pen' ),
			'fade'         => __( 'Fade', 'pen' ),
			'enlarge_fade' => sprintf(
				'%1$s + %2$s',
				__( 'Enlarge', 'pen' ),
				__( 'Fade', 'pen' )
			),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label, $description );

		$setting_id = "pen_list_header_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_post_header_alignment[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. content header. */
			_x( 'Center-align %s', 'verb', 'pen' ),
			__( 'Content Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_title_alignment[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Center-align Content Titles. */
			_x( 'Center-align %s', 'verb', 'pen' ),
			__( 'Content Titles', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_excerpt[$preset]";
		$label      = __( 'Prefer Excerpt over an automatic summary', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_title_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Titles', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_author_location[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			__( '%s Location', 'pen' ),
			__( 'Content Author', 'pen' )
		);
		$choices = array(
			'header' => __( 'Content Header', 'pen' ),
			'footer' => __( 'Content Footer', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_list_author_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Authors', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_author_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Author Profile', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_list_author_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Author Profile', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_list_date_location[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			__( '%s Location', 'pen' ),
			__( 'Content Date', 'pen' )
		);
		$choices = array(
			'header' => __( 'Content Header', 'pen' ),
			'footer' => __( 'Content Footer', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_list_date_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Date', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_category_location[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			__( '%s Location', 'pen' ),
			__( 'Content Categories', 'pen' )
		);

		$choices = array(
			'header' => __( 'Content Header', 'pen' ),
			'footer' => __( 'Content Footer', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_list_category_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Categories', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_category_only_first[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'The First Category Only', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_thumbnail_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Thumbnails', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_thumbnail_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Thumbnails', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_list_thumbnail_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Thumbnails', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id  = "pen_list_thumbnail_rotate[$preset]";
		$label       = __( 'Content Thumbnail Rotate', 'pen' );
		$description = __( 'Does not apply to the jQuery Masonry layout.', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id  = "pen_list_thumbnail_frame[$preset]";
		$label       = __( 'Content Thumbnail Frame', 'pen' );
		$description = __( 'Does not apply to the jQuery Masonry layout.', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_list_thumbnail_alignment[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Alignment', 'pen' ),
			__( 'Content Thumbnail', 'pen' )
		);
		$description = __( 'Does not apply to the jQuery Masonry layout.', 'pen' );
		$choices     = array(
			'left'   => __( 'Left', 'pen' ),
			'center' => __( 'Center', 'pen' ),
			'right'  => __( 'Right', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label, $description );

		$setting_id      = "pen_list_thumbnail_resize[$preset]";
		$label           = __( 'Content Thumbnail Size', 'pen' );
		$description     = __( 'Does not apply to the jQuery Masonry layout.', 'pen' );
		$thumbnail_sizes = array(
			'none' => __( 'None', 'pen' ),
		);
		$thumbnail_sizes = array_merge( $thumbnail_sizes, $variables['options_image_sizes'] );
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $thumbnail_sizes, $label, $description );

		$setting_id = "pen_list_summary_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Summaries', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_profile_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Author Profile', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_tags_display[$preset]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'Footer', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				__( 'Author Profile', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_button_comment_display[$preset]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'Footer', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Display Site Header. */
					__( '%s Buttons', 'pen' ),
					_x( 'Comment', 'noun', 'pen' )
				)
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_button_edit_display[$preset]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'Footer', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Share Buttons. */
					__( '%s Buttons', 'pen' ),
					_x( 'Edit', 'noun', 'pen' )
				)
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_list_pager_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
				__( '%s Buttons', 'pen' ),
				_x( 'Pagination', 'noun', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_list_pager_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
				__( '%s Buttons', 'pen' ),
				_x( 'Pagination', 'noun', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

	}
}

if ( ! function_exists( 'pen_customize_content_full' ) ) {
	/**
	 * Adds "Full Content" options.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param array                $variables    Common variables.
	 *
	 * @since Pen 1.0.2
	 * @return void
	 */
	function pen_customize_content_full( &$wp_customize, $variables ) {

		$preset = 'preset_1';

		$panel = 'pen_panel_content';

		$section = 'pen_section_content';
		$wp_customize->add_section(
			$section,
			array(
				'title'       => __( 'Full Content Views', 'pen' ),
				'description' => __( 'You can override these settings for individual contents through Posts (or Pages) &rarr; Edit &rarr; Pen Options.', 'pen' ),
				'panel'       => $panel,
			)
		);

		$setting_id = "pen_content_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Content Area', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_content_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Content Area', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_content_header_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_header_alignment[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. content header. */
			_x( 'Center-align %s', 'verb', 'pen' ),
			__( 'Content Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_title_alignment[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. content header. */
			_x( 'Center-align %s', 'verb', 'pen' ),
			__( 'Content Titles', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_title_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Title', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_author_location[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			__( '%s Location', 'pen' ),
			__( 'Content Author', 'pen' )
		);
		$choices = array(
			'header' => __( 'Content Header', 'pen' ),
			'footer' => __( 'Content Footer', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_content_author_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Author', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_author_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Author Profile', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_content_author_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Author Profile', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_content_date_location[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Share Buttons Location. */
			__( '%s Location', 'pen' ),
			__( 'Content Date', 'pen' )
		);
		$choices = array(
			'header' => __( 'Content Header', 'pen' ),
			'footer' => __( 'Content Footer', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_content_date_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Date', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_category_location[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Share Buttons Location. */
			__( '%s Location', 'pen' ),
			__( 'Content Categories', 'pen' )
		);
		$choices = array(
			'header' => __( 'Content Header', 'pen' ),
			'footer' => __( 'Content Footer', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_content_category_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Category', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_category_only_first[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'The First Category Only', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_thumbnail_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Thumbnail', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_thumbnail_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Thumbnails', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_content_thumbnail_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Thumbnails', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_content_thumbnail_alignment[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Alignment', 'pen' ),
			__( 'Content Thumbnail', 'pen' )
		);
		$choices = array(
			'left'   => __( 'Left', 'pen' ),
			'center' => __( 'Center', 'pen' ),
			'right'  => __( 'Right', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id      = "pen_content_thumbnail_resize[$preset]";
		$label           = __( 'Content Thumbnail Size', 'pen' );
		$thumbnail_sizes = array(
			'none' => __( 'None', 'pen' ),
		);
		$thumbnail_sizes = array_merge( $thumbnail_sizes, $variables['options_image_sizes'] );
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $thumbnail_sizes, $label );

		$setting_id = "pen_content_thumbnail_rotate[$preset]";
		$label      = __( 'Content Thumbnail Rotate', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_thumbnail_frame[$preset]";
		$label      = __( 'Content Thumbnail Framed', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_tags_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Tags', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_share_location[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			__( '%s Location', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				__( '%s Buttons', 'pen' ),
				_x( 'Share', 'noun', 'pen' )
			)
		);
		$choices = array(
			'header'  => __( 'Content Header', 'pen' ),
			'content' => __( 'Content', 'pen' ),
			'footer'  => __( 'Content Footer', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_content_share_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				__( '%s Buttons', 'pen' ),
				_x( 'Share', 'noun', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_content_profile_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Author Profile', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_comments_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Comments', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_comments_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Comments', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_content_pager_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Pagination', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_content_pager_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Pagination', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

	}
}

if ( ! function_exists( 'pen_customize_site_layout' ) ) {
	/**
	 * Adds "Site layout" options.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param array                $variables    Common variables.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_customize_site_layout( &$wp_customize, $variables ) {

		$preset = 'preset_1';

		$panel = 'pen_panel_content';

		$section = 'pen_section_layout';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Site Layout', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_site_width[$preset]";
		$label      = __( 'Site Layout', 'pen' );
		$choices    = array(
			'standard' => __( 'Standard', 'pen' ),
			'wide'     => __( 'Wide', 'pen' ),
			'boxed'    => __( 'Boxed', 'pen' ),
		);
		pen_control_radio( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_container_position[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Alignment', 'pen' ),
			__( 'Content Area', 'pen' )
		);
		$choices = array(
			'left'   => __( 'Left', 'pen' ),
			'center' => __( 'Center', 'pen' ),
			'right'  => __( 'Right', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'postMessage', $choices, $label );

		$setting_id = "pen_round_corners[$preset]";
		$label      = __( 'Round corners', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

	}
}

if ( ! function_exists( 'pen_customize_front' ) ) {
	/**
	 * "Front page" options.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param array                $variables    Common variables.
	 *
	 * @since Pen 1.0.2
	 * @return void
	 */
	function pen_customize_front( &$wp_customize, $variables ) {

		$preset = 'preset_1';

		$panel = 'pen_panel_front';
		$wp_customize->add_panel(
			$panel,
			array(
				'title'    => __( 'Front Page', 'pen' ),
				'priority' => 5,
			)
		);

		$wp_customize->get_section( 'static_front_page' )->panel = $panel;
		$wp_customize->get_section( 'static_front_page' )->title = __( 'Front Page Content', 'pen' );

		$section = 'pen_section_front_sidebars';
		$wp_customize->add_section(
			$section,
			array(
				'title'       => __( 'Front Page Sidebars', 'pen' ),
				'description' => __( 'You may also use some plugins such as the "Widget Visibility" or "Conditional Logic".', 'pen' ),
				'panel'       => $panel,
			)
		);

		$setting_id = "pen_front_sidebar_header_primary_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Header', 'pen' ),
				__( 'Primary', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_header_secondary_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Header', 'pen' ),
				__( 'Secondary', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_search_top_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Search', 'pen' ),
				__( 'Top', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_search_left_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Search', 'pen' ),
				__( 'Left', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_search_right_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Search', 'pen' ),
				__( 'Right', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_search_bottom_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Search', 'pen' ),
				__( 'Bottom', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_top_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			__( 'Top', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_left_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			__( 'Left', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_right_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			__( 'Right', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_content_top_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Content', 'pen' ),
				__( 'Top', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_content_bottom_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Content', 'pen' ),
				__( 'Bottom', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_bottom_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			__( 'Bottom', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_footer_top_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Top', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_footer_left_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Left', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_footer_right_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Right', 'pen' )
			),
			sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Top', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_front_sidebar_footer_bottom_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Bottom', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

	}
}

if ( ! function_exists( 'pen_customize_footer' ) ) {
	/**
	 * Adds footer options.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param array                $variables    Common variables.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_customize_footer( &$wp_customize, $variables ) {

		$preset = 'preset_1';

		$section = 'pen_section_footer';
		$wp_customize->add_section(
			$section,
			array(
				'title'       => __( 'Footer', 'pen' ),
				'description' => sprintf(
					/* Translators: 1: opening tag for a hyperlink, e.g. <a href="#">, 2: closing tag for a hyperlink, e.g. </a>. */
					__( 'You can control the visibility of the phone number and social network icons through Customize &rarr; Contact and the colors of the footer links through %1$sCustomize &rarr; Colors &rarr; Footer%2$s.', 'pen' ),
					sprintf(
						'<a href="%s" class="pen_customizer_shortcut" data-type="section" data-target="pen_section_colors_footer">',
						esc_url( add_query_arg( array( 'autofocus[section]' => 'pen_section_colors_footer' ), $variables['url_customize'] ) )
					),
					'</a>'
				),
				'priority'    => 6,
			)
		);

		$setting_id = "pen_site_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Site Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_footer_alignment[$preset]";
		$label      = sprintf(
			/* Translators: %s: Some elements, such as Header links. */
			__( '%s Alignment', 'pen' ),
			__( 'Footer', 'pen' )
		);
		$choices = array(
			'left'   => __( 'Left', 'pen' ),
			'center' => __( 'Center', 'pen' ),
			'right'  => __( 'Right', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'postMessage', $choices, $label );

		$setting_id = "pen_footer_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_footer_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_footer_menu_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Footer Navigation', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id = "pen_footer_menu_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Footer Menu', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_footer_menu_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Footer Menu', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_footer_menu_separator[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Footer Menu Separator', 'pen' ),
			__( 'Desktop Only', 'pen' )
		);
		$choices    = array(
			0 => __( 'None', 'pen' ),
		);
		for ( $i = 1; $i <= 10; $i++ ) {
			/* Translators: %d the style number. */
			$choices[ $i ] = sprintf( __( 'Style %d', 'pen' ), $i );
		}
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

		$setting_id = "pen_social_footer_animation_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation', 'pen' ),
			__( 'Social Links', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_social_footer_animation_delay_reveal[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			__( '%s Animation Delay', 'pen' ),
			__( 'Social Links', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_phone_footer_animation_reveal[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
				__( '%s Animation', 'pen' ),
				__( 'Phone Number', 'pen' )
			),
			__( 'Footer', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_phone_footer_animation_delay_reveal[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
				__( '%s Animation Delay', 'pen' ),
				__( 'Phone Number', 'pen' )
			),
			__( 'Footer', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_footer_back_to_top_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Login Link. */
				__( '%s Link', 'pen' ),
				sprintf(
					'"%s"',
					_x( 'Back to top', 'noun', 'pen' )
				)
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_footer_copyright_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Copyright', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'postMessage', $label );

		$setting_id  = "pen_footer_copyright_text[$preset]";
		$label       = __( 'Copyright Notice', 'pen' );
		$description = sprintf(
			/* Translators: %s: HTML list. */
			__( 'The following tokens are available:%s', 'pen' ),
			sprintf(
				'<br><ul><li>%s</li><li>%s</li><li>%s</li></ul>%s',
				sprintf(
					/* Translators: %s: a token, i.e. %YEAR%. */
					__( '%s for the current year.', 'pen' ),
					'<strong>%YEAR%</strong>'
				),
				sprintf(
					/* Translators: 1: a token, i.e. %SITE_NAME%, 2: opening tag for a hyperlink, e.g. <a href="#">, 3: closing tag for a hyperlink, e.g. </a>. */
					__( '%1$s for your site title as set in %2$sCustomize &rarr; Site Identity%3$s.', 'pen' ),
					'<strong>%SITE_NAME%</strong>',
					sprintf(
						'<a href="%s" class="pen_customizer_shortcut" data-type="section" data-target="title_tagline">',
						esc_url( add_query_arg( array( 'autofocus[section]' => 'title_tagline' ), $variables['url_customize'] ) )
					),
					'</a>'
				),
				sprintf(
					/* Translators: %s: a token, i.e. %SITE_URL%. */
					__( '%s for your site URL as set in Settings &rarr; General.', 'pen' ),
					'<strong>%SITE_URL%</strong>'
				),
				sprintf(
					'<strong>%1$s</strong>%2$s',
					__( 'Examples:', 'pen' ),
					sprintf(
						'<br><ul><li><small>%1$s</small></li><li><small>%2$s</small></li><li><small>%3$s</small></li></ul>',
						sprintf(
							'&amp;copy; %%YEAR%% %1$s %%SITE_NAME%%. %2$s',
							/* Translators: "by" as in copyright notice, e.g. Copyright 2019 by Lorem Ipsum. All rights reserved. */
							__( 'by', 'pen' ),
							__( 'All rights reserved.', 'pen' )
						),
						sprintf(
							'&amp;copy; %%YEAR%% %1$s &lt;a href="%%SITE_URL%%"&gt;%%SITE_NAME%%&lt;/a&gt;. %2$s.',
							/* Translators: "by" as in copyright notice, e.g. Copyright 2019 by Lorem Ipsum. All rights reserved. */
							__( 'by', 'pen' ),
							__( 'All rights reserved.', 'pen' )
						),
						__( '(Supports limited HTML)', 'pen' )
					)
				)
			)
		);
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

	}
}

if ( ! function_exists( 'pen_customize_contact' ) ) {
	/**
	 * Adds contact details options.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param array                $variables    Common variables.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_customize_contact( &$wp_customize, $variables ) {

		$preset = 'preset_1';

		$panel = 'pen_panel_contact';
		$wp_customize->add_panel(
			$panel,
			array(
				'title'    => __( 'Contact Information', 'pen' ),
				'priority' => 7,
			)
		);

		$section = 'pen_section_twitter';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Twitter', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_twitter[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook. */
			__( '%s URL', 'pen' ),
			__( 'Twitter', 'pen' )
		);
		$description = 'https://twitter.com/example';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_twitter_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Twitter', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_twitter_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Twitter', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_facebook';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Facebook', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_facebook[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook. */
			__( '%s URL', 'pen' ),
			__( 'Facebook', 'pen' )
		);
		$description = 'https://facebook.com/example';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_facebook_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Facebook', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_facebook_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Facebook', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_instagram';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Instagram', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_instagram[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook. */
			__( '%s URL', 'pen' ),
			__( 'Instagram', 'pen' )
		);
		$description = 'https://instagram.com/example';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_instagram_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Instagram', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_instagram_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Instagram', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_vk';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'VK', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_vk[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook. */
			__( '%s URL', 'pen' ),
			__( 'VK', 'pen' )
		);
		$description = 'https://vk.com/example';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_vk_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'VK', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_vk_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'VK', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_pinterest';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Pinterest', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_pinterest[$preset]";
		$label      = sprintf(
			/* Translators: %s: Social network name, e.g. Facebook. */
			__( '%s URL', 'pen' ),
			__( 'Pinterest', 'pen' )
		);
		$description = 'https://pinterest.com/example';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_pinterest_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Pinterest', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_pinterest_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Pinterest', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_linkedin';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'LinkedIn', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_linkedin[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook. */
			__( '%s URL', 'pen' ),
			__( 'LinkedIn', 'pen' )
		);
		$description = 'https://linkedin.com/example';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_linkedin_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'LinkedIn', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_linkedin_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'LinkedIn', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_flickr';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Flickr', 'pen' ),
				'panel' => 'pen_panel_contact',
			)
		);

		$setting_id = "pen_flickr[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook. */
			__( '%s URL', 'pen' ),
			__( 'Flickr', 'pen' )
		);
		$description = 'https://flickr.com/example';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_flickr_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Flickr', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_flickr_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Flickr', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_bitbucket';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'BitBucket', 'pen' ),
				'panel' => 'pen_panel_contact',
			)
		);

		$setting_id = "pen_bitbucket[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook. */
			__( '%s URL', 'pen' ),
			__( 'BitBucket', 'pen' )
		);
		$description = 'https://bitbucket.com/example';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_bitbucket_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'BitBucket', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_bitbucket_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'BitBucket', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_github';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'GitHub', 'pen' ),
				'panel' => 'pen_panel_contact',
			)
		);

		$setting_id = "pen_github[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook. */
			__( '%s URL', 'pen' ),
			__( 'GitHub', 'pen' )
		);
		$description = 'https://github.com/example';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_github_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'GitHub', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_github_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'GitHub', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_slack';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Slack', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_slack[$preset]";
		$label      = sprintf(
			/* Translators: %s: Social network name, e.g. Facebook. */
			__( '%s URL', 'pen' ),
			__( 'Slack', 'pen' )
		);
		$description = 'https://slack.com/example';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_slack_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Slack', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_slack_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Slack', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_telegram';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Telegram', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_telegram[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook. */
			__( '%s URL', 'pen' ),
			__( 'Telegram', 'pen' )
		);
		$description = 'https://t.me/example';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_telegram_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Telegram', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_telegram_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Telegram', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_whatsapp';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'WhatsApp', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_whatsapp[$preset]";
		$label      = sprintf(
			/* Translators: %s Some website name. */
			__( '%s Link', 'pen' ),
			__( 'WhatsApp', 'pen' )
		);
		$description = 'whatsapp://send?text=Hi!&phone=+123456789';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_whatsapp_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'WhatsApp', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_whatsapp_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'WhatsApp', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_skype';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Skype', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_skype[$preset]";
		$label      = sprintf(
			/* Translators: %s Some website name. */
			__( '%s Link', 'pen' ),
			__( 'Skype', 'pen' )
		);
		$description = 'skype:username?call';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_skype_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Skype', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_skype_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Skype', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_phone';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Phone', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_phone[$preset]";
		$label      = __( 'Phone Number', 'pen' );
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_phone_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Phone', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_phone_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'Phone', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_rss';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Feed', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id = "pen_rss[$preset]";
		$label      = sprintf(
			/* Translators: %s: Social network name, e.g. Facebook. */
			__( '%s URL', 'pen' ),
			__( 'Feed', 'pen' )
		);
		$description = 'http://example.com/rss.xml';
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_rss_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'RSS', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_rss_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'RSS', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_email';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'E-mail', 'pen' ),
				'panel' => $panel,
			)
		);

		$setting_id  = "pen_email[$preset]";
		$label       = __( 'Your e-mail or URL to a "Contact us" page', 'pen' );
		$description = sprintf(
			/* Translators: 1 and 2: sample URLs. */
			__( '%1$s or %2$s', 'pen' ),
			'mail@example.com',
			'http://example.com/contact-us'
		);
		pen_control_text( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_email_header_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'E-mail', 'pen' ),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_email_footer_display[$preset]";
		$label      = sprintf(
			/* Translators: 1: Social network name, e.g. Facebook, 2: part of the layout, e.g. header, footer, etc. */
			__( '%1$s link in the %2$s', 'pen' ),
			__( 'E-mail', 'pen' ),
			__( 'Footer', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

	}
}

if ( ! function_exists( 'pen_customize_background' ) ) {
	/**
	 * Adds the background image options.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param array                $variables    Common variables.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_customize_background( &$wp_customize, $variables ) {

		$preset = 'preset_1';

		$panel = 'p_panel_background_images';
		$wp_customize->add_panel(
			$panel,
			array(
				'title'    => __( 'Background Images', 'pen' ),
				'priority' => 10,
			)
		);

		$section = 'background_image';

		$wp_customize->get_section( $section )->title     = __( 'Site', 'pen' );
		$wp_customize->get_section( $section )->priority  = 1;
		$wp_customize->get_section( $section )->transport = 'refresh';
		$wp_customize->get_section( $section )->panel     = $panel;

		$setting_id  = "pen_background_lights_dim[$preset]";
		$label       = __( 'Dim the lights', 'pen' );
		$description = __( '(This feature is a part of the "Pen" theme.)', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$section = 'header_image';

		$wp_customize->get_section( $section )->title     = __( 'Header', 'pen' );
		$wp_customize->get_section( $section )->priority  = 2;
		$wp_customize->get_section( $section )->transport = 'refresh';
		$wp_customize->get_section( $section )->panel     = $panel;

		$section = 'pen_section_background_image_navigation';
		$wp_customize->add_section(
			$section,
			array(
				'title'    => __( 'Navigation', 'pen' ),
				'priority' => 3,
				'panel'    => $panel,
			)
		);

		$setting_id = "pen_background_image_navigation[$preset]";
		$label      = __( 'Navigation', 'pen' );
		pen_control_image( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_background_image_navigation_submenu[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			__( 'Navigation', 'pen' ),
			__( 'Submenus', 'pen' )
		);
		pen_control_image( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_background_image_search';
		$wp_customize->add_section(
			$section,
			array(
				'title'       => __( 'Search Bar', 'pen' ),
				'priority'    => 4,
				'description' => sprintf(
					/* Translators: 1: opening tag for a hyperlink, e.g. <a href="#">, 2: closing tag for a hyperlink, e.g. </a>. */
					__( 'Please make sure you have the search box added to the top of the content area through %1$sCustomize &rarr; Search%2$s so you can see your background image.', 'pen' ),
					sprintf(
						'<a href="%s" class="pen_customizer_shortcut" data-type="section" data-target="pen_section_header_search">',
						esc_url( add_query_arg( array( 'autofocus[section]' => 'pen_section_header_search' ), $variables['url_customize'] ) )
					),
					'</a>'
				),
				'panel'       => $panel,
			)
		);

		$setting_id = "pen_background_image_search[$preset]";
		$label      = __( 'Search Bar', 'pen' );
		pen_control_image( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_background_image_content_title';
		$wp_customize->add_section(
			$section,
			array(
				'title'    => __( 'Content', 'pen' ),
				'priority' => 5,
				'panel'    => $panel,
			)
		);

		$setting_id = "pen_background_image_content_title[$preset]";
		$label      = __( 'Content Title', 'pen' );
		pen_control_image( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_background_image_content_title_dynamic[$preset]";
		$label      = __( 'Use Featured Image As Background', 'pen' );
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_background_image_bottom';
		$wp_customize->add_section(
			$section,
			array(
				'title'    => __( 'Bottom', 'pen' ),
				'priority' => 6,
				'panel'    => $panel,
			)
		);

		$setting_id = "pen_background_image_bottom[$preset]";
		$label      = __( 'Bottom', 'pen' );
		pen_control_image( $wp_customize, $setting_id, $section, 'refresh', $label );

		$section = 'pen_section_background_image_footer';
		$wp_customize->add_section(
			$section,
			array(
				'title'    => __( 'Footer', 'pen' ),
				'priority' => 7,
				'panel'    => $panel,
			)
		);

		$setting_id = "pen_background_image_footer[$preset]";
		$label      = __( 'Footer', 'pen' );
		pen_control_image( $wp_customize, $setting_id, $section, 'refresh', $label );

	}
}

if ( ! function_exists( 'pen_customize_woocommerce' ) ) {
	/**
	 * Adds WooCommerce options.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param array                $variables    Common variables.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_customize_woocommerce( &$wp_customize, $variables ) {

		$preset = 'preset_1';

		$section = 'pen_section_woocommerce_general';
		$wp_customize->add_section(
			$section,
			array(
				'title' => __( 'Theme Options', 'pen' ),
				'panel' => 'woocommerce',
			)
		);

		$setting_id = "pen_cart_header_display[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Shopping Cart Button. */
					__( '%s Button', 'pen' ),
					__( 'Cart', 'pen' )
				)
			),
			__( 'Header', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_cart_header_animation_reveal[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
				__( '%s Animation', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Shopping Cart Button. */
					__( '%s Button', 'pen' ),
					__( 'Cart', 'pen' )
				)
			),
			__( 'Header', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_cart_header_animation_delay_reveal[$preset]";
		$label      = sprintf(
			'%1$s (%2$s)',
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation delay. */
				__( '%s Animation Delay', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Shopping Cart Button. */
					__( '%s Button', 'pen' ),
					__( 'Cart', 'pen' )
				)
			),
			__( 'Header', 'pen' )
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_cart_navigation_include[$preset]";
		$label      = sprintf(
			'%1$s: %2$s',
			__( 'Navigation', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				__( 'Include the %s', 'pen' ),
				__( 'Shopping Cart', 'pen' )
			)
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_cart_products_related_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Related Products', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_cart_upsells_per_product[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the site, e.g. Number of Related Products. */
			__( 'Number of %s', 'pen' ),
			__( 'Related Products', 'pen' )
		);
		$description = sprintf(
			/* Translators: %s: the default value. */
			__( 'Default: %s', 'pen' ),
			pen_option_default( 'cart_upsells_per_product' )
		);
		pen_control_number( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

		$setting_id = "pen_cart_upsells_columns[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the site, e.g. Number of Related Products. */
			__( 'Number of %s', 'pen' ),
			__( 'Columns For Related Products', 'pen' )
		);
		$description  = sprintf(
			'%s<br>',
			__( 'This may automatically change to provide the best appearance and user experience.', 'pen' )
		);
		$description .= sprintf(
			/* Translators: %s: the default value. */
			__( 'Default: %s', 'pen' ),
			pen_option_default( 'cart_upsells_columns' )
		);
		$choices = array(
			1 => __( 'One', 'pen' ),
			2 => __( 'Two', 'pen' ),
			3 => __( 'Three', 'pen' ),
			4 => __( 'Four', 'pen' ),
			5 => __( 'Five', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label, $description );

		$setting_id  = "pen_content_per_page_products[$preset]";
		$label       = __( 'Products per page', 'pen' );
		$description = sprintf(
			/* Translators: %s: the default value. */
			__( 'Default: %s', 'pen' ),
			pen_option_default( 'content_per_page_products' )
		);
		$description .= sprintf(
			'<br>%s',
			sprintf(
				/* Translators: 1: opening tag for a hyperlink, e.g. <a href="#">, 2: closing tag for a hyperlink, e.g. </a>. */
				__( 'When using the jQuery Masonry layout the %1$sColumns setting%2$s for it would override this one.', 'pen' ),
				sprintf(
					'<a href="%s" class="pen_customizer_shortcut" data-type="section" data-target="pen_section_list">',
					esc_url( add_query_arg( array( 'autofocus[section]' => 'pen_section_list' ), $variables['url_customize'] ) )
				),
				'</a>'
			)
		);
		pen_control_number( $wp_customize, $setting_id, $section, 'refresh', $label, $description );

	}
}

if ( ! function_exists( 'pen_customize_logo' ) ) {
	/**
	 * Moves logo options to "Site Identity".
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param array                $variables    Common variables.
	 *
	 * @since Pen 1.0.8
	 * @return void
	 */
	function pen_customize_logo( &$wp_customize, $variables ) {

		$preset = 'preset_1';

		$section = 'title_tagline';

		$setting_id = "pen_header_logo_display[$preset]";
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Site Logo', 'pen' )
		);
		pen_control_checkbox( $wp_customize, $setting_id, $section, 'refresh', $label );

		$setting_id = "pen_header_logo_animation_reveal[$preset]";
		$label      = sprintf(
			'[%1$s] %2$s',
			__( 'Pen', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
				__( '%s Animation', 'pen' ),
				__( 'Logo', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation'], $label );

		$setting_id = "pen_header_logo_animation_delay_reveal[$preset]";
		$label      = sprintf(
			'[%1$s] %2$s',
			__( 'Pen', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
				__( '%s Animation Delay', 'pen' ),
				__( 'Logo', 'pen' )
			)
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $variables['options_animation_delay'], $label );

		$setting_id = "pen_header_logo_size[$preset]";
		$label      = sprintf(
			'[%1$s] %2$s',
			__( 'Pen', 'pen' ),
			__( 'Logo Size', 'pen' )
		);
		$choices    = array(
			'none'   => __( 'None', 'pen' ),
			'height' => _x( 'Limit Height', 'verb', 'pen' ),
			'width'  => _x( 'Limit Width', 'verb', 'pen' ),
		);
		pen_control_select( $wp_customize, $setting_id, $section, 'refresh', $choices, $label );

	}
}

if ( ! function_exists( 'pen_control_color' ) ) {
	/**
	 * Color control.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $setting_id   The setting ID.
	 * @param string               $section      Field section.
	 * @param string               $transport    Transport type.
	 * @param string               $label        Field label.
	 * @param string               $description  Field description.
	 *
	 * @since Pen 1.0.8
	 * @return void
	 */
	function pen_control_color( &$wp_customize, $setting_id, $section, $transport, $label, $description = '' ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => pen_option_default( $setting_id ),
				'sanitize_callback' => pen_option_sanitize( $setting_id ),
				'transport'         => $transport,
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$setting_id,
				array(
					'label'       => $label,
					'description' => $description,
					'section'     => $section,
					'settings'    => $setting_id,
				)
			)
		);
	}
}

if ( ! function_exists( 'pen_control_image' ) ) {
	/**
	 * Image control.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $setting_id   The setting ID.
	 * @param string               $section      Field section.
	 * @param string               $transport    Transport type.
	 * @param string               $label        Field label.
	 * @param string               $description  Field description.
	 *
	 * @since Pen 1.0.8
	 * @return void
	 */
	function pen_control_image( &$wp_customize, $setting_id, $section, $transport, $label, $description = '' ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => pen_option_default( $setting_id ),
				'sanitize_callback' => pen_option_sanitize( $setting_id ),
				'transport'         => $transport,
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$setting_id,
				array(
					'label'       => $label,
					'description' => $description,
					'section'     => $section,
					'settings'    => $setting_id,
				)
			)
		);
	}
}

if ( ! function_exists( 'pen_control_checkbox' ) ) {
	/**
	 * Checkbox control.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $setting_id   The setting ID.
	 * @param string               $section      Field section.
	 * @param string               $transport    Transport type.
	 * @param string               $label        Field label.
	 * @param string               $description  Field description.
	 *
	 * @since Pen 1.0.8
	 * @return void
	 */
	function pen_control_checkbox( &$wp_customize, $setting_id, $section, $transport, $label, $description = '' ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => pen_option_default( $setting_id ),
				'sanitize_callback' => pen_option_sanitize( $setting_id ),
				'transport'         => $transport,
			)
		);
		$wp_customize->add_control(
			$setting_id,
			array(
				'label'       => $label,
				'description' => $description,
				'section'     => $section,
				'type'        => 'checkbox',
			)
		);
	}
}

if ( ! function_exists( 'pen_control_radio' ) ) {
	/**
	 * Radio button control.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $setting_id   The setting ID.
	 * @param string               $section      Field section.
	 * @param string               $transport    Transport type.
	 * @param array                $choices      Choices.
	 * @param string               $label        Field label.
	 * @param string               $description  Field description.
	 *
	 * @since Pen 1.0.8
	 * @return void
	 */
	function pen_control_radio( &$wp_customize, $setting_id, $section, $transport, $choices, $label, $description = '' ) {

		$default = pen_option_default( $setting_id );

		foreach ( $choices as $key => $value ) {
			if ( $key === $default && false === stripos( $value, __( 'Default', 'pen' ) ) ) {
				$choices[ $key ] = esc_html(
					sprintf(
						/* Translators: %s: just some text, such as 'Fade In (Default)'. */
						__( '%s (Default)', 'pen' ),
						$value
					)
				);
			}
		}

		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $default,
				'sanitize_callback' => pen_option_sanitize( $setting_id ),
				'transport'         => $transport,
			)
		);
		$wp_customize->add_control(
			$setting_id,
			array(
				'label'       => $label,
				'description' => $description,
				'section'     => $section,
				'type'        => 'radio',
				'choices'     => $choices,
			)
		);
	}
}

if ( ! function_exists( 'pen_control_select' ) ) {
	/**
	 * Select control.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $setting_id   The setting ID.
	 * @param string               $section      Field section.
	 * @param string               $transport    Transport type.
	 * @param array                $choices      Choices.
	 * @param string               $label        Field label.
	 * @param string               $description  Field description.
	 *
	 * @since Pen 1.0.8
	 * @return void
	 */
	function pen_control_select( &$wp_customize, $setting_id, $section, $transport, $choices, $label, $description = '' ) {

		$default = pen_option_default( $setting_id );

		foreach ( $choices as $key => $value ) {
			if ( $key === $default && false === stripos( $value, __( 'Default', 'pen' ) ) ) {
				$choices[ $key ] = esc_html(
					sprintf(
						/* Translators: %s: just some text, such as 'Fade In (Default)'. */
						__( '%s (Default)', 'pen' ),
						$value
					)
				);
			}
		}

		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => $default,
				'sanitize_callback' => pen_option_sanitize( $setting_id ),
				'transport'         => $transport,
			)
		);
		$wp_customize->add_control(
			$setting_id,
			array(
				'label'       => $label,
				'description' => $description,
				'section'     => $section,
				'type'        => 'select',
				'choices'     => $choices,
			)
		);
	}
}

if ( ! function_exists( 'pen_control_text' ) ) {
	/**
	 * Text control.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $setting_id   The setting ID.
	 * @param string               $section      Field section.
	 * @param string               $transport    Transport type.
	 * @param string               $label        Field label.
	 * @param string               $description  Field description.
	 *
	 * @since Pen 1.0.8
	 * @return void
	 */
	function pen_control_text( &$wp_customize, $setting_id, $section, $transport, $label, $description = '' ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => pen_option_default( $setting_id ),
				'sanitize_callback' => pen_option_sanitize( $setting_id ),
				'transport'         => $transport,
			)
		);
		$wp_customize->add_control(
			$setting_id,
			array(
				'label'       => $label,
				'description' => $description,
				'section'     => $section,
				'type'        => 'text',
			)
		);
	}
}

if ( ! function_exists( 'pen_control_number' ) ) {
	/**
	 * Number control.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $setting_id   The setting ID.
	 * @param string               $section      Field section.
	 * @param string               $transport    Transport type.
	 * @param string               $label        Field label.
	 * @param string               $description  Field description.
	 *
	 * @since Pen 1.2.8
	 * @return void
	 */
	function pen_control_number( &$wp_customize, $setting_id, $section, $transport, $label, $description = '' ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'default'           => pen_option_default( $setting_id ),
				'sanitize_callback' => pen_option_sanitize( $setting_id ),
				'transport'         => $transport,
			)
		);
		$wp_customize->add_control(
			$setting_id,
			array(
				'label'       => $label,
				'description' => $description,
				'section'     => $section,
				'type'        => 'number',
			)
		);
	}
}

if ( ! function_exists( 'pen_inline_css_general' ) ) {
	/**
	 * Adds inline CSS.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_inline_css_general() {

		$content_id = pen_post_id();

		$css                = '';
		$preset_color       = esc_html( pen_preset_get( 'color' ) );
		$preset_font        = esc_html( pen_preset_get( 'font_family' ) );
		$background         = esc_html( pen_option_get( 'color_site_background' ) );
		$background_default = pen_option_default( 'color_site_background' );
		$color              = esc_html( pen_option_get( 'color_text' ) );
		$color_default      = pen_option_default( 'color_text' );

		if ( 'preset_1' !== $preset_color || $background !== $background_default ) {
			// background overrides any linear-gradient in the CSS files
			// and background-color for any background image.
			$css .= 'body {
				background-color:' . $background . ';
				background:' . $background . ';';
			if ( 'preset_1' !== $preset_color || $color !== $color_default ) {
				$css .= 'color:' . $color . ';';
			}
			$css .= '}';
		}

		$site_font = esc_html( pen_option_get( 'font_family_site' ) );
		if ( 'default' !== $site_font || $color !== $color_default ) {
			$css .= 'body,
				button,
				button.hpcf_attachment_remove,
				input,
				select,
				optgroup,
				textarea {
					font-family:"' . ltrim( $site_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;
				}';
		}

		$headings_font = esc_html( pen_option_get( 'font_family_headings' ) );
		if ( 'default' !== $headings_font ) {
			$css .= 'h1,h2,h3,h4,h5 {
				font-family:"' . ltrim( $headings_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;
			}';
		}

		if ( pen_option_get( 'color_site_shadow_display' ) ) {
			$shadow_color         = esc_html( pen_option_get( 'color_shadow' ) );
			$shadow_color_default = pen_option_default( 'color_shadow' );
			if ( 'preset_1' !== $preset_color || $shadow_color !== $shadow_color_default ) {
				$shadow_color = new \Pen_Theme\Color( $shadow_color );
				$shadow_color = $shadow_color->getRgb();
				$shadow_color = 'rgba(' . implode( ',', $shadow_color ) . ',0.25)';

				$css .= '#main article.pen_article,
				body.pen_multiple #main li.pen_article,
				body.pen_drop_shadow #comments,
				body.pen_drop_shadow.pen_list_plain #pen_pager,
				body.pen_drop_shadow #main .pen_customize_overview.pen_off_screen,
				body.pen_drop_shadow #pen_header .pen_header_inner,
				body.pen_drop_shadow #pen_search,
				body.pen_drop_shadow #page .widget.pen_widget_not_transparent,
				body.pen_drop_shadow #pen_bottom.pen_not_transparent,
				body.pen_drop_shadow #pen_footer.pen_not_transparent {
					box-shadow:0 5px 10px ' . $shadow_color . ', 0 0 5px ' . $shadow_color . ' !important;
				}';
			}
		}

		$link_color               = esc_html( pen_option_get( 'color_link' ) );
		$link_color_default       = pen_option_default( 'color_link' );
		$link_color_hover         = esc_html( pen_option_get( 'color_link_hover' ) );
		$link_color_hover_default = pen_option_default( 'color_link_hover' );
		if ( 'preset_1' !== $preset_color || $link_color !== $link_color_default ) {
			$css .= 'a {
				color:' . $link_color . ';
			}';
		}
		if ( 'preset_1' !== $preset_color || $link_color_hover !== $link_color_hover_default ) {
			$css .= 'a:focus,
			a:hover,
			a:active {
				color:' . $link_color_hover . ';
			}';
		}

		$form_font = esc_html( pen_option_get( 'font_family_forms' ) );
		if ( 'default' !== $form_font ) {
			$css .= 'input[type="date"],
			input[type="email"],
			input[type="file"],
			input[type="number"],
			input[type="password"],
			input[type="tel"],
			input[type="time"],
			input[type="text"],
			input[type="url"],
			legend,
			option,
			select,
			textarea,
			#pen_header .pen_header_main .search-form .search-field,
			#pen_search .search-form .search-field {
				font-family:"' . ltrim( $form_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;
			}';
		}

		$button_color_text              = esc_html( pen_option_get( 'color_button_text' ) );
		$button_color_text_default      = pen_option_default( 'color_button_text' );
		$button_color_primary           = esc_html( pen_option_get( 'color_button_background_primary' ) );
		$button_color_primary_default   = pen_option_default( 'color_button_background_primary' );
		$button_color_secondary         = esc_html( pen_option_get( 'color_button_background_secondary' ) );
		$button_color_secondary_default = pen_option_default( 'color_button_background_secondary' );
		$button_color_border            = esc_html( pen_option_get( 'color_button_border' ) );
		$button_color_border_default    = pen_option_default( 'color_button_border' );
		$button_font                    = esc_html( pen_option_get( 'font_family_buttons' ) );

		if ( 'preset_1' !== $preset_color || $button_color_text !== $button_color_text_default || $button_color_primary !== $button_color_primary_default || $button_color_secondary !== $button_color_secondary_default || $button_color_border !== $button_color_border_default || 'default' !== $button_font ) {
			$css .= '#page .hpcf_button_submit,
				#page .pen_button,
				#primary .comments-link a,
				#primary a.post-edit-link,
				#primary .comment-list a.comment-edit-link,
				#primary .comment-list .reply a,
				#primary button,
				#primary .button,
				#primary input[type="button"],
				#primary input[type="reset"],
				#primary input[type="submit"],
				#primary .pen_content_footer .tags-links a,
				#page .hpcf_button_submit,
				#cancel-comment-reply-link,
				#content .page-links a,
				#content .comment-navigation a,
				#content .posts-navigation a,
				#content .post-navigation a,
				#content .wp-pagenavi a,
				#content .wp-pagenavi span,
				#page .hpcf_button_submit:focus,
				#page .pen_button:focus,
				#primary .comments-link a:focus,
				#primary a.post-edit-link:focus,
				#primary .comment-list a.comment-edit-link:focus,
				#primary .comment-list .reply a:focus,
				#primary button:focus,
				#primary .button:focus,
				#primary input[type="button"]:focus,
				#primary input[type="reset"]:focus,
				#primary input[type="submit"]:focus,
				#primary .pen_content_footer .tags-links a:focus,
				#page .hpcf_button_submit:focus,
				#cancel-comment-reply-link:focus,
				#content .pen_content button:focus,
				#content .pen_content .button:focus,
				#content .pen_content input[type="button"]:focus,
				#content .pen_content input[type="reset"]:focus,
				#content .pen_content input[type="submit"]:focus,
				#content .page-links a:focus,
				#content .comment-navigation a:focus,
				#content .posts-navigation a:focus,
				#content .post-navigation a:focus,
				#page .hpcf_button_submit:hover,
				#page .pen_button:hover,
				#primary .comments-link a:hover,
				#primary a.post-edit-link:hover,
				#primary .comment-list a.comment-edit-link:hover,
				#primary .comment-list .reply a:hover,
				#primary button:hover,
				#primary .button:hover,
				#primary input[type="button"]:hover,
				#primary input[type="reset"]:hover,
				#primary input[type="submit"]:hover,
				#primary .pen_content_footer .tags-links a:hover,
				#page .hpcf_button_submit:hover,
				#cancel-comment-reply-link:hover,
				#content .pen_content button:hover,
				#content .pen_content .button:hover,
				#content .pen_content input[type="button"]:hover,
				#content .pen_content input[type="reset"]:hover,
				#content .pen_content input[type="submit"]:hover,
				#content .page-links a:hover,
				#content .comment-navigation a:hover,
				#content .posts-navigation a:hover,
				#content .post-navigation a:hover';

			if ( PEN_THEME_HAS_WOOCOMMERCE ) {
				$css .= ',
					body.pen_has_woocommerce #page .wc-backward,
					body.pen_has_woocommerce #page .wc-forward,
					body.pen_has_woocommerce #page .wc-backward:focus,
					body.pen_has_woocommerce #page .wc-forward:focus,
					body.pen_has_woocommerce #page .wc-backward:hover,
					body.pen_has_woocommerce #page .wc-forward:hover';
			}

			$css .= '{';

			if ( 'preset_1' !== $preset_color || $button_color_primary !== $button_color_primary_default || $button_color_secondary !== $button_color_secondary_default ) {
				$css .= 'background-color:' . $button_color_secondary . ';
				background:' . $button_color_secondary . ';';
				if ( $button_color_primary !== $button_color_secondary ) {
					$css .= 'background:-ms-linear-gradient(top,' . $button_color_primary . ' 0%,' . $button_color_secondary . ' 100%);
					background:linear-gradient(to bottom,' . $button_color_primary . ' 0%,' . $button_color_secondary . ' 100%);';
				}
			}
			if ( 'preset_1' !== $preset_color || $button_color_text !== $button_color_text_default ) {
				$css .= 'color:' . $button_color_text . ' !important;';
			}
			if ( 'preset_1' !== $preset_color || $button_color_border !== $button_color_border_default ) {
				$css .= 'border:1px solid' . $button_color_border . ' !important;';
			}
			if ( 'default' !== $button_font ) {
				$css .= 'font-family:"' . ltrim( $button_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;';
			}
			$css .= '}';

			if ( 'preset_1' !== $preset_color || $button_color_primary !== $button_color_primary_default || $button_color_secondary !== $button_color_secondary_default ) {

				$css .= '#page .hpcf_button_submit:active,
				#page .pen_button:active,
				#page .pen_button.pen_active,
				#primary .comments-link a:active,
				#primary a.post-edit-link:active,
				#primary .comment-list a.comment-edit-link:active,
				#primary .comment-list .reply a:active,
				#primary button:active,
				#primary .button:active,
				#primary input[type="button"]:active,
				#primary input[type="reset"]:active,
				#primary input[type="submit"]:active,
				#primary .pen_content_footer .tags-links a:active,
				#page .hpcf_button_submit:active,
				#cancel-comment-reply-link:active,
				#content .pen_content button:active,
				#content .pen_content .button:active,
				#content .pen_content input[type="button"]:active,
				#content .pen_content input[type="reset"]:active,
				#content .pen_content input[type="submit"]:active,
				#content .page-links a:active,
				#content .comment-navigation a:active,
				#content .posts-navigation a:active,
				#content .post-navigation a:active,
				#content .wp-pagenavi span,
				#content .wp-pagenavi .current';

				if ( PEN_THEME_HAS_WOOCOMMERCE ) {
					$css .= ',
						body.pen_has_woocommerce #page .wc-backward:active,
						body.pen_has_woocommerce #page .wc-forward:active';
				}

				$css .= '{background:' . $button_color_secondary . '}';
			}
			if ( 'default' !== $button_font ) {
				$css .= '#pen_header .pen_header_main .search-form .search-submit {
					font-family:"' . ltrim( $button_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;
				}';
			}
		}

		if ( pen_sidebar_check( 'sidebar-top', $content_id ) ) {

			$widget_title_top_font              = esc_html( pen_option_get( 'font_family_widget_title_top' ) );
			$widget_title_top_font_size         = esc_html( pen_option_get( 'font_size_widget_title_top' ) );
			$widget_title_top_font_size_default = pen_option_default( 'font_size_widget_title_top' );

			if ( 'default' !== $widget_title_top_font || $widget_title_top_font_size !== $widget_title_top_font_size_default ) {
				$css .= '#pen_top .widget-title {';
				if ( 'default' !== $widget_title_top_font ) {
					$css .= 'font-family:"' . ltrim( $widget_title_top_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;';
				}
				if ( $widget_title_top_font_size !== $widget_title_top_font_size_default ) {
					$css .= 'font-size:' . $widget_title_top_font_size . ';';
				}
				$css .= '}';
			}
		}

		if ( pen_sidebar_check( 'sidebar-left', $content_id ) ) {

			$widget_title_left_font              = esc_html( pen_option_get( 'font_family_widget_title_left' ) );
			$widget_title_left_font_size         = esc_html( pen_option_get( 'font_size_widget_title_left' ) );
			$widget_title_left_font_size_default = pen_option_default( 'font_size_widget_title_left' );

			if ( 'default' !== $widget_title_left_font || $widget_title_left_font_size !== $widget_title_left_font_size_default ) {
				$css .= '#pen_left .widget-title {';
				if ( 'default' !== $widget_title_left_font ) {
					$css .= 'font-family:"' . ltrim( $widget_title_left_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;';
				}
				if ( $widget_title_left_font_size !== $widget_title_left_font_size_default ) {
					$css .= 'font-size:' . $widget_title_left_font_size . ';';
				}
				$css .= '}';
			}
		}

		if ( pen_sidebar_check( 'sidebar-right', $content_id ) ) {

			$widget_title_right_font              = esc_html( pen_option_get( 'font_family_widget_title_right' ) );
			$widget_title_right_font_size         = esc_html( pen_option_get( 'font_size_widget_title_right' ) );
			$widget_title_right_font_size_default = pen_option_default( 'font_size_widget_title_right' );

			if ( 'default' !== $widget_title_right_font || $widget_title_right_font_size !== $widget_title_right_font_size_default ) {
				$css .= '#pen_right .widget-title {';
				if ( 'default' !== $widget_title_right_font ) {
					$css .= 'font-family:"' . ltrim( $widget_title_right_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;';
				}
				if ( $widget_title_right_font_size !== $widget_title_right_font_size_default ) {
					$css .= 'font-size:' . $widget_title_right_font_size . ';';
				}
				$css .= '}';
			}
		}

		$css = pen_compress_css( $css );

		wp_add_inline_style( 'pen-css', $css );
	}
	add_action( 'wp_enqueue_scripts', 'pen_inline_css_general' );
}

if ( ! function_exists( 'pen_inline_css_header' ) ) {
	/**
	 * Adds inline CSS for the header.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_inline_css_header() {
		$css                      = '';
		$preset_color             = esc_html( pen_preset_get( 'color' ) );
		$background_left          = esc_html( pen_option_get( 'color_header_background_primary' ) );
		$background_left_default  = pen_option_default( 'color_header_background_primary' );
		$background_right         = esc_html( pen_option_get( 'color_header_background_secondary' ) );
		$background_right_default = pen_option_default( 'color_header_background_secondary' );
		$header_image             = get_header_image();

		$angle         = esc_html( pen_option_get( 'color_header_background_angle' ) );
		$angle_default = pen_option_default( 'color_header_background_angle' );
		if ( 'to right' === $angle ) {
			$angle_ie = 'left';
		} elseif ( 'to bottom' === $angle ) {
			$angle_ie = 'top';
		} elseif ( false !== strpos( $angle, 'deg' ) ) {
			$angle_ie = ( str_replace( 'deg', '', $angle ) + 90 ) . 'deg';
		}

		if ( 'preset_1' !== $preset_color || $background_left !== $background_left_default || $background_right !== $background_right_default || $header_image || $angle !== $angle_default ) {
			$css .= '#pen_header .pen_header_inner {
				background-color:' . $background_left . ';
				background:' . $background_left . ';';
			if ( $background_left !== $background_right ) {
				$css .= 'background:-ms-linear-gradient(' . $angle_ie . ',' . $background_left . ' 0%,' . $background_right . ' 100%);
				background:linear-gradient(' . $angle . ',' . $background_left . ' 0%,' . $background_right . ' 100%);';
			}
			if ( $header_image ) {
				$css .= "background-image:url('" . $header_image . "');
				background-repeat:no-repeat;
				background-position:top center;
				background-size:cover;";
			}
			$css .= '}';
		}

		$text_color         = esc_html( pen_option_get( 'color_header_text' ) );
		$text_color_default = pen_option_default( 'color_header_text' );

		if ( 'preset_1' !== $preset_color || $text_color !== $text_color_default ) {
			$css .= '#pen_header .pen_header_main {
				color:' . $text_color . ';
			}';
		}

		if ( ! pen_option_get( 'color_header_text_shadow_display' ) ) {
			$text_shadow = 'none';
		} else {
			$text_shadow = '1px 1px 1px ' . esc_html( pen_option_get( 'color_header_text_shadow' ) );
		}
		if ( 'preset_1' !== $preset_color || '1px 1px 1px ' . pen_option_default( 'color_header_text_shadow' ) !== $text_shadow ) {
			$css .= 'body.pen_drop_shadow #pen_header .pen_header_inner .pen_header_main {
				text-shadow:' . $text_shadow . ';
			}';
		}

		$link_color               = esc_html( pen_option_get( 'color_header_link' ) );
		$link_color_default       = pen_option_default( 'color_header_link' );
		$link_color_hover         = esc_html( pen_option_get( 'color_header_link_hover' ) );
		$link_color_hover_default = pen_option_default( 'color_header_link_hover' );
		if ( 'preset_1' !== $preset_color || $link_color !== $link_color_default ) {
			$css .= '#pen_header .pen_header_main a {
				color:' . $link_color . ';
			}';
		}
		if ( 'preset_1' !== $preset_color || $link_color_hover !== $link_color_hover_default ) {
			$css .= '#pen_header .pen_header_main a:focus,
			#pen_header .pen_header_main a:hover,
			#pen_header .pen_header_main a:active,
			#pen_header .pen_social_networks a:focus,
			#pen_header .pen_social_networks a:hover,
			#pen_header .pen_social_networks a:active {
				color:' . $link_color_hover . ';
			}';
		}

		$sitetitle_color               = esc_html( pen_option_get( 'color_header_sitetitle' ) );
		$sitetitle_color_default       = pen_option_default( 'color_header_sitetitle' );
		$sitetitle_color_hover         = esc_html( pen_option_get( 'color_header_sitetitle_hover' ) );
		$sitetitle_color_hover_default = pen_option_default( 'color_header_sitetitle_hover' );
		$sitetitle_font                = esc_html( pen_option_get( 'font_family_sitetitle' ) );
		$sitetitle_size                = esc_html( pen_option_get( 'font_size_sitetitle' ) );
		$sitetitle_size_default        = pen_option_default( 'font_size_sitetitle' );

		if ( 'preset_1' !== $preset_color || $sitetitle_color !== $sitetitle_color_default || $link_color !== $link_color_default // || because $link_color may affect the sitetitle_color.
			|| 'default' !== $sitetitle_font || $sitetitle_size !== $sitetitle_size_default ) {
			$css .= '#pen_header h1 a span.site-title {';
			if ( 'preset_1' !== $preset_color || $sitetitle_color !== $sitetitle_color_default || $link_color !== $link_color_default ) {
				$css .= 'color:' . $sitetitle_color . ';';
			}
			if ( 'default' !== $sitetitle_font ) {
				$css .= 'font-family:"' . ltrim( $sitetitle_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;';
			}
			if ( $sitetitle_size !== $sitetitle_size_default ) {
				$css .= 'font-size:' . $sitetitle_size . ';';
			}
			$css .= '}';
		}
		if ( 'preset_1' !== $preset_color || $sitetitle_color_hover !== $sitetitle_color_hover_default || $link_color_hover !== $link_color_hover_default ) {
			$css .= '#pen_header h1 a:focus .site-title,
			#pen_header h1 a:hover .site-title,
			#pen_header h1 a:active .site-title {
				color:' . $sitetitle_color_hover . ';
			}';
		}

		$sitedescription_color               = esc_html( pen_option_get( 'color_header_sitedescription' ) );
		$sitedescription_color_default       = pen_option_default( 'color_header_sitedescription' );
		$sitedescription_color_hover         = esc_html( pen_option_get( 'color_header_sitedescription_hover' ) );
		$sitedescription_color_hover_default = pen_option_default( 'color_header_sitedescription_hover' );
		$sitedescription_font                = esc_html( pen_option_get( 'font_family_sitedescription' ) );
		$sitedescription_size                = esc_html( pen_option_get( 'font_size_sitedescription' ) );
		$sitedescription_size_default        = pen_option_default( 'font_size_sitedescription' );

		if ( 'preset_1' !== $preset_color || $sitedescription_color !== $sitedescription_color_default || $link_color !== $link_color_default || 'default' !== $sitedescription_font || $sitedescription_size !== $sitedescription_size_default ) {
			$css .= '#pen_header h1 a .site-description {';
			if ( 'preset_1' !== $preset_color || $sitedescription_color !== $sitedescription_color_default || $link_color !== $link_color_default ) {
				$css .= 'color:' . $sitedescription_color . ';';
			}
			if ( 'default' !== $sitedescription_font ) {
				$css .= 'font-family:"' . ltrim( $sitedescription_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;';
			}
			if ( $sitedescription_size !== $sitedescription_size_default ) {
				$css .= 'font-size:' . $sitedescription_size . ';';
			}
			$css .= '}';
		}
		if ( 'preset_1' !== $preset_color || $sitedescription_color_hover !== $sitedescription_color_hover_default || $link_color_hover !== $link_color_hover_default ) {
			$css .= '#pen_header h1 a:focus .site-description,
			#pen_header h1 a:hover .site-description,
			#pen_header h1 a:active .site-description {
				color:' . $sitedescription_color_hover . ';
			}';
		}

		$social_links_size         = esc_html( pen_option_get( 'font_size_social_header' ) );
		$social_links_size_default = pen_option_default( 'font_size_social_header' );
		if ( $social_links_size !== $social_links_size_default ) {
			$css .= '#pen_header .pen_social_networks li {
				font-size:' . $social_links_size . ';
			}';
		}

		if ( pen_option_get( 'phone' ) && pen_option_get( 'phone_header_display' ) ) {

			$phone_color               = esc_html( pen_option_get( 'color_header_phone' ) );
			$phone_color_default       = pen_option_default( 'color_header_phone' );
			$phone_color_hover         = esc_html( pen_option_get( 'color_header_phone_hover' ) );
			$phone_color_hover_default = pen_option_default( 'color_header_phone_hover' );

			if ( 'preset_1' !== $preset_color || $phone_color !== $phone_color_default ) {
				$css .= '#pen_header .pen_header_main .pen_phone a {';
				if ( 'preset_1' !== $preset_color || $phone_color !== $phone_color_default ) {
					$css .= 'color:' . $phone_color . ';';
				}
				$css .= '}';
			}
			if ( 'preset_1' !== $preset_color || $phone_color_hover !== $phone_color_hover_default ) {
				$css .= '#pen_header .pen_header_main .pen_phone a:focus,
				#pen_header .pen_header_main .pen_phone a:hover,
				#pen_header .pen_header_main .pen_phone a:active {
					color:' . $phone_color_hover . ' !important;
				}';
			}

			$phone_font         = esc_html( pen_option_get( 'font_family_phone_header' ) );
			$phone_size         = esc_html( pen_option_get( 'font_size_phone_header' ) );
			$phone_size_default = pen_option_default( 'font_size_phone_header' );

			if ( 'default' !== $phone_font || $phone_size !== $phone_size_default ) {
				$css .= '#pen_header .pen_phone {';
				if ( 'default' !== $phone_font ) {
					$css .= 'font-family:"' . ltrim( $phone_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;';
				}
				if ( $phone_size !== $phone_size_default ) {
					$css .= 'font-size:' . $phone_size . ';';
				}
				$css .= '}';
			}
		}

		$field_background_primary           = esc_html( pen_option_get( 'color_header_field_background_primary' ) );
		$field_background_primary_default   = pen_option_default( 'color_header_field_background_primary' );
		$field_background_secondary         = esc_html( pen_option_get( 'color_header_field_background_secondary' ) );
		$field_background_secondary_default = pen_option_default( 'color_header_field_background_secondary' );
		$field_text                         = esc_html( pen_option_get( 'color_header_field_text' ) );
		$field_text_default                 = pen_option_default( 'color_header_field_text' );

		if ( 'preset_1' !== $preset_color || $field_background_primary !== $field_background_primary_default || $field_background_secondary !== $field_background_secondary_default || $field_text !== $field_text_default ) {
			$css .= '#pen_header .pen_header_main input[type="date"],
			#pen_header .pen_header_main input[type="email"],
			#pen_header .pen_header_main input[type="file"],
			#pen_header .pen_header_main input[type="number"],
			#pen_header .pen_header_main input[type="password"],
			#pen_header .pen_header_main input[type="tel"],
			#pen_header .pen_header_main input[type="time"],
			#pen_header .pen_header_main input[type="text"],
			#pen_header .pen_header_main input[type="url"],
			#pen_header .pen_header_main option,
			#pen_header .pen_header_main select,
			#pen_header .pen_header_main textarea,
			#pen_header .pen_header_main .search-form .search-field {
				background:' . $field_background_secondary . ';';
			if ( $field_background_primary !== $field_background_secondary ) {
				$css .= 'background:-ms-linear-gradient(top,' . $field_background_primary . ' 0%,' . $field_background_secondary . ' 100%);
				background:linear-gradient(to bottom,' . $field_background_primary . ' 0%,' . $field_background_secondary . ' 100%);';
			}
			if ( 'preset_1' !== $preset_color || $field_text !== $field_text_default ) {
				$css .= 'color:' . $field_text . ';';
			}
			$css .= '}';

			if ( 'preset_1' !== $preset_color || $field_text !== $field_text_default ) {
				$placeholder_color = new \Pen_Theme\Color( $field_text );
				$placeholder_color = $placeholder_color->getRgb();
				$placeholder_color = 'rgba(' . implode( ',', $placeholder_color ) . ',0.75)';

				$css .= '#pen_header .pen_header_main input::-webkit-input-placeholder,
					#pen_header .pen_header_main select::-webkit-input-placeholder,
					#pen_header .pen_header_main textarea::-webkit-input-placeholder {
					color: ' . $placeholder_color . ';
				}
				#pen_header .pen_header_main input::-moz-placeholder,
				#pen_header .pen_header_main select::-moz-placeholder,
				#pen_header .pen_header_main textarea::-moz-placeholder {
					color: ' . $placeholder_color . ';
				}
				#pen_header .pen_header_main input:-ms-input-placeholder,
				#pen_header .pen_header_main select:-ms-input-placeholder,
				#pen_header .pen_header_main textarea:-ms-input-placeholder {
					color: ' . $placeholder_color . ';
				}';
			}
		}

		$search_background_top            = esc_html( pen_option_get( 'color_header_search_background_primary' ) );
		$search_background_top_default    = pen_option_default( 'color_header_search_background_primary' );
		$search_background_bottom         = esc_html( pen_option_get( 'color_header_search_background_secondary' ) );
		$search_background_bottom_default = pen_option_default( 'color_header_search_background_secondary' );
		$search_text                      = esc_html( pen_option_get( 'color_header_search_text' ) );
		$search_text_default              = pen_option_default( 'color_header_search_text' );

		$background_dark   = false;
		$search_text_check = new \Pen_Theme\Color( $search_text );
		if ( $search_text_check->isDark() ) {
			$background_dark = true;
		}

		if ( 'preset_1' !== $preset_color || $search_background_top !== $search_background_top_default || $search_background_bottom !== $search_background_bottom_default || $search_text !== $search_text_default || $background_dark ) {
			$css .= '#pen_header .pen_header_main .search-form .search-submit {
				background-color:' . $search_background_bottom . ';
				background:' . $search_background_bottom . ';';
			if ( $search_background_top !== $search_background_bottom ) {
				$css .= 'background:-ms-linear-gradient(top,' . $search_background_top . ' 0%,' . $search_background_bottom . ' 100%);
				background:linear-gradient(to bottom,' . $search_background_top . ' 0%,' . $search_background_bottom . ' 100%);';
			}
			if ( 'preset_1' !== $preset_color || $search_text !== $search_text_default ) {
				$css .= 'color:' . $search_text . ';';
			}
			$css .= '}';
			if ( $background_dark ) {
				$css .= 'body.pen_drop_shadow #pen_header .pen_header_main .search-form .search-submit {
					text-shadow:1px 1px 2px rgba(255,255,255,0.5);
				}';
			}
			$css .= 'body.pen_drop_shadow #pen_header .pen_header_main input[type="date"]:focus,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="date"]:active,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="email"]:focus,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="email"]:active,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="file"]:focus,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="file"]:active,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="number"]:focus,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="number"]:active,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="password"]:focus,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="password"]:active,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="tel"]:focus,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="tel"]:active,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="time"]:focus,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="time"]:active,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="text"]:focus,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="text"]:active,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="url"]:focus,
			body.pen_drop_shadow #pen_header .pen_header_main input[type="url"]:active,
			body.pen_drop_shadow #pen_header .pen_header_main option:focus,
			body.pen_drop_shadow #pen_header .pen_header_main option:active,
			body.pen_drop_shadow #pen_header .pen_header_main select:focus,
			body.pen_drop_shadow #pen_header .pen_header_main select:active,
			body.pen_drop_shadow #pen_header .pen_header_main textarea:focus,
			body.pen_drop_shadow #pen_header .pen_header_main textarea:active,
			body.pen_drop_shadow #pen_header .pen_header_main .search-form .search-field:focus,
			body.pen_drop_shadow #pen_header .pen_header_main .search-form .search-field:active {
				box-shadow:2px 2px 2px rgba(0,0,0,0.2) inset, 0 0 7px ' . $search_background_bottom . ';
			}
			#pen_header .pen_header_main .search-form .search-submit:focus,
			#pen_header .pen_header_main .search-form .search-submit:active {
				background:' . $search_background_bottom . ';
			}';
		}

		$button_users_background_top            = esc_html( pen_option_get( 'color_header_button_users_background_primary' ) );
		$button_users_background_top_default    = pen_option_default( 'color_header_button_users_background_primary' );
		$button_users_background_bottom         = esc_html( pen_option_get( 'color_header_button_users_background_secondary' ) );
		$button_users_background_bottom_default = pen_option_default( 'color_header_button_users_background_secondary' );
		$button_users_text                      = esc_html( pen_option_get( 'color_header_button_users_text' ) );
		$button_users_text_default              = pen_option_default( 'color_header_button_users_text' );

		$background_dark         = false;
		$button_users_text_check = new \Pen_Theme\Color( $button_users_text );
		if ( $button_users_text_check->isDark() ) {
			$background_dark = true;
		}

		if ( 'preset_1' !== $preset_color || $button_users_background_top !== $button_users_background_top_default || $button_users_background_bottom !== $button_users_background_bottom_default || $button_users_text !== $button_users_text_default || $background_dark ) {
			$css .= '#pen_header .pen_header_main .pen_button_users .pen_button,
			#pen_header .pen_header_main .pen_button_users .pen_button:focus,
			#pen_header .pen_header_main .pen_button_users .pen_button:hover {
				background-color:' . $button_users_background_bottom . ' !important;
				background:' . $button_users_background_bottom . ' !important;';
			if ( $button_users_background_top !== $button_users_background_bottom ) {
				$css .= 'background:-ms-linear-gradient(top,' . $button_users_background_top . ' 0%,' . $button_users_background_bottom . ' 100%) !important;
				background:linear-gradient(to bottom,' . $button_users_background_top . ' 0%,' . $button_users_background_bottom . ' 100%) !important;';
			}
			if ( 'preset_1' !== $preset_color || $button_users_text !== $button_users_text_default ) {
				$css .= 'border:1px solid ' . $button_users_background_bottom . ' !important;
				color:' . $button_users_text . ' !important;';
			}
			$css .= '}';
			if ( $background_dark ) {
				$css .= 'body.pen_drop_shadow #pen_header .pen_header_main .pen_button_users .pen_button {
					text-shadow:1px 1px 2px rgba(255,255,255,0.5) !important;
				}';
			}
			$css .= 'body.pen_drop_shadow #pen_header .pen_header_main .pen_button_users .pen_button:focus,
			body.pen_drop_shadow #pen_header .pen_header_main .pen_button_users .pen_button:active,
			body.pen_drop_shadow #pen_header .pen_header_main .pen_button_users .pen_button.pen_active {
				box-shadow:2px 2px 2px rgba(0,0,0,0.2) inset, 0 0 7px ' . $button_users_background_bottom . ' !important;
			}
			#pen_header .pen_header_main .pen_button_users .pen_button:focus,
			#pen_header .pen_header_main .pen_button_users .pen_button:active,
			#pen_header .pen_header_main .pen_button_users .pen_button.pen_active {
				background:' . $button_users_background_bottom . ' !important;
			}';
		}

		$css = pen_compress_css( $css );

		wp_add_inline_style( 'pen-css', $css );
	}
	add_action( 'wp_enqueue_scripts', 'pen_inline_css_header' );
}

if ( ! function_exists( 'pen_inline_css_navigation' ) ) {
	/**
	 * Adds inline CSS for the main navigation menu.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_inline_css_navigation() {
		$css = '';

		if ( pen_option_get( 'navigation_display' ) ) {

			$preset_color = esc_html( pen_preset_get( 'color' ) );

			$background_left          = esc_html( pen_option_get( 'color_navigation_background_primary' ) );
			$background_left_default  = pen_option_default( 'color_navigation_background_primary' );
			$background_right         = esc_html( pen_option_get( 'color_navigation_background_secondary' ) );
			$background_right_default = pen_option_default( 'color_navigation_background_secondary' );
			$background_image         = esc_html( pen_option_get( 'background_image_navigation' ) );

			$angle         = esc_html( pen_option_get( 'color_navigation_background_angle' ) );
			$angle_default = pen_option_default( 'color_navigation_background_angle' );
			if ( 'to right' === $angle ) {
				$angle_ie = 'left';
			} elseif ( 'to bottom' === $angle ) {
				$angle_ie = 'top';
			} elseif ( false !== strpos( $angle, 'deg' ) ) {
				$angle_ie = ( str_replace( 'deg', '', $angle ) + 90 ) . 'deg';
			}

			if ( 'preset_1' !== $preset_color || $background_left !== $background_left_default || $background_right !== $background_right_default || $background_image || $angle !== $angle_default ) {
				$css .= '#pen_navigation,
				#pen_navigation_mobile {
					background-color:' . $background_left . ';
					background:' . $background_left . ';';
				if ( $background_left !== $background_right ) {
					$css .= 'background:-ms-linear-gradient(' . $angle_ie . ',' . $background_left . ' 0%,' . $background_right . ' 100%);
					background:linear-gradient(' . $angle . ',' . $background_left . ' 0%,' . $background_right . ' 100%);';
				}
				if ( $background_image ) {
					$css .= "background-image:url('" . $background_image . "');
					background-repeat:no-repeat;
					background-position:top center;
					background-size:cover;";
				}
				$css .= '}';
			}

			$background_submenu_left          = esc_html( pen_option_get( 'color_navigation_background_submenu_primary' ) );
			$background_submenu_left_default  = pen_option_default( 'color_navigation_background_submenu_primary' );
			$background_submenu_right         = esc_html( pen_option_get( 'color_navigation_background_submenu_secondary' ) );
			$background_submenu_right_default = pen_option_default( 'color_navigation_background_submenu_secondary' );
			$background_submenu_image         = esc_html( pen_option_get( 'background_image_navigation_submenu' ) );

			$angle         = esc_html( pen_option_get( 'color_navigation_background_submenu_angle' ) );
			$angle_default = pen_option_default( 'color_navigation_background_submenu_angle' );
			if ( 'to right' === $angle ) {
				$angle_ie = 'left';
			} elseif ( 'to bottom' === $angle ) {
				$angle_ie = 'top';
			} elseif ( false !== strpos( $angle, 'deg' ) ) {
				$angle_ie = ( str_replace( 'deg', '', $angle ) + 90 ) . 'deg';
			}

			if ( 'preset_1' !== $preset_color || $background_submenu_left !== $background_submenu_left_default || $background_submenu_right !== $background_submenu_right_default || $background_submenu_image || $angle !== $angle_default ) {
				$css .= '#pen_navigation ul ul,
				#pen_navigation_mobile ul ul {
					background-color:' . $background_submenu_left . ';
					background:' . $background_submenu_left . ';';
				if ( $background_submenu_left !== $background_submenu_right ) {
					$css .= 'background:-ms-linear-gradient(' . $angle_ie . ',' . $background_submenu_left . ' 0%,' . $background_submenu_right . ' 100%);
					background:linear-gradient(' . $angle . ',' . $background_submenu_left . ' 0%,' . $background_submenu_right . ' 100%);';
				}
				if ( $background_submenu_image ) {
					$css .= "background-image:url('" . $background_submenu_image . "');
					background-repeat:no-repeat;
					background-position:top center;
					background-size:cover;";
				}
				$css .= '}';
			}

			$link_color               = esc_html( pen_option_get( 'color_navigation_link' ) );
			$link_color_default       = pen_option_default( 'color_navigation_link' );
			$link_color_hover         = esc_html( pen_option_get( 'color_navigation_link_hover' ) );
			$link_color_hover_default = pen_option_default( 'color_navigation_link_hover' );
			$navigation_font          = esc_html( pen_option_get( 'font_family_navigation' ) );
			$navigation_size          = esc_html( pen_option_get( 'font_size_navigation' ) );
			$navigation_size_default  = pen_option_default( 'font_size_navigation' );

			if ( 'preset_1' !== $preset_color || $link_color !== $link_color_default || 'default' !== $navigation_font || $navigation_size !== $navigation_size_default ) {
				$css .= '#pen_navigation a,
				#pen_navigation_mobile ul a {';
				if ( 'preset_1' !== $preset_color || $link_color !== $link_color_default ) {
					$css .= 'color:' . $link_color . ';';
				}
				if ( 'default' !== $navigation_font ) {
					$css .= 'font-family:"' . ltrim( $navigation_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;';
				}
				if ( $navigation_size !== $navigation_size_default ) {
					$css .= 'font-size:' . $navigation_size . ';';
				}
				$css .= '}';

				if ( ! pen_option_get( 'color_navigation_text_shadow_display' ) ) {
					$text_shadow = 'none';
				} else {
					$text_shadow = '1px 1px 1px ' . esc_html( pen_option_get( 'color_navigation_text_shadow' ) );
				}
				if ( 'preset_1' !== $preset_color || '1px 1px 1px ' . pen_option_default( 'color_navigation_text_shadow' ) !== $text_shadow ) {
					$css .= 'body.pen_drop_shadow #pen_navigation a,
					body.pen_drop_shadow #pen_navigation_mobile ul a {
						text-shadow:' . $text_shadow . ';
					}';
				}

				$separator = esc_html( pen_option_get( 'navigation_separator' ) );
				if ( 'preset_1' !== $preset_color && $separator ) {
					if ( in_array( $separator, array( 1, 2, 3 ), true ) ) {
						$css .= '#pen_navigation.pen_separator_' . $separator . ' div#primary-menu > ul > li:after,
						#pen_navigation.pen_separator_' . $separator . ' ul#primary-menu > li:after {
							background:-ms-linear-gradient(270deg, rgba(0,0,0,0) 0%, ' . $link_color . ' 50%, rgba(0,0,0,0) 100%);
							background:linear-gradient(180deg, rgba(0,0,0,0) 0%, ' . $link_color . ' 50%, rgba(0,0,0,0) 100%);
						}';
					} elseif ( in_array( $separator, array( 4, 5, 7 ), true ) ) {
						$css .= '#pen_navigation.pen_separator_' . $separator . ' div#primary-menu > ul > li:after,
						#pen_navigation.pen_separator_' . $separator . ' ul#primary-menu > li:after {
							background:' . $link_color . ';
						}';
					} elseif ( 6 === $separator ) {
						$css .= '#pen_navigation.pen_separator_' . $separator . ' div#primary-menu > ul > li:before,
						#pen_navigation.pen_separator_' . $separator . ' ul#primary-menu > li:before,
						#pen_navigation.pen_separator_' . $separator . ' div#primary-menu > ul > li:after,
						#pen_navigation.pen_separator_' . $separator . ' ul#primary-menu > li:after {
							background:' . $link_color . ';
						}';
					} elseif ( in_array( $separator, array( 8, 9 ), true ) ) {
						$css .= '#pen_navigation.pen_separator_' . $separator . ' div#primary-menu > ul > li:after,
						#pen_navigation.pen_separator_' . $separator . ' ul#primary-menu > li:after {
							border-color:' . $link_color . ';
						}';
					} elseif ( 10 === $separator ) {
						$css .= '#pen_navigation.pen_separator_' . $separator . ' div#primary-menu > ul > li:after,
						#pen_navigation.pen_separator_' . $separator . ' ul#primary-menu > li:after {
							color:' . $link_color . ';
						}';
					}
				}

				$hover = esc_html( pen_option_get( 'navigation_hover' ) );
				if ( 'preset_1' !== $preset_color && $hover ) {
					if ( 1 === $hover || 2 === $hover ) {
						$link_color_check = new \Pen_Theme\Color( $link_color );
						if ( $link_color_check->isDark() ) {
							$css .= '#pen_navigation.pen_hover_' . $hover . ' div#primary-menu > ul > li.sfHover > a,
								#pen_navigation.pen_hover_' . $hover . ' div#primary-menu > ul > li > a:focus,
								#pen_navigation.pen_hover_' . $hover . ' div#primary-menu > ul > li > a:hover,
								#pen_navigation.pen_hover_' . $hover . ' div#primary-menu > ul > li > a:active,
								#pen_navigation.pen_hover_' . $hover . ' div#primary-menu > ul > li.current-menu-item > a,
								#pen_navigation.pen_hover_' . $hover . ' ul#primary-menu > li.sfHover > a,
								#pen_navigation.pen_hover_' . $hover . ' ul#primary-menu > li > a:focus,
								#pen_navigation.pen_hover_' . $hover . ' ul#primary-menu > li > a:hover,
								#pen_navigation.pen_hover_' . $hover . ' ul#primary-menu > li > a:active,
								#pen_navigation.pen_hover_' . $hover . ' ul#primary-menu > li.current-menu-item > a {';
							if ( 'preset_15' === $preset_color ) {
								$css .= 'background:rgba(255,255,255,0.2);';
							} else {
								$css .= 'background:rgba(255,255,255,0.3);';
							}
							$css .= '}';
						}
					} elseif ( in_array( $hover, array( 3, 4, 5, 6, 7, 10 ), true ) ) {
						$css .= '#pen_navigation.pen_hover_' . $hover . ' div#primary-menu > ul > li > a:after,
						#pen_navigation.pen_hover_' . $hover . ' ul#primary-menu > li > a:after {
							background:' . $link_color . ';
						}';
					} elseif ( 8 === $hover ) {
						$css .= '#pen_navigation.pen_hover_' . $hover . ' div#primary-menu > ul > li > a:after,
						#pen_navigation.pen_hover_' . $hover . ' ul#primary-menu > li > a:after {
							border-top-color:' . $link_color . ';
						}';
					} elseif ( 9 === $hover ) {
						$css .= '#pen_navigation.pen_hover_' . $hover . ' div#primary-menu > ul > li > a:after,
						#pen_navigation.pen_hover_' . $hover . ' ul#primary-menu > li > a:after {
							border-bottom-color:' . $link_color . ';
						}';
					}
				}
			}

			if ( 'preset_1' !== $preset_color || $link_color_hover !== $link_color_hover_default ) {
				$css .= '#pen_navigation li.sfHover > a,
				#pen_navigation a:focus,
				#pen_navigation a:hover,
				#pen_navigation a:active,
				#pen_navigation_mobile ul a:focus,
				#pen_navigation_mobile ul a:hover,
				#pen_navigation_mobile ul a:active,
				#pen_navigation_mobile ul li.pen_active a {
					color:' . $link_color_hover . ';
				}';
			}

			$link_color_submenu               = esc_html( pen_option_get( 'color_navigation_link_submenu' ) );
			$link_color_submenu_default       = pen_option_default( 'color_navigation_link_submenu' );
			$link_color_hover_submenu         = esc_html( pen_option_get( 'color_navigation_link_hover_submenu' ) );
			$link_color_hover_submenu_default = pen_option_default( 'color_navigation_link_hover_submenu' );

			$navigation_submenu_font = esc_html( pen_option_get( 'font_family_navigation_submenu' ) );

			if ( 'preset_1' !== $preset_color || $link_color_submenu !== $link_color_submenu_default || 'default' !== $navigation_submenu_font || $navigation_size !== $navigation_size_default ) {
				$css .= '#pen_navigation li li a,
				#pen_navigation_mobile li li a {';
				if ( 'preset_1' !== $preset_color || $link_color_submenu !== $link_color_submenu_default ) {
					$css .= 'color:' . $link_color_submenu . ';';
				}
				if ( 'default' !== $navigation_submenu_font ) {
					$css .= 'font-family:"' . ltrim( $navigation_submenu_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;';
				}
				if ( $navigation_size !== $navigation_size_default ) {
					$css .= 'font-size:' . $navigation_size . ';';
				}
				$css .= '}';

				if ( ! pen_option_get( 'color_navigation_text_shadow_display_submenu' ) ) {
					$text_shadow_submenu = 'none';
				} else {
					$text_shadow_submenu = '1px 1px 1px ' . esc_html( pen_option_get( 'color_navigation_text_shadow_submenu' ) );
				}
				if ( 'preset_1' !== $preset_color || '1px 1px 1px ' . pen_option_default( 'color_navigation_text_shadow_submenu' ) !== $text_shadow_submenu ) {
					$css .= 'body.pen_drop_shadow #pen_navigation li li a,
					body.pen_drop_shadow #pen_navigation_mobile li li a {
						text-shadow:' . $text_shadow_submenu . ';
					}';
				}

				$separator = esc_html( pen_option_get( 'navigation_separator_submenu' ) );
				if ( 'preset_1' !== $preset_color && $separator ) {
					if ( 1 === $separator ) {
						$css .= '#pen_navigation.pen_separator_submenu_' . $separator . ' li li:after,
						#pen_navigation_mobile nav.pen_separator_submenu_' . $separator . ' li:after {
							background:-ms-linear-gradient(180deg,rgba(0,0,0,0) 0%, ' . $link_color_submenu . ' 25%,rgba(0,0,0,0) 100%);
							background:linear-gradient(90deg,rgba(0,0,0,0) 0%, ' . $link_color_submenu . ' 25%,rgba(0,0,0,0) 100%);
						}';
					} elseif ( 2 === $separator ) {
						$css .= '#pen_navigation.pen_separator_submenu_' . $separator . ' li li:after,
						#pen_navigation_mobile nav.pen_separator_submenu_' . $separator . ' li:after {
							background:-ms-linear-gradient(180deg,rgba(0,0,0,0) 0%, ' . $link_color_submenu . ' 50%,rgba(0,0,0,0) 100%);
							background:linear-gradient(90deg,rgba(0,0,0,0) 0%, ' . $link_color_submenu . ' 50%,rgba(0,0,0,0) 100%);
						}';
					} elseif ( 3 === $separator ) {
						$css .= '#pen_navigation.pen_separator_submenu_' . $separator . ' li li:after,
						#pen_navigation_mobile nav.pen_separator_submenu_' . $separator . ' li:after {
							background:-ms-linear-gradient(180deg,rgba(0,0,0,0) 0%, ' . $link_color_submenu . ' 75%,rgba(0,0,0,0) 100%);
							background:linear-gradient(90deg,rgba(0,0,0,0) 0%, ' . $link_color_submenu . ' 75%,rgba(0,0,0,0) 100%);
						}';
					} elseif ( in_array( $separator, array( 4, 5, 7 ), true ) ) {
						$css .= '#pen_navigation.pen_separator_submenu_' . $separator . ' li li:after,
						#pen_navigation_mobile nav.pen_separator_submenu_' . $separator . ' li:after {
							background:' . $link_color_submenu . ';
						}';
					} elseif ( 6 === $separator ) {
						$css .= '#pen_navigation.pen_separator_submenu_' . $separator . ' li li:before,
						#pen_navigation.pen_separator_submenu_' . $separator . ' li li:after,
						#pen_navigation_mobile nav.pen_separator_submenu_' . $separator . ' li:before,
						#pen_navigation_mobile nav.pen_separator_submenu_' . $separator . ' li:after {
							background:' . $link_color_submenu . ';
						}';
					} elseif ( in_array( $separator, array( 8, 9 ), true ) ) {
						$css .= '#pen_navigation.pen_separator_submenu_' . $separator . ' li li:after,
						#pen_navigation_mobile nav.pen_separator_submenu_' . $separator . ' li:after {
							border-color:' . $link_color . ';
						}';
					} elseif ( 10 === $separator ) {
						$css .= '#pen_navigation.pen_separator_submenu_' . $separator . ' li li:after,
						#pen_navigation_mobile nav.pen_separator_submenu_' . $separator . ' li:after {
							color:' . $link_color . ';
						}';
					}
				}
			}
			if ( 'preset_1' !== $preset_color || $link_color_hover_submenu !== $link_color_hover_submenu_default ) {
				$css .= '#pen_navigation li li.sfHover > a,
				#pen_navigation li li a:focus,
				#pen_navigation li li a:hover,
				#pen_navigation li li a:active,
				#pen_navigation_mobile li li a:focus,
				#pen_navigation_mobile li li a:hover,
				#pen_navigation_mobile li li a:active,
				#pen_navigation_mobile li li.pen_active > a {
					color:' . $link_color_hover_submenu . ';
				}';
			}
			$css = pen_compress_css( $css );
		}

		wp_add_inline_style( 'pen-css', $css );
	}
	add_action( 'wp_enqueue_scripts', 'pen_inline_css_navigation' );
}

if ( ! function_exists( 'pen_inline_css_search' ) ) {
	/**
	 * Adds inline CSS for the search bar.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_inline_css_search() {

		$content_id = pen_post_id();

		$css = '';

		$search_location = get_post_meta( $content_id, 'pen_content_search_location_override', true );
		if ( ! $search_location || 'default' === $search_location ) {
			$search_location = esc_html( pen_option_get( 'search_location' ) );
		}
		$search = pen_html_search_box( $content_id );
		if ( $search && 'content' === $search_location ) {

			$preset_color                       = esc_html( pen_preset_get( 'color' ) );
			$field_background_primary           = esc_html( pen_option_get( 'color_search_field_background_primary' ) );
			$field_background_primary_default   = pen_option_default( 'color_search_field_background_primary' );
			$field_background_secondary         = esc_html( pen_option_get( 'color_search_field_background_secondary' ) );
			$field_background_secondary_default = pen_option_default( 'color_search_field_background_secondary' );
			$field_text                         = esc_html( pen_option_get( 'color_search_field_text' ) );
			$field_text_default                 = pen_option_default( 'color_search_field_text' );

			if ( 'preset_1' !== $preset_color || $field_background_primary !== $field_background_primary_default || $field_background_secondary !== $field_background_secondary_default || $field_text !== $field_text_default ) {
				$css .= '#pen_search .search-form .search-field {
					background:' . $field_background_secondary . ';';
				if ( $field_background_primary !== $field_background_secondary ) {
					$css .= 'background:-ms-linear-gradient(top,' . $field_background_primary . ' 0%,' . $field_background_secondary . ' 100%);
					background:linear-gradient(to bottom,' . $field_background_primary . ' 0%,' . $field_background_secondary . ' 100%);';
				}
				if ( 'preset_1' !== $preset_color || $field_text !== $field_text_default ) {
					$css .= 'color:' . $field_text . ';';
				}
				$css .= '}';
			}

			$background_left          = esc_html( pen_option_get( 'color_search_background_primary' ) );
			$background_left_default  = pen_option_default( 'color_search_background_primary' );
			$background_right         = esc_html( pen_option_get( 'color_search_background_secondary' ) );
			$background_right_default = pen_option_default( 'color_search_background_secondary' );
			$background_image         = esc_html( pen_option_get( 'background_image_search' ) );

			$angle         = esc_html( pen_option_get( 'color_search_background_angle' ) );
			$angle_default = pen_option_default( 'color_search_background_angle' );
			if ( 'to right' === $angle ) {
				$angle_ie = 'left';
			} elseif ( 'to bottom' === $angle ) {
				$angle_ie = 'top';
			} elseif ( false !== strpos( $angle, 'deg' ) ) {
				$angle_ie = ( str_replace( 'deg', '', $angle ) + 90 ) . 'deg';
			}

			if ( 'preset_1' !== $preset_color || $background_left !== $background_left_default || $background_right !== $background_right_default || $background_image || $angle !== $angle_default ) {
				$css .= '#pen_search {
					background-color:' . $background_left . ';
					background:' . $background_left . ';';
				if ( $background_left !== $background_right ) {
					$css .= 'background:-ms-linear-gradient(' . $angle_ie . ',' . $background_left . ' 0%,' . $background_right . ' 100%);
					background:linear-gradient(' . $angle . ',' . $background_left . ' 0%,' . $background_right . ' 100%);';
				}
				if ( $background_image ) {
					$css .= "background-image:url('" . $background_image . "');
					background-repeat:no-repeat;
					background-position:top center;
					background-size:cover;";
				}
				$css .= '}';
			}

			$text_color         = esc_html( pen_option_get( 'color_search_text' ) );
			$text_color_default = pen_option_default( 'color_search_text' );
			if ( 'preset_1' !== $preset_color || $text_color !== $text_color_default ) {
				$css .= '#pen_search .widget {
					color:' . $text_color . ';
				}';
			}

			if ( ! pen_option_get( 'color_search_text_shadow_display' ) ) {
				$text_shadow = 'none';
			} else {
				$text_shadow = '1px 1px 1px ' . esc_html( pen_option_get( 'color_search_text_shadow' ) );
			}
			if ( 'preset_1' !== $preset_color || '1px 1px 1px ' . pen_option_default( 'color_search_text_shadow' ) !== $text_shadow ) {
				$css .= 'body.pen_drop_shadow #pen_search .widget {
					text-shadow:' . $text_shadow . ';
				}';
			}

			$link_color               = esc_html( pen_option_get( 'color_search_link' ) );
			$link_color_default       = pen_option_default( 'color_search_link' );
			$link_color_hover         = esc_html( pen_option_get( 'color_search_link_hover' ) );
			$link_color_hover_default = pen_option_default( 'color_search_link_hover' );
			if ( 'preset_1' !== $preset_color || $link_color !== $link_color_default ) {
				$css .= '#pen_search .widget a {
					color:' . $link_color . ';
				}';
			}
			if ( 'preset_1' !== $preset_color || $link_color_hover !== $link_color_hover_default ) {
				$css .= '#pen_search .widget a:focus,
				#pen_search .widget a:hover,
				#pen_search .widget a:active {
					color:' . $link_color_hover . ' !important;
				}';
			}

			$search_background_top            = esc_html( pen_option_get( 'color_search_button_background_primary' ) );
			$search_background_top_default    = pen_option_default( 'color_search_button_background_primary' );
			$search_background_bottom         = esc_html( pen_option_get( 'color_search_button_background_secondary' ) );
			$search_background_bottom_default = pen_option_default( 'color_search_button_background_secondary' );
			$search_text                      = esc_html( pen_option_get( 'color_search_button_text' ) );
			$search_text_default              = pen_option_default( 'color_search_button_text' );

			$background_dark   = false;
			$search_text_check = new \Pen_Theme\Color( $search_text );
			if ( $search_text_check->isDark() ) {
				$background_dark = true;
			}

			if ( 'preset_1' !== $preset_color || $search_background_top !== $search_background_top_default || $search_background_bottom !== $search_background_bottom_default || $search_text !== $search_text_default || $background_dark ) {
				$css .= '#pen_search .search-form .search-submit {
					background:' . $search_background_bottom . ';';
				if ( $search_background_top !== $search_background_bottom ) {
					$css .= 'background:-ms-linear-gradient(top,' . $search_background_top . ' 0%,' . $search_background_bottom . ' 100%) !important;
					background:linear-gradient(to bottom,' . $search_background_top . ' 0%,' . $search_background_bottom . ' 100%) !important;';
				}
				if ( 'preset_1' !== $preset_color || $search_text !== $search_text_default ) {
					$css .= 'color:' . $search_text . ' !important;';
				}
				$css .= '}
				#pen_search .search-form .search-submit:active {
					background:' . $search_background_bottom . ' !important;
				}';
			}

			$css = pen_compress_css( $css );

		}

		wp_add_inline_style( 'pen-css', $css );
	}
	add_action( 'wp_enqueue_scripts', 'pen_inline_css_search' );
}

if ( ! function_exists( 'pen_inline_css_content' ) ) {
	/**
	 * Adds inline CSS for the content area.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_inline_css_content() {

		$content_id      = pen_post_id();
		$pen_is_singular = is_singular();

		$css                      = '';
		$preset_color             = esc_html( pen_preset_get( 'color' ) );
		$background_left          = esc_html( pen_option_get( 'color_content_title_background_primary' ) );
		$background_left_default  = pen_option_default( 'color_content_title_background_primary' );
		$background_right         = esc_html( pen_option_get( 'color_content_title_background_secondary' ) );
		$background_right_default = pen_option_default( 'color_content_title_background_secondary' );
		$background_image         = esc_html( pen_option_get( 'background_image_content_title' ) );
		$angle                    = esc_html( pen_option_get( 'color_content_title_background_angle' ) );
		$angle_default            = pen_option_default( 'color_content_title_background_angle' );
		if ( 'to right' === $angle ) {
			$angle_ie = 'left';
		} elseif ( 'to bottom' === $angle ) {
			$angle_ie = 'top';
		} elseif ( false !== strpos( $angle, 'deg' ) ) {
			$angle_ie = ( str_replace( 'deg', '', $angle ) + 90 ) . 'deg';
		}

		if ( 'preset_1' !== $preset_color || $background_left !== $background_left_default || $background_right !== $background_right_default || $angle !== $angle_default || $background_image ) {
			$css .= '#main .pen_article header {
				background-color:' . $background_left . ';
				background:' . $background_left . ';';
			if ( $background_left !== $background_right ) {
				$css .= 'background:-ms-linear-gradient(' . $angle_ie . ',' . $background_left . ' 0%,' . $background_right . ' 100%);
				background:linear-gradient(' . $angle . ',' . $background_left . ' 0%,' . $background_right . ' 100%);';
			}
			if ( $background_image ) {
				$css .= "background-image:url('" . $background_image . "');
				background-repeat:no-repeat;
				background-position:top center;
				background-size:cover;";
			}
			$css .= '}';
		}

		$text_color         = esc_html( pen_option_get( 'color_content_text' ) );
		$text_color_default = pen_option_default( 'color_content_text' );
		if ( 'preset_1' !== $preset_color || $text_color !== $text_color_default ) {
			$css .= '#main article.pen_article,
			body.pen_multiple #main li.pen_article,
			#main .pen_summary,
			#main .pen_content_footer,
			#main label,
			#comments,
			#comments h3';

			if ( PEN_THEME_HAS_WOOCOMMERCE ) {
				$css .= ',
				body.pen_has_woocommerce #page .woocommerce-notices-wrapper,
				body.pen_has_woocommerce #page div.product .woocommerce-tabs,
				body.pen_has_woocommerce #page div.product .up-sells,
				body.pen_has_woocommerce #page div.product .related';
			}

			$css .= '{color:' . $text_color . '}';

			$view            = $pen_is_singular ? 'content' : 'list';
			$profile_display = get_post_meta( $content_id, 'pen_' . $view . '_profile_display_override', true );
			if ( ! $profile_display || 'default' === $profile_display ) {
				$profile_display = esc_html( pen_option_get( $view . '_profile_display' ) );
			}
			if ( $profile_display ) {
				$css .= '#primary .pen_author_profile:before {
					background: -ms-linear-gradient(180deg, rgba(255,255,255,0) 0%,' . $text_color . ' 50%, rgba(255,255,255,0) 100%);
					background: linear-gradient(90deg, rgba(255,255,255,0) 0%,' . $text_color . ' 50%, rgba(255,255,255,0) 100%);
				}';
			}
		}

		$background_color         = esc_html( pen_option_get( 'color_content_background_primary' ) );
		$background_color_default = pen_option_default( 'color_content_background_primary' );
		if ( 'preset_1' !== $preset_color || $background_color !== $background_color_default ) {
			$css .= '#main article.pen_article,
			body.pen_multiple #main li.pen_article,
			#primary .pen_author_profile .pen_author_avatar,
			#comments,
			#comments ol.comment-list li.comment div.comment-author .photo,
			body.pen_list_plain #pen_pager';

			if ( PEN_THEME_HAS_WOOCOMMERCE ) {
				$css .= ',
				body.pen_has_woocommerce.pen_list_masonry #pen_masonry ul.products li.product,
				body.pen_has_woocommerce.single-product div.product #reviews #comments ol.commentlist li.review .avatar';
			}

			$css .= '{
				background-color:' . $background_color . ';
				background:' . $background_color . ';
			}';
		}

		$link_color               = esc_html( pen_option_get( 'color_content_link' ) );
		$link_color_default       = pen_option_default( 'color_content_link' );
		$link_color_hover         = esc_html( pen_option_get( 'color_content_link_hover' ) );
		$link_color_hover_default = pen_option_default( 'color_content_link_hover' );
		if ( 'preset_1' !== $preset_color || $link_color !== $link_color_default ) {
			$css .= '#primary a {
				color:' . $link_color . ';
			}';
		}
		if ( 'preset_1' !== $preset_color || $link_color_hover !== $link_color_hover_default ) {
			$css .= '#primary a:focus,
			#primary a:hover,
			#primary a:active {
				color:' . $link_color_hover . ';
			}';
		}

		if ( $pen_is_singular ) {
			$title_font         = esc_html( pen_option_get( 'font_family_title_content' ) );
			$title_size         = esc_html( pen_option_get( 'font_size_title_content' ) );
			$title_size_default = pen_option_default( 'font_size_title_content' );
		} else {
			$title_font         = esc_html( pen_option_get( 'font_family_title_list' ) );
			$title_size         = esc_html( pen_option_get( 'font_size_title_list' ) );
			$title_size_default = pen_option_default( 'font_size_title_list' );
		}

		if ( 'preset_1' !== $preset_color || $title_size !== $title_size_default || 'default' !== $title_font ) {
			$css .= '#main header .pen_content_title {';
			if ( 'default' !== $title_font ) {
				$css .= 'font-family:"' . ltrim( $title_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;';
			}
			if ( $title_size !== $title_size_default ) {
				$css .= 'font-size:' . $title_size . ' !important;';
			}
			$css .= '}';
		}

		if ( ! pen_option_get( 'color_content_title_text_shadow_display' ) ) {
			$text_shadow = 'none';
		} else {
			$text_shadow = '1px 1px 1px ' . esc_html( pen_option_get( 'color_content_title_text_shadow' ) );
		}
		if ( 'preset_1' !== $preset_color || '1px 1px 1px ' . pen_option_default( 'color_content_title_text_shadow' ) !== $text_shadow ) {
			$css .= 'body.pen_drop_shadow #main header .pen_content_title {
				text-shadow:' . $text_shadow . ';
			}';
		}

		$title_color         = esc_html( pen_option_get( 'color_content_title_text' ) );
		$title_color_default = pen_option_default( 'color_content_title_text' );

		if ( 'preset_1' !== $preset_color || $title_color !== $title_color_default ) {
			$css .= '#main .pen_article header {
				color:' . $title_color . ';
			}
			#main .pen_article .entry-meta > span:after {
				background: -ms-linear-gradient(270deg, rgba(0,0,0,0) 0%,' . $title_color . ' 50%, rgba(0,0,0,0) 100%);
				background: linear-gradient(180deg, rgba(0,0,0,0) 0%,' . $title_color . ' 50%, rgba(0,0,0,0) 100%);
			}';
		}

		$link_color               = esc_html( pen_option_get( 'color_content_title_link' ) );
		$link_color_default       = pen_option_default( 'color_content_title_link' );
		$link_color_hover         = esc_html( pen_option_get( 'color_content_title_link_hover' ) );
		$link_color_hover_default = pen_option_default( 'color_content_title_link_hover' );
		if ( 'preset_1' !== $preset_color || $link_color !== $link_color_default ) {
			$css .= '#main .pen_article header a {
				color:' . $link_color . ';
			}';
		}
		if ( 'preset_1' !== $preset_color || $link_color_hover !== $link_color_hover_default ) {
			$css .= '#main .pen_article header a:focus,
			#main .pen_article header a:hover,
			#main .pen_article header a:active {
				color:' . $link_color_hover . ';
			}';
		}

		$field_background_primary           = esc_html( pen_option_get( 'color_content_field_background_primary' ) );
		$field_background_primary_default   = pen_option_default( 'color_content_field_background_primary' );
		$field_background_secondary         = esc_html( pen_option_get( 'color_content_field_background_secondary' ) );
		$field_background_secondary_default = pen_option_default( 'color_content_field_background_secondary' );
		$field_text                         = esc_html( pen_option_get( 'color_content_field_text' ) );
		$field_text_default                 = pen_option_default( 'color_content_field_text' );

		if ( 'preset_1' !== $preset_color || $field_background_primary !== $field_background_primary_default || $field_background_secondary !== $field_background_secondary_default || $field_text !== $field_text_default ) {
			$css .= '#page input[type="date"],
			#page input[type="email"],
			#page input[type="file"],
			#page input[type="number"],
			#page input[type="password"],
			#page input[type="tel"],
			#page input[type="time"],
			#page input[type="text"],
			#page input[type="url"],
			#page select,
			#page textarea {
				background:' . $field_background_secondary . ';';
			if ( $field_background_primary !== $field_background_secondary ) {
				$css .= 'background:-ms-linear-gradient(top,' . $field_background_primary . ' 0%,' . $field_background_secondary . ' 100%);
				background:linear-gradient(to bottom,' . $field_background_primary . ' 0%,' . $field_background_secondary . ' 100%);';
			}
			if ( 'preset_1' !== $preset_color || $field_text !== $field_text_default ) {
				$css .= 'color:' . $field_text . ';';
			}
			$css .= '}
			#page option {
				background:' . $field_background_secondary . ';
			}';

			if ( 'preset_1' !== $preset_color || $field_text !== $field_text_default ) {
				$placeholder_color = new \Pen_Theme\Color( $field_text );
				$placeholder_color = $placeholder_color->getRgb();
				$placeholder_color = 'rgba(' . implode( ',', $placeholder_color ) . ',0.75)';

				$css .= '#page input::-webkit-input-placeholder,
				#page select::-webkit-input-placeholder,
				#page textarea::-webkit-input-placeholder {
					color: ' . $placeholder_color . ';
				}
				#page input::-moz-placeholder,
				#page select::-moz-placeholder,
				#page textarea::-moz-placeholder {
					color: ' . $placeholder_color . ';
				}
				#page input:-ms-input-placeholder,
				#page select:-ms-input-placeholder,
				#page textarea:-ms-input-placeholder {
					color: ' . $placeholder_color . ';
				}';
			}

			$css .= '.select2-container--default .select2-selection--single,
			.select2-container--default .select2-selection--multiple,
			.select2-container--default .select2-dropdown {
				background:' . $field_background_secondary . ';
				border: 1px solid ' . $field_background_secondary . ';';
			/* The .select2-dropdown stays outside the #page. */
			if ( $field_background_primary !== $field_background_secondary ) {
				$css .= 'background:-ms-linear-gradient(top,' . $field_background_primary . ' 0%,' . $field_background_secondary . ' 100%);
				background:linear-gradient(to bottom,' . $field_background_primary . ' 0%,' . $field_background_secondary . ' 100%);';
			}
			if ( 'preset_1' !== $preset_color || $field_text !== $field_text_default ) {
				$css .= 'color:' . $field_text . ';';
			}
			$css .= '}';

			if ( 'preset_1' !== $preset_color || $field_text !== $field_text_default ) {
				$css .= '.select2-container--default .select2-selection__rendered,
				.select2-container--default .select2-search__field,
				.select2-container--default .select2-results__option {
					color: ' . $field_text . ' !important;
				}';
			}

			$css .= '.select2-container--default .select2-results__option[aria-selected=true],
			.select2-container--default .select2-results__option[data-selected=true],
			.select2-container--default .select2-results__option--highlighted[aria-selected],
			.select2-container--default .select2-selection--multiple .select2-selection__choice {
				background:-ms-linear-gradient(top,' . $field_background_secondary . ' 0%,' . $field_background_primary . ' 100%);
				background:linear-gradient(to bottom,' . $field_background_secondary . ' 0%,' . $field_background_primary . ' 100%);
			}';
		}

		$css = pen_compress_css( $css );

		wp_add_inline_style( 'pen-css', $css );
	}
	add_action( 'wp_enqueue_scripts', 'pen_inline_css_content' );
}

if ( ! function_exists( 'pen_inline_css_list' ) ) {
	/**
	 * Adds inline CSS for lists.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_inline_css_list() {

		$css          = '';
		$preset_color = esc_html( pen_preset_get( 'color' ) );

		if ( 'masonry' === pen_list_type() ) {
			$list_masonry_thumbnail_style                      = esc_html( pen_option_get( 'list_masonry_thumbnail_style' ) );
			$color_list_thumbnail_background_primary           = esc_html( pen_option_get( 'color_list_thumbnail_background_primary' ) );
			$color_list_thumbnail_background_primary_default   = pen_option_default( 'color_list_thumbnail_background_primary' );
			$color_list_thumbnail_background_secondary         = esc_html( pen_option_get( 'color_list_thumbnail_background_secondary' ) );
			$color_list_thumbnail_background_secondary_default = pen_option_default( 'color_list_thumbnail_background_secondary' );
			if ( 'preset_1' !== $preset_color || $color_list_thumbnail_background_primary !== $color_list_thumbnail_background_primary_default || $color_list_thumbnail_background_secondary !== $color_list_thumbnail_background_secondary_default ) {
				$css .= 'body.pen_list_masonry #pen_masonry .pen_article.pen_thumbnail_style_' . $list_masonry_thumbnail_style . ' .pen_image_thumbnail {
					background: -ms-linear-gradient(180deg, ' . $color_list_thumbnail_background_primary . ' 0%, ' . $color_list_thumbnail_background_secondary . ' 50%, ' . $color_list_thumbnail_background_primary . ' 100%);
					background: linear-gradient(90deg, ' . $color_list_thumbnail_background_primary . ' 0%, ' . $color_list_thumbnail_background_secondary . ' 50%, ' . $color_list_thumbnail_background_primary . ' 100%);
				}';
			}
		}

		$css = pen_compress_css( $css );

		wp_add_inline_style( 'pen-css', $css );
	}
	add_action( 'wp_enqueue_scripts', 'pen_inline_css_list' );
}

if ( ! function_exists( 'pen_inline_css_bottom' ) ) {
	/**
	 * Adds inline CSS for the bottom area.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_inline_css_bottom() {
		$css = '';

		$content_id = pen_post_id();

		$preset_color = esc_html( pen_preset_get( 'color' ) );

		if ( pen_sidebar_check( 'sidebar-bottom', $content_id ) ) {

			$background_left          = esc_html( pen_option_get( 'color_bottom_background_primary' ) );
			$background_left_default  = pen_option_default( 'color_bottom_background_primary' );
			$background_right         = esc_html( pen_option_get( 'color_bottom_background_secondary' ) );
			$background_right_default = pen_option_default( 'color_bottom_background_secondary' );
			$background_image         = esc_html( pen_option_get( 'background_image_bottom' ) );
			$angle                    = esc_html( pen_option_get( 'color_bottom_background_angle' ) );
			$angle_default            = pen_option_default( 'color_bottom_background_angle' );
			if ( 'to right' === $angle ) {
				$angle_ie = 'left';
			} elseif ( 'to bottom' === $angle ) {
				$angle_ie = 'top';
			} elseif ( false !== strpos( $angle, 'deg' ) ) {
				$angle_ie = ( str_replace( 'deg', '', $angle ) + 90 ) . 'deg';
			}

			$text_color         = esc_html( pen_option_get( 'color_bottom_text' ) );
			$text_color_default = pen_option_default( 'color_bottom_text' );

			if ( 'preset_1' !== $preset_color || $background_left !== $background_left_default || $background_right !== $background_right_default || $background_image || $angle !== $angle_default ) {
				$css .= '#pen_bottom.pen_not_transparent {
					background-color:' . $background_left . ';
					background:' . $background_left . ';';
				if ( $background_left !== $background_right ) {
					$css .= 'background:-ms-linear-gradient(' . $angle_ie . ',' . $background_left . ' 0%,' . $background_right . ' 100%);
					background:linear-gradient(' . $angle . ',' . $background_left . ' 0%,' . $background_right . ' 100%);';
				}
				if ( $background_image ) {
					$css .= "background-image:url('" . $background_image . "');
					background-repeat:no-repeat;
					background-position:top center;
					background-size:cover;";
				}
				if ( 'preset_1' !== $preset_color || $text_color !== $text_color_default ) {
					$css .= 'color:' . $text_color . ';';
				}
				$css .= '}';
			}
			if ( ! pen_option_get( 'color_bottom_text_shadow_display' ) ) {
				$text_shadow = 'none';
			} else {
				$text_shadow = '1px 1px 2px ' . esc_html( pen_option_get( 'color_bottom_text_shadow' ) );
			}
			if ( 'preset_1' !== $preset_color || '1px 1px 2px ' . pen_option_default( 'color_bottom_text_shadow' ) !== $text_shadow ) {
				$css .= 'body.pen_drop_shadow #pen_bottom.pen_not_transparent {
					text-shadow:' . $text_shadow . ';
				}';
			}

			$headings_color         = esc_html( pen_option_get( 'color_bottom_headings' ) );
			$headings_color_default = pen_option_default( 'color_bottom_headings' );

			if ( 'preset_1' !== $preset_color || $headings_color !== $headings_color_default ) {
				$css .= '#pen_bottom .pen_widget_transparent h3,
				#pen_bottom .pen_widget_transparent h4,
				#pen_bottom .pen_widget_transparent h5 {';
				if ( 'preset_1' !== $preset_color || $headings_color !== $headings_color_default ) {
					$css .= 'color:' . $headings_color . ';';
				}
				$css .= '}';
			}

			if ( ! pen_option_get( 'color_bottom_headings_text_shadow_display' ) ) {
				$headings_shadow = 'none';
			} else {
				$headings_shadow = '1px 1px 2px ' . esc_html( pen_option_get( 'color_bottom_headings_text_shadow' ) );
			}
			if ( 'preset_1' !== $preset_color || '1px 1px 2px ' . pen_option_default( 'color_bottom_headings_text_shadow' ) !== $headings_shadow ) {
				$css .= 'body.pen_drop_shadow #pen_bottom .pen_widget_transparent h3,
				body.pen_drop_shadow #pen_bottom .pen_widget_transparent h4,
				body.pen_drop_shadow #pen_bottom .pen_widget_transparent h5 {
					text-shadow:' . $headings_shadow . ';
				}';
			}

			$widget_title_bottom_font              = esc_html( pen_option_get( 'font_family_widget_title_bottom' ) );
			$widget_title_bottom_font_size         = esc_html( pen_option_get( 'font_size_widget_title_bottom' ) );
			$widget_title_bottom_font_size_default = pen_option_default( 'font_size_widget_title_bottom' );

			if ( 'default' !== $widget_title_bottom_font || $widget_title_bottom_font_size !== $widget_title_bottom_font_size_default ) {
				$css .= '#pen_bottom .widget-title {';
				if ( 'default' !== $widget_title_bottom_font ) {
					$css .= 'font-family:"' . ltrim( $widget_title_bottom_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;';
				}
				if ( $widget_title_bottom_font_size !== $widget_title_bottom_font_size_default ) {
					$css .= 'font-size:' . $widget_title_bottom_font_size . ';';
				}
				$css .= '}';
			}

			$field_background_primary           = esc_html( pen_option_get( 'color_bottom_field_background_primary' ) );
			$field_background_primary_default   = pen_option_default( 'color_bottom_field_background_primary' );
			$field_background_secondary         = esc_html( pen_option_get( 'color_bottom_field_background_secondary' ) );
			$field_background_secondary_default = pen_option_default( 'color_bottom_field_background_secondary' );
			$field_text                         = esc_html( pen_option_get( 'color_bottom_field_text' ) );
			$field_text_default                 = pen_option_default( 'color_bottom_field_text' );

			if ( 'preset_1' !== $preset_color || $field_background_primary !== $field_background_primary_default || $field_background_secondary !== $field_background_secondary_default || $field_text !== $field_text_default ) {
				$css .= '#pen_bottom input[type="date"],
				#pen_bottom input[type="email"],
				#pen_bottom input[type="file"],
				#pen_bottom input[type="number"],
				#pen_bottom input[type="password"],
				#pen_bottom input[type="tel"],
				#pen_bottom input[type="time"],
				#pen_bottom input[type="text"],
				#pen_bottom input[type="url"],
				#pen_bottom select,
				#pen_bottom textarea {
					background:' . $field_background_secondary . ';';
				if ( $field_background_primary !== $field_background_secondary ) {
					$css .= 'background:-ms-linear-gradient(top,' . $field_background_primary . ' 0%,' . $field_background_secondary . ' 100%);
					background:linear-gradient(to bottom,' . $field_background_primary . ' 0%,' . $field_background_secondary . ' 100%);';
				}
				if ( 'preset_1' !== $preset_color || $field_text !== $field_text_default ) {
					$css .= 'color:' . $field_text . ';';
				}
				$css .= '}
				#pen_bottom option {
					background:' . $field_background_secondary . ';
				}';

				if ( 'preset_1' !== $preset_color || $field_text !== $field_text_default ) {
					$placeholder_color = new \Pen_Theme\Color( $field_text );
					$placeholder_color = $placeholder_color->getRgb();
					$placeholder_color = 'rgba(' . implode( ',', $placeholder_color ) . ',0.75)';

					$css .= '#pen_bottom input::-webkit-input-placeholder {
						color: ' . $placeholder_color . ';
					}
					#pen_bottom input::-moz-placeholder {
						color: ' . $placeholder_color . ';
					}
					#pen_bottom input:-ms-input-placeholder {
						color: ' . $placeholder_color . ';
					}';
				}
			}

			$link_color               = esc_html( pen_option_get( 'color_bottom_link' ) );
			$link_color_default       = pen_option_default( 'color_bottom_link' );
			$link_color_hover         = esc_html( pen_option_get( 'color_bottom_link_hover' ) );
			$link_color_hover_default = pen_option_default( 'color_bottom_link_hover' );
			if ( 'preset_1' !== $preset_color || $link_color !== $link_color_default ) {
				$css .= '#pen_bottom a {
					color:' . $link_color . ';
				}';
			}
			if ( 'preset_1' !== $preset_color || $link_color_hover !== $link_color_hover_default ) {
				$css .= '#pen_bottom a:focus,
				#pen_bottom a:hover,
				#pen_bottom a:active {
					color:' . $link_color_hover . ';
				}';
			}
			$css = pen_compress_css( $css );
		}

		wp_add_inline_style( 'pen-css', $css );
	}
	add_action( 'wp_enqueue_scripts', 'pen_inline_css_bottom' );
}

if ( ! function_exists( 'pen_inline_css_footer' ) ) {
	/**
	 * Adds inline CSS for the footer area.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_inline_css_footer() {
		$css                      = '';
		$preset_color             = esc_html( pen_preset_get( 'color' ) );
		$background_left          = esc_html( pen_option_get( 'color_footer_background_primary' ) );
		$background_left_default  = pen_option_default( 'color_footer_background_primary' );
		$background_right         = esc_html( pen_option_get( 'color_footer_background_secondary' ) );
		$background_right_default = pen_option_default( 'color_footer_background_secondary' );
		$background_image         = esc_html( pen_option_get( 'background_image_footer' ) );
		$angle                    = esc_html( pen_option_get( 'color_footer_background_angle' ) );
		$angle_default            = pen_option_default( 'color_footer_background_angle' );
		if ( 'to right' === $angle ) {
			$angle_ie = 'left';
		} elseif ( 'to bottom' === $angle ) {
			$angle_ie = 'top';
		} elseif ( false !== strpos( $angle, 'deg' ) ) {
			$angle_ie = ( str_replace( 'deg', '', $angle ) + 90 ) . 'deg';
		}

		$text_color         = esc_html( pen_option_get( 'color_footer_text' ) );
		$text_color_default = pen_option_default( 'color_footer_text' );

		$link_color         = esc_html( pen_option_get( 'color_footer_link' ) );
		$link_color_default = pen_option_default( 'color_footer_link' );

		if ( 'preset_1' !== $preset_color || $background_left !== $background_left_default || $background_right !== $background_right_default || $background_image || $angle !== $angle_default ) {
			$css .= '#pen_footer.pen_not_transparent {
				background-color:' . $background_left . ';
				background:' . $background_left . ';';
			if ( $background_left !== $background_right ) {
				$css .= 'background:-ms-linear-gradient(' . $angle_ie . ',' . $background_left . ' 0%,' . $background_right . ' 100%);
				background:linear-gradient(' . $angle . ',' . $background_left . ' 0%,' . $background_right . ' 100%);';
			}
			if ( $background_image ) {
				$css .= "background-image:url('" . $background_image . "');
				background-repeat:no-repeat;
				background-position:top center;
				background-size:cover;";
			}
			if ( 'preset_1' !== $preset_color || $text_color !== $text_color_default ) {
				$css .= 'color:' . $text_color . ';';
			}
			$css .= '}
			a#pen_back {
				background:' . $background_right . ';
				color:' . $link_color . ';
			}';
		}

		if ( ! pen_option_get( 'color_footer_text_shadow_display' ) ) {
			$text_shadow = 'none';
		} else {
			$text_shadow = '1px 1px 2px ' . esc_html( pen_option_get( 'color_footer_text_shadow' ) );
		}
		if ( 'preset_1' !== $preset_color || '1px 1px 2px ' . pen_option_default( 'color_footer_text_shadow' ) !== $text_shadow ) {
			$css .= 'body.pen_drop_shadow #pen_footer.pen_not_transparent,
			body.pen_drop_shadow a#pen_back {
				text-shadow:' . $text_shadow . ';
			}';
		}

		if ( pen_option_get( 'phone' ) && pen_option_get( 'phone_footer_display' ) ) {

			$phone_font         = esc_html( pen_option_get( 'font_family_phone_footer' ) );
			$phone_size         = esc_html( pen_option_get( 'font_size_phone_footer' ) );
			$phone_size_default = pen_option_default( 'font_size_phone_footer' );

			if ( 'preset_1' !== $preset_color || 'default' !== $phone_font || $phone_size !== $phone_size_default ) {
				$css .= '#pen_footer .pen_footer_inner .pen_phone {';
				if ( 'default' !== $phone_font ) {
					$css .= 'font-family:"' . ltrim( $phone_font, 'g:' ) . '", Arial, Helvetica, Sans-serif !important;';
				}
				if ( $phone_size !== $phone_size_default ) {
					$css .= 'font-size:' . $phone_size . ';';
				}
				$css .= '}';
			}
		}

		$separator = esc_html( pen_option_get( 'footer_menu_separator' ) );
		if ( 'preset_1' !== $preset_color && $separator ) {
			if ( in_array( $separator, array( 1, 2, 3 ), true ) ) {
				$css .= '#pen_footer .pen_footer_inner #pen_footer_menu.pen_separator_' . $separator . ' div#secondary-menu > ul > li:after,
				#pen_footer .pen_footer_inner #pen_footer_menu.pen_separator_' . $separator . ' ul#secondary-menu > li:after {
					background:-ms-linear-gradient(270deg, rgba(0,0,0,0) 0%, ' . $link_color . ' 50%, rgba(0,0,0,0) 100%);
					background:linear-gradient(180deg, rgba(0,0,0,0) 0%, ' . $link_color . ' 50%, rgba(0,0,0,0) 100%);
				}';
			} elseif ( in_array( $separator, array( 4, 5, 7 ), true ) ) {
				$css .= '#pen_footer .pen_footer_inner #pen_footer_menu.pen_separator_' . $separator . ' div#secondary-menu > ul > li:after,
				#pen_footer .pen_footer_inner #pen_footer_menu.pen_separator_' . $separator . ' ul#secondary-menu > li:after {
					background:' . $link_color . ';
				}';
			} elseif ( 6 === $separator ) {
				$css .= '#pen_footer .pen_footer_inner #pen_footer_menu.pen_separator_' . $separator . ' div#secondary-menu > ul > li:before,
				#pen_footer .pen_footer_inner #pen_footer_menu.pen_separator_' . $separator . ' ul#secondary-menu > li:before,
				#pen_footer .pen_footer_inner #pen_footer_menu.pen_separator_' . $separator . ' div#secondary-menu > ul > li:after,
				#pen_footer .pen_footer_inner #pen_footer_menu.pen_separator_' . $separator . ' ul#secondary-menu > li:after {
					background:' . $link_color . ';
				}';
			} elseif ( in_array( $separator, array( 8, 9 ), true ) ) {
				$css .= '#pen_footer .pen_footer_inner #pen_footer_menu.pen_separator_' . $separator . ' div#secondary-menu > ul > li:after,
				#pen_footer .pen_footer_inner #pen_footer_menu.pen_separator_' . $separator . ' ul#secondary-menu > li:after {
					border-color:' . $link_color . ';
				}';
			} elseif ( 10 === $separator ) {
				$css .= '#pen_footer .pen_footer_inner #pen_footer_menu.pen_separator_' . $separator . ' div#secondary-menu > ul > li:after,
				#pen_footer .pen_footer_inner #pen_footer_menu.pen_separator_' . $separator . ' ul#secondary-menu > li:after {
					color:' . $link_color . ';
				}';
			}
		}

		$link_color_hover         = esc_html( pen_option_get( 'color_footer_link_hover' ) );
		$link_color_hover_default = pen_option_default( 'color_footer_link_hover' );

		if ( 'preset_1' !== $preset_color || $link_color !== $link_color_default ) {
			$css .= '#pen_footer a,
			#pen_footer .pen_footer_inner .pen_social_networks a {
				color:' . $link_color . ';
			}
			#pen_footer .pen_footer_inner .pen_social_networks a {
				border-color:' . $link_color . ';
			}
			@media only screen and (min-width:728px) {
				#pen_footer .pen_footer_inner #pen_footer_menu li a:after {
					background: -ms-linear-gradient(270deg, rgba(0,0,0,0) 0%,' . $link_color . ' 50%, rgba(0,0,0,0) 100%);
					background: linear-gradient(180deg, rgba(0,0,0,0) 0%,' . $link_color . ' 50%, rgba(0,0,0,0) 100%);
				}
			}';
		}

		if ( 'preset_1' !== $preset_color || $link_color_hover !== $link_color_hover_default ) {
			$css .= '#pen_footer a:focus,
			#pen_footer a:hover,
			#pen_footer a:active,
			#pen_footer .pen_footer_inner .pen_social_networks a:focus,
			#pen_footer .pen_footer_inner .pen_social_networks a:hover,
			#pen_footer .pen_footer_inner .pen_social_networks a:active {
				color:' . $link_color_hover . ';
			}
			#pen_footer .pen_footer_inner .pen_social_networks a:focus,
			#pen_footer .pen_footer_inner .pen_social_networks a:hover,
			#pen_footer .pen_footer_inner .pen_social_networks a:active {
				border-color:' . $link_color_hover . ';
			}';
		}

		$social_links_size         = esc_html( pen_option_get( 'font_size_social_footer' ) );
		$social_links_size_default = pen_option_default( 'font_size_social_footer' );
		if ( $social_links_size !== $social_links_size_default ) {
			$css .= '#pen_footer .pen_footer_inner .pen_social_networks li {
				font-size:' . $social_links_size . ';
			}';
		}

		$css = pen_compress_css( $css );

		wp_add_inline_style( 'pen-css', $css );
	}
	add_action( 'wp_enqueue_scripts', 'pen_inline_css_footer' );
}

if ( PEN_THEME_HAS_WOOCOMMERCE && ! function_exists( 'pen_inline_css_woocommerce' ) ) {
	/**
	 * Adds inline CSS for the awesome WooCommerce plugin.
	 *
	 * @since Pen 1.2.8
	 * @return void
	 */
	function pen_inline_css_woocommerce() {
		$css = '';

		$preset_color = esc_html( pen_preset_get( 'color' ) );

		$cart_text_color         = esc_html( pen_option_get( 'color_cart_header_content_text' ) );
		$cart_text_color_default = pen_option_default( 'color_cart_header_content_text' );

		$background_cart_left          = esc_html( pen_option_get( 'color_cart_header_content_background_primary' ) );
		$background_cart_left_default  = pen_option_default( 'color_cart_header_content_background_primary' );
		$background_cart_right         = esc_html( pen_option_get( 'color_cart_header_content_background_secondary' ) );
		$background_cart_right_default = pen_option_default( 'color_cart_header_content_background_secondary' );

		$angle         = esc_html( pen_option_get( 'color_cart_header_content_background_angle' ) );
		$angle_default = pen_option_default( 'color_cart_header_content_background_angle' );
		if ( 'to right' === $angle ) {
			$angle_ie = 'left';
		} elseif ( 'to bottom' === $angle ) {
			$angle_ie = 'top';
		} elseif ( false !== strpos( $angle, 'deg' ) ) {
			$angle_ie = ( str_replace( 'deg', '', $angle ) + 90 ) . 'deg';
		}

		if ( 'preset_1' !== $preset_color || $background_cart_left !== $background_cart_left_default || $background_cart_right !== $background_cart_right_default || $angle !== $angle_default || $cart_text_color !== $cart_text_color_default ) {
			$css .= 'body.pen_has_woocommerce #pen_cart_header .pen_cart_content {
			background-color:' . $background_cart_left . ' !important;
			background:' . $background_cart_left . '; !important;';
			if ( $background_cart_left !== $background_cart_right ) {
				$css .= 'background:-ms-linear-gradient(' . $angle_ie . ',' . $background_cart_left . ' 0%,' . $background_cart_right . ' 100%) !important;
				background:linear-gradient(' . $angle . ',' . $background_cart_left . ' 0%,' . $background_cart_right . ' 100%) !important;';
			}
			if ( 'preset_1' !== $preset_color || $cart_text_color !== $cart_text_color_default ) {
				$css .= 'color:' . $cart_text_color . ' !important;';
			}
			$css .= '}';
		}

		$link_color_cart               = esc_html( pen_option_get( 'color_cart_header_content_link' ) );
		$link_color_cart_default       = pen_option_default( 'color_cart_header_content_link' );
		$link_color_hover_cart         = esc_html( pen_option_get( 'color_cart_header_content_link_hover' ) );
		$link_color_hover_cart_default = pen_option_default( 'color_cart_header_content_link_hover' );

		if ( 'preset_1' !== $preset_color || $link_color_cart !== $link_color_cart_default ) {
			$css .= 'body.pen_has_woocommerce #pen_cart_header .pen_cart_content a {
				color:' . $link_color_cart . ';
			}';
		}
		if ( 'preset_1' !== $preset_color || $link_color_hover_cart !== $link_color_hover_cart_default ) {
			$css .= 'body.pen_has_woocommerce #pen_cart_header .pen_cart_content a:focus,
			body.pen_has_woocommerce #pen_cart_header .pen_cart_content a:hover,
			body.pen_has_woocommerce #pen_cart_header .pen_cart_content a:active {
				color:' . $link_color_hover_cart . ';
			}';
		}

		$background_badge_top            = esc_html( pen_option_get( 'pen_color_cart_badge_sale_background_primary' ) );
		$background_badge_top_default    = pen_option_default( 'pen_color_cart_badge_sale_background_primary' );
		$background_badge_bottom         = esc_html( pen_option_get( 'pen_color_cart_badge_sale_background_secondary' ) );
		$background_badge_bottom_default = pen_option_default( 'pen_color_cart_badge_sale_background_secondary' );

		$angle    = 90;
		$angle_ie = $angle + 90;

		if ( 'preset_1' !== $preset_color || $background_badge_top !== $background_badge_top_default || $background_badge_bottom !== $background_badge_bottom_default || $angle !== $angle_default ) {
			$css .= 'body.pen_has_woocommerce #page div.product > .pen_badge_sale {
			background-color:' . $background_badge_top . ' !important;
			background:' . $background_badge_top . ' !important;';
			if ( $background_badge_top !== $background_badge_bottom ) {
				$css .= 'background:-ms-linear-gradient(' . $angle_ie . 'deg,' . $background_badge_top . ' 0%,' . $background_badge_bottom . ' 100%) !important;
				background:linear-gradient(' . $angle . 'deg,' . $background_badge_top . ' 0%,' . $background_badge_bottom . ' 100%) !important;';
			}
			$css .= '}
				body.pen_has_woocommerce #page ul.products li.product .pen_badge_sale {
					background: ' . $background_badge_top . ' !important;
				}
				body.pen_has_woocommerce #page ul.products li.product .pen_badge_sale:before {
					border-top-color: ' . $background_badge_top . ' !important;
				}';
		}

		$css = pen_compress_css( $css );

		wp_add_inline_style( 'pen-css', $css );
	}
	add_action( 'wp_enqueue_scripts', 'pen_inline_css_woocommerce' );
}

if ( ! function_exists( 'pen_customize_register' ) ) {
	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_customize_register( $wp_customize ) {

		$variables = array(
			'options_animation'       => pen_animations(),
			'options_animation_delay' => pen_animations_delay(),
			'options_image_sizes'     => pen_wp_image_sizes(),
			'url_customize'           => wp_customize_url(),
		);

		pen_customize_contact( $wp_customize, $variables );
		pen_customize_color( $wp_customize, $variables );
		pen_customize_typography( $wp_customize, $variables );
		pen_customize_header( $wp_customize, $variables );
		pen_customize_content_list( $wp_customize, $variables );
		pen_customize_content_full( $wp_customize, $variables );
		pen_customize_site_layout( $wp_customize, $variables );
		pen_customize_front( $wp_customize, $variables );
		pen_customize_footer( $wp_customize, $variables );
		pen_customize_background( $wp_customize, $variables );
		pen_customize_logo( $wp_customize, $variables );

		if ( PEN_THEME_HAS_WOOCOMMERCE ) {
			pen_customize_woocommerce( $wp_customize, $variables );
		}
	}
	add_action( 'customize_register', 'pen_customize_register' );
}

if ( ! function_exists( 'pen_customizer_preview_js' ) ) {
	/**
	 * Enhancements for the the Theme Customizer.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_customizer_preview_js() {
		wp_enqueue_script( 'pen-customizer-preview', PEN_THEME_DIRECTORY_URI . '/assets/js/pen-customize-preview.js', array( 'customize-preview', 'wp-backbone' ), PEN_THEME_VERSION, true );
		wp_localize_script(
			'pen-customizer-preview',
			'pen_preview_js',
			array(
				'preset_color' => esc_html( pen_preset_get( 'color' ) ),
			)
		);
	}
	add_action( 'customize_preview_init', 'pen_customizer_preview_js' );
}

if ( ! function_exists( 'pen_customizer_main_js' ) ) {
	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_customizer_main_js() {

		$preset_preview = false;
		if ( pen_filter_input( 'GET', 'pen_preview_color' ) || pen_filter_input( 'GET', 'pen_preview_font' ) ) {
			$preset_preview = true;
		}

		$content_id = (int) pen_filter_input( 'GET', 'pen_content_id' );
		$url_start  = '';
		if ( $content_id ) {
			$url_start = get_permalink( $content_id );
		}

		$plugin_installed = false;
		if ( is_plugin_active( 'pen-extra-features/pen-extra-features.php' ) || ( is_multisite() && is_network_only_plugin( 'pen-extra-features/pen-extra-features.php' ) ) ) {
			$plugin_installed = true;
		}

		wp_enqueue_script( 'pen-customizer-main', PEN_THEME_DIRECTORY_URI . '/assets/js/pen-customize-main.js', array(), PEN_THEME_VERSION, true );
		wp_localize_script(
			'pen-customizer-main',
			'pen_customize_js',
			array(
				'url_start'          => esc_url( $url_start ),
				'url_support'        => esc_url( PEN_THEME_SUPPORT_URL ),
				'preset_preview'     => $preset_preview,
				'preset_color'       => str_replace( 'preset_', '', pen_preset_get( 'color' ) ),
				'preset_font'        => str_replace( 'preset_', '', pen_preset_get( 'font_family' ) ),
				'plugin_installed'   => $plugin_installed,
				'plugin_install_url' => esc_url( self_admin_url( 'plugin-install.php?s=pen_theme&tab=search&type=tag' ) ),
				'text'               => array(
					'pen_theme'                  => esc_html__( 'Pen', 'pen' ),
					'support_text'               => esc_html__( 'Do you need help?', 'pen' ),
					'support_description'        => esc_attr__( 'Request Support', 'pen' ),
					'install_plugin'             => esc_html__( 'Install the plugin', 'pen' ),
					'install_plugin_description' => esc_attr__( 'Enjoy a whole bunch of awesome features with the companion plugin, download and install right away.', 'pen' ),
					'theme_specific'             => sprintf(
						'%1$s\r\n%2$s',
						esc_attr(
							sprintf(
								/* Translators: %s: Theme name. */
								__( '%s Theme Only:', 'pen' ),
								__( 'Pen', 'pen' )
							)
						),
						esc_attr__( 'This is a part of the Pen theme so if you switch to another theme these settings will be no longer used. The rest of the settings that are here are either parts of the WordPress core or added via plugins and they are available with or without this theme.', 'pen' )
					),
				),
			)
		);
	}
	add_action( 'customize_controls_enqueue_scripts', 'pen_customizer_main_js' );
}
