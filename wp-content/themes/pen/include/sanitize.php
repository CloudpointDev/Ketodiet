<?php
/**
 * Sanitization functions.
 *
 * @package Pen
 */

defined( 'ABSPATH' ) || die();

if ( ! function_exists( 'pen_sanitize_integer' ) ) {
	/**
	 * Sanitizes numbers.
	 *
	 * @param string $input The input integer.
	 *
	 * @since Pen 1.0.0
	 * @return integer
	 */
	function pen_sanitize_integer( $input ) {
		return (int) $input;
	}
}

if ( ! function_exists( 'pen_sanitize_string' ) ) {
	/**
	 * Sanitizes strings.
	 *
	 * @param string $input The input string.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_string( $input ) {
		return wp_kses( $input, wp_kses_allowed_html( 'post' ) );
	}
}

if ( ! function_exists( 'pen_sanitize_url' ) ) {
	/**
	 * Sanitizes URLs.
	 *
	 * @param string $input The input URL.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_url( $input ) {
		return esc_url( $input );
	}
}

if ( ! function_exists( 'pen_sanitize_boolean' ) ) {
	/**
	 * Sanitizes booleans.
	 *
	 * @param boolean $input The input boolean.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_boolean( $input ) {
		if ( is_bool( $input ) || in_array( (int) $input, array( 0, 1 ), true ) ) {
			return $input;
		}
		return false;
	}
}

if ( ! function_exists( 'pen_sanitize_color' ) ) {
	/**
	 * Sanitizes HEX and RGBA colors.
	 *
	 * @param string $input The color code.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_color( $input ) {
		$input = str_replace( array( '#', ' ' ), '', strtolower( trim( $input ) ) );
		if ( 3 === strlen( $input ) ) {
			$input = $input . $input;
		} elseif ( false !== strpos( $input, 'rgb(' ) ) {
			$input = str_ireplace( array( 'rgb(', ')' ), array( 'rgba(', ',1)' ), $input );
		}
		if ( false !== strpos( $input, 'rgba(' ) && preg_match( '/\A^rgba\(([0]*[0-9]{1,2}|[1][0-9]{2}|[2][0-4][0-9]|[2][5][0-5])\s*,\s*([0]*[0-9]{1,2}|[1][0-9]{2}|[2][0-4][0-9]|[2][5][0-5])\s*,\s*([0]*[0-9]{1,2}|[1][0-9]{2}|[2][0-4][0-9]|[2][5][0-5])\s*,\s*([0-9]*\.?[0-9]+)\)$\z/im', $input ) ) {
			return $input;
		} elseif ( preg_match( '/^[a-f0-9]{6}$/i', $input ) ) {
			return '#' . $input;
		}
		return '#ffffff';
	}
}

if ( ! function_exists( 'pen_sanitize_logo_size' ) ) {
	/**
	 * Sanitizes the logo size option.
	 *
	 * @param string $input The logo source.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_logo_size( $input ) {
		if ( in_array( (string) $input, array( 'none', 'height', 'width' ), true ) ) {
			return $input;
		}
		return 'none';
	}
}

if ( ! function_exists( 'pen_sanitize_list_effect' ) ) {
	/**
	 * Sanitizes the content list effects.
	 *
	 * @param string $input The content list type.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_list_effect( $input ) {
		if ( in_array( (string) $input, array( 'none', 'enlarge', 'fade', 'enlarge_fade' ), true ) ) {
			return $input;
		}
		return 'none';
	}
}

if ( ! function_exists( 'pen_sanitize_masonry_thumbnail' ) ) {
	/**
	 * Sanitizes the masonry thumbnail image effect option.
	 *
	 * @param string $input The search box display.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_masonry_thumbnail( $input ) {
		if ( in_array( (string) $input, array( 'none', 'zoom_in', 'zoom_out' ), true ) ) {
			return $input;
		}
		return 'none';
	}
}

if ( ! function_exists( 'pen_sanitize_masonry_columns' ) ) {
	/**
	 * Sanitizes the masonry columns option.
	 *
	 * @param string $input The content list type.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_masonry_columns( $input ) {
		if ( 'automatic' === $input || ( 1 < $input && 5 >= $input ) ) {
			return $input;
		}
		return 'automatic';
	}
}

if ( ! function_exists( 'pen_sanitize_thumbnail_resize' ) ) {
	/**
	 * Sanitizes the post thumbnail size option.
	 *
	 * @param string $input The post thumbnail size.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_thumbnail_resize( $input ) {
		/* phpcs:disable */
		if ( 'none' === $input || in_array( (string) $input, get_intermediate_image_sizes(), true ) ) {
			return $input;
		}
		/* phpcs:enable */
		return 'none';
	}
}

if ( ! function_exists( 'pen_sanitize_list_type' ) ) {
	/**
	 * Sanitizes the content list types.
	 *
	 * @param string $input The content list type.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_list_type( $input ) {
		if ( in_array( (string) $input, array( 'masonry', 'plain' ), true ) ) {
			return $input;
		}
		return '';
	}
}

if ( ! function_exists( 'pen_sanitize_site_width' ) ) {
	/**
	 * Sanitizes the layout type.
	 *
	 * @param string $input The content area layout.
	 *
	 * @since Pen 1.0.2
	 * @return string
	 */
	function pen_sanitize_site_width( $input ) {
		// 'default' === 'standard' (Content Meta).
		if ( in_array( (string) $input, array( 'default', 'standard', 'wide', 'boxed' ), true ) ) {
			return $input;
		}
		return 'default';
	}
}

if ( ! function_exists( 'pen_sanitize_location' ) ) {
	/**
	 * Sanitizes the element location option.
	 *
	 * @param string $input The content area layout.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_location( $input ) {
		if ( in_array( (string) $input, array( 'header', 'content', 'footer' ), true ) ) {
			return $input;
		}
		return 'header';
	}
}

if ( ! function_exists( 'pen_sanitize_alignment' ) ) {
	/**
	 * Sanitizes the alignment option.
	 *
	 * @param string $input The "alignment" option.
	 *
	 * @since Pen 1.0.4
	 * @return string
	 */
	function pen_sanitize_alignment( $input ) {
		if ( in_array( (string) $input, array( 'left', 'center', 'right' ), true ) ) {
			return $input;
		}
		return 'left';
	}
}

if ( ! function_exists( 'pen_sanitize_font_family' ) ) {
	/**
	 * Sanitizes font families.
	 *
	 * @param string $input The font size.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_font_family( $input ) {
		$fonts = pen_fonts_all();
		if ( 'default' === $input || array_key_exists( $input, $fonts ) ) {
			return $input;
		}
		return 'default';
	}
}

if ( ! function_exists( 'pen_sanitize_font_size' ) ) {
	/**
	 * Sanitizes font sizes.
	 *
	 * @param string $input The font size.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_sanitize_font_size( $input ) {
		if ( in_array( (string) $input, array( 'default', '0.5em', '0.75em', 'normal', '2em', '3em' ), true ) ) {
			return $input;
		}
		return 'default';
	}
}

if ( ! function_exists( 'pen_sanitize_animation' ) ) {
	/**
	 * Sanitizes animations.
	 *
	 * @param string $input The animation effect ID.
	 *
	 * @since Pen 1.0.8
	 * @return string
	 */
	function pen_sanitize_animation( $input ) {
		$animations_available = pen_animations();
		if ( isset( $animations_available[ $input ] ) ) {
			return $input;
		}
		return 'none';
	}
}
