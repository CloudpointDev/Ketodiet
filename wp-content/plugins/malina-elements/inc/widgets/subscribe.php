<?php
if(!function_exists('malina_email_subscription_fn')) {
	add_action('malina_email_subscription' , 'malina_email_subscription_fn' );
	function malina_email_subscription_fn($id) {

		if('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['malina_submit_subscription_'.$id])) {

			if( filter_var($_POST['subscriber_email'], FILTER_VALIDATE_EMAIL) ){
				
				$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
				 
				$subject = sprintf(esc_html__('New Subscription on %s','malina-elements'), $blogname);
				 
				$to = get_option('admin_email'); 
				 
				$headers = 'From: '. sprintf(esc_html__('%s Admin', 'malina-elements'), $blogname) .' <no-repy@'.$_SERVER['SERVER_NAME'] .'>' . PHP_EOL;
				 
				$message  = sprintf(esc_html__('Hi ,', 'malina-elements')) . PHP_EOL . PHP_EOL;
				$message .= sprintf(esc_html__('You have a new subscription on your %s website.', 'malina-elements'), $blogname) . PHP_EOL . PHP_EOL;
				$message .= esc_html__('Email Details', 'malina-elements') . PHP_EOL;
				$message .= esc_html__('-----------------') . PHP_EOL;
				$message .= esc_html__('User E-mail: ', 'malina-elements') . stripslashes($_POST['subscriber_email']) . PHP_EOL;
				$message .= esc_html__('Regards,', 'malina-elements') . PHP_EOL . PHP_EOL;
				$message .= sprintf(esc_html__('Your %s Team', 'malina-elements'), $blogname) . PHP_EOL;
				$message .= trailingslashit(get_option('home')) . PHP_EOL . PHP_EOL . PHP_EOL . PHP_EOL;
			
				if (wp_mail($to, $subject, $message, $headers)){
					echo '<p>';
					esc_html_e('Your e-mail (' . $_POST['subscriber_email'] . ') has been added to our mailing list!', 'malina-elements');
					echo '</p>';

				} else {
					echo '<p>';
					esc_html_e('There was a problem with your e-mail (' . $_POST['subscriber_email'] . ')', 'malina-elements');
					echo '</p>'; 

				}
			} else {
			   echo '<p>';
			   esc_html_e('There was a problem with your e-mail (' . $_POST['subscriber_email'] . ')', 'malina-elements');
			   echo '</p>';
			}
		}?>
						
		<form id="newsletter-<?php echo esc_attr($id); ?>" method="POST">				
			<div class="newsletter-form">
				<div class="newsletter-email">
					<input type="email" name="subscriber_email" placeholder="<?php esc_html_e('Enter Your Email', 'malina-elements'); ?>">
				</div>
				<div class="newsletter-submit">
					<input type="hidden" name="malina_submit_subscription_<?php echo esc_attr($id); ?>" value="Submit"><button type="submit" name="submit_form"><i class="la la-paper-plane"></i></button>						
				</div>
			</div>
		</form>

	<?php }

}

class malina_widget_subscribe extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => esc_html__('Display subscribe form', 'malina-elements') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'malinasubscribe' );
		parent::__construct( 'malinasubscribe', esc_html__('malina-Subscribe', 'malina-elements'), $widget_ops, $control_ops );
	}

	// Widget Output
	function widget($args, $instance) {
		extract($args);
		$title = $text = '';
		if(isset($instance['title'])){
			$title = apply_filters('widget_title', $instance['title']);
		}
		
		if(isset($instance['text'])){
			$text = $instance['text'];
		}
		// ------
		$id = $this->id;
		echo ''.$before_widget;
		if ( $title !='' ) echo ''.$before_title . $title . $after_title;
		echo '<p class="info-text">'.$text.'</p>';
		do_action('malina_email_subscription', $id);
		echo ''.$after_widget;
		// ------
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['text'] = sanitize_text_field($new_instance['text']);
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => '', 'text' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('text')); ?>"><?php _e('Info text:','malina-elements'); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('text')); ?>" name="<?php echo esc_attr($this->get_field_name('text')); ?>"><?php echo esc_attr($instance['text']); ?></textarea>
		</p>
		
    <?php }
}

// Add Widget
function malina_widget_subscribe_init() {
	register_widget('malina_widget_subscribe');
}
add_action('widgets_init', 'malina_widget_subscribe_init');

?>