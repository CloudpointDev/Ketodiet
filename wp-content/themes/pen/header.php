<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pen
 */

$content_id = pen_post_id();

ob_start();
?><!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="https://gmpg.org/xfn/11">
<?php
wp_head();
?>
	</head>
	<body <?php body_class(); ?>>
		<div id="page" class="site">
			<div class="pen_loading clearfix" role="alert">
				<div class="pen_icon">
				</div>
				<div class="pen_text">
<?php
esc_html_e( 'Loading...', 'pen' );
?>
				</div>
			</div>
			<div class="pen_wrapper">
<?php
if ( ! is_customize_preview() ) {
	pen_html_jump_menu( 'color_schemes', $content_id );
	pen_html_jump_menu( 'font_presets', $content_id );
}
?>
				<a class="screen-reader-shortcut screen-reader-text" href="#content">
<?php
esc_html_e( 'Skip to content', 'pen' );
?>
				</a>
<?php
$header_primary = false;
if ( pen_sidebar_check( 'sidebar-header-primary', $content_id ) && is_active_sidebar( 'sidebar-header-primary' ) ) {
	$header_primary = true;
}
$header_secondary = false;
if ( pen_sidebar_check( 'sidebar-header-secondary', $content_id ) && is_active_sidebar( 'sidebar-header-secondary' ) ) {
	$header_secondary = true;
}
$connect_html    = pen_html_connect( 'header', $content_id );
$connect_display = $connect_html ? 'show' : 'hide';

$search_html     = pen_html_search_box( $content_id );
$search_location = '';
$search_display  = 'hide';
$search_location = get_post_meta( $content_id, 'pen_content_search_location_override', true );
if ( ! $search_location || 'default' === $search_location ) {
	$search_location = pen_option_get( 'search_location' );
}
if ( $search_html ) {
	if ( 'header' === $search_location ) {
		$search_display = 'show';
	} elseif ( 'content' === $search_location ) {
		$search_display = 'show_toolbar';
	}
}
$logo_html    = pen_html_logo( $content_id );
$logo_display = ( $logo_html && pen_option_get( 'header_logo_display' ) ) ? 'show' : 'hide';

$phone         = pen_option_get( 'phone' ); // No HTML.
$phone_display = ( $phone && pen_option_get( 'phone_header_display' ) ) ? 'show' : 'hide';

$button_users_html    = pen_html_button_users();
$button_users_display = ( $button_users_html && pen_option_get( 'button_users_header_display' ) ) ? 'show' : 'hide';

ob_start();
get_template_part( 'partials/site', 'navigation' );
$navigation_html = trim( ob_get_clean() );

$classes_header = array(
	'site-header',
	'pen_logo_' . sanitize_html_class( $logo_display ),
	'pen_phone_' . sanitize_html_class( $phone_display ),
	'pen_connect_' . sanitize_html_class( $connect_display ),
	'pen_search_' . sanitize_html_class( $search_display ),
	'pen_button_users_' . sanitize_html_class( $button_users_display ),
	// <body> may also get .pen_navigation_hide per content (never the .pen_navigation_show).
	'pen_navigation_' . ( $navigation_html ? 'show' : 'hide' ),
	'pen_navigation_mobile_' . ( pen_option_get( 'navigation_mobile_display' ) ? 'show' : 'hide' ),
	pen_class_animation( 'header', false, $content_id ),
);

$cart_display = 'hide';
if ( PEN_THEME_HAS_WOOCOMMERCE ) {
	$cart_display     = pen_option_get( 'cart_header_display' ) ? 'show' : 'hide';
	$classes_header[] = 'pen_cart_' . sanitize_html_class( $cart_display );
}

$classes_header = trim( implode( ' ', array_filter( array_values( $classes_header ) ) ) );
?>
				<header id="pen_header" class="<?php echo esc_attr( $classes_header ); ?>" role="banner">
					<div class="pen_header_inner">
