<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Pen
 */

$content_id = pen_post_id();

pen_sidebar_get( 'sidebar-left', $content_id );
pen_sidebar_get( 'sidebar-right', $content_id );
?>
						</div><!-- #content -->
					</div><!-- .pen_container -->
<?php
pen_html_jump_menu( 'site', $content_id );
?>
				</div><!-- #pen_section -->
<?php
pen_sidebar_get( 'sidebar-bottom', $content_id );

$footer_display = get_post_meta( $content_id, 'pen_site_footer_display_override', true );
if ( ! $footer_display || 'default' === $footer_display ) {
	$footer_display = pen_option_get( 'site_footer_display' );
}
if ( $footer_display && 'no' !== $footer_display ) {
	$footer_display = true;
} else {
	$footer_display = false;
}

$connect_html    = pen_html_connect( 'footer', $content_id );
$connect_display = $connect_html ? 'show' : 'hide';

$classes_footer = array(
	'site-footer',
	( ! $footer_display ) ? 'pen_element_hidden' : '',
	'pen_html_connect_' . sanitize_html_class( $connect_display ),
	pen_class_animation( 'footer', false, $content_id ),
	pen_option_get( 'color_footer_background_transparent' ) ? 'pen_is_transparent' : 'pen_not_transparent',
);
$classes_footer = trim( implode( ' ', array_filter( $classes_footer ) ) );
?>
				<footer id="pen_footer" class="<?php echo esc_attr( $classes_footer ); ?>" role="contentinfo">
					<div class="pen_container">
<?php
pen_sidebar_get( 'sidebar-footer-left', $content_id );
?>
						<div class="pen_footer_inner">
<?php
pen_sidebar_get( 'sidebar-footer-top', $content_id );

if ( pen_option_get( 'footer_menu_display' ) ) {
	$menu_html = wp_nav_menu(
		array(
			'theme_location' => 'secondary',
			'menu_id'        => 'secondary-menu',
			'echo'           => false,
			'fallback_cb'    => 'pen_html_footer_menu_fallback',
		)
	);
	if ( '' !== trim( $menu_html ) ) {
		?>
							<nav id="pen_footer_menu" role="navigation" class="pen_separator_<?php echo (int) pen_option_get( 'footer_menu_separator' ); ?> <?php pen_class_animation( 'footer_menu', 'echo', $content_id ); ?>" aria-label="<?php esc_attr_e( 'Footer Menu', 'pen' ); ?>">
		<?php
		echo $menu_html; /* phpcs:ignore */
		?>
							</nav>
		<?php
	}
}

$phone_html = pen_option_get( 'phone', false );
if ( $phone_html && pen_option_get( 'phone_footer_display' ) ) {
	?>
							<div class="pen_phone <?php pen_class_animation( 'phone_footer', 'echo', $content_id ); /* phpcs:ignore */ ?>">
								<a href="tel:<?php echo esc_attr( $phone_html ); ?>">
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
	echo esc_html( $phone_html );
	?>
									</span>
								</a>
							</div>
	<?php
}

echo $connect_html; /* phpcs:ignore */

get_template_part( 'partials/content', 'copyright' );

pen_sidebar_get( 'sidebar-footer-bottom', $content_id );
?>
						</div>
<?php
pen_sidebar_get( 'sidebar-footer-right', $content_id );
?>
					</div>
<?php
pen_html_jump_menu( 'footer', $content_id );
?>
				</footer><!-- #pen_footer -->
			</div><!-- .pen_wrapper -->
		</div><!-- #page -->
		<a id="pen_back" href="#page" title="<?php esc_attr_e( 'Back to top', 'pen' ); ?>"<?php echo ( ! pen_option_get( 'footer_back_to_top_display' ) ) ? ' class="screen-reader-text' : ''; /* phpcs:ignore */ ?>>
			<span class="screen-reader-text">
<?php
esc_html_e( 'Back to top', 'pen' );
?>
			</span>
		</a>
<?php
wp_footer();
?>
	</body>
</html>
<?php
ob_end_flush();
