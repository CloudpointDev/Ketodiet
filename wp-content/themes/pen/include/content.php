<?php
/**
 * Post meta data fields.
 *
 * @package Pen
 */

defined( 'ABSPATH' ) || die();

if ( ! function_exists( 'pen_post_classes' ) ) {
	/**
	 * Generates class names for posts.
	 *
	 * @param array  $classes      List of class names.
	 * @param int    $content_id   Content ID.
	 * @param string $output_type Type of output
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_post_classes( $classes = array(), $content_id, $output_type = 'class_attribute_echo' ) {

		if ( is_sticky() ) {
			$classes[] = 'sticky';
		}

		$classes[] = 'pen_article';

		if ( ! is_singular() ) {
			if ( 'masonry' !== pen_list_type() ) {
				$thumbnail_rotate = get_post_meta( $content_id, 'pen_list_thumbnail_rotate_override', true );
				if ( ! $thumbnail_rotate || 'default' === $thumbnail_rotate ) {
					$thumbnail_rotate = pen_option_get( 'list_thumbnail_rotate' );
				}
				if ( $thumbnail_rotate && 'no' !== $thumbnail_rotate ) {
					$classes[] = 'pen_list_thumbnail_rotate';
				} else {
					$classes[] = 'pen_list_thumbnail_rotate_not';
				}

				$thumbnail_frame = get_post_meta( $content_id, 'pen_list_thumbnail_frame_override', true );
				if ( ! $thumbnail_frame || 'default' === $thumbnail_frame ) {
					$thumbnail_frame = pen_option_get( 'list_thumbnail_frame' );
				}
				if ( $thumbnail_frame && 'no' !== $thumbnail_frame ) {
					$classes[] = 'pen_list_thumbnail_frame';
				} else {
					$classes[] = 'pen_list_thumbnail_frame_not';
				}

				$thumbnail_frame_color = get_post_meta( $content_id, 'pen_color_list_thumbnail_frame_override', true );
				if ( ! $thumbnail_frame_color || 'default' === $thumbnail_frame_color ) {
					$thumbnail_frame_color = pen_option_get( 'color_list_thumbnail_frame' );
				}
				if ( '#000000' === $thumbnail_frame_color ) {
					$classes[] = 'pen_list_thumbnail_frame_dark';
				} else {
					$classes[] = 'pen_list_thumbnail_frame_light';
				}

				$thumbnail_alignment = get_post_meta( $content_id, 'pen_list_thumbnail_alignment_override', true );
				if ( ! $thumbnail_alignment || 'default' === $thumbnail_alignment ) {
					$thumbnail_alignment = pen_option_get( 'list_thumbnail_alignment' );
				}
				$classes[] = 'pen_list_thumbnail_' . $thumbnail_alignment;
			}

			$options_list = array(
				'list_header_display'         => 'list_header_hide',
				'list_title_display'          => 'list_title_hide',
				'list_author_display'         => 'list_author_hide',
				'list_date_display'           => 'list_date_hide',
				'list_category_display'       => 'list_category_hide',
				'list_thumbnail_display'      => 'list_thumbnail_hide',
				'list_summary_display'        => 'list_summary_hide',
				'list_footer_display'         => 'list_footer_hide',
				'list_tags_display'           => 'list_tags_hide',
				'list_button_comment_display' => 'list_button_comment_hide',
				'list_button_edit_display'    => 'list_button_edit_hide',
			);
			foreach ( $options_list as $option => $class ) {
				$value = get_post_meta( $content_id, 'pen_' . $option . '_override', true );
				if ( $value && 'default' !== $value ) {
					$classes[] = 'pen_' . $class;
				}
			}

			$animation_reveal = get_post_meta( $content_id, 'pen_list_animation_reveal_override', true );
			if ( ! $animation_reveal || 'default' === $animation_reveal ) {
				$animation_reveal = pen_option_get( 'list_animation_reveal' );
			}
			if ( $animation_reveal ) {
				$classes[] = 'pen_custom_animation_' . $animation_reveal;

				$animation_delay = get_post_meta( $content_id, 'pen_list_animation_delay_reveal_override', true );
				if ( ! $animation_delay || 'default' === $animation_delay ) {
					$animation_delay = pen_option_get( 'list_animation_delay_reveal' );
				}
				if ( (int) $animation_delay ) {
					$classes[] = 'pen_custom_animation_delay_' . $animation_delay;
				}
			}

			$header_alignment = get_post_meta( $content_id, 'pen_list_post_header_alignment_override', true );
			if ( ! $header_alignment || 'default' === $header_alignment ) {
				$header_alignment = pen_option_get( 'list_post_header_alignment' );
			}
			if ( $header_alignment && 'no' !== $header_alignment ) {
				$classes[] = 'pen_list_header_center';
			}

			$title_alignment = get_post_meta( $content_id, 'pen_list_title_alignment_override', true );
			if ( ! $title_alignment || 'default' === $title_alignment ) {
				$title_alignment = pen_option_get( 'list_title_alignment' );
			}
			if ( $title_alignment && 'no' !== $title_alignment ) {
				$classes[] = 'pen_list_title_center';
			}

			$thumbnail_style = get_post_meta( $content_id, 'pen_list_masonry_thumbnail_style_override', true );
			if ( false === $thumbnail_style || empty( $thumbnail_style ) || 'default' === $thumbnail_style ) {
				$thumbnail_style = pen_option_get( 'list_masonry_thumbnail_style' );
			}
			$classes[] = 'pen_thumbnail_style_' . $thumbnail_style;
		}
		if ( 'return_array' === $output_type ) {
			return get_post_class( $classes, $content_id );
		}
		return post_class( $classes );
	}
}

if ( ! function_exists( 'pen_thumbnail_classes' ) ) {
	/**
	 * Generates class names for posts.
	 * (Turned into a separate function since v1.2.8)
	 *
	 * @param string $view       Whether full content or summary.
	 * @param int    $content_id Content ID.
	 *
	 * @return string
	 */
	function pen_thumbnail_classes( $view, $content_id = null ) {

		if ( ! in_array( $view, array( 'content', 'list' ), true ) ) {
			return;
		}

		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		$animation_reveal = get_post_meta( $content_id, 'pen_' . $view . '_thumbnail_animation_reveal_override', true );
		if ( ! $animation_reveal || 'default' === $animation_reveal ) {
			$animation_reveal = pen_option_get( $view . '_thumbnail_animation_reveal' );
		}

		$animation_delay = get_post_meta( $content_id, 'pen_' . $view . '_thumbnail_animation_delay_reveal_override', true );
		if ( ! $animation_delay || 'default' === $animation_delay ) {
			$animation_delay = pen_option_get( $view . '_thumbnail_animation_delay_reveal' );
		}

		$classes = array(
			'post-thumbnail',
			'pen_image_thumbnail',
			'pen_thumbnail_size_' . pen_content_thumbnail_size( $view, $content_id ),
			$animation_reveal ? 'pen_custom_animation_' . $animation_reveal : '',
			( $animation_reveal && (int) $animation_delay ) ? 'pen_custom_animation_delay_' . $animation_delay : '',
		);

		return trim( implode( ' ', array_filter( $classes ) ) );
	}
}

