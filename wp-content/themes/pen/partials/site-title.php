<?php
/**
 * Template part for displaying the site navigation.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Pen
 */

$content_id               = pen_post_id();
$description              = false;
$site_description_display = pen_option_get( 'header_sitedescription_display' );
if ( $site_description_display ) {
	$description = get_bloginfo( 'description', 'display' );
}

$site_title_display = pen_option_get( 'header_sitetitle_display' );
$classes_sitetitle  = array(
	$description ? 'pen_has_description' : '',
	'pen_sitetitle_' . ( sanitize_html_class( $site_title_display ) ? 'show' : 'hide' ),
);
$classes_sitetitle  = trim( implode( ' ', array_filter( $classes_sitetitle ) ) );

$url_home = is_multisite() ? network_home_url( false ) : home_url( false );

ob_start();
?>
	<a href="<?php echo esc_url( $url_home ); ?>" id="site-title" class="<?php echo esc_attr( $classes_sitetitle ); ?>" rel="home">
		<span class="site-title <?php echo ( ! $site_title_display ) ? 'pen_element_hidden ' : ''; ?><?php pen_class_animation( 'header_sitetitle', 'echo', $content_id ); /* phpcs:ignore */ ?>">
<?php
bloginfo( 'name' );
?>
		</span>
<?php
$description = wp_strip_all_tags( $description );
if ( 200 < strlen( $description ) ) {
	$description = substr( $description, 0, 100 ) . ' &hellip;'; /* phpcs:ignore */
}
if ( $description || is_customize_preview() ) {
	// CSS "margin" relies on :not(:empty) here hence no indentation, newlines, etc.
	?>
		<span class="site-description <?php pen_class_animation( 'header_sitedescription', 'echo', $content_id ); /* phpcs:ignore */ ?>"><?php echo $description; /* phpcs:ignore */ ?></span>
	<?php
}
?>
	</a>
<?php
echo ob_get_clean(); /* phpcs:ignore */
