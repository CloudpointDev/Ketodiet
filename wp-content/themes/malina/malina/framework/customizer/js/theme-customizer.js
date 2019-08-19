(function( $ ) {
	var api = wp.customize;

	api( 'malina_fixed_header', function( value ) {
	    value.bind( function( to ) {
	        false === to ? $( '#header-main' ).removeClass('fixed_header') : $( '#header-main' ).addClass('fixed_header');
	    });
	});
	api( 'malina_menu_font_size', function( value ) {
	    value.bind( function( to ) {
	        $( '#navigation .menu li a' ).css('font-size', to);
	    });
	});
	api( 'malina_menu_font_family', function( value ) {
	    value.bind( function( to ) {
	    	var tmp = to.replace(/\s/g, '+');
	    	if( !$('link#google-font-5').length ){
	    		$('head').append('<link rel="stylesheet" id="google-font-5" href="#" type="text/css" media="all">');
	    	}
	    	if(to != 'Arial' && to != 'Verdana' && to != 'Trebuchet' && to != 'Georgia, sans-serif' && to != 'Times New Roman, sans-serif' && to != 'Tahoma' && to != 'Palatino' && to != 'Helvetica, sans-serif'){
	    		$('link#google-font-5').attr({href:"https://fonts.googleapis.com/css?family="+tmp+":100,100italic,200,200italic,300,300italic,400,400italic,600,600italic,700,700italic,800,800italic&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese"})
	    	}
	    	$( '#navigation .menu li a' ).css('font-family', to);
	    });
	});
	api( 'malina_menu_font_weight', function( value ) {
	    value.bind( function( to ) {
	        $( '#navigation .menu li a' ).css('font-weight', to);
	    });
	});
	api( 'malina_widgets_headings_font_weight', function( value ) {
	    value.bind( function( to ) {
	        $( '.widget-title' ).css('font-weight', to);
	    });
	});
	api( 'malina_menu_item_color', function( value ) {
	    value.bind( function( to ) {
	        $( '#navigation .menu li a' ).css('color', to);
	    });
	});
	api( 'malina_menu_transform', function( value ) {
	    value.bind( function( to ) {
	        $( '#navigation .menu li a' ).css('text-transform', to);
	    });
	});
	api( 'malina_header_socials_color', function( value ) {
	    value.bind( function( to ) {
	        $( '#header .social-icons li a' ).css('color', to);
	    });
	});
	api( 'malina_header_border_color', function( value ) {
	    value.bind( function( to ) {
	        $( ' #header, .header-top' ).css('border-color', to);
	    });
	});
	api( 'malina_menu_item_color_active', function( value ) {
	    value.bind( function( to ) {
	        $( '#navigation .menu li a' ).hover(function(){$(this).css('color', to)}, function(){$(this).css('color', '')});
	        $( '#navigation .menu li.current-menu-item > a, #navigation .menu li.current-menu-ancestor > a ').css('color', to);
	    });
	});
	api( 'malina_menu_item_padding', function( value ) {
	    value.bind( function( to ) {
	        $( '.menu > li > a, ' ).css('padding-right', to/2 + 'px');
	        $( '.menu > li > a' ).css('padding-left', to/2 + 'px');
	    });
	});
	api( 'malina_button_border_radius', function( value ) {
	    value.bind( function( to ) {
	        $( 'input[type="submit"], .button, button[type="submit"]' ).css('border-radius', to + 'px');
	    });
	});
	api( 'malina_button_horizontal_padding', function( value ) {
	    value.bind( function( to ) {
	        $( 'input[type="submit"], .button, button[type="submit"]' ).css({'paddings-right': to + 'px', 'paddings-left': to + 'px'});
	    });
	});
	api( 'malina_button_vertical_padding', function( value ) {
	    value.bind( function( to ) {
	        $( 'input[type="submit"], .button, button[type="submit"]' ).css({'paddings-top': to + 'px', 'paddings-bottom': to + 'px'});
	    });
	});
	api( 'malina_button_letter_spacing', function( value ) {
	    value.bind( function( to ) {
	        $( 'input[type="submit"], .button, button[type="submit"]' ).css('letter-spacing', to+'px');
	    });
	});
	api( 'malina_button_font_weight', function( value ) {
	    value.bind( function( to ) {
	        $( 'input[type="submit"], .button, button[type="submit"]' ).css('font-weight', to);
	    });
	});
	api( 'malina_navigation_disable_dots', function( value ) {
        value.bind( function( to ) {
	        false === to ? $( '.menu > li > a:after, .menu > li > a:before, #navigation-block ul.wp-megamenu > li > a:after, #navigation-block ul.wp-megamenu > li > a:before' ).show() : $( '.menu > li > a:after, .menu > li > a:before, #navigation-block ul.wp-megamenu > li > a:after, #navigation-block ul.wp-megamenu > li > a:before' ).hide();
	    });
    });
	api( 'malina_home_slider', function( value ) {
	    value.bind( function( to ) {
	        false === to ? $( '#post-slider' ).hide() : $( '#post-slider' ).show();
	    });
	});
    api( 'malina_header_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '#header, #side-header' ).css( 'background-color', to );
        } );
    });
    api( 'malina_menu_dropdown_bg', function( value ) {
        value.bind( function( to ) {
            $( '#navigation li ul' ).css( 'background-color', to );
        } );
    });
    api( 'malina_footer_bg_image', function( value ) {
	    value.bind( function( to ) {
	        $( '#footer .special-bg' ).css('background-image','url('+ to +')');
	    });
	    value.bind( function( to ) {
	        0 === $.trim( to ).length ?
	            $( '#footer .special-bg' ).css('background-image','url()') :
	            $( '#footer .special-bg' ).css('background-image','url('+ to +')');
	 
	    });
	});
	api( 'malina_footer_bg_position', function( value ) {
	    value.bind( function( to ) {
	        $( '#footer .special-bg' ).css('background-position', to );
	    });
	});
	api( 'malina_footer_bg_size', function( value ) {
	    value.bind( function( to ) {
	        $( '#footer .special-bg' ).css('background-size', to );
	    });
	});
    api( 'malina_footer_bg_color', function( value ) {
        value.bind( function( to ) {
            $( '#footer .special-bg, #footer' ).css( 'background-color', to );
        } );
    });
    api( 'malina_footer_top_padding', function( value ) {
        value.bind( function( to ) {
            $( '#footer' ).css( 'padding-top', to+'px' );
        } );
    });
    api( 'malina_footer_bottom_padding', function( value ) {
        value.bind( function( to ) {
            $( '#footer' ).css( 'padding-bottom', to+'px' );
        } );
    });
    api( 'malina_footer_socials', function( value ) {
        value.bind( function( to ) {
	        false === to ? $( '#footer .social-icons' ).hide() : $( '#footer .social-icons' ).show();
	    });
    });
    api( 'malina_footer_socials_color', function( value ) {
	    value.bind( function( to ) {
	        $( '#footer .social-icons li a, #footer .social-icons li span' ).css('color', to);
	    });
	});
    api( 'malina_header_image', function( value ) {
	    value.bind( function( to ) {
	        $( '#header, #side-header' ).css('background-image','url('+ to +')');
	    });
	    value.bind( function( to ) {
	        0 === $.trim( to ).length ?
	            $( '#header, #side-header' ).css('background-image','url()') :
	            $( '#header, #side-header' ).css('background-image','url('+ to +')');
	 
	    });
	});
	api( 'malina_header_bg_size', function( value ) {
	    value.bind( function( to ) {
	 		var bSize = 'auto';
	        switch( to.toString().toLowerCase() ) {
	
	            case 'cover':
	                bSize = 'cover';
	                break;
	 
	            case 'contain':
	                bSize = 'contain';
	                break;
	 
	            default:
	                bSize = 'auto';
	                break;
	 
	        }
	        $( '#header, #side-header' ).css({
	            backgroundSize: bSize
	        });
	    });
	});
	api( 'malina_header_socials', function( value ) {
	    value.bind( function( to ) {
	        false === to ? $( '#header .social-icons, #side-header .social-icons' ).fadeOut('fast') : $( '#header .social-icons, #side-header .social-icons' ).fadeIn('fast');
	    });
	});
	api( 'malina_header_search_button', function( value ) {
	    value.bind( function( to ) {
	        false === to ? $( '#header .search-link' ).fadeOut('fast') : $( '#header .search-link' ).fadeIn('fast');
	    });
	});
	api( 'malina_header_hidden_nav', function( value ) {
	    value.bind( function( to ) {
	        false === to ? $( '#header .hidden-menu-button' ).fadeOut('fast') : $( '#header .hidden-menu-button' ).fadeIn('fast');
	    });
	});
	api( 'malina_posts_headings_separator', function( value ) {
	    value.bind( function( to ) {
	        false === to ? $( '.post .meta-date' ).removeClass('separator') : $( '.post .meta-date' ).addClass('separator');
	    } );
	});
	api( 'malina_post_headings_transform', function( value ) {
	    value.bind( function( to ) {
	        $( '.title h2, .title h3' ).css('text-transform', to);
	    });
	});
	api( 'malina_posts_headings_letter_spacing', function( value ) {
	    value.bind( function( to ) {
	        $( '.title h2, .title h3' ).css('letter-spacing', to+'px');
	    });
	});
	api( 'malina_widgets_headings_letter_spacing', function( value ) {
	    value.bind( function( to ) {
	        $( '.wpb_widgetised_column .widget h3.title, .widget-title, #related-posts h2, #comments #reply-title, #comments-title, .write-comment h3' ).css('letter-spacing', to+'px');
	    });
	});
	api( 'malina_logo_title_letter_spacing', function( value ) {
	    value.bind( function( to ) {
	        $( '#header .logo .logo_text' ).css('letter-spacing', to+'px');
	    });
	});
	api( 'malina_logo_font_weight', function( value ) {
	    value.bind( function( to ) {
	        $( '#header .logo .logo_text' ).css('font-weight', to);
	    });
	});
	api( 'malina_logo_transform', function( value ) {
	    value.bind( function( to ) {
	        $( '#header .logo .logo_text' ).css('text-transform', to);
	    });
	});
	api( 'malina_logo_font_family', function( value ) {
	    value.bind( function( to ) {
	    	var tmp = to.replace(/\s/g, '+');
	    	if( !$('link#google-font').length ){
	    		$('head').append('<link rel="stylesheet" id="google-font" href="#" type="text/css" media="all">');
	    	}
	    	if(to != 'Arial' && to != 'Verdana' && to != 'Trebuchet' && to != 'Georgia, sans-serif' && to != 'Times New Roman, sans-serif' && to != 'Tahoma' && to != 'Palatino' && to != 'Helvetica, sans-serif'){
	    		$('link#google-font').attr({href:"https://fonts.googleapis.com/css?family="+tmp+":100,100italic,200,200italic,300,300italic,400,400italic,600,600italic,700,700italic,800,800italic&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese"})
	    	}
	    	$( '#header .logo' ).css('font-family', to);
	    });
	});
	api( 'malina_media_logo_width', function( value ) {
	    value.bind( function( to ) {
	        $( '#header .logo .logo_text' ).css('font-size', to+'px');
	        $('#header .logo img').css('width', to+'px');
	    });
	});
	api( 'malina_logo_color', function( value ) {
	    value.bind( function( to ) {
	        $( '#header .logo .logo_text' ).css('color', to);
	    });
	});
	api( 'malina_widgets_headings_transform', function( value ) {
	    value.bind( function( to ) {
	        $( '.wpb_widgetised_column .widget h3.title, .widget-title, #related-posts h2, #comments #reply-title, #comments-title, .write-comment h3' ).css('text-transform', to);
	    });
	});
	api( 'malina_footer_logo', function( value ) {
	    value.bind( function( to ) {
	    	if( !$( '#footer .logo img' ).length ) {
	    		$( '#footer .logo' ).html('<img src="">');
	    	}
	        0 === $.trim( to ).length ?
	            $( '#footer .logo img' ).attr( 'src', '' ).hide() :
	            $( '#footer .logo img' ).attr( 'src', to ).show();
	 
	    });
	});
	api( 'malina_media_logo', function( value ) {
	    value.bind( function( to ) {
	    	if( !$( '#header .logo img, #side-header .logo img' ).length ) {
	    		$( '#header .logo, #side-header .logo img' ).html('<img src="">');
	    	}
	        0 === $.trim( to ).length ?
	            $( '#header .logo img, #side-header .logo img' ).attr( 'src', '' ).hide() :
	            $( '#header .logo img, #side-header .logo img' ).attr( 'src', to ).show();
	    });
	});
	api( 'malina_media_logo_width', function( value ) {
	    value.bind( function( to ) {
	        $( '#header .logo img, #side-header .logo img' ).css('max-width', to+'px');
	        $( '#header .logo img, #side-header .logo img' ).css('height', 'auto');
	    });
	});
	api( 'malina_sidebar_pos', function( value ) {
	    value.bind( function( to ) {
	        switch(to){
	        	case 'sidebar-left':
	        		$('#content').removeClass('sidebar-right span12').addClass('sidebar-left span9');
	        		$('#sidebar').show();
	        	break;
	        	case 'none':
	        		$('#content').removeClass('sidebar-right sidebar-left span9').addClass('span12');
	        		$('#sidebar').hide();
	        	break;
	        	default:
	        		$('#content').removeClass('sidebar-left span12').addClass('sidebar-right span9');
	        		$('#sidebar').show();
	        	break;
	        }
	    });
	});
	api( 'malina_footer_br_color', function( value ) {
	    value.bind( function( to ) {
	        $( '#footer-nav-block' ).css('border-color', to);
	    });
	});
	api( 'malina_button_default_text_color', function( value ) {
	    value.bind( function( to ) {
	        $( 'input[type="submit"], .button, button[type="submit"]' ).css('color', to);
	    });
	});
	api( 'malina_button_default_bg_color', function( value ) {
	    value.bind( function( to ) {
	        $( 'input[type="submit"], .button, button[type="submit"]' ).css('background-color', to);
	    });
	});
	api( 'malina_button_default_border_color', function( value ) {
	    value.bind( function( to ) {
	        $( 'input[type="submit"], .button, button[type="submit"]' ).css('border-color', to);
	    });
	});
	api( 'malina_button_loadmore_text_color', function( value ) {
	    value.bind( function( to ) {
	        $( '.loadmore.button' ).css('color', to);
	    });
	});
	api( 'malina_button_loadmore_bg_color', function( value ) {
	    value.bind( function( to ) {
	        $( '.loadmore.button' ).css('background-color', to);
	    });
	});
	api( 'malina_button_loadmore_border_color', function( value ) {
	    value.bind( function( to ) {
	        $( '.loadmore.button' ).css('border-color', to);
	    });
	});
	api( 'malina_footer_copyright', function( value ) {
        value.bind( function( to ) {
        	if(!$('#footer-copy-block').length){
        		if($('#footer-nav-block').length){
	        		$('#footer-nav-block').after('<div id="footer-copy-block" role="contentinfo" class="aligncenter"><div class="container"><div class="span12"><div class="copyright-text"></div></div></div></div>'); 
	        	} else {
	        		$('#footer').after('<div id="footer-copy-block" role="contentinfo" class="aligncenter"><div class="container"><div class="span12"><div class="copyright-text"></div></div></div></div>');
	        	}
        	} 
            $( '.copyright-text' ).text( to );
        } );
    });
	api( 'malina_footer_menu_font_size', function( value ) {
	    value.bind( function( to ) {
	        $( '#footer-nav li a' ).css('font-size', to);
	    });
	});
	api( 'malina_footer_menu_font_family', function( value ) {
	    value.bind( function( to ) {
	    	var tmp = to.replace(/\s/g, '+');
	    	if( !$('link#google-font').length ){
	    		$('head').append('<link rel="stylesheet" id="google-font" href="#" type="text/css" media="all">');
	    	}
	    	if(to != 'Arial' && to != 'Verdana' && to != 'Trebuchet' && to != 'Georgia, sans-serif' && to != 'Times New Roman, sans-serif' && to != 'Tahoma' && to != 'Palatino' && to != 'Helvetica, sans-serif'){
	    		$('link#google-font').attr({href:"https://fonts.googleapis.com/css?family="+tmp+":100,100italic,200,200italic,300,300italic,400,400italic,600,600italic,700,700italic,800,800italic&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese"})
	    	}
	    	$( '#footer-nav li a' ).css('font-family', to);
	    });
	});
	api( 'malina_footer_menu_item_color', function( value ) {
	    value.bind( function( to ) {
	        $( '#footer-nav li a' ).css('color', to);
	    });
	});
	api( 'malina_footer_menu_item_color_active', function( value ) {
	    value.bind( function( to ) {
	    	$( '#footer-nav li.current-menu-item a, #footer-nav li.current_page_item a' ).css('color', to);
	        $( '#footer-nav li a' ).hover(function(){$(this).css('color', to)}, function(){$(this).css('color', '')});
	    });
	});
	api( 'malina_posts_headings_font_size', function( value ) {
	    value.bind( function( to ) {
	    	to = parseInt(to);
	        $( '.title h2' ).css('font-size', to+6+'px');
	        $( '.title h3' ).css('font-size', to+'px');
	        $( '.post.featured .title h2' ).css('font-size', (to+4)+'px');
	    });
	});
	api( 'malina_posts_headings_font_weight', function( value ) {
	    value.bind( function( to ) {
	        $( '.title h2, .title h3' ).css('font-weight', to);
	    });
	});
	api( 'malina_posts_headings_font_family', function( value ) {
	    value.bind( function( to ) {
	    	var tmp = to.replace(/\s/g, '+');
	    	if( !$('link#google-font-2').length ){
	    		$('head').append('<link rel="stylesheet" id="google-font-2" href="#" type="text/css" media="all">');
	    	}
	    	if(to != 'Arial' && to != 'Verdana' && to != 'Trebuchet' && to != 'Georgia, sans-serif' && to != 'Times New Roman, sans-serif' && to != 'Tahoma' && to != 'Palatino' && to != 'Helvetica, sans-serif'){
	    		$('link#google-font-2').attr({href:"https://fonts.googleapis.com/css?family="+tmp+":100,100italic,200,200italic,300,300italic,400,400italic,600,600italic,700,700italic,800,800italic&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese"})
	    	}
	    	$( '.title h2, .title h3' ).css('font-family', to);
	    });
	});
	api( 'malina_posts_headings_item_color', function( value ) {
	    value.bind( function( to ) {
	        $( '.title h2, .title h2 a, .title h3 a' ).css('color', to);
	    });
	});
	api( 'malina_posts_headings_item_color_active', function( value ) {
	    value.bind( function( to ) {
	        $( '.title h2 a, .title h3 a, .related-item-title a' ).hover(function(){$(this).css('color', to)}, function(){$(this).css('color', '')});
	    });
	});
	api( 'malina_widgets_headings_font_size', function( value ) {
	    value.bind( function( to ) {
	        $( '.widget-title' ).css('font-size', to);
	    });
	});
	api( 'malina_widgets_headings_font_family', function( value ) {
	    value.bind( function( to ) {
	    	var tmp = to.replace(/\s/g, '+');
	    	if( !$('link#google-font-3').length ){
	    		$('head').append('<link rel="stylesheet" id="google-font-3" href="#" type="text/css" media="all">');
	    	}
	    	if(to != 'Arial' && to != 'Verdana' && to != 'Trebuchet' && to != 'Georgia, sans-serif' && to != 'Times New Roman, sans-serif' && to != 'Tahoma' && to != 'Palatino' && to != 'Helvetica, sans-serif'){
	    		$('link#google-font-3').attr({href:"https://fonts.googleapis.com/css?family="+tmp+":100,100italic,200,200italic,300,300italic,400,400italic,600,600italic,700,700italic,800,800italic&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese"})
	    	}
	    	$( '.widget-title' ).css('font-family', to);
	    });
	});
	api( 'malina_widgets_headings_item_color', function( value ) {
	    value.bind( function( to ) {
	        $( '.widget-title' ).css('color', to);
	    });
	});
	api( 'malina_posts_headings_separator', function( value ) {
	    value.bind( function( to ) {
	        false === to ? $( '.post .meta-date' ).removeClass('separator') : $( '.post .meta-date' ).addClass('separator');
	    } );
	} );
	api( 'malina_widgets_headings_separator', function( value ) {
	    value.bind( function( to ) {
	        false === to ? $( '.widget-title' ).removeClass('separator') : $( '.widget-title' ).addClass('separator');
	    } );
	} );
	api( 'malina_accent_color', function( value ) {
	    value.bind( function( to ) {
	    	$('.pie-top-button, .post .meta-categories, #hidden-nav .menu li.current-menu-item a').css('color', to);
	    	$('#hidden-nav .menu li a, .widget .latest-blog-list .meta-categories a, .author .comment-reply a').hover(function(){$(this).css('color', to)}, function(){$(this).css('color', '')});
	    	$('.pie').css('background-color', to);
	    	$('.single-post .post.featured .title .meta-date .meta-categories a').css('border-color', to);
	    	$('input[type="text"], input[type="password"], input[type="email"], input[type="url"], input[type="tel"], input[type="number"], textarea').focus(function(){$(this).css('border-color', to)});
	    	$('input[type="text"], input[type="password"], input[type="email"], input[type="url"], input[type="tel"], input[type="number"], textarea').focusout(function(){$(this).css('border-color', '')});
	    	$( '.instagram-item' ).hover(function(){$(this).find('img').css('border-color', to);}, function(){$(this).find('img').css('border-color', '');});
	    	if( !$('style#malina_accent_color').length ){
	    		$('<style id="malina_accent_color">#sidebar .widget.widget_socials .social-icons li a:before, input[type="submit"]:hover, input[type="submit"]:before, .button:before, button:before, #footer .social-icons li a:before{background-color:'+to+'}</style>').appendTo('head');
	    	} else {
	    		$('style#malina_accent_color').html('#sidebar .widget.widget_socials .social-icons li a:before, input[type="submit"]:hover, input[type="submit"]:before, .button:before, button:before, #footer .social-icons li a:before{background-color:'+to+'}');
	    	}
	    	
	    });
	});
	api( 'malina_body_font_size', function( value ) {
	    value.bind( function( to ) {
	        $( 'body' ).css('font-size', to);
	    });
	});
	api( 'malina_body_line_height', function( value ) {
	    value.bind( function( to ) {
	        $( 'body' ).css('line-height', to);
	    });
	});
	api( 'malina_button_font_size', function( value ) {
	    value.bind( function( to ) {
	        $( 'button, .button, input[type="submit"]' ).css('font-size', to);
	    });
	});
	api( 'malina_body_font_family', function( value ) {
	    value.bind( function( to ) {
	    	var tmp = to.replace(/\s/g, '+');
	    	if( !$('link#google-font-4').length ){
	    		$('head').append('<link rel="stylesheet" id="google-font-4" href="#" type="text/css" media="all">');
	    	}
	    	if(to != 'Arial' && to != 'Verdana' && to != 'Trebuchet' && to != 'Georgia, sans-serif' && to != 'Times New Roman, sans-serif' && to != 'Tahoma' && to != 'Palatino' && to != 'Helvetica, sans-serif'){
	    		$('link#google-font-4').attr({href:"https://fonts.googleapis.com/css?family="+tmp })
	    	}
	    	$( 'body' ).css('font-family', to);
	    });
	});
	api( 'malina_button_font_family', function( value ) {
	    value.bind( function( to ) {
	    	var tmp = to.replace(/\s/g, '+');
	    	if( !$('link#google-font-6').length ){
	    		$('head').append('<link rel="stylesheet" id="google-font-6" href="#" type="text/css" media="all">');
	    	}
	    	if(to != 'Arial' && to != 'Verdana' && to != 'Trebuchet' && to != 'Georgia, sans-serif' && to != 'Times New Roman, sans-serif' && to != 'Tahoma' && to != 'Palatino' && to != 'Helvetica, sans-serif'){
	    		$('link#google-font-6').attr({href:"https://fonts.googleapis.com/css?family="+tmp })
	    	}
	    	$( 'button, .button, input[type="submit"]' ).css('font-family', to);
	    });
	});
	api( 'malina_meta_categories_font_family', function( value ) {
	    value.bind( function( to ) {
	    	var tmp = to.replace(/\s/g, '+');
	    	if( !$('link#google-font-categories').length ){
	    		$('head').append('<link rel="stylesheet" id="google-font-categories" href="#" type="text/css" media="all">');
	    	}
	    	if(to != 'Arial' && to != 'Verdana' && to != 'Trebuchet' && to != 'Georgia, sans-serif' && to != 'Times New Roman, sans-serif' && to != 'Tahoma' && to != 'Palatino' && to != 'Helvetica, sans-serif'){
	    		$('link#google-font-categories').attr({href:"https://fonts.googleapis.com/css?family="+tmp })
	    	}
	    	$( '.meta-categories' ).css('font-family', to);
	    });
	});
	api( 'malina_meta_categories_font_size', function( value ) {
	    value.bind( function( to ) {
	        $( '.meta-categories' ).css('font-size', to);
	    });
	});
	api( 'malina_meta_categories_color', function( value ) {
	    value.bind( function( to ) {
	        $( '.meta-categories' ).css('color', to);
	    });
	});
	api( 'malina_meta_categories_transform', function( value ) {
	    value.bind( function( to ) {
	        $( '.meta-categories' ).css('text-transform', to);
	    });
	});
	api( 'malina_meta_info_font_family', function( value ) {
	    value.bind( function( to ) {
	    	var tmp = to.replace(/\s/g, '+');
	    	if( !$('link#google-font-meta').length ){
	    		$('head').append('<link rel="stylesheet" id="google-font-meta" href="#" type="text/css" media="all">');
	    	}
	    	if(to != 'Arial' && to != 'Verdana' && to != 'Trebuchet' && to != 'Georgia, sans-serif' && to != 'Times New Roman, sans-serif' && to != 'Tahoma' && to != 'Palatino' && to != 'Helvetica, sans-serif'){
	    		$('link#google-font-meta').attr({href:"https://fonts.googleapis.com/css?family="+tmp })
	    	}
	    	$( '.post-meta > div' ).css('font-family', to);
	    });
	});
	api( 'malina_meta_info_font_size', function( value ) {
	    value.bind( function( to ) {
	        $( '.post-meta.footer-meta > div' ).css('font-size', to);
	    });
	});
	api( 'malina_meta_info_color', function( value ) {
	    value.bind( function( to ) {
	        $( '.post-meta.footer-meta > div' ).css('color', to);
	    });
	});
	api( 'malina_meta_info_transform', function( value ) {
	    value.bind( function( to ) {
	        $( '.post-meta.footer-meta > div' ).css('text_transform', to);
	    });
	});
	api( 'malina_body_color', function( value ) {
	    value.bind( function( to ) {
	        $( 'body' ).css('color', to);
	    });
	});
	api( 'malina_links_color', function( value ) {
	    value.bind( function( to ) {
	        $( 'a' ).css('color', to);
	    });
	});
	api( 'malina_links_color_hover', function( value ) {
	    value.bind( function( to ) {
	        $( 'a' ).hover(function(){$(this).css('color', to)}, function(){$(this).css('color', '')});
	    });
	});
	/*
	
	wp.customize( 'malina_font', function( value ) {
	    value.bind( function( to ) {
	 		var sFont = 'Times New Roman';
	        switch( to.toString().toLowerCase() ) {
	 
	            case 'times':
	                sFont = 'Times New Roman';
	                break;
	 
	            case 'arial':
	                sFont = 'Arial';
	                break;
	 
	            case 'courier':
	                sFont = 'Courier New, Courier';
	                break;
	 
	            case 'helvetica':
	                sFont = 'Helvetica';
	                break;
	 
	            default:
	                sFont = 'Times New Roman';
	                break;
	 
	        }
	 
	        $( 'body' ).css({
	            fontFamily: sFont
	        });
	 
	    });
	 
	});

	wp.customize( 'malina_footer_copyright_text', function(value) {
		value.bind( function(to){
			$('#copyright-message').text(to);
		});
	});
	wp.customize( 'blogname', function(value) {
		value.bind( function(to){
			$( '.logo_main' ).text( to );
		});
	});*/
 
})( jQuery );