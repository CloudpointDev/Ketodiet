<?php
/**
 * Template part for displaying the site navigation.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Pen
 */

$content_id = pen_post_id();

$navigation_display = get_post_meta( $content_id, 'pen_navigation_display_override', true );
if ( ! $navigation_display || 'default' === $navigation_display ) {
	$navigation_display = pen_option_get( 'navigation_display' );
}
if ( $navigation_display && 'no' !== $navigation_display ) {
	$navigation_display = true;
} else {
	$navigation_display = false;
}

if ( $navigation_display ) {
	$variables = array(
		'theme_location' => 'primary',
		'menu_id'        => 'primary-menu',
		'menu_class'     => 'menu',
		'echo'           => false,
		'fallback_cb'    => 'pen_html_navigation_fallback',
	);

	$menu_html = trim( wp_nav_menu( $variables ) );
	if ( $menu_html ) {
		ob_start();
		?>
<nav id="pen_navigation" class="<?php echo esc_attr( pen_class_navigation() ); ?>" role="navigation" aria-label="<?php esc_attr_e( 'Header Menu', 'pen' ); ?>">
	<div class="pen_container <?php pen_class_animation( 'navigation', 'echo', $content_id ); /* phpcs:ignore */ ?>">
		<?php
		echo $menu_html; /* phpcs:ignore */
		?>
	</div>
		<?php
		pen_html_jump_menu( 'navigation', $content_id );
		?>
</nav>
		<?php
		echo ob_get_clean(); /* phpcs:ignore */
	}
}
