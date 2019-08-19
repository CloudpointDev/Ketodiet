<?php

$timebeforerevote = 1;
add_action('wp_enqueue_scripts', 'post_like_scripts');

add_action('wp_ajax_nopriv_post-like', 'post_like');
add_action('wp_ajax_post-like', 'post_like');


function post_like_scripts(){
	wp_register_script('like_post', trailingslashit( MALINA_PLUGIN_URL ).'inc/post-like/post-like.js', array('jquery'), '1.0', TRUE );
	wp_localize_script('like_post', 'malina_like_post', array(
		'url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('ajax-nonce')
	));
}

function post_like()
{
	wp_enqueue_script('like_post');
	$nonce = $_POST['nonce'];
 
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Busted!');
		
	if(isset($_POST['post_like']))
	{
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			//check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		$post_id = $_POST['post_id'];
		$meta_IP = array();
		$meta_IP = get_post_meta($post_id, "voted_IP");

		$voted_IP = $meta_IP[0];
		
		if(!is_array($voted_IP))
			$voted_IP = array();
		
		$meta_count = get_post_meta($post_id, "votes_count", true);

		if(!hasAlreadyVoted($post_id)){
			$voted_IP[$ip] = time();

			update_post_meta($post_id, "voted_IP", $voted_IP);
			update_post_meta($post_id, "votes_count", ++$meta_count);
			
			echo $meta_count;
		}
		else
			echo esc_html__("already",'malina-elements');
	}
	exit;
}

function hasAlreadyVoted($post_id)
{
	global $timebeforerevote;

	$meta_IP = get_post_meta($post_id, "voted_IP");
	
	if(isset($meta_IP[0])) {$voted_IP = $meta_IP[0];} else {$voted_IP=0;}
	if(!is_array($voted_IP))
		$voted_IP = array();
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		//check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	if (!isset ($_SERVER['REMOTE_ADDR'])) {
        return false;
    }
	if(in_array($ip, array_keys($voted_IP)))
	{
		if ( isset($voted_IP[$ip]) ) {
			$time = $voted_IP[$ip];
			$now = time();
			$tmp = $now - $time;
			if( $tmp > 3600 ){
				return false;
			}
		}
		return true;
	}
	
	return false;
}
if( !function_exists('getPostLikeLink') ){
	function getPostLikeLink($post_id)
	{
		wp_enqueue_script('like_post');
		$vote_count = get_post_meta($post_id, "votes_count", true);
		$output = '<div class="item-like">';
		if(hasAlreadyVoted($post_id))
			$output .= '<span title="'.esc_attr__('Already liked', 'malina-elements').'" class="qtip like alreadyvoted"><i class="la la-heart"></i></span>';
		else{
			$output .= '<a href="#" data-post_id="'.$post_id.'"><span  title="'.esc_attr__('I like this', 'malina-elements').'" class="qtip like"><i class="la la-heart-o"></i></span></a>';
		}
			
		if($vote_count > 1) {
			$output .= '<span class="count">'.$vote_count.'</span> '.esc_html__('Likes', 'malina-elements');
		} else if($vote_count == 1) {
			$output .= '<span class="count">'.$vote_count.'</span> '.esc_html__('Like', 'malina-elements');
		} else {
			$output .= '<span class="count">0</span> '.esc_html__('Like', 'malina-elements');
		}
		$output .='</div>';
		
		return $output;
	}
}
if( !function_exists('getPostLikeCount') ){
	function getPostLikeCount($post_id){
		wp_enqueue_script('like_post');
		$vote_count = get_post_meta($post_id, "votes_count", true);
		$output = '<div class="item-like">';
		if(hasAlreadyVoted($post_id))
			$output .= ' <span title="'.esc_attr__('Already liked', 'malina-elements').'" class="qtip like alreadyvoted"><i class="la la-heart"></i></span>';
		else
			$output .= '<a href="#" data-post_id="'.$post_id.'">
						<span  title="'.esc_attr__('I like this', 'malina-elements').'" class="qtip like"><i class="la la-heart-o"></i></span>
					</a>';

		if($vote_count > 1) {
			$output .= '<span class="count">'.$vote_count.'</span> '.esc_html__('Likes', 'malina-elements');
		} else if($vote_count == 1) {
			$output .= '<span class="count">'.$vote_count.'</span> '.esc_html__('Like', 'malina-elements');
		} else {
			$output .= '<span class="count">0</span> '.esc_html__('Like', 'malina-elements');
		}
		$output .='</div>';
		
		return $output;
	}
}