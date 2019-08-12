<?php
/**
 * The functions.php file.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Pen
 */

define( 'PEN_THEME_SUPPORT_URL', 'https://wordpress.org/support/theme/pen/' );
define( 'PEN_THEME_DIRECTORY', get_template_directory() );
define( 'PEN_THEME_DIRECTORY_URI', get_template_directory_uri() );
define( 'PEN_THEME_HAS_WOOCOMMERCE', class_exists( 'WooCommerce' ) );

require PEN_THEME_DIRECTORY . '/include/color.php';
require PEN_THEME_DIRECTORY . '/include/general.php';
require PEN_THEME_DIRECTORY . '/include/compress.php';
require PEN_THEME_DIRECTORY . '/include/sanitize.php';
require PEN_THEME_DIRECTORY . '/include/typography.php';
require PEN_THEME_DIRECTORY . '/include/html.php';
require PEN_THEME_DIRECTORY . '/include/configure.php';
require PEN_THEME_DIRECTORY . '/include/assets.php';
require PEN_THEME_DIRECTORY . '/include/sidebars.php';
require PEN_THEME_DIRECTORY . '/include/widgets.php';
require PEN_THEME_DIRECTORY . '/include/content.php';
require PEN_THEME_DIRECTORY . '/include/customize.php';
require PEN_THEME_DIRECTORY . '/install/list.php';

if ( PEN_THEME_HAS_WOOCOMMERCE ) {
	require PEN_THEME_DIRECTORY . '/include/plugins/woocommerce.php';
}
