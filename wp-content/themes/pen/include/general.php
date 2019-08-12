<?php
/**
 * Common functions.
 *
 * @package Pen
 */

defined( 'ABSPATH' ) || die();

if ( ! function_exists( 'pen_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function pen_setup() {

		if ( pen_filter_input( 'GET', 'pen_preview_color' ) || pen_filter_input( 'GET', 'pen_preview_font' ) ) {
			// Disables the "Autoptimize" plugin.
			define( 'DONOTMINIFY', true );
			// Disables the "WP Super Cache" plugin.
			define( 'DONOTCACHEPAGE', true );
		}

		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Pen, use a find and replace
		 * to change 'pen' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'pen', PEN_THEME_DIRECTORY . '/languages' );

		add_theme_support( 'editor-styles' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for custom logo.
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 512,
				'width'       => 512,
				'flex-height' => true,
			)
		);

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 225, 225, true );

		/**
		 * Adds default RSS feed links to the <head>.
		 */
		add_theme_support( 'automatic-feed-links' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary'   => esc_html__( 'Header', 'pen' ),
				'secondary' => esc_html__( 'Footer', 'pen' ),
			)
		);

		/**
		 * Switch default core markup for search form to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'gallery',
				'caption',
				'comment-form',
				'comment-list',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'pen_custom_background_args',
				array(
					'default-color' => '333333',
					'default-image' => '',
				)
			)
		);

		$theme = wp_get_theme( 'pen' );
		define( 'PEN_THEME_VERSION', $theme->get( 'Version' ) );
		define( 'PEN_THEME_PRESET_COLOR', get_theme_mod( 'pen_preset_color', 'preset_1' ) );
		define( 'PEN_THEME_PRESET_FONT', get_theme_mod( 'pen_preset_font', 'preset_1' ) );

		add_action( 'wp_ajax_pen_post_meta', 'pen_post_meta_ajax' );

	}
	add_action( 'after_setup_theme', 'pen_setup' );
}

if ( ! function_exists( 'pen_archive_title_override' ) ) {
	/**
	 * Adds extra markup to archive titles.
	 *
	 * @param string $title The title.
	 * @since Pen 1.0.5
	 * @return string
	 */
	function pen_archive_title_override( $title ) {
		$output = $title;
		if ( false !== strpos( $title, ': ' ) ) {
			$title   = explode( ': ', $title );
			$output  = '<span class="pen_heading_main">';
			$output .= $title[0] . ':';
			$output .= '</span>';
			unset( $title[0] );
			$output .= implode( '', $title );
		}
		return $output;
	}
	add_filter( 'get_the_archive_title', 'pen_archive_title_override' );
}