if ( ! function_exists( 'pen_content_thumbnail_size' ) ) {
	/**
	 * Calculates the thumbnail size.
	 * (Turned into a separate function since v1.2.8)
	 *
	 * @param string $view       Whether full content or summary.
	 * @param int    $content_id Content ID.
	 *
	 * @return int
	 */
	function pen_content_thumbnail_size( $view, $content_id = null ) {

		if ( ! in_array( $view, array( 'content', 'list' ), true ) ) {
			return;
		}

		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		$thumbnail_size = get_post_meta( $content_id, 'pen_' . $view . '_thumbnail_resize_override', true );
		if ( ! $thumbnail_size || 'default' === $thumbnail_size ) {
			$thumbnail_size = pen_option_get( $view . '_thumbnail_resize' );
		}
		if ( 'content' === $view ) {
			if ( 'none' === $thumbnail_size ) {
				if ( 'image' === get_post_type() ) {
					$thumbnail_size = 'large';
				} else {
					$thumbnail_size = 'medium';
				}
			}
		} else {
			if ( 'none' === $thumbnail_size || 'masonry' === pen_option_get( 'list_type' ) ) {
				$thumbnail_size = 'large';
			}
		}

		return $thumbnail_size;
	}
}

if ( ! function_exists( 'pen_post_excerpt' ) && ! is_admin() ) {
	/**
	 * Tweaks the automatically generated post excerpt.
	 *
	 * @param string $more Default 'more' string.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_post_excerpt( $more ) {
		$content_id = pen_post_id();
		$link       = sprintf(
			'<a href="%1$s" class="more-link pen_button">%2$s</a>',
			esc_url( get_permalink( $content_id ) ),
			sprintf(
				/* Translators: %s: Content title */
				__( 'Continue reading %s', 'pen' ),
				sprintf(
					'<span class="screen-reader-text">%1$s</span>',
					get_the_title( $content_id )
				)
			)
		);
		return sprintf(
			' &hellip;<br>%s',
			$link
		);
	}
	add_filter( 'excerpt_more', 'pen_post_excerpt' );
}

if ( ! function_exists( 'pen_post_sticky' ) ) {
	/**
	 * Sends sticky posts to the top of the lists.
	 *
	 * @param WP_Posts $posts An instance of WP_Post.
	 *
	 * @since Pen 1.0.0
	 */
	function pen_post_sticky( $posts ) {
		$is_sticky = array();
		foreach ( $posts as $key => $post ) {
			if ( is_sticky( $post->ID ) ) {
				$is_sticky[] = $post;
				unset( $posts[ $key ] );
			}
		}
		return array_merge( $is_sticky, $posts );
	}
	add_filter( 'the_posts', 'pen_post_sticky' );
}

