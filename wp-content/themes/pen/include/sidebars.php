<?php
/**
 * Theme sidebars.
 *
 * @package Pen
 */

defined( 'ABSPATH' ) || die();

if ( ! function_exists( 'pen_sidebars_register' ) ) {
	/**
	 * Register widget areas.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	function pen_sidebars_register() {
		/* phpcs:disable */
		$sidebars = array(
			'left' => array(
				'name'        => __( 'Left Sidebar', 'pen' ),
				'description' => '',
			),
			'right' => array(
				'name'        => __( 'Right Sidebar', 'pen' ),
				'description' => '',
			),
			'header-primary' => array(
				'name'        => sprintf(
					'%1$s - %2$s',
					__( 'Header', 'pen' ),
					__( 'Primary', 'pen' )
				),
				'description' => __( '(Stays in the middle of the header)', 'pen' ),
			),
			'header-secondary' => array(
				'name'        => sprintf(
					'%1$s - %2$s',
					__( 'Header', 'pen' ),
					__( 'Secondary', 'pen' )
				),
				'description' => __( '(Stays at the right of the header)', 'pen' ),
			),
			'search-top' => array(
				'name'        => sprintf(
					'%1$s - %2$s',
					__( 'Search', 'pen' ),
					__( 'Top', 'pen' )
				),
				'description' => __( 'Located above the bigger search box.', 'pen' ),
			),
			'search-left' => array(
				'name'        => sprintf(
					'%1$s - %2$s',
					__( 'Search', 'pen' ),
					__( 'Left', 'pen' )
				),
				'description' => __( 'Located left side of the bigger search box.', 'pen' ),
			),
			'search-right' => array(
				'name'        => sprintf(
					'%1$s - %2$s',
					__( 'Search', 'pen' ),
					__( 'Right', 'pen' )
				),
				'description' => __( 'Located right side of the bigger search box.', 'pen' ),
			),
			'search-bottom' => array(
				'name'        => sprintf(
					'%1$s - %2$s',
					__( 'Search', 'pen' ),
					__( 'Bottom', 'pen' )
				),
				'description' => __( 'Located beneath the bigger search box.', 'pen' ),
			),
			'top' => array(
				'name'        => __( 'Top', 'pen' ),
				'description' => __( 'Located above the content area below the header and the navigation menu.', 'pen' ),
			),
			'bottom' => array(
				'name'        => __( 'Bottom', 'pen' ),
				'description' => __( 'Located beneath the content area.', 'pen' ),
			),
			'content-top' => array(
				'name'        => sprintf(
					'%1$s - %2$s',
					__( 'Content', 'pen' ),
					__( 'Top', 'pen' )
				),
				'description' => __( 'Located above the content.', 'pen' ),
			),
			'content-bottom' => array(
				'name'        => sprintf(
					'%1$s - %2$s',
					__( 'Content', 'pen' ),
					__( 'Bottom', 'pen' )
				),
				'description' => __( 'Located beneath the content.', 'pen' ),
			),
			'footer-top' => array(
				'name'        => sprintf(
					'%1$s - %2$s',
					__( 'Footer', 'pen' ),
					__( 'Top', 'pen' )
				),
				'description' => '',
			),
			'footer-left' => array(
				'name'        => sprintf(
					'%1$s - %2$s',
					__( 'Footer', 'pen' ),
					__( 'Left', 'pen' )
				),
				'description' => '',
			),
			'footer-right' => array(
				'name'        => sprintf(
					'%1$s - %2$s',
					__( 'Footer', 'pen' ),
					__( 'Right', 'pen' )
				),
				'description' => '',
			),
			'footer-bottom' => array(
				'name'        => sprintf(
					'%1$s - %2$s',
					__( 'Footer', 'pen' ),
					__( 'Bottom', 'pen' )
				),
				'description' => '',
			),
		);
		/* phpcs:enable */

		foreach ( $sidebars as $id => $sidebar ) {
			register_sidebar(
				array(
					'name'          => esc_html( $sidebar['name'] ),
					'id'            => 'sidebar-' . esc_attr( $id ),
					'description'   => esc_html( $sidebar['description'] ),
					'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h3 class="widget-title"><span><span>',
					'after_title'   => '</span></span></h3>',
				)
			);
		}

	}
	add_action( 'widgets_init', 'pen_sidebars_register' );
}

if ( ! function_exists( 'pen_sidebar_get' ) ) {
	/**
	 * Sidebars.
	 *
	 * @param string $sidebar    The sidebar ID.
	 * @param int    $content_id Content ID.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_sidebar_get( $sidebar, $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		if ( ! is_registered_sidebar( $sidebar ) ) {
			return;
		}
		if ( pen_sidebar_check( $sidebar, $content_id ) && is_active_sidebar( $sidebar ) ) {
			$classes = array(
				'sidebar',
				'clearfix',
				'widget-area',
			);
			if ( 'sidebar-bottom' === $sidebar ) {
				if ( pen_option_get( 'color_bottom_background_transparent' ) ) {
					$classes[] = 'pen_is_transparent';
				} else {
					$classes[] = 'pen_not_transparent';
				}
			}
			$classes = trim( implode( ' ', array_filter( $classes ) ) );
			?>
	<div id="<?php echo esc_attr( str_ireplace( array( 'sidebar-', '-' ), array( 'pen_', '_' ), $sidebar ) ); ?>" class="<?php echo esc_attr( $classes ); ?>" role="complementary">
			<?php
			if ( in_array( $sidebar, array( 'sidebar-top', 'sidebar-bottom' ), true ) ) {
				?>
		<div class="pen_container">
				<?php
			}

			dynamic_sidebar( $sidebar );

			if ( in_array( $sidebar, array( 'sidebar-top', 'sidebar-bottom' ), true ) ) {
				?>
		</div>
				<?php
			}

			pen_html_jump_menu( $sidebar, $content_id );
			?>
	</div>
			<?php
		}
	}
}

if ( ! function_exists( 'pen_sidebar_check' ) ) {
	/**
	 * Checks sidebars visibility.
	 *
	 * @param string $sidebar    The unique sidebar ID.
	 * @param int    $content_id Content ID.
	 *
	 * @since Pen 1.0.0
	 */
	function pen_sidebar_check( $sidebar, $content_id = null ) {
		// For maximum compatibility.
		if ( is_null( $content_id ) ) {
			$content_id = pen_post_id();
		}

		if ( ! is_registered_sidebar( $sidebar ) ) {
			return;
		}
		$sidebar = str_ireplace( '-', '_', $sidebar );
		$visible = true;
		if ( is_home() || is_front_page() ) {
			$visible = pen_option_get( 'front_' . $sidebar . '_display' ) ? false : true;
		}
		if ( is_singular() ) {
			$visible = get_post_meta( $content_id, 'pen_' . $sidebar . '_display', true ) ? false : true;
		}
		return $visible;
	}
}
