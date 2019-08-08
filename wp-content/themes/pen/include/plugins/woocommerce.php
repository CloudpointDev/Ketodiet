<?php
/**
 * WooCommerce integration.
 *
 * @link https://woocommerce.com/
 *
 * @package Pen
 */

if ( PEN_THEME_HAS_WOOCOMMERCE ) {

	/**
	 * Disable the default WooCommerce stylesheet.
	 *
	 * Removing the default WooCommerce stylesheet and queueing your own will
	 * protect you during WooCommerce core updates.
	 *
	 * @since Pen 1.2.8
	 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
	 */
	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

	if ( ! pen_option_get( 'cart_products_related_display' ) ) {
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
	}

	if ( ! function_exists( 'pen_woocommerce' ) ) {
		/**
		 * Declares WooCommerce compatibility.
		 *
		 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
		 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
		 *
		 * @since Pen 1.2.8
		 * @return void
		 */
		function pen_woocommerce() {
			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}
		add_action( 'after_setup_theme', 'pen_woocommerce' );
	}

	if ( ! function_exists( 'pen_woocommerce_scripts' ) ) {
		/**
		 * WooCommerce-specific scripts & stylesheets.
		 *
		 * @since Pen 1.2.8
		 * @return void
		 */
		function pen_woocommerce_scripts() {
			wp_enqueue_style( 'pen-woocommerce', PEN_THEME_DIRECTORY_URI . '/assets/css/plugins/wp.woocommerce.css', array(), PEN_THEME_VERSION );

			wp_enqueue_script( 'pen-woocommerce', PEN_THEME_DIRECTORY_URI . '/assets/js/plugins/wp.woocommerce.js', array( 'jquery', 'pen-js' ), PEN_THEME_VERSION, true );

			wp_localize_script(
				'pen-woocommerce',
				'pen_woocommerce_js',
				array(
					'is_customize_preview' => is_customize_preview(),
				)
			);

			// Keeping it mostly for other plugins.
			$font_path = WC()->plugin_url() . '/assets/fonts/';
			// WOFF should be enough, keeping the rest for maximum browser-compatibility.
			$inline_font = '@font-face {
				font-family: "star";
				src: url("' . $font_path . 'star.eot");
				src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
					url("' . $font_path . 'star.woff") format("woff"),
					url("' . $font_path . 'star.ttf") format("truetype"),
					url("' . $font_path . 'star.svg#star") format("svg");
				font-weight: normal;
				font-style: normal;
			}';

			wp_add_inline_style( 'pen-woocommerce-style', $inline_font );
		}
		add_action( 'wp_enqueue_scripts', 'pen_woocommerce_scripts' );
	}

	if ( ! function_exists( 'pen_woocommerce_class_body' ) ) {
		/**
		 * Adds WooCommerce-specific classes to the body tag.
		 *
		 * @param array $classes CSS classes applied to the body tag.
		 *
		 * @since Pen 1.2.8
		 * @return array
		 */
		function pen_woocommerce_class_body( $classes ) {
			$classes[] = 'woocommerce-active';
			$classes[] = 'pen_has_woocommerce';
			// Keeping it mostly for other plugins.
			if ( is_shop() || is_product_category() || is_product_tag() ) {
				$classes[] = 'columns-' . absint( pen_woocommerce_columns() );
			}
			return $classes;
		}
		add_filter( 'body_class', 'pen_woocommerce_class_body' );
	}

	if ( ! function_exists( 'pen_woocommerce_class_post' ) ) {
		/**
		 * Adds custom classes to WooCommerce products.
		 *
		 * @param array $classes CSS classes applied to the body tag.
		 *
		 * @since Pen 1.2.8
		 * @return array $classes
		 */
		function pen_woocommerce_class_post( $classes, $product ) {
			if ( ! is_singular() ) {
				$content_id = pen_post_id();
				$classes    = pen_post_classes( $classes, $content_id, 'return_array' );
			}
			return $classes;
		}
		add_filter( 'woocommerce_post_class', 'pen_woocommerce_class_post', 10, 2 );
	}

	if ( ! function_exists( 'pen_content_per_page_products' ) ) {
		/**
		 * Products per page.
		 *
		 * @since Pen 1.2.8
		 * @return integer number of products.
		 */
		function pen_content_per_page_products() {
			return (int) pen_option_get( 'content_per_page_products' );
		}
		add_filter( 'loop_shop_per_page', 'pen_content_per_page_products' );
	}

	if ( ! function_exists( 'pen_woocommerce_archive_title' ) ) {
		/**
		 * Overrides archive titles.
		 *
		 * @param string $title Archive title.
		 *
		 * @since Pen 1.2.8
		 * @return string
		 */
		function pen_woocommerce_archive_title( $title ) {
			if ( is_shop() && wc_get_page_id( 'shop' ) === $shop_id ) {
				$title = get_the_title( $shop_id );
			}
			return $title;
		}
		add_filter( 'get_the_archive_title', 'pen_woocommerce_archive_title' );
	}

	if ( ! function_exists( 'pen_woocommerce_columns' ) ) {
		/**
		 * Overrides number of columns.
		 *
		 * @since Pen 1.2.8
		 * @return integer
		 */
		function pen_woocommerce_columns() {
			$columns = 4;
			if ( 'masonry' === pen_list_type() ) {
				$columns = (int) pen_option_get( 'list_masonry_columns' );
			}
			return $columns;
		}
		add_filter( 'loop_shop_columns', 'pen_woocommerce_columns' );
	}

	if ( ! function_exists( 'pen_woocommerce_summaries' ) ) {
		/**
		 * Product descriptions.
		 *
		 * @since Pen 1.2.8
		 * @return void
		 */
		function pen_woocommerce_product_summary() {

			$content_id = pen_post_id();

			$view = is_singular() ? 'content' : 'list';

			$thumbnail_display = get_post_meta( $content_id, 'pen_' . $view . '_thumbnail_display_override', true );
			if ( ! $thumbnail_display || 'default' === $thumbnail_display ) {
				$thumbnail_display = pen_option_get( $view . '_thumbnail_display' );
			}

			$classes = array(
				'pen_content',
				'p-' . $content_id,
				trim( pen_class_lists( 'summary_display_override', $content_id ) ),
				$thumbnail_display ? 'pen_with_thumbnail' : 'pen_without_thumbnail',
			);
			$classes = trim( implode( ' ', array_filter( $classes ) ) );

			$list_excerpt_display = pen_option_get( 'list_excerpt' );

			ob_start();
			// get_the_content() does not support shortcodes etc.
			if ( 'list' === $view || ! $list_excerpt_display ) {
				the_content(
					sprintf(
						wp_kses(
							/* Translators: %s: Name of current post. */
							__( 'Continue reading %s', 'pen' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					)
				);
			} elseif ( 'content' === $view && $list_excerpt_display ) {
				the_excerpt();
			}
			$summary = trim( ob_get_clean() );

			$length = 15;
			if ( 'list' === $view ) {
				$length = 30;
			}

			$summary = wp_trim_words( $summary, $length );

			ob_start();
			?>
			<div class="<?php echo esc_attr( $classes ); ?>">
			<?php
			echo esc_html( $summary );
			?>
			</div>
			<?php
			echo wp_kses_post( ob_get_clean() );
		}
		add_action( 'woocommerce_after_shop_loop_item_title', 'pen_woocommerce_product_summary', 9 );
	}

	if ( ! function_exists( 'pen_woocommerce_sale_flash' ) ) {
		/**
		 * Tweaks pagination links.
		 *
		 * @since Pen 1.2.8
		 * @return string
		 */
		function pen_woocommerce_sale_flash() {
			ob_start();
			?>
			<span class="onsale pen_badge_sale">
			<?php
			esc_html_e( 'Sale', 'pen' );
			?>
			</span>
			<?php
			return ob_get_clean();
		}
		add_filter( 'woocommerce_sale_flash', 'pen_woocommerce_sale_flash' );
	}

	if ( ! function_exists( 'pen_woocommerce_thumbnails_columns' ) ) {
		/**
		 * Tweaks product thumbnails.
		 *
		 * @since Pen 1.2.8
		 * @return integer number of columns.
		 */
		function pen_woocommerce_thumbnails_columns() {
			return 4;
		}
		add_action( 'woocommerce_product_thumbnails_columns', 'pen_woocommerce_thumbnails_columns' );
	}

	if ( ! function_exists( 'pen_woocommerce_related_products_args' ) ) {
		/**
		 * Related Products arguments.
		 *
		 * @param array $arguments Related products arguments.
		 *
		 * @since Pen 1.2.8
		 * @return array
		 */
		function pen_woocommerce_related_products_args( $arguments ) {
			$defaults = array(
				'posts_per_page' => (int) pen_option_get( 'cart_upsells_per_product' ),
				'columns'        => (int) pen_option_get( 'cart_upsells_columns' ),
			);
			return wp_parse_args( $defaults, $arguments );
		}
		add_filter( 'woocommerce_output_related_products_args', 'pen_woocommerce_related_products_args' );
	}

	if ( ! function_exists( 'pen_woocommerce_product_columns_wrapper' ) ) {
		/**
		 * Product columns wrapper.
		 *
		 * @since Pen 1.2.8
		 * @return void
		 */
		function pen_html_woocommerce_product_columns_wrapper() {
			$columns = pen_woocommerce_columns();
			if ( 'masonry' === pen_list_type() ) {
				?>
			<div id="pen_masonry" class="columns-<?php echo absint( $columns ); ?>">
				<?php
			} else {
				?>
			<div class="columns-<?php echo absint( $columns ); ?>">
				<?php
			}
		}
		add_action( 'woocommerce_before_shop_loop', 'pen_html_woocommerce_product_columns_wrapper', 40 );
	}

	if ( ! function_exists( 'pen_html_woocommerce_product_columns_wrapper_close' ) ) {
		/**
		 * Product columns wrapper close.
		 *
		 * @since Pen 1.2.8
		 * @return void
		 */
		function pen_html_woocommerce_product_columns_wrapper_close() {
			if ( 'masonry' === pen_list_type() ) {
				?>
			</div>
				<?php
			} else {
				?>
			</div>
				<?php
			}
		}
		add_action( 'woocommerce_after_shop_loop', 'pen_html_woocommerce_product_columns_wrapper_close', 40 );
	}

	if ( ! function_exists( 'pen_html_woocommerce_wrapper_before' ) ) {
		/**
		 * Before Content.
		 *
		 * Wraps all WooCommerce content in wrappers which match the theme markup.
		 *
		 * @since Pen 1.2.8
		 * @return void
		 */
		function pen_html_woocommerce_wrapper_before() {
			$content_id = pen_post_id();
			?>
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
					<div class="pen_article_wrapper">
						<article id="post-<?php echo (int) $content_id; /* phpcs:ignore */ ?>" <?php echo pen_post_classes( array(), $content_id ); /* phpcs:ignore */ ?>>
			<?php
		}
		add_action( 'woocommerce_before_main_content', 'pen_html_woocommerce_wrapper_before' );
	}

	if ( ! function_exists( 'pen_html_woocommerce_wrapper_after' ) ) {
		/**
		 * After Content.
		 *
		 * Closes the wrapping divs.
		 *
		 * @since Pen 1.2.8
		 * @return void
		 */
		function pen_html_woocommerce_wrapper_after() {
			?>
						</article>
					</div><!-- .pen_article_wrapper -->
				</main>
			</div><!-- #primary -->
			<?php
		}
		add_action( 'woocommerce_after_main_content', 'pen_html_woocommerce_wrapper_after' );
	}

	if ( ! function_exists( 'pen_woocommerce_image_product_wrap_start' ) ) {
		/**
		 * Wraps a <div> around all product images.
		 *
		 * @since Pen 1.2.8
		 * @return void
		 */
		function pen_html_woocommerce_image_product_wrap_start() {
			$content_id = pen_post_id();
			if ( is_singular() ) {
				$classes = pen_thumbnail_classes( 'content', $content_id );
			} else {
				$classes = pen_thumbnail_classes( 'list', $content_id );
			}
			?>
			<div class="pen_image_thumbnail <?php echo esc_attr( $classes ); ?>">
			<?php
		}
		add_action( 'woocommerce_before_shop_loop_item_title', 'pen_html_woocommerce_image_product_wrap_start', 5, 2 );
		add_action( 'woocommerce_before_subcategory_title', 'pen_html_woocommerce_image_product_wrap_start', 5, 2 );
	}

	if ( ! function_exists( 'pen_woocommerce_image_product_wrap_end' ) ) {
		/**
		 * Closes the wrapping <div> of the product images.
		 *
		 * @since Pen 1.2.8
		 * @return void
		 */
		function pen_html_woocommerce_image_product_wrap_end() {
			?>
			</div>
			<?php
		}
		add_action( 'woocommerce_before_shop_loop_item_title', 'pen_html_woocommerce_image_product_wrap_end', 12, 2 );
		add_action( 'woocommerce_before_subcategory_title', 'pen_html_woocommerce_image_product_wrap_end', 12, 2 );
	}

	if ( ! function_exists( 'pen_html_woocommerce_header_cart' ) ) {
		/**
		 * Display Header Cart.
		 *
		 * @param int $content_id Content ID.
		 *
		 * @since Pen 1.2.8
		 * @return string
		 */
		function pen_html_woocommerce_header_cart( $content_id = null ) {
			if ( is_cart() ) {
				return;
			}
			if ( is_null( $content_id ) ) {
				$content_id = pen_post_id();
			}
			ob_start();
			?>
			<div id="pen_cart_header" class="<?php pen_class_animation( 'cart_header', 'echo', $content_id ); ?>">
				<h3 class="screen-reader-text">
			<?php
			esc_html_e( 'Cart', 'pen' );
			?>
				</h3>
			<?php
			echo pen_html_woocommerce_cart_link(); /* phpcs:ignore */
			?>
				<div class="pen_cart_content screen-reader-text">
			<?php
			the_widget( 'WC_Widget_Cart', array( 'title' => '' ) );
			?>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}
	}

	if ( ! function_exists( 'pen_html_woocommerce_cart_link' ) ) {
		/**
		 * Displays a link to the cart including the number of items present and the cart total.
		 *
		 * @since Pen 1.2.8
		 * @return string
		 */
		function pen_html_woocommerce_cart_link() {
			ob_start();
			?>
			<a class="pen_button cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart.', 'pen' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* Translators: number of items in the mini cart. */
				esc_html( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'pen' ) ),
				WC()->cart->get_cart_contents_count()
			);
			?>
				<span class="amount">
			<?php
			echo wp_kses_data( WC()->cart->get_cart_subtotal() );
			?>
				</span>
				<span class="count">
			<?php
			echo esc_html( $item_count_text );
			?>
				</span>
			</a>
			<?php
			return ob_get_clean();
		}
	}

	if ( ! function_exists( 'pen_html_woocommerce_menu_item_cart' ) ) {
		/**
		 * Adds a shopping cart item to the navigation menu.
		 *
		 * @param array $items The menu items.
		 * @param array $args  The default arguments.
		 *
		 * @since Pen 1.2.8
		 * @return string
		 */
		function pen_html_woocommerce_menu_item_cart( $items, $arguments ) {
			if ( ! pen_option_get( 'cart_navigation_include' ) ) {
				return $items;
			}
			ob_start();
			if ( 'primary' === $arguments->theme_location ) {
				$classes = 'menu-item menu-item-type-cart menu-item-type-woocommerce-cart';
				if ( is_cart() ) {
					$classes .= ' current-menu-item';
				}
				?>
			<li class="<?php echo esc_attr( $classes ); ?>">
				<?php
				echo pen_html_woocommerce_menu_cart_item(); /* phpcs:ignore */
				?>
			</li>
				<?php
			}
			$items .= ob_get_clean();

			return $items;
		}
		add_filter( 'wp_nav_menu_items', 'pen_html_woocommerce_menu_item_cart', 10, 2 );
	}

	if ( ! function_exists( 'pen_html_woocommerce_menu_cart_item' ) ) {
		/**
		 * Returns the shopping cart link.
		 *
		 * @since Pen 1.2.8
		 * @return string
		 */
		function pen_html_woocommerce_menu_cart_item() {
			if ( ! pen_option_get( 'cart_navigation_include' ) ) {
				return;
			}
			$count = WC()->cart->cart_contents_count;
			if ( $count ) {
				$url = wc_get_cart_url();
			} else {
				$url = wc_get_page_permalink( 'shop' );
			}
			$class = 'pen_menu_cart_total pen_cart_total-' . (int) $count;
			ob_start();
			?>
			<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( $class ); ?>">
			<?php
			echo wp_kses_post( str_replace( 'amount', '', WC()->cart->get_cart_total() ) );
			?>
			</a>
			<?php
			return ob_get_clean();
		}
	}

	if ( ! function_exists( 'pen_woocommerce_cart_link_fragment' ) ) {
		/**
		 * Ensures cart contents update when products are added to the cart via AJAX.
		 *
		 * @param array $fragments Fragments to refresh via AJAX.
		 *
		 * @since Pen 1.2.8
		 * @return array Fragments to refresh via AJAX.
		 */
		function pen_woocommerce_cart_link_fragment( $fragments ) {
			$fragments['a.cart-contents']       = pen_html_woocommerce_cart_link();
			$fragments['a.pen_menu_cart_total'] = pen_html_woocommerce_menu_cart_item();
			return $fragments;
		}
		add_filter( 'woocommerce_add_to_cart_fragments', 'pen_woocommerce_cart_link_fragment' );
	}
}
