/**
 * WooCommerce JavaScript.
 *
 * @package Pen
 */
;( function( $ ) {

	"use strict";

	var $page = $( '#page' );

	$( document ).ready(
		function() {

			pen_trianglify();
			pen_shards();

			pen_cart_header();

			function pen_cart_header() {
				if ( $( '#pen_cart_header' ).length ) {
					var $header_cart = $( '#pen_cart_header' ),
					$cart_heading = $header_cart.find( 'a.cart-contents' ),
					$cart_content = $header_cart.find( '.pen_cart_content' );
					if ( pen_woocommerce_js.is_customize_preview ) {
						/* There seems to be no other way to make customizer respect the event.preventDefault() etc. */
						$cart_heading.attr( 'href', '#' );
					}
					if ( ! $cart_heading.hasClass( 'pen_processed' ) ) {
						$cart_heading.addClass( 'pen_processed' );
						$cart_heading.on( 'click', function( event ) {
							if ( $( '.widget_shopping_cart_content', $cart_content ).children().length ) {
								var $this = $( this );
								if ( ! $this.hasClass( 'pen_active' ) ) {
									$this.addClass( 'pen_active' );
									$cart_content.removeClass( 'screen-reader-text' );
								} else {
									$this.removeClass( 'pen_active' );
									$cart_content.addClass( 'screen-reader-text' );
								}
								event.preventDefault();
							}
						} );
					}
				}
			}

		}
	);

})( jQuery );