if ( ! function_exists( 'pen_pingback' ) ) {
	/**
	 * Add a pingback URL auto-discovery header for singularly identifiable articles.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_pingback() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">';
		}
	}
	add_action( 'wp_head', 'pen_pingback' );
}

if ( ! function_exists( 'pen_content_width' ) ) {
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	function pen_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'pen_content_width', 1140 );
	}
	add_action( 'after_setup_theme', 'pen_content_width', 0 );
}

if ( ! function_exists( 'pen_header_background' ) ) {
	/**
	 * Set up the WordPress core custom header feature.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_header_background() {
		add_theme_support(
			'custom-header',
			apply_filters(
				'pen_custom_header_args',
				array(
					'default-image'      => '',
					'default-text-color' => '333333',
					'header-text'        => false,
					'width'              => 1800,
					'height'             => 500,
					'flex-height'        => true,
				)
			)
		);
	}
	add_action( 'after_setup_theme', 'pen_header_background' );
}

if ( ! function_exists( 'pen_body_classes' ) ) {
	/**
	 * Adds custom classes to the array of body_class filter.
	 *
	 * @global object $post
	 *
	 * @param array $classes    Classes for the body element.
	 * @param int   $content_id Content ID.
	 *
	 * @since Pen 1.0.0
	 * @return array
	 */
	function pen_body_classes( $classes ) {

		$content_id = pen_post_id(); // $post->ID doesn't return the correct post ID.

		if ( ! is_home() && ! is_front_page() ) {
			$classes[] = 'not-home';
		}

		$sidebars = array(
			'sidebar-header-primary',
			'sidebar-header-secondary',
			'sidebar-top',
			'sidebar-search-top',
			'sidebar-search-left',
			'sidebar-search-right',
			'sidebar-search-bottom',
			'sidebar-left',
			'sidebar-right',
			'sidebar-bottom',
			'sidebar-footer-top',
			'sidebar-footer-left',
			'sidebar-footer-right',
			'sidebar-footer-bottom',
		);

		foreach ( $sidebars as $sidebar ) {
			if ( pen_sidebar_check( $sidebar, $content_id ) && is_active_sidebar( $sidebar ) ) {
				$classes[] = 'visible-' . sanitize_html_class( $sidebar );
			} else {
				$classes[] = 'invisible-' . sanitize_html_class( $sidebar );
			}
		}

		if ( pen_option_get( 'header_logo_display' ) ) {
			$classes[] = 'pen_header_logo_size_' . pen_option_get( 'header_logo_size' );
		}

		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		if ( pen_option_get( 'color_site_shadow_display' ) ) {
			$classes[] = 'pen_drop_shadow';
		}
		if ( pen_option_get( 'background_lights_dim' ) ) {
			$classes[] = 'pen_background_lights_dim';
		}
		if ( pen_option_get( 'header_sticky' ) ) {
			$classes[] = 'pen_header_sticky';
		}
		if ( pen_option_get( 'round_corners' ) ) {
			$classes[] = 'pen_round_corners';
		}

		$header_logo = pen_option_get( 'header_logo_display' );
		if ( 'none' !== $header_logo ) {
			$classes[] = 'pen_header_logo_size_' . pen_option_get( 'header_logo_size' );
		}

		$classes[] = 'pen_list_effect_' . pen_option_get( 'list_effect' );
		$classes[] = 'pen_header_alignment_' . pen_option_get( 'header_alignment' );
		$classes[] = 'pen_navigation_alignment_' . pen_option_get( 'navigation_alignment' );
		$classes[] = 'pen_footer_alignment_' . pen_option_get( 'footer_alignment' );
		$classes[] = 'pen_main_container_' . pen_option_get( 'container_position' );

		if ( is_sticky() ) {
			$classes[] = 'sticky';
		}

		$pen_is_singular = is_singular();

		if ( $pen_is_singular ) {

			// Hiding parts of the content with Web accessibility and SEO in mind.
			$options_content = array(
				'site_header_display'       => 'site_header_hide',
				'site_footer_display'       => 'site_footer_hide',
				'navigation_display'        => 'navigation_hide',
				'content_header_display'    => 'content_header_hide',
				'content_title_display'     => 'content_title_hide',
				'content_author_display'    => 'content_author_hide',
				'content_date_display'      => 'content_date_hide',
				'content_category_display'  => 'content_category_hide',
				'content_thumbnail_display' => 'content_thumbnail_hide',
				'content_share_display'     => 'content_share_hide',
				'content_tags_display'      => 'content_tags_hide',
				'content_footer_display'    => 'content_footer_hide',
			);
			foreach ( $options_content as $option => $class ) {
				$display = get_post_meta( $content_id, 'pen_' . $option . '_override', true );
				if ( ! $display || 'default' === $display ) {
					$display = pen_option_get( $option );
				}
				if ( ! $display || 'no' === $display ) {
					$classes[] = 'pen_' . $class;
				}
			}

			$site_width = get_post_meta( $content_id, 'pen_site_width_override', true );
			if ( ! $site_width || 'default' === $site_width ) {
				$site_width = pen_option_get( 'site_width' );
			}
			$classes[] = 'pen_width_' . $site_width;

			$header_alignment = get_post_meta( $content_id, 'pen_content_header_alignment_override', true );
			if ( ! $header_alignment || 'default' === $header_alignment ) {
				$header_alignment = pen_option_get( 'content_header_alignment' );
			}
			if ( $header_alignment && 'no' !== $header_alignment ) {
				$classes[] = 'pen_content_header_center';
			}

			$title_alignment = get_post_meta( $content_id, 'pen_content_title_alignment_override', true );
			if ( ! $title_alignment || 'default' === $title_alignment ) {
				$title_alignment = pen_option_get( 'content_title_alignment' );
			}
			if ( $title_alignment && 'no' !== $title_alignment ) {
				$classes[] = 'pen_content_title_center';
			}

			$thumbnail_rotate = get_post_meta( $content_id, 'pen_content_thumbnail_rotate_override', true );
			if ( ! $thumbnail_rotate || 'default' === $thumbnail_rotate ) {
				$thumbnail_rotate = pen_option_get( 'content_thumbnail_rotate' );
			}
			if ( $thumbnail_rotate && 'no' !== $thumbnail_rotate ) {
				$classes[] = 'pen_content_thumbnail_rotate';
			}

			$thumbnail_frame = get_post_meta( $content_id, 'pen_content_thumbnail_frame_override', true );
			if ( ! $thumbnail_frame || 'default' === $thumbnail_frame ) {
				$thumbnail_frame = pen_option_get( 'content_thumbnail_frame' );
			}
			if ( $thumbnail_frame && 'no' !== $thumbnail_frame ) {
				$classes[] = 'pen_content_thumbnail_frame';
			}

			$thumbnail_frame_color = get_post_meta( $content_id, 'pen_color_content_thumbnail_frame_override', true );
			if ( ! $thumbnail_frame_color || 'default' === $thumbnail_frame_color ) {
				$thumbnail_frame_color = pen_option_get( 'color_content_thumbnail_frame' );
			}
			if ( '#000000' === $thumbnail_frame_color ) {
				$classes[] = 'pen_thumbnail_frame_dark';
			}

			$thumbnail_alignment = get_post_meta( $content_id, 'pen_content_thumbnail_alignment_override', true );
			if ( ! $thumbnail_alignment || 'default' === $thumbnail_alignment ) {
				$thumbnail_alignment = pen_option_get( 'content_thumbnail_alignment' );
			}
			$classes[] = 'pen_content_thumbnail_' . $thumbnail_alignment;
			$classes[] = 'pen_content_thumbnail_' . pen_option_get( 'content_thumbnail_resize' );
			$classes[] = 'pen_singular';

		} else {

			// Hiding parts of the content with Web accessibility and SEO in mind.
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
				if ( ! pen_option_get( $option ) ) {
					$classes[] = 'pen_' . $class;
				}
			}

			$classes[] = 'pen_width_' . pen_option_get( 'site_width' );

			if ( pen_option_get( 'list_post_header_alignment' ) ) {
				$classes[] = 'pen_list_header_center';
			}
			if ( pen_option_get( 'list_title_alignment' ) ) {
				$classes[] = 'pen_list_title_center';
			}

			if ( 'none' !== pen_option_get( 'list_animation_reveal' ) ) {
				$classes[] = 'pen_has_animation';
			} else {
				$classes[] = 'pen_no_animation';
			}

			$classes[] = 'pen_multiple';
			$classes[] = 'hfeed';
		}

		$list_type = pen_list_type();

		if ( ! $pen_is_singular ) {

			$classes[] = 'pen_list_' . $list_type;

			if ( 'masonry' === $list_type ) {
				$classes[] = 'pen_masonry_columns_' . pen_option_get( 'list_masonry_columns' );
				$classes[] = 'pen_thumbnail_' . pen_option_get( 'list_masonry_thumbnail_effect' );
			} else {
				// The following apply to all the posts in the list.
				if ( '#000000' === pen_option_get( 'color_list_thumbnail_frame' ) ) {
					$classes[] = 'pen_thumbnail_frame_dark';
				}
				$classes[] = 'pen_list_thumbnail_' . pen_option_get( 'list_thumbnail_alignment' );
				$classes[] = 'pen_list_thumbnail_' . pen_option_get( 'list_thumbnail_resize' );
				if ( pen_option_get( 'list_thumbnail_rotate' ) ) {
					$classes[] = 'pen_list_thumbnail_rotate';
				}
				if ( pen_option_get( 'list_thumbnail_frame' ) ) {
					$classes[] = 'pen_list_thumbnail_frame';
				}
			}
		}

		global $post;
		if ( class_exists( 'HPCF' ) && is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'HPCF' ) ) {
			$classes[] = 'pen_has_contact_form';
		}

		return $classes;
	}
	add_filter( 'body_class', 'pen_body_classes' );
}

if ( ! function_exists( 'pen_content_classes' ) ) {
	/**
	 * Content classes.
	 *
	 * @param int $content_id Content ID.
	 *
	 * @since Pen 1.0.3
	 * @return string
	 */
	function pen_content_classes( $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		$classes[] = 'site-main';
		$animation = get_post_meta( $content_id, 'pen_content_animation_reveal_override', true );
		if ( ! $animation || 'default' === $animation ) {
			$animation = pen_option_get( 'content_animation_reveal' );
		}
		if ( $animation ) {
			$classes[] = 'pen_custom_animation_' . sanitize_html_class( $animation );

			$animation_delay = get_post_meta( $content_id, 'pen_content_animation_delay_reveal_override', true );
			if ( ! $animation_delay || 'default' === $animation_delay ) {
				$animation_delay = pen_option_get( 'content_animation_delay_reveal' );
			}
			if ( (int) $animation_delay ) {
				$classes[] = 'pen_custom_animation_delay_' . $animation_delay;
			}
		}

		$classes = trim( implode( ' ', array_unique( array_filter( $classes ) ) ) );

		return $classes;
	}
}

if ( ! function_exists( 'pen_post_id' ) ) {
	/**
	 * Returns the correct post ID.
	 *
	 * @return int
	 */
	function pen_post_id() {
		if ( in_the_loop() ) {
			return get_the_ID();
		} else {
			return (int) get_queried_object_id();
		}
	}
}

