/**
 * Front-end JavaScript.
 *
 * @package Pen
 */
;( function( $ ) {

	"use strict";

	$( 'html' ).removeClass( 'no-js' ).addClass( 'js' );

	var $page = $( '#page' );

	$( document ).ready(
		function() {

			pen_trianglify();
			pen_shards();

			if ( pen_function_exists( typeof Modernizr ) && Modernizr.mq( 'only all and (max-width:728px)' ) ) {
				if ( pen_function_exists( typeof $( window ).fitText ) && pen_js.font_resize.site_title === 'dynamic' ) {
					$( '#site-title' ).fitText();
				}
				if ( pen_js.font_resize.site_title === 'resize' ) {
					function pen_font_resize( $element, font_size ) {
						var parent_width = $element.parent().outerWidth( false ),
						element_width    = $element.css( { position: 'fixed', whiteSspace: 'nowrap' } ).outerWidth( true );
						$element.css( { position: 'relative' } );
						font_size = font_size - 2;
						if ( font_size > 12 && element_width > parent_width ) {
							$element.animate( { fontSize: font_size } );
							pen_font_resize( $element, font_size );
						}
					}
					var $site_title = $( '#pen_header h1 a .site-title' );
					pen_font_resize( $site_title, parseInt( $site_title.css( 'font-size' ) ) );
					$( window ).resize(
						function() {
							if ( pen_function_exists( typeof Modernizr ) && Modernizr.mq( 'only all and (max-width:728px)' ) ) {
								pen_font_resize( $site_title, parseInt( $site_title.css( 'font-size' ) ) );
							} else {
								$site_title.css( { fontSize: '' } );
							}
						}
					);
				}
			}

			if ( pen_function_exists( typeof autosize ) ) {
				autosize( $page.find( 'textarea' ) );
			}

			if ( $( 'div#primary-menu' ).length ) {
				var $menu = $( 'div#primary-menu > ul' );
			} else if ( $( 'ul#primary-menu' ).length ) {
				var $menu = $( 'ul#primary-menu' );
			} else {
				var $menu = false;
			}
			if ( $menu ) {
				if ( pen_function_exists( typeof $( window ).superfish ) ) {
					$menu.superfish(
						{
							animation: pen_js.navigation_easing,
							speed: parseInt( pen_js.animation_navigation_speed ),
							cssArrows: pen_js.navigation_arrows
						}
					);
				}

				if ( pen_js.navigation_mobile && pen_function_exists( typeof Modernizr ) && Modernizr.mq( 'only all and (max-width:1024px)' ) ) {
					pen_navigation_mobile( $menu );
				}

				function pen_navigation_mobile( $menu ) {
					var $menu_mobile = $menu.clone(), /* $menu is a <ul> */
					$navigation = $menu.closest( 'nav' );

					$menu_mobile.attr( 'id', 'primary-menu-mobile' )
					.removeClass( function ( index, css ) {
						return ( css.match( /(^|\s)sf-\S+/g ) || [] ).join( ' ' );
					} )
					.find( '*' ).each( function() {
						$( this ).removeClass( function ( index, css ) {
							return ( css.match( /(^|\s)sf-\S+/g ) || [] ).join( ' ' );
						} );
					} )
					.end()
					.addClass( 'screen-reader-text pen_collapsed' ).attr( 'aria-hidden', 'true' )
					.find( 'li ul' )
					.addClass( 'screen-reader-text pen_collapsed' ).attr( 'aria-hidden', 'true' );

					$page.prepend( '<div id="pen_navigation_mobile" />' )
					.children( '#pen_navigation_mobile' )
					.addClass( 'pen_collapsed' )
					.prepend( '<nav role="navigation" />' )
					.children( 'nav' )
					.attr( 'class', $navigation.attr( 'class' ) )
					.attr( 'aria-label', $navigation.attr( 'aria-label' ) )
					.prepend( $menu_mobile )
					.prepend( '<a id="pen_navigation_mobile_toggle" href="' + pen_js.url_home + '"><span class="pen_text">' + pen_js.text.menu + '</span><span class="pen_icon"><span></span><span></span><span></span><span></span></span></a>' );

					$navigation.fadeOut( 100 ).remove();

					$( '#pen_navigation_mobile_toggle' ).on( 'click', function( event ) {
						if ( $menu_mobile.hasClass( 'pen_collapsed' ) ) {
							$( this ).addClass( 'pen_active' );
							$menu_mobile.hide()
							.removeClass( 'pen_collapsed screen-reader-text' )
							.addClass( 'pen_expanded' )
							.stop()
							.animate( pen_js.navigation_easing, pen_js.animation_navigation_speed )
							.attr( 'aria-hidden', 'false' );
							$( '#pen_navigation_mobile' ).addClass( 'pen_expanded' ).removeClass( 'pen_collapsed' );
							$page.children( '.pen_wrapper' ).fadeOut( 200, function() { $( this ).addClass( 'screen-reader-text' ).show(); }
							);
						} else {
							$( this ).removeClass( 'pen_active' );
							$menu_mobile
							.stop()
							.animate( { height: 'hide' }, pen_js.animation_navigation_speed, function() {
								$( this )
								.removeClass( 'pen_expanded' )
								.addClass( 'pen_collapsed screen-reader-text' ).show()
								.attr( 'aria-hidden', 'true' );
							} );
							$( '#pen_navigation_mobile' ).removeClass( 'pen_expanded' ).addClass( 'pen_collapsed' );
							$page.children( '.pen_wrapper' ).hide().removeClass( 'screen-reader-text' ).fadeIn( 200 );
						}
						event.preventDefault();
					} );

					$menu_mobile.find( 'a' ).each( function() {
						var $link = $( this ),
						$parent = $link.closest( 'li' ),
						$child = $parent.children( 'ul' );
						if ( $child.length ) {
							if ( $parent.children( 'a' ).attr( 'href' ) !== '#' ) {
								$child.prepend( $( '<li />' ).prepend( $parent.children( 'a' ).clone() ) );
							}
							$parent.addClass( 'pen_parent pen_collapsed' );
							$link.on( 'click', function( event ) {
								if ( $parent.hasClass( 'pen_collapsed' ) ) {
									$parent.addClass( 'pen_expanded' ).removeClass( 'pen_collapsed' );
									$child.hide()
									.removeClass( 'pen_collapsed screen-reader-text' )
									.addClass( 'pen_expanded' )
									.stop()
									.animate( pen_js.navigation_easing, pen_js.animation_navigation_speed )
									.attr( 'aria-hidden', 'false' );
								} else {
									$parent.addClass( 'pen_collapsed' ).removeClass( 'pen_expanded' );
									$child.hide()
									.removeClass( 'pen_expanded screen-reader-text' )
									.addClass( 'pen_collapsed' )
									.stop()
									.animate( { height: 'hide' }, pen_js.animation_navigation_speed )
									.attr( 'aria-hidden', 'false' );
								}
								event.preventDefault();
							} );
						}
					} );
				}
			}

			$( '.search-form' ).on(
				'submit',
				function( event ) {
					var $search = $( this );
					if ( pen_text_trim( $search.find( '.search-field' ).val() ) === '' ) {
						alert( pen_js.text.enter_keyword );
						event.preventDefault();
					}
				}
			);

			if ( '.pen_options_overview' ) {
				$( '#primary' ).find( '.pen_options_overview' ).each(
					function() {
						var $overview = $( this );
						if ( $( 'body' ).hasClass( 'pen_singular' ) ) {
							$page.append( $overview );
						}
						var overview_id = $overview.attr( 'id' ),
						toggle_id = overview_id + '_toggle';
						$overview.addClass( 'pen_off_screen' )
						.prepend( '<a href="#" class="pen_close">' + pen_js.text.close + '</a>' )
						.before( '<a href="#" id="' + toggle_id + '" class="pen_options_overview_toggle pen_button pen_visible" title="' + pen_js.text.overview_options_post + '">' + pen_js.text.overview_options_post + '</a>' )
						.find( '.pen_close' ).on(
							'click',
							function( event ) {
								$( '#' + toggle_id ).toggleClass( 'pen_visible' );
								$overview.toggleClass( 'pen_visible' );
								event.preventDefault();
							}
						);
						$( '#' + toggle_id ).on(
							'click',
							function( event ) {
								$( this ).toggleClass( 'pen_visible' );
								$overview.toggleClass( 'pen_visible' );
								event.preventDefault();
							}
						);
					}
				);
			}

			$( '#pen_back' ).hide().on(
				'click',
				function ( event ) {
					$( 'html, body' ).animate( { scrollTop: 0 }, { queue: false, duration: 1000 } );
					event.preventDefault();
				}
			);

			pen_sticky_header();

		}
	);

	$( window ).load(
		function() {
			var $main = $( '#main' );

			if ( $page.children( '.pen_wrapper' ).length ) {
				$page.children( '.pen_loading' ).fadeOut(
					100,
					function() {
						$page.children( '.pen_wrapper' ).css( { display: 'none', visibility: 'visible' } ).fadeIn( 100 );
						$( this ).remove();
					}
				);
			}

			var $list = $( '#pen_masonry' );
			if ( $list.length ) {
				if ( pen_js.list_type === 'masonry' && pen_function_exists( typeof jQuery( window ).masonry ) ) {
					$list.masonry(
						{
							itemSelector: '.pen_article',
							percentPosition: true,
							transitionDuration: 0
						}
					).imagesLoaded(
						function() {
							$list.masonry( 'layout' );
							$page.pen_content_height();
							if ( pen_function_exists( typeof pen_animation ) ) {
								var $items  = $main.find( '.pen_article' ),
								$thumbnails = $main.find( '.pen_image_thumbnail' );
								pen_animation( $items, pen_js.animation_list );
								pen_animation( $thumbnails, pen_js.animation_list_thumbnails );
							}
						}
					);
					setTimeout(
						function() {
							$list.masonry( 'layout' );
							$page.pen_content_height();
						},
						5000
					);
				}
			} else {
				if ( pen_function_exists( typeof pen_animation ) ) {
					var $thumbnails = $main.find( '.pen_image_thumbnail' );
					if ( $( 'body' ).hasClass( 'pen_multiple' ) ) {
						var $items = $main.find( '.pen_article' );
						pen_animation( $items, pen_js.animation_list );
						pen_animation( $thumbnails, pen_js.animation_list_thumbnails );
					} else {
						pen_animation( $main, pen_js.animation_content );
						pen_animation( $thumbnails, pen_js.animation_content_thumbnails );
					}
				}
			}

			if ( pen_js.animation_comments ) {
				var $comments = $( '#comments .comment-list' );
				if ( $comments.length ) {
					$comments.children( 'li' )
					.addClass( 'pen_animate_on_scroll pen_custom_animation_' + pen_js.animation_comments );
					if ( pen_js.animation_delay_comments ) {
						$comments.children( 'li' ).attr( 'delay', pen_js.animation_delay_comments );
					}
				}
			}

			pen_animation( $page.find( '.pen_animate_on_scroll' ), 'automatic' );

			$page.pen_content_height();

			$page.find( '.pen_jump_menu' ).each(
				function() {
					pen_jump_menu( $( this ) );
				}
			);

		}
	);

	$( window ).on(
		'resize orientationchange',
		function() {
			$( '#main' ).find( '.pen_article.animated' ).removeClass( 'animated' ).addClass( 'animated_not' );
			$page.pen_content_height();
		}
	);

	$( window ).scroll(
		function() {
			$( '#main' ).find( '.pen_article.animated_not' ).removeClass( 'animated_not' ).addClass( 'animated' );

			if ( $( this ).scrollTop() > 400 ) {
				$( '#pen_back' ).fadeIn( 200 );
			} else {
				$( '#pen_back' ).fadeOut( 200 );
			}
		}
	);

	function pen_sticky_header() {
		if ( pen_js.header_sticky && $( '#pen_header' ).length && ! $( 'body' ).hasClass( 'pen_site_header_hide' ) ) {
			var mobile   = false,
			$window      = $( window ),
			$body        = $( 'body' ),
			layout_boxed = $body.hasClass( 'pen_width_boxed' ) ? true : false,
			$header      = $( '#pen_header' );
			if ( pen_function_exists( typeof Modernizr ) && Modernizr.mq( 'only all and (max-width:728px)' ) ) {
				mobile = true;
			}
			$window.resize(
				function() {
					if ( pen_function_exists( typeof Modernizr ) && Modernizr.mq( 'only all and (max-width:728px)' ) ) {
						mobile = true;
					} else {
						mobile = false;
					}
				}
			);
			$window.on(
				'load scroll resize orientationchange pen_update_sticky_header',
				function() {
					if ( layout_boxed ) {
						$header.css( { width: $( '#pen_section' ).outerWidth( true ) } );
					}
					if ( mobile || $window.outerHeight() < $header.outerHeight( true ) ) {
						$header.removeClass( 'pen_header_sticked' ).css( { left: '', position: '', top: '' } );
						$body.removeClass( 'pen_header_sticked' ).css( { paddingTop: '' } );
					} else {
						var header_top = 0,
						header_height  = $header.removeClass( 'pen_header_sticked' ).outerHeight( true );
						if ( $( '#wpadminbar' ).length ) {
							var adminBarheight = $( '#wpadminbar' ).outerHeight( true );
							header_height     += adminBarheight;
							header_top        += adminBarheight;
						}
						if ( $window.scrollTop() ) {
							var header_offset = $header.offset();
							$header.css( { left: header_offset.left, position: 'fixed', top: header_top } ).addClass( 'pen_header_sticked' );
							$body.addClass( 'pen_header_sticked' ).css( { paddingTop: header_height + 20 } );
						} else {
							$header.css( { left: '', position: '', top: '' } ).removeClass( 'pen_header_sticked' );
							$body.removeClass( 'pen_header_sticked' ).css( { paddingTop: '' } );
						}
					}
				}
			);
		}
	}

	$.fn.extend(
		{
			pen_content_height: function() {
				if ( pen_function_exists( typeof Modernizr ) && Modernizr.mq( 'only all and (max-width:728px)' ) ) {
					return;
				}
				var leftHeight = 0,
				rightHeight    = 0,
				$content       = jQuery( '#content' ),
				$left          = jQuery( '#pen_left' ),
				$right         = jQuery( '#pen_right' );
				if ( $left.length ) {
					leftHeight = $left.outerHeight( true );
				}
				if ( $right.length ) {
					rightHeight = $right.outerHeight( true );
				}
				var contentHeight = Math.max( leftHeight, rightHeight );
				if ( contentHeight ) {
					contentHeight += parseInt( $content.css( 'padding-bottom' ) );
					$content.css( 'min-height', contentHeight + 30 );
				}
			}
		}
	);

})( jQuery );

