<?php
/**
 * Template part for displaying the content footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Pen
 */

ob_start();
if ( pen_option_get( 'footer_copyright_display' ) ) {
	?>
	<div class="site-info">
	<?php
	$copyright = pen_option_get( 'footer_copyright_text' );

	/* Translators: Please refer to the PHP documentation for the date() function. */
	$copyright = str_ireplace( '%YEAR%', date_i18n( esc_html__( 'Y', 'pen' ) ), $copyright );
	$copyright = str_ireplace( '%SITE_NAME%', get_bloginfo( 'name' ), $copyright );
	$url_home  = is_multisite() ? network_home_url( false ) : home_url( false );
	$copyright = str_ireplace( '%SITE_URL%', $url_home, $copyright );

	if ( $copyright ) {
		echo wp_kses( $copyright, wp_kses_allowed_html( 'post' ) );
	} else {
		printf(
			'&copy; %1$s. %2$s',
			esc_html( get_bloginfo( 'name' ) ),
			esc_html__( 'All rights reserved.', 'pen' )
		);
	}
	?>
	</div><!-- .site-info -->
	<?php
}
echo trim( ob_get_clean() ); /* phpcs:ignore */