<?php
$header_display = get_post_meta( $content_id, 'pen_site_header_display_override', true );
if ( ! $header_display || 'default' === $header_display ) {
	$header_display = pen_option_get( 'site_header_display' );
}
if ( $header_display && 'no' !== $header_display ) {
	$header_display = true;
} else {
	$header_display = false;
}
?>
						<div class="pen_header_main<?php echo ( ! $header_display ) ? ' pen_element_hidden' : ''; ?>">
							<div class="pen_container clearfix">
								<h1>
<?php
echo $logo_html; /* phpcs:ignore */

get_template_part( 'partials/site', 'title' );
?>
								</h1>
<?php
if ( $header_primary || $header_secondary || 'show' === $phone_display || $connect_html || ( 'header' === $search_location && $search_html ) ) {
	?>
								<div class="pen_header_wrap">
	<?php
	pen_sidebar_get( 'sidebar-header-primary', $content_id );

	if ( 'show' === $phone_display ) {
		?>
									<div id="pen_header_phone" class="pen_phone <?php pen_class_animation( 'phone_header', 'echo', $content_id ); /* phpcs:ignore */ ?>">
										<a href="tel:<?php echo esc_attr( $phone ); ?>">
											<strong class="screen-reader-text">
		<?php
		echo esc_html(
			sprintf(
				'%s:',
				__( 'Phone Number', 'pen' )
			)
		);
		?>
											</strong>
											<span>
		<?php
		echo esc_html( $phone );
		?>
											</span>
										</a>
									</div>
		<?php
	}

	echo $connect_html; /* phpcs:ignore */

	if ( $search_html && 'header' === $search_location ) {
		?>
									<div id="pen_header_search" class="pen_search <?php pen_class_animation( 'search_header', 'echo', $content_id ); /* phpcs:ignore */ ?>">
		<?php
		echo $search_html; /* phpcs:ignore */
		?>
									</div>
		<?php
	}

	if ( 'show' === $cart_display ) {
		echo pen_html_woocommerce_header_cart( $content_id ); /* phpcs:ignore */
	}

	if ( 'show' === $button_users_display ) {
		?>
									<div id="pen_header_button_users" class="pen_button_users <?php pen_class_animation( 'button_users_header', 'echo', $content_id ); /* phpcs:ignore */ ?>">
		<?php
		echo $button_users_html; /* phpcs:ignore */
		?>
									</div>
		<?php
	}

	pen_sidebar_get( 'sidebar-header-secondary', $content_id );
	?>
								</div><!-- .pen_header_wrap -->
	<?php
}
?>
							</div>
<?php
pen_html_jump_menu( 'header', $content_id );
?>
						</div><!-- .pen_header_main -->
<?php
// Adds the main navigation menu.
echo $navigation_html; /* phpcs:ignore */
?>
					</div><!-- .pen_header_inner -->
<?php
if ( $search_html && 'content' === $search_location ) {
	?>
					<div id="pen_search">
						<div class="pen_container">
	<?php
	pen_sidebar_get( 'sidebar-search-top', $content_id );
	?>
						</div>
						<div class="pen_container">
	<?php
	pen_sidebar_get( 'sidebar-search-left', $content_id );
	?>
							<div id="pen_search_form">
	<?php
	echo $search_html; /* phpcs:ignore */
	?>
							</div>
	<?php
	pen_sidebar_get( 'sidebar-search-right', $content_id );
	?>
						</div>
						<div class="pen_container">
	<?php
	pen_sidebar_get( 'sidebar-search-bottom', $content_id );

	pen_html_jump_menu( 'search_bar', $content_id );
	?>
						</div>
					</div>
	<?php
}
?>
				</header>
				<div id="pen_section">
<?php
pen_sidebar_get( 'sidebar-top', $content_id );
?>
					<div class="pen_container">
						<div id="content" class="site-content clearfix">