function pen_animation( $items, animation ) {
	if ( pen_function_exists( typeof jQuery( window ).waypoint ) && animation ) {
		$items.addClass( 'animated' ).css( 'visibility', 'hidden' ).waypoint(
			{
				handler: function( direction ) {
					var timer,
					$item = jQuery( this.element ),
					add_animation = '';

					var animation_delay = 0,
					custom_animation_delay = this.element.className.match( /(^|\s)pen_custom_animation_delay_\S+/g );
					if ( custom_animation_delay && custom_animation_delay[0] ) {
						animation_delay = ( 1000 * parseInt( jQuery.trim( custom_animation_delay[0].replace( 'pen_custom_animation_delay_', '' ) ) ) );
					}

					var custom_animation = this.element.className.match( /(^|\s)pen_custom_animation_\S+/g );
					if ( custom_animation && custom_animation[0] ) {
						add_animation = jQuery.trim( custom_animation[0].replace( 'pen_custom_animation_', '' ) );
					} else {
						add_animation = animation;
					}

					timer = setTimeout( function() {
						if ( ! $item.hasClass( add_animation ) ) {
							$item.addClass( add_animation ).css( 'visibility', 'visible' );
						}
					}, animation_delay ? animation_delay : 1 );

				},
				offset: '90%'
			}
		);
	}
}