if ( ! function_exists( 'pen_post_meta' ) ) {
	/**
	 * Custom post meta data fields.
	 *
	 * @param object $post An instance of the $post.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_post_meta( $post ) {
		$post_type               = get_post_type();
		$options_animation       = pen_animations();
		$options_animation_delay = pen_animations_delay();
		$options_image_size      = pen_wp_image_sizes();

		ob_start();
		?>

	<div id="pen_postmeta_hint">
		<?php
		esc_html_e( 'If you switch to another theme these settings will be no longer used. The rest of the settings that are here are either parts of the WordPress core or added via plugins and they will be available with or without this theme.', 'pen' );
		?>
	</div>

	<div id="pen_postmeta">
		<p>
		<?php
		esc_html_e( 'The following options would only apply to this post. If you want to apply them to all your posts you should go to Appearance &rarr; Customize &rarr; Content.', 'pen' );
		?>
		</p>

		<?php
		if ( function_exists( 'pen_plugin_postmeta_tools' ) ) {
			pen_plugin_postmeta_tools( $post->ID );
		}
		?>

		<div id="pen_postmeta_full_content" class="pen_postmeta_options pen_post_meta_full postbox">
			<h3>
		<?php
		esc_html_e( 'Full Content View', 'pen' );
		?>
			</h3>
			<div class="pen_postmeta_container">

				<div>

					<fieldset>
						<legend>
		<?php
		$section_title = __( 'Style', 'pen' );
		$label_prefix  = $section_title;
		echo esc_html( $section_title );
		?>
						</legend>
		<?php
		$setting_id = 'content_custom_preset_color';
		$label      = __( 'Color Scheme', 'pen' );
		$default    = PEN_THEME_PRESET_COLOR;
		$choices    = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				sprintf(
					/* Translators: %d: just a number. */
					__( 'Style %d', 'pen' ),
					(int) str_replace( 'preset_', '', $default )
				)
			),
		);
		for ( $s = 1; $s <= 15; $s++ ) {
			$preset = 'preset_' . $s;
			/* Translators: %d: just a number. */
			$choices[ $preset ] = sprintf( __( 'Style %d', 'pen' ), $s );
			if ( $default === $preset ) {
				$choices[ $preset ] .= sprintf( ' (%s)', __( 'Default', 'pen' ) );
			}
		}
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'content_custom_preset_font';
		$label      = __( 'Typography', 'pen' );
		$default    = PEN_THEME_PRESET_FONT;
		$choices    = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				sprintf(
					/* Translators: %d: just a number. */
					__( 'Style %d', 'pen' ),
					(int) str_replace( 'preset_', '', $default )
				)
			),
		);
		for ( $f = 1; $f <= 10; $f++ ) {
			$preset = 'preset_' . $f;
			/* Translators: %d: just a number. */
			$choices[ $preset ] = sprintf( __( 'Style %d', 'pen' ), $f );
			if ( $default === $preset ) {
				$choices[ $preset ] .= sprintf( ' (%s)', __( 'Default', 'pen' ) );
			}
		}
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );
		?>
					</fieldset>
				</div>

				<div>

					<fieldset>
						<legend>
		<?php
		$section_title = __( 'Featured Image', 'pen' );
		$label_prefix  = $section_title;
		echo esc_html( $section_title );
		?>
						</legend>

		<?php
		$setting_id = 'background_image_content_title_dynamic';
		// There is no such option as content_background_image_content_title_dynamic
		// so we will add content_ prefix down there.
		$label = __( 'Content Title Background', 'pen' );
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices    = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		$setting_id = 'content_' . $setting_id;
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'content_thumbnail_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Featured Image', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id      = 'content_thumbnail_resize';
		$label           = __( 'Featured Image Size', 'pen' );
		$default         = pen_option_get( $setting_id );
		$thumbnail_sizes = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
		);
		$thumbnail_sizes = array_merge( $thumbnail_sizes, $options_image_size );
		pen_post_meta_select( $post->ID, $setting_id, $thumbnail_sizes, $default, $label, $label_prefix );

		$setting_id = 'content_thumbnail_rotate';
		$label      = __( 'Rotate', 'pen' );
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'content_thumbnail_alignment';
		$label      = __( 'Alignment', 'pen' );
		$default    = pen_option_get( $setting_id );
		$choices    = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( ucfirst( $default ) )
			),
			'left'    => __( 'Left', 'pen' ),
			'center'  => __( 'Center', 'pen' ),
			'right'   => __( 'Right', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'content_thumbnail_frame';
		$label      = __( 'Add Frame', 'pen' );
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'color_content_thumbnail_frame';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Thumbnail Frame Color. */
			__( '%s Color', 'pen' ),
			_x( 'Frame', 'noun', 'pen' )
		);
		if ( '#000000' === pen_option_get( $setting_id ) ) {
			$default = __( 'Dark', 'pen' );
		} else {
			$default = __( 'Light', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'#000000' => __( 'Dark', 'pen' ),
			'#ffffff' => __( 'Light', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		?>
					</fieldset>

					<fieldset>
						<legend>
		<?php
		$section_title = __( 'Layout', 'pen' );
		$label_prefix  = $section_title;
		echo esc_html( $section_title );
		?>
						</legend>
		<?php
		$setting_id = 'site_width';
		$label      = __( 'Site Layout', 'pen' );
		$default    = pen_option_get( $setting_id );
		if ( 'default' === $default || 'standard' === $default ) {
			$default = 'standard';
		}
		$choices = array(
			'default'  => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( ucfirst( $default ) )
			),
			'standard' => __( 'Standard', 'pen' ),
			'wide'     => __( 'Wide', 'pen' ),
			'boxed'    => __( 'Boxed', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'content_header_alignment';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. content header. */
			_x( 'Center-align %s', 'verb', 'pen' ),
			__( 'Content Header', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'content_title_alignment';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. content header. */
			_x( 'Center-align %s', 'verb', 'pen' ),
			__( 'Content Title', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		?>

					</fieldset>

					<fieldset>
						<legend>
		<?php
		$section_title = __( 'Animation', 'pen' );
		$label_prefix  = $section_title;
		echo esc_html( $section_title );
		?>
						</legend>
		<?php
		$setting_id = 'content_animation_reveal';
		$label      = __( 'Content Area', 'pen' );
		$default    = pen_option_get( $setting_id );
		$animations = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( ucfirst( $default ) )
			),
		);
		$animations = array_merge( $animations, $options_animation );
		pen_post_meta_select( $post->ID, $setting_id, $animations, $default, $label, $label_prefix );

		$setting_id = 'content_animation_delay_reveal';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Content area, Featured image. */
			__( '%s Delay', 'pen' ),
			__( 'Content Area', 'pen' )
		);
		$default          = (int) pen_option_get( $setting_id );
		$animations_delay = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default ? $default : __( 'None', 'pen' ) )
			),
		);
		$animations_delay = array_merge( $animations_delay, $options_animation_delay );
		pen_post_meta_select( $post->ID, $setting_id, $animations_delay, $default, $label, $label_prefix );

		$setting_id = 'content_thumbnail_animation_reveal';
		$label      = __( 'Featured Image', 'pen' );
		$default    = pen_option_get( $setting_id );
		$animations = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( ucfirst( $default ) )
			),
		);
		$animations = array_merge( $animations, $options_animation );
		pen_post_meta_select( $post->ID, $setting_id, $animations, $default, $label, $label_prefix );

		$setting_id = 'content_thumbnail_animation_delay_reveal';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Content area, Featured image. */
			__( '%s Delay', 'pen' ),
			__( 'Featured Image', 'pen' )
		);
		$default          = (int) pen_option_get( $setting_id );
		$animations_delay = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default ? $default : __( 'None', 'pen' ) )
			),
		);
		$animations_delay = array_merge( $animations_delay, $options_animation_delay );
		pen_post_meta_select( $post->ID, $setting_id, $animations_delay, $default, $label, $label_prefix );
		?>
					</fieldset>

					<fieldset>
						<legend>
		<?php
		$section_title = __( 'Visibility', 'pen' );
		$label_prefix  = $section_title;
		echo esc_html( $section_title );
		?>
						</legend>
		<?php
		$setting_id = 'site_header_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Site Header', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'site_footer_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Site Footer', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'navigation_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Main Navigation', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'content_header_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Header', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'content_title_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Title', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		if ( 'post' === $post_type ) {

			$setting_id = 'content_author_display';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Content Author Link. */
					__( '%s Link', 'pen' ),
					__( 'Author', 'pen' )
				)
			);
			if ( pen_option_get( $setting_id ) ) {
				$default = __( 'Yes', 'pen' );
			} else {
				$default = __( 'No', 'pen' );
			}
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( $default )
				),
				'yes'     => __( 'Yes', 'pen' ),
				'no'      => __( 'No', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'content_date_display';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				__( 'Content Date', 'pen' )
			);
			if ( pen_option_get( $setting_id ) ) {
				$default = __( 'Yes', 'pen' );
			} else {
				$default = __( 'No', 'pen' );
			}
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( $default )
				),
				'yes'     => __( 'Yes', 'pen' ),
				'no'      => __( 'No', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'content_category_display';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Category Links. */
					__( '%s Links', 'pen' ),
					__( 'Category', 'pen' )
				)
			);
			if ( pen_option_get( $setting_id ) ) {
				$default = __( 'Yes', 'pen' );
			} else {
				$default = __( 'No', 'pen' );
			}
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( $default )
				),
				'yes'     => __( 'Yes', 'pen' ),
				'no'      => __( 'No', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'content_profile_display';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				__( 'Author Profile', 'pen' )
			);
			if ( pen_option_get( $setting_id ) ) {
				$default = __( 'Yes', 'pen' );
			} else {
				$default = __( 'No', 'pen' );
			}
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( $default )
				),
				'yes'     => __( 'Yes', 'pen' ),
				'no'      => __( 'No', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'content_tags_display';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				__( 'Content Tags', 'pen' )
			);
			if ( pen_option_get( $setting_id ) ) {
				$default = __( 'Yes', 'pen' );
			} else {
				$default = __( 'No', 'pen' );
			}
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( $default )
				),
				'yes'     => __( 'Yes', 'pen' ),
				'no'      => __( 'No', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		}
		?>

		<?php
		$setting_id = 'content_share_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Share Buttons. */
				__( '%s Buttons', 'pen' ),
				_x( 'Share', 'noun', 'pen' )
			)
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'content_footer_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Footer', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'content_search_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Search box', 'pen' )
		);
		if ( pen_option_get( 'search_display' ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );
		?>
					</fieldset>

					<fieldset>
						<legend>
		<?php
		$section_title = __( 'Location', 'pen' );
		$label_prefix  = $section_title;
		echo esc_html( $section_title );
		?>
						</legend>
		<?php
		if ( 'post' === $post_type ) {

			$setting_id = 'content_author_location';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Category Links Location. */
				__( '%s Location', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Comment Buttons. */
					__( '%s Link', 'pen' ),
					__( 'Author', 'pen' )
				)
			);
			$default = pen_option_get( $setting_id );
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( ucfirst( $default ) )
				),
				'header'  => __( 'Content Header', 'pen' ),
				'footer'  => __( 'Content Footer', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'content_date_location';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Category Links Location. */
				__( '%s Location', 'pen' ),
				__( 'Content Date', 'pen' )
			);
			$default = pen_option_get( $setting_id );
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( ucfirst( $default ) )
				),
				'header'  => __( 'Content Header', 'pen' ),
				'footer'  => __( 'Content Footer', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'content_category_location';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Category Links Location. */
				__( '%s Location', 'pen' ),
				__( 'Categories', 'pen' )
			);
			$default = pen_option_get( $setting_id );
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( ucfirst( $default ) )
				),
				'header'  => __( 'Content Header', 'pen' ),
				'footer'  => __( 'Content Footer', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		}

		$setting_id = 'content_share_location';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Category Links Location. */
			__( '%s Location', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Comment Buttons. */
				__( '%s Buttons', 'pen' ),
				_x( 'Share', 'noun', 'pen' )
			)
		);
		$default = pen_option_get( $setting_id );
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( ucfirst( $default ) )
			),
			'header'  => __( 'Content Header', 'pen' ),
			'content' => __( 'Content', 'pen' ),
			'footer'  => __( 'Content Footer', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'content_search_location';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Search box Location. */
			__( '%s Location', 'pen' ),
			__( 'Search box', 'pen' )
		);
		$default = pen_option_get( 'search_location' );
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( ucfirst( $default ) )
			),
			'header'  => __( 'Site Header', 'pen' ),
			'content' => __( 'Content Area', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		?>
					</fieldset>

					<fieldset class="pen_sidebars">
						<legend>
		<?php
		$section_title = __( 'Sidebars', 'pen' );
		$label_prefix  = $section_title;
		echo esc_html( $section_title );
		?>
						</legend>

						<p>
		<?php
		esc_html_e( 'You can control the visibility of your sidebars for this specific post.', 'pen' );
		?>
						</p>
		<?php
		$setting_id = 'pen_sidebar_header_primary_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Header', 'pen' ),
				__( 'Primary', 'pen' )
			)
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_header_secondary_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Header', 'pen' ),
				__( 'Secondary', 'pen' )
			)
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_search_top_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Search', 'pen' ),
				__( 'Top', 'pen' )
			)
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_search_left_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Search', 'pen' ),
				__( 'Left', 'pen' )
			)
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_search_right_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Search', 'pen' ),
				__( 'Right', 'pen' )
			)
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_search_bottom_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Search', 'pen' ),
				__( 'Bottom', 'pen' )
			)
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_top_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			__( 'Top', 'pen' )
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_left_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			__( 'Left', 'pen' )
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_right_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			__( 'Right', 'pen' )
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_content_top_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Content', 'pen' ),
				__( 'Top', 'pen' )
			)
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_content_bottom_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Content', 'pen' ),
				__( 'Bottom', 'pen' )
			)
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_bottom_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			__( 'Bottom', 'pen' )
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_footer_top_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Top', 'pen' )
			)
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_footer_left_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Left', 'pen' )
			)
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_footer_right_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Right', 'pen' )
			)
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );

		$setting_id = 'pen_sidebar_footer_bottom_display';
		$label      = sprintf(
			/* Translators: %s: a widget are name. */
			__( 'Hide the "%s" widget area', 'pen' ),
			sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Bottom', 'pen' )
			)
		);
		pen_post_meta_checkbox( $post->ID, $setting_id, $label, $label_prefix );
		?>
					</fieldset>

				</div>
			</div>
		</div>

		<div id="pen_postmeta_lists" class="pen_postmeta_options pen_post_meta_list postbox">

			<h3 title="<?php esc_attr_e( 'Such as category listing pages, blog pages, search results, archive, etc.', 'pen' ); ?>">
		<?php
		esc_html_e( 'List View', 'pen' );
		?>
			</h3>
			<div class="pen_postmeta_container">
				<div>
					<fieldset>
						<legend>
		<?php
		$section_title = __( 'Featured Image', 'pen' );
		$label_prefix  = $section_title;
		echo esc_html( $section_title );
		?>
						</legend>
						<p class="pen_postmeta_tip">
		<?php
		esc_html_e( 'All the image settings below would only apply to the "Plain list" (classic) layout (Customize &rarr; Content &rarr; Layout), except for the "Display featured image" setting which applies to both.', 'pen' );
		?>
						</p>
		<?php
		$setting_id = 'background_image_content_title_dynamic';
		// There is no such option as list_background_image_content_title_dynamic
		// so we will add list_ prefix down there.
		$label = __( 'Content Title Background', 'pen' );
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices    = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		$setting_id = 'list_' . $setting_id;
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'list_thumbnail_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Featured Image', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id      = 'list_thumbnail_resize';
		$label           = __( 'Featured Image Size', 'pen' );
		$default         = pen_option_get( $setting_id );
		$thumbnail_sizes = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( ucfirst( $default ) )
			),
		);
		$thumbnail_sizes = array_merge( $thumbnail_sizes, $options_image_size );
		pen_post_meta_select( $post->ID, $setting_id, $thumbnail_sizes, $default, $label, $label_prefix );

		$setting_id = 'list_thumbnail_rotate';
		$label      = __( 'Rotate', 'pen' );
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'list_thumbnail_alignment';
		$label      = __( 'Alignment', 'pen' );
		$default    = pen_option_get( $setting_id );
		$choices    = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( ucfirst( $default ) )
			),
			'left'    => __( 'Left', 'pen' ),
			'center'  => __( 'Center', 'pen' ),
			'right'   => __( 'Right', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'list_thumbnail_frame';
		$label      = __( 'Add Frame', 'pen' );
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'color_list_thumbnail_frame';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Thumbnail Frame Color. */
			__( '%s Color', 'pen' ),
			_x( 'Frame', 'noun', 'pen' )
		);
		if ( '#000000' === pen_option_get( $setting_id ) ) {
			$default = __( 'Dark', 'pen' );
		} else {
			$default = __( 'Light', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'#000000' => __( 'Dark', 'pen' ),
			'#ffffff' => __( 'Light', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'list_masonry_thumbnail_style';
		$label      = __( 'Thumbnail Style', 'pen' );
		$default    = pen_option_get( $setting_id );
		$choices    = array(
			'default' => sprintf(
				'%1$s (%2$s)',
				__( 'Default', 'pen' ),
				sprintf(
					/* Translators: %s a number. */
					__( 'Style %d', 'pen' ),
					esc_html( $default )
				)
			),
			0         => __( 'None', 'pen' ),
		);
		for ( $i = 1; $i <= 10; $i++ ) {
			/* Translators: %d the style number. */
			$choices[ $i ] = sprintf( __( 'Style %d', 'pen' ), $i );
		}
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );
		?>
					</fieldset>

					<fieldset>
						<legend>
		<?php
		$section_title = __( 'Layout', 'pen' );
		$label_prefix  = $section_title;
		echo esc_html( $section_title );
		?>
						</legend>
		<?php
		$setting_id = 'list_post_header_alignment';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. content header. */
			_x( 'Center-align %s', 'verb', 'pen' ),
			__( 'Content Header', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'list_title_alignment';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. content header. */
			_x( 'Center-align %s', 'verb', 'pen' ),
			__( 'Content Title', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );
		?>
					</fieldset>

					<fieldset>
						<legend>
		<?php
		$section_title = __( 'Animation', 'pen' );
		$label_prefix  = $section_title;
		echo esc_html( $section_title );
		?>
						</legend>
		<?php
		$setting_id = 'list_animation_reveal';
		$label      = _x( 'List Item', 'noun', 'pen' );
		$default    = pen_option_get( $setting_id );
		$animations = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( ucfirst( $default ) )
			),
		);
		$animations = array_merge( $animations, $options_animation );
		pen_post_meta_select( $post->ID, $setting_id, $animations, $default, $label, $label_prefix );

		$setting_id = 'list_animation_delay_reveal';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Content area, Featured image. */
			__( '%s Delay', 'pen' ),
			_x( 'List Item', 'noun', 'pen' )
		);
		$default          = (int) pen_option_get( $setting_id );
		$animations_delay = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default ? $default : __( 'None', 'pen' ) )
			),
		);
		$animations_delay = array_merge( $animations_delay, $options_animation_delay );
		pen_post_meta_select( $post->ID, $setting_id, $animations_delay, $default, $label, $label_prefix );

		$setting_id = 'list_thumbnail_animation_reveal';
		$label      = __( 'Thumbnail', 'pen' );
		$default    = pen_option_get( $setting_id );
		$animations = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( ucfirst( $default ) )
			),
		);
		$animations = array_merge( $animations, $options_animation );
		pen_post_meta_select( $post->ID, $setting_id, $animations, $default, $label, $label_prefix );

		$setting_id = 'list_thumbnail_animation_delay_reveal';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Content area, Featured image. */
			__( '%s Delay', 'pen' ),
			__( 'Thumbnail', 'pen' )
		);
		$default          = (int) pen_option_get( $setting_id );
		$animations_delay = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default ? $default : __( 'None', 'pen' ) )
			),
		);
		$animations_delay = array_merge( $animations_delay, $options_animation_delay );
		pen_post_meta_select( $post->ID, $setting_id, $animations_delay, $default, $label, $label_prefix );
		?>
					</fieldset>

					<fieldset>
						<legend>
		<?php
		$section_title = __( 'Visibility', 'pen' );
		$label_prefix  = $section_title;
		echo esc_html( $section_title );
		?>
						</legend>
		<?php
		$setting_id = 'list_header_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Header', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'list_title_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Title', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		if ( 'post' === $post_type ) {

			$setting_id = 'list_author_display';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				__( 'Author Link', 'pen' )
			);
			if ( pen_option_get( $setting_id ) ) {
				$default = __( 'Yes', 'pen' );
			} else {
				$default = __( 'No', 'pen' );
			}
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( $default )
				),
				'yes'     => __( 'Yes', 'pen' ),
				'no'      => __( 'No', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'list_date_display';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				__( 'Content Date', 'pen' )
			);
			if ( pen_option_get( $setting_id ) ) {
				$default = __( 'Yes', 'pen' );
			} else {
				$default = __( 'No', 'pen' );
			}
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( $default )
				),
				'yes'     => __( 'Yes', 'pen' ),
				'no'      => __( 'No', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'list_category_display';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Category Links. */
					__( '%s Links', 'pen' ),
					__( 'Category', 'pen' )
				)
			);
			if ( pen_option_get( $setting_id ) ) {
				$default = __( 'Yes', 'pen' );
			} else {
				$default = __( 'No', 'pen' );
			}
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( $default )
				),
				'yes'     => __( 'Yes', 'pen' ),
				'no'      => __( 'No', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'list_summary_display';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				__( 'Content Summary', 'pen' )
			);
			if ( pen_option_get( $setting_id ) ) {
				$default = __( 'Yes', 'pen' );
			} else {
				$default = __( 'No', 'pen' );
			}
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( $default )
				),
				'yes'     => __( 'Yes', 'pen' ),
				'no'      => __( 'No', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'list_profile_display';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				__( 'Author Profile', 'pen' )
			);
			if ( pen_option_get( $setting_id ) ) {
				$default = __( 'Yes', 'pen' );
			} else {
				$default = __( 'No', 'pen' );
			}
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( $default )
				),
				'yes'     => __( 'Yes', 'pen' ),
				'no'      => __( 'No', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'list_tags_display';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Display Site Header. */
				_x( 'Display %s', 'verb', 'pen' ),
				__( 'Content Tags', 'pen' )
			);
			if ( pen_option_get( $setting_id ) ) {
				$default = __( 'Yes', 'pen' );
			} else {
				$default = __( 'No', 'pen' );
			}
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( $default )
				),
				'yes'     => __( 'Yes', 'pen' ),
				'no'      => __( 'No', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		}

		$setting_id = 'list_footer_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			__( 'Content Footer', 'pen' )
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'list_button_comment_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Comment Button. */
				__( '%s Button', 'pen' ),
				_x( 'Comment', 'noun', 'pen' )
			)
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

		$setting_id = 'list_button_edit_display';
		$label      = sprintf(
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			_x( 'Display %s', 'verb', 'pen' ),
			sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Edit Button. */
				__( '%s Button', 'pen' ),
				__( 'Content Edit', 'pen' )
			)
		);
		if ( pen_option_get( $setting_id ) ) {
			$default = __( 'Yes', 'pen' );
		} else {
			$default = __( 'No', 'pen' );
		}
		$choices = array(
			'default' => sprintf(
				'%s (%s)',
				esc_html__( 'Default', 'pen' ),
				esc_html( $default )
			),
			'yes'     => __( 'Yes', 'pen' ),
			'no'      => __( 'No', 'pen' ),
		);
		pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );
		?>
					</fieldset>

		<?php
		if ( 'post' === $post_type ) {
			?>
					<fieldset>
						<legend>
			<?php
			$section_title = __( 'Location', 'pen' );
			$label_prefix  = $section_title;
			echo esc_html( $section_title );
			?>
						</legend>

			<?php
			$setting_id = 'list_author_location';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, e.g. Category Links Location. */
				__( '%s Location', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Comment Buttons. */
					__( '%s Link', 'pen' ),
					__( 'Author', 'pen' )
				)
			);
			$default = pen_option_get( $setting_id );
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( ucfirst( $default ) )
				),
				'header'  => __( 'Content Header', 'pen' ),
				'footer'  => __( 'Content Footer', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'list_date_location';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, such as Content Title */
				__( '%s Location', 'pen' ),
				__( 'Content Date', 'pen' )
			);
			$default = pen_option_get( $setting_id );
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( ucfirst( $default ) )
				),
				'header'  => __( 'Content Header', 'pen' ),
				'footer'  => __( 'Content Footer', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );

			$setting_id = 'list_category_location';
			$label      = sprintf(
				/* Translators: %s: Part of the theme, such as Content Title */
				__( '%s Location', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, such as Content Title */
					__( '%s Links', 'pen' ),
					__( 'Category', 'pen' )
				)
			);
			$default = pen_option_get( $setting_id );
			$choices = array(
				'default' => sprintf(
					'%s (%s)',
					esc_html__( 'Default', 'pen' ),
					esc_html( ucfirst( $default ) )
				),
				'header'  => __( 'Content Header', 'pen' ),
				'footer'  => __( 'Content Footer', 'pen' ),
			);
			pen_post_meta_select( $post->ID, $setting_id, $choices, $default, $label, $label_prefix );
			?>
					</fieldset>
			<?php
		}
		?>
				</div>
			</div>
		</div>
	</div>

	<div id="pen_meta_box_footer">
		<?php
		$pen_post_meta_hp = esc_attr( md5( NONCE_SALT . $post->ID . date( 'd' ) ) );
		?>

		<input class="screen-reader-text" type="email" name="<?php echo $pen_post_meta_hp; /* phpcs:ignore */ ?>" id="<?php echo $pen_post_meta_hp; /* phpcs:ignore */ ?>" size="30" value="" />

		<div class="pen_right">
			<a href="<?php echo esc_url( PEN_THEME_SUPPORT_URL ); ?>" class="button pen_order" target="_blank" title="<?php esc_attr_e( 'Request new features and get them in a week!', 'pen' ); ?>">
		<?php
		esc_html_e( 'Order new features! (free of charge)', 'pen' );
		?>
			</a>
		</div>
	</div>

	<div style="clear:both"></div>
		<?php
		echo ob_get_clean(); /* phpcs:ignore */
	}
}

