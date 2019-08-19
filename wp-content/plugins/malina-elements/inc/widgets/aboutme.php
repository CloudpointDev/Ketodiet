<?php


class malina_widget_about_me extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => __('Display informations about you', 'malina') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'aboutme' );
		parent::__construct( 'aboutme', __('malina-AboutMe', 'malina'), $widget_ops, $control_ops );
		add_action('admin_enqueue_scripts', array($this, 'admin_setup'));
		add_action('wp_enqueue_scripts', array($this, 'malina_add_signature_font'));
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

	}
	public function malina_add_signature_font(){
		wp_register_style('sacramento', '//fonts.googleapis.com/css?family=Sacramento', array(), '1.0', 'all');
	}
	// Widget Output
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$signature = isset($instance['signature']) ? $instance['signature'] : '';
		$image_style = isset($instance['image_style']) ? $instance['image_style'] : 'circle'; 
		// ------
		echo ''.$before_widget;
		if ( $title !='' ) echo ''.$before_title . $title . $after_title;
		if( $signature != '' ){
			wp_enqueue_style('sacramento');
		}
		?>
			<div class="about-me">
				<?php if($instance['image']): ?>
				<div class="about-me-img">
					<?php if( $instance['image_id'] ){
						$thumbsize = 'thumbnail';
						if( $image_style == 'square' ){
							$thumbsize = 'medium';
						}
						$image_tmp = wp_get_attachment_image_src($instance['image_id'], $thumbsize );
						$image_url = $image_tmp[0];
						if($image_url){
							echo '<img class="'.$image_style.'" src="'.esc_url($image_url).'" alt="about-me-image">';
						}
					} else { ?>
					<img class="<?php echo esc_attr($image_style); ?>" src="<?php echo esc_url($instance['image']); ?>" alt="about-me-image">
					<?php } ?>
				</div>
				<?php endif; ?>
				<div class="content">
					<?php if($instance['content']): 
						echo apply_filters( 'widget_text', $instance['content'], $instance, $this );
					endif; ?>
					<?php if( $signature != '' ) { ?>
					<div class="signature">
						<?php echo esc_html($signature); ?>
					</div>
					<?php } ?>
				</div>
				
				<?php if( $instance['show_socials'] && function_exists('malina_get_social_links') ) { 
					echo malina_get_social_links(); 
				} ?>
			</div>

		<?php
		echo ''.$after_widget;
		// ------
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['signature'] = sanitize_text_field($new_instance['signature']);
		$instance['image'] = $new_instance['image'];
		$instance['image_id'] = $new_instance['image_id'];
		$instance['content'] = $new_instance['content'];
		$instance['show_socials'] = $new_instance['show_socials'];
		$instance['image_style'] = $new_instance['image_style'];
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => '', 'image' => '', 'image_id' => '', 'content' => '', 'image_style'=>'circle', 'show_socials' => 'true', 'signature' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:','malina'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php _e('Image:','malina'); ?></label>
			<input type="text" class="widefat widget-image-input" id="<?php echo esc_attr($this->get_field_id('image')); ?>_media_url" name="<?php echo esc_attr($this->get_field_name('image')); ?>" value="<?php echo esc_attr($instance['image']); ?>" />
			<input type="hidden" class="widefat widget-image-id" id="<?php echo esc_attr($this->get_field_id('image')); ?>_media_id" name="<?php echo esc_attr($this->get_field_name('image_id')); ?>" value="<?php echo esc_attr($instance['image_id']); ?>" />
			<br><br>
			<a href="#" class="upload_image_button button button-pmalinary" id="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php _e('Upload image', 'malina-elements'); ?></a>
		</p>
		<p>
            <label for="<?php echo $this->get_field_id( 'image_style' ); ?>"><?php esc_html_e('Image style', 'malina-elements'); ?></label>
            <?php
            $options = array(
                'circle' 	=> esc_html__('Circle', 'malina-elements'),
                'square' 	=> esc_html__('Square', 'malina-elements')
            );
            if(isset($instance['image_style'])) $image_style = $instance['image_style'];
            ?>
            <select class="widefat" id="<?php echo $this->get_field_id( 'image_style' ); ?>" name="<?php echo $this->get_field_name( 'image_style' ); ?>">
                <?php
                $op = '<option value="%s"%s>%s</option>';
                foreach ($options as $key=>$value ) {
                    if ($image_style === $key) {
                        printf($op, $key, ' selected="selected"', $value);
                    } else {
                        printf($op, $key, '', $value);
                    }
                }
                ?>
            </select>
        </p>
		<?php $show_socials = isset( $instance['show_socials'] ) ? (bool) $instance['show_socials'] : false; ?>
        <p>
            <input class="checkbox" type="checkbox"<?php checked( $show_socials ); ?> id="<?php echo $this->get_field_id( 'show_socials' ); ?>" name="<?php echo $this->get_field_name( 'show_socials' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_socials' ); ?>"><?php _e( 'Show Social Links?' ); ?></label>
        </p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('content')); ?>"><?php _e('Content:','malina'); ?></label>
			<textarea class="widefat" rows="10" cols="20" id="<?php echo esc_attr($this->get_field_id('content')); ?>" name="<?php echo esc_attr($this->get_field_name('content')); ?>"><?php echo esc_textarea($instance['content']); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('signature')); ?>"><?php _e('Signature:','malina'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('signature')); ?>" name="<?php echo esc_attr($this->get_field_name('signature')); ?>" value="<?php echo esc_attr($instance['signature']); ?>" />
		</p>
		
    <?php }
}

// Add Widget
function malina_widget_about_init() {
	register_widget('malina_widget_about_me');
}
add_action('widgets_init', 'malina_widget_about_init');

?>