function pen_shards() {
	if ( pen_function_exists( typeof jQuery( window ).shards ) ) {
		var $body        = jQuery( 'body' ),
		background_image = $body.css( 'background-image' );
		if ( pen_js.shards_colors && background_image && background_image === 'none' ) {
			$body.prepend( '<div id="shards" style="left:0;height:100%;position:fixed;top:0;visibility:hidden;width:100%;" />' );
			var $shards = jQuery( '#shards' );
			$shards.shards( pen_js.shards_colors[0], pen_js.shards_colors[1], [0,0,0,0.2], 20, .8, 2, .15, true );
			var background = $shards.css( 'background-image' );
			$shards.remove();
			jQuery( 'body' ).addClass( 'pen_shards' ).removeClass( 'custom-background' );
			jQuery( 'head' ).append( "<style type=\"text/css\">body.pen_shards:before{background-image:" + background + " !important;content:'';left:0;height:100%;position:fixed;top:0;width:100%;will-change:transform;z-index:-1; }</style>" );
		}
	}
}

function pen_trianglify() {
	if ( pen_function_exists( typeof Trianglify ) ) {
		var $body        = jQuery( 'body' ),
		background_image = $body.css( 'background-image' );
		if ( pen_js.trianglify_colors && background_image && background_image === 'none' ) {
			var pattern = Trianglify(
				{
					height: window.innerHeight,
					width: window.innerWidth,
					x_colors: pen_js.trianglify_colors,
					y_colors: 'match_x',
					cell_size: 80
				}
			);
			var svg     = jQuery( '<div />' ).prepend( pattern.svg() ).html();
			svg         = '<?xml version="1.0" ?>' + svg.replace( '<svg', '<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"' );
			var dataURI = "data:image/svg+xml;base64, " + window.btoa( unescape( encodeURIComponent( svg ) ) );
			jQuery( 'body' ).addClass( 'pen_trianglify' ).removeClass( 'custom-background' );
			jQuery( 'head' ).append( "<style type=\"text/css\">body.pen_trianglify:before{background-image:url('" + dataURI + "') !important;background-size:cover;content:'';left:0;height:100%;position:fixed;top:0;width:100%;will-change:transform;z-index:-1; }</style>" );
		}
	}
}

