<?php
function malina_subscribe_block() {
	// Scripts.
	wp_register_script(
		'malina-subscribe-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/subscribe/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n' ) // Dependencies, defined above.
	);

	// Styles.
	wp_register_style(
		'malina-subscribe-block-style', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/subscribe/editor.css', // Block editor CSS.
		array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
	);

	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/subscribe', array(
		'editor_script' => 'malina-subscribe-block-script',
		'attributes'      => array(
			'title' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'render_callback' => 'MalinaSubscribeBlock',
	) );

}
add_action( 'init', 'malina_subscribe_block' );
function MalinaSubscribeBlock($attributes){
	$id = rand(0, 9999);
	$out = '';
	$title = isset($attributes['title']) ? $attributes['title'] : esc_html__('Sign up for updates', 'malina-elements');
	if('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['malina_submit_subscription'])) {
		if( filter_var($_POST['subscriber_email'], FILTER_VALIDATE_EMAIL) ){
			
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			 
			$subject = sprintf(esc_html__('New Subscription on %s','malina-elements'), $blogname);
			 
			$to = get_option('admin_email'); 
			 
			$headers = 'From: '. sprintf(esc_html__('%s Admin', 'malina-elements'), $blogname) .' <no-repy@'.$_SERVER['SERVER_NAME'] .'>' . PHP_EOL;
			 
			$message  = sprintf(esc_html__('Hi ,', 'malina-elements')) . PHP_EOL . PHP_EOL;
			$message .= sprintf(esc_html__('You have a new subscription on your %s website.', 'malina-elements'), $blogname) . PHP_EOL . PHP_EOL;
			$message .= esc_html__('Email Details', 'malina-elements') . PHP_EOL;
			$message .= esc_html__('-----------------') . PHP_EOL;
			$message .= esc_html__('User Name: ', 'malina-elements') . stripslashes($_POST['subscriber_name']) . PHP_EOL;
			$message .= esc_html__('User E-mail: ', 'malina-elements') . stripslashes($_POST['subscriber_email']) . PHP_EOL;
			$message .= esc_html__('Regards,', 'malina-elements') . PHP_EOL . PHP_EOL;
			$message .= sprintf(esc_html__('Your %s Team', 'malina-elements'), $blogname) . PHP_EOL;
			$message .= trailingslashit(get_option('home')) . PHP_EOL . PHP_EOL . PHP_EOL . PHP_EOL;
		
			if (wp_mail($to, $subject, $message, $headers)){
				$out .= '<p class="subscribe-notice success">'.esc_html__('Your e-mail', 'malina-elements').' (' . $_POST['subscriber_email'] . ') '.esc_html__('has been added to our mailing list!', 'malina-elements').'</p>';

			} else {
				$out .= '<p class="subscribe-notice error">'.esc_html__('There was a problem with your e-mail', 'malina-elements').' (' . $_POST['subscriber_email'] . ') </p>';
			}
		} else {
		   $out .= '<p class="subscribe-notice error">'.esc_html__('There was a problem with your e-mail', 'malina-elements').' (' . $_POST['subscriber_email'] . ') </p>';
		}
	}

	$out .= '<div class="subscribe-block">';
		$out .= '<h3 class="subscribe-block-title">'.$title.'</h3>';					
		$out .= '<form id="newsletter-block-'.esc_attr($id).'" method="POST">';			
			$out .= '<div class="newsletter-form">';
				$out .= '<div class="newsletter-name">';
					$out .= '<input type="text" name="subscriber_name" placeholder="'.esc_attr__('Name', 'malina-elements').'">';
				$out .= '</div>';
				$out .= '<div class="newsletter-email">';
					$out .= '<input type="email" name="subscriber_email" placeholder="'.esc_attr__('Email', 'malina-elements').'">';
				$out .= '</div>';
				$out .= '<div class="newsletter-submit">';
					$out .= '<input type="hidden" name="malina_submit_subscription" value="Submit"><button type="submit" class="button" name="submit_form">'.esc_html__('Sign up', 'malina-elements').'</button>';					
				$out .= '</div>';
			$out .= '</div>';
		$out .= '</form>';
	$out .= '</div>';

	return $out;	
}