if ( ! function_exists( 'pen_categorized_blog' ) ) {
	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * @since Pen 1.0.0
	 * @return bool
	 */
	function pen_categorized_blog() {
		$all_the_cool_cats = get_transient( 'pen_categories' );
		if ( false === $all_the_cool_cats ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories(
				array(
					'fields'     => 'ids',
					'hide_empty' => 1,
					// We only need to know if there is more than one category.
					'number'     => 2,
				)
			);

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'pen_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so pen_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so pen_categorized_blog should return false.
			return false;
		}

	}
}

if ( ! function_exists( 'pen_category_transient_flusher' ) ) {
	/**
	 * Flush out the transients used in pen_categorized_blog.
	 *
	 * @since Pen 1.0.0
	 * @return void|string
	 */
	function pen_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'pen_categories' );
	}
	add_action( 'edit_category', 'pen_category_transient_flusher' );
	add_action( 'save_post', 'pen_category_transient_flusher' );
}

if ( ! function_exists( 'pen_editor_styles' ) ) {
	/**
	 * Adds theme stylesheet to the visual editor.
	 *
	 * @uses add_editor_style()           Links a stylesheet to visual editor.
	 * @uses get_template_directory_uri() Through PEN_THEME_DIRECTORY_URI which returns URI of theme directory.
	 * @since Pen 1.0.0
	 */
	function pen_editor_styles() {
		add_editor_style( PEN_THEME_DIRECTORY_URI . '/assets/css/pen-editor.css' );
	}
	add_action( 'admin_init', 'pen_editor_styles' );
}

if ( ! function_exists( 'pen_class_lists' ) ) {
	/**
	 * Creates a class name for hidden elements.
	 *
	 * @param string $option     Option ID.
	 * @param int    $content_id Content ID.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_class_lists( $option, $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		if ( ! is_singular() ) {
			$display = get_post_meta( $content_id, 'pen_list_' . $option, true );
			if ( 'no' === $display ) {
				return ' pen_element_hidden';
			} elseif ( 'yes' === $display ) {
				return ' pen_element_visible';
			} else {
				return ' pen_element_default';
			}
		}
	}
}

if ( ! function_exists( 'pen_filter_input' ) ) {
	/**
	 * Sanitization function similar to filter_input and filter_input_array.
	 *
	 * @param string $source The input source, can be GET, POST, or SERVER.
	 * @param string $name   The input name, false returns an array similar to $_GET etc.
	 *
	 * @since Pen 1.0.0
	 * @return mixed Returns null when source is not provided or input does not exist.
	 */
	function pen_filter_input( $source, $name = false ) {
		if ( 'GET' !== $source && 'POST' !== $source && 'SERVER' !== $source ) {
			return null;
		}
		// Gets the sources.
		/* phpcs:disable */
		if ( 'GET' === $source ) {
			$source = $_GET;
		} elseif ( 'POST' === $source ) {
			$source = $_POST;
		} else {
			$source = $_SERVER;
		}
		/* phpcs:enable */
		// Sanitization.
		if ( ! $name ) {
			array_walk_recursive( $source, 'pen_filter_input_help' );
			if ( $source ) {
				return $source;
			} else {
				return null;
			}
		} elseif ( ! isset( $source[ $name ] ) ) {
			return null;
		} elseif ( is_array( $source[ $name ] ) ) {
			array_walk_recursive( $source[ $name ], 'pen_filter_input_help' );
			return $source[ $name ];
		} else {
			return htmlspecialchars( trim( stripslashes( $source[ $name ] ) ), ENT_NOQUOTES, 'UTF-8' );
		}
		return null;
	}
}

if ( ! function_exists( 'pen_filter_input_help' ) ) {
	/**
	 * Helper function necessary for array_walk_recursive on older PHP versions.
	 *
	 * @param mixed $value The value to be processed.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_filter_input_help( &$value ) {
		$value = htmlspecialchars( trim( stripslashes( $value ) ), ENT_NOQUOTES, 'UTF-8' );
	}
}

if ( ! function_exists( 'pen_list_type' ) ) {
	/**
	 * Returns the content list type.
	 *
	 * @since Pen 1.0.5
	 * @return string
	 */
	function pen_list_type() {
		return pen_option_get( 'list_type' );
	}
}

if ( ! function_exists( 'pen_animations' ) ) {
	/**
	 * Returns a list of the available animations.
	 *
	 * @since Pen 1.0.5
	 * @return string
	 */
	function pen_animations() {
		return array(
			'none'              => __( 'None', 'pen' ),
			'bounce'            => 'bounce',
			'flash'             => 'flash',
			'pulse'             => 'pulse',
			'rubberBand'        => 'rubberBand',
			'shake'             => 'shake',
			'headShake'         => 'headShake',
			'swing'             => 'swing',
			'tada'              => 'tada',
			'wobble'            => 'wobble',
			'jello'             => 'jello',
			'bounceIn'          => 'bounceIn',
			'bounceInDown'      => 'bounceInDown',
			'bounceInLeft'      => 'bounceInLeft',
			'bounceInRight'     => 'bounceInRight',
			'bounceInUp'        => 'bounceInUp',
			'fadeIn'            => 'fadeIn',
			'fadeInDown'        => 'fadeInDown',
			'fadeInDownBig'     => 'fadeInDownBig',
			'fadeInLeft'        => 'fadeInLeft',
			'fadeInLeftBig'     => 'fadeInLeftBig',
			'fadeInRight'       => 'fadeInRight',
			'fadeInRightBig'    => 'fadeInRightBig',
			'fadeInUp'          => 'fadeInUp',
			'fadeInUpBig'       => 'fadeInUpBig',
			'flipInX'           => 'flipInX',
			'flipInY'           => 'flipInY',
			'lightSpeedIn'      => 'lightSpeedIn',
			'rotateIn'          => 'rotateIn',
			'rotateInDownLeft'  => 'rotateInDownLeft',
			'rotateInDownRight' => 'rotateInDownRight',
			'rotateInUpLeft'    => 'rotateInUpLeft',
			'rotateInUpRight'   => 'rotateInUpRight',
			'jackInTheBox'      => 'jackInTheBox',
			'rollIn'            => 'rollIn',
			'zoomIn'            => 'zoomIn',
			'zoomInDown'        => 'zoomInDown',
			'zoomInLeft'        => 'zoomInLeft',
			'zoomInRight'       => 'zoomInRight',
			'zoomInUp'          => 'zoomInUp',
			'slideInDown'       => 'slideInDown',
			'slideInLeft'       => 'slideInLeft',
			'slideInRight'      => 'slideInRight',
			'slideInUp'         => 'slideInUp',
		);
	}
}

if ( ! function_exists( 'pen_animations_delay' ) ) {
	/**
	 * Returns a list of the available animation delay options.
	 *
	 * @since Pen 1.2.8
	 * @return string
	 */
	function pen_animations_delay() {
		/* Translators: %d: just a number. */
		$text_seconds = __( '%d seconds', 'pen' );
		return array(
			0 => __( 'None', 'pen' ),
			1 => __( '1 second', 'pen' ),
			2 => sprintf( $text_seconds, 2 ),
			3 => sprintf( $text_seconds, 3 ),
			4 => sprintf( $text_seconds, 4 ),
			5 => sprintf( $text_seconds, 5 ),
		);
	}
}

