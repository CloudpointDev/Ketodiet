<?php
/**
 * Custom widgets options.
 *
 * @package Pen
 */

defined( 'ABSPATH' ) || die();

if ( ! function_exists( 'pen_widget_options' ) ) {
	/**
	 * Color scheme and animation options for widgets.
	 *
	 * @param WP_Widget $widget   An instance of WP_Widget.
	 * @param null      $return   Whether a field was added.
	 * @param array     $instance Widget settings.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_widget_options( $widget, $return, $instance ) {
		?>
		<fieldset style="border:1px dashed #ccc;margin:0 0 1em;padding:0 1em">
			<legend style="font-weight:bold" title="<?php esc_attr_e( 'This is a part of the Pen theme so if you switch to another theme these settings will be no longer used. The rest of the settings that are here are either parts of the WordPress core or added via plugins and they are available with or without this theme.', 'pen' ); ?>">
		<?php
		esc_html_e( 'Pen', 'pen' );
		?>
			</legend>
		<?php
		pen_widget_options_color_scheme( $widget, $return, $instance );
		pen_widget_options_animation( $widget, $return, $instance );
		pen_widget_options_animation_delay( $widget, $return, $instance );
		?>
		</fieldset>
		<?php
	}
	add_filter( 'in_widget_form', 'pen_widget_options', 10, 3 );
}

if ( ! function_exists( 'pen_widget_options_color_scheme' ) ) {
	/**
	 * Widget color scheme options.
	 *
	 * @param WP_Widget $widget   An instance of WP_Widget.
	 * @param null      $return   Whether a field was added.
	 * @param array     $instance Widget settings.
	 *
	 * @since Pen 1.0.0
	 * @return void
	 */
	function pen_widget_options_color_scheme( $widget, $return, $instance ) {
		$color      = ( ! empty( $instance['pen_theme_color_widget'] ) ) ? $instance['pen_theme_color_widget'] : '';
		$field_id   = $widget->get_field_id( 'pen_theme_color_widget' );
		$field_name = $widget->get_field_name( 'pen_theme_color_widget' );
		?>
			<p>
				<label for="<?php echo esc_attr( $field_id ); ?>">
		<?php
		esc_html_e( 'Widget Color Scheme:', 'pen' );
		?>
				</label>
				<select id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>">
					<option value="transparent" <?php selected( 'transparent', $color ); ?>>
		<?php
		esc_html_e( 'None', 'pen' );
		?>
					</option>
		<?php
		$options = array(
			'blue'   => __( 'Blue', 'pen' ),
			'dark'   => __( 'Dark', 'pen' ),
			'light'  => __( 'Light', 'pen' ),
			'orange' => __( 'Orange', 'pen' ),
			'purple' => __( 'Purple', 'pen' ),
			'red'    => __( 'Red', 'pen' ),
			'yellow' => __( 'Yellow', 'pen' ),
		);
		foreach ( $options as $key => $label ) {
			?>
					<option value="<?php echo $key; /* phpcs:ignore */ ?>" <?php selected( $key, $color ); ?>>
			<?php
			echo esc_html( $label );
			?>
					</option>
			<?php
		}
		?>
				</select>
			</p>
		<?php
	}
}

