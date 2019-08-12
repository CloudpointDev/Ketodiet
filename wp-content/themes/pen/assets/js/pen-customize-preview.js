/**
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @package Pen
 */

;( function( $ ) {
	function pen_element_header() {
		return $( '#pen_header .pen_header_inner' );
	}
	function pen_element_header_main() {
		return $( '#pen_header .pen_header_main' );
	}
	function pen_element_header_links() {
		return pen_element_header_main().find( 'a:not(a#site-title,.pen_phone a)' );
	}
	function pen_element_header_logo() {
		return $( '#pen_header h1 .custom-logo-link' );
	}
	function pen_element_header_sitetitle() {
		return $( '#pen_header h1 a .site-title' );
	}
	function pen_element_header_sitedescription() {
		return $( '#pen_header h1 a .site-description' );
	}
	function pen_element_header_fields() {
		return $( '#pen_header .pen_header_main .search-form .search-field' );
	}
	function pen_element_phone() {
		return $( '.pen_phone' );
	}
	function pen_element_navigation() {
		return $( '#pen_navigation' );
	}
	function pen_element_navigation_submenu() {
		return $( '#pen_navigation ul ul' );
	}
	function pen_element_navigation_links() {
		return $( '#pen_navigation #primary-menu > ul > li > a,#pen_navigation ul.menu > li > a' );
	}
	function pen_element_navigation_links_submenu() {
		return $( '#pen_navigation li li a' );
	}
	function pen_element_search_bar() {
		return $( '#pen_search' );
	}
	function pen_element_search_bar_links() {
		return $( '#pen_search a' );
	}
	function pen_element_search_bar_field() {
		return $( '#pen_search .search-form .search-field' );
	}
	function pen_element_content() {
		return $( '#main .pen_article,body.pen_list_masonry #pen_masonry .pen_article,#comments,body.pen_list_plain #pen_pager' );
	}
	function pen_element_content_title() {
		return $( '#main .pen_article header' );
	}
	function pen_element_content_title_link() {
		return $( '#main .pen_article header a' );
	}
	function pen_element_content_links() {
		return $( '#primary a:not(.pen_tabs a,header a)' );
	}
	function pen_element_content_fields() {
		return $( '#main input:not([type="button"],[type="submit"]), #main select, #main textarea' );
	}
	function pen_element_content_fields_option() {
		return $( '#main option' );
	}
	function pen_element_bottom() {
		return $( '#pen_bottom' );
	}
	function pen_element_bottom_headings() {
		return $( '#pen_bottom .pen_widget_transparent h3,#bottom .pen_widget_transparent h4,#bottom .pen_widget_transparent h5' );
	}
	function pen_element_bottom_links() {
		return $( '#pen_bottom a' );
	}
	function pen_element_bottom_fields() {
		return $( '#pen_bottom input:not([type="button"],[type="submit"]),#pen_bottom option,#pen_bottom select,#pen_bottom textarea' );
	}
	function pen_element_footer() {
		return $( '#pen_footer' );
	}
	function pen_element_go_to_top() {
		return $( 'a#pen_back' );
	}
	function pen_element_footer_menu() {
		return $( '#pen_footer_menu' );
	}
	function pen_element_footer_copyright() {
		return $( '#pen_footer .site-info' );
	}
	function pen_element_footer_links() {
		return $( '#pen_footer a' );
	}
	function pen_css_background_gradient( color_primary, color_secondary, direction ) {
		return 'linear-gradient(' + direction + ', ' + color_primary + ' 0%, ' + color_secondary + ' 100%';
	}
	function pen_apply_link_color( $element, link_color, link_color_hover ) {
		$element.css(
			{
				color: link_color
			}
		)
		.off( 'mouseenter mouseleave' )
		.on(
			'mouseenter',
			function() {
				$( this ).css(
					{
						color: link_color_hover
					}
				);
			}
		)
		.on(
			'mouseleave',
			function() {
				$( this ).css(
					{
						color: link_color
					}
				);
			}
		);
	}
	function pen_option_get( option ) {
		var preset = ( option.substr( 0, 5 ) === 'color' ) ? pen_preview_js.preset_color : 'preset_1', /* Packaging Difference. */
		element    = wp.customize( 'pen_' + option + '[' + preset + ']' );
		if ( element === 'undefined' || element === undefined || element === null ) {
			console.log( option );
		}
		return wp.customize( 'pen_' + option + '[' + preset + ']' )();
	}

	/**
	 * After each page load.
	 */
	wp.customize.bind(
		'preview-ready',
		function() {

			$( '#page' ).find( 'a.pen_customizer_shortcut' ).each(
				function() {
					$( this ).on(
						'click',
						function( event ) {
							var data = $( this ).data();
							wp.customize.preview.send( 'pen_switch_section', { type: data.type, target: data.target } );
							event.preventDefault();
						}
					);
				}
			);

			wp.customize.preview.bind(
				'pen_section_change',
				function( data ) {
					if ( $( data.selector ).length ) {
						var element_offset = $( data.selector ).offset().top;
						if ( $( 'body' ).hasClass( 'pen_header_sticky' ) ) {
							element_offset -= $( '#pen_header' ).outerHeight( true );
						}
						element_offset -= 200;
						$( 'html, body' ).stop().animate( { scrollTop: element_offset }, 500 );
					}
				}
			);

			/**
			 * Logo.
			 */
			var pen_logo_source = pen_element_header_logo().find( 'img' ).attr( 'src' );
			if ( pen_logo_source === 'undefined' || pen_logo_source === undefined || pen_logo_source === null ) {
				$( '#pen_header' ).removeClass( 'pen_logo_show' );
			} else {
				$( '#pen_header' ).addClass( 'pen_logo_show' );
			}

			/**
			 * General.
			 */
			$( 'body' ).css(
				{
					backgroundColor: pen_option_get( 'color_site_background' )
				}
			);

			/**
			 * Layout
			 */
			$( 'body' ).removeClass(
				function( index, css ) {
					return ( css.match( /(^|\s)pen_main_container_\S+/g ) || [] ).join( ' ' );
				}
			).addClass( 'pen_main_container_' + pen_option_get( 'container_position' ) );

			/**
			 * Header.
			 */
			$( 'body' ).removeClass(
				function( index, css ) {
					return ( css.match( /(^|\s)pen_header_alignment_\S+/g ) || [] ).join( ' ' );
				}
			).addClass( 'pen_header_alignment_' + pen_option_get( 'header_alignment' ) );
			pen_element_header_main().css(
				{
					color: pen_option_get( 'color_header_text' ),
					textShadow: ( ! pen_option_get( 'color_header_text_shadow_display' ) ) ? 'none' : '1px 1px 1px ' + pen_option_get( 'color_header_text_shadow' )
				}
			);
			pen_apply_link_color( pen_element_header_links(), pen_option_get( 'color_header_link' ), pen_option_get( 'color_header_link_hover' ) );
			pen_apply_link_color( pen_element_header_sitetitle(), pen_option_get( 'color_header_sitetitle' ), pen_option_get( 'color_header_sitetitle_hover' ) );
			pen_apply_link_color( pen_element_header_sitedescription(), pen_option_get( 'color_header_sitedescription' ), pen_option_get( 'color_header_sitedescription_hover' ) );
			pen_apply_link_color( pen_element_header().find( pen_element_phone() ).children( 'a' ), pen_option_get( 'color_header_phone' ), pen_option_get( 'color_header_phone_hover' ) );
			pen_element_header_fields().css(
				{
					background: pen_css_background_gradient( pen_option_get( 'color_header_field_background_primary' ), pen_option_get( 'color_header_field_background_secondary' ), 'to bottom' ),
					color: pen_option_get( 'color_header_field_text' )
				}
			);

			/**
			 * Navigation.
			 */
			$( 'body' ).removeClass(
				function( index, css ) {
					return ( css.match( /(^|\s)pen_navigation_alignment_\S+/g ) || [] ).join( ' ' );
				}
			).addClass( 'pen_navigation_alignment_' + pen_option_get( 'navigation_alignment' ) );
			pen_element_navigation_links().css(
				{
					textShadow: ( ! pen_option_get( 'color_navigation_text_shadow_display' ) ) ? 'none' : '1px 1px 1px ' + pen_option_get( 'color_navigation_text_shadow' )
				}
			);
			pen_apply_link_color( pen_element_navigation_links_submenu(), pen_option_get( 'color_navigation_link_submenu' ), pen_option_get( 'color_navigation_link_hover_submenu' ) );
			pen_element_navigation_links_submenu().css(
				{
					textShadow: ( ! pen_option_get( 'color_navigation_text_shadow_display_submenu' ) ) ? 'none' : '1px 1px 1px ' + pen_option_get( 'color_navigation_text_shadow_submenu' )
				}
			);

			/**
			 * Search bar.
			 */
			pen_element_search_bar().css(
				{
					color: pen_option_get( 'color_search_text' ),
					textShadow: ( ! pen_option_get( 'color_search_text_shadow_display' ) ) ? 'none' : '1px 1px 1px ' + pen_option_get( 'color_search_text_shadow' )
				}
			);
			pen_apply_link_color( pen_element_search_bar_links(), pen_option_get( 'color_search_link' ), pen_option_get( 'color_search_link_hover' ) );
			pen_element_search_bar_field().css(
				{
					background: pen_css_background_gradient( pen_option_get( 'color_search_field_background_primary' ), pen_option_get( 'color_search_field_background_secondary' ), 'to bottom' )
				}
			);
			pen_element_search_bar_field().css(
				{
					color: pen_option_get( 'color_search_field_text' )
				}
			);

			/**
			 * Content area.
			 */
			pen_element_content().css(
				{
					background: pen_option_get( 'color_content_background_primary' )
				}
			)
			.find( '.pen_content,.pen_summary,.pen_content_footer,label' ).css(
				{
					color: pen_option_get( 'color_content_text' )
				}
			);
			pen_apply_link_color( pen_element_content_links(), pen_option_get( 'color_content_link' ), pen_option_get( 'color_content_link_hover' ) );

			pen_element_content_title().css(
				{
					color: pen_option_get( 'color_content_title_text' )
				}
			)
			.children( '.pen_content_title' ).css(
				{
					textShadow: ( ! pen_option_get( 'color_content_title_text_shadow_display' ) ) ? 'none' : '1px 1px 1px ' + pen_option_get( 'color_content_title_text_shadow' )
				}
			);
			pen_apply_link_color( pen_element_content_title_link(), pen_option_get( 'color_content_title_link' ), pen_option_get( 'color_content_title_link_hover' ) );

			pen_element_content_fields().css(
				{
					background: pen_css_background_gradient( pen_option_get( 'color_content_field_background_primary' ), pen_option_get( 'color_content_field_background_secondary' ), 'to bottom' )
				}
			);
			pen_element_content_fields().css(
				{
					color: pen_option_get( 'color_content_field_text' )
				}
			);
			pen_element_content_fields_option().css(
				{
					background: pen_option_get( 'color_content_field_background_primary' )
				}
			);
			pen_element_content_fields_option().css(
				{
					color: pen_option_get( 'color_content_field_text' )
				}
			);

			/**
			 * Bottom widget area.
			 */
			pen_element_bottom().css(
				{
					color: pen_option_get( 'color_bottom_text' )
				}
			);
			pen_apply_link_color( pen_element_bottom_links(), pen_option_get( 'color_bottom_link' ), pen_option_get( 'color_bottom_link_hover' ) );
			pen_element_bottom().css(
				{
					textShadow: ( ! pen_option_get( 'color_bottom_text_shadow_display' ) ) ? 'none' : '1px 1px 1px ' + pen_option_get( 'color_bottom_text_shadow' )
				}
			);
			pen_element_bottom_headings().css(
				{
					color: pen_option_get( 'color_bottom_headings' ),
					textShadow: ( ! pen_option_get( 'color_bottom_headings_text_shadow_display' ) ) ? 'none' : '1px 1px 1px ' + pen_option_get( 'color_bottom_headings_text_shadow' )
				}
			);
			pen_element_bottom_fields().css(
				{
					background: pen_css_background_gradient( pen_option_get( 'color_bottom_field_background_primary' ), pen_option_get( 'color_bottom_field_background_secondary' ), 'to bottom' ),
					color: pen_option_get( 'color_bottom_field_text' )
				}
			);

			/**
			 * Footer.
			 */
			$( 'body' ).removeClass(
				function( index, css ) {
					return ( css.match( /(^|\s)pen_footer_alignment_\S+/g ) || [] ).join( ' ' );
				}
			).addClass( 'pen_footer_alignment_' + pen_option_get( 'footer_alignment' ) );
			if ( pen_option_get( 'footer_menu_display' ) ) {
				pen_element_footer_menu().show();
			} else {
				pen_element_footer_menu().hide();
			}
			if ( pen_option_get( 'footer_copyright_display' ) ) {
				pen_element_footer_copyright().show();
			} else {
				pen_element_footer_copyright().hide();
			}

			/**
			 * Footer colors.
			 */
			pen_element_footer().css(
				{
					color: pen_option_get( 'color_footer_text' )
				}
			);
			var pen_color_footer_link            = pen_option_get( 'color_footer_link' ),
			pen_color_footer_text_shadow         = pen_option_get( 'color_footer_text_shadow' ),
			pen_color_footer_text_shadow_display = pen_option_get( 'color_footer_text_shadow_display' );
			pen_element_footer().css(
				{
					textShadow: ( ! pen_color_footer_text_shadow_display ) ? 'none' : '1px 1px 1px ' + pen_color_footer_text_shadow
				}
			);
			var pen_color_footer_background_secondary = pen_option_get( 'color_footer_background_secondary' );
			pen_element_go_to_top().css(
				{
					background: pen_color_footer_background_secondary,
					boxShadow: '0 0 10px ' + pen_color_footer_background_secondary,
					color: pen_color_footer_link,
					textShadow: ( ! pen_color_footer_text_shadow_display ) ? 'none' : '1px 1px 1px ' + pen_color_footer_text_shadow,
				}
			);
		}
	);

	/**
	 * Logo.
	 */
	wp.customize(
		'custom_logo',
		function( value ) {
			value.bind(
				function( logo ) {
					if ( logo ) {
						  $( '#pen_header' ).addClass( 'pen_logo_show' );
					} else {
						  $( '#pen_header' ).removeClass( 'pen_logo_show' );
					}
				}
			);
		}
	);
	/**
	 * General.
	 */
	wp.customize(
		'pen_color_site_background[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( color ) {
					$( 'body' ).css(
						{
							backgroundColor: color
						}
					);
				}
			);
		}
	);

	/**
	 * Layout.
	 */
	wp.customize(
		'pen_container_position[preset_1]',
		function( value ) {
			value.bind(
				function( position ) {
					$( 'body' ).removeClass(
						function( index, css ) {
							return ( css.match( /(^|\s)pen_main_container_\S+/g ) || [] ).join( ' ' );
						}
					).addClass( 'pen_main_container_' + position );
				}
			);
		}
	);

	/**
	 * Header.
	 */
	wp.customize(
		'pen_header_alignment[preset_1]',
		function( value ) {
			value.bind(
				function( position ) {
					$( 'body' ).removeClass(
						function( index, css ) {
							return ( css.match( /(^|\s)pen_header_alignment_\S+/g ) || [] ).join( ' ' );
						}
					).addClass( 'pen_header_alignment_' + position );
				}
			);
		}
	);

	/**
	 * Header colors.
	 */
	wp.customize(
		'pen_color_header_text[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( text_color ) {
					pen_element_header_main().css(
						{
							color: text_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_link[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_header_link ) {
					var pen_color_header_link_hover = pen_option_get( 'color_header_link_hover' );
					pen_apply_link_color( pen_element_header_links(), pen_color_header_link, pen_color_header_link_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_link_hover[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_header_link_hover ) {
					var pen_color_header_link = pen_option_get( 'color_header_link' );
					pen_apply_link_color( pen_element_header_links(), pen_color_header_link, pen_color_header_link_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_sitetitle[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_header_sitetitle ) {
					var pen_color_header_sitetitle_hover = pen_option_get( 'color_header_sitetitle_hover' );
					pen_apply_link_color( pen_element_header_sitetitle(), pen_color_header_sitetitle, pen_color_header_sitetitle_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_sitetitle_hover[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_header_sitetitle_hover ) {
					var pen_color_header_sitetitle = pen_option_get( 'color_header_sitetitle' );
					pen_apply_link_color( pen_element_header_sitetitle(), pen_color_header_sitetitle, pen_color_header_sitetitle_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_sitedescription[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_header_sitedescription ) {
					var pen_color_header_sitedescription_hover = pen_option_get( 'color_header_sitedescription_hover' );
					pen_apply_link_color( pen_element_header_sitedescription(), pen_color_header_sitedescription, pen_color_header_sitedescription_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_sitedescription_hover[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_header_sitedescription_hover ) {
					var pen_color_header_sitedescription = pen_option_get( 'color_header_sitedescription' );
					pen_apply_link_color( pen_element_header_sitedescription(), pen_color_header_sitedescription, pen_color_header_sitedescription_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_phone[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_header_phone ) {
					var pen_color_header_phone_hover = pen_option_get( 'color_header_phone_hover' );
					pen_apply_link_color( pen_element_header().find( pen_element_phone() ).children( 'a' ), pen_color_header_phone, pen_color_header_phone_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_phone_hover[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_header_phone_hover ) {
					var pen_color_header_phone = pen_option_get( 'color_header_phone' );
					pen_apply_link_color( pen_element_header().find( pen_element_phone() ).children( 'a' ), pen_color_header_phone, pen_color_header_phone_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_field_background_primary[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( top ) {
					var bottom = pen_option_get( 'color_header_field_background_secondary' );
					pen_element_header_fields().css(
						{
							background: pen_css_background_gradient( top, bottom, 'to bottom' )
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_field_background_secondary[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( bottom ) {
					var top = pen_option_get( 'color_header_field_background_primary' );
					pen_element_header_fields().css(
						{
							background: pen_css_background_gradient( top, bottom, 'to bottom' )
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_field_text[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( text_color ) {
					pen_element_header_fields().css(
						{
							color: text_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_text_shadow[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_color ) {
					var shadow_display = pen_option_get( 'color_header_text_shadow_display' );
					if ( shadow_display ) {
						pen_element_header_main().css(
							{
								textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 1px ' + shadow_color
							}
						);
					}
				}
			);
		}
	);
	wp.customize(
		'pen_color_header_text_shadow_display[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_display ) {
					var shadow_color = pen_option_get( 'color_header_text_shadow' );
					pen_element_header_main().css(
						{
							textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 1px ' + shadow_color
						}
					);
				}
			);
		}
	);

	/**
	 * Navigation.
	 */
	wp.customize(
		'pen_navigation_alignment[preset_1]',
		function( value ) {
			value.bind(
				function( position ) {
					$( 'body' ).removeClass(
						function( index, css ) {
							return ( css.match( /(^|\s)pen_navigation_alignment_\S+/g ) || [] ).join( ' ' );
						}
					).addClass( 'pen_navigation_alignment_' + position );
				}
			);
		}
	);

	/**
	 * Navigation colors.
	 */
	wp.customize(
		'pen_color_navigation_link_hover[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_navigation_link_hover ) {
					var pen_color_navigation_link = pen_option_get( 'color_navigation_link' );
					pen_apply_link_color( pen_element_navigation_links(), pen_color_navigation_link, pen_color_navigation_link_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_navigation_text_shadow[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_color ) {
					var shadow_display = pen_option_get( 'color_navigation_text_shadow_display' );
					if ( shadow_display ) {
						pen_element_navigation_links().css(
							{
								textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 1px ' + shadow_color
							}
						);
					}
				}
			);
		}
	);
	wp.customize(
		'pen_color_navigation_text_shadow_display[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_display ) {
					var shadow_color = pen_option_get( 'color_navigation_text_shadow' );
					pen_element_navigation_links().css(
						{
							textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 1px ' + shadow_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_navigation_link_submenu[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_navigation_link_submenu ) {
					var pen_color_navigation_link_hover_submenu = pen_option_get( 'color_navigation_link_hover_submenu' );
					pen_apply_link_color( pen_element_navigation_links_submenu(), pen_color_navigation_link_submenu, pen_color_navigation_link_hover_submenu );
				}
			);
		}
	);
	wp.customize(
		'pen_color_navigation_link_hover_submenu[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_navigation_link_hover_submenu ) {
					var pen_color_navigation_link_submenu = pen_option_get( 'color_navigation_link_submenu' );
					pen_apply_link_color( pen_element_navigation_links_submenu(), pen_color_navigation_link_submenu, pen_color_navigation_link_hover_submenu );
				}
			);
		}
	);
	wp.customize(
		'pen_color_navigation_text_shadow_submenu[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_color ) {
					var shadow_display = pen_option_get( 'color_navigation_text_shadow_display_submenu' );
					if ( shadow_display ) {
						pen_element_navigation_links_submenu().css(
							{
								textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 1px ' + shadow_color
							}
						);
					}
				}
			);
		}
	);

	wp.customize(
		'pen_color_navigation_text_shadow_display_submenu[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_display ) {
					var shadow_color = pen_option_get( 'color_navigation_text_shadow_submenu' );
					pen_element_navigation_links_submenu().css(
						{
							textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 1px ' + shadow_color
						}
					);
				}
			);
		}
	);

	/**
	 * Search bar colors.
	 */
	wp.customize(
		'pen_color_search_text[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( text_color ) {
					pen_element_search_main().css(
						{
							color: text_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_search_link[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_search_link ) {
					var pen_color_search_link_hover = pen_option_get( 'color_search_link_hover' );
					pen_apply_link_color( pen_element_search_bar_links(), pen_color_search_link, pen_color_search_link_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_search_link_hover[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_search_link_hover ) {
					var pen_color_search_link = pen_option_get( 'color_search_link' );
					pen_apply_link_color( pen_element_search_bar_links(), pen_color_search_link, pen_color_search_link_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_search_field_background_primary[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( top ) {
					var bottom = pen_option_get( 'color_search_field_background_secondary' );
					pen_element_search_bar_field().css(
						{
							background: pen_css_background_gradient( top, bottom, 'to bottom' )
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_search_field_background_secondary[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( bottom ) {
					var top = pen_option_get( 'color_search_field_background_primary' );
					pen_element_search_bar_field().css(
						{
							background: pen_css_background_gradient( top, bottom, 'to bottom' )
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_search_field_text[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( text_color ) {
					pen_element_search_bar_field().css(
						{
							color: text_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_search_text_shadow[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_color ) {
					var shadow_display = pen_option_get( 'color_search_text_shadow_display' );
					if ( shadow_display ) {
						pen_element_search_main().css(
							{
								textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 1px ' + shadow_color
							}
						);
					}
				}
			);
		}
	);
	wp.customize(
		'pen_color_search_text_shadow_display[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_display ) {
					var shadow_color = pen_option_get( 'color_search_text_shadow' );
					pen_element_search_main().css(
						{
							textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 1px ' + shadow_color
						}
					);
				}
			);
		}
	);

	/**
	 * Content area.
	 */
	wp.customize(
		'pen_color_content_title_link[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_content_title_link ) {
					var pen_color_content_title_link_hover = pen_option_get( 'color_content_title_link_hover' );
					pen_apply_link_color( pen_element_content_title_link(), pen_color_content_title_link, pen_color_content_title_link_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_title_link_hover[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_content_title_link_hover ) {
					var pen_color_content_title_link = pen_option_get( 'color_content_title_link' );
					pen_apply_link_color( pen_element_content_title_link(), pen_color_content_title_link, pen_color_content_title_link_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_title_text[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( text_color ) {
					pen_element_content_title().css(
						{
							color: text_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_title_text_shadow[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_color ) {
					var shadow_display = pen_option_get( 'color_content_title_text_shadow_display' );
					if ( shadow_display ) {
						pen_element_content_title().children( '.pen_content_title' ).css(
							{
								textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 1px ' + shadow_color
							}
						);
					}
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_title_text_shadow_display[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_display ) {
					var shadow_color = pen_option_get( 'color_content_title_text_shadow' );
					pen_element_content_title().children( '.pen_content_title' ).css(
						{
							textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 1px ' + shadow_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_background_primary[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( color ) {
					pen_element_content().css(
						{
							background: color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_text[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( text_color ) {
					pen_element_content().find( '.pen_content,.pen_summary,.pen_content_footer,label' ).css(
						{
							color: text_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_link[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_content_link ) {
					var pen_color_content_link_hover = pen_option_get( 'color_content_link_hover' );
					pen_apply_link_color( pen_element_content_links(), pen_color_content_link, pen_color_content_link_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_link_hover[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_content_link_hover ) {
					var pen_color_content_link = pen_option_get( 'color_content_link' );
					pen_apply_link_color( pen_element_content_links(), pen_color_content_link, pen_color_content_link_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_field_background_primary[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( top ) {
					var bottom = pen_option_get( 'color_content_field_background_secondary' );
					pen_element_content_fields().css(
						{
							background: pen_css_background_gradient( top, bottom, 'to bottom' )
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_field_background_secondary[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( bottom ) {
					var top = pen_option_get( 'color_content_field_background_primary' );
					pen_element_content_fields().css(
						{
							background: pen_css_background_gradient( top, bottom, 'to bottom' )
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_field_text[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( text_color ) {
					pen_element_content_fields().css(
						{
							color: text_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_field_background_primary[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( color ) {
					pen_element_content_fields_option().css(
						{
							background: color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_content_field_text[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( text_color ) {
					pen_element_content_fields_option().css(
						{
							color: text_color
						}
					);
				}
			);
		}
	);

	/**
	 * Bottom widget area.
	 */
	wp.customize(
		'pen_color_bottom_text[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( text_color ) {
					pen_element_bottom().css(
						{
							color: text_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_bottom_link[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_bottom_link ) {
					var pen_color_bottom_link_hover = pen_option_get( 'color_bottom_link_hover' );
					pen_apply_link_color( pen_element_bottom_links(), pen_color_bottom_link, pen_color_bottom_link_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_bottom_link_hover[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_bottom_link_hover ) {
					var pen_color_bottom_link = pen_option_get( 'color_bottom_link' );
					pen_apply_link_color( pen_element_bottom_links(), pen_color_bottom_link, pen_color_bottom_link_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_bottom_text_shadow[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_color ) {
					var shadow_display = pen_option_get( 'color_bottom_text_shadow_display' );
					if ( shadow_display ) {
						pen_element_bottom().css(
							{
								textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 2px ' + shadow_color
							}
						);
					}
				}
			);
		}
	);
	wp.customize(
		'pen_color_bottom_text_shadow_display[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_display ) {
					var shadow_color = pen_option_get( 'color_bottom_text_shadow' );
					pen_element_bottom().css(
						{
							textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 2px ' + shadow_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_bottom_headings[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( text_color ) {
					pen_element_bottom_headings().css(
						{
							color: text_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_bottom_headings_text_shadow[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_color ) {
					var shadow_display = pen_option_get( 'color_bottom_headings_text_shadow_display' );
					if ( shadow_display ) {
						pen_element_bottom_headings().css(
							{
								textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 2px ' + shadow_color
							}
						);
					}
				}
			);
		}
	);
	wp.customize(
		'pen_color_bottom_headings_text_shadow_display[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_display ) {
					var shadow_color = pen_option_get( 'color_bottom_headings_text_shadow' );
					pen_element_bottom_headings().css(
						{
							textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 2px ' + shadow_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_bottom_field_background_primary[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( top ) {
					var bottom = pen_option_get( 'color_bottom_field_background_secondary' );
					pen_element_bottom_fields().css(
						{
							background: pen_css_background_gradient( top, bottom, 'to bottom' )
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_bottom_field_background_secondary[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( bottom ) {
					var top = pen_option_get( 'color_bottom_field_background_primary' );
					pen_element_bottom_fields().css(
						{
							background: pen_css_background_gradient( bottom, top, 'top bottom' )
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_bottom_field_text[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( text_color ) {
					pen_element_bottom_fields().css(
						{
							color: text_color
						}
					);
				}
			);
		}
	);

	/**
	 * Footer.
	 */
	wp.customize(
		'pen_footer_alignment[preset_1]',
		function( value ) {
			value.bind(
				function( position ) {
					$( 'body' ).removeClass(
						function( index, css ) {
							return ( css.match( /(^|\s)pen_footer_alignment_\S+/g ) || [] ).join( ' ' );
						}
					).addClass( 'pen_footer_alignment_' + position );
				}
			);
		}
	);
	wp.customize(
		'pen_footer_menu_display[preset_1]',
		function( value ) {
			value.bind(
				function( display ) {
					if ( display ) {
						pen_element_footer_menu().show();
					} else {
						pen_element_footer_menu().hide();
					}
				}
			);
		}
	);
	wp.customize(
		'pen_footer_copyright_display[preset_1]',
		function( value ) {
			value.bind(
				function( display ) {
					if ( display ) {
						pen_element_footer_copyright().show();
					} else {
						pen_element_footer_copyright().hide();
					}
				}
			);
		}
	);

	/**
	 * Footer colors.
	 */
	function pen_go_to_top() {
		var pen_color_footer_background_secondary = pen_option_get( 'color_footer_background_secondary' ),
		pen_color_footer_link                     = pen_option_get( 'color_footer_link' ),
		pen_color_footer_text_shadow              = pen_option_get( 'color_footer_text_shadow' ),
		pen_color_footer_text_shadow_display      = pen_option_get( 'color_footer_text_shadow_display' );
		pen_element_go_to_top().css(
			{
				background: pen_color_footer_background_secondary,
				boxShadow: '0 0 10px ' + pen_color_footer_background_secondary,
				color: pen_color_footer_link,
				textShadow: ( ! pen_color_footer_text_shadow_display ) ? 'none' : '1px 1px 1px ' + pen_color_footer_text_shadow,
			}
		);
	}
	wp.customize(
		'pen_color_footer_text[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( text_color ) {
					pen_element_footer().css(
						{
							color: text_color
						}
					);
				}
			);
		}
	);
	wp.customize(
		'pen_color_footer_link_hover[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( pen_color_footer_link_hover ) {
					var pen_color_footer_link = pen_option_get( 'color_footer_link' );
					pen_apply_link_color( pen_element_footer_links(), pen_color_footer_link, pen_color_footer_link_hover );
				}
			);
		}
	);
	wp.customize(
		'pen_color_footer_text_shadow[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_color ) {
					pen_go_to_top();
					var shadow_display = pen_option_get( 'color_footer_text_shadow_display' );
					if ( shadow_display ) {
						pen_element_footer().css(
							{
								textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 1px ' + shadow_color
							}
						);
					}
				}
			);
		}
	);
	wp.customize(
		'pen_color_footer_text_shadow_display[' + pen_preview_js.preset_color + ']',
		function( value ) {
			value.bind(
				function( shadow_display ) {
					pen_go_to_top();
					var shadow_color = pen_option_get( 'color_footer_text_shadow' );
					pen_element_footer().css(
						{
							textShadow: ( ! shadow_display ) ? 'none' : '1px 1px 1px ' + shadow_color
						}
					);
				}
			);
		}
	);
} )( jQuery );