if ( ! function_exists( 'pen_class_navigation' ) ) {
	/**
	 * Generates class names for the navigation menu.
	 *
	 * @since Pen 1.0.8
	 * @return string
	 */
	function pen_class_navigation() {
		$hover             = pen_option_get( 'navigation_hover' );
		$arrows            = pen_option_get( 'navigation_arrows' );
		$separator         = pen_option_get( 'navigation_separator' );
		$separator_submenu = pen_option_get( 'navigation_separator_submenu' );

		$navigation_display = get_post_meta( pen_post_id(), 'pen_navigation_display_override', true );
		if ( ! $navigation_display || 'default' === $navigation_display ) {
			$navigation_display = pen_option_get( 'navigation_display' );
		}
		if ( $navigation_display && 'no' !== $navigation_display ) {
			$navigation_display = true;
		} else {
			$navigation_display = false;
		}

		$classes = array(
			'main-navigation',
			( ! $navigation_display ) ? 'pen_element_hidden' : '',
			'pen_hover_' . ( $hover ? $hover : 'none' ),
			'pen_arrows_' . ( $arrows ? $arrows : 'none' ),
			'pen_separator_' . ( $separator ? $separator : 'none' ),
			'pen_separator_submenu_' . ( $separator_submenu ? $separator_submenu : 'none' ),
		);
		return trim( implode( ' ', array_filter( $classes ) ) );
	}
}

if ( ! function_exists( 'pen_class_animation' ) ) {
	/**
	 * Generates animation class names.
	 *
	 * @param string  $option_id  The option ID.
	 * @param boolean $echo       Whether to echo or return.
	 * @param int     $content_id Content ID.
	 *
	 * @since Pen 1.0.7
	 * @return void|string
	 */
	function pen_class_animation( $option_id, $echo, $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		$classes = array();

		$animation = get_post_meta( $content_id, 'pen_' . $option_id . '_animation_reveal_override', true );
		if ( ! $animation || 'default' === $animation ) {
			$animation = pen_option_get( $option_id . '_animation_reveal' );
		}
		if ( $animation ) {
			$classes[] = 'pen_animate_on_scroll';
			$classes[] = 'pen_custom_animation_' . sanitize_html_class( $animation );

			$animation_delay = get_post_meta( $content_id, 'pen_' . $option_id . '_animation_delay_reveal_override', true );
			if ( ! $animation_delay || 'default' === $animation_delay ) {
				$animation_delay = pen_option_get( $option_id . '_animation_delay_reveal' );
			}
			if ( (int) $animation_delay ) {
				$classes[] = 'pen_custom_animation_delay_' . $animation_delay;
			}
		}

		$classes = trim( implode( ' ', array_unique( array_filter( $classes ) ) ) );

		if ( $echo ) {
			echo $classes; /* phpcs:ignore */
		} else {
			return $classes;
		}
	}
}

if ( ! function_exists( 'pen_url_customizer' ) ) {
	/**
	 * Generates a URL for the customizer.
	 *
	 * @param string $focus Focus on specific option.
	 *
	 * @since Pen 1.0.8
	 * @return string
	 */
	function pen_url_customizer( $focus = '' ) {
		if ( is_customize_preview() ) {
			return '#';
		}
		$query['return'] = rawurlencode( pen_filter_input( 'SERVER', 'REQUEST_URI' ) );
		if ( $focus && false !== strpos( $focus, ',' ) ) {
			list( $container_type, $container_name ) = explode( ',', $focus );

			$generic = array(
				'background_image',
				'header_image',
				'nav_menus',
				'title_tagline',
				'widgets',
			);
			if ( ! in_array( $container_name, $generic, true ) && false === strpos( $container_name, 'sidebar-widgets-' ) ) {
				$container_name = 'pen_' . $container_type . '_' . $container_name;
			}
			$query[ 'autofocus[' . $container_type . ']' ] = $container_name;
		}

		$url_customize = wp_customize_url();
		if ( ! is_admin() ) {
			$content_id = pen_post_id();
			if ( $content_id ) {
				$url_customize = add_query_arg( 'pen_content_id', $content_id, wp_customize_url() );
			}
		}
		return add_query_arg( $query, $url_customize );
	}
}

