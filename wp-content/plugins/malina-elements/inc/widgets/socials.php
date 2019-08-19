<?php


class malina_widget_socials extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => __('Display your Socials icons', 'malina-elements') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'socials' );
		parent::__construct( 'socials', __('malina-Socials', 'malina-elements'), $widget_ops, $control_ops );
	}
	
	// Widget Output
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$format = $instance['socials_style'];
		if(!isset($instance['goodreads'])){
			$instance['goodreads'] = '';
		}
		if(!isset($instance['spotify'])){
			$instance['spotify'] = '';
		}
		// ------
		echo ''.$before_widget;
		if ( $title != '' ) echo ''.$before_title . $title . $after_title;
		?>
		<div class="social-icons">
			<ul class="unstyled <?php echo str_replace('+', '_', $format); ?>">
			<?php 
			$output='';
			if($format == 'text'){
				if($instance['vk'] != "") { 
					$output .= '<li class="social-vkontakte"><a href="'.esc_url($instance['vk']).'" class="text-icon" target="_blank" title="'.__( 'Vkontakte', 'malina-elements').'">'.__( 'Vkontakte', 'malina-elements').'</a></li>';
				}
				if($instance['facebook'] != "") { 
					$output .= '<li class="social-facebook"><a href="'.esc_url($instance['facebook']).'" class="text-icon" target="_blank" title="'.__( 'Facebook', 'malina-elements').'">'.__( 'Facebook', 'malina-elements').'</a></li>';
				}
				if($instance['twitter'] != "") { 
					$output .= '<li class="social-twitter"><a href="'.esc_url($instance['twitter']).'" class="text-icon" target="_blank" title="'.__( 'Twitter', 'malina-elements').'">'.__( 'Twitter', 'malina-elements').'</a></li>';
				} 	 
				if($instance['instagram'] != '') { 
					$output .= '<li class="social-instagram"><a href="'.esc_url($instance['instagram']).'" class="text-icon" target="_blank" title="'.__( 'Instagram', 'malina-elements').'">'.__( 'Instagram', 'malina-elements').'</a></li>';
				}
				if($instance['goodreads'] != "") { 
					$output .= '<li class="social-goodreads"><a href="'.esc_url($instance['goodreads']).'" class="text-icon" target="_blank" title="'.__( 'Goodreads', 'malina-elements').'">'.__( 'Goodreads', 'malina-elements').'</a></li>';
				} 
				if($instance['bloglovin'] != "") { 
					$output .= '<li class="social-bloglovin"><a href="'.esc_url($instance['bloglovin']).'" class="text-icon" target="_blank" title="'.__( 'Bloglovin', 'malina-elements').'">'.__( 'Bloglovin', 'malina-elements').'</a></li>';
				}
				if($instance['pinterest'] != "") { 
					$output .= '<li class="social-pinterest"><a href="'.esc_url($instance['pinterest']).'" class="text-icon" target="_blank" title="'.__( 'Pinterest', 'malina-elements').'">'.__( 'Pinterest', 'malina-elements').'</a></li>';
				}
				if($instance['googleplus'] != "") { 
					$output .= '<li class="social-googleplus"><a href="'.esc_url($instance['googleplus']).'" class="text-icon" target="_blank" title="'.__( 'Google plus', 'malina-elements').'">'.__( 'Google plus', 'malina-elements').'</a></li>';
				}
				if($instance['spotify'] != "") { 
					$output .= '<li class="social-spotify"><a href="'.esc_url($instance['spotify']).'" class="text-icon" target="_blank" title="'. esc_html__( 'Spotify', 'malina-elements').'">'. esc_html__( 'Spotify', 'malina-elements').'</a></li>';
				}
				if($instance['forrst'] != "") { 
					$output .= '<li class="social-forrst"><a href="'.esc_url($instance['forrst']).'" class="text-icon" target="_blank" title="'.__( 'Forrst', 'malina-elements').'">'.__( 'Forrst', 'malina-elements').'</a></li>';
				}
				if($instance['dribbble'] != "") { 
					$output .= '<li class="social-dribbble"><a href="'.esc_url($instance['dribbble']).'" class="text-icon" target="_blank" title="'.__( 'Dribbble', 'malina-elements').'">'.__( 'Dribbble', 'malina-elements').'</a></li>';
				}
				if($instance['flickr'] != "") { 
					$output .= '<li class="social-flickr"><a href="'.esc_url($instance['flickr']).'" class="text-icon" target="_blank" title="'.__( 'Flickr', 'malina-elements').'">'.__( 'Flickr', 'malina-elements').'</a></li>';
				}
				if($instance['linkedin'] != "") { 
					$output .= '<li class="social-linkedin"><a href="'.esc_url($instance['linkedin']).'" class="text-icon" target="_blank" title="'.__( 'LinkedIn', 'malina-elements').'">'.__( 'LinkedIn', 'malina-elements').'</a></li>';
				}
				if($instance['skype'] != "") { 
					$output .= '<li class="social-skype"><a href="skype:'.esc_attr($instance['skype']).'" class="text-icon" title="'.__( 'Skype', 'malina-elements').'">'.__( 'Skype', 'malina-elements').'</a></li>';
				}
				if($instance['digg'] != "") { 
					$output .= '<li class="social-digg"><a href="'.esc_url($instance['digg']).'" class="text-icon" target="_blank" title="'.__( 'Digg', 'malina-elements').'">'.__( 'Digg', 'malina-elements').'</a></li>';
				}
				if($instance['vimeo'] != "") { 
					$output .= '<li class="social-vimeo"><a href="'.esc_url($instance['vimeo']).'" class="text-icon" target="_blank" title="'.__( 'Vimeo', 'malina-elements').'">'.__( 'Vimeo', 'malina-elements').'</a></li>';
				}
				if($instance['yahoo'] != "") { 
					$output .= '<li class="social-yahoo"><a href="'.esc_url($instance['yahoo']).'" class="text-icon" target="_blank" title="'.__( 'Yahoo', 'malina-elements').'">'.__( 'Yahoo', 'malina-elements').'</a></li>';
				}
				if($instance['tumblr'] != "") { 
					$output .= '<li class="social-tumblr"><a href="'.esc_url($instance['tumblr']).'" class="text-icon" target="_blank" title="'.__( 'Tumblr', 'malina-elements').'">'.__( 'Tumblr', 'malina-elements').'</a></li>';
				}
				if($instance['youtube'] != "") { 
					$output .= '<li class="social-youtube"><a href="'.esc_url($instance['youtube']).'" class="text-icon" target="_blank" title="'.__( 'YouTube', 'malina-elements').'">'.__( 'YouTube', 'malina-elements').'</a></li>';
				}
				if($instance['deviantart'] != "") { 
					$output .= '<li class="social-deviantart"><a href="'.esc_url($instance['deviantart']).'" class="text-icon" target="_blank" title="'.__( 'DeviantArt', 'malina-elements').'">'.__( 'DeviantArt', 'malina-elements').'</a></li>';
				}
				if($instance['behance'] != "") { 
					$output .= '<li class="social-behance"><a href="'.esc_url($instance['behance']).'" class="text-icon" target="_blank" title="'.__( 'Behance', 'malina-elements').'">'.__( 'Behance', 'malina-elements').'</a></li>';
				}
				if($instance['delicious'] != "") { 
					$output .= '<li class="social-delicious"><a href="'.esc_url($instance['delicious']).'" class="text-icon" target="_blank" title="'.__( 'Delicious', 'malina-elements').'">'.__( 'Delicious', 'malina-elements').'</a></li>';
				}
				$extra_icons = malina_get_custom_social_icon();
				if( !empty($extra_icons) ){
					foreach ($extra_icons as $icon) {
						$name = str_replace(' ', '', $icon['name']);
						$output .= '<li class="social-'.esc_attr(strtolower($name)).'"><a href="'.esc_url($icon['url']).'" class="text-icon" target="_blank" title="'.esc_attr(ucfirst($icon['name'])).'">'.esc_attr(ucfirst($icon['name'])).'</a></li>';
					}
				}
			} elseif ($format == 'icon+text') {
				if($instance['vk'] != "") { 
					$output .= '<li class="social-vkontakte"><a href="'.esc_url($instance['vk']).'" target="_blank" title="'.__( 'Vkontakte', 'malina-elements').'"><i class="fab fa-vk"></i><span>'.__( 'Vkontakte', 'malina-elements').'</span></a></li>';
				}
				if($instance['facebook'] != "") { 
					$output .= '<li class="social-facebook"><a href="'.esc_url($instance['facebook']).'" target="_blank" title="'.__( 'Facebook', 'malina-elements').'"><i class="fab fa-facebook-f"></i><span>'.__( 'Facebook', 'malina-elements').'</span></a></li>';
				}
				if($instance['twitter'] != "") { 
					$output .= '<li class="social-twitter"><a href="'.esc_url($instance['twitter']).'" target="_blank" title="'.__( 'Twitter', 'malina-elements').'"><i class="fab fa-twitter"></i><span>'.__( 'Twitter', 'malina-elements').'</span></a></li>';
				} 	 
				if($instance['instagram'] != '') { 
					$output .= '<li class="social-instagram"><a href="'.esc_url($instance['instagram']).'" target="_blank" title="'.__( 'Instagram', 'malina-elements').'"><i class="fab fa-instagram"></i><span>'.__( 'Instagram', 'malina-elements').'</span></a></li>';
				}
				if($instance['goodreads'] != "") { 
					$output .= '<li class="social-goodreads"><a href="'.esc_url($instance['goodreads']).'" target="_blank" title="'.__( 'Goodreads', 'malina-elements').'"><i class="fab fa-goodreads-g"></i><span>'.__( 'Goodreads', 'malina-elements').'</span></a></li>';
				} 
				if($instance['bloglovin'] != "") { 
					$output .= '<li class="social-bloglovin"><a href="'.esc_url($instance['bloglovin']).'" target="_blank" title="'.__( 'Bloglovin', 'malina-elements').'"><i class="fab fa-plus"></i><span>'.__( 'Bloglovin', 'malina-elements').'</span></a></li>';
				}
				if($instance['pinterest'] != "") { 
					$output .= '<li class="social-pinterest"><a href="'.esc_url($instance['pinterest']).'" target="_blank" title="'.__( 'Pinterest', 'malina-elements').'"><i class="fab fa-pinterest-p"></i><span>'.__( 'Pinterest', 'malina-elements').'</span></a></li>';
				}
				if($instance['googleplus'] != "") { 
					$output .= '<li class="social-googleplus"><a href="'.esc_url($instance['googleplus']).'" target="_blank" title="'.__( 'Google plus', 'malina-elements').'"><i class="fab fa-google-plus"></i><span>'.__( 'Google plus', 'malina-elements').'</span></a></li>';
				}
				if($instance['spotify'] != "") { 
					$output .= '<li class="social-spotify"><a href="'.esc_url($instance['spotify']).'" target="_blank" title="'. esc_html__( 'Spotify', 'malina-elements').'"><i class="fab fa-spotify"></i><span>'. esc_html__( 'Spotify', 'malina-elements').'</span></a></li>';
				}
				if($instance['forrst'] != "") { 
					$output .= '<li class="social-forrst"><a href="'.esc_url($instance['forrst']).'" target="_blank" title="'.__( 'Forrst', 'malina-elements').'"><i class="fa icon-forrst"></i><span>'.__( 'Forrst', 'malina-elements').'</span></a></li>';
				}
				if($instance['dribbble'] != "") { 
					$output .= '<li class="social-dribbble"><a href="'.esc_url($instance['dribbble']).'" target="_blank" title="'.__( 'Dribbble', 'malina-elements').'"><i class="fab fa-dribbble"></i><span>'.__( 'Dribbble', 'malina-elements').'</span></a></li>';
				}
				if($instance['flickr'] != "") { 
					$output .= '<li class="social-flickr"><a href="'.esc_url($instance['flickr']).'" target="_blank" title="'.__( 'Flickr', 'malina-elements').'"><i class="fab fa-flickr"></i><span>'.__( 'Flickr', 'malina-elements').'</span></a></li>';
				}
				if($instance['linkedin'] != "") { 
					$output .= '<li class="social-linkedin"><a href="'.esc_url($instance['linkedin']).'" target="_blank" title="'.__( 'LinkedIn', 'malina-elements').'"><i class="fab fa-linkedin"></i><span>'.__( 'LinkedIn', 'malina-elements').'</span></a></li>';
				}
				if($instance['skype'] != "") { 
					$output .= '<li class="social-skype"><a href="skype:'.esc_attr($instance['skype']).'" title="'.__( 'Skype', 'malina-elements').'"><i class="fab fa-skype"></i><span>'.__( 'Skype', 'malina-elements').'</span></a></li>';
				}
				if($instance['digg'] != "") { 
					$output .= '<li class="social-digg"><a href="'.esc_url($instance['digg']).'" target="_blank" title="'.__( 'Digg', 'malina-elements').'"><i class="fab fa-digg"></i><span>'.__( 'Digg', 'malina-elements').'</span></a></li>';
				}
				if($instance['vimeo'] != "") { 
					$output .= '<li class="social-vimeo"><a href="'.esc_url($instance['vimeo']).'" target="_blank" title="'.__( 'Vimeo', 'malina-elements').'"><i class="fab fa-vimeo"></i><span>'.__( 'Vimeo', 'malina-elements').'</span></a></li>';
				}
				if($instance['yahoo'] != "") { 
					$output .= '<li class="social-yahoo"><a href="'.esc_url($instance['yahoo']).'" target="_blank" title="'.__( 'Yahoo', 'malina-elements').'"><i class="fab fa-yahoo"></i><span>'.__( 'Yahoo', 'malina-elements').'</span></a></li>';
				}
				if($instance['tumblr'] != "") { 
					$output .= '<li class="social-tumblr"><a href="'.esc_url($instance['tumblr']).'" target="_blank" title="'.__( 'Tumblr', 'malina-elements').'"><i class="fab fa-tumblr"></i><span>'.__( 'Tumblr', 'malina-elements').'</span></a></li>';
				}
				if($instance['youtube'] != "") { 
					$output .= '<li class="social-youtube"><a href="'.esc_url($instance['youtube']).'" target="_blank" title="'.__( 'YouTube', 'malina-elements').'"><i class="fab fa-youtube"></i><span>'.__( 'YouTube', 'malina-elements').'</span></a></li>';
				}
				if($instance['deviantart'] != "") { 
					$output .= '<li class="social-deviantart"><a href="'.esc_url($instance['deviantart']).'" target="_blank" title="'.__( 'DeviantArt', 'malina-elements').'"><i class="fab fa-deviantart"></i><span>'.__( 'DeviantArt', 'malina-elements').'</span></a></li>';
				}
				if($instance['behance'] != "") { 
					$output .= '<li class="social-behance"><a href="'.esc_url($instance['behance']).'" target="_blank" title="'.__( 'Behance', 'malina-elements').'"><i class="fab fa-behance"></i><span>'.__( 'Behance', 'malina-elements').'</span></a></li>';
				}
				if($instance['delicious'] != "") { 
					$output .= '<li class="social-delicious"><a href="'.esc_url($instance['delicious']).'" target="_blank" title="'.__( 'Delicious', 'malina-elements').'"><i class="fab fa-delicious"></i><span>'.__( 'Delicious', 'malina-elements').'</span></a></li>';
				}
				$extra_icons = malina_get_custom_social_icon();
				if( !empty($extra_icons) ){
					foreach ($extra_icons as $icon) {
						$name = str_replace(' ', '', $icon['name']);
						$output .= '<li class="social-'.esc_attr(strtolower($name)).'"><a href="'.esc_url($icon['url']).'" target="_blank" title="'.esc_attr(ucfirst($icon['name'])).'"><i class="'.esc_attr($icon['icon']).'"></i><span>'.esc_attr(ucfirst($icon['name'])).'</span></a></li>';
					}
				}
			} else {
				if($instance['vk'] != "") { 
					$output .= '<li class="social-vkontakte"><a href="'.esc_url($instance['vk']).'" target="_blank" title="'.__( 'Vkontakte', 'malina-elements').'"><i class="fab fa-vk"></i></a></li>';
				}
				if($instance['facebook'] != "") { 
					$output .= '<li class="social-facebook"><a href="'.esc_url($instance['facebook']).'" target="_blank" title="'.__( 'Facebook', 'malina-elements').'"><i class="fab fa-facebook-f"></i></a></li>';
				}
				if($instance['twitter'] != "") { 
					$output .= '<li class="social-twitter"><a href="'.esc_url($instance['twitter']).'" target="_blank" title="'.__( 'Twitter', 'malina-elements').'"><i class="fab fa-twitter"></i></a></li>';
				} 	 
				if($instance['instagram'] != '') { 
					$output .= '<li class="social-instagram"><a href="'.esc_url($instance['instagram']).'" target="_blank" title="'.__( 'Instagram', 'malina-elements').'"><i class="fab fa-instagram"></i></a></li>';
				}
				if($instance['goodreads'] != "") { 
					$output .= '<li class="social-goodreads"><a href="'.esc_url($instance['goodreads']).'" target="_blank" title="'.__( 'Goodreads', 'malina-elements').'"><i class="fab fa-goodreads-g"></i></a></li>';
				}
				if($instance['bloglovin'] != "") { 
					$output .= '<li class="social-bloglovin"><a href="'.esc_url($instance['bloglovin']).'" target="_blank" title="'.__( 'Bloglovin', 'malina-elements').'"><i class="fab fa-plus"></i></a></li>';
				}
				if($instance['pinterest'] != "") { 
					$output .= '<li class="social-pinterest"><a href="'.esc_url($instance['pinterest']).'" target="_blank" title="'.__( 'Pinterest', 'malina-elements').'"><i class="fab fa-pinterest-p"></i></a></li>';
				}
				if($instance['googleplus'] != "") { 
					$output .= '<li class="social-googleplus"><a href="'.esc_url($instance['googleplus']).'" target="_blank" title="'.__( 'Google plus', 'malina-elements').'"><i class="fab fa-google-plus"></i></a></li>';
				}
				if($instance['spotify'] != "") { 
					$output .= '<li class="social-spotify"><a href="'.esc_url($instance['spotify']).'" target="_blank" title="'. esc_html__( 'Spotify', 'malina-elements').'"><i class="fab fa-spotify"></i></a></li>';
				}
				if($instance['forrst'] != "") { 
					$output .= '<li class="social-forrst"><a href="'.esc_url($instance['forrst']).'" target="_blank" title="'.__( 'Forrst', 'malina-elements').'"><i class="fa icon-forrst"></i></a></li>';
				}
				if($instance['dribbble'] != "") { 
					$output .= '<li class="social-dribbble"><a href="'.esc_url($instance['dribbble']).'" target="_blank" title="'.__( 'Dribbble', 'malina-elements').'"><i class="fab fa-dribbble"></i></a></li>';
				}
				if($instance['flickr'] != "") { 
					$output .= '<li class="social-flickr"><a href="'.esc_url($instance['flickr']).'" target="_blank" title="'.__( 'Flickr', 'malina-elements').'"><i class="fab fa-flickr"></i></a></li>';
				}
				if($instance['linkedin'] != "") { 
					$output .= '<li class="social-linkedin"><a href="'.esc_url($instance['linkedin']).'" target="_blank" title="'.__( 'LinkedIn', 'malina-elements').'"><i class="fab fa-linkedin"></i></a></li>';
				}
				if($instance['skype'] != "") { 
					$output .= '<li class="social-skype"><a href="skype:'.esc_attr($instance['skype']).'" title="'.__( 'Skype', 'malina-elements').'"><i class="fab fa-skype"></i></a></li>';
				}
				if($instance['digg'] != "") { 
					$output .= '<li class="social-digg"><a href="'.esc_url($instance['digg']).'" target="_blank" title="'.__( 'Digg', 'malina-elements').'"><i class="fab fa-digg"></i></a></li>';
				}
				if($instance['vimeo'] != "") { 
					$output .= '<li class="social-vimeo"><a href="'.esc_url($instance['vimeo']).'" target="_blank" title="'.__( 'Vimeo', 'malina-elements').'"><i class="fab fa-vimeo"></i></a></li>';
				}
				if($instance['yahoo'] != "") { 
					$output .= '<li class="social-yahoo"><a href="'.esc_url($instance['yahoo']).'" target="_blank" title="'.__( 'Yahoo', 'malina-elements').'"><i class="fab fa-yahoo"></i></a></li>';
				}
				if($instance['tumblr'] != "") { 
					$output .= '<li class="social-tumblr"><a href="'.esc_url($instance['tumblr']).'" target="_blank" title="'.__( 'Tumblr', 'malina-elements').'"><i class="fab fa-tumblr"></i></a></li>';
				}
				if($instance['youtube'] != "") { 
					$output .= '<li class="social-youtube"><a href="'.esc_url($instance['youtube']).'" target="_blank" title="'.__( 'YouTube', 'malina-elements').'"><i class="fab fa-youtube"></i></a></li>';
				}
				if($instance['deviantart'] != "") { 
					$output .= '<li class="social-deviantart"><a href="'.esc_url($instance['deviantart']).'" target="_blank" title="'.__( 'DeviantArt', 'malina-elements').'"><i class="fab fa-deviantart"></i></a></li>';
				}
				if($instance['behance'] != "") { 
					$output .= '<li class="social-behance"><a href="'.esc_url($instance['behance']).'" target="_blank" title="'.__( 'Behance', 'malina-elements').'"><i class="fab fa-behance"></i></a></li>';
				}
				if($instance['delicious'] != "") { 
					$output .= '<li class="social-delicious"><a href="'.esc_url($instance['delicious']).'" target="_blank" title="'.__( 'Delicious', 'malina-elements').'"><i class="fab fa-delicious"></i></a></li>';
				}
				$extra_icons = malina_get_custom_social_icon();
				if( !empty($extra_icons) ){
					foreach ($extra_icons as $icon) {
						$name = str_replace(' ', '', $icon['name']);
						$output .= '<li class="social-'.esc_attr(strtolower($name)).'"><a href="'.esc_url($icon['url']).'" target="_blank" title="'.esc_attr(ucfirst($icon['name'])).'"><i class="'.esc_attr($icon['icon']).'"></i></a></li>';
					}
				}
			}
			echo ''.$output;
			?>
			</ul>
		</div>
		<?php
		echo ''.$after_widget;
		// ------
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = $new_instance['title'];
		$instance['socials_style'] = $new_instance['socials_style'];
		$instance['facebook'] = $new_instance['facebook'];
		$instance['twitter'] = $new_instance['twitter'];
		$instance['goodreads'] = $new_instance['goodreads'];
		$instance['spotify'] = $new_instance['spotify'];
		$instance['bloglovin'] = $new_instance['bloglovin'];
		$instance['pinterest'] = $new_instance['pinterest'];
		$instance['instagram'] = $new_instance['instagram'];
		$instance['googleplus'] = $new_instance['googleplus'];
		$instance['forrst'] = $new_instance['forrst'];
		$instance['dribbble'] = $new_instance['dribbble'];
		$instance['flickr'] = $new_instance['flickr'];
		$instance['linkedin'] = $new_instance['linkedin'];
		$instance['skype'] = $new_instance['skype'];
		$instance['digg'] = $new_instance['digg'];
		$instance['vimeo'] = $new_instance['vimeo'];
		$instance['yahoo'] = $new_instance['yahoo'];
		$instance['tumblr'] = $new_instance['tumblr'];
		$instance['youtube'] = $new_instance['youtube'];
		$instance['deviantart'] = $new_instance['deviantart'];
		$instance['behance'] = $new_instance['behance'];
		$instance['vk'] = $new_instance['vk'];
		$instance['delicious'] = $new_instance['delicious'];

		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array(
			'title' => '',
			'socials_style' => 'icons', 
			'facebook'=> '#', 
			'twitter'=>'#',
			'goodreads'=>'',
			'spotify'=>'',
			'bloglovin'=>'', 
			'pinterest'=>'#', 
			'instagram'=>'#', 
			'googleplus'=>'', 
			'forrst'=>'', 
			'dribbble'=>'', 
			'flickr'=>'', 
			'linkedin'=>'', 
			'skype'=>'', 
			'digg'=>'', 
			'vimeo'=>'', 
			'yahoo'=>'', 
			'tumblr'=>'#', 
			'youtube'=>'', 
			'deviantart'=>'',
			'behance'=>'',
			'vk'=>'',
			'delicious'=>''
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
		<?php 
			$selected1 = $selected2 = $selected3 = '';

			if(isset($instance['socials_style'])){
				switch ($instance['socials_style']) {
					case '1':
						$selected1 = 'selected="selected"';
						break;
					case '2':
						$selected2 = 'selected="selected"';
						break;
					case '3':
						$selected3 = 'selected="selected"';
						break;
				}
			} ?>
			<label for="<?php echo esc_attr($this->get_field_id( 'socials_style' )); ?>">Display items as:</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'socials_style' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'socials_style' )); ?>">
				<option value="text" <?php echo esc_attr($selected1); ?>>Text</option>
				<option value="icon+text" <?php echo esc_attr($selected2); ?>>Icon+Text</option>
				<option value="icons" <?php echo esc_attr($selected2); ?>>Icons</option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('facebook')); ?>"><?php _e('Facebook url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook')); ?>" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" value="<?php echo esc_attr($instance['facebook']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('twitter')); ?>"><?php _e('Twitter url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" value="<?php echo esc_attr($instance['twitter']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('bloglovin')); ?>"><?php _e('Bloglovin profile url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('bloglovin')); ?>" name="<?php echo esc_attr($this->get_field_name('bloglovin')); ?>" value="<?php echo esc_attr($instance['bloglovin']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('goodreads')); ?>"><?php _e('Goodreads url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('goodreads')); ?>" name="<?php echo esc_attr($this->get_field_name('goodreads')); ?>" value="<?php echo esc_attr($instance['goodreads']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('pinterest')); ?>"><?php _e('Pinterest url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('pinterest')); ?>" name="<?php echo esc_attr($this->get_field_name('pinterest')); ?>" value="<?php echo esc_attr($instance['pinterest']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('instagram')); ?>"><?php _e('Instagram url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram')); ?>" value="<?php echo esc_attr($instance['instagram']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('googleplus')); ?>"><?php _e('Google plus url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('googleplus')); ?>" name="<?php echo esc_attr($this->get_field_name('googleplus')); ?>" value="<?php echo esc_attr($instance['googleplus']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('spotify')); ?>"><?php _e('Spotify url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('spotify')); ?>" name="<?php echo esc_attr($this->get_field_name('spotify')); ?>" value="<?php echo esc_attr($instance['spotify']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('forrst')); ?>"><?php _e('Forrst url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('forrst')); ?>" name="<?php echo esc_attr($this->get_field_name('forrst')); ?>" value="<?php echo esc_attr($instance['forrst']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('dribbble')); ?>"><?php _e('Dribbble url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('dribbble')); ?>" name="<?php echo esc_attr($this->get_field_name('dribbble')); ?>" value="<?php echo esc_attr($instance['dribbble']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('flickr')); ?>"><?php _e('Flickr url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr')); ?>" name="<?php echo esc_attr($this->get_field_name('flickr')); ?>" value="<?php echo esc_attr($instance['flickr']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('linkedin')); ?>"><?php _e('Linkedin url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('linkedin')); ?>" name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>" value="<?php echo esc_attr($instance['linkedin']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('skype')); ?>"><?php _e('Skype account:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('skype')); ?>" name="<?php echo esc_attr($this->get_field_name('skype')); ?>" value="<?php echo esc_attr($instance['skype']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('digg')); ?>"><?php _e('Digg url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('digg')); ?>" name="<?php echo esc_attr($this->get_field_name('digg')); ?>" value="<?php echo esc_attr($instance['digg']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('vimeo')); ?>"><?php _e('Vimeo url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('vimeo')); ?>" name="<?php echo esc_attr($this->get_field_name('vimeo')); ?>" value="<?php echo esc_attr($instance['vimeo']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('yahoo')); ?>"><?php _e('Yahoo url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('yahoo')); ?>" name="<?php echo esc_attr($this->get_field_name('yahoo')); ?>" value="<?php echo esc_attr($instance['yahoo']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('tumblr')); ?>"><?php _e('Tumblr url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('tumblr')); ?>" name="<?php echo esc_attr($this->get_field_name('tumblr')); ?>" value="<?php echo esc_attr($instance['tumblr']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('youtube')); ?>"><?php _e('Youtube url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('youtube')); ?>" name="<?php echo esc_attr($this->get_field_name('youtube')); ?>" value="<?php echo esc_attr($instance['youtube']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('deviantart')); ?>"><?php _e('Deviantart url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('deviantart')); ?>" name="<?php echo esc_attr($this->get_field_name('deviantart')); ?>" value="<?php echo esc_attr($instance['deviantart']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('behance')); ?>"><?php _e('Behance url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('behance')); ?>" name="<?php echo esc_attr($this->get_field_name('behance')); ?>" value="<?php echo esc_attr($instance['behance']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('vk')); ?>"><?php _e('VKontakte url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('vk')); ?>" name="<?php echo esc_attr($this->get_field_name('vk')); ?>" value="<?php echo esc_attr($instance['vk']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('delicious')); ?>"><?php _e('Delicious url:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('delicious')); ?>" name="<?php echo esc_attr($this->get_field_name('delicious')); ?>" value="<?php echo esc_attr($instance['delicious']); ?>" />
		</p>
    <?php }
}

// Add Widget
function malina_widget_socials_init() {
	register_widget('malina_widget_socials');
}
add_action('widgets_init', 'malina_widget_socials_init');

?>