if ( ! function_exists( 'pen_post_meta_select' ) ) {
	/**
	 * Generates HTML for <select> fields.
	 *
	 * @param int     $content_id   The content ID.
	 * @param string  $setting_id   The setting ID.
	 * @param array   $choices      Choices.
	 * @param mixed   $default      The default.
	 * @param string  $label        Field label.
	 * @param array   $label_prefix Label prefix. Only visible to screen readers.
	 *
	 * @since Pen 1.0.8
	 * @return void
	 */
	function pen_post_meta_select( $content_id, $setting_id, $choices, $default, $label, $label_prefix = '' ) {
		$setting_id    = 'pen_' . $setting_id . '_override';
		$current_value = get_post_meta( $content_id, $setting_id, true );
		$setting_id    = esc_attr( $setting_id );
		?>
		<div class="pen_postmeta_wrapper" id="<?php echo $setting_id; /* phpcs:ignore */ ?>_wrap">
			<label for="<?php echo $setting_id; /* phpcs:ignore */ ?>">
		<?php
		if ( $label_prefix ) {
			?>
				<span class="screen-reader-text">
			<?php
			echo esc_html(
				sprintf(
					'%s: ',
					$label_prefix
				)
			);
			?>
				</span>
			<?php
		}
		echo esc_html( $label );
		?>
			</label>
			<select class="widefat" name="<?php echo $setting_id; /* phpcs:ignore */ ?>" id="<?php echo $setting_id; /* phpcs:ignore */ ?>">
		<?php
		foreach ( $choices as $id => $name ) {
			?>
				<option value="<?php echo esc_attr( $id ); ?>"<?php selected( $id, $current_value ); ?>>
			<?php
			echo esc_html( $name );
			?>
				</option>
			<?php
		}
		?>
			</select>
		</div>
		<?php
	}
}

