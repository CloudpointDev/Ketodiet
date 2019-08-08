<?php
/**
 * Compression functions.
 *
 * @package Pen
 */

if ( ! function_exists( 'pen_compress_css' ) ) {
	/**
	 * Removes empty lines and white space from CSS.
	 *
	 * @param string $input The input CSS.
	 *
	 * @since Pen 1.0.0
	 * @return string
	 */
	function pen_compress_css( $input ) {
		// Removes blank lines.
		$output = preg_replace( '/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/', "\n", trim( $input ) );
		// Removes comments.
		$output = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $output );
		// Removes indentation.
		$trimmed = array();
		$output  = explode( "\n", $output );
		foreach ( $output as $output ) {
			$trimmed[] = trim( $output );
		}
		$output  = implode( $trimmed );
		$search  = array( '{ ', ' }', '; ', ', ', ' {', '} ', ': ', ' ,', ' ;', ';}' );
		$replace = array( '{', '}', ';', ',', '{', '}', ':', ',', ';', '}' );
		$output  = str_replace( $search, $replace, $output );
		return $output;
	}
}
