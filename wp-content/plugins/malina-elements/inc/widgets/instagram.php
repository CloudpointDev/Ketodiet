<?php
class malina_widget_instagram extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => __('Display your latest Instagram Photos', 'malina') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'instagram' );
		parent::__construct( 'instagram', __('malina-Instagram', 'malina'), $widget_ops, $control_ops );
	}
	/** @see WP_Widget::widget */
	function widget($args, $instance) {		
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$accessToken = $instance['access_token'];
		$pics = apply_filters('pics', $instance['pics']);
		$pics_per_row = apply_filters('pics_per_row', $instance['pics_per_row']);
		$hide_items = $instance['hide_items'];
		$hide_link = $instance['hide_link'];
		$item_link = isset($instance['item_link']) ? $instance['item_link'] : 1;
		$insta_title = isset($instance['insta_title']) ? $instance['insta_title'] : '';
		$suf = $this->id;
		$row_class='';	
		// processing further
		$main_data = array();
		echo ''.$before_widget; 
		if ( $title !='' )	echo ''.$before_title . $title . $after_title;
		
		$transient_name = 'malina_instagram_items'.$accessToken.$suf;
		$malina_instagram_items = get_transient( $transient_name );

		switch ($pics_per_row) {
        	case '1':
        		$row_class='span12';
        		break;
        	case '2':
        		$row_class='span6';
        		break;
        	case '4':
        		$row_class='span3';
        		break;
        	case '6':
        		$row_class='span2';
        		break;
        	default:
        		$row_class='span4';
        		break;
        }
		if( !$malina_instagram_items ){
		    // get remote data
		    $result = wp_remote_get( "https://api.instagram.com/v1/users/self/media/recent/?access_token={$accessToken}&count={$pics}", array('timeout' => 30) );
		    if(is_array($result) && !empty($result['body'])){
		    	$result = json_decode( $result['body'] );
			    if ( is_wp_error( $result ) ) {
			        // error handling
			        $error_message = $result->get_error_message();
			        echo "Something went wrong: ".$error_message;

			    } elseif( isset($result->meta->error_message) ) {
			    	echo "Something went wrong: ".$result->meta->error_message;

			    } else {
			        
			        //print_r($result);
			        $username = '';
			        $n         = 0;
			        // get username and actual thumbnail
			        if( is_array($result->data) || is_object($result->data) ){
			        	//print_r($result->data);
			        	foreach ( $result->data as $d ) {
				        	$username = $d->user->full_name;

				        	$main_data[ $n ]['type'] = $d->type;
				            $main_data[ $n ]['user']      = $d->user->full_name;
				            $main_data[ $n ]['user_url']   = '//instagram.com/'.$d->user->username;
				            $main_data[ $n ]['thumbnail'] = $d->images->low_resolution->url;
				            if($d->type == 'video'){
				        		$main_data[ $n ]['full'] = $d->videos->standard_resolution->url;
				        	} else {
				        		$main_data[ $n ]['full'] = $d->images->standard_resolution->url;
				        	}
				            $n++;
				        }
			        }
			        delete_transient( $transient_name );
			        set_transient( $transient_name, $main_data, 1 * HOUR_IN_SECONDS );
			    }
		    }
		}
		
		$malina_instagram_items = get_transient( $transient_name );
		if( !$malina_instagram_items ){
			$malina_instagram_items = $main_data;
		}
		if(!empty($malina_instagram_items) && is_array($malina_instagram_items)){
			// create main string, pictures embedded in links
		        $items = '<div class="instagram-items">';
		        foreach ( $malina_instagram_items as $data ) {
		        	$username = $data['user'];
		        	$user_url = $data['user_url'];
		        	if( $data['type']=='video' ){
		        		$items .= '<div class="'.$row_class.' instagram-item">';
		        		$items .= '<div class="insta-video-lightbox">';
		        			$items .= '<a href="#" class="close-lightbox"><i class="la la-close"></i></a>';
		        			$items .= '<div class="insta-video-item">';
		        				$items .= '<video id="insta-video" controls><source src="'.esc_url($data['full']).'" type="video/mp4"></video>';
		        			$items .= '</div>';
		        		$items .= '</div>';
		        		$items .= '<a class="open-insta-video-lightbox" href="#"><i class="la la-play-circle"></i><img src="'.esc_url($data['thumbnail']).'" alt="'.esc_attr($data['user']).' picture"></a></div>';
		        	} else {
		        		if( $item_link == 2 ){
							$item_link_t = $user_url;
							$data_l = '';
		        		} else {
		        			$item_link_t = esc_url($data['full']);
		        			$data_l = 'data-lightbox="lightbox-insta"';
		        		}
		            	$items .= '<div class="'.$row_class.' instagram-item"><a href="'.$item_link_t.'" '.$data_l.'><img src="'.esc_url($data['thumbnail']).'" alt="'.esc_attr($data['user']).' picture"></a></div>';
		            }
		        }
		        $items .= '</div>';
		    if(!$hide_items){
		    	echo $items;
		    }
		    if(!$hide_link){
		    	if( !isset( $insta_title ) || $insta_title == '' ){
		    		$insta_title = '@ '.$username;
		    	}
	        	echo '<a class="insta-follow-link" href="'.$user_url.'">'.$insta_title.'</a>';
		    }
		}
		echo ''.$after_widget; 
	}
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['access_token'] = strip_tags( $new_instance['access_token'] );
		$instance['pics'] = strip_tags( $new_instance['pics'] );
		$instance['pics_per_row'] = strip_tags( $new_instance['pics_per_row'] );
		$instance['hide_items'] = $new_instance['hide_items'];
		$instance['hide_link'] = $new_instance['hide_link'];
		$instance['item_link'] = $new_instance['item_link'];
		$instance['insta_title'] = $new_instance['insta_title'];
		if($old_instance['access_token'] != $new_instance['access_token']){
			delete_transient( $transient_name );
		}
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array( 'title' => 'Instagram Widget', 'insta_title' => '', 'item_link' => '1', 'pics' => '6', 'access_token' => get_theme_mod('malina_footer_instagram_access_token', ''), 'pics_per_row' => '3', 'hide_link' => '', 'hide_items' => '' ); // Default Values
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
        
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">Widget Title:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'access_token' )); ?>">Access Token:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'access_token' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'access_token' )); ?>" value="<?php echo esc_attr($instance['access_token']); ?>" /><br /><a target="_blank" href="https://instagram.com/oauth/authorize/?client_id=1677ed07ddd54db0a70f14f9b1435579&redirect_uri=http://instagram.pixelunion.net&response_type=token"><?php _e('Get your Access Token','malina'); ?></a>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'pics' )); ?>">Number of Items:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'pics' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pics' )); ?>" value="<?php echo esc_attr($instance['pics']); ?>" />
			<span class="description"><?php esc_html_e('Input number of items, max number is 20.','malina'); ?></span>
		</p>
		<p>
		<?php 
			$selected2 = '';
			$selected3 = '';
			$selected4 = '';
			$selected5 = '';
			$selected6 = '';
			if(isset($instance['pics_per_row'])){
				switch ($instance['pics_per_row']) {
					case '1':
						$selected6 = 'selected="selected"';
						break;
					case '2':
						$selected2 = 'selected="selected"';
						break;
					case '3':
						$selected3 = 'selected="selected"';
						break;
					case '4':
						$selected4 = 'selected="selected"';
						break;
					case '6':
						$selected5 = 'selected="selected"';
						break;
				}
			} ?>
			<label for="<?php echo esc_attr($this->get_field_id( 'pics_per_row' )); ?>">Items per row:</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'pics_per_row' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pics_per_row' )); ?>">
				<option value="1" <?php echo esc_attr($selected6); ?>>One item per row</option>
				<option value="2" <?php echo esc_attr($selected2); ?>>Two items per row</option>
				<option value="3" <?php echo esc_attr($selected3); ?>>Three items per row</option>
				<option value="4" <?php echo esc_attr($selected4); ?>>Four items per row</option>
				<option value="6" <?php echo esc_attr($selected5); ?>>Six items per row</option>
			</select>
		</p>
		<p>
		<?php 
			$selected1 = '';
			$selected2 = '';
			if(isset($instance['item_link'])){
				switch ($instance['item_link']) {
					case '1':
						$selected1 = 'selected="selected"';
						break;
					case '2':
						$selected2 = 'selected="selected"';
						break;
				}
			} ?>
			<label for="<?php echo esc_attr($this->get_field_id( 'item_link' )); ?>">Link image to:</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'item_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'item_link' )); ?>">
				<option value="1" <?php echo esc_attr($selected1); ?>>Lightbox</option>
				<option value="2" <?php echo esc_attr($selected2); ?>>Link to instagram</option>
			</select>
		</p>
    <?php }
}
// Add Widget
function malina_widget_instagram_init() {
	register_widget('malina_widget_instagram');
}
add_action('widgets_init', 'malina_widget_instagram_init');
?>