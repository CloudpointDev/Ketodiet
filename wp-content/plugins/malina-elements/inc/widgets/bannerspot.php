<?php


class malina_widget_bannerspot extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => __('Display block with banner and Title over it.', 'malina-elements') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'bannerspot' );
		parent::__construct( 'bannerspot', __('malina-BannerSpot', 'malina-elements'), $widget_ops, $control_ops );
		add_action('admin_enqueue_scripts', array($this, 'admin_setup'));
		add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );
	}
	/**
	 * Enqueue all the javascript.
	 */
	public function admin_setup() {
		global $pagenow;

        if($pagenow !== 'widgets.php' && $pagenow !== 'customize.php') return;

		wp_enqueue_media();
        wp_enqueue_script(
			'about-me-widget',
			MALINA_PLUGIN_URL.'js/about-me-widget.js',
			array(),
			1.0
		);
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

	}

	public function print_scripts() {
		?>
		<script>
			( function( $ ){
				function initColorPicker( widget ) {
					widget.find( '.color-picker' ).wpColorPicker( {
						change: _.throttle( function() { // For Customizer
							$(this).trigger( 'change' );
						}, 3000 )
					});
				}

				function onFormUpdate( event, widget ) {
					initColorPicker( widget );
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate );

				$( document ).ready( function() {
					$( '.widget:has(.color-picker)' ).each( function () {
						initColorPicker( $( this ) );
					} );
				} );
			}( jQuery ) );
		</script>
		<?php
	}
	// Widget Output
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$textcolor = ( ! empty( $instance['textcolor'] ) ) ? $instance['textcolor'] : '#fff';
		$link_url = (! empty( $instance['link_url'] )) ? $instance['link_url'] : '';
		// ------
		echo ''.$before_widget;
		?>
			<div class="banner-spot">
				<?php if($link_url != ''){ ?>
					<a href="<?php echo esc_url($link_url); ?>" target="_blank">
				<?php } ?>
				<?php if($instance['image']){
					$image_tmp = wp_get_attachment_image_src($instance['image_id'], 'medium');
					$image_url = $image_tmp[0];
				?>
					<div class="bg-image">
						<img src="<?php echo esc_url($image_url); ?>" alt="subscribe image background">
					</div>
				<?php } ?>
				<div class="content" style="color:<?php echo $textcolor; ?>;">
					<?php if ( $title != '' ) echo ''.$before_title . $title . $after_title; ?>
				</div>
				<?php if($link_url != ''){ ?>
					</a>
				<?php } ?>
			</div>

		<?php
		echo ''.$after_widget;
		// ------
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['image'] = $new_instance['image'];
		$instance['image_id'] = $new_instance['image_id'];
		$instance['link_url'] = $new_instance['link_url'];
		$instance['textcolor'] = strip_tags( $new_instance['textcolor'] );
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => '', 'image' => '', 'link_url' => '', 'textcolor' => '#ffffff', 'image_id' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php _e('Banner image:','malina-elements'); ?></label>
			<input type="text" class="widefat widget-image-input" id="<?php echo esc_attr($this->get_field_id('image')); ?>_media_url" name="<?php echo esc_attr($this->get_field_name('image')); ?>" value="<?php echo esc_attr($instance['image']); ?>" />
			<input type="hidden" class="widefat widget-image-id" id="<?php echo esc_attr($this->get_field_id('image')); ?>_media_id" name="<?php echo esc_attr($this->get_field_name('image_id')); ?>" value="<?php echo esc_attr($instance['image_id']); ?>" />
			<br><br>
			<a href="#" class="upload_image_button button button-pmalinary" id="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php _e('Upload image', 'malina-elements'); ?></a>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'textcolor' ); ?>"><?php _e( 'Title color' ); ?></label><br>
			<input type="text" name="<?php echo $this->get_field_name( 'textcolor' ); ?>" class="color-picker" id="<?php echo $this->get_field_id( 'textcolor' ); ?>" value="<?php echo esc_attr($instance['textcolor']); ?>" data-default-color="#ffffff" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('link_url')); ?>"><?php _e('URL:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('link_url')); ?>" name="<?php echo esc_attr($this->get_field_name('link_url')); ?>" value="<?php echo esc_attr($instance['link_url']); ?>" />
		</p>

		
    <?php }
}

// Add Widget
function malina_widget_bannerspot_init() {
	register_widget('malina_widget_bannerspot');
}
add_action('widgets_init', 'malina_widget_bannerspot_init');

?>