if ( ! function_exists( 'pen_jump_menu' ) ) {
	/**
	 * Provides easier access to various parts of the back-end.
	 *
	 * @param string $element    Target element.
	 * @param int    $content_id Content ID.
	 *
	 * @since Pen 1.0.8
	 * @return string
	 */
	function pen_jump_menu( $element, $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		$url_customize = wp_customize_url();
		if ( ! is_admin() && $content_id ) {
			$url_customize = add_query_arg( 'pen_content_id', $content_id, wp_customize_url() );
		}

		/* phpcs:disable */
		switch ( $element ) {
			case 'color_schemes':

				$preset_color_current = (int) str_replace( 'preset_', '', pen_preset_get( 'color' ) );

				$items = array();
				for ( $i = 1; $i <= 15; $i++ ) {
					$url_customize_color = add_query_arg(
						array(
							'autofocus[panel]'  => 'pen_panel_colors',
							'pen_preview_color' => (int) $i
						),
						$url_customize
					);

					$items[ $url_customize_color ] = sprintf( __( 'Style %d', 'pen' ), $i );
					if ( $i === $preset_color_current ) {
						$items[ $url_customize_color ] .= sprintf( ' (%s)', __( 'Current', 'pen' ) );
					}
				}

				$menu = array(
					'name'  => __( 'Color Schemes', 'pen' ),
					'items' => $items,
				);
				return $menu;

			case 'font_presets':

				$preset_font_current  = (int) str_replace( 'preset_', '', pen_preset_get( 'font_family' ) );

				$items = array();

				for ( $i = 1; $i <= 10; $i++ ) {
					$url_customize_font = add_query_arg(
						array(
							'autofocus[panel]' => 'pen_panel_typography',
							'pen_preview_font' => (int) $i
						),
						$url_customize
					);
					$items[ $url_customize_font ] = sprintf( __( 'Font Preset %d', 'pen' ), $i );
					if ( $i === $preset_font_current ) {
						$items[ $url_customize_font ] .= sprintf( ' (%s)', __( 'Current', 'pen' ) );
					}
				}

				$menu = array(
					'name'  => __( 'Font Presets', 'pen' ),
					'items' => $items,
				);
				return $menu;

			case 'site':
				$menu = array(
					'name'  => sprintf(
						/* Translators: %s: Something to configure, such as Header, Footer. */
						__( '%s Settings', 'pen' ),
						__( 'General', 'pen' )
					),
					'items' => array(
						'section,background_image'   => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Site', 'pen' ),
							__( 'Background Image', 'pen' )
						),
						'section,colors_general'     => __( 'Colors', 'pen' ),
						'section,typography_general' => __( 'Typography', 'pen' ),
						'section,layout'             => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Site', 'pen' ),
							__( 'Layout', 'pen' )
						),
					),
				);
				if ( is_home() || is_front_page() ) {
					$menu['items'][ ( 'panel,front' ) ] = __( 'Front Page', 'pen' );
				}
				return $menu;

			case 'header':
				return array(
					'name'  => __( 'Header', 'pen' ),
					'items' => array(
						'section,header_general'    => sprintf(
							'%1$s<span> &rarr; %2$s</span>',
							__( 'General', 'pen' ),
							sprintf(
								/* Translators: %s: Something to configure, such as Header, Footer. */
								__( '%s Settings', 'pen' ),
								__( 'Header', 'pen' )
							)
						),
						'section,header_image'      => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Header', 'pen' ),
							__( 'Background Image', 'pen' )
						),
						'section,title_tagline'     => __( 'Logo', 'pen' ),
						'section,header_search'     => __( 'Search', 'pen' ),
						'section,colors_header'     => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Header', 'pen' ),
							__( 'Colors', 'pen' )
						),
						'section,typography_header' => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Header', 'pen' ),
							__( 'Typography', 'pen' )
						),
						'panel,contact'             => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Site', 'pen' ),
							__( 'Contacts', 'pen' )
						),
					),
				);

			case 'navigation':
				return array(
					'name'  => __( 'Navigation', 'pen' ),
					'items' => array(
						'section,header_navigation'           => sprintf(
							'%1$s<span> &rarr; %2$s</span>',
							__( 'General', 'pen' ),
							sprintf(
								/* Translators: %s: Something to configure, such as Header, Footer. */
								__( '%s Settings', 'pen' ),
								__( 'Navigation', 'pen' )
							)
						),
						'panel,nav_menus'                     => __( 'Menus', 'pen' ),
						'section,background_image_navigation' => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Navigation', 'pen' ),
							__( 'Background Image', 'pen' )
						),
						'section,colors_navigation'           => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Navigation', 'pen' ),
							__( 'Colors', 'pen' )
						),
						'section,typography_navigation'       => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Navigation', 'pen' ),
							__( 'Typography', 'pen' )
						),
					),
				);

			case 'search_bar':
				return array(
					'name'  => __( 'Search Bar', 'pen' ),
					'items' => array(
						'section,header_search'           => sprintf(
							'%1$s<span> &rarr; %2$s</span>',
							__( 'General', 'pen' ),
							sprintf(
								/* Translators: %s: Something to configure, such as Header, Footer. */
								__( '%s Settings', 'pen' ),
								__( 'Search', 'pen' )
							)
						),
						'section,background_image_search' => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Search Bar', 'pen' ),
							__( 'Background Image', 'pen' )
						),
						'section,colors_search'           => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Search Bar', 'pen' ),
							__( 'Colors', 'pen' )
						),
					),
				);

			case 'content':
				$menu = array(
					'name'  => __( 'Content Area', 'pen' ),
					'items' => array(
						'section,content'        => sprintf(
							'%1$s<span> &rarr; %2$s</span>',
							__( 'General', 'pen' ),
							sprintf(
								/* Translators: %s: Something to configure, such as Header, Footer. */
								__( '%s Settings', 'pen' ),
								__( 'Content Area', 'pen' )
							)
						),
						'section,colors_content' => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Content Area', 'pen' ),
							__( 'Colors', 'pen' )
						),
						'section,layout'         => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Site', 'pen' ),
							__( 'Layout', 'pen' )
						),
					),
				);

				if ( $content_id ) {
					$url_post_edit = self_admin_url(
						sprintf(
							'post.php?post=%d&action=edit',
							esc_attr( $content_id )
						)
					);
					$menu['items'][ $url_post_edit ] = sprintf(
						/* Translators: %s: post type. */
						__( 'Edit This %s', 'pen' ),
						ucwords( get_post_type() )
					);
				}
				return $menu;

			case 'list':
				return array(
					'name'  => __( 'List Views', 'pen' ),
					'items' => array(
						'section,list'        => sprintf(
							'%1$s<span> &rarr; %2$s</span>',
							__( 'General', 'pen' ),
							sprintf(
								/* Translators: %s: Something to configure, such as Header, Footer. */
								__( '%s Settings', 'pen' ),
								__( 'List View', 'pen' )
							)
						),
						'section,colors_list' => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Content List', 'pen' ),
							__( 'Colors', 'pen' )
						),
						'section,layout'      => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Site', 'pen' ),
							__( 'Layout', 'pen' )
						),
					),
				);

			case 'sidebar-header-primary':
				return array(
					'name'  => sprintf(
						'%1$s - %2$s',
						__( 'Header', 'pen' ),
						__( 'Primary', 'pen' )
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-header-primary' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								'%1$s - %2$s',
								__( 'Header', 'pen' ),
								__( 'Primary', 'pen' )
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-header-secondary':
				return array(
					'name'  => sprintf(
						'%1$s - %2$s',
						__( 'Header', 'pen' ),
						__( 'Secondary', 'pen' )
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-header-secondary' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								'%1$s - %2$s',
								__( 'Header', 'pen' ),
								__( 'Secondary', 'pen' )
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-top':
				return array(
					'name'  => sprintf(
						__( '"%s" Widget Area', 'pen' ),
						__( 'Top', 'pen' )
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-top' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Widget Area', 'pen' ),
								__( 'Top', 'pen' )
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-search-top':
				return array(
					'name'  => sprintf(
						__( '"%s" Widget Area', 'pen' ),
						sprintf(
							'%1$s - %2$s',
							__( 'Search', 'pen' ),
							__( 'Top', 'pen' )
						)
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-search-top' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Widget Area', 'pen' ),
								sprintf(
									'%1$s - %2$s',
									__( 'Search', 'pen' ),
									__( 'Top', 'pen' )
								)
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-search-left':
				return array(
					'name'  => sprintf(
						__( '"%s" Widget Area', 'pen' ),
						sprintf(
							'%1$s - %2$s',
							__( 'Search', 'pen' ),
							__( 'Left', 'pen' )
						)
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-search-left' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Widget Area', 'pen' ),
								sprintf(
									'%1$s - %2$s',
									__( 'Search', 'pen' ),
									__( 'Left', 'pen' )
								)
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-search-right':
				return array(
					'name'  => sprintf(
						__( '"%s" Widget Area', 'pen' ),
						sprintf(
							'%1$s - %2$s',
							__( 'Search', 'pen' ),
							__( 'Right', 'pen' )
						)
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-search-right' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Widget Area', 'pen' ),
								sprintf(
									'%1$s - %2$s',
									__( 'Search', 'pen' ),
									__( 'Right', 'pen' )
								)
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-search-bottom':
				return array(
					'name'  => sprintf(
						__( '"%s" Widget Area', 'pen' ),
						sprintf(
							'%1$s - %2$s',
							__( 'Search', 'pen' ),
							__( 'Bottom', 'pen' )
						)
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-search-bottom' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Widget Area', 'pen' ),
								sprintf(
									'%1$s - %2$s',
									__( 'Search', 'pen' ),
									__( 'Bottom', 'pen' )
								)
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-content-top':
				return array(
					'name'  => sprintf(
						__( '"%s" Widget Area', 'pen' ),
						sprintf(
							'%1$s - %2$s',
							__( 'Content', 'pen' ),
							__( 'Top', 'pen' )
						)
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-content-top' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Widget Area', 'pen' ),
								sprintf(
									'%1$s - %2$s',
									__( 'Content', 'pen' ),
									__( 'Top', 'pen' )
								)
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-content-bottom':
				return array(
					'name'  => sprintf(
						__( '"%s" Widget Area', 'pen' ),
						sprintf(
							'%1$s - %2$s',
							__( 'Content', 'pen' ),
							__( 'Bottom', 'pen' )
						)
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-content-bottom' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Widget Area', 'pen' ),
								sprintf(
									'%1$s - %2$s',
									__( 'Content', 'pen' ),
									__( 'Bottom', 'pen' )
								)
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-left':
				return array(
					'name'  => sprintf(
						__( '"%s" Sidebar', 'pen' ),
						__( 'Left', 'pen' )
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-left' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Sidebar', 'pen' ),
								__( 'Left', 'pen' )
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-right':
				return array(
					'name'  => sprintf(
						__( '"%s" Sidebar', 'pen' ),
						__( 'Right', 'pen' )
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-right' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Sidebar', 'pen' ),
								__( 'Right', 'pen' )
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-bottom':
				return array(
					'name'  => __( 'Bottom', 'pen' ),
					'items' => array(
						'section,background_image_bottom' => sprintf(
							'<span>%1$s %2$s &rarr; </span>%2$s',
							sprintf(
								/* Translators: %s: Widget area name. */
								__( '"%s" Widget Area', 'pen' ),
								__( 'Bottom', 'pen' )
							),
							__( 'Background Image', 'pen' )
						),
						'section,colors_bottom'           => sprintf(
							'<span>%1$s %2$s &rarr; </span>%2$s',
							sprintf(
								/* Translators: %s: Widget area name. */
								__( '"%s" Widget Area', 'pen' ),
								__( 'Bottom', 'pen' )
							),
							__( 'Colors', 'pen' )
						),
						'section,sidebar-widgets-sidebar-bottom' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Widget Area', 'pen' ),
								__( 'Bottom', 'pen' )
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-footer-top':
				return array(
					'name'  => sprintf(
						'%1$s - %2$s',
						__( 'Footer', 'pen' ),
						__( 'Top', 'pen' )
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-footer-top' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Widget Area', 'pen' ),
								sprintf(
									'%1$s - %2$s',
									__( 'Footer', 'pen' ),
									__( 'Top', 'pen' )
								)
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-footer-left':
				return array(
					'name'  => sprintf(
						'%1$s - %2$s',
						__( 'Footer', 'pen' ),
						__( 'Left', 'pen' )
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-footer-left' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Widget Area', 'pen' ),
								sprintf(
									'%1$s - %2$s',
									__( 'Footer', 'pen' ),
									__( 'Left', 'pen' )
								)
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-footer-right':
				return array(
					'name'  => sprintf(
						'%1$s - %2$s',
						__( 'Footer', 'pen' ),
						__( 'Right', 'pen' )
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-footer-right' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Widget Area', 'pen' ),
								sprintf(
									'%1$s - %2$s',
									__( 'Footer', 'pen' ),
									__( 'Right', 'pen' )
								)
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'sidebar-footer-bottom':
				return array(
					'name'  => sprintf(
						'%1$s - %2$s',
						__( 'Footer', 'pen' ),
						__( 'Bottom', 'pen' )
					),
					'items' => array(
						'section,sidebar-widgets-sidebar-footer-bottom' => sprintf(
							'<span>%1$s </span>%2$s',
							sprintf(
								__( '"%s" Widget Area', 'pen' ),
								sprintf(
									'%1$s - %2$s',
									__( 'Footer', 'pen' ),
									__( 'Bottom', 'pen' )
								)
							),
							__( 'Configure Widgets', 'pen' )
						),
					),
				);

			case 'footer':
				return array(
					'name'  => __( 'Footer', 'pen' ),
					'items' => array(
						'section,footer'                  => sprintf(
							'%1$s<span> &rarr; %2$s</span>',
							__( 'General', 'pen' ),
							sprintf(
								/* Translators: %s: Something to configure, such as Header, Footer. */
								__( '%s Settings', 'pen' ),
								__( 'Footer', 'pen' )
							)
						),
						'section,background_image_footer' => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Footer', 'pen' ),
							__( 'Background Image', 'pen' )
						),
						'section,colors_footer'           => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Footer', 'pen' ),
							__( 'Colors', 'pen' )
						),
						'section,typography_footer'       => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Footer', 'pen' ),
							__( 'Typography', 'pen' )
						),
						'panel,contact'                   => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'Site', 'pen' ),
							__( 'Contacts', 'pen' )
						),
					),
				);

			case 'woocommerce':
				return array(
					'name'  => __( 'WooCommerce', 'pen' ),
					'items' => array(
						'panel,woocommerce'    => sprintf(
							'%1$s<span> &rarr; %2$s</span>',
							__( 'General', 'pen' ),
							sprintf(
								/* Translators: %s: Something to configure, such as Header, Footer. */
								__( '%s Settings', 'pen' ),
								__( 'WooCommerce', 'pen' )
							)
						),
						'section,colors_woocommerce'  => sprintf(
							'<span>%1$s &rarr; </span>%2$s',
							__( 'WooCommerce', 'pen' ),
							__( 'Colors', 'pen' )
						),
					),
				);

		}

		/* phpcs:enable */
	}
}

if ( ! function_exists( 'pen_post_meta_options' ) ) {
	/**
	 * Returns a list of post meta options.
	 *
	 * @param string $group Which group of options to return.
	 *
	 * @since Pen 1.0.5
	 * @return array
	 */
	function pen_post_meta_options( $group = 'all' ) {
		/* phpcs:disable */
		$options_list = array(
			// Do not reorder alphabetically.

			'pen_list_post_header_alignment_override'                  => sprintf(
				/* Translators: %s: Part of the theme, e.g. content header. */
				_x( 'Center-align %s', 'verb', 'pen' ),
				__( 'Content Header', 'pen' )
			),

			'pen_list_title_alignment_override'                        => sprintf(
				/* Translators: %s: Part of the theme, e.g. content header. */
				_x( 'Center-align %s', 'verb', 'pen' ),
				__( 'Content Title', 'pen' )
			),
			'pen_list_title_display_override'                          => __( 'Content Title', 'pen' ),
			'pen_list_animation_reveal_override'                       => sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
				__( '%s Animation', 'pen' ),
				__( 'Content', 'pen' )
			),
			'pen_list_animation_delay_reveal_override'                 => sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation Delay. */
				__( '%s Delay', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
					__( '%s Animation', 'pen' ),
					__( 'Content', 'pen' )
				)
			),
			'pen_list_author_display_override'                         => __( 'Content Author', 'pen' ),
			'pen_list_date_display_override'                           => __( 'Content Date', 'pen' ),
			'pen_list_date_location_override'                          => sprintf(
				/* Translators: %s: Part of the theme, e.g. Category Links Location. */
				__( '%s Location', 'pen' ),
				__( 'Content Date', 'pen' )
			),
			'pen_list_footer_display_override'                         => __( 'Content Footer', 'pen' ),
			'pen_list_header_display_override'                         => __( 'Content Header', 'pen' ),
			'pen_list_summary_display_override'                        => __( 'Content Summary', 'pen' ),
			'pen_list_tags_display_override'                           => __( 'Content Tags', 'pen' ),
			'pen_list_thumbnail_animation_reveal_override'             => sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
				__( '%s Animation', 'pen' ),
				__( 'Thumbnail', 'pen' )
			),
			/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
			'pen_list_thumbnail_animation_delay_reveal_override'       => sprintf(
				/* Translators: %s: Part of the theme, e.g. Site Title Animation Delay. */
				__( '%s Delay', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Site Title Animation. */
					__( '%s Animation', 'pen' ),
					__( 'Thumbnail', 'pen' )
				)
			),
			'pen_list_category_display_override'                       => sprintf(
				/* Translators: %s: Part of the theme, e.g. Category Links. */
				__( '%s Links', 'pen' ),
				__( 'Category', 'pen' )
			),
			'pen_list_category_location_override'                      => sprintf(
			/* Translators: %s: Part of the theme, e.g. Category Links Location. */
				__( '%s Location', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Category Links. */
					__( '%s Links', 'pen' ),
					__( 'Category', 'pen' )
				)
			),
			'pen_list_profile_display_override'                        => __( 'Author Profile', 'pen' ),
			'pen_list_author_location_override'                        => sprintf(
				/* Translators: %s: Part of the theme, e.g. Category Links Location. */
				__( '%s Location', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Category Links. */
					__( '%s Link', 'pen' ),
					__( 'Content Author', 'pen' )
				)
			),
			'pen_list_share_location_override'                         => sprintf(
				/* Translators: %s: Part of the theme, e.g. Category Links Location. */
				__( '%s Location', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Category Links. */
					__( '%s Buttons', 'pen' ),
					_x( 'Share', 'noun', 'pen' )
				)
			),
			'pen_list_background_image_content_title_dynamic_override' => __( 'Featured Image As Title Background', 'pen' ),
			'pen_list_thumbnail_display_override'                      => __( 'Thumbnail', 'pen' ),
			'pen_list_thumbnail_alignment_override'                    => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Title Alignment. */
				__( '%s Alignment', 'pen' ),
				__( 'Thumbnail', 'pen' )
			),
			'pen_color_list_thumbnail_frame_override'                  => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Title Color. */
				__( '%s Color', 'pen' ),
				__( 'Thumbnail Frame', 'pen' )
			),
			'pen_list_thumbnail_frame_override'                        => __( 'Thumbnail Frame', 'pen' ),
			'pen_list_thumbnail_resize_override'                       => __( 'Thumbnail Size', 'pen' ),
			'pen_list_thumbnail_rotate_override'                       => __( 'Thumbnail Rotate', 'pen' ),
			'pen_list_masonry_thumbnail_style_override'                => __( 'Thumbnail Style', 'pen' ),
			'pen_list_button_comment_display_override'                 => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Title Color. */
				__( '%s Button', 'pen' ),
				_x( 'Comment', 'noun', 'pen' )
			),
			'pen_list_button_edit_display_override'                    => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Title Color. */
				__( '%s Button', 'pen' ),
				_x( 'Edit', 'noun', 'pen' )
			),
		);

		$options_content = array(
			// Do not reorder alphabetically.
			'pen_content_custom_preset_color_override'                    => __( 'Color Scheme', 'pen' ),
			'pen_content_custom_preset_font_override'                     => __( 'Font Preset', 'pen' ),
			'pen_site_width_override'                                     => __( 'Site Width', 'pen' ),
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			'pen_site_header_display_override'                            => sprintf(
				_x( 'Display %s', 'verb', 'pen' ),
				__( 'Site Header', 'pen' )
			),
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			'pen_site_footer_display_override'                            => sprintf(
				_x( 'Display %s', 'verb', 'pen' ),
				__( 'Site Footer', 'pen' )
			),
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			'pen_navigation_display_override'                             => sprintf(
				_x( 'Display %s', 'verb', 'pen' ),
				__( 'Main Navigation', 'pen' )
			),
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			'pen_content_header_alignment_override'                       => sprintf(
				_x( 'Center-align %s', 'verb', 'pen' ),
				__( 'Content Header', 'pen' )
			),
			/* Translators: %s: Part of the theme, e.g. Display Site Header. */
			'pen_content_title_alignment_override'                        => sprintf(
				_x( 'Center-align %s', 'verb', 'pen' ),
				__( 'Content Title', 'pen' )
			),
			'pen_content_title_display_override'                          => __( 'Content Title', 'pen' ),
			'pen_content_animation_reveal_override'                       => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Title Animation. */
				__( '%s Animation', 'pen' ),
				__( 'Content Area', 'pen' )
			),
			'pen_content_animation_delay_reveal_override'                 => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Title Animation Delay. */
				__( '%s Delay', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Content Title Animation. */
					__( '%s Animation', 'pen' ),
					__( 'Content Area', 'pen' )
				)
			),
			'pen_content_author_display_override'                         => __( 'Content Author', 'pen' ),
			'pen_content_date_display_override'                           => __( 'Content Date', 'pen' ),
			'pen_content_date_location_override'                          => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Author Location. */
				__( '%s Location', 'pen' ),
				__( 'Content Date', 'pen' )
			),
			'pen_content_footer_display_override'                         => __( 'Content Footer', 'pen' ),
			'pen_content_header_display_override'                         => __( 'Content Header', 'pen' ),
			'pen_content_tags_display_override'                           => __( 'Content Tags', 'pen' ),
			'pen_content_profile_display_override'                        => __( 'Author Profile', 'pen' ),
			'pen_content_author_location_override'                        => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Author Location. */
				__( '%s Location', 'pen' ),
				__( 'Author Link', 'pen' )
			),
			'pen_content_share_display_override'                          => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Author Location. */
				__( '%s Buttons', 'pen' ),
				_x( 'Share', 'noun', 'pen' )
			),
			'pen_content_share_location_override'                         => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Author Location. */
				__( '%s Location', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Content Author Location. */
					__( '%s Buttons', 'pen' ),
					_x( 'Share', 'noun', 'pen' )
				)
			),
			'pen_content_category_display_override'                       => sprintf(
				/* Translators: %s: Part of the theme, e.g. Category Links. */
				__( '%s Links', 'pen' ),
				__( 'Category', 'pen' )
			),
			'pen_content_category_location_override'                      => sprintf(
			/* Translators: %s: Part of the theme, e.g. Category Links Location. */
				__( '%s Location', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Category Links. */
					__( '%s Links', 'pen' ),
					__( 'Category', 'pen' )
				)
			),
			'pen_content_search_display_override'                         => __( 'Search box', 'pen' ),
			'pen_content_search_location_override'                        => sprintf(
				/* Translators: %s: Part of the theme, e.g. Category Links Location. */
				__( '%s Location', 'pen' ),
				__( 'Search box', 'pen' )
			),
			'pen_content_background_image_content_title_dynamic_override' => __( 'Featured Image As Title Background', 'pen' ),
			'pen_content_thumbnail_display_override'                      => __( 'Thumbnail', 'pen' ),
			'pen_color_content_thumbnail_frame_override'                  => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Title Color. */
				__( '%s Color', 'pen' ),
				__( 'Thumbnail Frame', 'pen' )
			),
			'pen_content_thumbnail_alignment_override'                    => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Title Alignment. */
				__( '%s Alignment', 'pen' ),
				__( 'Thumbnail', 'pen' )
			),
			'pen_content_thumbnail_animation_reveal_override'             => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Title Animation. */
				__( '%s Animation', 'pen' ),
				__( 'Thumbnail', 'pen' )
			),
			'pen_content_thumbnail_animation_delay_reveal_override'       => sprintf(
				/* Translators: %s: Part of the theme, e.g. Content Title Animation Delay. */
				__( '%s Delay', 'pen' ),
				sprintf(
					/* Translators: %s: Part of the theme, e.g. Content Title Animation. */
					__( '%s Animation', 'pen' ),
					__( 'Thumbnail', 'pen' )
				)
			),
			'pen_content_thumbnail_frame_override'                        => __( 'Thumbnail Frame', 'pen' ),
			'pen_content_thumbnail_resize_override'                       => __( 'Thumbnail Size', 'pen' ),
			'pen_content_thumbnail_rotate_override'                       => __( 'Thumbnail Rotate', 'pen' ),
		);

		$options_sidebar = array(
			'pen_sidebar_header_primary_display'   => sprintf(
				'%1$s - %2$s',
				__( 'Header', 'pen' ),
				__( 'Primary', 'pen' )
			),
			'pen_sidebar_header_secondary_display' => sprintf(
				'%1$s - %2$s',
				__( 'Header', 'pen' ),
				__( 'Secondary', 'pen' )
			),
			'pen_sidebar_search_top_display'       => sprintf(
				'%1$s - %2$s',
				__( 'Search', 'pen' ),
				__( 'Top', 'pen' )
			),
			'pen_sidebar_search_left_display'      => sprintf(
				'%1$s - %2$s',
				__( 'Search', 'pen' ),
				__( 'Left', 'pen' )
			),
			'pen_sidebar_search_right_display'     => sprintf(
				'%1$s - %2$s',
				__( 'Search', 'pen' ),
				__( 'Right', 'pen' )
			),
			'pen_sidebar_search_bottom_display'    => sprintf(
				'%1$s - %2$s',
				__( 'Search', 'pen' ),
				__( 'Bottom', 'pen' )
			),
			'pen_sidebar_top_display'              => __( 'Top', 'pen' ),
			'pen_sidebar_left_display'             => __( 'Left', 'pen' ),
			'pen_sidebar_right_display'            => __( 'Right', 'pen' ),
			'pen_sidebar_content_top_display'      => sprintf(
				'%1$s - %2$s',
				__( 'Content', 'pen' ),
				__( 'Top', 'pen' )
			),
			'pen_sidebar_content_bottom_display'   => sprintf(
				'%1$s - %2$s',
				__( 'Content', 'pen' ),
				__( 'Bottom', 'pen' )
			),
			'pen_sidebar_bottom_display'           => __( 'Bottom', 'pen' ),
			'pen_sidebar_footer_top_display'       => sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Top', 'pen' )
			),
			'pen_sidebar_footer_left_display'      => sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Left', 'pen' )
			),
			'pen_sidebar_footer_right_display'     => sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Right', 'pen' )
			),
			'pen_sidebar_footer_bottom_display'    => sprintf(
				'%1$s - %2$s',
				__( 'Footer', 'pen' ),
				__( 'Bottom', 'pen' )
			),
		);
		/* phpcs:enable */

		if ( ! $group || 'all' === $group ) {
			return array_merge( $options_list, $options_content, $options_sidebar );
		}

		if ( 'list' === $group ) {
			return $options_list;
		}

		if ( 'content' === $group ) {
			return $options_content;
		}

		if ( 'sidebar' === $group ) {
			return $options_sidebar;
		}

	}
}