if ( ! function_exists( 'pen_widget_options_animation' ) ) {
	/**
	 * Widget animation options.
	 *
	 * @param WP_Widget $widget   An instance of WP_Widget.
	 * @param null      $return   Whether a field was added.
	 * @param array     $instance Widget settings.
	 *
	 * @since Pen 1.0.4
	 * @return void
	 */
	function pen_widget_options_animation( $widget, $return, $instance ) {

		$animation  = ( ! empty( $instance['pen_theme_animation_widget'] ) ) ? $instance['pen_theme_animation_widget'] : '';
		$field_id   = $widget->get_field_id( 'pen_theme_animation_widget' );
		$field_name = $widget->get_field_name( 'pen_theme_animation_widget' );
		?>
			<p>
				<label for="<?php echo esc_attr( $field_id ); ?>">
		<?php
		esc_html_e( 'Widget Animation:', 'pen' );
		?>
				</label>
				<select id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>">
		<?php
		$options = pen_animations();
		foreach ( $options as $key => $label ) {
			?>
					<option value="<?php echo $key; /* phpcs:ignore */ ?>" <?php selected( $key, $animation ); ?>>
			<?php
			echo esc_html( $label );
			?>
					</option>
			<?php
		}
		?>
				</select>
			</p>
		<?php
	}
}
if ( ! function_exists( 'pen_widget_options_animation_delay' ) ) {
	/**
	 * Widget animation delay options.
	 *
	 * @param WP_Widget $widget   An instance of WP_Widget.
	 * @param null      $return   Whether a field was added.
	 * @param array     $instance Widget settings.
	 *
	 * @since Pen 1.2.8
	 * @return void
	 */
	function pen_widget_options_animation_delay( $widget, $return, $instance ) {

		$animation_delay = ( ! empty( $instance['pen_theme_animation_delay_widget'] ) ) ? $instance['pen_theme_animation_delay_widget'] : '';
		$field_id        = $widget->get_field_id( 'pen_theme_animation_delay_widget' );
		$field_name      = $widget->get_field_name( 'pen_theme_animation_delay_widget' );
		?>
			<p>
				<label for="<?php echo esc_attr( $field_id ); ?>">
		<?php
		echo esc_html(
			sprintf(
				'%s:',
				__( 'Animation Delay', 'pen' )
			)
		);
		?>
				</label>
				<select id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>">
		<?php
		$options = pen_animations_delay();
		foreach ( $options as $key => $label ) {
			?>
					<option value="<?php echo $key; /* phpcs:ignore */ ?>" <?php selected( $key, $animation_delay ); ?>>
			<?php
			echo esc_html( $label );
			?>
					</option>
			<?php
		}
		?>
				</select>
			</p>
		<?php
	}
}

if ( ! function_exists( 'pen_widgets_customization_save' ) ) {
	/**
	 * Saves widget customization.
	 *
	 * @param array $instance     Widget settings.
	 * @param array $new_instance The new widget settings.
	 *
	 * @since Pen 1.0.0
	 * @return array
	 */
	function pen_widgets_customization_save( $instance, $new_instance ) {
		return $new_instance;
	}
	add_filter( 'widget_update_callback', 'pen_widgets_customization_save', 10, 2 );
}

if ( ! function_exists( 'pen_widgets_custom_classes' ) ) {
	/**
	 * Custom class names for widgets.
	 *
	 * @global wp_registered_widgets $wp_registered_widgets
	 *
	 * @param array $params Widget parameters.
	 *
	 * @since Pen 1.0.0
	 * @return array
	 */
	function pen_widgets_custom_classes( $params ) {
		global $wp_registered_widgets;
		$widget_id   = $params[0]['widget_id'];
		$instance_id = $params[1]['number'];
		if ( ! is_object( $wp_registered_widgets[ $widget_id ]['callback'][0] ) ) {
			return;
		}

		$settings = $wp_registered_widgets[ $widget_id ]['callback'][0]->get_settings();

		$class = 'class="';

		if ( isset( $settings[ $instance_id ]['title'] ) && '' !== trim( $settings[ $instance_id ]['title'] ) ) {
			$class .= 'pen_widget_has_title ';
		}

		$color = 'transparent';
		if ( ! empty( $settings[ $instance_id ]['pen_theme_color_widget'] ) ) {
			$color = $settings[ $instance_id ]['pen_theme_color_widget'];
		}
		$class .= 'pen_widget_' . $color . ' ';
		if ( 'transparent' !== $color ) {
			$class .= 'pen_widget_not_transparent ';
		}

		$animation = 'fadeIn';
		if ( ! empty( $settings[ $instance_id ]['pen_theme_animation_widget'] ) ) {
			$animation = $settings[ $instance_id ]['pen_theme_animation_widget'];
		}
		if ( $animation && 'none' !== $animation ) {
			$class .= 'pen_animate_on_scroll pen_custom_animation_' . sanitize_html_class( $animation ) . ' ';

			if ( ! empty( $settings[ $instance_id ]['pen_theme_animation_delay_widget'] ) ) {
				$animation_delay = (int) $settings[ $instance_id ]['pen_theme_animation_delay_widget'];
				if ( $animation_delay ) {
					$class .= 'pen_custom_animation_delay_' . $animation_delay . ' ';
				}
			}
		}

		$params[0]['before_widget'] = str_ireplace( 'class="', $class, $params[0]['before_widget'] );
		return $params;
	}
	add_filter( 'dynamic_sidebar_params', 'pen_widgets_custom_classes' );
}