function pen_jump_menu( $menu ) {
	var title = jQuery.trim( $menu.find( 'h4' ).attr( 'title' ) );
	$menu.prepend( '<button type="button" class="pen_toggle" title="' + title + '"><span class="screen-reader-text">' + pen_js.text.expand_collapse + '</span></button>' )
	.find( '.pen_menu_wrapper' ).attr( 'aria-hidden', true )
	.end().removeClass( 'screen-reader-text' ).attr( 'aria-hidden', false )
	.find( 'h4 span' ).prepend( '<span class="pen_only" title="' + pen_js.text.theme_specific + '">' + pen_js.text.pen_theme + '</span>&nbsp;' );
	var $toggle = $menu.find( '.pen_toggle' ),
	timer;
	$menu.find( 'ul li a' ).each(
		function() {
			jQuery( this ).attr( 'title', jQuery.trim( jQuery( this ).text() ) ).attr( 'tabindex', '-1' );
		}
	);
	$toggle.on(
		'click',
		function( event ) {
			var $wrapper = jQuery( '.pen_menu_wrapper', $menu );
			clearTimeout( timer );
			if ( $toggle.hasClass( 'pen_expanded' ) ) {
				$toggle.removeClass( 'pen_expanded' );
				$wrapper.addClass( 'screen-reader-text' ).attr( 'aria-hidden', true )
				.find( 'ul li a' ).attr( 'tabindex', '-1' );
			} else {
				$toggle.addClass( 'pen_expanded' );
				$wrapper.find( 'ul li a' ).removeAttr( 'tabindex' )
				.end().removeClass( 'screen-reader-text' ).attr( 'aria-hidden', false )
				.on(
					'mouseleave',
					function() {
						clearTimeout( timer );
						timer = setTimeout(
							function() {
								$wrapper.stop().animate(
									{ opacity: 0 },
									{
										duration: 2000,
										queue: false,
										complete: function() {
											 $toggle.trigger( 'click' );
										}
									}
								);
							},
							30000
						);
					}
				).on(
					'mouseenter',
					function() {
						$wrapper.stop().animate( { opacity: 1 }, { duration: 200, queue: false } );
						clearTimeout( timer );
					}
				);
			}
			event.preventDefault();
		}
	);
}

function pen_function_exists( type_of ) {
	if ( type_of !== 'undefined' && type_of !== undefined && type_of !== null ) {
		return true;
	}
	return false;
}

function pen_text_trim( input ) {
	if ( ! input ) {
		return input;
	}
	var output = jQuery.trim( input.replace( /\s/g, ' ' ) );
	return output;
}