if ( ! function_exists( 'pen_post_meta_checkbox' ) ) {
	/**
	 * Generates HTML for checkboxes fields.
	 *
	 * @param int     $content_id   The content ID.
	 * @param string  $setting_id   The setting ID.
	 * @param string  $label        Field label.
	 * @param string  $label_prefix Label prefix. Only visible to screen readers.
	 *
	 * @since Pen 1.0.8
	 * @return void
	 */
	function pen_post_meta_checkbox( $content_id, $setting_id, $label, $label_prefix = '' ) {
		$current_value = get_post_meta( $content_id, $setting_id, true );
		$setting_id    = esc_attr( $setting_id );
		?>
		<label for="<?php echo $setting_id; /* phpcs:ignore */ ?>" class="pen_postmeta_wrapper" id="<?php echo $setting_id; /* phpcs:ignore */ ?>_wrap">
			<input type="checkbox" name="<?php echo $setting_id; /* phpcs:ignore */ ?>" id="<?php echo $setting_id; /* phpcs:ignore */ ?>" <?php checked( $current_value, 'on' ); ?>>
		<?php
		if ( $label_prefix ) {
			?>
				<span class="screen-reader-text">
			<?php
			echo esc_html(
				sprintf(
					'%s: ',
					$label_prefix
				)
			);
			?>
				</span>
			<?php
		}
		echo esc_html( $label );
		?>
		</label>
		<?php
	}
}

