<?php


class malina_widget_sliderposts extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => esc_html__('Display your posts as slider', 'malina-elements') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sliderposts' );
		parent::__construct( 'sliderposts', esc_html__('malina-Slider Posts', 'malina-elements'), $widget_ops, $control_ops );
		add_action('wp_enqueue_scripts', array($this, 'scripts_setup'));
	}

	public function scripts_setup() {
        wp_enqueue_script('owl-carousel');
        wp_enqueue_style('owl-carousel');
	}
	// Widget Output
	function widget($args, $instance) {
		$title = $number = $posts_ids = '';
		extract($args);
		$title = isset($instance['title']) ? $instance['title'] : '';
		$title = apply_filters('widget_title', $title);
		$number = isset($instance['number']) ? $instance['number'] : '3';
		$post_ids = isset($instance['posts_ids']) ? $instance['posts_ids'] : '';
		$order = isset($instance['order']) ? $instance['order'] : 'DESC';
		$orderby = isset($instance['orderby']) ? $instance['orderby'] : 'date';
		$thumbsize = isset($instance['thumbsize']) ? $instance['thumbsize'] : 'medium';
		$loop = '';

		if(isset($instance['loop']) && $instance['loop'] ){
			$loop = 'true';
		}
		
		if($post_ids != ''){
			$post_ids = str_replace(' ', '', $post_ids);
			$post_ids = explode(',', $post_ids);
		} else {
			$post_ids = array();
		}
		$rand_id = $this->id ? $this->id : 'sliderposts'.rand(1, 9999);
		echo $before_widget;

		if($title != '') {
			echo $before_title . $title . $after_title;
		}
		if( $loop == '' ){
			$loop = 'false';
		}
		$custom_script = 'jQuery(window).load(function(){
				"use strict";
				var owl = jQuery("#block-'.esc_attr($rand_id).'").owlCarousel(
			    {
			        items: 1,
			        margin: 0,
			        dots: false,
			        nav: true,
			        navText: [\'<i class="la la-angle-left"></i>\',\'<i class="la la-angle-right"></i>\'],
			        autoplay: false,
			        responsiveClass:true,
			        loop: '.$loop.',
			        smartSpeed: 450,
			        autoHeight: true,
			        themeClass: "owl-widget-sliderposts",
			        responsive:{
			            0:{
			                items:1,
			            },
			            1199:{
			                items:1
			            }
			        }
			    });
				owl.on(\'resized.owl.carousel\', function(event) {
				    var $this = jQuery(this);
				    $this.find(\'.owl-height\').css(\'height\', $this.find(\'.owl-item.active\').height() );
				});
			});';
			wp_add_inline_script('owl-carousel', $custom_script);
		?>
		<div id="block-<?php echo esc_attr($rand_id); ?>" class="sliderposts">
			<?php
			
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $number,
				'order' => $order,
				'orderby' => $orderby,
				'ignore_sticky_posts' => true,
				'meta_query' => array(
			        array(
			         'key' => '_thumbnail_id',
			         'compare' => 'EXISTS'
			        ),
			    )
			);
			if($post_ids != ''){
				$args['post__in'] = $post_ids;
			}
			query_posts( $args );
			if(have_posts()){
				while ( have_posts() ){
					the_post();
					$out = '';
					global $post;
			        echo '<div class="slider-item">';
						if( has_post_thumbnail() ) {
							echo '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail($post->ID, $thumbsize).'</a></figure>';
							echo '<h3><a href="'.esc_url(get_the_permalink()).'">'.esc_attr(get_the_title()).'</a></h3>';
							
						}
					echo '</div>';
		        }		
			?>
			<?php } wp_reset_query(); ?>
			
		</div>
		<?php
			echo $after_widget;
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = $new_instance['number'];
		$instance['posts_ids'] = $new_instance['posts_ids'];
		$instance['order_by'] = $new_instance['order_by'];
		$instance['order'] = $new_instance['order'];
		$instance['loop'] = $new_instance['loop'];
		$instance['thumbsize'] = $new_instance['thumbsize'];
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => '', 'number' => 3, 'posts_ids'=> '', 'loop'=>'', 'orderby' => 'date', 'order'=>'DESC', 'thumbsize'=>'medium');
		$instance = wp_parse_args((array) $instance, $defaults); 
		$loop = isset( $instance['loop'] ) ? (bool) $instance['loop'] : false;
		$imageSizes = get_intermediate_image_sizes();
		$imageSizes[]= 'full';
		$imageSizes = array_combine($imageSizes, $imageSizes);
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e("Title",'malina-elements'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e("Number of items to show",'malina-elements'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('posts_ids')); ?>"><?php esc_html_e("Posts IDs",'malina-elements'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('posts_ids')); ?>" name="<?php echo esc_attr($this->get_field_name('posts_ids')); ?>" value="<?php echo esc_attr($instance['posts_ids']); ?>" />
			<span class="description"><?php esc_html_e("Enter posts IDs to display only those records (Note: separate values by commas (,)).",'malina-elements'); ?></span>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('thumbsize')); ?>"><?php _e('Select image size:','malina-elements'); ?></label>
			<?php
            if(isset($instance['thumbsize'])) $thumbsize = $instance['thumbsize'];
            ?>
            <select class="widefat" id="<?php echo $this->get_field_id( 'thumbsize' ); ?>" name="<?php echo $this->get_field_name( 'thumbsize' ); ?>">
                <?php
                $op = '<option value="%s"%s>%s</option>';
                foreach ($imageSizes as $key=>$value ) {
                    if ($thumbsize === $key) {
                        printf($op, $key, ' selected="selected"', $value);
                    } else {
                        printf($op, $key, '', $value);
                    }
                }
                ?>
            </select>
		</p>
		<p>
			<?php
			switch ($instance['order']) {
				case 'ASC':
					$selected1 = 'selected="selected"';
					$selected2 = '';
					break;
				case 'DESC':
					$selected2 = 'selected="selected"';
					$selected1 = '';
					break;
				default:
					$selected1 = '';
					$selected2 = '';
					break;
			}
			?>
			<label for="<?php echo esc_attr($this->get_field_id( 'order' )); ?>"><?php esc_html_e("Order",'malina-elements'); ?>:</label>
			<select id="<?php echo esc_attr($this->get_field_id( 'order' )); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name( 'order' )); ?>">
			  <option value="ASC" <?php echo esc_attr($selected1); ?>><?php esc_html_e("Lowest to highest values",'malina-elements'); ?></option>
			  <option value="DESC" <?php echo esc_attr($selected2); ?>><?php esc_html_e("Highest to lowest values",'malina-elements'); ?></option>
			</select>
		</p>

		<p>
			<?php
			switch ($instance['order_by']) {
				case 'title':
					$selected1 = 'selected="selected"';
					break;
				case 'ID':
					$selected2 = 'selected="selected"';
					break;
				case 'date':
					$selected3 = 'selected="selected"';
					break;
				case 'modified':
					$selected4 = 'selected="selected"';
					break;
				case 'comment_count':
					$selected5 = 'selected="selected"';
					break;
				case 'post__in':
					$selected6 = 'selected="selected"';
					break;
				default:
					$selected1 = '';
					$selected2 = '';
					$selected3 = '';
					$selected4 = '';
					$selected5 = '';
					$selected6 = '';
					break;
			}
			?>
			<label for="<?php echo esc_attr($this->get_field_id( 'order_by' )); ?>"><?php esc_html_e("Order by",'malina-elements'); ?>:</label>
			<select id="<?php echo esc_attr($this->get_field_id( 'order_by' )); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name( 'order_by' )); ?>">
			  <option value="title" <?php echo esc_attr($selected1); ?>><?php esc_html_e("Title",'malina-elements'); ?></option>
			  <option value="ID" <?php echo esc_attr($selected2); ?>><?php esc_html_e("Post's ID",'malina-elements'); ?></option>
			  <option value="date" <?php echo esc_attr($selected3); ?>><?php esc_html_e("Date",'malina-elements'); ?></option>
			  <option value="modified" <?php echo esc_attr($selected4); ?>><?php esc_html_e("Modified date",'malina-elements'); ?></option>
			  <option value="comment_count" <?php echo esc_attr($selected5); ?>><?php esc_html_e("Popular",'malina-elements'); ?></option>
			  <option value="post__in" <?php echo esc_attr($selected6); ?>><?php esc_html_e("Preserve post ID order",'malina-elements'); ?></option>
			</select>
		</p>
		<p>
			<input type="checkbox" class="checkbox"<?php checked( $loop ); ?> id="<?php echo $this->get_field_id('loop'); ?>" name="<?php echo $this->get_field_name('loop'); ?>"<?php checked( $loop ); ?> />
			<label for="<?php echo $this->get_field_id('loop'); ?>"><?php _e( 'Loop items' ); ?></label></p>
		</p>
	<?php
	}
}

// Add Widget
function malina_widget_sliderposts_init() {
	register_widget('malina_widget_sliderposts');
}
add_action('widgets_init', 'malina_widget_sliderposts_init');

?>