if ( ! function_exists( 'pen_wp_image_sizes' ) ) {
	/**
	 * Get size information for all currently-registered image sizes.
	 * https://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
	 *
	 * @global $_wp_additional_image_sizes
	 * @uses   get_intermediate_image_sizes()
	 *
	 * @param bool $return_data Only return a data array.
	 *
	 * @since Pen 1.2.8
	 * @return array $sizes Data for all currently-registered image sizes.
	 */
	function pen_wp_image_sizes( $return_data = false ) {
		global $_wp_additional_image_sizes;

		$data = array();
		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ), true ) ) {
				$data[ $_size ]['width']  = (int) get_option( $_size . '_size_w' );
				$data[ $_size ]['height'] = (int) get_option( $_size . '_size_h' );
				$data[ $_size ]['crop']   = (bool) get_option( $_size . '_crop' );
			} elseif ( ! empty( $_wp_additional_image_sizes[ $_size ]['width'] ) ) {
				$data[ $_size ] = array(
					'width'  => (int) $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => 0,
					'crop'   => false,
				);
				if ( ! empty( $_wp_additional_image_sizes[ $_size ]['height'] ) ) {
					$data[ $_size ]['height'] = (int) $_wp_additional_image_sizes[ $_size ]['height'];
				}
				if ( ! empty( $_wp_additional_image_sizes[ $_size ]['crop'] ) ) {
					$data[ $_size ]['crop'] = (bool) $_wp_additional_image_sizes[ $_size ]['crop'];
				}
			}
		}
		if ( $return_data ) {
			return $data;
		}

		$list = array();
		foreach ( $data as $id => $size ) {
			if ( $size['height'] ) {
				$dimensions = sprintf(
					' - %1$sx%2$s',
					$size['width'],
					$size['height']
				);
			} else {
				$dimensions = sprintf(
					' - %1$s %2$spx',
					__( 'Maximum Width:', 'pen' ),
					$size['width']
				);
			}

			$list[ $id ] = esc_html(
				sprintf(
					'%1$s%2$s%3$s',
					$id,
					$dimensions,
					$size['crop'] ? sprintf( ' (%s)', __( 'Cropped', 'pen' ) ) : ''
				)
			);
		}
		return $list;
	}
}