if ( ! function_exists( 'pen_post_meta_save' ) ) {
	/**
	 * Saves the meta data.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_post_meta_save() {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		global $post;
		if ( ! is_object( $post ) ) {
			return;
		}

		if ( wp_is_post_revision( $post->ID ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post->ID ) ) {
			return;
		}

		// Honey pot.
		if ( pen_filter_input( 'POST', md5( NONCE_SALT . $post->ID . date( 'd' ) ) ) ) {
			return;
		}

		$options = pen_post_meta_options();
		foreach ( $options as $option => $label ) {
			$new = pen_filter_input( 'POST', $option );
			if ( $new ) {
				update_post_meta( $post->ID, $option, $new );
			} else {
				delete_post_meta( $post->ID, $option );
			}
		}

		// Plugin option.
		$meta_name = pen_filter_input( 'POST', 'pen_meta_name' );
		if ( $meta_name ) {
			update_post_meta( $post->ID, 'pen_meta_name', $meta_name );
		} else {
			delete_post_meta( $post->ID, 'pen_meta_name' );
		}
	}
	add_action( 'save_post', 'pen_post_meta_save' );
}

if ( ! function_exists( 'pen_post_meta_box' ) ) {
	/**
	 * Adds the meta box.
	 *
	 * @param object $post An instance of the $post.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_post_meta_box( $post ) {
		if ( in_array( (string) get_post_type(), array( 'page', 'post', 'product' ), true ) ) {
			add_meta_box( 'pen_meta_box', __( 'Options', 'pen' ), 'pen_post_meta', get_post_type(), 'normal', 'high' );
		}
	}
	add_action( 'add_meta_boxes', 'pen_post_meta_box' );
}

if ( ! function_exists( 'pen_post_meta_scripts' ) ) {
	/**
	 * Adds post meta JavaScripts.
	 *
	 * @param string $hook_suffix The file name.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_post_meta_scripts( $hook_suffix ) {
		if ( 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix ) {
			wp_enqueue_script( 'pen-postmeta-js', PEN_THEME_DIRECTORY_URI . '/assets/js/pen-postmeta.js', array( 'jquery' ), PEN_THEME_VERSION, true );
			wp_localize_script(
				'pen-postmeta-js',
				'pen_postmeta_js',
				array(
					'text' => array(
						'pen_theme'        => esc_html__( 'Pen', 'pen' ),
						'nothing_selected' => esc_html__( 'Please select an item.', 'pen' ),
						'toggle'           => esc_attr(
							sprintf(
								/* Translators: %s section title. */
								_x( 'Toggle Panel: %s', 'verb', 'pen' ),
								__( 'Pen Options', 'pen' )
							)
						),
					),
				)
			);
				wp_enqueue_style( 'pen-postmeta-css', PEN_THEME_DIRECTORY_URI . '/assets/css/pen-postmeta.css', array(), PEN_THEME_VERSION );
		}
	}
	add_action( 'admin_enqueue_scripts', 'pen_post_meta_scripts' );
}

