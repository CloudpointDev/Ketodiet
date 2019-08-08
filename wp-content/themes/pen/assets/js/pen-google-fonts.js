/**
 * Google Fonts.
 *
 * @package Pen
 */
;( function( $ ) {
	"use strict";
	$( document ).ready(
		function() {
			if ( pen_googlefonts.families.length && pen_function_exists( typeof WebFont ) ) {
				WebFont.load( { google: { families: pen_googlefonts.families } } );
			}
		} );
})( jQuery );

function pen_function_exists( type_of ) {
	if ( type_of !== 'undefined' && type_of !== undefined && type_of !== null ) {
		return true;
	}
	return false;
}
