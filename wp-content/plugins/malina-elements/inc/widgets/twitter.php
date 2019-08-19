<?php
//convert links to clickable format
function malina_convert_links($status,$targetBlank=true,$linkMaxLen=250){
			 
	// the target
		$target=$targetBlank ? " target=\"_blank\" " : "";
	 
	// convert link to url
		$status = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $status);
	 
	// convert @ to follow
		$status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);
	 
	// convert # to search
		$status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);
	 
	// return the status
		return $status;
}
//convert dates to readable format	
function malina_relative_time($a) {
//get current timestampt
$b = strtotime("now"); 
//get timestamp when tweet created
$c = strtotime($a);
//get difference
$d = $b - $c;
//calculate different time values
$minute = 60;
$hour = $minute * 60;
$day = $hour * 24;
$week = $day * 7;
	
if(is_numeric($d) && $d > 0) {
	//if less then 3 seconds
	if($d < 3) return __("right now",'malina');
	//if less then minute
	if($d < $minute) return floor($d) . __(" seconds ago",'malina');
	//if less then 2 minutes
	if($d < $minute * 2) return __("about 1 minute ago",'malina');
	//if less then hour
	if($d < $hour) return floor($d / $minute) . __(" minutes ago",'malina');
	//if less then 2 hours
	if($d < $hour * 2) return __("about 1 hour ago",'malina');
	//if less then day
	if($d < $day) return floor($d / $hour) . __(" hours ago",'malina');
	//if more then day, but less then 2 days
	if($d > $day && $d < $day * 2) return __("yesterday",'malina');
	//if less then year
	if($d < $day * 365) return floor($d / $day) . __(" days ago",'malina');
	//else return more than a year
	return __("over a year ago",'malina');
	}
}
function malina_getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
	$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	return $connection;
}
// widget function
	class malina_widget_twitter extends WP_Widget {

		public function __construct() {
			$widget_ops = array('description' => __('Display recent tweets', 'malina') );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'twitter' );
			parent::__construct( 'twitter', __('malina-Twitter', 'malina'), $widget_ops, $control_ops );
			add_action('wp_enqueue_scripts', array($this, 'scripts_setup'));
		}
		public function scripts_setup() {
	        wp_enqueue_script('owl-carousel');
	        wp_enqueue_style('owl-carousel');
		}
		//widget output
		public function widget($args, $instance) {
			$display_time = '';
			extract($args);
			$display_time = esc_attr($instance['display_time']);
			if(!empty($instance['title'])){ $title = apply_filters( 'widget_title', $instance['title'] ); }
			$suf = $this->id;
			echo $before_widget;				
			if ( ! empty( $title ) ){ echo $before_title . $title . $after_title; }
			//check settings and die if not set
			if(empty($instance['consumerkey']) || empty($instance['consumersecret']) || empty($instance['accesstoken']) || empty($instance['accesstokensecret']) || empty($instance['cachetime']) || empty($instance['username'])){
				echo '<strong>Please fill all widget settings!</strong>' . $after_widget;
				return;
			}
			//check if cache needs update
			$tp_twitter_plugin_last_cache_time = get_option('tp_twitter_plugin_last_cache_time'.$suf);
			$tp_twitter_plugin_last_tweetstoshow = get_option('tp_twitter_plugin_last_tweetstoshow'.$suf);
			$diff_tweets = $instance['tweetstoshow'] != $tp_twitter_plugin_last_tweetstoshow ? true : false;
			$diff = time() - $tp_twitter_plugin_last_cache_time;
			$crt = $instance['cachetime'] * 3600;

			$tweets_array = array();
			$custom_script = '<script>jQuery(window).load(function(){
				"use strict";
				var owl = jQuery(\'.widget_twitter.'.$suf.'\').owlCarousel({
			        items:1,
			        autoplay:false,
			        nav:false,
			        navRewind:false,
			        dots:true,
			        autoHeight: true,
			        themeClass: "owl-twitter"
			    });
				owl.on(\'resized.owl.carousel\', function(event) {
				    var $this = jQuery(this);
				    $this.find(\'.owl-height\').css(\'height\', $this.find(\'.owl-item.active\').height() );
				});
			});</script>';
			//	yes, it needs update			
			if($diff >= $crt || empty($tp_twitter_plugin_last_cache_time) || $diff_tweets){
				if(!require_once('twitteroauth.php')){ 
					echo '<strong>Couldn\'t find twitteroauth.php!</strong>' . $after_widget;
					return;
				}
									  
				$connection = malina_getConnectionWithAccessToken($instance['consumerkey'], $instance['consumersecret'], $instance['accesstoken'], $instance['accesstokensecret']);
				$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$instance['username']."&count=".$instance['tweetstoshow']);
								
				if(!empty($tweets->errors)){
					if($tweets->errors[0]->message == 'Invalid or expired token'){
						echo '<strong>'.$tweets->errors[0]->message.'!</strong><br />You\'ll need to regenerate it at https://dev.twitter.com/apps' . $after_widget;
					}else{
						echo '<strong>'.$tweets->errors[0]->message.'</strong>' . $after_widget;
					}
					return;
				}

				for($i = 0;$i <= count($tweets); $i++){
					if(is_array($tweets) && !empty($tweets[$i])){
						$tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
						$tweets_array[$i]['text'] = trim(strip_tags($tweets[$i]->text,'<a>'));			
						$tweets_array[$i]['status_id'] = $tweets[$i]->id_str;			
					}	
				}							

				//save tweets to wp option 		
				update_option('tp_twitter_plugin_tweets'.$suf,serialize($tweets_array));							
				update_option('tp_twitter_plugin_last_cache_time'.$suf,time());
				update_option('tp_twitter_plugin_last_tweetstoshow'.$suf,$instance['tweetstoshow']);

				echo '<!-- twitter cache has been updated! -->';
			}

			$tp_twitter_plugin_tweets = maybe_unserialize(get_option('tp_twitter_plugin_tweets'.$suf));
			if(!empty($tp_twitter_plugin_tweets) && is_array($tp_twitter_plugin_tweets)){
				print '<div class="widget_twitter '.$suf.'">';
				$fctr = '1';
				foreach($tp_twitter_plugin_tweets as $tweet){
					if($display_time != 'false') {
						$newDate = date("g:i a M d", strtotime($tweet['created_at']));
						$tweet_time = __('Tweeted on', 'malina').' '.$newDate;
						$display_time_text = '<br /><span class="date">'.$tweet_time.'</span>';
					} else {
						$display_time_text = '';
					}
					print '<div class="tweet"><a target="_blank" href="http://twitter.com/'.$instance['username'].'/">@'.$instance['username'].'</a><span> '.malina_convert_links($tweet['text']).'</span>'.$display_time_text.'</div>';
					if($fctr == $instance['tweetstoshow']){ break; }
					$fctr++;
				}
				print '</div>';
			}
			echo $custom_script;
			echo $after_widget;
		}
			
		
		//save widget settings 
		public function update($new_instance, $old_instance) {				
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['consumerkey'] = strip_tags( $new_instance['consumerkey'] );
			$instance['consumersecret'] = strip_tags( $new_instance['consumersecret'] );
			$instance['accesstoken'] = strip_tags( $new_instance['accesstoken'] );
			$instance['accesstokensecret'] = strip_tags( $new_instance['accesstokensecret'] );
			$instance['cachetime'] = strip_tags( $new_instance['cachetime'] );
			$instance['username'] = strip_tags( $new_instance['username'] );
			$instance['tweetstoshow'] = strip_tags( $new_instance['tweetstoshow'] );
			$instance['display_time'] = strip_tags( $new_instance['display_time'] );

			if($old_instance['username'] != $new_instance['username']){
				delete_option('tp_twitter_plugin_last_cache_time');
			}
			
			return $instance;
		}
			
			
		//widget settings form	
		public function form($instance) {
			$defaults = array( 'title' => 'Recent tweets', 'consumerkey' => '', 'consumersecret' => '', 'accesstoken' => '', 'accesstokensecret' => '', 'cachetime' => '5', 'username' => '', 'tweetstoshow' => '2', 'display_time'=>'true' );
			$instance = wp_parse_args( (array) $instance, $defaults );
					
			echo '
			<p><label>'.__('Title:','malina').'</label>
				<input type="text" name="'.esc_attr($this->get_field_name( 'title' )).'" id="'.esc_attr($this->get_field_id( 'title' )).'" value="'.esc_attr($instance['title']).'" class="widefat" /></p>
			<p><label>'.__('Consumer Key:','malina').'</label>
				<input type="text" name="'.esc_attr($this->get_field_name( 'consumerkey' )).'" id="'.esc_attr($this->get_field_id( 'consumerkey' )).'" value="'.esc_attr($instance['consumerkey']).'" class="widefat" /></p>
			<p><label>'.__('Consumer Secret:','malina').'</label>
				<input type="text" name="'.esc_attr($this->get_field_name( 'consumersecret' )).'" id="'.esc_attr($this->get_field_id( 'consumersecret' )).'" value="'.esc_attr($instance['consumersecret']).'" class="widefat" /></p>					
			<p><label>'.__('Access Token:','malina').'</label>
				<input type="text" name="'.esc_attr($this->get_field_name( 'accesstoken' )).'" id="'.esc_attr($this->get_field_id( 'accesstoken' )).'" value="'.esc_attr($instance['accesstoken']).'" class="widefat" /></p>									
			<p><label>'.__('Access Token Secret:','malina').'</label>		
				<input type="text" name="'.esc_attr($this->get_field_name( 'accesstokensecret' )).'" id="'.esc_attr($this->get_field_id( 'accesstokensecret' )).'" value="'.esc_attr($instance['accesstokensecret']).'" class="widefat" /></p>														
			<p><label>'.__('Cache Tweets in every:','malina').'</label>
				<input type="text" name="'.esc_attr($this->get_field_name( 'cachetime' )).'" id="'.esc_attr($this->get_field_id( 'cachetime' )).'" value="'.esc_attr($instance['cachetime']).'" class="small-text" /> hours</p>																			
			<p><label>'.__('Twitter Username:','malina').'</label>
				<input type="text" name="'.esc_attr($this->get_field_name( 'username' )).'" id="'.esc_attr($this->get_field_id( 'username' )).'" value="'.esc_attr($instance['username']).'" class="widefat" /></p>																			
			<p><label>'.__('Tweets to display:','malina').'</label>
				<select type="text" name="'.esc_attr($this->get_field_name( 'tweetstoshow' )).'" id="'.esc_attr($this->get_field_id( 'tweetstoshow' )).'">';
				$i = 1;
				for(i; $i <= 10; $i++){
					echo '<option value="'.$i.'"'; if($instance['tweetstoshow'] == $i){ echo ' selected="selected"'; } echo '>'.$i.'</option>';						
				}
				echo '
				</select></p>
			<p><label>'.__('Display time?','malina').'</label>
				<select type="text" name="'.esc_attr($this->get_field_name( 'display_time' )).'" id="'.esc_attr($this->get_field_id( 'display_time' )).'">';
				echo '<option value="true"'; if($instance['display_time'] == 'true'){ echo ' selected="selected"'; } echo '>'.__('Yes','malina').'</option>';
				echo '<option value="false"'; if($instance['display_time'] == 'false'){ echo ' selected="selected"'; } echo '>'.__('No', 'malina').'</option>';						
				echo '
				</select></p>';		
		}
	}
	
	// register	widget
	function malina_register_tp_twitter_widget(){
		register_widget('malina_widget_twitter');
	}
	add_action('widgets_init', 'malina_register_tp_twitter_widget')
	
?>