if ( ! function_exists( 'pen_content_title_background' ) ) {
	/**
	 * Returns background image URL for content header.
	 *
	 * @param bool $is_singular Result of is_singular(), for better performance.
	 * @param int  $content_id  Content ID.
	 *
	 * @since Pen 1.1.1
	 * @return string
	 */
	function pen_content_title_background( $is_singular, $content_id ) {
		$background_image_dynamic = '';
		if ( $is_singular ) {
			$thumbnail_as_background = get_post_meta( $content_id, 'pen_content_background_image_content_title_dynamic_override', true );
			if ( ! $thumbnail_as_background || 'default' === $thumbnail_as_background ) {
				$thumbnail_as_background = pen_option_get( 'background_image_content_title_dynamic' );
			}
		} else {
			$thumbnail_as_background = get_post_meta( $content_id, 'pen_list_background_image_content_title_dynamic_override', true );
			if ( ! $thumbnail_as_background || 'default' === $thumbnail_as_background ) {
				$thumbnail_as_background = pen_option_get( 'background_image_content_title_dynamic' );
			}
		}
		if ( $thumbnail_as_background ) {
			$thumbnail = esc_url( get_the_post_thumbnail_url( null, 'large' ) );
			if ( $thumbnail ) {
				$background_image_dynamic = $thumbnail;
			}
		}
		return $background_image_dynamic;
	}
}
